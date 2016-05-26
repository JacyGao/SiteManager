<?PHP

$url = $_SERVER["REQUEST_URI"];
$tokens = explode('/', $url);
$page=$tokens[3];
$rest = substr($page, 0, 2);
$page = $rest;
list($first, $mid, $last) = explode(".", $_SERVER['HTTP_HOST']);

if ($mid == 'textplaywin')
    $text = "For your chance to win an iPad mini and Subscribe to get the best Games and Music for R4.50/day on your phone";
else
    $text = "For your chance to Subscribe to get the best content for R4.50/day on your phone";
?>
<? echo '<'.'?xml version="1.0" charset="UTF-8"?'.'>'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <title>{TITLE}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
    <link rel="shortcut icon" href="{DocumentRoot}/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/mobile.css">
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/mobile.css">
    <link rel="icon" href="../../images/favicon.ico">
    <link rel="stylesheet" href="/css/portal/web/js/js.css" type="text/css"  />
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-41644938-1', 'fizzmobi.com');
        ga('send', 'pageview');


    </script>
</head>

{WRAPPER_START}

<table width="100%" border="0">
    <tr>
        <td><img src="{DocumentRoot}/css/{ProductPath}/images/header_tpw.jpg" width="100%" height=""></td>
    </tr>
    <tr>
        <td><h3 style="text-align:center;">
                sms <font color=red> {Keyword} </font>to <font color=red>{Shortcode}</font>
                <br/><br/>To get your Air Time Voucher
            </h3></td>
    </tr>
    <tr>
        <td><img src="{DocumentRoot}/css/{ProductPath}/images/voucher.jpg" width="100%" height=""></td>
    </tr>
</table>

<form method="post" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="280" valign="top" align="center">

                <p align="center" style="font-size:14px; font-weight:bold;">


                    OR<br/>
                    Enter your mobile number:<br />
                    <span style="font-size:11px; color:#999999;">(format eg. {MobileExample} <!--{MobileExample}-->)</span>

                    <br>
                    <input type="text" id="mobile" name="mobile" size="25" required placeholder="07XXXXXXXXXX"
                           pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 45px;" maxlength="10"><br />

                    <!-- <div>{TermsCheckbox}</div> -->

                </p>
                <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/cmd_Sub1.png" / height="50" width="170"><br/>
                    <?php if($page == "sa"):?>
                        <font style="text-align:center; font-size: 14px;">
                            <? echo $text;?>
                        </font>
                    <?php endif;?>
                </p></tr>
    </table>
</form>
<div class="footer">

    <strong>Terms & Conditions:</strong>
    {Terms_And_Conditions}

    <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
</div>

{WRAPPER_END}
