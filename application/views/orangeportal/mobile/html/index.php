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
            <td width="33%" height="72"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/videos"><img src="/css/{ProductPath}/images/bvids.png" width="116" height="67" /></a></td>
            <td width="34%" align="center"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/covertones"><img src="/css/{ProductPath}/images/bmusic.png" width="116" height="67" /></a></td>
            <td width="33%"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/games"><img src="/css/{ProductPath}/images/bgames.png" width="127" height="67" /></a></td>
        </tr>

    </table>
</div>

<div class="clear"></div>

<? if (($Special) && sizeof($Special) > 0){ ?>
        <p class="g1 bld center"> Featured Content </p>
        <? $i = 0; foreach ($Special as $item): 
            $item_url = "{DocumentRoot}/{ProductPath}/login/{Country}/{Keyword}/";            
        ?>
            <div<? if ($i % 3 == 0) echo "";?>>
                <div class="item-slider">
                    <table class="center W100 g6">
                        <tr>
                            <td class="W30 Left ptbl5 val_top">
                                <a href="<?=$item_url?>"
                                   class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['preview']['mobile'], 163, 109); ?></a>
                            </td>
                            <td class="Left ptbl5 val_top"><p><?=$item['title']?></p>
                                <a href="<?=$item_url?>" style=" " class="szM bld c2 g5">Get It</a>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        <? endforeach;
    } ?>

<!-- Video Section Starts-->
<!-- If there's no video contents in the database, this section will not be displayed -->
<? if (($Videos) && sizeof($Videos) > 0){ ?>

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
    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Videos" style=" " class="szM " >
        <p class="g6 bld center"> More Videos... </p>
    </a>
<? }?>
<!-- Video Section Ends-->

<!-- Covertone Section Starts-->
<!-- If there's no Covertone contents in the database, this section will not be displayed -->

<? if (($Ringtones) && sizeof($Ringtones['Covertones']) > 0){ ?>

    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Popular Music </p>
    <!-- displaying contents -->

    <? $i = 0; foreach ($Ringtones['Covertones'] as $item): ?>
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
    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Music" style=" " class="szM " >
        <p class="g6 bld center"> More Covertones... </p> </a>
<? }?>
<!-- Covertone Section Ends-->

<!-- Game Section Starts-->
<!-- If there's no Game contents in the database, this section will not be displayed -->
<? if (($Games) && sizeof($Games) > 0){ ?>

    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Popular Games </p>
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
                        <td class="Left ptbl5 val_top"><p><?=$item['title']?></p>
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Get It</a>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <? endforeach; ?>

    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Games" style=" " class="szM " >
        <p class="g6 bld center"> More games... </p>
    </a>

<? }?>
<!-- Game Section Ends-->

<!-- Info Section Starts-->
<!-- If there's no Info contents in the database, this section will not be displayed -->
<? if (isset($Infos) && sizeof($Infos) > 0): ?>

    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Popular Information </p>
    <!-- displaying contents -->

    <? $i = 0; foreach ($Infos as $item): ?>
        <div<? if ($i % 3 == 0) echo "";?>>
            <div class="item-slider">
                <table class="center W100 g6">
                    <tr>
                        <td class="W30 Left ptbl5 val_top">
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                               class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['image'], 163, 109); ?></a>
                        </td>
                        <td class="Left ptbl5 val_top"><p><?=$item['title']?></p>
                            <a href="{DocumentRoot}/{ProductPath}/info_item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Get It</a>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <? endforeach; ?>


    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/info" style=" " class="szM " >
        <p class="g6 bld center"> More information... </p>
    </a>
<? endif;?>
<!-- Info Section Ends-->
<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>

