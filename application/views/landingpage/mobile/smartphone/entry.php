<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jhonny
 * Date: 24/07/13
 * Time: 17:36
 * To change this template use File | Settings | File Templates.
 */


$url = $_SERVER["REQUEST_URI"];
$tokens = explode('/', $url);
$page=$tokens[3];
$rest = substr($page, 0, 2);
$page = $rest;
$text = "For your chance to win an iPad mini
            and Subscribe to get the best Games and Music for R5/day on your phone";


?>
<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=2.0"  />
    <!-- Included CSS Files (Uncompressed) -->
    <!--
    <link rel="stylesheet" href="stylesheets/foundation.css">
    -->
    <!-- Included CSS Files (Compressed)
    <link rel="stylesheet" href="/foundation/stylesheets/foundation.min.css">
    <link rel="stylesheet" href="/foundation/stylesheets/app.css">
    -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />    <title></title>
    <link href="{DocumentRoot}/css/{ProductPath}/images/ipad/css/base.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="{DocumentRoot}/css/{ProductPath}/images/ipad/css/media.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="{DocumentRoot}/css/{ProductPath}/images/ipad/css/ipad.css" media="screen" rel="stylesheet" type="text/css" />
    <script>
        function Minimum(obj,min){
            if (obj.value.length<min) alert('Please Enter Correct Mobile Number');
        }
    </script>
</head>
<body class="page_entry">
<div class="app-container">
    <div class="row">
        <div class="twelve columns legal-text ">
            <p class="hide-for-small"> </p>
            <small class="show-for-small"> </small>
        </div>
    </div>
    <div class="row top-image">
        <div class="twelve columns top-image-container">
            <div class="hide-for-small" >
                <img class="show-for-landscape" src="{DocumentRoot}/css/{ProductPath}/images/ipad/header_normal.jpg">
            </div>
            <div class="show-for-small" >
                <img class="show-for-landscape" src="{DocumentRoot}/css/{ProductPath}/images/ipad/tiny-header-ani.gif">
            </div>
            <img class="show-for-portrait" src="{DocumentRoot}/css/{ProductPath}/images/ipad/header-portrait.jpg">
        </div>
    </div>
    <div class="row gray-area">
        <div class="twelve columns centered">
            <div class="row">
                <div class="twelve columns" >
                    <h2>
                        <span>Enter your mobile number</span>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="twelve columns centered">
                    <form method="POST" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" name="FrontPage_Form1" target="_self" onsubmit="return ValidateForm(this);">

                        <input type="text" id="mobile" name="mobile" maxlength="10" required  size="20" pattern="\d+" onblur="Minimum(this,10);"/>
                        <div class="submitButton show-for-large-up">
                            <input id="submitButtonLsLarge" name="submitForm" class="show-for-landscape" type="submit" value="" />
                            <input id="submitButtonPrLarge" name="submitForm" class="show-for-portrait" type="submit" value="" />
                        </div>
                        <div class="submitButton show-for-medium hide-for-large-up">
                            <input id="submitButtonLsMedium" name="submitForm" class="show-for-landscape" type="submit" value="" />
                            <input id="submitButtonPrMedium" name="submitForm" class="show-for-portrait" type="submit" value="" />
                        </div>
                        <div class="show-for-small">
                          <!--
                            <input id="submitButtonLsSmall" name="submitForm" class="show-for-landscape" type="submit" value="" />
                            <input id="submitButtonPrSmall" name="submitForm" class="show-for-portrait" type="submit" value="" />
                       -->
                            </div>


                    </form>
                </div>
            </div>
        </div>
        <div class="row disclaimer-container">
            <div class="twelve columns centered compliance">
                <?php if($page == "sa"):?>
                    <p style="text-align:center; font-size: 14px;">
                        <? echo $text;?>
                    </p>

                    <strong>Terms & Conditions:</strong>
                    {Terms_And_Conditions}
                <?php else: ?>
                    <strong>Terms & Conditions:</strong>
                    {Terms_And_Conditions}
                <?php endif;?>
            </div>
            <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>

        </div>
    </div>
</div>
<!-- pixels here -->
<div id="pixel">
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var inputSet = $('.submitButton').children('input');
        $('.submitButton').removeClass('show-for-large-up');
        inputSet.val('Continue');
        //$('#submitButtonLsSmall, #submitButtonPrSmall').addClass('round button');
        $('#submitButtonLsSmall, #submitButtonPrSmall').val('Continue');
        $('#frmShopSubmit .show-for-small').remove();
        $('#submitButtonPrLarge, #submitButtonPrSmall, #submitButtonLsMedium, #submitButtonPrMedium').remove();
        $('').remove();
    });    </script>

</body>
</html>
