<?php if (is_active_sidebar('down-single-note')) { ?>
    <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('down-single-note'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php
$articles_interest_block = RB_Gutenberg_Block::get_block('ta/articles-interest');
$articles_interest_block->render(array(
    'title'             => 'Test',
    'use_container'     => true,
    'color_context'     => 'light-blue-bg',
));
?>

<!-- <div class="ta-context dark-blue-bg">
    <?php //include_once(TA_THEME_PATH . '/markup/partes/relacionados-tema.php');  ?>
</div> -->

<?php include_once(TA_THEME_PATH . '/markup/partes/segun-tus-intereses.php');  ?>

<?php if (is_active_sidebar('note_mob_2')) { ?>
    <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('note_mob_2'); ?>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container-md">
    <div class="row">
        <div class="col-12 col-lg-8">
            <?php include_once(TA_THEME_PATH . '/markup/partes/comentarios.php');  ?>
        </div>
        <div class="col-12 col-lg-4">
            <?php if (is_active_sidebar('side-comments-note')) { ?>
                <div class="d-none d-sm-none d-md-block anuncio-side-comments-single">
                    <?php dynamic_sidebar('side-comments-note'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- abajo comentarios -->
<?php if (is_active_sidebar('down-comments-note')) { ?>
    <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('down-comments-note'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (is_active_sidebar('note_mob_5')) { ?>
    <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3">
        <div class="row d-flex">
            <div class="col-12 mx-auto text-center">
                <?php dynamic_sidebar('note_mob_5'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<!-- abajo comentarios -->

<?php get_template_part('parts/article', 'tambien_podes_leer', ['post_id' => get_the_ID()]); ?>
