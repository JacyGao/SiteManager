<?php require_once(dirname(__FILE__) . "/inc_head.php");?>


<?php if($Allow_Signup || $Allow_Login): ?>

    <?php if($Allow_Signup): ?>
        <?php if($Signup_Flow == SUBSCRIBE_FLOW_MO): ?>
        <p><h1>SMS {Keyword} to {Shortcode}</h1></p>
        <?php else: ?>
        <p>
            <h1>JOIN NOW</h1>

            Enter mobile :
            <input name="mobile" type="text" value=""><br />
            <small>(Example: {MobileExample}) <? if($Allow_MO_Optin) echo "or SMS <b>{Keyword}</b> to <b>{Shortcode}</b>"; ?></small><br />

            <? if($Login_Flow == LOGIN_FLOW_GOT_PIN): ?>
            Enter Your NEW PIN : <input name="pin" type="text" value="" maxlength="4"><br />
            <? endif; ?>

            <? if($TermsCheckbox): ?>
            <? $TermsCheckbox = preg_replace("/<input (.*)>/","[select]", $TermsCheckbox); echo $TermsCheckbox; ?><br />
            <? endif; ?>

            <do type="button" label="Submit Data">
                <go method="get" href="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}/">
                    <postfield name="mobile" value="$(mobile)" />
                <? if($Login_Flow == LOGIN_FLOW_GOT_PIN): ?>
                    <postfield name="pin" value="$(pin)" />
                <? endif; ?>
                <? if($TermsCheckbox): ?>
                    <postfield name="terms" value="$(terms)" />
                <? endif; ?>
                </go>
            </do>
            <br />
        </p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($Allow_Login): ?>
    <p>
        <a href="{DocumentRoot}/{ProductPath}/login/{Country}/{Keyword}/">Existing members, click here to Log In!</a>
        <br />
    </p>
    <?php endif; ?>

<?php endif; ?>

<? if (count($Top10) > 0): ?>
    <p>
        <h2>{CountryName} TOP <?=count($Top10)?></h2>
        <? foreach ($Top10 as $item): ?>
                <p>
                <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"><?= sprintf($item['image'], 40, 40); ?></a>
                <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"><?=$item['title']?></a><br/>
                <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>">by <?=$item['artist']?></a>
                </p>
        <? endforeach; ?>
    </p>
<? endif; ?>

<?php require_once(dirname(__FILE__) . "/inc_foot.php");?>
