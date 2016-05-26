<?php
/**
 * Created by John Huseinovic
 * Date: 28/11/12
 * Time: 11:04 AM
 */
require_once( dirname(__FILE__) ."/inc_functions.php" );

class number_lookup
{
    private function ask_smsc($query)
    {
        $data = array();
        $data[] = "username=mobileapps";
        $data[] = "password=appl1cat10ns";
        $data[] = "category=mnp";
        $data[] = "address=". $query;

        $results = file_get_contents("http://srs.smsc.com.au/pcm/client/getcontents.php?". implode("&", $data));

        writeLog("smsc", $results);

        if( substr($results, 0, strlen($query)) == $query )
        {
            $network = substr($results, strlen($query));
            $network = trim($network);
            return $network;
        }
        else
        {
            return "unknown";
        }
    }

    private function ask_integrat($query)
    {
        if($query == "27700000061")
            return "VODACOMSA";
        if($query == "27700000062")
            return "MTNSA";
        if($query == "27700000063")
            return "CELLCSA";
        if($query == "27700000075")
            return "8TASA";

        $URL = trim("http://submitxml.integrat.co.za/higate/requestnetwork.php?Ref=0&MSISDN=". $query);

        #echo $URL;

        $results = file_get_contents($URL);

        writeLog("integrat", $URL ."\n". $results);

        $xml = simplexml_load_string($results);

        switch((int)$xml->Network->ID)
    {
        case 1: return "VODACOMSA";
        case 2: return "MTNSA";
        case 3: return "CELLCSA";
        case 15: return "8TASA";
    }

        return "UNKNOWN";
    }


    static function australia($query)
    {
        return self::ask_smsc($query);
    }

    static function south_africa($query)
    {
       # $mobile = $query;
       # if( substr($mobile, 0, 2) == "27")
       #     $mobile = "0". substr($mobile, 2);

        return self::ask_integrat($query);
    }

    static function generic($country, $mobile)
    {
        $country = (int)$country;
        $mobile = preg_replace("/[^0-9]/","",$mobile);

        if( $country == 61 )
        {
            $msisdn = "{$country}". substr($mobile, 1);
            return self::australia($msisdn);
        }

        if( $country == 27 )
        {
            $msisdn = "{$country}". substr($mobile, 1);
            return self::south_africa($msisdn);

        }

        return "Country not supported!";
    }

}
