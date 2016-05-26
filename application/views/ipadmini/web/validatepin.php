<?php require_once( dirname(__FILE__) ."/inc_head.php");?>

<form action="{DocumentRoot}/ipadmini/validatepin/{Country}/{Keyword}/{next_page}" method="POST" name="form1" id="form1" onsubmit="return busSignon();">
    <br /><br />
    <p align="center">One more step to go! </ br>
    <small>We have sent you a text, please click the link</small> </ p>
    <h3 style="color: #020101; text-align: center;">OR </h3>
        <?
        echo "<h3 style='color: #020101; text-align: center;'> "."SMS"."</h3><h1 style='color: #ff112a; text-align: center;'>"." {Keyword}"." </h1><h3 style='color: #020101; text-align: center;'>to"."<h3><h1 style='color: #ff112a; text-align: center;'>".
            " {Shortcode}"."</font></h1>";
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