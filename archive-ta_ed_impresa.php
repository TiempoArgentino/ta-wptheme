<?php
/*
*   Section articles archive template
*/
$section = TA_Section_Factory::get_section(get_queried_object(), 'ta_article_section');
$articles = [];

if( $wp_query->have_posts() ){
    foreach ($wp_query->posts as $ed_impresa_post) {
        $articles[] = TA_Article_Factory::get_article($ed_impresa_post);
    }
}

$articles_block = RB_Gutenberg_Block::get_block('ta/articles');
//include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
?>

<?php get_header(); ?>

    <div class="py-3">
        <div class="container">
            <div class="section-title">
                <h4>Ediciones Impresas</h4>
            </div>
        </div>
        <?php get_template_part('parts/archive', 'simple', array(
            'articles'              => $articles,
            // 'max_num_pages'         => $wp_query->max_num_pages,
            // 'current_page'          => max(1, get_query_var('paged')),
        )); ?>
    </div>
    <?php include_once(TA_THEME_PATH . '/markup/partes/footer.php');  ?>
<?php get_footer(); ?>
