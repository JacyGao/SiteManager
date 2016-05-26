<?
$smslink = "sms:{Shortcode}?body={Keyword}";
$kw= "{Keyword}";
$msg= "SMS ".$kw." to {Shortcode}";
?>
<!-- code from taken mint/index.php -->
<!DOCTYPE html><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
    <!-- Specific Document/Page Tittle as Consumer requested -->
    <title>

        {TITLE}

    </title>
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/mobile.css">
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/mobile.css">
    <link rel="icon" href="../../images/favicon.ico">

    <div id="sdt-js"></div>
    <script type="text/JavaScript" src="/custom/js/games/inmobi_landing.js"></script>
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

<div class="wrap">

    <div class="logo">
        <img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/header_hot.jpg"  width="100%"/>
    </div> <!-- logo -->



    <div>

        <h3 style="text-align:center;">
            SMS <font color="blue"> <?php echo $kw; ?> </font>to <font color="blue">{Shortcode}</font></h3>
    </div><!-- first part -->
    <div class="clear"></div>
    <div class="container">
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview1.jpg" width="49%" border=0 alt="Video Preview"></a><br />
    </div>

    <div class="container">
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview2.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview3.jpg" width="49%" border=0 alt="Video Preview"></a><br />
    </div>
    <div class="container">
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview4.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview5.jpg" width="49%" border=0 alt="Video Preview"></a><br />
    </div>

    <div class="clear"></div>

    <div id="tail">
        <font style="font-size:18px; font-family:Verdana, Geneva, sans-serif; font-weight:bold;">Not a Member?<br /></font>
        SMS <font color="blue"> <?php echo $kw; ?> </font>to <font color="blue">{Shortcode}</font><br/>
        OR<br />
        <font style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;" >Enter your mobile number and click Get it Now<br/ > </font>
        <div id="left">
            <img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/badge.png" alt="" width="80px" />
        </div>
        <div id="right">
            <br />
            <a href="<?php echo $smslink ?>" style="color: #000000;" class="tn">

                <form method="post" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">

                    <span style="font-size:11px; color:#000000;">
                      (format eg.{MobileExample} <!--{MobileExample}-->)</span>
                    <br />
                    <input type="text" id="mobile" name="mobile" size="25" required placeholder="07XXXXXXXXXX"
                           pattern="\d+" style="text-align: left; font-size: 15px; padding-left: 10px; width:140px; height: 30px;" maxlength="10" /><br />

                    <!-- <?=$SelectNetwork?> --> <!-- <div>{TermsCheckbox}</div> -->

                    <input type="image" src="{DocumentRoot}/css/{ProductPath}/images/cmd_Sub1.png"  height="50" width="120" / >

                </form>
                <br />


        </div>


    </div>
    <div class="clear"></div>
    <div class="container">
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview6.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview7.jpg" width="49%" border=0 alt="Video Preview"></a><br />
    </div>
    <div class="container">
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview8.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview9.jpg" width="49%" border=0 alt="Video Preview"></a><br />
    </div>
    <div class="container">
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview10.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview11.jpg" width="49%" border=0 alt="Video Preview"></a>
    </div>
    <div class="footer">
        <strong>Terms & Conditions:</strong>
        {Terms_And_Conditions}

        <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
    </div>
</div>



{WRAPPER_END}
