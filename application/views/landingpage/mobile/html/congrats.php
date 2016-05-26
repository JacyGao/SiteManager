
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

    <div class="logo" align="center">
        <img src="{DocumentRoot}/css/{ProductPath}/images/win/header_log.jpg"  width="100%" >
    </div> <!-- logo -->



    <div align="center" class="container" style="font-size: 20px; font-family: Arial, Helvetica, sans-serif; ">

        Correct!<br />
        Please SMS <font style="color: orange;">{Keyword} </font> to <font style="color: orange;">{Shortcode} </font> <br /> complete your iPhone5 competition <br />enrty NOW!<br /> enter your number below
    </div><!-- first part -->


    <div class="clear"></div>

    <div class="mwhite">


        <div  align="center">
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
        <div class="container" style="background-color:#FFF; text-align:center;font-size: 20px; font-family: Arial, Helvetica, sans-serif;">

            You will also get 1000 scredits for <br /><font style="color: blue;">Ringtones</font>, <font style="color: green;">Wallpapers</font>, <font style="color: #ff8c00;">Sound Effects</font>, <font style="color: #b22222;">Videos </font>&amp; <font style="color: #6a5acd;">games</font>


        </div>
        <div class="clear" style="background-color:#FFF;"></div>
        <div class="container" align="center" >
            <img src="{DocumentRoot}/css/{ProductPath}/images/win/iphone5.jpg"   />
        </div>
    </div>



</div>

<div class="footer">
    <strong>Terms & Conditions:</strong>
    <p align="center">
    {Terms_And_Conditions}
    </p>

    <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
</div>

{WRAPPER_END}
