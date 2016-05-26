{DOCTYPE}
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    {META}
    <title>{TITLE}</title>
    <script language="JavaScript" type="text/javascript"><!--
    function ValidateForm(theForm)
    {

        if (theForm.terms && theForm.terms.checked == false)
        {
            alert("Please agree to the Terms and Conditions.");
            theForm.terms.focus();
            return false;
        }
        if (theForm.MobileNo.value == "")
        {
            alert("Please enter your mobile number!");
            theForm.MobileNo.focus();
            return (false);
        }

        if (theForm.MobileNo.value.length < 10)
        {
            alert("Please enter your mobile number!");
            theForm.MobileNo.focus();
            return (false);
        }

        if (theForm.MobileNo.value.length > 11)
        {
            alert("Sorry, your mobile number must not be more than 10 characters long.");
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
        return (true);
    }
    //--></script>
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/ipadquiz/iframe.css">
</head>
<body scroll=no style="overflow:hidden;">