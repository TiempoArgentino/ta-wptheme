<?php

$featured = $articles[0];
$regular_1 = $articles[1];
$regular_2 = $articles[2];
$regular_3 = $articles[3];

$regular_config = array(
    'size'                  => 'common',
    'class'                 => '',
    'desktop_horizontal'    => true,
);

register_articles_block_cells_count(4);
?>

<div class="ta-articles-block d-flex flex-column flex-md-row mt-3 row">
    <div class="col-12 col-md-6">
        <?php
        ta_render_article_preview($featured, array(
            'size'  => 'large',
            'class' => '',
        ));
        ?>
    </div>
    <div class="col-12 col-md-6">
        <?php
        ta_render_article_preview($regular_1, $regular_config);
        ?>
        <?php
        ta_render_article_preview($regular_2, $regular_config);
        ?>
        <?php
        ta_render_article_preview($regular_3, $regular_config);
        ?>
    </div>
</div>
