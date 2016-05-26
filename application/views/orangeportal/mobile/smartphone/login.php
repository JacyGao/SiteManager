<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<?php if($Allow_Login): ?>
<!--Login Form-->		
<div class="image-slider" style="margin-top:15px;">

<table width="100%" border="0">
    <tr>

        <td width="85%" align="center" style="font-family:Arial, Helvetica, sans-serif; color:#FFF;">Please enter your mobile number</td>
    </tr>
    <tr>
   
    <td align="center">
      
      <form method="post" action="{DocumentRoot}/{ProductPath}/login_form/{Country}/{Keyword}/">
        
        <input type="text" id="mobile" name="mobile" type="text" size="15" required placeholder="07XXXXXXXXXX"
                            pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 25px;" maxlength="10" onblur="Minimum(this,10);"><br /><br />

        <? if($Login_Flow == LOGIN_FLOW_GOT_PIN): ?>

            <input name="pin" type="text" value="" maxlength="4" placeholder="Enter Your PIN">

        <? endif; ?>
        <input type="submit"   value="Login" class="cmd" />
        
        </form>
      
      </td>
  </tr>
</table>

</div>

<?php endif; ?>

<br />
    <p class="g1 center bld">Most Popular Downloads </p>
<!--Icons-->        
	<div class="image-slider">
            <table width="100%" border="0">
           
  <tr>
    <td width="33%" height="72"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/videos"><img src="/css/{ProductPath}/images/bvids.png" width="116" height="67" /></a></td>
   <td width="34%"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/Music"><img src="/css/{ProductPath}/images/bmusic.png" width="116" height="67" /></a></td>
   <td width="33%"><a href="{DocumentRoot}/{ProductPath}/content/{Country}/{Keyword}/games"><img src="/css/{ProductPath}/images/bgames.png" width="127" height="67" /></a></td>
    
  </tr>
  
</table>
</div>
		
    <p class="g1 bld center">  </p>

<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>
