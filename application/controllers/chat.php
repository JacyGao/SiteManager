<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 1/11/13
 * Time: 2:19 PM
 * To change this template use File | Settings | File Templates.
 */

class Chat extends MY_Controller
{
    public function __construct($country_required=true)
    {
        parent::__construct();

        if( !$this->Country )
            show_error("Chat page cannot be shown if country is not specified!");

        $this->setDescription();

    }

    private function setDescription()
    {
        $flow = $this->Product_model->getSubscriptionFlow();
        $freq = $this->Product_model->getMessageFrequency();

        switch($flow)
        {
            case SUBSCRIBE_FLOW_PIN:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME%. You will be billed {$freq}";
                break;

            case SUBSCRIBE_FLOW_DOI:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME%. You will be billed {$freq}";
                break;

            case SUBSCRIBE_FLOW_MO_MSG:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME%. You will be billed {$freq}";
                break;

            case SUBSCRIBE_FLOW_MO:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME%. You will be billed {$freq}";
                break;

            case SUBSCRIBE_FLOW_CLICK:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME%. You will be billed {$freq}";
                break;
        }
    }

    protected function homepage_data()
    {
        $data = array();
        $data['Logo'] = $this->Product_model->Logo_Image;
        $data['IsLoggedIn'] = $this->isLoggedIn();

        if( $this->isLoggedIn() )
        {
            $data['Username'] = $this->session->userdata('LOGGED_IN');
        }

        return $data;
    }

    public function index()
    {
        $data = $this->homepage_data();

        $profiles = $this->Product_model->getProfiles();

        $data['Profiles'] = $profiles;

        $this->_index($data);
    }

    public function profile()
    {
        $profileID = $this->uri->segment(5);
        $profileData = $this->Product_model->getProfile($profileID);

        $data = $this->homepage_data();
        $data['ID'] = $profileData['ID'];
        $data['Name'] = $profileData['name'];
        $data['Gender'] = $profileData['gender'];
        $data['Age'] = $profileData['age'];
        $data['City'] = $profileData['city'];
        $data['State'] = $profileData['state'];
        $data['Country'] = $profileData['country'];
        $data['Imageurl'] = $profileData['imageurl'];

        $data['Profile'] = $profileData['name'].".jpg";

        $this->Display('profile', $data);
    }

    public function search()
    {
        $gender = $this->input->post('gender');
        $seeking = $this->input->post('seeking');
        $country = $this->input->post('country');
        $city = $this->input->post('city');
        $age_from = $this->input->post('age_from');
        $age_to = $this->input->post('age_to');

        $results = $this->Product_model->search($seeking,$country,$city,$age_from,$age_to);

        $data = $this->homepage_data();
        $data['Results'] = $results;

        $this->Display('search', $data);
    }

    public function about()
    {
        $data = $this->homepage_data();
        $this->Display('about', $data);
    }

    public function member()
    {
        $data = $this->homepage_data();
        $this->Display('member', $data);
    }

    function validate()
    {
        if( strlen($this->input->post('mobile')) < 9 || strlen($this->input->post('mobile')) > 11 )
            return $this->getError( "You must enter your correct mobile number! Please go back and try again!" );
        if (!is_numeric($this->input->post('mobile')))
            return $this->getError( "You must enter your correct mobile number! Please go back and try again!" );

        $mobile = $this->input->post('mobile');

        if(!$mobile && $this->session->userdata('MSISDN')) $mobile = $this->session->userdata('MSISDN');

        $this->startSubscription($mobile);
    }

    function do_signup()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $this->Product_model->addMember($username, $password, $email);

        $this->session->set_userdata('LOGGED_IN', $username );

        header('Location: '.$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword.'/');
    }

    function do_login()
    {
        $username = $this->input->post('user_login');
        $password = $this->input->post('user_password');

        if($this->Product_model->getMember($username, $password) == true)
        {
            $this->session->set_userdata('LOGGED_IN', $username );
        }
        else
        {
            exit("Incorrect username/password!");
        }
        header('Location: '.$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword.'/');
    }

    function sign_out()
    {
        $this->session->sess_destroy();

        header('Location: '.$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword.'/');
    }

    protected  function isLoggedIn()
    {
        return $this->session->userdata('LOGGED_IN');
    }

    function reset_password()
    {
        $username = $this->input->post('username');
    }

    public function doi()
    {
        $this->load->model('Pixel_model', 'Pixels');
        $this->Pixels->init( $this->siteconfig , $this->Keyword );

        $data = $this->homepage_data();
        $data['pixels'] = $this->Pixels->get(PIXELTYPE_HTML);

        $this->Display( __FUNCTION__, $data);
    }
}