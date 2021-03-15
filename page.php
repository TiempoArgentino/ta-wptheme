<?php
/**
*   Page template
*/
?>
<?php get_header(); ?>


<div class="container">
    <?php if ( have_posts() ) : the_post(); the_content(); endif; ?>asdasd
    <?php
    $articles = [];
    $result = rb_get_posts(array(
        'post_type' => 'ta_article',
    ));
    $posts = $result['posts'];
    $query = $result['wp_query'];

    if($posts && !empty($posts)){
        foreach ($posts as $article_post) {
            $article = TA_Article_Factory::get_article($article_post, 'article_post');
            $article->populate(true);
            $articles[] = $article;
        }
    }

    $articles_block = RB_Gutenberg_Block::get_block('ta/articles');
    // $query = new WP_Query(array(
    //     'post_type' => 'ta_article',
    // ));
    // $articles = $query->posts;

    //include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
    // $articles_block->render(array(
    //     'articles'          => $articles,
    //     // 'articles_type'     => 'article_post',
    //     'container_title'   => 'Miscelanea',
    //     'use_container'     => false,
    //     'rows'              => array(
    //         array(
    //             'layout'            => 'miscelanea',
    //         ),
    //         array(
    //             'layout'            => 'common',
    //         ),
    //     ),
    // ));

    //include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
    // $articles_block->render(array(
    //     'articles'          => $articles,
    //     // 'articles_type'     => 'article_post',
    //     'container_title'   => 'Miscelanea',
    //     'use_container'     => false,
    //     'rows'              => [
    //         array(
    //             'layout'            => 'common',
    //         ),
    //     ],
    // ));
    ?>
</div>

<?php get_footer(); ?>
