<?php if($Allow_Signup || $Allow_Login): ?>
<!-- Begin membership area -->
<div id="featured-wrapper">

    <div class="ribbon-shadow-left">&nbsp;</div>
    <div class="section-wrapper">
        <div class="section">MEMBERSHIP</div>
    </div>
    <div class="section-arrow">&nbsp;</div>

    <?php $div_width = ($Allow_Signup && $Allow_Login)? "one_half":""; ?>

    <?php if($Allow_Signup): ?>
    <div class="<?=$div_width?> bg_dark1">
        <div id="not_a_member" class="container">

            <?php if($Signup_Flow == SUBSCRIBE_FLOW_MO): ?>
            <h1>SMS {Keyword} to {Shortcode}</h1>
            <?php else: ?>
            <form action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}/" method="post">
                <h2>JOIN NOW</h2>

                <div class="comment-form-mobile">
                    <div class="input-wrapper">
                        <div class="shadow">
                            <div class="icon">
                                <input name="mobile" type="text" value="" placeholder="Enter mobile">
                            </div>
                        </div>
                    </div>
                </div>

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
                <div class="comment-form-pin" style="margin-top:5px;">
                    <div class="input-wrapper">
                        <div class="shadow">
                            <div class="icon">
                                <input name="pin" type="text" value="" maxlength="4" placeholder="Enter Your NEW PIN">
                            </div>
                        </div>
                    </div>
                </div>
                <? endif; ?>

                <? if($TermsCheckbox): ?>
                <br class="clearer" />
                <div style="margin-bottom:15px;">
                    {TermsCheckbox}
                </div>
                <? endif; ?>

                <fieldset style="margin-top:5px;">
                    <button class="button_link rust large_button" style="opacity: 0.8;"><span>Continue</span></button>
                </fieldset>
                <small>(Example: {MobileExample}) <? if($Allow_MO_Optin) echo "or SMS {Keyword} to {Shortcode}"; ?></small>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if($Allow_Login): ?>
    <div class="<?=$div_width?> bg_dark2 last">
        <div id="already_a_member" class="container">
            <form action="{DocumentRoot}/{ProductPath}/login_form/{Country}/{Keyword}/" method="post">
                <h2>LOGIN NOW</h2>
                <div class="comment-form-mobile">
                    <div class="input-wrapper">
                        <div class="shadow">
                            <div class="icon">
                                <input name="mobile" type="text" value="" placeholder="Enter mobile">
                            </div>
                        </div>
                    </div>
                </div>

                <? if($Login_Flow == LOGIN_FLOW_GOT_PIN): ?>
                <div class="comment-form-pin" style="margin-top:5px;">
                    <div class="input-wrapper">
                        <div class="shadow">
                            <div class="icon">
                                <input name="pin" type="text" value="" maxlength="4" placeholder="Enter Your PIN">
                            </div>
                        </div>
                    </div>
                </div>
                <? endif; ?>

                <fieldset style="margin-top:5px;">
                    <button class="button_link sky large_button" style="opacity: 0.8;"><span>Continue</span></button>
                </fieldset>
                <small>(Example: {MobileExample})</small>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
