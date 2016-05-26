{DOCTYPE}
<html>
<head>
    <title>{TITLE}</title>
    {META}

    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/mobile.css">

</head>

<body topmargin=0>
<table  border="0" width="731" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan=2 align="right">
            <div style="height:25px; font-size:11px; font-weight:bold; text-align:right; color:#CCCCCC;">{Header_Note}</div>
        </td>
    </tr>
    <tr valign=top>
        <td colspan=2 align="center" height=100><img src="{DocumentRoot}/css/{ProductPath}/images/header.jpg" height="82"   /></td>
    </tr>
    <tr align="left">
        <td width="373"><img src="{DocumentRoot}/css/{ProductPath}/images/middle_left.png" width="373" height="376" /></td>
        <td width="356" height="376" valign="bottom"  style="padding-left:10px; background-image:url({DocumentRoot}/css/{ProductPath}/images/middle_right.jpg); background-repeat:no-repeat;">
            <iframe src="{DocumentRoot}/{ProductPath}/question/{Country}/{Keyword}" width="350" height="310" allowtransparency="true" frameborder="0" border=0 style="background:none;"></iframe>
        </td>
    </tr>
    <tr>
        <td colspan=2 class="footer">
            <strong>Terms & Conditions:</strong>
            {Terms_And_Conditions}

            <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
        </td>
    </tr>
</table>


</body>
</html>