<? 
if($MO_ORDER_ONLY) { 
	echo "<p align=\"center\">\n";
	switch($COUNTRY)
	{
		case GHANA:
			echo "Ghana's number#1 mobile site, content costs just {$PRICE_PREFIX}{$SUBSCR_COST}{$CURRENCY}  per item!";
		break;
		
		case KENYA:
		?>
        <br /><br />
        <?=$HOME_INTRO?> - Wallpapers cost just <?=$COST['Wallpapers']?> credits and Videos <?=$COST['Videos']?> credits - 
        <?=$SUBSCR_CREDITS_PER_MSG?> credits equals just <?=$PRICE_PREFIX.$SUBSCR_COST?>! 
        Sms keyword above and join, by doing this you're subscribing to the service at a cost of ONLY <?=$PRICE_PREFIX.$SUBSCR_COST?> Joining fee + <?="{$PRICE_PREFIX}{$SUBSCR_COST} ". ($SUBSCR_MSG_PER_WEEK<7? "{$SUBSCR_MSG_PER_WEEK}x/week":"per day") ?> which gives you 100 EXTRA credits EVERY TIME - ENJOY!...
            <?
		break;
	}
	echo "<br /><br /></p>\n";
}
?>

<p class="footer">
	<br /><br />
    <p class="footerCopy">
    <a href="terms.php?back=<?= urlencode($_SERVER['REQUEST_URI']); ?>">Terms & Conditions of Service</a> &middot; 
    Copyright <?=$SITE_TITLE?> &copy; <?=date("Y");?>
    </p>
    <br />
</p>

<? 

$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
if($googleAnalyticsImageUrl) 
	echo '<img src="' . $googleAnalyticsImageUrl . '" />';
?>

<p>
<img src="/mobile/images/tittiebar.jpg" width="100%" alt="">
</p>

<?
ob_end_flush(); 
@mysql_close();
exit(); 
