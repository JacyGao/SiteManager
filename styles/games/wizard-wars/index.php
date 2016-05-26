<!doctype html>
<html lang=en>
<head>
	<title> Wizard Wars </title>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<link rel="apple-touch-startup-image" href="iphonestartup.png" />
	<link rel="stylesheet" type="text/css" href="iphone.css" media="only screen and (max-width: 480px)" />
	<link rel="stylesheet" type="text/css" href="desktop.css" media="screen and (min-width: 481px)" />
	<link rel="apple-touch-icon" href="appleicon.png" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="explorer.css" media="all" />
	<![endif]-->
	<script type="application/x-javascript" src="jquery-1.6.2.min.js"></script>
	<script type="application/x-javascript" src="library.js"></script>
	<script type="application/x-javascript" src="textdata.js"></script>
	<script type="application/x-javascript" src="classlib.js"></script>
	<script type="application/x-javascript" src="resources.js"></script>
	<script type="application/x-javascript" src="data.js"></script>
	<script type="application/x-javascript" src="game.js"></script>
	<script type="application/x-javascript" src="aselect.js"></script>
</head>
<body onload="init();" onkeydown="scanInput(event);" onkeyup="stopMove(event);" style="background-color:#000000;">

	<div id="game">
		<canvas width="320" height="480"></canvas>
		<div id="banad"></div>
		<div id="console"></div>
	</div>
	<div id="orientate"><img src="library/orientate.png" /></div>

</body>
</html>