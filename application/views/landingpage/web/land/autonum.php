<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 27/06/13
 * Time: 4:01 PM
 * To change this template use File | Settings | File Templates.
 */
require_once( dirname(__FILE__) ."/inc_header.php");

if(isset($_GET['mobile']))
{
    $mobile = $_GET['mobile'];
}
else
{
    exit("missing mobile number...");
}
if(isset($_GET['shortcode']))
{
    $shortcode = $_GET['shortcode'];
}
else
{
    exit("missing shortcode...");
}
if(isset($_GET['keyword']))
{
    $keyword = $_GET['keyword'];
}
else
{
    exit("missing keyword...");
}
if(isset($_GET['country']))
{
    $country = $_GET['country'];
}
else
{
    exit("missing country...");
}
?>
<p>Congratulations! Your mobile number is <?=$mobile?></p>
<p>you have a chance to win an IPhone</p>
<p>Click YES to subscribe to Mintmonkey</p>

<form action="emsubscribe_confirm.php" method="post">
<input type="hidden" name="mobile" value="<?=$mobile?>">
<input type="hidden" name="shortcode" value="<?=$shortcode?>">
<input type="hidden" name="keyword" value="<?=$keyword?>">
<input type="hidden" name="country" value="<?=$country?>">
<input type="submit" value="YES"/>
</form>

<? require_once( dirname(__FILE__) ."/inc_footer.php"); ?>