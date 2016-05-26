<?php
/**
 * Created by John Huseinovic
 * Date: 23/11/12
 * Time: 8:26 PM
 */

function getShortURL($url, $service = "tinyurl") {
    $services = array();
    $services['tinyurl'] = "http://tinyurl.com/api-create.php?url=";
    $services['urltea'] = "http://urltea.com/api/text/?url=";
    $services['snipurl'] = "http://snipurl.com/site/snip?r=simple&link=";
    $services['urlx'] = "http://urlx.org/api.php?domain=0&x=";

    if( !$services[ $service ] ) $service = 'tinyurl';


    $URL = $services[ $service ] . $url;
    $DATA = array();

    $DATA[] = "MOBILE=". $mobile;
    $DATA[] = "PIN=". trim($pin);

    $URL_Info=parse_url($URL);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$URL);
    curl_setopt($ch, CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
    curl_setopt($ch, CURLOPT_POST,0);
#	curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$DATA) );
    $result=curl_exec ($ch);
    curl_close ($ch);
    return trim($result);
}