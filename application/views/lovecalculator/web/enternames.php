<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

<form method="post" action="{DocumentRoot}/{ProductPath}/entermobile/{Country}/{Keyword}" name="FrontPage_Form1" target="_self" onsubmit="return FormValidator(this)" language="JavaScript">
    <table width="438" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top" background="{DocumentRoot}/css/{ProductPath}/images/middle_02.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="65" align="center" valign="bottom"><span class="heading1">Enter Your Name and His or Her Name</span><strong><br />
                        <span class="heading2">To Get Your Love Compatibility Messages</span></strong></td>
                </tr>
                <tr>
                    <td height="7" align="center"></td>
                </tr>
                <tr>
                    <td height="86" align="center" background="{DocumentRoot}/css/{ProductPath}/images/step_one.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="196" height="50" align="center" valign="bottom"><input name="Yname" type="text" class="input" maxlength="15" /></td>
                            <td height="50" align="center" valign="bottom">&nbsp;</td>
                            <td width="195" height="50" align="center" valign="bottom"><input name="Lname" type="text" class="input" maxlength="15" /></td>
                        </tr>
                    </table></td>
                </tr>
                <tr>
                    <td height="20" align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <input type="image" name="submit" src="{DocumentRoot}/css/{ProductPath}/images/continue_off.jpg" srcover="{DocumentRoot}/css/{ProductPath}/images/continue_on.jpg" srcdown="images/continue_on.jpg" border="0">
                    </td>
                </tr>
            </table></td>
        </tr>
    </table>

<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>