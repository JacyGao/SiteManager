<?php
require_once(dirname(__FILE__) . "/inc_head.php");
require_once(dirname(__FILE__) . "/inc_signup_section.php");
?>

    <p class="g1 center bld">Most Popular Downloads </p>
		
	<div class="clear"></div>

    <!-- Icons -->
<div class="image-slider">
    <table width="100%" border="0">

        <tr>
            <td width="33%" height="72">&nbsp;<a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/videos"><img src="/css/{ProductPath}/images/bbvids.png" width="116" height="67" /></a> &nbsp;</td>
            <td width="34%" align="center">&nbsp;<a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Wallpapers"><img src="/css/{ProductPath}/images/bbbabes.png" width="116" height="67" /></a> &nbsp;</td>
            <td width="33%">&nbsp;<a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/games"><img src="/css/{ProductPath}/images/bbadult.png" width="127" height="67" /></a> &nbsp;</td>
        </tr>

    </table>
</div>

	<div class="clear"></div>

    <!-- Video Section Starts-->
    <!-- If there's no video contents in the database, this section will not be displayed -->
    <? if (sizeof($Videos) > 0): ?>

        <!-- auto bar is created depending on category-->
        <p class="g1 bld center"> Popular Videos </p>
        <!-- displaying contents -->

        <? $i = 0; foreach ($Videos as $item): ?>
            <div<? if ($i % 3 == 0) echo "";?>>
                <div class="item-slider">
                    <table class="center W100 g6">
                        <tr>
                            <td class="W30 Left ptbl5 val_top">
                                <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                                   class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['preview']['mobile'], 163, 109); ?></a>
                            </td>
                            <td class="Left ptbl5 val_top"><p><?=$item['title']?></p>
                                <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Get It</a>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        <? endforeach; ?>
    <? endif;?>
    <!-- Video Section Ends-->

    <!-- Bikini Girls Section Starts-->
    <!-- If there's no  contents in the database, this section will not be displayed -->
    <? if (sizeof($Wallpapers) > 0): ?>
    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/videos" style=" " class="szM " >
        <p class="g6 bld center"> More Sexy Videos... </p></a>
    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Popular Wallpaper </p>
    <!-- displaying contents -->

        <? $i = 0; foreach ($Wallpapers as $item): ?>
        <div<? if ($i % 3 == 0) echo "";?>>
            <div class="item-slider">
                <table class="center W100 g6">
                    <tr>
                        <td class="W30 Left ptbl5 val_top">
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                               class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['preview']['mobile'], 163, 109); ?></a>
                        </td>
                        <td class="Left ptbl5 val_top"><p><?=$item['title']?> - <?=$item['artist']?></p>
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Get It</a>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
            <? endforeach; ?>
        <? endif;?>
    <!-- Bikini Girls Section Ends-->
<? if (sizeof($Games) > 0): ?>
    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Wallpapers" style=" " class="szM " >
        <p class="g6 bld center"> More Sexy Wallpapers... </p>
    </a>
    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Popular Sexy Games </p>
    <!-- displaying contents -->

    <? $i = 0; foreach ($Games as $item): ?>
        <div<? if ($i % 3 == 0) echo "";?>>
            <div class="item-slider">
                <table class="center W100 g6">
                    <tr>
                        <td class="W30 Left ptbl5 val_top">
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                               class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['preview']['mobile'], 163, 109); ?></a>
                        </td>
                        <td class="Left ptbl5 val_top"><p><?=$item['title']?> - <?=$item['artist']?></p>
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Get It</a>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <? endforeach; ?>
<? endif;?>
<a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/games" style=" " class="szM " >
    <p class="g6 bld center"> More Sexy Games... </p></a>
    <!-- Game Section Starts-->
    <!-- If there's no Game contents in the database, this section will not be displayed -->


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>

