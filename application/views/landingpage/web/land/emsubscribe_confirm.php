<?
require_once( dirname(__FILE__) ."/../includes/inc_start.php");

$mobile = $_POST["mobile"];
$keyword = $_POST["keyword"];
$shortcode = $_POST["shortcode"];
$COUNTRY = $_POST["country"];
$NETWORK = "premium";

if( substr($mobile, 0, strlen($COUNTRY)) == $COUNTRY ) $mobile = "0". substr($mobile, strlen($COUNTRY));

//echo $mobile.$keyword.$shortcode.$COUNTRY.$NETWORK;
//exit($mobile);

$response = SendSMS(
        $shortcode,
		$NETWORK, 
		"SUBSCRIBE", 
		$COUNTRY, 
		$mobile, 
		"",
        $keyword,
		"JUG MintMonkey"
		);
//exit($response);
if ($response < 1) {
    header("location: thanks.php");
} else {
    exit("We are currently facing an issue with our system, please try later");
}
?>