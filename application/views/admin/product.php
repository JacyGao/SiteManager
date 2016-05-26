<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<? foreach($Countries as $country):  ?>


    <? if(sizeof($country['Subs']) > 0): ?>
        <h2><?=$Product['name']?> in <?=$country['name']?></h2>
        <div style="margin:10px;">
        <? foreach($country['Subs'] as $num=>$shortcode): ?>
            <div style="width:150px; float:left;"><a href="/admin/productcountry/<?=$Product['path']?>/<?=$country['iso']?>/<?=$num?>">Configure <b><?=$shortcode['Shortcode']?></b></a></div>
            <? if(trim($shortcode['properties']['Frequency'])): ?>
                <div style="width:100px; float:left;">[<a href="/<?=$Product['path']?>/index/<?=$country['iso']?><?=$num?>/preview/" target="preview">preview</a>]</div>
            <? endif; ?>
            <div style="clear:both;"></div>
            <div style="width:150px; float:left;"><small><b>Sitename</b></small></div>
            <div style="width:100px; float:left;"><small><?=$shortcode['Sitename']? $shortcode['Sitename']:"N/A" ?></small></div>
            <div style="clear:both;"></div>
            <div style="width:150px; float:left;"><small><b>Pricing</b></small></div>
            <div style="width:100px; float:left;"><small><?=$shortcode['Pricing']? $shortcode['Pricing']:"N/A"?></small></div>
            <div style="clear:both;"></div>
            <div style="width:150px; float:left;"><small><b>Joining Fee</b></small></div>
            <div style="width:100px; float:left;"><small><?=$shortcode['Joining_Fee']? $shortcode['Joining_Fee']:"N/A"?></small></div>
            <div style="clear:both;"></div>
            <div style="width:150px; float:left;"><small><b>Keywords</b></small> </div>
            <div style="width:500px; float:left;">
                <ul style="list-style: none; ">
                    <? foreach($shortcode['keywords'] as $kw): ?>
                    <li style="width:auto; float:left; margin-right:10px;"><button class="keyword" rel="<?=$shortcode['confid']?>" style="padding:2px;"><?=$kw?></button></li>
                    <? endforeach; ?>
                </ul>
                <button class="new_keyword" rel="<?=$shortcode['confid']?>" style="padding:2px; background-color:gold;"><span>Add New</span></button>
            </div>
            <div style="clear:both;"></div>
        <? endforeach; ?>
        </div>
    <? endif; ?>

<? endforeach; ?>
<div id="keywordpopup" style="position:absolute; width:400px; height:auto; display:none; background-color:#EEEEEE; border:1px solid #333333; padding:4px; overflow: auto;"></div>

<script>

    function bindkeywordpopupform()
    {
        $('#keywordpopup').find('form').submit(function(e)
        {
            var $frm = $(this),
                $configid = $frm.find('#configid').val(),
                $keyword = $frm.find('#keyword').val();

            e.preventDefault();
            $.post('/admin/productkeyword/'+ $configid +'/'+ $keyword +'/save', $frm.serialize(), function(data)
            {
                if(data.ok)
                {
                    location.reload();
                    $('#keywordpopup').hide();

                }
                else
                {
                    alert(data.message);
                }
            }, 'json');
            return false;
        });
        $('#keywordpopup').find('input.close').click(function(e)
        {
            e.preventDefault();
            $('#keywordpopup').hide();
        });
        $('#keywordpopup').find('input.delete').click(function(e)
        {
            e.preventDefault();
            var $frm = $('#keywordpopup').find('form'),
                $configid = $frm.find('#configid').val(),
                $keyword = $frm.find('#keyword').val();

            $.post('/admin/productkeyword/'+ $configid +'/'+ $keyword +'/delete', {}, function(data)
            {
                if(data.ok)
                {
                    location.reload();
                    $('#keywordpopup').hide();

                }
                else
                {
                    alert(data.message);
                }
            }, 'json');
            $('#keywordpopup').hide();
        });
    }

    $(document).ready(function()
    {
        $('button.keyword').click(function(e)
        {
            e.preventDefault();
            var $this = $(this),
                $off = $this.position(),
                $id = $this.attr('rel'),
                $kw = $this.text();

            $('#keywordpopup').load('/admin/productkeyword/'+ $id +'/'+ $kw, function()
            {
                $('#keywordpopup').css('left', $off.left);
                $('#keywordpopup').css('top', $off.top+30);
                $('#keywordpopup').css('height', 'auto');
                $('#keywordpopup').show();
                bindkeywordpopupform();
            });
        });

        $('button.new_keyword').click(function(e)
        {
            e.preventDefault();
            var $this = $(this),
                $off = $this.position(),
                $id = $this.attr('rel');

            $('#keywordpopup').load('/admin/productkeyword/'+ $id, function()
            {
                $('#keywordpopup').css('left', $off.left);
                $('#keywordpopup').css('top', $off.top+30);
                $('#keywordpopup').css('height', 'auto');
                $('#keywordpopup').show();
                bindkeywordpopupform();
            });
        });
    });
</script>

<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>
