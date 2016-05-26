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

        return (true);
    }
    //-->
</script>

<div class="header1">Enter your name and his or her name</div>
<div class="header2">to find out how compatible you are!</div>
<br /><br /><br />
<form method="post" action="{DocumentRoot}/{ProductPath}/entermobile/{Country}/{Keyword}" target="_self" onSubmit="return ValidateForm(this)">
    <table align=center border=0 cellspacing=3>
        <tr align=center>
            <th>YOUR NAME</th>
            <td style="font-size:25px; font-weight:bold;" rowspan=2>&amp;</td>
            <th>HIS / HER NAME</th>
        </tr>
        <tr>
            <td class="field_bg"><input type="text" name="Yname" maxlength=10 /></td>
            <td class="field_bg"><input type="text" name="Lname" maxlength=10 /></td>
        </tr>

        <tr>
            <td colspan=3>
                <input type="submit" value=" Continue " class="BigButton" />
            </td>
        </tr>
    </table>
</form>


<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>