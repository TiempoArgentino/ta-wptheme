<?php

$featured = isset($articles[0]) ? $articles[0] : null;
$regular_1 = isset($articles[1]) ? $articles[1] : null;
$regular_2 = isset($articles[2]) ? $articles[2] : null;
$regular_3 =isset($articles[3]) ? $articles[3] : null;

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
        <?php $regular_1 ? ta_render_article_preview($regular_1, $regular_config) : null; ?>
        <?php $regular_2 ? ta_render_article_preview($regular_2, $regular_config) : null; ?>
        <?php $regular_3 ? ta_render_article_preview($regular_3, $regular_config) : null; ?>
    </div>
</div>
