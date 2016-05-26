<div id="permissionwindow">
    <h3 style="float:left;">Grant permissions</h3>
    <a style="float:right; cursor:pointer;" id="closeWindow">[x]</a>

    <div style="clear:both;"></div>
    <div style="text-align:right; border-bottom:1px solid #333333; margin:10px 0px; "><input type="checkbox" value="super" <?= ($IsSuper? "checked":"") ?> > <b>Super User?</b></div>

    <table width=100% border=0 cellspacing=0 cellpadding=2>
        <thead>
            <th>Domain</th>
            <th>Granted</th>
        </thead>
        <tbody>
        <? foreach($Domains as $rs): ?>
        <tr align=center>
            <td class="<?= ($rs['granted']? "granted":"") ?>"><?=$rs['hostname']?></td>
            <td><input type="checkbox" value="<?=$rs['id']?>" <?= ($rs['granted']? "checked":"") ?> <?= ($IsSuper? "disabled":"") ?> /></td>
        </tr>
        <? endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(function() {
        $('#permissionwindow input[type="checkbox"]').click(function(e)
        {
            e.preventDefault();
            var $this = $(this),
                $value = $this.attr('value'),
                $checked = $this.is(':checked');

            $('#permissionwindow').load('/admin/usershosts/{UserID}/'+ $value +'/'+ ($checked? 'grant':'revoke') );
            $('#permissionwindow').parent().hide();

        });

        $('#closeWindow').click(function()
        {
            $('#permissionwindow').parent().hide();
        });
    });



</script>