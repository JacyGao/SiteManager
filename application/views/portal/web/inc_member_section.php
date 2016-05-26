<?php if($Allow_Signup || $Allow_Login): if(!isset($showSidebar)) $showSidebar = true; ?>
<!-- Begin membership area -->
<div id="featured-wrapper" class="<? if (!$showSidebar) echo "full" ?>">

    <script type="text/javascript">
        <!--//
        if (navigator.userAgent.indexOf("Firefox")==-1){

        function sizeFrame(id) {
            var F = document.getElementById(id);

            if(F.contentDocument) {
                return F.contentDocument.documentElement.scrollHeight+30;
            } else {
                return F.contentWindow.document.body.scrollHeight+30;
            }

        }
        }
        else{
            function sizeFrame(id) {

            }
        }
        //-->
    </script>

    <div class="ribbon-shadow-left">&nbsp;</div>
    <div class="section-wrapper">
        <div class="section">MEMBERSHIP</div>
    </div>
    <div class="section-arrow">&nbsp;</div>

    <?php $div_width = ($Allow_Signup && $Allow_Login)? "one_half":""; ?>

    <?php if($Allow_Signup): ?>
    <div class="<?=$div_width?> bg_dark1">
        <div id="not_a_member" class="container">

            <?php if($Signup_Flow == SUBSCRIBE_FLOW_MO): ?>
            <h1>SMS {Keyword} to {Shortcode}</h1>
            <?php else: ?>
            <iframe id="frmSignup" src="{DocumentRoot}/{ProductPath}/signup_form/{Country}/{Keyword}/" width=100% height=260 frameborder="0"></iframe>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if($Allow_Login): ?>
    <div class="<?=$div_width?> bg_dark2 last">
        <div id="already_a_member" class="container">
            <iframe id="frmLogin" src="{DocumentRoot}/{ProductPath}/login_form/{Country}/{Keyword}/" width=100% height=260 frameborder="0"></iframe>
        </div>
    </div>
    <?php endif; ?>
</div>
<br class="clearer"/>

<script>
    $(document).ready(function()
    {
       var h1 = sizeFrame('frmSignup');
       var h2 = sizeFrame('frmLogin');

      if(h1 > h2)
      {
          console.log('set height h1', h1);
          jQuery('#frmSignup').attr('height', h1);
          jQuery('#frmLogin').attr('height', h1);

      }
      else
      {
          console.log('set height h2', h2);
          jQuery('#frmSignup').attr('height', h2);
          jQuery('#frmLogin').attr('height', h2);
      }

    });
</script>

<?php endif; ?>
