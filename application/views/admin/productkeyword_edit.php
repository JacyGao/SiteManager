<form><table width=100% border=0 cellspacing=2 cellpadding=2>
    <tr>
        <td colspan=2 align="right"><button onclick="$('#keywordpopup').hide(); return false;">[close]</button></td>
    </tr>
    <tr>
        <td>Keyword</td>
        <td><input type="text" size="15" value="{keyword}" readonly /></td>
    </tr>
    <tr>
        <td>Pixel</td>
        <td><input type="text" size="40" name="pixel" placeholder="Affiliates pixel code / URL" value="<?=$traffic['pixel']?>" /></td>
    </tr>
    <tr>
        <td nowrap="">Pixel Type</td>
        <td>
            <select name="pixeltype">
                <option value=""></option>
                <option value="<?=PIXELTYPE_HTML?>" <?= ($traffic['pixeltype'] == PIXELTYPE_HTML? "SELECTED":"") ?>>HTML Code (Client side)</option>
                <option value="<?=PIXELTYPE_S2S?>" <?= ($traffic['pixeltype'] == PIXELTYPE_S2S? "SELECTED":"") ?>>URL (Server2Server)</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Stats</td>
        <td>
            <table border=1 cellspacing=0 cellpadding=1>
                <thead>
                <tr>
                    <th colspan=2 style="border:1px solid black; border-bottom:none;">Visitors</th>
                    <th colspan=2 style="border:1px solid black; border-bottom:none;">Subscribers</th>
                    <th colspan=2 style="border:1px solid black; border-bottom:none;">Pixels Fired</th>
                </tr>
                <tr align="center">
                    <td style="border:1px solid black; border-bottom:none; border-right:1px dotted:#444444;">This Month</td>
                    <td style="border:1px solid black; border-bottom:none; border-left:none;">All Time</td>
                    <td style="border:1px solid black; border-bottom:none; border-right:1px dotted:#444444;">This Month</td>
                    <td style="border:1px solid black; border-bottom:none; border-left:none;">All Time</td>
                    <td style="border:1px solid black; border-bottom:none; border-right:1px dotted:#444444;">This Month</td>
                    <td style="border:1px solid black; border-bottom:none; border-left:none;">All Time</td>
                </tr>
                </thead>
                <tbody>
                <tr align="center">
                    <td style="border:1px solid black; border-top:none; border-right:1px dotted:#444444;"><?=$traffic['visitors']?></td>
                    <td style="border:1px solid black; border-top:none; border-left:none;"><?=$traffic['visitors_total']?></td>
                    <td style="border:1px solid black; border-top:none; border-right:1px dotted:#444444;"><?=$traffic['subscribers']?></td>
                    <td style="border:1px solid black; border-top:none; border-left:none;"><?=$traffic['subscribers_total']?></td>
                    <td style="border:1px solid black; border-top:none; border-right:1px dotted:#444444;"><?=$traffic['pixelfired']?></td>
                    <td style="border:1px solid black; border-top:none; border-left:none;"><?=$traffic['pixelfired_total']?></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" style="background-color:lightgreen; font-weight:bold; padding:2px;" value="Save" />
        </td>
        <td align="right">
            <input type="button" style="background-color:lightcoral; padding:2px;" value="Delete Pixel" />
        </td>
    </tr>
</table>
</form>