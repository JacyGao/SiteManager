<? echo '<'.'?xml version="1.0" charset="UTF-8"?'.'>'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

    <head>
        <title>{TITLE}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
        <link rel="shortcut icon" href="{DocumentRoot}/favicon.ico" type="image/x-icon" />

        <link rel="stylesheet" href="/css/{ProductPath}/mobile/html.css" type="text/css" /> <!-- the main structure and main page elements style -->
        <link rel="stylesheet" type="text/css" href="/custom/{ProductPath}_mobile.css" />
        <link rel="stylesheet" href="/css/portal/web/js/js.css" type="text/css"  />
    </head>

    {WRAPPER_START}

    <!-- top-menu section includes header notes and fb like button -->
    <div id="top-menu-wrapper">
        <div class="ribbon-shadow-left">&nbsp;</div>

        <div id="top-menu">

            <div class="container mid" style="width:100%;">
                <div class="menu">
                    <span style="font-size:9px; margin-top:5px;">{Header_Note}</span>
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

            <br class="clearer" />

        </div>

        <div class="ribbon-shadow-right">&nbsp;</div>
    </div>

    <!-- everything below the top menu should be inside the page wrapper div -->
    <div id="page-wrapper">

        <!--begin the main header logo area-->
        <div id="logo-bar-wrapper">
            <img src="/custom/images/header_mobile.jpg" alt="{TITLE}">
            <!--
           <div id="logo-bar"></div>
           <div id="logo-bar-shadow">&nbsp;</div>-->

        </div>

        <!--begin the main manu area-->
        <div id="cat-menu" class="cat-menu">

            <a class="home-link" href="{DocumentRoot}/{ProductPath}/index/{Country}/{Keyword}/">&nbsp;</a>

            <form method="POST" action="/css/portal/mobile/direct.php">

            <select id="select-menu-main-menu" name="navigation">
                <option>Choose Content</option>
                <?php foreach ($ContentTypes as $cat=> $items): ?>
                <?if($cat=="Sound Effects"){
                    $cat = urldecode($cat);?>
                <option value="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/<?=trim($cat)?>"><?=$cat?></option>
                <? }else{ ?>
                <option value="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/<?=urlencode($cat)?>"><?=$cat?></option>
                <?}?>
                <?php endforeach; ?>
            </select>

                <div class="nav_go"><input type="submit" value="GO"></div>
            </form>

            <div id="search">
                <div class="wrapper">
                    <div class="inner">
                        <!-- SEARCH -->
                        <form method="get" id="searchformtop" action="{DocumentRoot}/{ProductPath}/search/{Country}/{Keyword}/">
                            <input type="text" value="search" name="s" id="s" />
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <br class="clearer hide-responsive-small" />

        <div id="main-wrapper">

            <div id="main-wrapper-dark">

                <div class="main-content">