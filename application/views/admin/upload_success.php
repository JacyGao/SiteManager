<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<h3>Your file was successfully uploaded!</h3>

<ul>
    <?php foreach ($upload_data as $item => $value):?>
    <li><?php echo $item;?>: <?php echo $value;?></li>
    <?php endforeach; ?>
</ul>

<p><?php echo anchor('/admin/upload', 'Upload Another File!'); ?></p>


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>