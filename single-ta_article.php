<?php
/*
*  Single article page template
*
*/
$article = TA_Article_Factory::get_article($post);
// $article_data = LR_Article::get_article($post);
// $attributes = rb_get_query_var(array(
//     'body_class'            => '',
//     'show_excerpt'          => true,
//     'show_thumbnail'        => true,
//     'show_featured_media'   => true,
//     'show_author'           => true,
//     'show_tags_cloud'       => true,
//     'show_popular'          => true,
//     'show_header_detail'    => true,
//     /**
//      *   @param string Indica que header se debe usar. Carga el template part common-$header_type
//      */
//     'header_type'           => 'header-tag',
//     /**
//      *   @param string Formato del multimedia destacado del articulo.
//      *   Valores: common (tamaño limitado), full (tamaño completo del medio)
//      */
//     'featured_media_type'   => 'full',
//     /**
//      *   @param mixed[] Attributos extra para el bloque lr/popular-articles
//      */
//     'popular_args'          => array(
//         'amount'                    => 4,
//     ),
// ));
// extract($attributes);
// $attachment_position_style = $article_data->get_attachment_bkg_position_style();
// $show_featured_media = $show_featured_media && $article_data->show_featured_media_on_article();
// $tags_ids = is_array($article_data->tags) ? array_map(function ($tag) {
//     return $tag->term_id;
// }, $article_data->tags) : null;
?>
<?php get_header(); ?>

<?php
//
// if($posts && !empty($posts)){
//     foreach ($posts as $article_post) {
//         $article = TA_Article_Factory::get_article($article_post, 'article_post');
//         $article->populate(true);
//         $articles[] = $article;
//     }
// }
//
// if($articles){
//     $columns = array(
//         array(
//             'cells' => array(1,2,3,4,5,6),
//             'width' => 1/2,
//         ),
//         array(
//             'cells' => array(1,2,3,4,5,6),
//             'width' => 1/2,
//         ),
//     );
//    render_grid($columns, $articles);
// }
?>
<!-- widget sobre la nota -->
<?php if (is_active_sidebar('over-single-note')) { ?>
    <div class="container d-sm-none d-md-block mt-md-3 mb-md-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('over-single-note'); ?>
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
                <div class="container-md mb-2 p-0 d-block d-md-none">
                    <div class="separator"></div>
                </div>
                <?php //include_once(TA_THEME_PATH . '/markup/partes/mas-leidas.php');
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
                <div class="d-sm-none d-md-block anuncio-side-single">
                    <?php dynamic_sidebar('side-single-note'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php if (is_active_sidebar('down-single-note')) { ?>
    <div class="container d-sm-none d-md-block mt-md-3 mb-md-3">
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
<div class="container-md">
    <div class="row">
        <div class="col-12 col-lg-8">
            <?php include_once(TA_THEME_PATH . '/markup/partes/comentarios.php');  ?>
        </div>
        <div class="col-12 col-lg-4">
            <?php if (is_active_sidebar('side-comments-note')) { ?>
                <div class="d-sm-none d-md-block anuncio-side-comments-single">
                    <?php dynamic_sidebar('side-comments-note'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- abajo comentarios -->
<?php if (is_active_sidebar('down-comments-note')) { ?>
    <div class="container d-sm-none d-md-block mt-md-3 mb-md-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('down-comments-note'); ?>
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
<div class="ta-context light-blue-bg">
    <?php   ?>
</div>
<?php include_once(TA_THEME_PATH . '/markup/partes/footer.php');  ?>
<?php get_footer(); ?>
