<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

    <?php if($next_page): ?>
    <form action="{DocumentRoot}/{ProductPath}/questions/{Country}/{Keyword}/{next_page}" method="GET" onsubmit="if( isChecked(this.q1, <?php if(is_array($Q2_Options) && sizeof($Q2_Options) > 0): ?>this.q2<?php else: ?>this.q1<?php endif; ?>) ) {  if(this.agree && this.agree.checked == false) { alert('Please agree to the Terms and Conditions.'); return false; } return true; } return false;">
    <?php endif; ?>
        <div class="content">
            <b class="blue tinierBigFont">{Q1_Notation}</b><br>
            <span>{Q1_Question}</span>
            <ul style="margin-top:0px;">
                <?php foreach($Q1_Options as $key=>$answer): ?>
                <li><input type="radio" name="q1" value="<?=$answer?>" id="q1<?=md5($answer)?>" /> <label for="q1<?=md5($answer)?>"><?=$answer?></label></li>
                <?php endforeach; ?>
            </ul>
            {Q1_HTML}

            <br />

            <b class="blue tinierBigFont">{Q2_Notation}</b><br>
            <span>{Q2_Question}</span>
            <?php if(is_array($Q2_Options) && sizeof($Q2_Options) > 0): ?>
            <ul style="margin-bottom: 15px;">
                <?php foreach($Q2_Options as $key=>$answer): ?>
                <li><input type="radio" name="q2" value="<?=$answer?>" id="q2<?=md5($answer)?>" /> <label for="q2<?=md5($answer)?>"><?=$answer?></label></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            {Q2_HTML}

            <?php if($next_page == 5): ?>
                <p align="center"><input type="submit" id="submit" value=" Submit "></p>
            <?php endif; ?>

        </div>
    <?php if($next_page): ?>
        <?php if($next_page < 5): ?>
            <input id="nextButton" type="submit"  value=" Next 2 Questions &gt;&gt; " />
        <?php endif; ?>

    </form>
    <?php endif; ?>

<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>