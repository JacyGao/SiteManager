<?php
require_once(dirname(__FILE__) . "/inc_head.php");
$showSidebar = (sizeof($Ringtones) + sizeof($Videos) > 0);
?>
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

<div id="main-wrapper">

<div id="main-wrapper-dark">

<? if (sizeof($LatestContent) > 0): ?>
<!-- Begin latest slider area-->
<div id="latest-wrapper">
    <div class="latest-scroller-wrapper">
        <a href="#" class="latest-prev">&nbsp;</a>

        <!-- begin latest slider -->
        <div class="latest">

            <ul>

                <? foreach ($LatestContent as $item): ?>
                <li>
                    <a class="darken small" href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>">
                        <? if(isset($item['image'])) { echo sprintf($item['image'], 163, 109); } else { print_r($item); } ?>
                    </a>
                    <a class="title"
                       href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"><?=$item['title']?></a>

                    <div class="icon"><img alt="<?=$item['type']?>" title="<?=$item['type']?>" src="/css/{ProductPath}/icons/<?=$item['type']?>15x15.gif"/></div>
                </li>
                <? endforeach; ?>

            </ul>

        </div>
        <!-- end latest -->

        <a href="#" class="latest-next">&nbsp;</a>
        <br class="clearer"/>

    </div>
</div>
    <? endif; ?>

<div class="clearer hide-responsive">&nbsp;</div>
<br class="hide-responsive"/>

<div class="main-content<? if ($showSidebar) echo "-left" ?>">

    <?php include( dirname(__FILE__)."/inc_member_section.php"); ?>

    <? if (count($TextServices) > 0): ?>
    <!-- Begin popular text services area -->
    <div id="spotlight-wrapper<? if (!$showSidebar) echo "-full" ?>">

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
                            <a class="darken" href="<?=$item['link']?>"><?= sprintf($item['image'], 300, 170); ?></a>
                            <? else: ?>
                            <?= sprintf($item['image'], 300, 170); ?>
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
        <div class="section-wrapper">
            <div class="section">TOP ZONE</div>
        </div>

        <div class="section-arrow">&nbsp;</div>

        <ul class="tabnav">

            <? $limit = 4; foreach ($ContentTypes as $cat=> $items): if ($limit-- > 0): ?>
            <li><a href="#topzone_<?=md5("topzone_{$cat}")?>">TOP <?=strtoupper($cat)?></a></li>
            <? endif; endforeach; ?>

        </ul>

        <br class="clearer"/>

        <div class="tabdiv-wrapper">

            <? $limit = 4; foreach ($ContentTypes as $cat=> $items): if ($limit-- > 0): ?>
            <div id="topzone_<?=md5("topzone_{$cat}")?>" class="tabdiv">

                <? $i = 1; foreach ($items as $item): ?>
                <div class="panel <? if ($i % 3 == 0) echo "right"; ?>">

                    <div class="rating-wrapper small">
                        <div class="number color4"><?=$item['score']?></div>
                    </div>

                    <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                       class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['image'], 163, 109); ?></a>

                    <a class="post-title"
                       href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                       title="<?=$item['title']?>"><?=$item['title']?></a>

                </div>
                <? if ($i++ % 3 == 0) echo "<div class=\"clearer hide-responsive\"></div>\n"; ?>
                <? endforeach; ?>

                <br class="clearer"/>

                <div style="text-align:center;">
                    <a class="button_link" href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/<?=$cat?>/" style="opacity: 1;"><span>Browse All <?=$cat?></span></a>
                </div>

            </div>
            <? endif; endforeach; ?>

        </div>

    </div>
    <? endif; ?>

</div>

<? if ($showSidebar): ?>
<!-- Begin Right Sidebar Here -->
<div class="sidebar">

    <? if (sizeof($Ringtones) > 0): ?>
    <!-- Begin Top Ringtones -->
    <div class="widget-wrapper">

        <div class="widget">

            <div class="section-wrapper">
                <div class="section">LATEST RINGTONES</div>
            </div>

            <div id="tabbed-reviews-compact" class="complex-list compact">

                <ul class="tabnav">
                    <? foreach ($Ringtones as $type=> $items): ?>
                    <li><a href="#ringtones_<?=md5("ringtones_{$type}")?>"><?=$type?></a></li>
                    <? endforeach; ?>
                </ul>

                <br class="clearer"/>

                <div class="tabdiv-wrapper">

                    <? foreach ($Ringtones as $type=> $items): ?>
                    <div id="ringtones_<?=md5("ringtones_{$type}")?>" class="tabdiv">

                        <ul>
                            <? foreach ($items as $item): ?>
                            <li>

                                <div class="rating-wrapper small">
                                    <div class="number color4"><?=$item['preview']['protected']?></div>
                                </div>

                                <a class="post-title"
                                   href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                                   title="<?=$item['artist']?> &#8211; <?=$item['title']?>"><?=$item['artist']?>
                                    &#8211; <?=$item['title']?></a>

                                <br class="clearer"/>

                            </li>
                            <? endforeach; ?>

                            <li class="more" title="View all <?=$type?> songs"><a
                                href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/<?=$type?>">More</a></li>
                            <li class="last">&nbsp;</li>

                        </ul>

                    </div>
                    <? endforeach; ?>

                </div>

            </div>

        </div>

    </div>
    <? endif; ?>

    <? if (sizeof($Videos) > 0): ?>
    <!-- Begin Top Videos -->
    <div class="complex-list all_reviews">

        <div class="widget-wrapper">

            <div class="widget">
                <div class="section-wrapper">
                    <div class="section">POPULAR VIDEOS</div>
                </div>

                <div class="tabdiv">
                <ul>

                    <? $i = 0; foreach ($Videos as $item): ?>
                    <li class="<? if ($i++ == 0) echo "first"; ?>">

                        <div class="floatleft">

                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                               class="thumbnail darken small"
                               title="<?=$item['title']?>"><?= sprintf($item['image'], 70, 70); ?></a>
                        </div>

                        <div class="floatleft">
                            <a class="post-title"
                               href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                               title="<?=$item['title']?>"><?=$item['title']?></a>
                            <br class="clearer"/>
                        </div>

                        <br class="clearer"/>

                    </li>
                    <? endforeach; ?>

                    <li class="more" title="View all videos"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/videos">More</a></li>

                    <li class="last">&nbsp;</li>

                </ul>
                </div>

            </div>

        </div>

    </div>
    <? endif; ?>

</div>
<? endif; ?>

</div>

<br class="clearer"/>
<br/>

</div>



<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>