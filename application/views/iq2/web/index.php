{DOCTYPE}
<? # http://www.mobirok.com/uk/iq/test/ ?>
<html>
<head>
    {META}
    <title>{TITLE}</title>
    <style>
        * { font-family:Arial, Helvetica, sans-serif; text-decoration:none; }
        body { background-color:#DDDDDD; }
        .mainTable {  }
    </style>
    <!--[if IE 7]>
    <style>
        .mainTable { width:101%; }
    </style>
    <![endif]-->
    <script language="javascript">
        var winWidth, winHeight, d=document;
        if (typeof window.innerWidth!='undefined') {
            winWidth = window.innerWidth;
            winHeight = window.innerHeight;
        } else if ( d.documentElement
            && typeof d.documentElement.clientWidth!='undefined'
            && d.documentElement.clientWidth!=0 ) {
            winWidth = d.documentElement.clientWidth;
            winHeight = d.documentElement.clientHeight;
        } else if ( d.body
            && typeof d.body.clientWidth!='undefined') {
            winWidth = d.body.clientWidth;
            winHeight = d.body.clientHeight;
        }

        function fixWin() {
            var tbl = document.getElementById('mainTable');
            tbl.style.height = winHeight +'px';
        }
    </script>
</head>
<body  onLoad="fixWin();" scrolling="no" onResize="fixWin();" margintop="0" marginleft="0" marginheight="0" marginwidth="0">
<table id="mainTable" width="100%" height="100%" border=0 cellspacing=0 cellpadding=0 style="position:absolute; top:0px; left:0px; background-image:url('{DocumentRoot}/css/{ProductPath}/images/shadow_up.png'); background-position:top; background-repeat:repeat-x;">
    <tr>
        <td align=center valign="middle" style="background-image:url('{DocumentRoot}/css/{ProductPath}/images/shadow_down.png'); background-position:bottom; background-repeat:repeat-x;">
            <div style="text-align:right; margin-right:20px; font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#222222; height:25px;">{Header_Note}</div>
            <img src="{DocumentRoot}/css/{ProductPath}/images/header.png"  /><br /><br />
            <table  align=center border=0 cellspacing=0>
                <tr align=center>
                    <td width="263">&nbsp;</td>
                    <td>
                        <div id="TheBox" style="width:481px; height:449px; background-image:url({DocumentRoot}/css/{ProductPath}/images/box.png); background-repeat:no-repeat;">
                            <div style="margin:5px;">
                                <iframe allowtransparency="true" name="main" width=460 height=435 scrolling="no" frameborder=0 border=0 src="{DocumentRoot}/{ProductPath}/questions/{Country}/{Keyword}/0"></iframe>
                            </div>
                        </div>
                    </td>
                    <td width="263"><img src="{DocumentRoot}/css/{ProductPath}/images/light.png" width="263" height="400" border=0 /></td>
                </tr>
            </table>
            <br /><br />
            <div style="width:600px; color:#222222; font-size:12px; text-align:left;">

                <strong>Terms & Conditions:</strong>
                {Terms_And_Conditions}

            </div>
        </td>
    </tr>
</table>
</body>
</html>
