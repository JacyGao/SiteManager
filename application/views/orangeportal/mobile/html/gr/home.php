<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

{ContentTypes}
    <h2>{ContentType}</h2>
    {Link}
    <ul class="items">
    {Items}
        <li>{Item}</li>
    {/Items}
    </ul>
    <h3>Select your favourite category!!...</h3>
    <ul class="categories">
    {Categories}
        <li>{Category}</li>
    {/Categories}
    </ul>
{/ContentTypes}

<h2>Click below for</h2>
<ul class="links">
{Links}
    <li>{Link}</li>
{/Links}
</ul>


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>
