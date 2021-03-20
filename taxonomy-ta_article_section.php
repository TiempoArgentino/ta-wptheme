<?php
/*
*   Section articles archive template
*/
$section = TA_Section_Factory::get_section(get_queried_object(), 'ta_article_section');
$articles_block = RB_Gutenberg_Block::get_block('ta/articles');
$articles = get_ta_articles_from_query(array(
    'post_type' => 'ta_article',
    'tax_query' => array(
        array(
            'taxonomy' => 'ta_article_section',
            'field'    => 'term_id',
            'terms'    => $section->term->term_id,
        ),
    ),
));
//include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
?>

<?php get_header(); ?>
    <?php ta_print_header();  ?>
    <div class="py-3">
        <div class="container">
            <div class="section-title">
                <h4>Sección <?php echo esc_attr($section->name); ?></h4>
            </div>
        </div>
        <div class="container-fluid container-lg mt-3">
            <div class="d-flex flex-column flex-md-row">
                <div class="col-12 col-md-8 p-0">
                    <?php
                        $articles_block->render(array(
                            'articles'          => $articles,
                            'articles_type'     => 'article_post',
                            'layout'            => '',
                            'cells_per_row'     => 3,
                        ));
                    ?>
                </div>
                <div class="col-12 col-md-4 p-0">
                    <?php include_once(TA_THEME_PATH . '/markup/partes/seamos-socios.php');  ?>
                </div>
            </div>
            <div class="btns-container">
                <div class="pagination d-none d-lg-flex justify-content-center">
                    <button class="active">1</button>
                    <button>2</button>
                    <button>3</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once(TA_THEME_PATH . '/markup/partes/footer.php');  ?>
<?php get_footer(); ?>
