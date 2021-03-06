<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

        <div class="item-slider" style="margin-top:15px;">

            <div class="center W100 g6">

            <h1 class="title" style="font-size:20px; margin-top:10px;margin-bottom:5px;">{Item_Title}</h1>

            <div class="overview">

                <div class="left-panel">

                    <div class="article-image {Item_Type}">
                        {Item_Image}
                    </div>

                    <br class="clearer">

                    <span class="taxName">Τύπος περιεχομένου</span>: <span class="taxContent"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/{Item_Type}" rel="tag">{Item_Type}</a></span>

                    <div class="separator">&nbsp;</div>

                    <span class="taxName">Κατηγορία</span>: <span class="taxContent"><a href="{DocumentRoot}/{ProductPath}/category/{Country}/{Keyword}/{Item_Type}/{Item_Category}" rel="tag">{Item_Category}</a></span>

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

                                    <br class="clearer">

                                    <div class="number color5 single">{Item_Download}</div>

                                    <br class="clearer">

                                </div>


                            </div>

                        </div>



                    </div>

                    <div class="ribbon-shadow-right">&nbsp;</div>

                    <div class="summary">

                        <div class="positive-wrapper">
                            <div>
                                <h3>Σημείωση:</h3>
                                <br class="clearer">
                            </div>
                            <p>Χρειάζεστε WAP / GPRS στο τηλέφωνο σας για

                                να κατεβάσετε αυτό το περιεχόμενο. Τα

                                παιχνίδια απαιτούν να είναι το JAVA

                                ενεργοποιημένο στη συσκευή. Επανεκτελέσεις

                                των τραγουδιών απαιτούν συσκευές με

                                δυνατότητα MP3. Ισχύουν οι χρεώσεις

                                δεδομένων δικτύου.</p>
                        </div>

                    </div>

                </div>

                <br class="clearer"><br>


            </div>

        </div>

        <br class="clearer">


    </div>


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>