<?php
/*
*   Tags articles archive template
*/

$tag = TA_Tag_Factory::get_tag(get_queried_object(), 'ta_article_tag');
$articles_block = RB_Gutenberg_Block::get_block('ta/articles');
$articles = get_ta_articles_from_query(array(
    'post_type' => 'ta_article',
    'tax_query' => array(
        array(
            'taxonomy' => 'ta_article_tag',
            'field'    => 'term_id',
            'terms'    => $tag->term->term_id,
        ),
    ),
));
//include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
?>

<?php get_header(); ?>

    <div class="tag-profile mt-3">
        <div class="container d-flex">
            <div class="section-title d-flex align-items-center mr-2">
                <h4>NUBE DE TAGS</h4>
            </div>
            <div class="article-tags m-0">
                <div class="tag d-flex justify-content-center my-2">
                    <div class="content p-1">
                        <a href="">
                            <p class="m-0"><?php echo esc_attr( $tag->name ); ?></p>
                        </a>
                    </div>
                    <div class="triangle"></div>
                </div>
            </div>
        </div>
        <?php if( $tag->description ): ?>
        <div class="container">
            <div class="tag-block px-3 py-4">
                <div class="d-flex flex-column flex-md-row">
                    <?php if( $tag->image_url ): ?>
                    <div class="d-flex flex-row flex-md-column justify-content-between justify-content-md-start px-4">
                        <div class="profile  position-relative ">
                            <div class="picture">
                                <img src="<?php echo esc_attr($tag->image_url); ?>" alt="<?php echo esc_attr( $tag->name ); ?>">
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="tag-content">
                        <div class="quote">
                            <div class="separator mt-md-0 mb-3"></div>
                            <div class="tag-quoted">
                                <p><?php echo esc_attr( $tag->name ); ?></p>
                            </div>
                        </div>
                        <div class="tag-description">
                            <div class="description-content mt-4">
                                <p><?php echo $tag->description; ?></p>
                            </div>
                        </div>
                        <div class="separator my-3"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="py-3">
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
