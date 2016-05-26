<!--begin footer wrapper -->
<div id="footer-wrapper">

<div id="footer">

<div class="footer-menu">

    <a class="home-link" href="index.php">&nbsp;</a>

    <ul id="menu-footer-menu" class="menu">
        <?php foreach($MainMenu as $link): ?>
        <li><a href="<?=$link['url']?>"><?=$link['label']?></a></li>
        <?php endforeach; ?>
    </ul>

</div>

<br class="clearer" />

<div class="inner">


    <div class="complex-list all_reviews small">

        <div class="widget">

            <h2>Terms and Conditions</h2>

            <div class="textwidget">

                <p>{Terms_And_Conditions}</p>

            </div>

        </div>

    </div>




<br class="clearer" />

</div>

<div class="copyright">

    <div class="ribbon-shadow-left">&nbsp;</div>

    <div class="floatright">
        <div class="floatleft">
            <div class="textwidget"><p>Powered by  <a href="http://www.mobivate.com">Mobivate</a> © <?=date("Y")?></p></div>
        </div>
    </div>

    <br class="clearer" />

    <div class="ribbon-shadow-right">&nbsp;</div>

</div>

</div>

</div> <!--end footer wrapper-->

<img id="qrcode" src="http://www.mobivate.com/QR/?d=<?=urlencode("URL=http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");?>" style="position:fixed; top:10px; right:10px; z-index:999; opacity:0.3;" title="Scan the code to open the page on your mobile device" />

<script type="text/javascript" src="/css/portal/web/js/plugins.js"></script> <!-- jquery plugin js -->


<!-- need to setup review category tabs here since we don't know how many review types there are -->
<script type="text/javascript">
    jQuery.noConflict();

    //DOCUMENT.READY
    jQuery(document).ready(function() {
        //loop through each post type and setup a jquery tabs object
        jQuery('#tabbed-Restaurant-reviews > ul').tabs({ fx: { opacity: 'toggle', duration: 150 } });
        jQuery('#tabbed-Music-reviews > ul').tabs({ fx: { opacity: 'toggle', duration: 150 } });
        jQuery('#tabbed-Movie-reviews > ul').tabs({ fx: { opacity: 'toggle', duration: 150 } });
        jQuery('#tabbed-Fashion-reviews > ul').tabs({ fx: { opacity: 'toggle', duration: 150 } });
        jQuery('#tabbed-Product-reviews > ul').tabs({ fx: { opacity: 'toggle', duration: 150 } });

        //colorbox
        jQuery('.review .article-image a').colorbox({transition:'fade', speed:250});
        jQuery('.single-post .content .article-image a').colorbox({transition:'fade', speed:250});
        jQuery('.colorbox').colorbox({transition:'fade', speed:250});
        jQuery('.colorboxiframe').colorbox({transition:'fade', speed:250, iframe:true, innerWidth:640, innerHeight:390});
        jQuery(".page-content a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").colorbox();
        jQuery('.page-content .gallery a').colorbox({  rel:'gallery' });

        //initialize smooth div scroll on Don't Miss slider
        jQuery("#dontmiss").smoothDivScroll({
            autoScrollingMode: "always",
            autoScrollingDirection: "endlessloopright",
            autoScrollingStep: 1,
            autoScrollingInterval: 50
        });

        // Logo parade event handlers
        jQuery("#dontmiss").bind("mouseover", function() {
            jQuery(this).smoothDivScroll("stopAutoScrolling");
        }).bind("mouseout", function() {
                    jQuery(this).smoothDivScroll("startAutoScrolling");
                });

        /* uitotop scroller:
              var defaults = {
                    containerID: 'toTop', // fading element id
                  containerHoverID: 'toTopHover', // fading element hover id
                  scrollSpeed: 1200,
                  easingType: 'linear'
               };
              */

        jQuery().UItoTop({ easingType: 'easeOutExpo' });

        jQuery('#qrcode').bind("mouseover", function()
        {
            jQuery('#qrcode').fadeTo('slow', 1);
        }).bind("mouseout", function()
        {
            jQuery('#qrcode').fadeTo('slow', 0.3);
        });

    });

    //the reason they are here instead of in custom.js is because they contain php variables which can't
    //be applied in a .js file. Also, make sure these come before the darken function.

    //WINDOW.LOAD
    jQuery(window).load(function() {
        //spotlight slider
        jQuery(function() {
            jQuery(".main-content-left #spotlight-slider, .main-content-left #spotlight-slider-responsive").jCarouselLite({
                auto: 3000,
                easing: "easeInOutExpo",
                speed: 1100,
                visible: 2
            });
        });
        jQuery(function() {
            jQuery(".main-content #spotlight-slider, .main-content #spotlight-slider-responsive").jCarouselLite({
                auto: 3000,
                easing: "easeInOutExpo",
                speed: 1100,
                visible: 3
            });
        });
        //featured slider
        jQuery('#featured').nivoSlider({
            effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
            slices: 10, // For slice animations
            boxCols: 6, // For box animations
            boxRows: 3, // For box animations
            animSpeed: 200, // Slide transition speed
            pauseTime: 3000, // How long each slide will show
            startSlide: 0, // Set starting Slide (0 index)
            directionNav: true, // Next and Prev navigation
            directionNavHide: false, // Only show on hover
            controlNav: false, // 1,2,3... navigation
            controlNavThumbs: false, // Use thumbnails for Control Nav
            pauseOnHover: true, // Stop animation while hovering
            manualAdvance: false, // Force manual transitions
            prevText: 'Prev', // Prev directionNav text
            nextText: 'Next', // Next directionNav text
            beforeChange: function(){}, // Triggers before a slide transition
            afterChange: function(){}, // Triggers after a slide transition
            slideshowEnd: function(){}, // Triggers after all slides have been shown
            lastSlide: function(){}, // Triggers when last slide is shown
            afterLoad: function(){} // Triggers when slider has loaded
        });

    });
</script>

<script type="text/javascript" src="/css/portal/web/js/custom.js"></script>
<!--
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
<script type="text/javascript" src="http://platform.tumblr.com/v1/share.js"></script>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<script src="http://widgets.digg.com/buttons.js" type="text/javascript"></script>
-->



</div>


</body>

</html>