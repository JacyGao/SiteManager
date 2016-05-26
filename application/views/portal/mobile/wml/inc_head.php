{WRAPPER_START}
<card id="page" title="{TITLE}">
    <p><small>{Header_Note}</small></p>
    <p><img src="/custom/images/header.jpg" width="100%" alt="{TITLE}" /></p>

    <p>
        <select title="Navigation" name="selection">
        <?php foreach($MainMenu as $link): ?>
            <option value="<?=$link['url']?>" onpick="<?=$link['url']?>"><?=$link['label']?></option>
        <?php endforeach; ?>
        </select>
    </p>

    <p>
