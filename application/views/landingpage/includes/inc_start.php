<? 
if(!session_id()) session_start();

#echo "<!-- ". session_id() ."-->\n";
require_once(dirname(__FILE__)  . "/syslogger.php");
require_once(dirname(__FILE__)  . "/inc_functions.php");

$mkc = setMkhojCookie();


if( strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot') == true || 
	strstr($_SERVER['HTTP_USER_AGENT'], 'YandexBot') == true || 
	strstr($_SERVER['HTTP_USER_AGENT'], 'Baiduspider') == true 
	) die("No Bots Allowed");

syslogger::info($_SERVER['REMOTE_ADDR'] ." >> ". $_SERVER['REQUEST_URI'] );
syslogger::info("UserAgent : ". $_SERVER['HTTP_USER_AGENT'] );


define("SMS_GATEWAY", "http://www.mobivate.com/smsgw/");

function SendSMS($originator, $provider = "default", $type = "PIN", $country = "", $mobile, $service = false, $message = "", $affiliate = false, $value=false, $extra=false) {
	$URL = SMS_GATEWAY . "SendSMS.php";
	$DATA = array();

	$message = str_replace("&", "%26", $message);

	$DATA[] = "UNAME=mobivate";
	$DATA[] = "PWD=4Gd3-tDsc";
	$DATA[] = "COUNTRY={$country}";
	$DATA[] = "MOBILE={$mobile}";
	$DATA[] = "SHORTCODE={$originator}";
	$DATA[] = "PROVIDER={$provider}";
	$DATA[] = "TYPE={$type}";
	if($service) $DATA[] = "SERVICE={$service}";
	if($affiliate) $DATA[] = "AFFILIATE={$affiliate}";
	$DATA[] = "MESSAGE={$message}";
	$DATA[] = "IP=".$_SERVER['REMOTE_ADDR'];
	if($value) $DATA[] = "VALUE={$value}";
	if($extra) $DATA[] = strtoupper($extra);
	
	$URL_Info=parse_url($URL);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL_Info["host"].$URL_Info["path"]);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$DATA) );
	$result=curl_exec ($ch);
	curl_close ($ch);

	syslogger::debug(__FUNCTION__ .": ". $URL ."?". implode("&", $DATA) );
	syslogger::debug("RETURNED: ". $result );
	
	return $result;
}

function GetHostURL()
{
	$host = str_replace("www.","",$_SERVER['HTTP_HOST']);
	$host = str_replace("mintmonkey.com","",$_SERVER['HTTP_HOST']);
	
	$host = explode(".", $host);
	
	$domain = "mintmonkey.com/" . implode("/", $host);
	return $domain;
}

function FixURL($url)
{
    $url = str_replace("//","/", $url);
    $url = str_replace("www/","", $url);
    # TODO: Disable the "simulated" url when you have propper urls for the existing pixels in MPM
    # if too many subdomains, replace by single common subdomain

    #$url = "xxx.mintmonkey.com/simulated";
    return $url;
}


function GetPixels($aff="",$folder="") 
{
	global $_SESSION;
	
	if($aff) 
	{
		if(substr($aff,0,1) != "/") $aff = "/".$aff;	
	}
	
	$URL = SMS_GATEWAY . "GetPixels.php";
	$DATA = array();
	$DATA[] = 'REFERER='. FixURL( GetHostURL().$aff.$_SERVER['REQUEST_URI'].$folder );
	
	$URL_Info=parse_url($URL);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL_Info["host"].$URL_Info["path"]);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$DATA) );
	$result=curl_exec ($ch);
	curl_close ($ch);
		
	$result = str_replace("%%MOBILE%%", $_SESSION['MobileNo'], $result);
	$result = str_replace("%%AFF_ID%%", $_SESSION['AFFILIATE_ID'], $result);
	$result = str_replace("%%SUB_ID%%", $_SESSION['SUB_ID'], $result);
	$result = str_replace("%%AFF_SUB%%", $_SESSION['AFFILIATE-SUB'], $result);
	
	$result .= '<img src="https://encrypted.reporo.net/conversion" width=1 height=1 />';
	
	echo $result ."\n";
}

function SavePixels($aff="",$suff="") 
{
	echo "<!--";
	print_r($_SESSION);
	echo "-->";
	
	if($aff) 
	{
		if(substr($aff,0,1) != "/") $aff = "/".$aff;	
	}
	
	
	
	$URL = SMS_GATEWAY . "SavePixels.php";
	$DATA = array();
	$DATA[] = "DOMAIN=". FixURL( GetHostURL().$aff.$_SERVER['REQUEST_URI'] );
	$DATA[] = "KEYWORD=". $_SESSION['ProductID'];
	$DATA[] = "MOBILE=". $_SESSION['MobileNo'];
	$DATA[] = "AFFID=". urlencode($_SESSION['AFFILIATE_ID']);
	$DATA[] = "SUBID=". urlencode($_SESSION['SUB_ID']);
	
	$URL_Info=parse_url($URL);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL_Info["host"].$URL_Info["path"]);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$DATA) );
	echo curl_exec ($ch);
	curl_close ($ch);
}

function VerifyPin($PinToVerify) {
	if ($_SESSION['PINair'] == trim($PinToVerify)){  
		echo "<script language='Javascript'>window.location='subscribe.php';</script>";
	} else {
		if ((int)$_SESSION['Check'] > 0){
			echo "<script language='Javascript'>alert('You have not entered the correct PIN!');</script>";
			$_SESSION['Alert1'] = "You have not entered the correct PIN!";
		}
	}	
	(int)$_SESSION['Check']++;
}

function getError($err) {
	$URL = SMS_GATEWAY . "Errors.php";
	$DATA = array();
	
	$DATA[] = "ERR=". (int)$err;
	
	$URL_Info=parse_url($URL);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL_Info["host"].$URL_Info["path"]);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$DATA) );
	$result=curl_exec ($ch);
	curl_close ($ch);
	
	syslogger::debug(__FUNCTION__ .": ". $URL ."?". implode("&", $DATA) );
	syslogger::debug("RETURNED: ". $result );
	return $result;
}
function setPIN($mobile, $product) {
	$URL = SMS_GATEWAY . "db_pin.php";
	$DATA = array();
	
	$DATA[] = "MOBILE=". $mobile;
	$DATA[] = "PRODUCT=". $product;

	$URL_Info=parse_url($URL);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL_Info["host"].$URL_Info["path"]);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$DATA) );
	$result=curl_exec ($ch);
	curl_close ($ch);
	
	syslogger::debug(__FUNCTION__ .": ". $URL ."?". implode("&", $DATA) );
	syslogger::debug("RETURNED: ". $result );

	return $result;
}

function getPIN($mobile, $pin='') {
	$URL = SMS_GATEWAY . "db_pin.php";
	$DATA = array();
	
	$DATA[] = "MOBILE=". $mobile;
	$DATA[] = "PIN=". trim($pin);
	
	$URL_Info=parse_url($URL);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL_Info["host"].$URL_Info["path"]);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$DATA) );
	$result=curl_exec ($ch);
	curl_close ($ch);
	
	syslogger::debug(__FUNCTION__ .": ". $URL ."?". implode("&", $DATA) );
	syslogger::debug("RETURNED: ". $result );
	
	return trim($result);
}

function AffiliateTracking() {
	$URL = SMS_GATEWAY . "AffiliateTracking.php";
	$DATA = array();
	
	$DATA[] = "SESSIONID=". session_id();
	$DATA[] = "DOMAIN=". $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$DATA[] = "AFF_ID=". (isset($_SESSION['AFFILIATE_ID'])? $_SESSION['AFFILIATE_ID']:"");
	$DATA[] = "SUB_ID=". (isset($_SESSION['SUB_ID'])? $_SESSION['SUB_ID']:"");
	$DATA[] = "AFF_SUB=". (isset($_SESSION['AFFILIATE-SUB'])? $_SESSION['AFFILIATE-SUB']:"");
	$DATA[] = "MOBILE=". (isset($_SESSION['MobileNo'])? $_SESSION['MobileNo']:"");
	$DATA[] = "REFERER=". (isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:"");

	$URL_Info=parse_url($URL);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL_Info["host"].$URL_Info["path"]);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,0);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER'] );
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$DATA) );
	
	$result = curl_exec ($ch);
	curl_close ($ch);
	
	syslogger::debug(__FUNCTION__ .": ". $URL ."?". implode("&", $DATA) );
	syslogger::debug("RETURNED: ". $result );
	
	return $result;
}

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
	
	syslogger::debug(__FUNCTION__ .": ". $URL ."?". implode("&", $DATA) );
	syslogger::debug("RETURNED: ". $result );	
	
	return trim($result);
}

function CheckMSISDN($force=false)
{
	#setcookie("MSISDN",$identity->msisdn); 
	if( isset($_COOKIE['MSISDN']) && $force === false ) { $_SESSION['MSISDN'] = (string)$_COOKIE['MSISDN']; syslogger::info("Getting MSISDN from Cookie {$_SESSION['MSISDN']}"); return true; }
	#echo "[Checking..]";
	syslogger::info("INITIALIZING LOOKUP.php");
	require_once( dirname(__FILE__) .'/lookup.php');	
	#echo "[done]";

}
