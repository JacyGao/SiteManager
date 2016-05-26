<?php require_once( dirname(__FILE__) ."/inc_head.php");?>


    <br /><br />
    <h1 style="color: #F00; text-align: center; font-size:46px;">Please Enter your PIN Code</h1>
    <p align="center" style="text-align: center; font-size:26px;">(check your mobile phone for your PIN code)</p>
    <p align="center"><img src="{DocumentRoot}/css/{ProductPath}/images/darrow.gif" /></p>

<form action="{DocumentRoot}/{ProductPath}/validatepin/{Country}/{Keyword}/{next_page}" method="POST" name="form1" id="form1" onsubmit="return busSignon();">
    <p align="center"><input name="pin" type="text" id="MobileNo" maxlength="4" style="text-align: left; padding-left: 10px; width:450px; height:80px; font-size:18px;"  /></p>

    <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/submit.png" height="130" width="250"   /></p></td>
</form>

<script type="text/javascript">
    <!--
    document.form1.pin.focus();
    //-->
</script>
<?php require_once( dirname(__FILE__) ."/inc_footer.php"); ?>