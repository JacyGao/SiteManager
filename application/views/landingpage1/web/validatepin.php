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
    <div id="comments">

        <div class="comment-form-comment">
            <form action="{DocumentRoot}/{ProductPath}/validatepin/{Country}/{Keyword}" method="POST">


                <div style="float:left; margin-bottom:15px;">
                    <div class="label">
                        <label for="input_pin">PIN :</label>
                        <span class="required">(required)</span>

                    </div>

                    <div class="input-wrapper">

                        <div class="shadow">
                            <input type="text" name="pin" id="input_pin" class="text" value="<?php echo set_value('pin'); ?>">
                        </div>

                    </div>
                    <?php echo form_error('pin', '<div class="error">', '</div>'); ?>
                </div>


                <br class="clearer" />

                <div style="float:left; margin-bottom:15px;">
                    <button class="button_link blue large_button" style="opacity: 0.8;"><span>Continue</span></button>
                </div>

            </form>

            <br class="clearer">
        </div>

    </div>
</body>
</html>