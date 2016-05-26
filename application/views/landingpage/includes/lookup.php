<?
require_once(dirname(__FILE__)  . "/syslogger.php");
	/*
	$_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><identity><status description="Unable to determine subscriber information" code="-3"/></identity>';
	$_xmlurl = "http://www.mobirok.com/wap/test.xml";
	$_xmlurl = "https://wapsvcs1.jumptxt.com/wapsis/identity?svcid=138&token=cNqGyTLXmI&rnd=4d3905503d1ea";
	echo $_xmlurl;
	$e = new SimpleXMLElement($_xmlurl, null, true);
	print_r($e);
	exit;
	*/
syslogger::info( "{$_SERVER['REMOTE_ADDR']} >> ". $_SERVER['REQUEST_URI'] ."?". $_SERVER['QUERY_STRING'] );

if(!session_id()) session_start();

/*
if( !isset($_SESSION['CHECKED_MSISDN']) )
{
	$_SESSION['CHECKED_MSISDN'] = 0;
	$_SESSION['MSISDN'] = "";
}
*/

define("SVCID", 138);

function redirect($location)
{
	syslogger::info( "{$_SERVER['REMOTE_ADDR']} >> redirect: ". $location);
	header("location: ". $location);
	exit();
}

if( isset($HTTP_COOKIE_VARS["MSISDN"]) )
{
	if( (int)$HTTP_COOKIE_VARS["MSISDN"] > 0 ) 
	{
		$_SESSION['MSISDN'] = $HTTP_COOKIE_VARS["MSISDN"];
		$_SESSION['CHECKED_MSISDN'] = 'cookie';
		syslogger::info( "{$_SERVER['REMOTE_ADDR']} >> Found Cookie, using {$_SESSION['MSISDN']}" );

		redirect( $_GET['uri'] );
	}
}

function LookupMSISDN_GetToken($url)
{
	$_SESSION['MSISDN'] = "";
	if( !isset($_SESSION['CHECKED_MSISDN']) ) $_SESSION['CHECKED_MSISDN'] = 0;

	$_SESSION['CHECKED_MSISDN'] = (int)$_SESSION['CHECKED_MSISDN'] + 1;
	$request = "http://wapsvcs1.jumptxt.com/wapsis/discover?svcid=". SVCID ."&url=". urlencode($url) ."&rnd=". uniqid();
	#$xmlstr = file_get_contents($request);
	#return htmlentities($xmlstr);
	
	redirect($request);
}

function LookupMSISDN_Identity($token)
{

	#echo "[Identify token: {$token}]";
	$request = "https://wapsvcs1.jumptxt.com/wapsis/identity?svcid=". SVCID ."&token=". $token;
	
	#echo $request;
	syslogger::info("{$_SERVER['REMOTE_ADDR']} >> LookupMSISDN_Identity: ". $request);
	$identity = new SimpleXMLElement($request,null,true);
	syslogger::info("{$_SERVER['REMOTE_ADDR']} >> SimpleXMLElement ". $identity);
	#print_r($identity);
	
	if( isset($identity->status) )
	{
		$attributes = $identity->status->attributes();
		$_SESSION['CHECKED_MSISDN'] = (string)$attributes['code'];
		if($attributes['code'] < 0)
		{
			switch( $attributes['code'] )
			{
				case "-1": return "Invalid SVCID"; break;
				case "-2": return "Unauthorized redirect URL (not whitelisted)"; break;
				case "-3": return "Unable to determine Subscriber"; break;
				case "-4": return "Invalid Token"; break;
				case "-5": return "Token Expired"; break;
				case "-6": return "Unauthorized Carrier"; break;
			}
			return false;
		}
		else
		{
			if( !isset($identity->msisdn) )	return false;
			if( $identity->msisdn < 1 )	return false;
			$_SESSION['CHECKED_MSISDN'] = $_SESSION['MSISDN'] = (string)$identity->msisdn;

			syslogger::info("{$_SERVER['REMOTE_ADDR']} >> Set MSISDN ". $_SESSION['MSISDN']);

			setcookie("MSISDN", $_SESSION['MSISDN']);  
			return true;
		}
			
	}
	$_SESSION['CHECKED_MSISDN'] = -10;
	return -10;
}

if(!isset($_SESSION['CHECKED_MSISDN']) || isset($_GET['REVALIDATE']))
{
#	if($_SESSION['CHECKED_MSISDN'] < 1)
#	{
	#echo "[Check]";
		if(!isset($_GET['token']) )
		{
			#echo "Get Token\n";
			$uri = $_SERVER['REQUEST_URI'];
			$uri = str_replace("REVALIDATE&","",$uri);
			$uri = str_replace("REVALIDATE","",$uri);
			
		#	$uri = str_replace("?","",$uri);
			
			$uri = "/includes/lookup.php?uri=". urlencode($uri) ;
			
			$uri .= "&RaNdOmIzEr=". uniqid();
			$uri .= "&SESSION=". session_id();
			$uri .= "&REVALIDATE";
			
			$token = LookupMSISDN_GetToken("http://". $_SERVER['HTTP_HOST'] . $uri );
			exit();
		}
		
		$_SESSION['Token'] = $token = $_GET['token'];
		
		
		#echo "[Token:". $token ."]";
		#echo "[RaNdOmIzEr:". $_GET['RaNdOmIzEr'] ."]";
		#echo "[SESSION:". (session_id() == $_GET['SESSION']? "Match":"Invalid {$_GET['SESSION']} != ".session_id()."") ."]";
		if(strlen(trim($token)) > 0) { $status = LookupMSISDN_Identity($token); }
		
		$uri = urldecode($_GET['uri']);
		if( strstr($uri, "?") == false ) $uri .= "?";
		syslogger::info("{$_SERVER['REMOTE_ADDR']} >> Finished Identity ". (isset($_SESSION['MSISDN'])? $_SESSION['MSISDN']:"N/A") );
		redirect( $uri ."&ERROR=". urlencode($status)  );

#	}
}
