<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function curl_post($url, $data=array())
{
	$s = microtime(true);
	$response = curl($url, $data, CURL_POST);
	$e = microtime(true);
	
	return $response;
}

function curl_get($url, $data=array())
{
	$query = array();
	foreach($data as $k=>$v) { $query[] = $k."=".urlencode($v); }
	$url .= "?". implode("&", $query);
	
	$data = array();
	
	$s = microtime(true);
	$response = curl($url, $data, CURL_GET);
	$e = microtime(true);
	
	return $response;
}

function curl($url, $data=array(), $method=CURL_POST)
{
	log_message("debug", "CURL ". ($method == CURL_POST? "POST":"GET") ." : ". $url);
	if($method == CURL_POST) log_message("debug", "CURL DATA : ".  json_encode($data) );
	
	if(defined("SYSTEM_TESTING") && SYSTEM_TESTING) 
	{
		log_message("debug", "SYSTEM_TESTING ENABLED ... Returning 0 (success)");
		return "0";
	}

    $username = 'jacy';
    $password = 'gao';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookiefile.txt'); 
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiefile.txt'); 
	
	if($method == CURL_POST) 
	{
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
	
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}


/* End of file curl_helper.php */