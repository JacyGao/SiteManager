<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<script src="http://www.appelsiini.net/projects/jeditable/jquery.jeditable.js"></script>

<h2>Add New Domain</h2>
<form action="" method="POST" class="form">

    <fieldset>
        <label>Domain / Host</label><br />
        <input type="text" name="hostname" class="text" value="" placeholder="www.domain.com" />
    </fieldset>
    <fieldset>
        <label>Client Name</label><br />
        <input type="text" name="sitename" class="text" value="" placeholder="Company Name" />
    </fieldset>

    <fieldset>
        <label>Homepage</label><br />
        <input type="text" name="homepage" class="text" value="" placeholder="no redirection" />
    </fieldset>

    <input type="submit" value=" Save Changes " class="submit" />
</form>

<h2>Existing Domains</h2>
<table class="table">
    <tbody>
    <tr>
        <th>Domain</th>
        <th>Client</th>
        <th>Homepage</th>
        <th>Options</th>
    </tr>
    {Domains}
    <tr>
        <td><div class="edit" id="{id}_hostname">{hostname}</div></td>
        <td><div class="edit" id="{id}_sitename">{sitename}</div></td>
        <td><div class="edit" id="{id}_homepage">{homepage}</div></td>
        <td>[delete]</td>
    </tr>
    {/Domains}
    </tbody>
</table>

<script>
    $(function() {
        $(".edit").editable("/admin/domains/");
    });

</script>
<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>
