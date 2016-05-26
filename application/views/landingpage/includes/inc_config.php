<?
if(!session_id()) session_start();
ob_start();

if( isset($_GET['betatest']) ) $_SESSION['BETATEST'] = true;

require_once( dirname(__FILE__) ."/inc_start.php");
require_once( dirname(__FILE__) ."/inc_free.php");
require_once( dirname(__FILE__) ."/class_Page.php");
require_once( dirname(__FILE__) ."/class_Form.php");
require_once( dirname(__FILE__) ."/inc_db.php");
require_once( dirname(__FILE__) ."/inc_functions.php");
require_once( dirname(__FILE__) ."/googleanalytics.php");

define("CLIENTCODE", "MOBIVATE");

define("SOUTH_AFRICA", 27);
define("GHANA", 233);
define("KENYA", 254);


$SITE_TITLE = "Mint Monkey";

$ITEMS_PER_ROW = 2;
$ITEMS_PER_PAGE = 4;

$HEADER_NOTE = "";

$ALLOW_BYPASS = true;
$MO_ORDER_ONLY = false;
$NO_DOI = false;
$COST = array();
$IS_MO = false;

$SUBSCR_CREDITS_ON_SUB = 1000;
$SUBSCR_CREDITS_PER_MSG = 100;

$HTTP_HOST = strtoupper($_SERVER['HTTP_HOST']);

if( $HTTP_HOST == "DEV.MINTMONKEY.COM" ) $HTTP_HOST = "M.KE.GEN1.MINTMONKEY.COM";


if( ($_SERVER['HTTP_HOST'] == "www.mintmonkey.com" || $_SERVER['HTTP_HOST'] == "mintmonkey.com") && !isset($DO_NOT_REDIRECT) ) 
{
	header("Location: http://m.ke.gen1.mintmonkey.com/?". $_SERVER['QUERY_STRING']);
} elseif( ($_SERVER['HTTP_HOST'] == "www.mintmonkey.com" || $_SERVER['HTTP_HOST'] == "mintmonkey.com") && isset($DO_NOT_REDIRECT) ) 
{
	$HTTP_HOST = "M.KE.GEN1.MINTMONKEY.COM";
}

preg_match("/([A-Z]{1})\.(KE|GH|SA|CA|AU)\.([A-Z0-9]+)\.([A-Z0-9.]+)\.([A-Z]+)/",$HTTP_HOST,$DOMAIN);

$DOMAIN_COUNTRY = NULL;
$ON_ENTRY = "CHOOSE_COUNTRY";
$HOME_TITLE = "Scroll down &amp; CLICK THE BUTTON RIGHT NOW for COOL mobile stuff!!";
$HOME_INTRO = "Bringing u great FUN and great value";

if( sizeof($DOMAIN) > 4 ) include_once( dirname(__FILE__) ."/inc_config_new.php");
