<?php

require_once( dirname(__FILE__) ."/inc_db.php");


function getPoints($msisdn=NULL) 
{
	
	if(!$msisdn) return 0;
	
	$points = mysql_query("SELECT points FROM points WHERE mobile='". mysql_escape_string($msisdn) ."' LIMIT 1");
	if(!$points) return 0;
	
	if(mysql_num_rows($points) > 0) {
		list($points) = mysql_fetch_row($points);
		return (int)$points;
	} else {
		return 0;	
	}
}


function shouldNotify() 
{
	if(!isset($_SESSION['MSISDN'])) return 0;
	
	$points = mysql_query("SELECT points FROM points WHERE mobile='". addslashes($_SESSION['MSISDN']) ."' AND notified=0 LIMIT 1");
	if(!$points) return 0;
	
	return mysql_num_rows($points);
}


function setNotified()
{
	mysql_query("UPDATE points SET notified=1 WHERE mobile='". addslashes($_SESSION['MSISDN']) ."' LIMIT 1");
}

function cURL($URL,$useragent = false) {
	$URL_Info=parse_url($URL);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_USERAGENT, ($useragent? $useragent:$_SERVER['HTTP_USER_AGENT']));
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
#	curl_setopt($ch, CURLOPT_GET,1);
		$result=curl_exec ($ch);
	curl_close ($ch);
	return $result;
}

function DomainNameToTitle($domain)
{
	$domain = strtoupper($domain);
	if(strstr($domain,"GHANA") == true || strstr($domain,"KENYA") == true)
	{
		switch( substr($domain, 5, 1) )
		{
			case "G": return "Games";
			case "T": return "Tones";
			case "V": return "Videos";
			case "W": return "Wallpapers";
		}
	}
	return ucfirst(strtolower($domain));
}

function KeywordToTitle($keyword)
{
	$keyword = strtoupper($keyword);
	switch( substr($keyword, 0, 1) )
	{
		case "G": return "Games";
		case "T": return "Tones";
		case "V": return "Videos";
		case "W": return "Wallpapers";
	}
}


function GetMOKeyword($rs)
{
	switch( strtolower($rs['contentType']) )
	{
		case "games": return "GAME".$rs['ID'];
		case "animations": return "ANI".$rs['ID'];
		case "covertones": return "TONE".$rs['ID'];
		case "sound effects": return "TONE".$rs['ID'];
		case "videos": return "VID".$rs['ID'];
		case "wallpapers": return "WALL".$rs['ID'];
		
	}
}

function GetShortMOKeyword($rs)
{
	global $KW_DIGIT;
	
	$campaign = chr( 64 + $KW_DIGIT );
	switch( strtolower($rs['contentType']) )
	{
		case "games": return "G" . $campaign . $rs['ID'];
		case "animations": return "A" . $campaign . $rs['ID'];
		case "covertones": 
		case "sound effects":
		case "polyphonics": return "T" . $campaign . $rs['ID'];
		case "videos": return "V" . $campaign . $rs['ID'];
		case "wallpapers": return "W" . $campaign . $rs['ID'];
		
	}
}


// This code should be accessible in the page that the above two snippets are called
function setMkhojCookie() {
        $mkcookie = null;
        if($_COOKIE["mKCu"]) {
            $mkcookie = $_COOKIE["mKCu"];
        }
        else {
            $mkcookie = md5(uniqid(rand(), true));
            setcookie("mKCu", $mkcookie,time()+(3600*24*30),'/');
        }
        return $mkcookie;
    }
    function mkhojSiteAnalytics($advId, $mkCookie, $goalId) {
	$mkUrl = 'http://ma.mkhoj.com/analytics/mkhoj.gif';
	$params = array();
	$params["mk-carrier"] = rawurlencode($_SERVER['REMOTE_ADDR']);
	if(array_key_exists('HTTP_REFERER', $_SERVER)) {
	    $params["mKRef"] = rawurlencode($_SERVER['HTTP_REFERER']);
	}
	$params["mKPage"] = rawurlencode($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
	$params["mKGid"] = rawurlencode($goalId);
	$params["mKAdvId"] = $advId;
	$params["mKCVer"] = "QEQE-1";
        if (($_REQUEST["mKImpId"])) {
           $params["mKImpId"] = $_REQUEST["mKImpId"];
        }
        $params["mKCu"] = $mkCookie;

	$headers = array();
	foreach (getallheaders() as $name => $value) {
	    $headers[strtolower($name)] = $value;
	}
	$headers["mk-carrier"] = rawurlencode($_SERVER['REMOTE_ADDR']);
	$headers["Content-Type"] = "application/x-www-form-urlencoded";
	$headers["charset"] = "UTF-8";
	$mkhoj_prot = 'http';
	if( !empty($_SERVER['HTTPS']) && ('on' === $_SERVER['HTTPS']) )
	    $mkhoj_prot .= 's';
	$headers["Referer"] = rawurlencode($mkhoj_prot . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

	$mkhojPost = array();
	foreach($params as $key => $value) {
	    array_push($mkhojPost, "$key=$value");
	}
	$mkhojPostBody = join('&', $mkhojPost);

	$headersList = array();
	foreach($headers as $key => $value) {
	    array_push($headersList, "$key: $value");
	}
	$mkhoj_timeout = 12;

	$mkhoj_copt = array (
		CURLOPT_URL             => $mkUrl,
		CURLOPT_RETURNTRANSFER  => true,
		CURLOPT_HEADER          => false,
		CURLOPT_HTTPPROXYTUNNEL => true,
		CURLOPT_POST            => true,
		CURLOPT_POSTFIELDS      => $mkhojPostBody,
		CURLOPT_CONNECTTIMEOUT  => $mkhoj_timeout,
		CURLOPT_TIMEOUT         => $mkhoj_timeout,
		CURLOPT_HTTPHEADER      => $headersList
		);
	$mkhoj_ch = curl_init();
	curl_setopt_array( $mkhoj_ch, $mkhoj_copt );

	$mkhoj_response = curl_exec($mkhoj_ch);

	curl_close($mkhoj_ch);
}

function ip2country($ipaddr)
{
   return file_get_contents("http://geoip.wtanaka.com/cc/$ipaddr");
}

function thisIP2Country() 
{ 
	if( isset($_COOKIE['ip2country']) && strlen($_COOKIE['ip2country']) == 2 ) return $_COOKIE['ip2country'];
	
	$result = ip2country($_SERVER['REMOTE_ADDR']);
	if(strlen($result) == 2) 
	{
		setcookie("ip2country", $result);
		return $result;
	}
	return "";
}
