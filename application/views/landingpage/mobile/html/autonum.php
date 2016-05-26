<?PHP

$url = $_SERVER["REQUEST_URI"];
$tokens = explode('/', $url);
$page=$tokens[3];
$rest = substr($page, 0, 2);
$page = $rest;
$text = "For your chance to win an iPad mini
            and Subscribe to get the best Games and Music for R5/day on your phone";


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
<form action="emsubscribe_confirm.php" method="post">
    <div align = "center">
        <p style="text-align:center; font-size: 14px">Only one more step to go! </p>
        <p style="text-align:center; font-size: 14px"> <font color=red><?=$mobile?></font></p>
        <p style="text-align:center; font-size: 14px">Now Click YES</p>

        <input type="hidden" name="mobile" value="<?=$mobile?>">
        <input type="hidden" name="shortcode" value="<?=$shortcode?>">
        <input type="hidden" name="keyword" value="<?=$keyword?>">
        <input type="hidden" name="country" value="<?=$country?>">
        <input type="image" src="/css/landingpage/images/cmd_join.png"  height="70" width="170">


        <?php if($page == "sa"):?>
            <p style="text-align:center; font-size: 14px;">
                <? echo $text;?>
            </p>

        <?php else:?>

        <?php endif;?>
    </div>
</form>
<div align = "center">
<? require_once( dirname(__FILE__) ."/inc_footer.php"); ?>