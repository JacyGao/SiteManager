{DOCTYPE}
<html>
<head>
    <title>{TITLE}</title>
    {CSS}
</head>

{WRAPPER_START}

    <img src="/custom/images/header.jpg" width="100%" alt="{TITLE}"  border=0/>




<div style="text-align:center;"><font style="font-size:54px;">Choose Country</font><br /></div>

            <? foreach($Countries as $code => $country): $iso = preg_replace("/[^a-z]/","",$code); ?>


                        <a href="{DocumentRoot}/{Prod_path}/index/<?=$code?>/{Landing_Keyword}">
                            <img src="{DocumentRoot}/css/{ProductPath}/images/flag_<?=$iso?>.png" width="118" height="108"  border="0" /></a>

                    <? /*
                    <td>

                        <ul>
                            <? foreach($country['products'] as $prod): ?>
                                <li>
                                    <font style="font-size:34px;">
                                    <a href="<?=$prod['url']?>"><?=$prod['name']?></a>
                                    </font>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </td>
        */?>

            <? endforeach; ?>

{WRAPPER_END}
