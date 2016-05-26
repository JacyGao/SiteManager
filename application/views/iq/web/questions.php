<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

    <?php if($next_page): ?>
    <form action="{DocumentRoot}/iq/questions/{Country}/{Keyword}/{next_page}" method="GET" onsubmit="if( isChecked(this.q1, <?php if(is_array($Q2_Options) && sizeof($Q2_Options) > 0): ?>this.q2<?php else: ?>this.q1<?php endif; ?>) ) {  if(this.agree && this.agree.checked == false) { alert('Please agree to the Terms and Conditions.'); return false; } return true; } return false;">
    <?php endif; ?>
        <div class="x5">
            <h2>{Q1_Notation}</h2>
            <h3>{Q1_Question}</h3>
            <ul style="margin-top:0px;">
                <?php foreach($Q1_Options as $key=>$answer): if($answer): ?>
                <li><input type="radio" name="q1" value="<?=$answer?>" id="q1<?=md5($answer)?>" /> <label for="q1<?=md5($answer)?>"><?=$answer?></label></li>
                <?php endif; endforeach; ?>
            </ul>
            {Q1_HTML}
        </div>
        <div class="x2"></div>
        <div class="x5">
            <h2>{Q2_Notation}</h2>
            <h3>{Q2_Question}</h3>
            <?php if(is_array($Q2_Options) && sizeof($Q2_Options) > 0): ?>
            <ul>
                <?php foreach($Q2_Options as $key=>$answer): if($answer): ?>
                <li><input type="radio" name="q2" value="<?=$answer?>" id="q2<?=md5($answer)?>" /> <label for="q2<?=md5($answer)?>"><?=$answer?></label></li>
                <?php endif; endforeach; ?>
            </ul>
            <?php endif; ?>
            {Q2_HTML}

            <?php if($next_page == $total_pages): ?>
                <p align="center"><input type="submit" id="submit" value=""></p>
            <?php endif; ?>

        </div>
    <?php if($next_page): ?>
        <?php if($next_page < $total_pages): ?>
            <input id="nextButton" type="submit"  value="" />
        <?php endif; ?>

    </form>
    <?php endif; ?>

<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>