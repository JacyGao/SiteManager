<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiteTitle | Chat Portal</title>

    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://themextemplates.com/demo/lovestory/wp-content/themes/lovestory/js/html5.js"></script>
    <![endif]-->

    <meta name='robots' content='noindex,nofollow' />
    <link rel='stylesheet' id='woocommerce_frontend_styles-css'  href='{DocumentRoot}/css/{ProductPath}/woocommerce.css?ver=3.5.2' type='text/css' media='all' />
    <link rel='stylesheet' id='colorbox-css'  href='{DocumentRoot}/css/{ProductPath}/colorbox.css?ver=3.5.2' type='text/css' media='all' />
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/style.css">
    <script type='text/javascript' src='{DocumentRoot}/css/{ProductPath}/js/jquery.js?ver=1.8.3'></script>
    <script type='text/javascript' src='{DocumentRoot}/css/{ProductPath}/js/comment-reply.min.js?ver=3.5.2'></script>
    <script type='text/javascript' src='{DocumentRoot}/css/{ProductPath}/js/jquery.hoverIntent.min.js?ver=3.5.2'></script>
    <script type='text/javascript' src='{DocumentRoot}/css/{ProductPath}/js/jquery.colorbox.min.js?ver=3.5.2'></script>
    <script type='text/javascript' src='{DocumentRoot}/css/{ProductPath}/js/jquery.placeholder.min.js?ver=3.5.2'></script>
    <script type='text/javascript' src='{DocumentRoot}/css/{ProductPath}/js/jquery.themexSlider.js?ver=3.5.2'></script>
    <script type='text/javascript' src='{DocumentRoot}/css/{ProductPath}/js/jquery.interface.js?ver=3.5.2'></script>
    <meta name="generator" content="WordPress 3.5.2" />
    <link rel="shortcut icon" href="{DocumentRoot}/css/{ProductPath}/images/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/base.css">

    <script type="text/javascript">
    WebFontConfig = {google: { families: [ "Montserrat","Open Sans" ] } };
    (function() {
        var wf = document.createElement("script");
        wf.src = ("https:" == document.location.protocol ? "https" : "http") + "://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js";
        wf.type = "text/javascript";
        wf.async = "true";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(wf, s);
    })();
    </script>

    <!-- WooCommerce Version -->
    <meta name="generator" content="WooCommerce 2.0.12" />

    <style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
</head>

<body class="page page-id-63 page-template page-template-template-profiles-php">
<div class="site-wrap">
    <div class="header-wrap">
        <header class="site-header container">
            <div class="site-logo left">
                <a href="{DocumentRoot}/{ProductPath}/index/{Country}/{Keyword}" rel="home">
                    <img src="/custom/images/logo.png" alt="Chat Portal" />
                </a>
            </div>
            <!-- /logo -->
            <?php if($IsLoggedIn){ ?>
            <div class="header-options">
                <a href="{DocumentRoot}/{ProductPath}/sign_out/{Country}/{Keyword}" class="button secondary">Sign Out</a>
                <a href="{DocumentRoot}/{ProductPath}/member/{Country}/{Keyword}" class="button">My Profile</a>
            </div>

            <?php }else{ ?>
            <div class="header-options">
                <a href="#" class="button secondary header-login-button">Sign In</a>
            </div>
            <?}?>
            <!-- /options -->
            <nav class="header-menu right">
                <div class="menu">
                    <ul id="menu-main-menu" class="menu">

                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-71"><a href="{DocumentRoot}/{ProductPath}/index/{Country}/{Keyword}">Home</a></li>

                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-71"><a href="{DocumentRoot}/{ProductPath}/about/{Country}/{Keyword}">About</a></li>
                    </ul>
                </div>

                <div class="mobile-menu hidden">
                    <div class="select-field">
                        <span></span>
                        <select><option value="{DocumentRoot}/{ProductPath}/index/{Country}/{Keyword}">Home</option><option value="{DocumentRoot}/{ProductPath}/about/{Country}/{Keyword}">About</option></select>
                    </div>
                </div>
            </nav>
            <!-- /menu -->
        </header>
        <!-- /header -->