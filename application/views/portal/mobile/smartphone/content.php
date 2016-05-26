<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<?php if(isset($ShowMemberSection)) include( dirname(__FILE__)."/inc_member_section.php"); ?>

    <div class="post-loop search-loop">

    <div class="ribbon-shadow-left">&nbsp;</div>

    <div class="section-wrapper">

        <div class="section">{Title}</div>

    </div>

    <div class="ribbon-shadow-right">&nbsp;</div>

    <div class="section-arrow">&nbsp;</div>


        <? foreach ($Items as $item): ?>
        <div class="post-panel">
            <div class="post-thumbnail">
                <a class="darken small" href="<?=$DocumentRoot?>/<?=$ProductPath?>/item/<?=$Country?>/<?=$Keyword?>/<?=$item['id']?>/"><?= sprintf($item['image'], 70, 70); ?></a>
            </div>
            <div class="inner">
                <h2><a href="<?=$DocumentRoot?>/<?=$ProductPath?>/item/<?=$Country?>/<?=$Keyword?>/<?=$item['id']?>"><?=$item['title']?></a></h2>
                <div class="category">
                    <div class="catname"><a href="<?=$DocumentRoot?>/<?=$ProductPath?>/category/<?=$Country?>/<?=$Keyword?>/<?=$item['type']?>/<?=$item['category']?>"><?=$item['category']?></a></div>
                    <div class="catname"><a href="<?=$DocumentRoot?>/<?=$ProductPath?>/content/<?=$Country?>/<?=$Keyword?>/<?=$item['type']?>"><?=$item['type']?></a></div>
                </div>
                <div class="more"><a href="<?=$DocumentRoot?>/<?=$ProductPath?>/item/<?=$Country?>/<?=$Keyword?>/<?=$item['id']?>">Info</a></div>
            </div>
            <br class="clearer">
        </div>
        <br class="clearer">
        <? endforeach; ?>

        <div class="pagination-wrapper">

        <div class="pagination">
            {Pagination}
        </div>

        <br class="clearer">

    </div>

    <br class="clearer">

    </div>



<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>