<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:10 PM
 */

class Subscription_model extends CI_Model
{
    var $Error = NULL;

    function __construct()
    {
    }

    function Subscribe($shortcode,$msisdn,$keyword,$network=NULL)
    {
        log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." Load PSS Library");
        $this->load->library('pss');


        if(!pss::ServiceKeywordExists($shortcode,$keyword))
        {
            log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." ServiceKeyword Not found!");
            $this->Error = ERROR_UNKNOWNKEYWORD;
            return false;
        }

        log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." Load SRS Library");
        $this->load->library('srs');

        log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." Load UserAgent Library");
        $this->load->library('user_agent');
        #$message = sprintf("%s [%s] UA:%s", $keyword, $this->input->ip_address(), $this->agent->mobile() );
        $message = sprintf($keyword);

        if(substr($msisdn,0,3) == 254)
        {
            log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." Push MO to Adtel API");
            $result = srs::Subscribe2Safaricom($msisdn,$shortcode,$message,$network);
            log_message("info", "Sent MO {$msisdn} => {$shortcode} '{$message}' ({$network}) => ". $result);

            if(substr($result,0,1) == 0)
            {
                log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." Adtel Returned Positive");
                $this->Error = NULL;
                return true;
            }
            else
            {
                $this->Error = 'Error occured!'. $result;
                log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." SRS Returned Error : {$this->Error} ({$result})");
                return false;
            }
        }
        else
        {
            log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." Push MO to SRS");
            $result = srs::mo($msisdn,$shortcode,$message,$network);
            log_message("info", "Sent MO {$msisdn} => {$shortcode} '{$message}' ({$network}) => ". ($result? "OK":"FAIL") );

            if( $result === true )
            {
                log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." SRS Returned Positive");
                $this->Error = NULL;
                return true;
            }
            else
            {
                $this->Error = errors::explain($result);
                log_message("info", __CLASS__ ."->". __FUNCTION__ ."@Line ". __LINE__ ." SRS Returned Error : {$this->Error} ({$result})");
                return false;
            }
        }
    }

}
