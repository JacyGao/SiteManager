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

                    <figure class="post-icon"><a href="#" rel="lightbox">{Item_Image}</a></figure>
                </div>

                <div>
                <h1 style="font-size:15px; color:#FFF;">{Item_Title}</h1><br>

                    <div id="downloadbutton">
                        <p style="color:#adadad;">{Item_Note}</p>

                        {Item_Download}
                    </div>
                <br>
                <p style="color:#adadad;">Note: You need a WAP/GPRS enabled phone to download the content. Games require a JAVA enabled device. Covertones require MP3 capable devices. ** Standard Data charges apply!</p>
                </div>
            </article>

        </section>

    </div>

</section>

<?require_once(dirname(__FILE__) . "/inc_foot.php");?>