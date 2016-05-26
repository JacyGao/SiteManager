<?
$kw = strtoupper($this->uri->segment(4));
$kw1= $this->uri->segment(6);
if ($kw1 == 'top')
{
    $text="Or <br />Enter your mobile number to get the <br />
           best Kenyan Games, Ringtones, Sound Effects, Wallpapers & Videos with 1000 <br />
           free credits.";
}
else
{
    $text="Get the best Kenyan Games, Ringtones, Sound Effects, Wallpapers & Videos with 1000 free credits now. <br />
              Ksh 30 to join and then Ksh 30 4x/week";
}
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

<div class="wrap">

    <div class="logo">
        <img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/header_bg.jpg"  width="100%" >
    </div> <!-- logo -->



    <div align="center" class="container">

        <font class="tn">Not a Member?</font>
        <h3 style="text-align:center;">
            SMS <font color="#5fa20f"> <?php echo $kw; ?> </font>to <font color="#5fa20f">{Shortcode}</font></h3>
        <font style="font-size:14px;">
            <? echo $text;?><br />
        </font>

        <font class="tn"> OR <br />
            Enter your mobile number below</font>
    </div><!-- first part -->


    <div class="clear"></div>

    <div class="white">

        <div id="left" align="left">

                <img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/pass.jpg" alt="" width="100%" />
        </div>
        <div id="right" align="center">
            <form method="post" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">

                    <span style="font-size:11px; color:#000000;">
                      (format eg.{MobileExample} <!--{MobileExample}-->)</span>
                <br />
                <input type="text" id="mobile" name="mobile" size="25" required placeholder="07XXXXXXXXXX"
                       pattern="\d+" style="text-align: left; font-size: 15px; padding-left: 10px; width:140px; height: 30px;" maxlength="10" /><br />

                <!-- <?=$SelectNetwork?> --> <!-- <div>{TermsCheckbox}</div> -->

                <input type="image" src="{DocumentRoot}/css/{ProductPath}/images/cmd_Sub1.png"  height="50" width="120" / >

            </form>
        </div>
        <div class="clear" style="background-color:#FFF;"></div>
        <div class="container" style="background-color:#FFF; text-align:left">
            <p align="center">
                <a href=""><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/icons/btn_tones.jpg" alt="Latest Music" width="21%" height="99" border="0"></a>
                <a href=""><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/icons//btn_games.jpg"  alt="Latest Games" width="21%"" height="99" border="0"></a>
                <a href=""><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/icons/btn_videos.jpg" width="21%" height="99"  alt="Funniest Videos" border="0"></a>
                <a href=""><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/icons/btn_wallpapers.jpg" width="21%" height="99" alt="Coolest Wallpapers" border="0"></a>
            </p>


        </div>
    </div>



</div>
{WRAPPER_END}
