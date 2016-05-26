<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<div id="main-wrapper">

    <div id="main-wrapper-dark">

        <div class="clearer hide-responsive">&nbsp;</div>
        <br class="hide-responsive">
        <div class="main-content-left">

            <div class="page-content review">

                <link rel="image_src" href="{DocumentRoot}/{ProductPath}/image/{Item_ID}/large.jpg">

                <div class="overview-wrapper">

                    <h1 class="title">{Item_Title}</h1>

                    <div class="overview">

                        <div class="arrow-catpanel-bottom">&nbsp;</div>

                        <div class="left-panel">

                            <div class="article-image {Item_Type}">
                                {Item_Image}
                            </div>

                            <br class="clearer">

                            <div class="category">
                                <div class="ribbon-shadow-left">&nbsp;</div>
                                <div class="catname">Item Info</div>
                                <div class="category-arrow">&nbsp;</div>
                            </div>

                            <br class="clearer">

                            <?php if($Can_Listen): ?>
                            <span class="taxName">Preview</span>: {Item_Preview}
                            <div class="separator">&nbsp;</div>
                            <?php endif; ?>

                            <span class="taxName">Content Type</span>: <span class="taxContent"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/{Item_Type}" rel="tag">{Item_Type}</a></span>
                            <div class="separator">&nbsp;</div>

                            <span class="taxName">Category</span>: <span class="taxContent"><a href="{DocumentRoot}/{ProductPath}/category/{Country}/{Keyword}/{Item_Type}/{Item_Category}" rel="tag">{Item_Category}</a></span>
                            <div class="separator">&nbsp;</div>

                            <span class="taxName">Cost</span>: <span class="taxContent">{Item_Cost}</span>
                            <div class="separator">&nbsp;</div>

                        </div>

                        <div class="right-panel">

                            <div class="ratings-wrapper">

                                <div id="criteria0" class="rating-criteria-wrapper regular number" style="opacity: 1;">

                                    <div class="rating-criteria" style="width:90%">
                                        {Item_Note}


                                    </div>

                                </div>


                                <div class="rating-criteria-outer number">

                                    <div id="last-criteria" class="rating-criteria-wrapper last percentage" style="opacity: 1; background-position: 0px 0px;">

                                        <div id="last-rating" class="rating-wrapper" style="background-image: url(/css/portal/web/images/rating-number-last-color5.png); background-repeat:repeat-x; opacity: 1;">

                                            <div class="number color5 single">{Item_Download}</div>

                                            <br class="clearer">

                                        </div>

                                        <br class="clearer">

                                    </div>

                                </div>



                            </div>

                            <div class="ribbon-shadow-right">&nbsp;</div>

                            <div class="summary">

                                <div class="positive-wrapper">

                                    <div>

                                        <h3>Note:</h3>

                                        <br class="clearer">

                                    </div>

                                    <p>{NOTE}</p>
                                </div>

                            </div>

                        </div>

                        <br class="clearer"><br>


                    </div>

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