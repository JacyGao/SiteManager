<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>
<form method="post" action="{DocumentRoot}/{ProductPath}/validate/{Country}/{Keyword}" name="FrontPage_Form1" target="_self" onsubmit="return FormValidator(this)" language="JavaScript">
    <input type="hidden" value="{Yname}" name="Yname" />
    <input type="hidden" value="{Lname}" name="Lname" />
    <table width="438" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top" background="{DocumentRoot}/css/{ProductPath}/images/middle_02.jpg">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="65" align="center" valign="bottom" style="padding-left: 10px; padding-right: 10px;"><span class="heading1">Enter Your Phone Number {Yname},</span><strong><br />
                            <span class="heading2">and find out your compatibility with {Lname}!</span></strong></td>
                    </tr>
                    <tr>
                        <td height="6" align="center"></td>
                    </tr>
                    <tr>
                        <td height="86" align="center" valign="top" background="{DocumentRoot}/css/{ProductPath}/images/blank.jpg">
                            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                <tr>
                                    <td width="70" align="center" valign="middle">&nbsp;</td>
                                    <td align="left" valign="middle"><strong>Your Cell Number:</strong></td>
                                    <td align="left" valign="middle"><input name="MobileNo" type="text" id="MobileNo" size="24" value="{Placeholder}" maxlength="{MaxInputLength}" class="input" style="text-align: left;" /></td>
                                    <td width="70" align="center" valign="middle">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="70" align="center" valign="middle">&nbsp;</td>
                                    <td colspan="2" align="center" valign="middle"><span class="numFormat">(format eg. {MobileExample})</span></td>
                                    <td width="70" align="center" valign="middle">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="70" align="center" valign="middle">&nbsp;</td>
                                    <td colspan="2" align="center" valign="middle">
                                        {TermsCheckbox}
                                    </td>
                                    <td width="70" align="center" valign="middle">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <input type="image" name="submit" src="{DocumentRoot}/css/{ProductPath}/images/continue_off.jpg" srcover="{DocumentRoot}/css/{ProductPath}/images/continue_on.jpg" srcdown="{DocumentRoot}/css/{ProductPath}/imagesimages/continue_on.jpg" border="0"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>