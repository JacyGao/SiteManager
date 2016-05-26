<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 18/03/13
 * Time: 10:10 AM
 * To change this template use File | Settings | File Templates.
 */
class Ipadmini extends MY_Controller
{
    private $Question = "Who makes the IPhone?";
    private $Answers = array('Apple','Sony');
    private $CorrectAnswer = "Apple";

    function __construct()
    {
        parent::__construct();

        if( !$this->Country )
            show_error("IPad Mini cannot be shown if country is not specified!");

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

        }
    }

    public function index()
    {
        $data = array();

        $data['Question'] = $this->Question;
        $data['Answers'] = $this->Answers;

        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $this->_index($data);
    }

    function question()
    {
        $this->_question();
    }

    private function _question($error=NULL)
    {
        $data = array();
        $data['Question'] = $this->Question;
        $data['Answers'] = $this->Answers;

        $data['Error'] = $error;

        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $this->Display( 'question', $data);
    }

    function validate()
    {

        if( $this->input->post('answer') != $this->CorrectAnswer ){
            if(!$this->agent->is_mobile())
            {
                //$this->_question( $this->input->post('answer') ." is incorrect answer! Please try again!");
                //redirect('/ipadmini/index/'.$this->CountryKey ."/". $this->Keyword);
                echo "<script type='javascript/text'>";
                echo "alert('Incorrect answer! Please try again!');";
                echo "window.location.href = '"."/ipadmini/index/".$this->CountryKey ."/". $this->Keyword."'";
                echo "</script>";
            }
            else
            {
                return $this->_question( $this->input->post('answer') ." is incorrect answer! Please try again!");
            }
        }
        $mobile = $this->input->post('MobileNo');

        if(!$mobile && $this->session->userdata('MSISDN')) $mobile = $this->session->userdata('MSISDN');

        $this->startSubscription($mobile);
    }

}