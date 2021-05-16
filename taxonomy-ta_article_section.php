<?php
/*
*   Section articles archive template
*/
global $wp_query;
$section = TA_Section_Factory::get_section(get_queried_object(), 'ta_article_section');
$articles = get_ta_articles_from_query($wp_query);
//include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
?>
<?php get_header(); ?>

    <div class="py-3">
        <div class="container">
            <div class="section-title">
                <h4>Sección <?php echo esc_attr($section->name); ?></h4>
            </div>
        </div>
        <?php get_template_part('parts/archive', 'simple', array(
            'articles'              => $articles,
            // 'max_num_pages'         => $wp_query->max_num_pages,
            // 'current_page'          => max(1, get_query_var('paged')),
        )); ?>
    </div>

<?php get_footer(); ?>
