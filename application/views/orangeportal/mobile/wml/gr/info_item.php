<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<div class="item-slider" style="margin-top:15px;">

    <div class="center W100 g6">

        <h1 class="title" style="font-size:20px; margin-top:10px;margin-bottom:5px;">{Item_Title}</h1>

        <div class="overview">

            <div class="left-panel">

                <div class="article-image {Item_Type}">
                    <img src="{Item_Image}" alt="info preview is not available"/>
                </div>

                <br class="clearer">

                <span class="taxName">Content Type</span>: <span class="taxContent"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/{Item_Type}" rel="tag">{Item_Type}</a></span>

                <div class="separator">&nbsp;</div>

                <span class="taxName">Category</span>: <span class="taxContent"><a href="{DocumentRoot}/{ProductPath}/category/{Country}/{Keyword}/{Item_Type}/{Item_Category}" rel="tag">{Item_Category}</a></span>

                <div class="separator">&nbsp;</div>

            </div>

            <div class="right-panel">

                <div class="ratings-wrapper">

                    <div id="criteria0" class="rating-criteria-wrapper regular number" style="opacity: 1;">

                        <div class="rating-criteria" style="width:90%">
                            {Item_Content}


                        </div>

                    </div>

                </div>

                <div class="ribbon-shadow-right">&nbsp;</div>


            </div>

            <br class="clearer"><br>


        </div>

    </div>

    <br class="clearer">


</div>


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>