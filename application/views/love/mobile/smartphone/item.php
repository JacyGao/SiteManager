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
                <h1 style="font-size:15px; color:#FFF;">{Item_Content}</h1><br>
                </div>
            </article>
            <a href="{DocumentRoot}/{ProductPath}/index/{Country}/{Keyword}/"><span style="color:white;">Go Back</span></a>
        </section>

    </div>

</section>

<?require_once(dirname(__FILE__) . "/inc_foot.php");?>