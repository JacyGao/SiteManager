<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

<form action="{DocumentRoot}/iq/validatepin/{Country}/{Keyword}/{next_page}" method="POST" name="form1" id="form1" onsubmit="return busSignon();">
    <div id="q1">
        <h2 style="margin-left: -30px;">Your IQ Score is <br>ready.</h2>

        <h3 style="margin-left: -30px;">Enter your PIN Code to get <br>Your IQ Score!</h3>
        <small>(check your mobile phone for your PIN code)</small>
    </div>
    <div id="q2">
        <br /><br /><br /><br /><br />
        <p align=left>
            <b>Your PIN Code:</b><br />
            <input name="pin" type="text" id="MobileNo" value="" size="7" maxlength="4">
        </p>
        <br /><br />
        <p align=center><input type="submit" id="submit" value=""  /></p>

    </div>
</form>

<script type="text/javascript">
    <!--
    document.form1.pin.focus();
    //-->
</script>
<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>