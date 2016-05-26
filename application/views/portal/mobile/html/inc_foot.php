
</div>

<div class="sidebar">
    <div class="complex-list all_reviews">
    <? if (sizeof($Ringtones) > 0): ?>
        <div class="widget-wrapper">

            <div class="widget">

                <? foreach ($Ringtones as $type => $items): ?>
                <div class="section-wrapper">
                    <div class="section">LATEST <?=$type?></div>
                </div>

                <div class="tabdiv">
                    <div id="tabbed-reviews-compact" class="complex-list compact">

                        <div class="tabdiv-wrapper">

                            <div id="ringtones_<?=md5("ringtones_{$type}")?>" >
                                <ul>
                                    <? foreach ($items as $item): ?>
                                    <li>
                                        <a class="post-title"
                                           href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                                           title="<?=$item['artist']?> &#8211; <?=$item['title']?>"><?=$item['artist']?>
                                            &#8211; <?=$item['title']?></a>

                                        <br class="clearer"/>

                                    </li>
                                    <? endforeach; ?>

                                    <li class="more" title="View all <?=$type?> songs"><a
                                        href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/<?=$type?>">More <?=$type?></a></li>
                                    <li class="last">&nbsp;</li>

                                </ul>

                            </div>


                        </div>

                    </div>
                </div>
                <? endforeach; ?>

            </div>

        </div>
    <? endif; ?>

    <? if (sizeof($Videos) > 0): ?>
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
                                   title="<?=$item['title']?>"><?= sprintf($item['preview']['mobile'], 70, 70); ?></a>
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

                        <li class="more" title="View all <?echo isset($type)? $type : ""?> videos"><a
                            href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/videos">More Videos</a></li>

                        <li class="last">&nbsp;</li>

                    </ul>
                </div>

            </div>

        </div>
    <? endif; ?>
    </div>

</div>

</div>

<br class="clearer"/>
<br/>

</div>

<!--begin footer wrapper -->
<div id="footer-wrapper">

<div id="footer">

<div class="footer-menu">

    <a class="home-link" href="{DocumentRoot}/{ProductPath}/index/{Country}/{Keyword}">&nbsp;</a>

    <ul id="menu-footer-menu" class="menu">
        <?php foreach($MainMenu as $link): ?>
        <li><a href="<?=$link['url']?>"><?=$link['label']?></a></li>
        <?php endforeach; ?>
    </ul>

</div>

<br class="clearer" />

<div class="inner">


    <div class="complex-list all_reviews small">

        <div class="widget">

            <h2>Terms and Conditions</h2>

            <div class="textwidget">

                <p>{Terms_And_Conditions}</p>

            </div>

        </div>

    </div>




<br class="clearer" />

</div>

<div class="copyright">

    <div class="ribbon-shadow-left">&nbsp;</div>

    <div class="floatright">
        <div class="floatleft">
            <div class="textwidget"><p>Powered by <a href="http://www.mobivate.com">Mobivate</a> © <?=date("Y")?></p></div>
        </div>
    </div>

    <br class="clearer" />

    <div class="ribbon-shadow-right">&nbsp;</div>

</div>

</div>

</div> <!--end footer wrapper-->

</div>

{WRAPPER_END}