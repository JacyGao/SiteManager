<?php require_once(dirname(__FILE__) . "/inc_head.php");?>

<!-- signup section not needed at the moment
    <div class="header-form-wrap container">
        <div class="header-form header-login-form clearfix">
            <form class="ajax-form formatted-form" action="http://themextemplates.com/demo/lovestory/wp-admin/admin-ajax.php" method="POST">
                <div class="message"></div>
                <div class="field-wrap">
                    <input type="text" name="user_login" value="demo" class="static" />
                </div>
                <div class="field-wrap">
                    <input type="password" name="user_password" value="demo" class="static" />
                </div>
                <a href="#" class="button submit-button">Sign In</a>
                <a href="#" class="button secondary header-password-button" title="Password Recovery">
                    <span class="button-icon icon-lock nomargin"></span>
                </a>
                <input type="hidden" name="user_action" value="login_user" />
                <input type="hidden" class="nonce" value="faea368169" />
                <input type="hidden" class="action" value="themex_update_user" />
            </form>
        </div>
        <div class="header-form header-password-form clearfix">
            <form class="ajax-form formatted-form" action="http://themextemplates.com/demo/lovestory/wp-admin/admin-ajax.php" method="POST">
                <div class="message"></div>
                <div class="field-wrap">
                    <input type="text" name="user_email" value="Email" />
                </div>
                <a href="#" class="button submit-button">Reset Password</a>
                <input type="hidden" name="user_action" value="reset_password" />
                <input type="hidden" class="nonce" value="faea368169" />
                <input type="hidden" class="action" value="themex_update_user" />
            </form>
        </div>
    </div>
    -->

<!-- /forms -->
<div class="header-content-wrap">
    <div class="header-content container">
        <h1 class="page-title">Sorry</h1>
    </div>
</div>
<!-- /content -->
</div>
<div class="content-wrap">
    <div style="text-align:center; margin-top:50px;">
        <h2>Sorry</h2>
        {ErrorMessage}
        <br />
        <a href="javascript:history.go(-1);">Click here to return to previous page.</a>
    </div>
    <!-- /site content -->
<?php require_once(dirname(__FILE__) . "/inc_foot.php");?>