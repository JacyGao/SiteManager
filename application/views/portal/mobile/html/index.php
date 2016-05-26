<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

    <? if (count($Top10) > 0): ?>
    <div id="dontmiss-bar">
        <div class="ribbon-shadow-left">&nbsp;</div>
        <div id="dontmiss-header">{CountryName} TOP <?=count($Top10)?></div>
        <div id="dontmiss-arrow">&nbsp;</div>
        <div class="dontmiss" id="dontmiss">

            <? foreach ($Top10 as $item): ?>
            <div class="panel">
                <div class="image">
                    <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"><?= sprintf($item['image'], 40, 40); ?></a>
                </div>
                <div class="title">
                    <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"><?=$item['title']?></a><br/>
                    <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>">by <?=$item['artist']?></a>
                </div>
            </div>
            <? endforeach; ?>

        </div>

        <br class="clearer"/>
    </div>
    <? endif; ?>

        <?php include(dirname(__FILE__) . "/inc_member_section.php"); ?>

    <br class="clearer"/>

    <!-- Begin popular text services area -->
    <? if (count($TextServices) > 0): ?>
    <div id="spotlight-wrapper">

        <div class="ribbon-shadow-left">&nbsp;</div>

        <!-- Services section header -->
        <div class="section-wrapper">
            <div class="section">Popular Text Services</div>
        </div>

        <div class="ribbon-shadow-right">&nbsp;</div>

        <div class="section-arrow">&nbsp;</div>
        <!-- begin Service slider -->
        <div class="spotlight">

            <div id="spotlight-slider">
                <ul>

                    <? foreach ($TextServices as $item): ?>
                    <li>
                        <div class="post-panel">
                            <div class="category">
                                <div class="ribbon-shadow-left">&nbsp;</div>
                                <div class="icon"
                                     style="background:url(/css/{ProductPath}/web/images/icon_mobile.png) no-repeat 0px 0px;">
                                    &nbsp;</div>
                                <div class="catname"><?=$item['keyword']?> &raquo; <?=$item['shortcode']?></div>
                                <div class="category-arrow">&nbsp;</div>
                            </div>

                            <? if (isset($item['link'])): ?>
                            <a class="darken" href="<?=$item['link']?>"><?= sprintf($item['preview']['mobile'], 300, 170); ?></a>
                            <? else: ?>
                            <?= sprintf($item['preview']['mobile'], 300, 170); ?>
                            <? endif; ?>

                            <div class="inner">
                                <h2><?=$item['name']?></h2>

                                <div class="excerpt"><?=$item['instruction']?></div>
                            </div>
                        </div>
                    </li>
                    <? endforeach; ?>

                </ul>
            </div>
        </div>
    </div>
    <? endif; ?>

    <div class="clearer"></div>
    <br class="clearer"/>

    <? unset($ContentTypes['Videos'],$ContentTypes['Polyphonics'],$ContentTypes['Covertones']); if (count($ContentTypes) > 0) : ?>
    <!-- Begin Top Zone Area -->
    <div id="tabs-frontpage">

        <div class="ribbon-shadow-left">&nbsp;</div>

        <!-- Top Zone section header -->
        <br class="clearer"/>

        <div class="tabdiv-wrapper">
            <? $limit = 4; foreach ($ContentTypes as $cat=> $items): if ($limit-- > 0): ?>
            <div class="section-wrapper">
                <div class="section">TOP <?=strtoupper($cat)?></div>
            </div>
            <div id="topzone_<?=md5("topzone_{$cat}")?>" class="tabdiv">

                <?if(strtoupper($cat)=="SOUND EFFECTS"){?>

                <? $i = 1; foreach ($items as $item): ?>
                    <div class="panel <? if ($i % 3 == 0) echo "right"; ?>">

                        <a class="post-title"
                           href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                           title="<?=$item['title']?>"><?=$item['title']?></a>

                    </div>
                    <? endforeach; ?>

                <?}else{?>
                <? $i = 1; foreach ($items as $item): ?>
                <div class="panel <? if ($i % 3 == 0) echo "right"; ?>">

                    <div class="rating-wrapper small">
                        <div class="number color4"><?=$item['score']?></div>
                    </div>

                    <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                       class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['preview']['mobile'], 163, 109); ?></a>

                    <a class="post-title"
                       href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                       title="<?=$item['title']?>"><?=$item['title']?></a>

                </div>
                <? endforeach; ?>
                <?}?>
                <br class="clearer"/>

                <div style="text-align:center;">
                    <a class="button_link" href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/<?=$cat?>/" style="opacity: 1;"><span>Browse All <?=$cat?></span></a>
                </div>

            </div>
            <? endif; endforeach; ?>

        </div>

    </div>
    <? endif; ?>



<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>