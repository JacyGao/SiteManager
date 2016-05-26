<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

        <div>
            <h2>{Q1_Notation}</h2>
            <h3>{Q1_Question}</h3>
            <?php if( is_array($Q1_Options) ): ?>
            <ul>
                <?php foreach($Q1_Options as $key=>$answer): if($answer): ?>
                <li><a href="{DocumentRoot}/iq/questions/{Country}/{Keyword}/{next_page}?q1=<?=$answer?>"><?=$answer?></a></li>
                <?php endif; endforeach; ?>
            </ul>
            <?php endif; ?>
            {Q1_HTML}
        </div>

<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>