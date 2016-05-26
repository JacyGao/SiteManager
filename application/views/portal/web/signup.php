<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<div id="main-wrapper">

    <div id="main-wrapper-dark">

        <div class="clearer hide-responsive">&nbsp;</div>
        <br class="hide-responsive">
        <div class="main-content-left">
            <div class="page-content">

                <div class="review-content">
                <div class="ribbon-shadow-left">&nbsp;</div>
                <div class="section-wrapper">
                    <div class="section">Sign Up</div>
                </div>
                <div class="ribbon-shadow-right">&nbsp;</div>
                <div class="section-arrow">&nbsp;</div>

                <?php if($Signup_Flow == SUBSCRIBE_FLOW_MO): ?>
                    <h1>SMS {Keyword} to {Shortcode}</h1>
                <?php else: ?>
                    <iframe src="{DocumentRoot}/{ProductPath}/signup_form/{Country}/{Keyword}/" width=100% height=500 frameborder="0"></iframe>
                <?php endif; ?>
            </div>

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
                                            <div class="number color4">[ p ]</div>
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

        </div>

        <br class="clearer"/>
        <br />

    </div>
    <!--end main wrapper dark-->

</div><!--end main white content wrapper -->


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>