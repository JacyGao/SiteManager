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



<p>{WRAPPER_START} </p>
<table width="90%" border="0" align="center">
  <tr>
    <td align="center"><img src="/custom/images/header.jpg" width="100%" height=""></td>
  </tr>
    <?/*
  <tr>
    <td align="center"><h3 style="text-align:center;">
    SMS <font color=red> {Keyword} </font>to <font color=red>{Shortcode}</font></h3></td>
  </tr>
*/?>
  <tr>
      <td align="center" style="color:red; font-size:24px; font-weight:bold;">To get your Unlimited Games </td>
  </tr>
  <tr>
    <td align="center"><img src="/custom/images/games.jpg" width="100%" height=""></td>
  </tr>
  <tr>
    <td><form method="post" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="280" valign="top" align="center">

                <p align="center" style="font-size:14px; font-weight:bold;">

                    Enter your mobile number:<br />
                    <span style="font-size:11px; color:#999999;">(format eg.{MobileExample} <!--{MobileExample}-->)</span>

                    <br>
                    <input type="text" id="mobile" name="mobile" size="25" required placeholder="07XXXXXXXXXX"
                           pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 45px;" maxlength="10"><br />

                    <!-- <div>{TermsCheckbox}</div> -->

                </p>
                <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/cmd_Sub1.png" / height="50" width="170"><br/>
                    <? /*<font style="text-align:center; font-size: 14px;">
                        {text}
                    </font>
                    */?>
                </p>

            </td>
        </tr>

    </table>
</form>

  </tr>
    <tr><td><div class="footer">

                <strong>Terms & Conditions:</strong>
                {Terms_And_Conditions}

                <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
            </div></td></tr>
</table>


{WRAPPER_END}

