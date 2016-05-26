{DOCTYPE}
<? # http://www.mobirok.com/uk/lovecalculator/test/  ?>
<html>
<head>
    {META}
    <title>{TITLE}</title>
    <style>
        .footer { padding:10px; text-align:justify; }
        .footer, .footer * { font-size:12px; color:white; font-family:Arial, Helvetica, sans-serif; }
    </style>
</head>
<body style="background-color:#bd1e2d; background-image:url({DocumentRoot}/css/{ProductPath}/images/bg.jpg); background-position:top left; background-repeat:repeat-y;">

<table width=770 align=center border=0 cellspacing=0 cellpadding=0>
    <tr>
        <td align=right colspan=4 height=23 valign=top><span style="font-size:16px; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif;">{Header_Note}</span></td>
    </tr>

    <tr valign=top>
        <td width="33" rowspan=3><img src="{DocumentRoot}/css/{ProductPath}/images/r1c1.jpg" width="33" height="422" /></td>
        <td width="318" height="198"><img src="{DocumentRoot}/css/{ProductPath}/images/r1c2.jpg" width="318" height="198" /></td>
        <td width="209" height="198"><img src="{DocumentRoot}/css/{ProductPath}/images/r1c3.jpg" width="209" height="198" /></td>
        <td width="210" height="198"><img src="{DocumentRoot}/css/{ProductPath}/images/r1c4.jpg" width="210" height="198" /></td>
    </tr>
    <tr valign=top>
        <td width="318"><img src="{DocumentRoot}/css/{ProductPath}/images/r2-3c1.jpg" width="318" height="241" /><img src="{DocumentRoot}/css/{ProductPath}/images/r4c1.jpg" width="318" height="174" /></td>
        <td width="419"colspan=2 style="background-image:url({DocumentRoot}/css/{ProductPath}/images/r3-4c1-2.jpg); background-repeat:no-repeat; background-position:left bottom;"><img src="{DocumentRoot}/css/{ProductPath}/images/r2c2-3.jpg" width="419" height="97" /><br />
            <iframe src="{DocumentRoot}/{ProductPath}/enternames/{Country}/{Keyword}" style="margin-left:20px; margin-top:10px;" width=360 height=275 border=0 frameborder=0 allowtransparency=yes border=0 scrolling=no></iframe>
        </td>
    </tr>
    <tr>
        <td colspan=3 class="footer"><p>
            <strong>Terms &amp; Conditions:</strong>
            {Terms_And_Conditions}
        </p></td>
    </tr>
    </tr>
</table>

</body>
</html>