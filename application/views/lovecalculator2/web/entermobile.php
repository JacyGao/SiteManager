<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>
<script Language="JavaScript" Type="text/javascript">
    <!--
    function ValidateForm(theForm)
    {

        if (theForm.Yname.value == "")
        {
            alert("Please enter your name!");
            theForm.Yname.focus();
            return (false);
        }

        if (theForm.Yname.value.length < 1)
        {
            alert("Please enter your name!");
            theForm.Yname.focus();
            return (false);
        }

        if (theForm.Yname.value.length > 50)
        {
            alert("Sorry but we only accept names less than 50 characters long.");
            theForm.Yname.focus();
            return (false);
        }

        if (theForm.Lname.value == "")
        {
            alert("Please enter your lovers name.");
            theForm.Lname.focus();
            return (false);
        }

        if (theForm.Lname.value.length < 1)
        {
            alert("Please enter your lovers name.");
            theForm.Lname.focus();
            return (false);
        }

        if (theForm.Lname.value.length > 50)
        {
            alert("Sorry but we only accept names less than 50 characters long.");
            theForm.Lname.focus();
            return (false);
        }

        if (theForm.MobileNo.value == "")
        {
            alert("Please enter your mobile number!");
            theForm.MobileNo.focus();
            return (false);
        }

        if (theForm.MobileNo.value.length != 11)
        {
            alert("Please enter your correct mobile number!");
            theForm.MobileNo.focus();
            return (false);
        }

        var checkOK = "0123456789";
        var checkStr = theForm.MobileNo.value;
        var allValid = true;
        var validGroups = true;
        var decPoints = 0;
        var allNum = "";
        for (i = 0;  i < checkStr.length;  i++)
        {
            ch = checkStr.charAt(i);
            for (j = 0;  j < checkOK.length;  j++)
                if (ch == checkOK.charAt(j))
                    break;
            if (j == checkOK.length)
            {
                allValid = false;
                break;
            }
            allNum += ch;
        }
        if (!allValid)
        {
            alert("Please enter only numeric characters for your mobile number.");
            theForm.MobileNo.focus();
            return (false);
        }

        if( !theForm.terms.checked ) {
            alert("You need to Agree with the Terms and Conditions.");
            return false;
        }
        return (true);
    }//-->
</script>

<div class="header1">Enter Your Mobile Number {Yname},</div>
<div class="header2">and find out your compatibility with {Lname}!</div>
<br /><br />

<form method="post" action="{DocumentRoot}/{ProductPath}/validate/{Country}/{Keyword}" target="_self" onSubmit="return ValidateForm(this)">
    <input type="hidden" name="Yname" value="{Yname}" />
    <input type="hidden" name="Lname" value="{Lname}" />

    <table align=center border=0 cellspacing=3>
        <tr>
            <td align=center>
                <div class="field_bg" style="padding-top:10px;"><input type="text" name="MobileNo" value="{Placeholder}" maxlength={MaxInputLength} /></div>
                Subscribe to Love Scopes for {Pricing}
            </td>
        </tr>
        <tr>
            <td align=center>{TermsCheckbox}</td>
        </tr>
        <tr>
            <td colspan=3>
                <input type="submit" value=" Continue " class="BigButton" />
            </td>
        </tr>
    </table>
</form>


<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>