<?php
require_once(dirname(__FILE__) . "/inc_head.php");
/***********************
 * Created by Jacy Gao *
 * Date: 31/01/13      *
 * Time: 5:24 PM       *
 **********************/
?>

<!-- enter your number section-->
<section id="content-header">
    <div class="container">
        <div class="row-fluid">
            <? if(!$isLoggedIn): ?>
            <div class="span12">
                <hgroup class="content-title welcome">

                    <h1>Enter your number</h1>
                    <h2>to get <span style="font-size:17px; color:yellow;">UNLIMITED</span> downloads</h2>
                    <br />
                    <form action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}/" method="post">
                        <input type="text" name="mobile" placeholder="Enter Mobile" style="height:30px;font-size:15pt;width:90%;"><br>
                        <br>
                        {TermsCheckbox}
                        <input type="submit" name="submit" value="GO!" style="height:25px;font-size:12pt;width:auto;">
                    </form>
                </hgroup>
            </div>
            <? endif; ?>
            <div class="span12">
                <hgroup class="fancy-headers">
                    <h1>Download the <span style="color:yellow;"> sexiest </span></h1>
                    <h2>videos on your mobile NOW!</h2>
                </hgroup>
            </div>
        </div>
    </div>
</section>

<!-- Video section -->

<section id="content-container" class="container">

    <div class="row-fluid">


        <section id="content" class="span8 front-page posts">

            <? if (sizeof($Items) > 0): ?>
            <? $i = 0; foreach ($Items as $item): ?>
                <article class="post">
                    <div class="post-offset">
                        <figure class="post-icon"><a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>" title="<?=$item['title']?>"><?= sprintf($item['image'], 70, 70); ?></a></figure>
                        <h1><a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>" title="<?=$item['title']?>"><?=$item['title']?></a></h1>

                    </div>
                </article><!-- /post -->
                <? endforeach; ?><? endif; ?>

            <div class="clearfix"></div>


            <section id="pagination-wrapper">
                <div class="pagination">
                    {Pagination}
                </div>
            </section>

        </section><!-- /content -->

        <aside id="sidebar" class="span4">

            <div class="widget upcoming-events">
                <header>
                    <hgroup class="fancy-headers">
                        <h1>Download the <span style="color:red;">Most Exciting</span></h1>
                        <h2>Games on your mobile NOW!</h2>
                    </hgroup>
                </header>
            </div><!-- /upcoming-events -->

            <div class="widget photos">

                <ul class="photo-stream">
                    <? foreach ($Games as $item): ?>
                        <li><a rel="lightbox" href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"><?= sprintf($item['preview']['mobile'], 70, 70); ?></a></li>

                    <? endforeach; ?>
                </ul>
            </div>

        </aside>
    </div>
</section><!-- content-container -->

<?require_once(dirname(__FILE__) . "/inc_foot.php");?>