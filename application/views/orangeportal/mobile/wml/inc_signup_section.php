<?php if($Allow_Signup || $Allow_Login): ?>
<!-- Begin membership area -->
    <?php if($Allow_Signup): ?>
    <!-- Form for signup -->
    <div class="image-slider" style="margin-top:15px; text-align: center;">
            <?php if($Signup_Flow == SUBSCRIBE_FLOW_MO): ?>
            <p >SMS <font color=red> {Keyword} </font>to <font color=red>{Shortcode} </font></p>
            <?php else: ?>
                <p >Please enter your mobile number</p>
            <p style=" text-align: center;">To Get Latest Content on your Mobile</p>
                <form method="post" action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}">
                    <br />
                    <input type="text" id="input_phone" name="mobile" size="25" required 
                           pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 25px;" maxlength="10" ><br /><br />

                <? if($SelectNetwork): ?>
                <div class="comment-form-network">
                    <div class="input-wrapper">
                        <div class="shadow">
                            <div class="icon">
                                <?=$SelectNetwork?>
                            </div>
                        </div>
                    </div>
                </div>
                <? endif; ?>


                <? if($Login_Flow == LOGIN_FLOW_GOT_PIN): ?>
                    <font style="font-family:Arial, Helvetica, sans-serif;"> Please enter your Own PIN<br />
                    <input type="text" id="input_pin" name="pin" size="25" required placeholder="XXXX" align="center"
                           pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 25px;" maxlength="4" onblur="Minimum(this,4);"><br /><br />
                <? endif; ?>

                <? if($TermsCheckbox): ?>
                <br class="clearer" />
                <div style="margin-bottom:15px;">
                    {TermsCheckbox}
                </div>
                <? endif; ?>
                <br>
                <input type="submit" value="Submit" class="cmd" /><br>
                <small style="">(Example: {MobileExample}) <? if($Allow_MO_Optin) echo "or SMS {Keyword} to {Shortcode}"; ?></small>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <br>

    <?php endif; ?>


<?php endif; ?>
