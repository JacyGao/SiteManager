<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<script src="http://www.appelsiini.net/projects/jeditable/jquery.jeditable.js"></script>

<h2>Add New Product</h2>
<form action="" method="POST" class="form">

    <fieldset>
        <label>ID</label><br />
        <input type="text" name="path" class="text" value="" placeholder="" />
    </fieldset>

    <fieldset>
        <label>Name</label><br />
        <input type="text" name="name" class="text" value="" placeholder="" />
    </fieldset>


    <input type="submit" value=" Save Changes " class="submit" />
</form>

<h2>Existing Products</h2>
<table class="table">
    <tbody>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Options</th>
    </tr>
    {ProductsTable}
    <tr>
        <td><div class="edit" id="{id}_path">{path}</div></td>
        <td><div class="edit" id="{id}_name">{name}</div></td>
        <td>[delete]</td>
    </tr>
    {/ProductsTable}
    </tbody>
</table>

<script>
    $(function() {
        $(".edit").editable("/admin/products/");
    });

</script>
<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>
