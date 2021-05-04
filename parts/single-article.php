<!-- widget sobre la nota -->
<?php if (is_active_sidebar('over-single-note')) { ?>
    <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('over-single-note'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (is_active_sidebar('note_mob_1')) { ?>
    <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 mt-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('note_mob_1'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<!-- widget sobre la nota -->
<div class="container-fluid container-lg p-0 ">
    <div class="d-flex col-12 flex-column flex-lg-row align-items-start p-0">
        <div class="col-12 col-lg-8 p-0">
            <?php include_once(TA_THEME_PATH . '/markup/partes/articulo-simple.php');  ?>

            <?php include_once(TA_THEME_PATH . '/markup/partes/tags.php');  ?>
            <?php if (is_active_sidebar('note_mob_1')) { ?>

                <div class="row d-flex d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 mt-3">
                    <div class="col-9 mx-auto">
                        <?php dynamic_sidebar('note_mob_1'); ?>
                    </div>
                </div>

            <?php } ?>
            <?php include_once(TA_THEME_PATH . '/markup/partes/mira-tambien.php');  ?>
            <div class="container-md mb-2 p-0">
                <div class="separator"></div>
            </div>
            <?php include_once(TA_THEME_PATH . '/markup/partes/audiovisual.php');  ?>
        </div>
        <div class="col-12 col-lg-4 p-0">
            <div class="d-flex flex-column flex-lg-column-reverse">
                <div class="container-md p-0 line-height-0 mt-3 d-block d-md-none">
                    <div class="separator"></div>
                </div>
                <div class="ta-context light-blue-bg">
                    <?php include_once(TA_THEME_PATH . '/markup/partes/newsletter.php');  ?>
                </div>
                <?php if (is_active_sidebar('note_mob_4')) { ?>
                    <div class="d-block d-sm-none d-md-none d-lg-none text-center mx-auto mt-3">
                        <?php dynamic_sidebar('note_mob_4'); ?>
                    </div>
                <?php } ?>
                <div class="container-md mb-2 p-0 d-block d-md-none">
                    <div class="separator"></div>
                </div>

                <?php include_once(TA_THEME_PATH . '/markup/partes/mas-leidas.php');
                ?>
            </div>
            <div class="container-md mb-2 p-0 d-none d-md-block">
                <div class="separator"></div>
            </div>
            <div class="d-none d-md-block">
                <?php //include(TA_THEME_PATH . '/markup/partes/taller-relacionado.php');
                ?>
            </div>
            <?php if (is_active_sidebar('side-single-note')) { ?>
                <div class="d-none d-sm-none d-md-block anuncio-side-single">
                    <?php dynamic_sidebar('side-single-note'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
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
<div class="container-md p-0">
    <div class="separator"></div>
</div>

<div class="d-block d-md-none">
    <?php //include(TA_THEME_PATH . '/markup/partes/taller-relacionado.php');
    ?>
</div>
<div class="container-md">
    <div class="col-12 col-lg-8">

    </div>
</div>

<div class="ta-context dark-blue-bg">
    <?php include_once(TA_THEME_PATH . '/markup/partes/relacionados-tema.php');  ?>
</div>

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
<?php
$articles_block = RB_Gutenberg_Block::get_block('ta/articles');
$articles = get_ta_articles_from_query(array(
    'post_type' => 'ta_article',
));

//include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
$articles_block->render(array(
    'articles'          => $articles,
    'articles_type'     => 'article_post',
    'container_title'   => 'También podés leer',
    'color_context'     => 'light-blue-bg',
    'layout'            => '',
    'use_container'     => true,
));

?>
