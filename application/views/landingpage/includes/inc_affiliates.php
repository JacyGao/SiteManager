<?
require_once( dirname(__FILE__) ."/inc_start.php");

$PIXEL_CLIENT = false;
$PIXEL_SERVER = false;
$CID_PARAM = "cid";

if(!isset($AFFILIATE)) $AFFILIATE = isset($_SESSION['Affiliate'])? $_SESSION['Affiliate']:"gen";

switch($AFFILIATE)
{
	case "epi":
		$PIXEL_CLIENT = false;
		$PIXEL_SERVER = true;
		$CID_PARAM = "cid";

	break;	

	case "mat":
		$PIXEL_CLIENT = false;
		$PIXEL_SERVER = false;
		$CID_PARAM = "cid";

	break;	
	
	case "nevb":
		$PIXEL_CLIENT = false;
		$PIXEL_SERVER = false;
		$CID_PARAM = "cid";

	break;	
	
	case "drg":
		$PIXEL_CLIENT = false;
		$PIXEL_SERVER = false;
		$CID_PARAM = "cid";

	break;	


}


if($PIXEL_SERVER && isset($_GET[$CID_PARAM]) )
{
	$_SESSION['AFFILIATE_ID'] = $AFFILIATE;
	$_SESSION['SUB_ID'] = urldecode($_GET[$CID_PARAM]);
}

AffiliateTracking();