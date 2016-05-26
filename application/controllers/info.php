<?php

class Info extends MY_Controller
{
    var $Description = "Information Portal";
    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('inflector');

        if(!$this->isLoggedIn() && $this->session->userdata('MSISDN') )
            $this->session->set_userdata('LOGGED_IN', $this->session->userdata('MSISDN') );
    }

    private function homepage_data()
    {
        if( !$this->Country )
            show_error("Splash cannot be shown if country is not specified!");

        $data = array();
        //$data['jokes'] = $this->Product_model->GetVideos( $this->Product_model->getItemsPerPage() );
        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $data['isLoggedIn']= $this->isLoggedIn();

        $data['categories'] = $this->Product_model->GetCategories();

        return $data;
    }

    public function index()
    {
        $this->number_detection();

        $data = $this->homepage_data();

        //$content = "content";

        //$data['Title'] = $content;
        //$data['Pagination'] = "";
        //$data['Items'] = array();

        $this->Display( __FUNCTION__, $data);
    }

    function item()
    {
        $categ = $this->uri->segment(5);
        return $this->show_item($categ);
    }

    public function login()
    {
        $data = $this->homepage_data();
        $this->Display( __FUNCTION__, $data);
    }

    public function login2()
    {
        $data = $this->homepage_data();
        $this->Display( __FUNCTION__, $data);
    }

    public function error()
    {
        $data = $this->homepage_data();
        $this->Display( __FUNCTION__, $data);
    }

    private function isLoggedIn()
    {
        return $this->session->userdata('LOGGED_IN');
    }

    private function allow_signup()
    {
        return ($this->Product_model->getSubscriptionFlow() != SUBSCRIBE_FLOW_NONE &&
            $this->Product_model->getSubscriptionFlow() != SUBSCRIBE_FLOW_HIDDEN);
    }

    private function allow_login()
    {
        return ($this->Product_model->getLoginFlow() != LOGIN_FLOW_NO_LOGIN);
    }

    private function show_item($categ, $note=null, $error=null)
    {

        $data = $this->homepage_data();

        $item = $this->Product_model->GetItem($categ);
        #$this->Product_model->IncreaseDisplayedCount($item['dbID']);

        if(!$item)
            return $this->sorry("The item you are searching for no longer exists!");

        if( $this->agent->is_mobile() )
        {
            $img_width	 = '40%';
        }
        else
        {
            $img_width	 = 350;
        }

        $data['Item_Content'] = $item['content'];
        $data['Item_Category'] = $item['category'];

        $sessionID = $this->session->userdata('session_id');


        if( $this->isLoggedIn() && $this->allow_login() )
        {
        }

        $data['Category'] = $item['category'];

        if($note)
            $data['Item_Note'] = "<b style=\"color:#FFF; font-weigh:bold;\">{$note}</b>";

        if(!isset($data['Item_Download']))
            $data['Item_Download'] = "Thank you";

        $this->Display( 'item', $data);
    }

    public function do_signup()
    {
        if( $_SERVER['REQUEST_METHOD'] == "POST")
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric');

            if( $this->Product_model->getLoginFlow() == LOGIN_FLOW_GOT_PIN )
                $this->form_validation->set_rules('pin', 'Custom PIN Number', 'required|numeric|min_length[4]|max_length[4]');


            if( $this->siteconfig->getTermsCheckbox($this->Product) )
                $this->form_validation->set_rules('terms', 'Terms & Conditions', 'required');


            if ($this->form_validation->run() == FALSE)
            {

                if( $this->agent->is_mobile() || strstr($this->agent->referrer(), "/info/index/") == true )
                    return $this->sorry( validation_errors('<p>', '</p>'));
                else
                    return $this->sorry_iframe(validation_errors('<p>', '</p>'));

            }
            else
            {
                $this->realStartSubscription( $this->input->post('mobile'), $this->input->post('pin') );
                return;
            }
        }

        if( $this->agent->is_mobile() )
            redirect($this->DocumentRoot."/info/signup_form/". $this->CountryKey ."/". $this->Keyword);
        else
            redirect($this->DocumentRoot."/info/signup/". $this->CountryKey ."/". $this->Keyword);
    }

    public function do_login(){
        if( $_SERVER['REQUEST_METHOD'] == "POST")
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric');

            if ($this->form_validation->run() == FALSE)
            {

                if( $this->agent->is_mobile() || strstr($this->agent->referrer(), "/info/index/") == true )
                    return $this->sorry( validation_errors('<p>', '</p>'));
                else
                    return $this->sorry_iframe(validation_errors('<p>', '</p>'));

            }
            else
            {
                $this->realStartLogin( $this->input->post('mobile'), $this->input->post('pin') );
                return;
            }

        }

            redirect($this->DocumentRoot."/info/login/". $this->CountryKey ."/". $this->Keyword);

    }

    protected function realStartSubscription($mobile, $pin)
    {

        $network = $this->input->post('network');

        $result = parent::realStartSubscription($mobile, $network);

        if( $result !== true )
        {
            $this->session->unset_userdata('MSISDN');
            $this->session->unset_userdata('LOGGED_IN');

            return $this->sorry($result);
        }


        # check if user already exists!
        #$this->Product_model->CreateUser($mobile, $pin);

        $this->postSubscription();
    }

    public function realStartLogin($mobile, $pin){

        // TODO: WHAT THE FUKKKK>>>????? Hard coded to south africa (27)???

        $mobileFix = "27".substr($mobile, 1);
        $credits = $this->Product_model->getSubs($mobileFix);
        if($credits < 1 ){
            $this->realStartSubscription($mobile,$pin);
            redirect($this->DocumentRoot."/info/error/". $this->CountryKey ."/". $this->Keyword);
        }
        else
        $this->session->set_userdata('MSISDN', $mobile);
        $this->session->set_userdata('MSISDN_DETECTION_PERFORMED', 'FAKED');
        redirect($this->DocumentRoot."/info/index/". $this->CountryKey ."/". $this->Keyword);
    }
}