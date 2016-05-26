<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<script src="http://www.appelsiini.net/projects/jeditable/jquery.jeditable.js"></script>

<h2>Add New User</h2>
<form action="" method="POST" class="form">

    <fieldset>
        <label>Username</label><br />
        <input type="text" name="username" class="text" value="" placeholder="" />
    </fieldset>
    <fieldset>
        <label>Password</label><br />
        <input type="password" name="password" class="text" value=""  />
    </fieldset>

    <fieldset>
        <label style="white-space: nowrap;">Repeat Password</label><br />
        <input type="password" name="password2" class="text" value=""  />
    </fieldset>

    <input type="submit" value=" Save Changes " class="submit" />
</form>

<h2>Existing Users</h2>
<table class="table">
    <tbody>
    <tr>
        <th>Username</th>
        <th>Password</th>
    </tr>
    {Users}
    <tr>
        <td><div class="edit" id="{id}_username">{username}</div></td>
        <td><button class="grantdomains" rel="{id}">Domains</button></td>
        <td>[delete]</td>
    </tr>
    {/Users}
    </tbody>
</table>
<div id="domainpopup" style="position:absolute; width:300px; height:auto; display:none; background-color:#EEEEEE; border:1px solid #333333; padding:4px; overflow: auto;"></div>

<script>
    $(function() {
        $(".edit").editable("/admin/users/");

        $('.grantdomains').click(function(e)
        {
            e.preventDefault();
            var $this = $(this),
                $off = $this.position(),
                $id = $this.attr('rel');

            $('#domainpopup').load('/admin/usershosts/'+ $id, function()
            {
                $('#domainpopup').css('left', $off.left);
                $('#domainpopup').css('top', $off.top);
                $('#domainpopup').css('height', 'auto');
                $('#domainpopup').show();

            });
        });
    });



</script>
<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>
