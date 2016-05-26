<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 11:43 AM
 */
class srs
{

    private function getCountryMobile($msisdn)
    {
        $data = array();
        if( substr($msisdn, 0, 1) == "1")
        {
            $data['COUNTRY'] = 1;
            $data['MOBILE'] = substr($msisdn, 1);
        }
        elseif( substr($msisdn, 0, 2) == 27 || substr($msisdn, 0, 2) == 61 || substr($msisdn, 0, 2) == 64 || substr($msisdn, 0, 2) == 44 )
        {
            $data['COUNTRY'] = substr($msisdn, 0, 2);
            $data['MOBILE'] = "0". substr($msisdn, 2);
        }
        else
        {
            $data['COUNTRY'] = substr($msisdn, 0, 3);
            $data['MOBILE'] = "0". substr($msisdn, 3);
        }
        return $data;
    }

    function free_mt($shortcode,$msisdn,$message,$username='mobivate')
    {
        $data = self::getCountryMobile($msisdn);
        $data['PROVIDER'] = "default";
        $data['SHORTCODE'] = $shortcode;
        $data['MESSAGE'] = $message;
        $data['TYPE'] = "PIN";
        return self::smsgw($data);
    }

    function billed_mt($shortcode,$msisdn,$message,$cost=NULL)
    {
        $data = $this->getCountryMobile($msisdn);
        $data['PROVIDER'] = "premium";
        $data['SHORTCODE'] = $shortcode;
        $data['MESSAGE'] = $message;
        $data['TYPE'] = "MESSAGE";
        if($cost)
            $data['VALUE'] = $cost;
        return $this->smsgw($data);
    }

    function mo($msisdn,$shortcode,$keyword,$network="premium")
    {
        if(!$network)
            $network = "premium";

        $data = self::getCountryMobile($msisdn);
        $data['PROVIDER'] = $network;
        $data['SHORTCODE'] = $shortcode;
        $data['MESSAGE'] = $keyword;
        $data['TYPE'] = "SUBSCRIBE";
        $data['AFFILIATE'] = $keyword;
        $data['IP'] = $_SERVER['REMOTE_ADDR'];
        return self::smsgw($data);
    }

    function SendDOIRequest($shortcode,$msisdn,$provider,$productcode,$keyword,$message='SILENT BILLING MESSAGE',$cost=NULL)
    {
        $data = $this->getCountryMobile($msisdn);
        $data['PROVIDER'] = $provider;
        $data['SHORTCODE'] = $shortcode;
        $data['MESSAGE'] = $message;
        $data['TYPE'] = "MESSAGE";
        $data['STARTED'] = date("Y-m-d H:i:s") . " FIRST";
        $data['KEYWORD'] = $productcode ." FORCE";
        $data['INREPLYTO'] = $keyword;

        if($cost)
            $data['VALUE'] = $cost;
        return $this->smsgw($data);
    }

    function Subscribe2Safaricom($msisdn,$shortcode,$keyword,$network="premium")
    {
        $this->load->helper('curl');
        $url = 'http://apps.mobivate.com/srs/api/subscribe2safaricom?msisdn='.$msisdn.'&shortcode='.$shortcode.'&keyword='.$keyword;

        $result = curl($url);
        return $result;
    }

    function queue_free_mt($shortcode,$msisdn,$message)
    {
        $data = self::getCountryMobile($msisdn);
        $data['PROVIDER'] = "default";
        $data['SHORTCODE'] = $shortcode;
        $data['MESSAGE'] = $message;
        $data['TYPE'] = "CUE_PIN";
        return self::smsgw($data);
    }

    function queue_billed_mt($shortcode,$msisdn,$message,$cost)
    {
        $data = self::getCountryMobile($msisdn);
        $data['PROVIDER'] = "premium";
        $data['SHORTCODE'] = $shortcode;
        $data['MESSAGE'] = $message;
        $data['TYPE'] = "CUE_MESSAGE";
        $data['VALUE'] = $cost;
        return self::smsgw($data);
    }

    function get_error($code)
    {
        include_once( dirname(__FILE__) ."/smsgw/errors.php");

        return errors::explain( $code );
    }

    private function smsgw($req = array())
    {
        include_once( dirname(__FILE__) ."/smsgw/users.php");

        if(!isset($req['UNAME']))
            $req['UNAME'] = "mobivate";

        if(!isset($req['PWD']))
            $req['PWD'] = users::getPassword( $req['UNAME'] );

        $req['SERVICE'] = preg_replace("/[^a-zA-Z]/","",strtolower($req['MESSAGE']));


        include_once( dirname(__FILE__) ."/smsgw/message.php");


        $msg = new message($req);

        $valid = $msg->validateInput();

        if( $valid !== true )
            return $valid;

        $sms = $msg->prepareMessage();

        return $msg->sendSMS($sms);

    }

}
