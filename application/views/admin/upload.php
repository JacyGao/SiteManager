<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>
<h2>Note:</h2>
<p style="color: red;">1. To use this feature, Writing Permission must be enabled by site administrator</p>
<p style="color: red;">2. File format must be .jpg, .gif or .png</p>
<p style="color: red;">3. Image size must be less than 100K</p>
    <br><br>
<?php echo $error;?>

<?php echo form_open_multipart('/admin/do_upload/');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>
<br><br>
<h1>Existing Images:</h1>
<table>
    <tr>
    <th width="120px"><h2>Filename</h2></th>
    <th width="350px"><h2>Preview</h2></th>
    <th><h2>Delete</h2></th>
    </tr>
    <?php foreach($images as $img):?>
    <tr>
        <td><strong><?=$img?></strong></td>
        <td><img src="/custom/images/<?=$img?>" width="300px" height=""></td>
        <td><a href="/admin/deleteImage/<?=$img?>"><h3>Delete</h3></a></td>
    </tr>
    <?php endforeach;?>
</table>
<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>