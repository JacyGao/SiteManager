<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>
    <div id="header"><span>{Header_Note}</span></div>


    <div>
        <h2>{Q1_Notation}</h2>
        <h3>{Q1_Question}</h3>
        <ul>
            <?php foreach($Q1_Options as $key=>$answer): ?>
            <li><a href="{DocumentRoot}/iq/questions/{Country}/{Keyword}/{next_page}?q1=<?=$answer?>"><?=$answer?></a></li>
            <?php endforeach; ?>
        </ul>
        {Q1_HTML}
    </div>

    <div id="footer">

        <strong>Terms & Conditions: </strong>
        {Terms_And_Conditions}
        <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; 2012</span></p>
    </div>

    <?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>