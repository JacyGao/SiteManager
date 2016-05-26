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
                        <div class="section">Login</div>
                    </div>
                    <div class="ribbon-shadow-right">&nbsp;</div>
                    <div class="section-arrow">&nbsp;</div>

                    <div id="comments">

                        <div class="comment-form-comment">
                            <form action="{DocumentRoot}/{ProductPath}/login_pin/{Country}/{Keyword}" method="POST">


                                <div style="float:left; margin-bottom:15px;">
                                    <div class="label">
                                        <label for="input_pin">PIN :</label>
                                        <span class="required">(required)</span>

                                    </div>

                                    <div class="input-wrapper">

                                        <div class="shadow">
                                            <input type="text" name="pin" id="input_pin" class="text" value="<?php echo set_value('pin'); ?>">
                                        </div>

                                    </div>
                                    <?php echo form_error('pin', '<div class="error">', '</div>'); ?>
                                    <? if(isset($Error)) echo "<div class=\"error\">{$Error}</div>"; ?>
                                    <? if(isset($Message)) echo "<div class=\"note\">{$Message}</div>"; ?>
                                </div>

                                <br class="clearer" />

                                <div style="float:left; margin-bottom:15px;">
                                    <button class="button_link green large_button" style="opacity: 0.8;"><span>Continue</span></button>
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