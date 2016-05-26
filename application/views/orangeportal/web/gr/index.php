<?php
require_once(dirname(__FILE__) . "/inc_head.php");
require_once(dirname(__FILE__) . "/inc_signup_section.php");
?>

<p class="g1 center bld">Κορυφαίες λήψεις </p>

<div class="clear"></div>

<!-- Icons -->
<div class="image-slider">
    <table width="100%" border="0">

        <tr>
            <td width="33%" height="72"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/videos"><img src="/css/{ProductPath}/images/bvids.png" width="116" height="67" /></a></td>
            <td width="34%" align="center"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/covertones"><img src="/css/{ProductPath}/images/bmusic.png" width="116" height="67" /></a></td>
            <td width="33%" align="right"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/games"><img src="/css/{ProductPath}/images/bgames.png" width="127" height="67" /></a></td>
        </tr>

    </table>
</div>

<div class="clear"></div>

<!-- Video Section Starts-->
<!-- If there's no video contents in the database, this section will not be displayed -->
<? if (($Videos) && sizeof($Videos) > 0){ ?>

    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Δημοφιλεστέρα βίντεο </p>
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
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Αποκτήστε το</a>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <? endforeach; ?>
    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Videos" style=" " class="szM " >
        <p class="g6 bld center"> Περισσότερα βίντεο... </p>
    </a>
<? }?>
<!-- Video Section Ends-->

<!-- Covertone Section Starts-->
<!-- If there's no Covertone contents in the database, this section will not be displayed -->

<? if (($Ringtones) && sizeof($Ringtones['Covertones']) > 0){ ?>

    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Δημοφιλέστερη μουσική </p>
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
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Αποκτήστε το</a>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <? endforeach; ?>
    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Music" style=" " class="szM " >
        <p class="g6 bld center"> περισσότερα covertones... </p> </a>
<? }?>
<!-- Covertone Section Ends-->

<!-- Game Section Starts-->
<!-- If there's no Game contents in the database, this section will not be displayed -->
<? if (($Games) && sizeof($Games) > 0){ ?>

    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Δημοφιλεστέρα παιχνίδια </p>
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
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Αποκτήστε το</a>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <? endforeach; ?>

    <a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Games" style=" " class="szM " >
        <p class="g6 bld center"> Περισσότερα παιχνίδια... </p>
    </a>

<? }?>
<!-- Game Section Ends-->

<!-- html5 Game Section Starts-->
<? if (($Html5_Games) && sizeof($Html5_Games) > 0){ ?>

    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> HTML5 παιχνίδι </p>
    <!-- displaying contents -->

    <? $i = 0; foreach ($Html5_Games as $item): ?>
        <div<? if ($i % 3 == 0) echo "";?>>
            <div class="item-slider">
                <table class="center W100 g6">
                    <tr>
                        <td class="W30 Left ptbl5 val_top">
                            <a href="/css/games/<?=$item['preview_url']?>/"
                               class="thumbnail darken small" title="<?=$item['title']?>">
                                <img width="163" height="109" border="0" align="absmiddle" alt="<?=$item['title']?>" src="/css/{ProductPath}/games/<?=$item['preview_url']?>.gif">
                               </a>
                        </td>
                        <td class="Left ptbl5 val_top"><p><?=$item['title']?></p>
                            <a href="/css/games/<?=$item['preview_url']?>/" style=" " class="szM bld c2 g5">παιχνίδι</a>
                        </td>
                    </tr>
                </table>
            </div>            
        </div>
    <? endforeach; ?>
<? }?>
<!-- html5 Game Section Ends-->

<!-- Info Section Starts-->
<!-- If there's no Info contents in the database, this section will not be displayed -->
<? if (isset($Infos) && sizeof($Infos) > 0): ?>

    <!-- auto bar is created depending on category-->
    <p class="g1 bld center"> Popular Information </p>
    <!-- displaying contents -->

    <? $i = 0; foreach ($Infos as $item):?>
        <div<? if ($i % 3 == 0) echo "";?>>
            <div class="item-slider">
                <table class="center W100 g6">
                    <tr>
                        <td class="W30 Left ptbl5 val_top">
                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                               class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['image'], 163, 109); ?></a>
                        </td>
                        <td class="Left ptbl5 val_top"><p><?=$item['title']?></p>
                            <a href="{DocumentRoot}/{ProductPath}/info_item/{Country}/{Keyword}/<?=$item['id']?>/" style=" " class="szM bld c2 g5">Αποκτήστε το</a>

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

