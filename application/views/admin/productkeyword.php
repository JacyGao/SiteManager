<form>
    <input type="hidden" name="configid" id="configid" value="{configid}" />
    <table width=100% border=0 cellspacing=2 cellpadding=2>
    <tr>
        <td colspan=2 align="right"><input type="button" class="close" value="[close]" /></td>
    </tr>
    <tr>
        <td>Keyword</td>
        <td><input type="text" size="20" name="keyword" id="keyword" placeholder="enter single keyword" value="{keyword}" <?= ($traffic? "readonly":""); ?> /></td>
    </tr>
    <tr>
        <td>Pixel</td>
        <td><textarea name="pixel" cols=40 rows=4 placeholder="Affiliates pixel code / URL"><?=$traffic['pixel']?></textarea></td>
    </tr>
    <tr>
        <td>Place Holders</td>
        <td><code style="color:blue">%%SUB_ID%%</code> , <code style="color:blue">%%MOBILE%%</code> , <code style="color:blue">%%PIXEL_ID%%</code></td>
    </tr>
    <tr>
        <td colspan=2><small><i>Simply copy paste the place holder into the Pixel code where you wish to insert the data. (eg. <b>subid=%%SUB_ID%%</b> will send back the affiliates sub id back to them)</i></small></td>
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
    <? if($traffic): ?>
    <tr>
        <td colspan=2><br /></td>
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
    <? endif; ?>
    <tr>
        <td colspan=2><br /></td>
    </tr>

    <tr>
        <td>
            <input type="submit" class="save" style="background-color:lightgreen; font-weight:bold; padding:2px;" value="Save" />
        </td>
        <td align="right">
            <? if($traffic): ?>
            <input type="button" class="delete" style="background-color:lightcoral; padding:2px;" value="Delete Pixel" />
            <? endif; ?>
        </td>
    </tr>
    <tr>
        <td colspan=2><br />
        <p style="border-top:1px solid #333333;">
        <i><b>Note:</b> You need to make sure the following URL is triggered by the PSS Channel once the subscription is confirmed.<br />
        eg. Contain the following Subscription rule: <br />
        </i>
        </p>
        <p>
            <code>On 0 (zero) days active, Hit URL : </code><br />
            <code>http://worker.mobivate.com/pixels/?smconfig={configid}&[MOBILE]&[CHANNEL]&[KEYWORD]&[SERVICE]</code>
        </p>
        </td>
    </tr>
</table>
</form>