{DOCTYPE}
<html>
<head>
    <title>{TITLE}</title>
    {META}
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/iq/reset.css">
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/iq/style.css">
</head>
<body>

<div id="container">
    <div id="header"><span>{Header_Note}</span></div>
    <div id="content"><iframe src="{DocumentRoot}/iq/questions/{Country}/{Keyword}/0" allowtransparency="true" width="100%" height="100%" border=0 frameborder="0"></iframe></div>
    <div id="footer">

        <strong>Terms & Conditions: </strong>
        {Terms_And_Conditions}
        <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
    </div>
</div>

</body>
</html>