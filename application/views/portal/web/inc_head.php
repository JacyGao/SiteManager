{DOCTYPE}
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<head profile="http://gmpg.org/xfn/11">

    {META}

    <title>{TITLE}</title>

    <link rel="shortcut icon" href="{DocumentRoot}/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/css/{ProductPath}/web/style.css" type="text/css" />
    <link rel="stylesheet" href="/css/{ProductPath}/web/js/js.css" type="text/css"  />

    <!--[if IE 7]><link rel="stylesheet" type="text/css" href="/css/{ProductPath}/web/ie7.css" /><![endif]-->
    <!--[if IE 8]><link rel="stylesheet" type="text/css" href="/css/{ProductPath}/web/ie8.css" /><![endif]-->
    <!--[if gt IE 8]><link rel="stylesheet" type="text/css" href="/css/{ProductPath}/web/ie9.css" /><![endif]-->

    <link rel="stylesheet" type="text/css" href="/custom/{ProductPath}_web.css" />

    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js?ver=3.3.1'></script>

</head>

<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="top-menu-wrapper">
    <div class="ribbon-shadow-left">&nbsp;</div>

    <div id="top-menu">

        <div class="container mid" style="width:800px;">
            <div class="menu">
                <span style="font-size:12px; margin-top:5px;">{Header_Note}</span>
                <!--
                To be implemented:
                If this is a non-credit service, then display none;
                If this is a credit service, if users not logged in, then display none;
                                             if users already logged in, then display credits
                -->
                <?php if($IsLoggedIn): ?>
                <span style="font-size:12px; margin-top:5px;margin-left:10px; color:red;">You have {CreditsAvailable} credits</span>
                <?php endif; ?>
            </div>
        </div>


        <div id="top-widget" style="width:160px;">

            <div class="top-social" style="width:100px; text-align:right;">
                <div class="fb-like" data-href="{DocumentRoot}" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="segoe ui"></div>
            </div>
        </div>

        <br class="clearer" />

    </div>

    <div class="ribbon-shadow-right">&nbsp;</div>
</div>

<!-- everything below the top menu should be inside the page wrapper div -->
<div id="page-wrapper">

    <!--begin the main header logo area-->
    <div id="logo-bar-wrapper">
        <img src="/custom/images/header.jpg" width="100%" alt="{TITLE}">
        <!-- <div id="logo-bar"><img src="/custom/images/header.jpg" alt="header"></div> -->
        <!-- <div id="logo-bar-shadow">&nbsp;</div> -->

    </div>

    <!--begin the main manu area-->
    <div id="cat-menu" class="cat-menu">

        <a class="home-link" href="{DocumentRoot}/{ProductPath}/index/{Country}/{Keyword}/">&nbsp;</a>

        <ul id="menu-main-menu">
            <?php foreach($MainMenu as $link): ?>
            <li><a href="<?=$link['url']?>"><?=$link['label']?></a></li>
            <?php endforeach; ?>
        </ul>

        <div id="search">
            <div class="wrapper">
                <div class="inner">
                    <!-- SEARCH -->
                    <form method="get" id="searchformtop" action="{DocumentRoot}/{ProductPath}/search/{Country}/{Keyword}/">
                        <input type="text" value="search" onfocus="if (this.value == 'search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'search';}" name="s" id="s" />
                    </form>
                </div>
            </div>
        </div>

    </div>


    <br class="clearer hide-responsive-small" />
