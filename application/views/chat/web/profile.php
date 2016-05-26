<?php require_once(dirname(__FILE__) . "/inc_head.php");?>

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

    <!-- /forms -->
    <div class="header-content-wrap">
        <div class="header-content container">
            <h1 class="page-title">Profile</h1>
        </div>
    </div>
    <!-- /content -->
</div>
<div class="content-wrap">
<section class="site-content container clearfix"><aside class="column threecol">
    <div class="profile-preview">
        <div class="profile-image">
            <img src="/custom/images/{Imageurl}" class="avatar" width="200" alt="" />
        </div>
        <div class="profile-options popup-container clearfix">
            <div class="profile-option">
                <a href="#" title="Live Chat" class="icon-comment"> Text Me!</a>
            </div>
        </div>
    </div></aside>
<div class="full-profile fivecol column">
    <div class="section-title separated-title">
        <h2>
            <span title="Offline" class="profile-status offline"></span>{Name}		</h2>
    </div>
    <table class="profile-fields">
        <tbody>
        <tr>
            <th>Gender</th>
            <td>{Gender}</td>
        </tr>
        <tr>
            <th>Age</th>
            <td>{Age}</td>
        </tr>
        <tr>
            <th>State</th>
            <td>{State}</td>
        </tr>
        <tr>
            <th>City</th>
            <td>{City}</td>
        </tr>
        </tbody>
    </table>
    <div class="profile-description">
        <h2>To Chat, Enter your mobile number below:</h2>
        <form method="POST" action="{DocumentRoot}/{ProductPath}/validate/{Country}/{Keyword}">
        <p align="center"><input type="text" name="mobile" placeholder="647XXXXXXX"></p>
        <p align="center">$1.50 per message</p>
        <p align="center"><a href="#" class="button submit-button">Chat Now</a></p>
        </form>
    </div>
</div>
<aside class="sidebar fourcol column last">
<div class="widget clearfix">
    <h4 class="widget-title clearfix">
        <span class="left">Photos</span>
		<span class="widget-options">
					</span>
    </h4>
    <div class="themex-slider carousel-slider">
        <ul>
            <li class="clearfix">
                <div class="fourcol static-column ">
                    <div class="profile-preview widget-profile">
                        <div class="profile-image popup-container">
                            <a href="/custom/images/hellen.jpg" class="colorbox" data-group="photos"><img src="/custom/images/{Imageurl}" class="fullwidth" alt="" /></a>
                            <div class="popup hidden">
                                <ul class="error">
                                    <li>Sign in to view full size photos</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
    <div class="widget clearfix"></div>
</aside>
</section>
<!-- /site content -->
<?php require_once(dirname(__FILE__) . "/inc_foot.php");?>