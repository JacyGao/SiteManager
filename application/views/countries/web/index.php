{DOCTYPE}
<html>
<head>
    {META}
    <title>{TITLE}</title>
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/main.css">
    <script language="javascript" src="{DocumentRoot}/css/{ProductPath}/ajax.js"></script>
</head>
<body>

<center>
    <table border=0 cellspacing=0 cellpadding=0 width="674" bgcolor="#FFFFFF">
        <tbody>
        <tr>

            <td colspan="9"  align="center">

                <img src="/custom/images/header.jpg" width="100%" height="" alt="{TITLE}" border=0 >

            </td>
        </tr>


        <tr>
            <td colspan="10" style="background-image:url('{DocumentRoot}/css/{ProductPath}/images/hdr_blue.jpg'); background-repeat:repeat; color:#FFFFFF; font-size:12px;">
                &nbsp;&nbsp;<strong>CHOOSE COUNTRY</strong>
            </td>
        </tr>


        <tr>
           <td width="<?= (100/count($Countries)) ?>%">
            <? foreach($Countries as $code => $country): 
                  $iso = preg_replace("/[^a-z]/", "", strtolower($code));

                ?>
                <a href="{DocumentRoot}/{Prod_path}/index/<?=$code?>/{Landing_Keyword}"><img src="{DocumentRoot}/css/{ProductPath}/images/flag_<?=$iso?>.png" width="118" height="108"  border="0" /></a>
                <?/* old code
                <img src="{DocumentRoot}/css/{ProductPath}/images/flag_<?=$code?>.jpg" width="48" height="48" border="0" />
                <br />
                <b><?=$country['name']?></b><br />
                <? foreach($country['products'] as $prod): ?>
                &raquo; <a href="<?=$prod['url']?>"><?=$prod['name']?></a><br />
                <? endforeach; ?>
               */?>


            <? endforeach; ?>

            </td>
        </tr>

        </tbody>

    </table>
</center>

</body>
</html>
