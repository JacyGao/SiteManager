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



<p>{WRAPPER_START} </p>
<table width="90%" border="0" align="center" class="gameszw"> 
    <tr>
        <td align="right" class="logo">
            <img src="{DocumentRoot}/css/{ProductPath}/images/header_mobilemojo.jpg" alt="Mobilemojo" />
        </td>
    </tr>
  <tr>
    <td align="center"><img class="body-image" src="{DocumentRoot}/css/{ProductPath}/images/musiczw.jpg" /></td>
  </tr>
  <tr>
    <td><form method="post" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top" align="center">

                <p align="center" style="font-size:14px; font-weight:bold;">

                    Enter your mobile number:<br />
                    <input type="text" id="mobile" name="mobile" size="25" required 
                           pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 45px;" maxlength="10"><br />

                    <!-- <div>{TermsCheckbox}</div> -->

                </p>
                <p align="center"><input class="button" type="image" src="{DocumentRoot}/css/{ProductPath}/images/btn_down.png" height="50" width="221"><br/>

                <font class="pricing">
                    Subscribe $0.25 x 4 per week Mobilemojo
                </font>                    

                </p></tr>
    </table>
</form>
    </td>
  </tr>
    <tr><td><div class="footer">

                <strong>Terms & Conditions:</strong>
                {Terms_And_Conditions}

                <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
            </div></td></tr>

</table>


{WRAPPER_END}
