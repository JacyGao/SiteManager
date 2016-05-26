<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:06 PM
 */
class LoveCalculator extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        if( !$this->Country )
            show_error("Love Calculator cannot be shown if country is not specified!");

        $this->setDescription();
    }

    private function setDescription()
    {
        $flow = $this->Product_model->getSubscriptionFlow();
        $freq = $this->Product_model->getMessageFrequency();
        $pricing = $this->siteconfig->getPricing();

        switch($flow)
        {
            case SUBSCRIBE_FLOW_PIN:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME% Love Scopes. You will receive {$freq} @ {$pricing}";
                break;

            case SUBSCRIBE_FLOW_DOI:
                $this->Description = "This is a subscription service, by inserting your mobile number and sending in a text message, you are subscribing to the %SITE_NAME% Love Scopes. You will receive {$freq} @ {$pricing}";
                break;

        }
    }

    public function index()
    {
        $data = array();

        $this->_index($data);
    }

    public function enternames()
    {
        $data = array();

        $this->Display( __FUNCTION__, $data);
    }

    public function entermobile()
    {
        $data = array();

        $data['Yname'] = $this->input->post('Yname');
        $data['Lname'] = $this->input->post('Lname');

        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $this->Display( __FUNCTION__, $data);
    }

    function validate()
    {

        $mobile = $this->input->post('MobileNo');

        if(!$mobile && $this->session->userdata('MSISDN')) $mobile = $this->session->userdata('MSISDN');

        $this->startSubscription($mobile);
    }


}
