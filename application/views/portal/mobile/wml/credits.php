<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

            <h1>Credits</h1>


            <p>Below are the prices of each content type:</p>
                <br><br>
            <table width="280px">
                <tbody>
                <? foreach($Prices as $type=>$price): ?>
                <tr><th style="text-align:left;"><?=$type?></th><td><?=$price?> credits</td></tr>
                    <? endforeach; ?>
                </tbody>
            </table>

            <p>For more information, please contact</p>
            <p>{Contact_us_Text}</p>


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>