<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>MobiGreat - Information Portal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="stylesheet" href="/css/splash/mobile/css/grid.css">
    <link rel="stylesheet" href="/css/splash/mobile/css/grid.responsive.css">
    <link rel="stylesheet" href="/css/splash/mobile/css/normalize.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pontano+Sans&subset=latin,latin-ext">
    <link rel="stylesheet" href="/css/splash/mobile/css/main.css">
    <link rel="stylesheet" href="/css/splash/mobile/css/core.css">
    <link rel="stylesheet" href="/css/info/mobile/css/color-orange.css">

    <!--[if IE 8]> <link rel="stylesheet" href="css/ie8.css"> <![endif]-->
</head>
<body class="theme-orange">

<header id="page-header">

    <div class="container mid" style="width:100%;">
    </div>

    <div class="container">
        <div class="row-fluid">
            <div class="span12">
                <img src="/custom/images/logo.jpg" width="100%" height="">

                <!--<nav id="primary-nav-mobile">
                    <form method="post" action="" name="mobile-menu">
                        <select id="mobileSelect" onchange="$(this).submit();">
                            <option value="index.html">home</option>
                            <option value="signup.html">sign up</option>
                            <option value="login.html">login in</option>
                        </select>
                    </form>
                </nav>-->
            </div>
        </div><!-- /row-fluid -->
    </div>
</header><!-- /page-header -->

<!-- enter your number section-->
<section id="content-header">
    <div class="container">
        <div class="row-fluid">
            <div class="span12">
                <hgroup class="content-title welcome">

                    <h1>If you are an existing member<br>
                        Please enter your number to login</h1>
                    <br />
                    <form action="{DocumentRoot}/{ProductPath}/do_login/{Country}/{Keyword}/" method="post">
                        <input type="text" name="mobile" placeholder="Enter Mobile" value="0" style="height:30px;font-size:15pt;width:90%;"><br>
                        e.g.0700000000
                        <br><br>
                        <input type="submit" name="submit" value="GO!" style="height:25px;font-size:12pt;width:auto;">
                    </form>
                </hgroup>
            </div>

        </div>
    </div>
</section>

<?require_once(dirname(__FILE__) . "/inc_foot.php");?>