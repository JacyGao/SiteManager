
<!-- code from taken mint/index.php -->
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
    <!-- Specific Document/Page Tittle as Consumer requested -->
    <style>
        #OuterWrap
        {
            margin: 0 auto;
            padding: 0;
            text-align: left;
        }

        #InnerWrap
        {
            margin: 0 auto;
            /*Width: 230px;*/
            width: auto;
            text-align: left;
        }
    </style>
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

<div id="OuterWrap">
    <div id="InnerWrap">
        <form name="aspnetForm" method="post" action="" id="aspnetForm">

            <div align="center" >
                <img src="{DocumentRoot}/css/{ProductPath}/images/win/header_log.jpg" alt="headerImage" width="54%" style="width:50%;border-width:0px;border: solid 0px #000000;" />
            </div> <? /* logo */?>


            <div  align="center">

                <input type="image" name="imgBannerButton" src="{DocumentRoot}/css/{ProductPath}/images/win/WinaniPhone_noTCs.gif" alt="ImageBanner" style="width:60%;border-width:0px;border: solid 0px #000000;" />
            </div> <? /* banner images */?>
            <div>
                <table width="100%">
                    <tr>
                        <td align="center">
                            <span style="text-align:left;">Simply Answer the Question Below:</span>
                        </td>
                        <td width="15.0em">
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <span  style="text-align:left;">Q: Who makes the iPhone 5?  </span>
                        </td>
                        <td width="15.0em">
                        </td>
                    </tr>
                </table>
            </div><? /* Question Table */?>
            <div align="center">

                <a href="congrats.php"><img type="image" name="appleButton" value="correct" src="{DocumentRoot}/css/{ProductPath}/images/win/ButtonApple.gif" alt="ImageBanner" style="width:50%;border-width:0px;border: solid 0px #000000;" />
            </a>
            </div><? /* Btn Apple */?>
            <div align="center">
                <a href=""><img type="image" src="{DocumentRoot}/css/{ProductPath}/images/win/ButtonSony.gif" onclick="alert('Wrong answer! Please try again!')" alt="ImageBanner" style="width:50%;border-width:0px;border: solid 0px #000000;" /></a>
            </div><? /* Btn Sony */?>
        </form>
    </div>
</div> <? /* outer wrapper end */?>


<div class="footer">
    <strong>Terms & Conditions:</strong>
    {Terms_And_Conditions}

    <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
</div>

{WRAPPER_END}
