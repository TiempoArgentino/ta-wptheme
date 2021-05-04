<?php
$defaults = array(
    'articles'          => null,
    'max_num_pages'     => $wp_query ? $wp_query->max_num_pages : null,
    'current_page'      => max(1, get_query_var('paged')),
);
extract( array_merge( $defaults, $args ) );

if(!$articles)
    return;

$articles_block = RB_Gutenberg_Block::get_block('ta/articles');
?>
<div class="container-fluid container-lg mt-3">
    <div class="d-flex flex-column flex-md-row">
        <div class="col-12 col-md-8 p-0">
            <?php
                $articles_block->render(array(
                    'articles'          => $articles,
                    'rows'              => array(
                        array(
                            'format'            => 'common',
                            'cells_amount'      => -1,
                            'cells_per_row'     => 3,
                        ),
                    ),
                ));
            ?>
        </div>
        <div class="col-12 col-md-4 p-0">
            <?php include_once(TA_THEME_PATH . '/markup/partes/seamos-socios.php');  ?>
        </div>
    </div>
    <?php
    get_template_part('parts/common', 'pagination', array(
        'total'     => $max_num_pages,
        'current'   => $current_page,
    )); ?>
</div>
