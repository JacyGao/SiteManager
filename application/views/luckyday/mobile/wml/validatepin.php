<?php require_once( dirname(__FILE__) ."/inc_head.php");?>

<form action="{DocumentRoot}/{ProductPath}/validatepin/{Country}/{Keyword}/{next_page}" method="POST" name="form1" id="form1" onsubmit="return busSignon();">
    <br /><br />
    <h3 style="color: #ffffff; text-align: center;">Please Enter your PIN Code</h3>
    <p align="center"><small>(check your mobile phone for your PIN code)</small></p>
    <p align="center"><input name="pin" type="text" id="MobileNo" value="" maxlength="4" style="text-align: left; padding-left: 10px;" /></p><br />
    <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/cmd_Sub1.png" /></p></td>
</form>

<script type="text/javascript">
    <!--
    document.form1.pin.focus();
    //-->
</script>
<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>