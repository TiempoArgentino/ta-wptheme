<?php
/*
*  Archivo de posts que contienen un tag especifico
*
*/
global $wp_query;
$searched_query = esc_html(get_search_query());
$articles = get_ta_articles_from_query($wp_query);
?>
<?php get_header(); ?>

    <div class="py-3">
        <div class="container">
            <div class="section-title">
                <h4>Resultados para: <?php echo esc_attr($searched_query); ?></h4>
            </div>
        </div>
        <?php get_template_part('parts/archive', 'simple', array(
            'articles'              => $articles,
            // 'max_num_pages'         => $wp_query->max_num_pages,
            // 'current_page'          => max(1, get_query_var('paged')),
        )); ?>
    </div>

<?php get_footer(); ?>
