<?php 
include_once(dirname(__FILE__)  . "/../includes/inc_head.php"); 

$Keyword = str_replace('_', ' ', $Keyword);  
?>

<div class="header">
    <div class="header-inner">
        <div class="logo"></div>
    </div>
</div>
<div class="main">
    <div class="main-inner">
        <a href="<?= $sms_link ?>">
            <img src="{DocumentRoot}/css/{ProductPath}/img/img.png" alt="Hottest tunes on your mobile" />
        </a>               
    </div>
    <div class="beam"></div>
</div>
<div class="bottom">
    <div class="bottom-inner">
        <div>
            <a href="<?= $sms_link ?>">
                <img src="{DocumentRoot}/css/{ProductPath}/img/button.png" alt="Click here to listen">
            </a> 
        </div>        
        <div class="text-join">
            SMS <span><?= $Keyword ?></span> TO <span>{Shortcode}</span>
        </div>      
    </div>
</div>

<?php include_once(dirname(__FILE__)  . "/../includes/inc_foot.php"); ?>