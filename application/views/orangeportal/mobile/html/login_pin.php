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
                    <form action="{DocumentRoot}/{ProductPath}/login_pin/{Country}/{Keyword}" method="POST">


                        <div style="float:left; margin-bottom:15px;">
                            <div class="label">
                                <label for="input_pin">PIN :</label>
                                <span class="required">(required)</span>

                            </div>

                            <div class="input-wrapper">

                                <div class="shadow">
                                    <input type="text" name="pin" id="input_pin" class="text" value="<?php echo set_value('pin'); ?>">
                                </div>

                            </div>
                            <?php echo form_error('pin', '<div class="error">', '</div>'); ?>
                            <? if(isset($Error)) echo "<div class=\"error\">{$Error}</div>"; ?>
                            <? if(isset($Message)) echo "<div class=\"note\">{$Message}</div>"; ?>
                        </div>

                        <br class="clearer" />

                        <div style="float:left; margin-bottom:15px;">
                            <button class="button_link green large_button" style="opacity: 0.8;"><span>Continue</span></button>
                        </div>

                    </form>

                    <br class="clearer">
                    <div class = "signup_widget"></div>
                </div>

            </div>

        </div>
    </div>
<br class="clearer" />


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>