<?
$smslink = "sms:{Shortcode}?body={Keyword}";

$kw1= $this->uri->segment(6);
$kw= $this->uri->segment(4);
$msg= "SMS ".$kw." to {Shortcode}";
if ($kw1 == 'mint')
{
    $text="Click here get the best Kenyan Games, Ringtones, Sound Effects, Wallpapers & Videos
    <br/>with 1000 free credits";
}
else
{
    $text="Get the best Kenyan Games, Ringtones, Sound Effects, Wallpapers & Videos
    <br />
    with 1000 free credits. Ksh 30 to join and then Ksh 30 4x/week";
}?>
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
        <img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/header_bg.jpg"  width="100%" >
    </div> <!-- logo -->



    <div align="center" class="container">

        <?php if($Signup_Flow == SUBSCRIBE_FLOW_CLICK): ?>
        <h3 style="text-align:center;">
            <? printf('<%1$s style="text-align:center";>
                <a href="%2$s" style="color: #000000; font-weight: bold;">%3$s</a></%1$s>', "h3", $smslink,$msg); ?>
        </h3>
        <p>
            <span style="font-size:14px; color: #000000; font-weight: bold; text-align:center;">
            <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;">get your 1000 free credits now. Ksh 30 to join and then Ksh 30 <br/ >4x/week
    </div><!-- first part -->
    <div align="center" class="container">
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;">
            To get your BONUS HOT VIDEOS<br />or<br />Click here

        </a><br /><br />
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview1.jpg" width="49%" border=0 alt="Video Preview"></a><br />
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview2.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview3.jpg" width="49%" border=0 alt="Video Preview"></a><br />
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview4.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview5.jpg" width="49%" border=0 alt="Video Preview"></a><br />
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview6.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview7.jpg" width="49%" border=0 alt="Video Preview"></a><br />
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview8.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview9.jpg" width="49%" border=0 alt="Video Preview"></a><br />
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview10.jpg" width="49%" border=0 alt="Video Preview"></a>
        <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview11.jpg" width="49%" border=0 alt="Video Preview"></a>
    </div><!-- second part -->


    <div class="clear"></div>

    <div class="" style="background-color:#fc7677">

        <div id="left" align="left">
            <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/textme.jpg" alt="" width="100%" /></a>
        </div> <!-- left -->
        <div id="right" align="center">
            <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;">AND sms  {Keyword} to {Shortcode} </a>
            <br />
            <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;">
                get your 1000 free credits now. Ksh 30
                <br/>to join and then Ksh 30 4x/week
            </a>
            <br />
            <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;">TO</a>
            <br /><a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;">GET YOUR 500 FREE CREDITS</a><br />
            <a href="<?php echo $smslink ?>" style="color: #000000; font-weight: bold;">TO<br/>

                GET YOUR BONUS VIDEOS<br/>

                AND FREE CREDITS NOW!<br/>

                you must be over 18!</a><br/>
            <a href="<?php echo $smslink ?>">
                <img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/18.jpg">
            </a>
        </div><!-- right -->
        <div class="clear" style="background-color:#FFF;"></div>



    </div>
</div>



</div>
<?endif?>

<div class="footer">
    <strong>Terms & Conditions:</strong>
    <p align="center">
        {Terms_And_Conditions}
    </p>

    <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
</div>

{WRAPPER_END}
