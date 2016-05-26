<!--
Website: Mintmonkey

-->
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/{ProductPath}/style.css" type="text/css" media="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{TITLE}</title>
    <meta http-equiv="Cache-Control" content="must-revalidate" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php if(!$IsLoggedIn): ?>
<!-- Begin membership area -->
    <?if(($Allow_Login) && ($Allow_Signup)){?>
<div class="header">
    <table class="center W100 g1">
        <tr>
            <td width="25%" class="Center W15">&nbsp;</td>
            <td width="25%" class="Center W15">&nbsp;</td>

            <?php foreach ($MainMenu as $link): ?>
            <td class="Center W15"><img width="25" height="25"  src="/css/{ProductPath}/images/<?= $link['label'] ?>.png" alt=""/>

                <p><a class="ac" href="<?= $link['url'] ?>"><?=$link['label']?></a></p></td>
            <?php endforeach; ?>
        </tr>
    </table>
</div>
        <?}?>
<?php endif; ?>
<?php if($IsLoggedIn): ?>
<div class="header">
<table class="center W100 g1">
    <tr>
        <td width="25%" class="Center W15">&nbsp;</td>
        <td width="25%" class="Center W15">&nbsp;</td>
    <?php foreach ($LogoutMenu as $link): ?>
            <td class="Center W15"><img width="25" height="25"  src="/css/{ProductPath}/images/<?= $link['label'] ?>.png" alt=""/>
            <p><a class="ac" href="<?= $link['url'] ?>"><?=$link['label']?></a></p></td>
        <?php endforeach; ?>
    </tr>
</table>
</div>
<span style="font-size:12px; margin-top:5px;margin-left:10px; color:#bc8f8f;">You have {CreditsAvailable} credits</span>
    <?php endif; ?>
<div class="sub-header">
    <div class="wrap">
        <!-- Logo -->
        <div class="logo">
            <table width="100%" border="0">
                <tr>
                    <td align="center"><a href="{DocumentRoot}/{ProductPath}/index/{Country}/{Keyword}"><img src="/custom/images/header.jpg" width="100%" height="" title="logo"/></a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="clear"></div>

<!-- top menu -->
<!-- if user is logged in, hide top menu-->

<div class="header">
    <table class="center W100 g1">
        <tr>
            <?php foreach($SecondMenu as $link): ?>
            <td class="Center W15">
                <img width="25" height="25" src="/css/{ProductPath}/images/<?=$link['label']?>.png" alt="" />
                <p>
                    <a class="ac" href="<?=$link['url']?>"><?=$link['label']?></a>
                </p>
            </td>
            <?php endforeach; ?>
        </tr>
    </table>
</div>


<div class="clear"></div>