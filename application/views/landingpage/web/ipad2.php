<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mo
 * Date: 24/07/13
 * Time: 14:39
 * To change this template use File | Settings | File Templates.
 */
$url = $_SERVER["REQUEST_URI"];
$tokens = explode('/', $url);
$page=$tokens[3];
$rest = substr($page, 0, 2);
$page = $rest;
$text = "For your chance to win an iPad mini
            and Subscribe to get the best Games and Music for R6/day on your phone";

?>
<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=2.0"  />

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<link href="{DocumentRoot}/css/{ProductPath}/images/ipad/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="{DocumentRoot}/css/{ProductPath}/images/ipad/css/media.css" media="screen" rel="stylesheet" type="text/css" />
<link href="{DocumentRoot}/css/{ProductPath}/images/ipad/css/ipad.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body class="page_index">
<div class="app-container">
<div class="row">
  <div class="twelve columns legal-text ">
    <p class="hide-for-small"> </p>
    <small class="show-for-small"> </small>
  </div>
</div>
<div class="row top-image">
  <div class="twelve columns top-image-container">
    <div class="hide-for-small" >
        <img class="show-for-landscape" src="{DocumentRoot}/css/{ProductPath}/images/ipad/header_normal.jpg">
    </div>
    <div class="show-for-small" >
        <img class="show-for-landscape" src="{DocumentRoot}/css/{ProductPath}/images/ipad/tiny-header-ani.gif">
    </div>
    <img class="show-for-portrait" src="{DocumentRoot}/css/{ProductPath}/images/ipad/header-portrait.jpg">
  </div>
</div>
<div class="row gray-area">
  <div class="twelve columns centered">
    <div class="row">
      <div class="twelve columns" >
        <div class="header-text">
          <span>Click the correct Apple logo</span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="twelve columns centered">
        <div class="app-questionarie hide-for-small">
<a href="entry.php">
          <img src="{DocumentRoot}/css/{ProductPath}/images/ipad/bleft.png">
</a>
<a href="entry.php">
          <img src="{DocumentRoot}/css/{ProductPath}/images/ipad/bright.png">
</a>
        </div>
        <div class="app-questionarie show-for-small">
          <div class="question-img">
<a href="entry.php">
          <img src="{DocumentRoot}/css/{ProductPath}/images/ipad/bleft.png">
</a>
<a href="entry.php">
          <img src="{DocumentRoot}/css/{ProductPath}/images/ipad/bright.png">
</a>
           </div>
        </div>
      </div>
    </div>
    <div class="row">

</div>
      </div>
</div>
</div>
<div class="row disclaimer-container">
    <div class="twelve columns centered compliance">
        <?php if($page == "sa"):?>
        <p style="text-align:center; font-size: 14px;">
            <? echo $text;?>
        </p>

            <strong>Terms & Conditions:</strong>
            {Terms_And_Conditions}
        <?php else: ?>
            <strong>Terms & Conditions:</strong>
            {Terms_And_Conditions}
        <?php endif;?>
    </div>
    <p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>

</div>
</div>
<!-- pixels here -->
<div id="pixel">
     </div>


</body>
</html>
