<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 16/09/13
 * Time: 4:02 PM
 * To change this template use File | Settings | File Templates.
 */

class Luckyday extends My_Controller
{

    function __construct()
    {
        parent::__construct();

        if( !$this->Country )
            show_error("Lucky Day cannot be shown if country is not specified!");

        $this->setDescription();
    }

    private function setDescription()
    {
        $flow = $this->Product_model->getSubscriptionFlow();
        $freq = $this->Product_model->getMessageFrequency();

        switch($flow)
        {
            case SUBSCRIBE_FLOW_PIN:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME% Quiz where you can play the quiz to win great prizes. You will receive questions {$freq} and each correct answer increases your chances to win.";
                break;

            case SUBSCRIBE_FLOW_DOI:
                $this->Description = "This is a subscription service, by inserting your mobile number and sending in a text message, you are subscribing to the %SITE_NAME% Quiz where you can play the quiz to win great prizes. You will receive questions {$freq} and each correct answer increases your chances to win.";
                break;

            case SUBSCRIBE_THROUGH_WAP_OPTIN:
                $this->Description = "This is a subscription service, by inserting your mobile number and sending in a text message, you are subscribing to the %SITE_NAME% Quiz where you can play the quiz to win great prizes. You will receive questions {$freq} and each correct answer increases your chances to win.";
                break;
        }
    }

    public function index()
    {
        $this->number_detection();

        $data = array();

        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);
        $data['SubscriptionFlow'] = $this->Product_model->getSubscriptionFlow();
        $data['WapOptinURL'] = $this->Product_model->Wap_Optin_URL;
        $body_image = $this->Product_model->Body_Image;

        switch($body_image)
        {
            case "airtime":
                $data['ImageURL'] = "main_at.jpg";
                break;
            case "blackberry":
                $data['ImageURL'] = "main_bb.jpg";
                break;
            case "iphone":
                $data['ImageURL'] = "main_iphone.jpg";
                break;
            case "newipad":
                $data['ImageURL'] = "main_ipad.jpg";
                break;
            case "macbook":
                $data['ImageURL'] = "main_mac.jpg";
                break;
        }
        $this->_index($data);
    }

    public function mnp()
    {
        $url = file_get_contents("http://www.mobivate.com/smsgw/integrat.php?KEY=MAA0100000000085&HOST={$_SERVER['HTTP_HOST']}/airtime&HEADER=/images/header.jpg&SERVICE=". urlencode($this->Host->sitename) ."&DONT_REDIRECT");
        header("Location: {$url}");
    }

    function getError($error=NULL)
    {
        echo $error;
        echo '<br><a href="javascript:history.go(-1)">Go Back</a>';
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


}