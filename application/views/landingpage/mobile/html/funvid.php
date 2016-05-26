<?
$kw = strtoupper($this->uri->segment(4));
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



<p>{WRAPPER_START} </p>
<table width="90%" border="0" align="center">
  <tr>
    <td align="center"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/header_hot.jpg"  width="45%"/></td>
  </tr>
  <tr>
    <td align="center">
        <h1>Not a Member?</h1>
        <h3 style="text-align:center;">
    SMS <font color="#5fa20f"> <?php echo $kw; ?> </font>to <font color="#5fa20f">{Shortcode}</font></h3></td>
  </tr>
  <tr>
    <td align="center">
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview.jpg" width="19%" border=0 alt="Video Preview"></a>
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview1.jpg" width="19%" border=0 alt="Video Preview"></a><br />
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview2.jpg" width="19%" border=0 alt="Video Preview"></a>
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview3.jpg" width="19%" border=0 alt="Video Preview"></a><br />
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview4.jpg" width="19%" border=0 alt="Video Preview"></a>
        <a href="" style="color: #000000; font-weight: bold;"><img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/previews/preview5.jpg" width="19%" border=0 alt="Video Preview"></a><br />

    </td>
  </tr>
    <tr>
        <td align="center">OR <br /><h1>Enter your mobile number below</h1></td>
    </tr>

  <tr>
    <td>
        <form method="post" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fc7677">
        <tr>
            <td align="center" colspan="2">
                <h1>Not a Member?</h1>
                <h3 style="text-align:center;">
                    SMS <font color="#000000"> <?php echo $kw; ?> </font>to <font color="#000000">{Shortcode}</font></h3>
            <br/>
                OR
                <p align="center"  > Enter your mobile number and click <br/ >GET IT NOW and GET YOUR  BONUS HOT VIDEOS</p>
            </td>
        </tr>
                <td align="center">
                <img src="{DocumentRoot}/css/{ProductPath}/images/clicksms/badge.jpg" alt="" width="75%" />
                </td>
            <td height="280" valign="top" align="center">

                <p align="center" style="font-size:14px; font-weight:bold;">



                    <span style="font-size:11px; color:#999999;">(format eg.{MobileExample} <!--{MobileExample}-->)</span>

                    <br>
                    <input type="text" id="mobile" name="mobile" size="25" required placeholder="07XXXXXXXXXX"
                           pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 45px;" maxlength="10"><br />


                    <!-- <?=$SelectNetwork?> -->


                    <!-- <div>{TermsCheckbox}</div> -->

                </p>
                <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/cmd_Sub1.png" / height="50" width="170"></p></td>
        </tr>
    </table>
</form></td>
  </tr>

</table>

<div class="footer">
    <strong>Terms & Conditions:</strong>
    {Terms_And_Conditions}

    <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
</div>

{WRAPPER_START}
