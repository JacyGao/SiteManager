<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>


<div style="width:400px; margin:10px auto;">
    <table>
        <tr>
            <th style="border: 1px solid black;">Date</th>
            <th style="border: 1px solid black;">Unique Page Views</th>
            <th style="border: 1px solid black;">Unique Visitors</th>
        </tr>
    <?php for($i=0;$i<count($views);$i++){?>
        <tr>
            <td style="border: 1px solid black;"><?=$views[$i]['timestamp'];?></td>
            <td style="border: 1px solid black;"><?=$views[$i]['uri'];?></td>
            <td style="border: 1px solid black;"><?=$visitors[$i]['ip'];?></td>
        </tr>
    <?}?>
    </table>

    <div class="field">
    <a href="/admin/report/">GO BACK</a>
    </div>
</div>

<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>