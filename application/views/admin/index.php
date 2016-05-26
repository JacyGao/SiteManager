<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

<h1>Welcome to SiteMananger Administration</h1>

<form action="" method="POST" class="form">

    <fieldset>
        <label>Client Name</label><br />
        <input type="text" name="sitename" class="text" value="<?=$Host['sitename']?>" />
    </fieldset>

    <fieldset>
        <label style="width:auto;">Homepage / Default Landing Page</label><br />
        <input type="text" name="homepage" class="text" value="<?=$Host['homepage']?>" placeholder="no redirection" />
    </fieldset>

    <input type="submit" value=" Save Changes " class="submit" />
</form>

<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>
