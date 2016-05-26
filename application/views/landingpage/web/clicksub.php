<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 27/06/13
 * Time: 4:01 PM
 * To change this template use File | Settings | File Templates.
 */


/* if(isset($_GET['mobile']))
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

$cc = "{Country}"*/
?>
<?php session_start(); ?>
    <!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="HandheldFriendly" content="true" />
        <meta name = "viewport" content="width=device-width,height=device-height" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link href="style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/landingpage/mobile.css">
        <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/mobile.css">
        <title>{TITLE}</title>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-42496636-1', 'textplaywin.com');
            ga('send', 'pageview');

        </script>

        <!-- Start of StatCounter Code for Default Guide -->
        <script type="text/javascript">
            var sc_project=9104786;
            var sc_invisible=1;
            var sc_security="56ce67e1";
            var scJsHost = (("https:" == document.location.protocol) ?
                "https://secure." : "http://www.");
            document.write("<sc"+"ript type='text/javascript' src='" +
                scJsHost+
                "statcounter.com/counter/counter.js'></"+"script>");
        </script>
        <noscript><div class="statcounter"><a title="website
statistics" href="http://statcounter.com/free-web-stats/"
                                              target="_blank">
                    <img class="statcounter"
                                                                   src="http://c.statcounter.com/9104786/0/56ce67e1/1/"
                                                                   alt="website statistics"></a></div></noscript>
        <!-- End of StatCounter Code for Default Guide -->
    </head>
<body>
<div id="content">
    <table width="100%" border="0">
    <tr>
        <td align="center">
            <img src="/css/landingpage/images/Gmajor.jpg" alt="" width="320" height="">
        </td>
    </tr>
    <tr>
    <td>
<form action="emsubscribe_confirm.php" method="post">
    <div align = "center">
        <p style="text-align:center; font-size: 14px">Only one more step to go! </p>
        <p style="text-align:center; font-size: 14px"> <font color=red><?/*=$mobile*/?></font></p>
        <p style="text-align:center; font-size: 14px">Now Click YES</p>
<?/*
        <input type="hidden" name="mobile" value="<?=$mobile?>">
        <input type="hidden" name="shortcode" value="<?=$shortcode?>">
        <input type="hidden" name="keyword" value="<?=$keyword?>">
        <input type="hidden" name="country" value="<?=$country?>">
        <input type="image" src="/css/landingpage/images/cmd_join.png"  height="70" width="170">
*/?>

        <p style="text-align:center; font-size: 14px;">For your chance to win an iPad mini
            and Subscribe to get the best Games and Music for R4.50/day on your phone {Country}
        </p>
    </div>
</form>

<div align = "center">
<? require_once( dirname(__FILE__) ."/inc_footer.php"); ?>