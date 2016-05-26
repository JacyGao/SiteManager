<?php
require_once(dirname(__FILE__) . "/inc_head.php");
/***********************
 * Created by Jacy Gao *
 * Date: 11/04/13      *
 * Time: 10:20 AM       *
 **********************/
?>

<!-- enter your number section-->
<section id="content-header">
    <div class="container">
        <div class="row-fluid">
            <? if(!$isLoggedIn): ?>
            <div class="span12">
                <hgroup class="content-title welcome">

                    <h1>Enter your number</h1>
                    <h2>to get <span style="font-size:17px; color:yellow;">LOVE CONTENT <br>OF THE DAY!</span></h2>
                    <br />
                    <form action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}/" method="post">
                        <input type="text" name="mobile" placeholder="Enter Mobile" style="height:30px;font-size:15pt;width:90%;"><br>
                        <br>
                        {TermsCheckbox}
                        <input type="submit" name="submit" value="GO!" style="height:25px;font-size:12pt;width:auto;"><br>
                        <span style="font-size:14px;margin-top:5px;margin-left:5px;color:#FFFFFF;">{Header_Note}</span>
                    </form>
                </hgroup>
            </div>
            <div class="span12">
                <hgroup class="fancy-headers">
                    <h1>Sign up to {TITLE}, <br>view <span style="color:yellow;"> these best content </span></h1>
                    <h2>daily:</h2>
                </hgroup>
            </div>
        </div>
    </div>
</section>

<!-- Video section -->

<section id="content-container" class="container">

    <div class="row-fluid">

        <h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/scope.jpg"> Daily love scope</h2>
        <h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/guru.jpg"> Daily love guru tip</h2>
        <h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/lovepoem.jpg"> Daily love poem</h2>
        <h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/loveis.jpg"> Love is</h2>
        <h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/attract.jpg"> Daily attract girl tip</h2>

    </div>
</section><!-- content-container -->
<? endif; ?>
<? if($isLoggedIn): ?>

<div class="span12">
    <hgroup class="fancy-headers">
        <h1>Welcome to {TITLE}, <br>Click the links below to view <span style="color:yellow;"> the love content of the day </span></h1>
    </hgroup>
</div>
</div>
</div>
</section>

<!-- Video section -->

<section id="content-container" class="container">

    <div class="row-fluid">

        <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/lovescope/"><h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/scope.jpg"> Daily love scope</h2></a>
        <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/loveguru/"><h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/guru.jpg"> Daily love guru tip</h2></a>
        <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/lovepoem/"><h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/lovepoem.jpg"> Daily love poem</h2></a>
        <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/loveis/"><h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/loveis.jpg"> Love is</h2></a>
        <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/girl/"><h2 style="color:#FFF; font-size: 15px;"><img src="/css/love/mobile/img/attract.jpg"> Daily attract girl tip</h2></a>

    </div>
</section><!-- content-container -->

<? endif; ?>
<?require_once(dirname(__FILE__) . "/inc_foot.php");?>