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

                <div id="comments">

                    <div class="comment-form-comment"
                    <form action="{DocumentRoot}/{ProductPath}/help/{Country}/{Keyword}" method="post">

                        <div style="float:left; margin-right:10px; margin-bottom:15px;">
                            <div class="label">
                                <label for="input_name">Name :</label>
                                <span class="required">(required)</span>
                            </div>
                            <div class="input-wrapper">
                                <div class="shadow">
                                    <input type="text" name="name" id="input_name" value="">
                                </div>
                            </div>
                        </div>

                        <div style="float:left; margin-bottom:15px;">
                            <div class="label">
                                <label for="input_phone">Mobile Number :</label>
                                <span class="required">(required)</span>
                            </div>
                            <div class="input-wrapper">
                                <div class="shadow">
                                    <input type="text" name="phone" id="input_phone" value="">
                                </div>
                            </div>
                        </div>


                        <br class="clearer" />

                        <div style="float:left; margin-bottom:15px;">
                        <button class="button_link rust large_button" style="opacity: 0.8;"><span>Continue</span></button>
                        </div>

                    </form>

                    <br class="clearer">
                    <div class = "signup_widget"></div>
                </div>

                </div>

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

                        <div class="tabdiv-wrapper">

                            <? foreach($Ringtones as $type=>$items): ?>
                            <div id="ringtones_<?=md5("ringtones_{$type}")?>" class="tabdiv">

                                <ul>
                                    <li><strong><?=$type?></strong></li>
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