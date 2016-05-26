<?
require_once($_SERVER['DOCUMENT_ROOT'] ."/includes/inc_config.php");

if( isset($_GET['msisdn']) && isset($_GET['token']) )
{
	$checkToken = md5($_GET['msisdn'] . $SECRET);
	if($_GET['token'] == $checkToken)
	{
		$_SESSION['MSISDN'] = $_SESSION['LOGGEDIN'] = $_GET['msisdn'];
	}
}

$page = new MobPage($SITE_TITLE);
$page->ShowFooterLogo = false;

function callback($buffer) {
	global $page;
	return $page->GeneratePage($buffer);
}

ob_start("callback");
######################################################

if( isset($_SESSION['BETATEST']) )
{
	echo "<h3>Beta Features Enabled</h3><hr />";
	echo "<pre style=\"text-align:left;\">";	
	print_r($_SESSION);
	echo "</pre>";
}
?>
<? if($DOMAIN_COUNTRY == "GH"){?>

<p align="center" class="header">
    <img src="/mobile/images/header_bg_ghana.jpg" border=0 alt="<?=$SITE_TITLE?>" width="100%" />
</p>

<?}else{?>

<p align="center" class="header">
    <img src="/mobile/images/header_bg.jpg" border=0 alt="<?=$SITE_TITLE?>" width="100%" />
</p>

<?}?>
<? if(!$MO_ORDER_ONLY) { ?>
<? $AvailableCredits = isset($_SESSION['LOGGEDIN'])? getPoints($_SESSION['LOGGEDIN']):0; ?>
<p align="right" class="tabbar2">
	<?	
	if(!isset($_SESSION['LOGGEDIN']) || strlen($_SESSION['LOGGEDIN']) < 8 )
	{
		$loginpage = "http://". $_SERVER['SERVER_NAME'] ."/mobile/login_get.php?";
		$integrat = "http://wap.integrat.co.za/api.php?clientcode=". CLIENTCODE ."&enctype=none&format=". (strtolower($page->Format) == "wml"? strtolower($page->Format):"xhtml") ."&returnurl=". $loginpage;
		#$integrat = "mnp.php";
		echo "<a href=\"". ($COUNTRY == SOUTH_AFRICA? $integrat:"login.php") ."\" class=\"tab set3 t1\"><u>Click here to Log In</u></a>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href=\"buy_credits.php\" class=\"tab set3 t3\"><u>Click here to Join</u></a>";
	}
	else
	{
		echo "<font class=\"tab set3 t1\" style=\"color:#CC0000;\">{$AvailableCredits} Credits</font>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href=\"buy_credits.php\" class=\"tab set3 t3\"><u>Get More Credits</u></a>";
	}
	?>
    <?= (!$page->isIPHONE()? "<hr size=1 />":"") ?>
</p>
<? } ?>


<? 
if( shouldNotify() )
{
	echo "<p class=\"messageBox\">".
		 "Your credits have been registered. You are now able to download content.".
		 "</p>";
	setNotified();
}
?>
<?= (isset($ERROR)? "<p class=\"messageBox\"><h3><font color=\"#FF0000\">{$ERROR}</font></h3></p>":""); ?>  
