<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

<? if( in_array($AFFILIATE, array('rng','rngtb','rnginc')) ): ?>
<script>
    var exitTraffic = function()
    {
        window.open('http://aff.ringtonepartner.com/geo/preset/4100/2/','_top','', true);
    }
    setTimeout('exitTraffic()',4000);
</script>
<? endif; ?>

<div id="q1">
    <br /><br /><br /><br /><br />
    <h3>
        Hello, you have completed your quiz and the score will be arriving to your phone shortly.
    </h3>

</div>

<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>