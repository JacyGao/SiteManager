<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>



    <div class="page-content review">

        <div class="overview-wrapper">

            <h1 class="title">{Item_Title}</h1>

            <div class="overview">

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

                                <div class="rating-criteria"></div>

                                <div id="last-rating" class="rating-wrapper" style="background-image: url(http://demos.brianmcculloh.com/made/wp-content/themes/made/images/rating-number-last-color5.png); background-repeat:repeat-x; opacity: 1;">

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


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>