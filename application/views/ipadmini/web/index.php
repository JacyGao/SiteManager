{DOCTYPE}
<html>
<head>
    <title>{TITLE}</title>
    {META}

    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/default.css">

</head>

<body topmargin=0>
<div class="content">
<table>
    <tr>
        <td colspan=1 align="center" height=100><img src="{DocumentRoot}/css/{ProductPath}/images/left.jpg"/></td>
        <td colspan=1 align="center" height=100><span style="color:red; font-size: 25px;"><br>WIN A GREAT PRIZE!</span><br><span style="font-size: 25px;">& Get 1000 credits</span><br><br>

            <iframe src="{DocumentRoot}/{ProductPath}/question/{Country}/{Keyword}" width="350" height="350" allowtransparency="true" frameborder="0" border=0 style="background:none;"></iframe>

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

</div>
</body>
</html>