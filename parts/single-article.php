<?php
$article = TA_Article_Factory::get_article($post);

$date = $article->get_date_day('d/m/Y');

$thumbnail = $article->get_thumbnail();
$section = $article->section;
$author = $article->first_author;
$authors = $article->authors;
?>
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

            <!-- ARTICLE BODY -->
            <div class="articulo-simple text-right my-4">
                <?php TA_Blocks_Container_Manager::open_new(); ?>
                    <div class="text-left mx-auto">
                        <?php if( $section ): ?>
                        <div class="categories d-flex">
                            <a href="<?php echo esc_attr($section->archive_url); ?>"><h4 class="theme mr-2"><?php echo esc_html($section->name); ?></h4></a>
                        </div>
                        <?php endif; ?>
                        <div class="pl-lg-5">
                            <div class="title mt-2">
                                <h1><?php echo esc_html($article->title); ?></h1>
                            </div>
                            <?php if( $article->excerpt ): ?>
                            <div class="subtitle">
                                <h3><?php echo esc_html($article->excerpt); ?></h3>
                            </div>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <?php if( $date ): ?>
                                <p class="date mb-0"><?php echo $date; ?></p>
                                <?php endif; ?>
                                <?php get_template_part( 'parts/article', 'social_buttons', array( 'class' => 'text-right mt-3' ) ); ?>
                            </div>
                        </div>
                        <?php if( $thumbnail ): ?>
                        <div class="img-container mt-3">
                            <div class="img-wrapper">
                                <img src="<?php echo esc_attr($thumbnail['url']); ?>" alt="<?php echo esc_attr($thumbnail['alt']); ?>" class="img-fluid w-100" />
                            </div>
                            <?php if( $thumbnail['author'] ): ?>
                            <div class="credits text-right mt-2">
                                <p>Foto: <?php echo esc_html($thumbnail['author']->name); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php get_template_part('parts/article','authors_data', array( 'article' => $article )); ?>

                        <div class="article-body mt-3">
                            <div class="art-column-w-padding">
                                <?php echo apply_filters( 'the_content', $article->content ); ?>
                            </div>
                        </div>
                        <?php get_template_part( 'parts/article', 'social_buttons', array( 'class' => 'text-right mt-3' ) ); ?>
                    </div>
                <?php TA_Blocks_Container_Manager::close(); ?>
                <div class="container-md mb-2 p-0">
                    <div class="separator"></div>
                </div>
            </div>
            <!-- END ARTICLE BODY -->


            <?php include_once(TA_THEME_PATH . '/markup/partes/tags.php');  ?>
            <?php if (is_active_sidebar('note_mob_1')) { ?>

                <div class="row d-flex d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 mt-3">
                    <div class="col-9 mx-auto">
                        <?php dynamic_sidebar('note_mob_1'); ?>
                    </div>
                </div>

            <?php } ?>
            <?php include_once(TA_THEME_PATH . '/markup/partes/mira-tambien.php');  ?>
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

<?php get_template_part('parts/podes', 'leer', ['post_id' => get_the_ID()]); ?>
