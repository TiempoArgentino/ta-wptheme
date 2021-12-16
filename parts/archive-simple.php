<?php
$defaults = array(
    'articles'          => null,
    'max_num_pages'     => $wp_query ? $wp_query->max_num_pages : null,
    'current_page'      => max(1, get_query_var('paged')),
);
extract(array_merge($defaults, $args));

if (!$articles)
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
                        'format'                    => 'common',
                        'cells_amount'              => -1,
                        'cells_per_row'             => 3,
                        'deactivate_opinion_layout' => true,
                    ),
                ),
            ));
            ?>
        </div>
        <div class="col-12 col-md-4 p-0">

            <?php if (is_active_sidebar('seccion_mob_3')) { ?>
                <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 text-center mt-3">
                    <div class="row d-flex">
                        <div class="col-12 mx-auto text-center">
                            <?php dynamic_sidebar('seccion_mob_3'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            get_template_part('parts/common', 'seamos_socios', array(
                'title'                     => "En Tiempo Argentino hacemos periodismo sin condicionamientos.",
                'body'                      => "Nuestro único compromiso es con los lectores. Ayudá a sostener esta experiencia autogestiva y necesaria.",
                'btn'                       => "ASOCIATE",
            )); ?>

            <?php if (is_active_sidebar('seccion_desk_1')) { ?>
                <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
                    <div class="row d-flex">
                        <div class="col-9 mx-auto text-center">
                            <?php dynamic_sidebar('seccion_desk_1'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (is_active_sidebar('seccion_desk_2')) { ?>
                <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
                    <div class="row d-flex">
                        <div class="col-9 mx-auto text-center">
                            <?php dynamic_sidebar('seccion_desk_2'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>


        </div>
    </div>
    <?php
    get_template_part('parts/common', 'pagination', array(
        'total'     => $max_num_pages,
        'current'   => $current_page,
    )); ?>

    <?php if (is_active_sidebar('seccion_mob_4')) { ?>
        <div class="row d-block d-sm-none d-md-none d-lg-none">

            <div class="container  mt-md-3 mb-md-3 text-center mt-3">
                <div class="row d-flex">
                    <div class="col-12 mx-auto text-center">
                        <?php dynamic_sidebar('seccion_mob_4'); ?>
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
</div>
