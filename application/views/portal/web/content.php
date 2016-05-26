<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<div id="main-wrapper">

    <div id="main-wrapper-dark">

        <div class="clearer hide-responsive">&nbsp;</div>
        <br class="hide-responsive">
        <div class="main-content-left">

            <?php if(isset($ShowMemberSection)) include( dirname(__FILE__)."/inc_member_section.php"); ?>

            <div class="post-loop search-loop">

            <div class="ribbon-shadow-left">&nbsp;</div>

            <div class="section-wrapper">

                <div class="section">{Title}</div>

            </div>

            <div class="ribbon-shadow-right">&nbsp;</div>

            <div class="section-arrow">&nbsp;</div>


                <? foreach ($Items as $item): ?>
                <div class="post-panel">
                    <div class="post-thumbnail">
                        <a class="darken small" href="<?=$DocumentRoot?>/<?=$ProductPath?>/item/<?=$Country?>/<?=$Keyword?>/<?=$item['id']?>/"><?= sprintf($item['image'], 70, 70); ?></a>
                    </div>
                    <div class="inner">
                        <h2><a href="<?=$DocumentRoot?>/<?=$ProductPath?>/item/<?=$Country?>/<?=$Keyword?>/<?=$item['id']?>"><?=$item['title']?></a></h2>
                        <div class="category">
                            <div class="catname"><a href="<?=$DocumentRoot?>/<?=$ProductPath?>/category/<?=$Country?>/<?=$Keyword?>/<?=$item['type']?>/<?=$item['category']?>"><?=$item['category']?></a></div>
                            <div class="catname"><a href="<?=$DocumentRoot?>/<?=$ProductPath?>/content/<?=$Country?>/<?=$Keyword?>/<?=$item['type']?>"><?=$item['type']?></a></div>
                        </div>
                        <div class="more"><a href="<?=$DocumentRoot?>/<?=$ProductPath?>/item/<?=$Country?>/<?=$Keyword?>/<?=$item['id']?>">Info</a></div>
                    </div>
                    <br class="clearer">
                </div>
                <br class="clearer">
                <? endforeach; ?>

                <div class="pagination-wrapper">

                <div class="pagination">
                    {Pagination}
                </div>

                <br class="clearer">

            </div>

            <br class="clearer">

            </div>

        </div>

        <!-- Begin Right Sidebar Here -->
        <div class="sidebar">

            <? if ( sizeof($Ringtones) > 0 ): ?>
            <!-- Begin Top Ringtones -->
            <div class="widget-wrapper">

                <div class="widget">

                    <div class="section-wrapper">
                        <div class="section">TOP RINGTONES</div>
                    </div>

                    <div id="tabbed-reviews-compact" class="complex-list compact">

                        <ul class="tabnav">
                            <? foreach($Ringtones as $type=>$items): ?>
                            <li><a href="#ringtones_<?=md5("ringtones_{$type}")?>"><?=$type?></a></li>
                            <? endforeach; ?>
                        </ul>

                        <br class="clearer"/>

                        <div class="tabdiv-wrapper">

                            <? foreach($Ringtones as $type=>$items): ?>
                            <div id="ringtones_<?=md5("ringtones_{$type}")?>" class="tabdiv">

                                <ul>
                                    <? foreach($items as $item): ?>
                                    <li>

                                        <div class="rating-wrapper small">
                                            <div class="number color4"><?=$item['preview']['protected']?></div>
                                        </div>

                                        <a class="post-title" href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/","", $item['title']) ?>" title="<?=$item['artist']?> &#8211; <?=$item['title']?>"><?=$item['artist']?> &#8211; <?=$item['title']?></a>

                                        <br class="clearer"/>

                                    </li>
                                    <? endforeach; ?>

                                    <li class="more" title="View all <?=$type?> songs"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/<?=$type?>">More</a></li>
                                    <li class="last">&nbsp;</li>

                                </ul>

                            </div>
                            <? endforeach; ?>

                        </div>

                    </div>

                </div>

            </div>
            <? endif; ?>

            <? if ( sizeof($Videos) > 0 ): ?>
            <!-- Begin Top Videos -->
            <div class="complex-list all_reviews">

                <div class="widget-wrapper">

                    <div class="widget">
                        <div class="section-wrapper">
                            <div class="section">TOP VIDEOS</div>
                        </div>

                        <ul>

                            <? $i=0; foreach($Videos as $item): ?>
                            <li class="<? if( $i++ == 0) echo "first"; ?>">

                                <div class="floatleft">

                                    <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/","", $item['title']) ?>" class="thumbnail darken small"
                                       title="<?=$item['title']?>"><?= sprintf($item['image'], 70, 70); ?></a>
                                </div>

                                <div class="floatleft">
                                    <a class="post-title" href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/","", $item['title']) ?>" title="<?=$item['title']?>"><?=$item['title']?></a>
                                    <br class="clearer"/>
                                </div>

                                <br class="clearer"/>

                            </li>
                            <? endforeach; ?>

                            <li class="last">&nbsp;</li>

                        </ul>

                    </div>

                </div>

            </div>
            <? endif; ?>

        </div>

        <br class="clearer"/>
        <br />

    </div>
    <!--end main wrapper dark-->

</div><!--end main white content wrapper -->


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>