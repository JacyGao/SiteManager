<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:06 PM
 */
class IQ extends MY_Controller
{
    private $Questions = array();
    private $Answers = array();
    private $Correct = array();
    private $AnswerHTML = array();

    function __construct()
    {
        parent::__construct();

        if( !$this->Country )
            show_error("IQ Test cannot be shown if country is not specified!");

        $this->setDescription();

        for($i=1; $i<=9; $i++)
        {
            $q = "Q_{$i}";
            $a = "Q_{$i}_Answers";
            $c = "Q_{$i}_Correct";
            $this->Questions[$i] = $this->Product_model->$q;
            $this->Answers[$i] = (array)$this->Product_model->$a;
            $this->Correct[$i] = $this->Product_model->$c;
            $this->AnswerHTML[$i] = "";
        }

        $this->Questions[10] = !$this->session->userdata('MSISDN')? "What is your mobile number?":"Terms and Conditions";
        $this->Answers[10] = NULL;
        $this->AnswerHTML[10] = (!$this->session->userdata('MSISDN')? "<p style=\"text-align:center;\"><input type=\"text\" name=\"MobileNo\" /><br /><small>Enter your mobile number to receive your IQ score.</small></p>" : "").
                              $this->siteconfig->getTermsCheckbox($this->Product);

    }

    private function setDescription()
    {
        $flow = $this->Product_model->getSubscriptionFlow();
        $freq =  $this->Product_model->getMessageFrequency();

        switch($flow)
        {
            case SUBSCRIBE_FLOW_PIN:
                $this->Description = "This is a subscription service, by inserting your mobile number and entering the pin, you are subscribing to the %SITE_NAME% IQ Club ('IQ Club') where you will receive IQ improving messages {$freq}.";
                break;

            case SUBSCRIBE_FLOW_DOI:
                $this->Description = "This is a subscription service, by inserting your mobile number and sending in a text message, you are subscribing to the %SITE_NAME%  IQ Club ('IQ Club') where you will receive IQ improving messages {$freq}.";
                break;

        }
    }

    public function index()
    {
        $data = array();

        $data['Q1_Notation'] = "Question 1 of 6";
        $data['Q1_Question'] = $this->Questions[1];
        $data['Q1_Options'] = $this->Answers[1];
        $data['Q1_HTML'] = NULL;

        $data['next_page'] = 2;

        $this->_index($data);
    }

    public function questions()
    {
        $page = (int)$this->uri->segment(5);
        $data = array();



        $data['Q1_HTML'] = $data['Q2_HTML'] = $data['Q1_Notation'] =  $data['Q2_Notation'] = $data['Q1_Question'] =  $data['Q2_Question'] = NULL;
        $data['Q1_Options'] =  $data['Q2_Options'] = array();

        $questions_per_page = 2;
        $total_questions = 10;

        if( $this->agent->is_mobile() )
        {
            $questions_per_page = 1;
            $total_questions = 6;
        }

        $data['next_page'] = $page+2;
        $data['total_pages'] = ($total_questions / $questions_per_page) * 2;

        $questions = array_slice($this->Questions, $page, 2);
        $answers = array_slice($this->Answers, $page, 2);
        $ahtml = array_slice($this->AnswerHTML, $page, 2);

        switch($page)
        {
            case 0:
                if( $this->agent->is_mobile() )
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 1, $total_questions);
                else
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 1, $total_questions);
                $data['Q1_Question'] = array_shift($questions);
                $data['Q1_Options'] = array_shift($answers);
                $data['Q1_HTML'] = array_shift($ahtml);

                $data['Q2_Notation'] = sprintf("Question %d of %d", ($page + 2), $total_questions);
                $data['Q2_Question'] = array_shift($questions);
                $data['Q2_Options'] = array_shift($answers);
                $data['Q2_HTML'] = array_shift($ahtml);
                break;

            case 2:
                $this->session->set_userdata('q1', $this->input->get('q1'));
                $this->session->set_userdata('q2', $this->input->get('q2'));

                if( $this->agent->is_mobile() )
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 2, $total_questions);
                else
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 3, $total_questions);
                $data['Q1_Question'] = array_shift($questions);
                $data['Q1_Options'] = array_shift($answers);
                $data['Q1_HTML'] = array_shift($ahtml);

                $data['Q2_Notation'] = sprintf("Question %d of %d", ($page + 2), $total_questions);
                $data['Q2_Question'] = array_shift($questions);
                $data['Q2_Options'] = array_shift($answers);
                $data['Q2_HTML'] = array_shift($ahtml);

                break;

            case 4:
                $this->session->set_userdata('q3', $this->input->get('q1'));
                $this->session->set_userdata('q4', $this->input->get('q2'));

                if( $this->agent->is_mobile() )
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 3, $total_questions);
                else
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 5, $total_questions);
                $data['Q1_Question'] = array_shift($questions);
                $data['Q1_Options'] = array_shift($answers);
                $data['Q1_HTML'] = array_shift($ahtml);

                $data['Q2_Notation'] = sprintf("Question %d of %d", ($page + 2), $total_questions);
                $data['Q2_Question'] = array_shift($questions);
                $data['Q2_Options'] = array_shift($answers);
                $data['Q2_HTML'] = array_shift($ahtml);
                break;

            case 6:
                $this->session->set_userdata('q5', $this->input->get('q1'));
                $this->session->set_userdata('q6', $this->input->get('q2'));

                if( $this->agent->is_mobile() )
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 4, $total_questions);
                else
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 7, $total_questions);
                $data['Q1_Question'] = array_shift($questions);
                $data['Q1_Options'] = array_shift($answers);
                $data['Q1_HTML'] = array_shift($ahtml);

                $data['Q2_Notation'] = sprintf("Question %d of %d", ($page + 2), $total_questions);
                $data['Q2_Question'] = array_shift($questions);
                $data['Q2_Options'] = array_shift($answers);
                $data['Q2_HTML'] = array_shift($ahtml);
                break;

            case 8:
                $this->session->set_userdata('q7', $this->input->get('q1'));
                $this->session->set_userdata('q8', $this->input->get('q2'));

                if( $this->agent->is_mobile() )
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 5, $total_questions);
                else
                    $data['Q1_Notation'] = sprintf("Question %d of %d", 9, $total_questions);
                $data['Q1_Question'] = array_shift($questions);
                $data['Q1_Options'] = array_shift($answers);
                $data['Q1_HTML'] = array_shift($ahtml);

                $data['Q2_Notation'] = sprintf("Question %d of %d", ($page + 2), $total_questions);
                $data['Q2_Question'] = array_shift($questions);
                $data['Q2_Options'] = array_shift($answers);
                $data['Q2_HTML'] = array_shift($ahtml);

                break;

            case 10:
                $data['next_page'] = NULL;

                $this->session->set_userdata('q9', $this->input->get('q1'));

                if( $this->agent->is_mobile() )
                {
                    if( $this->agent->is_mobile() )
                        $data['Q1_Notation'] = sprintf("Question %d of %d", 6, $total_questions);
                    else
                        $data['Q1_Notation'] = sprintf("Question %d of %d", 10, $total_questions);
                    $data['Q1_Question'] = array_pop($this->Questions);
                    $data['Q1_Options'] = NULL;
                    $data['Q1_HTML'] =  "<form action=\"{$this->DocumentRoot}/iq/questions/{$this->CountryKey}/{$this->Keyword}/6\" method=\"GET\">". array_pop($this->AnswerHTML) .'<br><input type="submit" value="Submit"></form>';
                }
                else
                {
                    $mobile = $this->input->get('MobileNo');

                    if(!$mobile && $this->session->userdata('MSISDN')) $mobile = $this->session->userdata('MSISDN');

                    $this->scheduleScoreMessage();

                    $this->startSubscription($mobile);
                    return;
                }

                break;

            # Only in case of mobile!
            case 12:

                $mobile = $this->input->get('MobileNo');

                if(!$mobile && $this->session->userdata('MSISDN')) $mobile = $this->session->userdata('MSISDN');

                $this->scheduleScoreMessage();

                $this->startSubscription($mobile);

                break;

        }

        # Shuffle the answer options
        if( is_array($data['Q1_Options']) )
            shuffle( $data['Q1_Options'] );
        if( is_array($data['Q2_Options']) )
            shuffle( $data['Q2_Options'] );

        $this->Display( __FUNCTION__, $data);
    }

    private function calculateScore()
    {

        $correct = 0;
        for($i=1; $i<=9; $i++)
        {
            $ans = $this->session->userdata("q{$i}");
            if( $this->Correct[$i] == $ans ) $correct++;
        }

        $score = $correct * 15;

        $this->session->set_userdata('TOTAL_SCORE', $score);

        return $score;

    }

    private function getScoreMessage()
    {
        $score = $this->calculateScore();

        switch( true ) {
            case ($score < 45):
                $MESSAGE = "Your IQ is {$score}. Scientists have discovered cavemen who are smarter than you!";
                break;
            case ($score == 45):
                $MESSAGE = "Your IQ is {$score}. Keep trying! The quest for knowledge should be never ending!";
                break;
            case ($score >= 60 && $score <= 75):
                $MESSAGE = "Your IQ is {$score}. You need to do some studying or you're gonna be cooking burgers and fries 4 life!";
                break;
            case ($score == 90):
                $MESSAGE = "Your IQ is {$score}. You got five questions correct! That's OK but you should keep at it!  Nobody likes a quitter!";
                break;
            case ($score == 105):
                $MESSAGE = "Your IQ is {$score}. That's OK but you should keep at it! Nobody likes a quitter!";
                break;
            case ($score == 120):
                $MESSAGE = "Your IQ is {$score}. That's pretty good, but in order to be great you need to keep studying! Nobody likes a quitter!";
                break;

            case ($score == 135):
                $MESSAGE = "You got a perfect score! You are a genius and that's something to be really proud of! Now go and use those brains for something great!";
                break;
            default:
                $MESSAGE = "Your IQ is {$score}. That's OK but you should keep at it! Nobody likes a quitter!";
                break;
        }
        return $MESSAGE;
    }

    private function scheduleScoreMessage()
    {
        $message = $this->getScoreMessage();
        $this->session->set_userdata('SCHEDULED_MESSAGES', array('type'=>BILL_MESSAGE, 'message'=>$message));
    }

}
