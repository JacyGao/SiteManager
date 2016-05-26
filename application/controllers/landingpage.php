<?php
/**
 * Created by John Huseinovic
 * Date: 6/06/13
 * Time: 4:00 PM
 */
require_once( dirname(__FILE__) ."/portal.php");

class LandingPage extends Portal
{

    var $Description = "Landing page";

    function __construct()
    {
        parent::__construct();

        if( !$this->Country )
            show_error("This page cannot be shown if country is not specified!");

        $this->setDescription();
    }

    private function setDescription()
    {
        $flow = $this->Product_model->getSubscriptionFlow();
        $freq =  $this->Product_model->getMessageFrequency();

        switch($flow)
        {
            case SUBSCRIBE_FLOW_PIN:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME%, you will receive text messages {$freq}.";
                break;

            case SUBSCRIBE_FLOW_DOI:
                $this->Description = "This is a subscription service, by inserting your mobile number and sending in a text message, you are subscribing to the %SITE_NAME%, you will receive text messages {$freq}.";
                break;

        }
    }

    protected function homepage_data()
    {
        $data = array();
        $data['site_link'] = "/portal/index/".$this->CountryKey."/";

        $data['Subscription_Flow'] = $this->Product_model->getSubscriptionFlow();
        $data['Signup_Flow'] = $this->Product_model->getSubscriptionFlow();

        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $data['SelectNetwork'] = false;
        list($first, $mid, $last) = explode(".", $_SERVER['HTTP_HOST']);
        $data['Brand']= $mid;

        if($this->Country->selectnetwork)
        {
            $query = $this->db->get_where('networks', array('country'=>$this->Country->iso));
            $networks = array();
            foreach($query->result() as $net)
            {
                $networks[] = "<option value=\"{$net->netkey}\">{$net->netlabel}</option>";
            }

            $data['SelectNetwork'] = "<select id=\"networkselect\" name=\"network\"><option selected value = ''>-- Select Your Network --</option>". implode("", $networks) ."</select>\n";


        }
        $url = $_SERVER["REQUEST_URI"];
        $tokens = explode('/', $url);
        $page=$tokens[3];
        $rest = substr($page, 0, 2);
        $page = $rest;
        list($first, $mid, $last) = explode(".", $_SERVER['HTTP_HOST']);

        $tc = $this->Product_model->getShortTerms($this->Product, $this->Description);
        $data['Terms_And_Conditions'] = str_replace('%KEYWORD%', strtoupper($this->Keyword), $tc);

        // TODO: Move this crap to the UI. Store text in Database, pull on demand!!!
        if  ($page == "sa")
            $data['text'] = "For your chance to win an iPad mini and Subscribe to get the best Games and Music for R5/day on your phone";
        else
            $data['text'] = "For your chance to Subscribe to get the best content on your phone";


        return $data;
    }

    function index()
    {
        $template = $this->uri->segment(5);
        // template = file name in views

        $data = $this->homepage_data();

        //here I was trying to get the data filled from the admin panel
        //$data['Inmobi_Tracking_Code'] = $this->Product_model->getInmobiTrackingCode();

        $this->Display( $template, $data );




    }

    public function do_signup()
    {

        if( $_SERVER['REQUEST_METHOD'] == "POST")
        {

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules('mobile', 'Mobile Number','Mobile', 'required|numeric');

            if( $this->Product_model->getLoginFlow() == LOGIN_FLOW_GOT_PIN )
                $this->form_validation->set_rules('pin', 'Custom PIN Number', 'required|numeric|min_length[4]|max_length[4]');


            if( $this->siteconfig->getTermsCheckbox($this->Product) )
                $this->form_validation->set_rules('terms', 'Terms & Conditions', 'required');


            if ($this->form_validation->run() == FALSE)
            {

                if( $this->agent->is_mobile() || strstr($this->agent->referrer(), "/portal/index/") == true )
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

            redirect($this->DocumentRoot."/{ProductPath}/signup/". $this->CountryKey ."/". $this->Keyword);
    }

    function validate()
    {
        $mobile = $this->input->post('mobile');

        if(!$mobile && $this->session->userdata('MSISDN')) $mobile = $this->session->userdata('MSISDN');

        $this->startSubscription($mobile);
    }
}// Landingpage Class
