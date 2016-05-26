<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<div class="item-slider" style="margin-top: 15px;;">

    <div class="center W100 g6">

        <div class="main-content-left">

            <?php if(isset($ShowMemberSection)) include(dirname(__FILE__) . "/inc_signup_section.php"); ?>
            
            <div class="post-loop search-loop">
                <p class="g1 bld center"> Popular {Title} </p>
                <? foreach ($Items as $item): ?>

                    <table class="center W100 g6">
                        <tr>
                            <td class="W30 Left ptbl5 val_top">

                                <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/"
                                   class="thumbnail darken small" title="<?=$item['title']?>"><?= sprintf($item['image'], 163, 109); ?></a>

                            </td>
                            <td class="Left ptbl5 val_top">
                                <p><?=$item['title'] ?></p>
                                <p><?=$item['type']?></p>
                                <a href="{DocumentRoot}/{ProductPath}/item/{Country}/{Keyword}/<?=$item['id']?>/" style="" class="szM bld c2 g5">Get It</a>

                            </td>
                        </tr>
                    </table>

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

        </div>

        <br class="clearer"/>


    </div>
    <!--end main wrapper dark-->

</div><!--end main white content wrapper -->


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>