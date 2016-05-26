<?php
require_once(dirname(__FILE__) . "/inc_head.php");
/***********************
 * Created by Jacy Gao *
 * Date: 31/01/13      *
 * Time: 5:24 PM       *
 **********************/
?>

<section id="content-container" class="container">

    <div class="row-fluid">

        <section id="content" class="span8 blog posts">

            <article class="post single">

                <div class="post-offset">
                </div>
                <div>
                <?php if($isLoggedIn): ?>
                    <h1 style="font-size:15px; color:#FFF;">{Item_Content}</h1><br>
                <?php else: ?>
                    <h1 style="font-size:15px; color:#FFF;">You need to be logged in to find get the todays content!</h1><br>
                <?php endif; ?>
                </div>
            </article>


        </section>


        <section id="content-container" class="container">

            <div class="row-fluid">

                <?php foreach($categories as $key=>$label): ?>
                    <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$key?>/"><h2 style="color:#FFF; font-size: 15px;"><img src="/css/info/mobile/img/<?=$key?>.jpg"> <?=$label?></h2></a>
                <?php endforeach; ?>

            </div>
        </section><!-- content-container -->

    </div>

</section>

<?require_once(dirname(__FILE__) . "/inc_foot.php");?>