<?php include("inc_head.php"); ?>

    <!-- first part -->

    <div align="center" style="background-color:#0065ad;">

        <h1 style="margin:2px 5px 2px 5px; font-size: 25px;"><font color="#FFFFFF">Is It YOUR lucky day?</font></h1>
    </div>

    <!-- sec part -->

    <div class="clear"></div>

    <div>

        <img src="{DocumentRoot}/css/{ProductPath}/images/{ImageURL}" width="100%"  height="" alt="" />

    </div>

    <div align="center" style="background-color:#0065ad;">

        <h1 style="margin:2px 5px 2px 5px; font-size: 25px;"><font color="#FFFFFF">Become a Club member and <br/>WIN!!!</font></h1>
    </div><!-- sec1 part -->
    <div align="center">
        <form method="post" action="{DocumentRoot}/{ProductPath}/validate/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" align="center">

                        <p align="center" style="font-size:14px; font-weight:bold;">

                            Enter your mobile number:<br />
                            <span style="font-size:11px; color:#999999;">(format eg.{MobileExample} <!--{MobileExample}-->)</span>

                            <br>
                            <input type="text" id="mobile" name="mobile" size="25" required placeholder="07XXXXXXXXXX"
                                   pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 45px;" maxlength="10"><br />

                            <!-- <div>{TermsCheckbox}</div> -->

                        </p>
                        <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/cmd_Sub1.png" / height="50" width="170"><br/>

                        </p> </td></tr>
            </table>
        </form>
        <div align="center">
            <img src="{DocumentRoot}/css/{ProductPath}/images/main2.jpg" width="100%" alt="" />
        </div>

<?php include("inc_foot.php"); ?>