<?php require_once( dirname(__FILE__) ."/inc_head.php");?>
    <img src="{DocumentRoot}/css/{ProductPath}/images/tpw.jpg" width="100%" height=""/>

<form action="{DocumentRoot}/ipadmini/validatepin/{Country}/{Keyword}/{next_page}" method="POST" name="form1" id="form1" onsubmit="return busSignon();">
    <br /><br />
    <p align="center" style="font-size:66px; color: #F00;"> <strong>One more step to go!</strong></p>
    <p style='color: #ff112a; text-align: center; font-size:46px; '>We have sent you a text, please click the link </ p>
    <h3 style="color: #020101; text-align: center; font-size:76px; ">OR </h3>
        <?
        echo "<p align='center'> <font style='color: #020101; text-align: center; font-size:76px; ' > "."SMS "."</font> <font style='color: #ff112a; text-align: center; font-size:86px; ' >"." {Keyword}
        "." </ font><font style='color: #020101; text-align: center; font-size:76px; ' >to"."
        </ font><font style='color: #ff112a; text-align: center; font-size:86px; ' >".
            " {Shortcode}"."</ font> </ p>";
        ?>
    <h3 style="color: #020101; text-align: center;"> </h3>

    <!--
    <h3 style="color: #c01127; text-align: center;"> </h3>
    <p align="center"><small>(check your mobile phone for your PIN code)</small></p>
    <p align="center"><input name="pin" type="text" id="MobileNo" value="" maxlength="4" style="text-align: left; padding-left: 10px;" /></p><br />
    <p align="center"><input type="image" src="{DocumentRoot}/css/ipadmini/images/submit.jpg" onmouseover="this.src='{DocumentRoot}/css/ipadmini/images/submit.jpg';" onmouseout="this.src='{DocumentRoot}/css/ipadmini/images/submit.jpg';" width="220" height="54" /></p></td>
-->
</form>

<script type="text/javascript">
    <!--
    document.form1.pin.focus();
    //-->
</script>
<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>