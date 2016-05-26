<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 24/09/13
 * Time: 11:52 AM
 * To change this template use File | Settings | File Templates.
 */

class Landingpage1 extends My_Controller
{
    function __construct()
    {
        parent::__construct();

        if( !$this->Country )
            show_error("Landing page cannot be shown if country is not specified!");

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
            case SUBSCRIBE_FLOW_VIA_WAP:
                $this->Description ="Send user a URL via SMS. Once clicked, user will be validated and subscribed using the keyword from Campaign URL";
                break;
        }
    }

    public function index()
    {
        $this->load->library('usertracking');
        $this->usertracking->track_this();

        $data = array();

        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);
       
        $show_logo = $this->Product_model->Show_Logo;
        $show_sms_to_action = $this->Product_model->Show_SMS_To_Action;
        $text_above_image = $this->Product_model->Text_Above_Image;
        $flow = $this->Product_model->getSubscriptionFlow();
        $submit_button_image = $this->Product_model->Submit_Button_Image;
        $pricing_note = $this->Product_model->Pricing_Note;
        $background_colour = $this->Product_model->Background_Colour;
        $body_image_width_web = $this->Product_model->Body_Image_Width_Web;
        $body_image_width_mobile = $this->Product_model->Body_Image_Width_Mobile;
        $logo_width_web = $this->Product_model->Logo_Width_Web;
        $logo_width_mobile = $this->Product_model->Logo_Width_Mobile;
        $auto_catch_mobile = $this->Product_model->Auto_Catch_Mobile;

        if($auto_catch_mobile == 1)
        {
            if(isset($_GET['msisdn']))
            {
                $msisdn = $_GET['msisdn'];
                $data['msisdn'] = $msisdn;
            }
            else{
                exit('msisdn has not been detected!');
            }
        }        
        $data['ShowLogo'] = $show_logo;
        $data['ShowSMSToAction'] = $show_sms_to_action;
        $data['TextAboveImage'] = $text_above_image;
        $data['SubmitButtonImage'] = $submit_button_image;
        $data['PricingNote'] = $pricing_note;
        $data['BackgroundColour'] = $background_colour;
        $data['BodyImageWidthWeb'] = $body_image_width_web;
        $data['BodyImageWidthMobile'] = $body_image_width_mobile;
        $data['LogoWidthWeb'] = $logo_width_web;
        $data['LogoWidthMobile'] = $logo_width_mobile;
        $data['autoCatchMobile'] = $auto_catch_mobile;

        switch($flow)
        {
            case SUBSCRIBE_FLOW_PIN:
                $data["SubscriptionFlow"] = "SUBSCRIBE_FLOW_PIN";
                break;

            case SUBSCRIBE_FLOW_DOI:
                $data["SubscriptionFlow"] = "SUBSCRIBE_FLOW_DOI";
                break;

            case SUBSCRIBE_FLOW_MO_MSG:
                $data["SubscriptionFlow"] = "SUBSCRIBE_FLOW_MO_MSG";
                break;

            case SUBSCRIBE_FLOW_MO:
                $data["SubscriptionFlow"] = "SUBSCRIBE_FLOW_MO";
                break;

            case SUBSCRIBE_FLOW_CLICK:
                $data["SubscriptionFlow"] = "SUBSCRIBE_FLOW_CLICK";
                $shortcode = $this->siteconfig->getShortcode();
                $keyword = $this->Keyword;
                $data["SMSlink"] = "sms:{$shortcode}?body={$keyword}";
                break;
            case SUBSCRIBE_FLOW_VIA_WAP:
                $data["SubscriptionFlow"] = "SUBSCRIBE_FLOW_VIA_WAP";
                break;

        }

        $profile = $this->uri->segment(5);
        $data['profile'] = $profile;
        switch($profile)
        {
            case 'funchat':
                $data['BodyImageURL'] = 'funchat.jpg';
            break;
            case 'relationships':
                $data['BodyImageURL'] = 'relationships.jpg';
            break;
            case 'chat':
                $data['BodyImageURL'] = 'chat.jpg';
            break;
            default:
                $body_image_url = $this->Product_model->Body_Image_URL;
                $data['BodyImageURL'] = $body_image_url;
            break;
        }

        $this->_index($data);
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