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


<div class="wrap" style="background-color:#000000;">

    <div class="logo" align="left">
        <img src="{DocumentRoot}/css/{ProductPath}/images/worldcla/theader.jpg" width="100%" height="">
    </div> <!-- logo -->



    <div align="center" style=" color:#CCC;">

        <small>Subscription Service: R2 per day   &nbsp;&nbsp;&nbsp; <i>T&amp;C's apply</i></small>
    </div><!-- first part -->
    <div align="center">
        <h1 style="margin:2px 5px 2px 5px; font-size: 25px;"><font color="#FFFFFF">Get Latest Music</font></h1>
    </div>
    <div align="center" style=" color:#CCC;">
        <ul >
            <li>
                Wake Me Up by Avicii Ft Aloe Blacc
            </li>
            <li>
                La La La by Naughty Boy Ft Sam Smith
            </li>
            <li>
                We Cant Stop by Miley Cyrus
            </li>
            <li>
                Come And Get It by Selena Gomez
            </li>
            <li>
                Best Song Ever by One Direction
            </li>
            </ul>

    </div>
    <!-- sec part -->


    <div class="clear"></div>

    <div>

    </div>


    <div align="center">
        <form method="post" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" align="center">

                        <p align="center" style="font-size:14px; font-weight:bold; color:#CCC;">

                            Enter your mobile number:<br />
                            <span style="font-size:11px; color:#999999;">(format eg.{MobileExample} <!--{MobileExample}-->)</span>

                            <br>
                            <input type="text" id="mobile" name="mobile" size="25" required placeholder="07XXXXXXXXXX"
                                   pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 45px;" maxlength="10"><br />

                            <!-- <div>{TermsCheckbox}</div> -->

                        </p>
                        <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/cmd_Sub1.png" / height="50" width="170"><br/>

                        </p>
                    </td>
                </tr>

            </table>
        </form>
        <div class="footer" style="color:#CCC;">

            <strong>Terms & Conditions:</strong>
            {Terms_And_Conditions}
            <p align="center" ><span>Powered by <a href="http://www.mobivate.com" target="_blank" style="color:#CCC;"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
        </div>

    </div>
</div>
{WRAPPER_START}