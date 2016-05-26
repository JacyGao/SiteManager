<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

            <div class="page-content">

                <div class="review-content">
                <div class="ribbon-shadow-left">&nbsp;</div>
                <div class="section-wrapper">
                    <div class="section">Get Content</div>
                </div>
                <div class="ribbon-shadow-right">&nbsp;</div>
                <div class="section-arrow">&nbsp;</div>

                <div id="comments">

                    <div class="comment-form-comment">
                        <br>
                        <h3>To get your content</h3>
                        <h2>Sms {MOKeyword} to {Shortcode}</h2>
                        <h3>Or<br>Enter your number below</h3>
                    <form action="{DocumentRoot}/{ProductPath}/order/{Country}/{Keyword}/{pcs}" method="POST">
                        <input type="hidden" name="network" value="{SelNetwork}" />
                        <div style="float:left; margin-bottom:15px;">
                            <div class="label">
                                <label for="input_phone">Mobile Number :</label>
                                <span class="required">(required)</span>

                            </div>

                            <div class="input-wrapper">

                                <div class="shadow">
                                    <input type="text" name="mobile" id="input_phone" class="text" value="<?php echo set_value('mobile'); ?>">
                                </div>

                            </div>
                            <?php echo form_error('mobile', '<div class="error">', '</div>'); ?>
                        </div>


                        <? if($TermsCheckbox): ?>
                        <br class="clearer" />
                        <div style="float:left; margin-bottom:15px;">
                            <div class="label">
                                <label for="terms_cb">Terms & Conditions</label>
                                <span class="required">(required)</span>

                            </div>
                            <div>
                                <?php echo form_error('terms', '<div class="error">', '</div>'); ?>
                                {TermsCheckbox}

                            </div>
                        </div>
                        <? endif; ?>

                        <br class="clearer" />

                        <div style="float:left; margin-bottom:15px;">
                            <button class="button_link rust large_button" style="opacity: 0.8;"><span>Continue</span></button>
                        </div>

                    </form>

                        <br class="clearer">
                    <div class = "signup_widget"></div>
                    </div>
                    <br class="clearer">

                </div>

            </div>

        </div>



<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>