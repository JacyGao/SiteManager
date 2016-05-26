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
</head>
<body style="margin:0px; padding:0px; background:none; height:100%; overflow:hidden;">
<div id="already_a_member" class="container" style="
border: 0px solid #E0E0E0;
background: white;
padding: 0px 0px 0px 0px;
color: #333;
text-transform: uppercase;
font-size: 18px;
font-family: BebasNeueRegular, Arial, Sans-Serif;
text-align: center;">
        <form action="{DocumentRoot}/{ProductPath}/login_form/{Country}/{Keyword}/" method="post">
            <h2>LOGIN NOW</h2>
            <div class="comment-form-mobile">
                <div class="input-wrapper">
                    <div class="shadow">
                        <div class="icon">
                            <input name="mobile" type="text" value="" placeholder="Enter mobile">
                        </div>
                    </div>
                </div>
            </div>

            <? if($Login_Flow == LOGIN_FLOW_GOT_PIN): ?>
            <div class="comment-form-pin" style="margin-top:5px;">
                <div class="input-wrapper">
                    <div class="shadow">
                        <div class="icon">
                            <input name="pin" type="text" value="" maxlength="4" placeholder="Enter Your PIN">
                        </div>
                    </div>
                </div>
            </div>
            <? endif; ?>

            <fieldset style="margin-top:5px;">
                <button class="button_link sky large_button" style="opacity: 0.8;"><span>Continue</span></button>
            </fieldset>
            <small>(Example: {MobileExample})</small>
        </form>
</div>
</body>
</html>