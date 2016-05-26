<html>
<head>
    <link rel="stylesheet" href="/css/portal/web/style.css" type="text/css" /> <!-- the main structure and main page elements style -->

    <link rel="stylesheet" href="/css/portal/web/js/js.css" type="text/css"  /> <!-- styles for the various jquery plugins -->
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="/css/portal/web/ie7.css" />
    <![endif]-->

    <!--[if IE 8]>
    <link rel="stylesheet" type="text/css" href="/css/portal/web/ie8.css" />
    <![endif]-->

    <!--[if gt IE 8]>
    <link rel="stylesheet" type="text/css" href="/css/portal/web/ie9.css" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="/custom/portal_web.css" />

    <script>
        $(function(){
            $(':input[placeholder]').placeholder();
        });
    </script>
</head>
<body style="margin:0px; padding:0px; background:none; height:100%; overflow:hidden;">
<div id="not_a_member" class="container" style="
border: 0px solid #E0E0E0;
background: white;
padding: 0px 0px 0px 0px;
color: #333;
text-transform: uppercase;
font-size: 18px;
font-family: BebasNeueRegular, Arial, Sans-Serif;
text-align: center;">
<form action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}/" method="post">
    <h2>JOIN NOW</h2>

    <div class="comment-form-mobile">
        <div class="input-wrapper">
            <div class="shadow">
                <div class="icon">
                    <span style="position: relative;">

                    <input name="mobile" type="text" value="" placeholder="Enter mobile">
                    </span>
                </div>
            </div>
        </div>
    </div>

    <? if($SelectNetwork): ?>
    <div class="comment-form-network">
        <div class="input-wrapper">
            <div class="shadow">
                <div class="icon">
                    <?=$SelectNetwork?>
                </div>
            </div>
        </div>
    </div>
    <? endif; ?>


    <? if($Login_Flow == LOGIN_FLOW_GOT_PIN): ?>
    <div class="comment-form-pin" style="margin-top:5px;">
        <div class="input-wrapper">
            <div class="shadow">
                <div class="icon">
                    <input name="pin" type="text" value="" maxlength="4" placeholder="Enter Your NEW PIN">
                </div>
            </div>
        </div>
    </div>
    <? endif; ?>

    <? if($TermsCheckbox): ?>
    <div class="clearer"></div>
    <div style="float:left; margin-bottom:15px;">
        {TermsCheckbox}
    </div>
    <? endif; ?>
    <div class="clearer"></div>
    <div style="margin-top:5px;">
        <button class="button_link rust large_button" style="opacity: 0.8;"><span>Continue</span></button>
    </div>
    <small>(Example: {MobileExample}) <? if($Allow_MO_Optin) echo "or SMS {Keyword} to {Shortcode}"; ?></small>
</form>
</div>
</body>
</html>