{DOCTYPE}
<html >
<head>
    {META}
    <title>{TITLE}</title>
    <link href="{Document_Root}/css/{ProductPath}/steps.css" rel="stylesheet" type="text/css" />


    <script Language="JavaScript" Type="text/javascript">
        function FormValidator(theForm)
        {

            if (theForm.terms && theForm.terms.checked == false)
            {
                alert("Please agree to the Terms and Conditions.");
                theForm.terms.focus();
                return (false);
            }

            if (theForm.MobileNo.value == "")
            {
                alert("Your cell number is incorrect, please enter it again.");
                theForm.MobileNo.focus();
                return (false);
            }

            if (theForm.MobileNo.value.length < 10)
            {
                alert("Your cell number is incorrect, please enter at least 10 characters.");
                theForm.MobileNo.focus();
                return (false);
            }

            if (theForm.MobileNo.value.length > 10)
            {
                alert("Your cell number is incorrect, please enter at least 10 characters.");
                theForm.MobileNo.focus();
                return (false);
            }

            var checkOK = "0123456789-";
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
                alert("Please enter only numbers in the cell number field.");
                theForm.MobileNo.focus();
                return (false);
            }
            return (true);
        }
        function autotab(original,destination){
            if (original.getAttribute&&original.value.length==original.getAttribute("maxlength"))
                destination.focus()
        }

    </script>
</head>

<body style="margin:0px; padding;0px; overflow:hidden;">