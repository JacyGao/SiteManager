<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<div id="main-wrapper">

    <div id="main-wrapper-dark">

        <div class="clearer hide-responsive">&nbsp;</div>
        <br class="hide-responsive">
        <div class="main-content">

            <div class="page-content">

                <div class="content-panel">

                    <div class="one_half">

                        <h6 id="credit-title">Credits</h6>


                        <div>Below are the prices of each content type:</div>
                        <table width="400">
                        <tbody>
                        <? foreach($Prices as $type=>$price): ?>
                        <tr><th style="text-align:left;"><?=$type?></th><td><?=$price?> credits</td></tr>
                        <? endforeach; ?>
                        </tbody>
                        </table>
                    </div>

                    <div class="one_half last">
                        <h6>For more information, please contact</h6>
                        <p>{Contact_us_Text}</p>

                        <div class="contact_bottom"></div>
                    </div>

                </div>

            </div>

        </div>


        <br class="clearer"/>
        <br />

    </div>
    <!--end main wrapper dark-->

</div><!--end main white content wrapper -->


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>