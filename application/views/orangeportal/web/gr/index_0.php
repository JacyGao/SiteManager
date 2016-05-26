<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="/css/{ProductPath}/style.css" type="text/css" media="all" />
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		
		<title>home</title>
		<meta http-equiv="Cache-Control" content="must-revalidate" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	<body>
    
    <!-- Signup and members login -->
	<div class="header">
        <table class="center W100 g1">    
        <tr>
        <td width="25%" class="Center W15">
        <p>&nbsp;</p>
        <p><a accesskey="7" href="" class="ac"></a></p>    
        </td>    
        <td width="25%" class="Center W15">
        
        </td>
            <?php foreach($MainMenu as $link): ?>
            <td class="Center W15">
            <img width="25" height="25" src="/css/{ProductPath}/images/<?=$link['label']?>.png" alt="" />
            <p>
                <a class="ac" href="<?=$link['url']?>"><?=$link['label']?></a>
            </p>
            </td>
            <?php endforeach; ?>

            </tr>
            </table>
            </div>
            <div/>
    <!-- Signup and members login -->
	<div class="wrap"> </div>
<!-- Logo Start -->		
		<div class="wrap"> 
        </div>
		<div class="sub-header">
		<div class="wrap">
        <div class="wrap"> </div>
		<div class="logo">
		<table width="100%" border="0">
  		<tr>
    	<td align="center"><a href="index.php"><img src="/custom/images/mm_logo.png" width="253" height="59" title="logo"/></a></td>
  		</tr>
		</table>
		</div><!-- class logo-->
		</div><!-- inner wrap -->
		</div><!-- sub header-->
<!-- Logo finish -->
		<div class="clear">
			
		</div>
<!-- Mebu-->
<div/>
        <div class="header">
        <table class="center W100 g1">    
        <tr>
            <!-- Home, Music , Games and Videos Menu-->
            <?php foreach($SecondMenu as $link): ?>
                <td class="Center W15">
                    <img width="25" height="25" src="/css/{ProductPath}/images/<?=$link['label']?>.png" alt="" />
                    <p>
                        <a class="ac" href="<?=$link['url']?>"><?=$link['label']?></a>
                    </p>
                </td>
            <?php endforeach; ?>

        </tr>
        </table>
		</div>
<!-- menu finish -->			
		
		<div class="clear">
			
		</div>
<!-- bar most popular -->		
			<div class="icons">
            <p class="g1 bld" align="center">  Most Popular Downloads </p>
			</div>
<!-- bar-->

<!-- buttons -->
<div class="icons">
            <table width="100%" border="0">
            <tr>
    			<td width="33%" height="72" align="center">
                <a href="videos.php">
                <img src="/css/{ProductPath}/images/bvids.png" width="116" height="67" /></a>
                </td>
   				<td width="34%" align="center">
                <a href="music.php">
                <img src="/css/{ProductPath}/images/bmusic.png" width="116" height="67" />
                </a>
                </td>
   				<td width="33%">
                <a href="games.php">
                <img src="/css/{ProductPath}/images/bgames.png" width="127" height="67" />
                </a>
                </td>
    			</tr>
  				</table>
</div>

<!-- contents-->
                <? $limit = 3; foreach ($ContentTypes as $cat=> $items): if ($limit-- > 0): ?>

                    <!-- auto bar is created depending on category-->
                    <p class="g1 bld center"> <?=$cat;?> </p>
                    <!-- displaying contents -->

                    <? $i = 1; foreach ($items as $item): ?>
                        <div<? if ($i % 3 == 0) echo "";?>>
                            <div class="item-slider">
                                <table class="center W100 g6">
                                    <tr>
                                        <td class="W30 Left ptbl5 val_top">
                                            <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/<?=preg_replace("/[^0-9A-Za-z\-]/", "", $item['title']) ?>"
                                               class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['preview']['mobile'], 163, 109); ?></a>
                                        </td>
                                        <td class="Left ptbl5 val_top"><p><?=$item['title']?></p>
                                            <a href="" style=" " class="szM bld c2 g5">Get It</a>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <? endforeach; ?>
                <? endif; endforeach; ?>
<!-- Banner-->
        <div class="image-slider"><center>
<img src="../../../styles/mobilemojo/images/banner/ban_1.gif" width="331" height="53" />
</center>
</div>
	<div class="clear"> </div>
<!-- Footer -->
		<div class="footer">
			<div class="wrap">
<!-- Footer Details -->
            <h3 class="cart1">Ts & Cs</h3>
			<div class="footer-grids">
			<div class="clear"> </div>
		</div>
		</div>
		<div class="clear"> </div>
		</div>
		<div class="clear"> </div>
		<div class="footer1">
	<p class="link"><span style="font-family:Arial, Helvetica, sans-serif;">© All rights Reserved&nbsp;| Power By Mobivate <a href=""> </a>	</span></p>
</div>


	</body>
</html>

