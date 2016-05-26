<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<script src="http://www.appelsiini.net/projects/jeditable/jquery.jeditable.js"></script>

<h2>Add New Country</h2>
<form action="" method="POST" class="form">

    <fieldset>
        <label>ISO</label><br />
        <input type="text" name="iso" class="text" value="" placeholder="ISO Code" />
    </fieldset>
    <fieldset>
        <label>Name</label><br />
        <input type="text" name="name" class="text" value="" placeholder="Country Name" />
    </fieldset>

    <fieldset>
        <label>Currency</label><br />
        <input type="text" name="currency" class="text" value="" placeholder="" />
    </fieldset>
    <fieldset>
        <label>Prefix</label><br />
        <input type="text" name="prefix" class="text" value="" placeholder="" />
    </fieldset>
    <fieldset>
        <label>Min. Length</label><br />
        <input type="number" name="minlength" class="text" value="" placeholder="" />
    </fieldset>
    <fieldset>
        <label>Max. Length</label><br />
        <input type="number" name="maxlength" class="text" value="" placeholder="" />
    </fieldset>
    <fieldset>
        <label>Placeholder</label><br />
        <input type="text" name="placeholder" class="text" value="" placeholder="" />
    </fieldset>
    <fieldset>
        <label>Example</label><br />
        <input type="text" name="example" class="text" value="" placeholder="" />
    </fieldset>
    <fieldset>
        <label>Manual Network Selection</label><br />
        <input type="radio" name="selectnetwork" value="0" checked /> No &nbsp;&nbsp;&nbsp;
        <input type="radio" name="selectnetwork" value="1" /> Yes
    </fieldset>

    <input type="submit" value=" Save Changes " class="submit" />
</form>

<h2>Existing Countries</h2>
<table class="table">
    <tbody>
    <tr>
        <th>ISO</th>
        <th>Name</th>
        <th>Currency</th>
        <th>Prefix</th>
        <th>Min.length</th>
        <th>Max.length</th>
        <th>Placeholder</th>
        <th>Example</th>
        <th>Network Selection</th>
    </tr>
    {Countries}
    <tr>
        <td><div class="edit" id="{id}_iso">{iso}</div></td>
        <td><div class="edit" id="{id}_name">{name}</div></td>
        <td><div class="edit" id="{id}_currency">{currency}</div></td>
        <td><div class="edit" id="{id}_prefix">{prefix}</div></td>
        <td><div class="edit" id="{id}_minlength">{minlength}</div></td>
        <td><div class="edit" id="{id}_maxlength">{maxlength}</div></td>
        <td><div class="edit" id="{id}_placeholder">{placeholder}</div></td>
        <td><div class="edit" id="{id}_example">{example}</div></td>
        <td><div class="edit" id="{id}_selectnetwork" >{selectnetwork}</div></td>
        <td>[delete]</td>
    </tr>
    {/Countries}
    </tbody>
</table>

<script>
    $(function() {
        $(".edit").editable("/admin/countries/");
    });

</script>
<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>
