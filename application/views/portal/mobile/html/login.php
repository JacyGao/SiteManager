<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>


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
            <form action="{DocumentRoot}/{ProductPath}/login_form/{Country}/{Keyword}" method="post">



                <div style="float:left; margin-bottom:15px;">
                    <div class="label">
                        <label for="input_phone">Mobile Number :</label>
                        <span class="required">(required)</span>
                    </div>
                    <div class="input-wrapper">
                        <div class="shadow">
                            <input type="text" name="mobile" id="input_phone" value="">
                        </div>
                    </div>
                    <?php echo form_error('mobile', '<div class="error">', '</div>'); ?>
                </div>

                <? if($Login_Flow == LOGIN_FLOW_GOT_PIN): ?>
                <div style="float:left; margin-bottom:15px;">
                    <div class="label">
                        <label for="input_pin">Your Custom PIN :</label>
                        <span class="required">(required)</span>

                    </div>

                    <div class="input-wrapper">

                        <div class="shadow">
                            <input type="number" name="pin" id="input_pin"  maxlength="4" text" value="<?php echo set_value('pin'); ?>">
                        </div>

                    </div>
                    <?php echo form_error('pin', '<div class="error">', '</div>'); ?>
                </div>
                <? endif; ?>


                <div style="float:left; margin-left:20px; margin-bottom:15px;">
                    <div style="margin-top:37px;">
                        <button class="button_link rust " style="opacity: 0.8;"><span>Continue</span></button>
                    </div>

                </div>
                <div class = "login_widget"></div>



            </form>

            <br class="clearer">

        </div>

</div>

        </div>
    </div>
    <br class="clearer" />

<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>