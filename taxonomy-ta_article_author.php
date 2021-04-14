<?php
/*
*   Author articles archive template
*/

$author = TA_Author_Factory::get_author(get_queried_object(), 'ta_article_author');
$articles_block = RB_Gutenberg_Block::get_block('ta/articles');
$articles = get_ta_articles_from_query(array(
    'post_type' => 'ta_article',
    'tax_query' => array(
        array(
            'taxonomy' => 'ta_article_author',
            'field'    => 'term_id',
            'terms'    => $author->term->term_id,
        ),
    ),
));
//include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
?>

<?php get_header(); ?>

    <?php if( $author->description || $author->quote ): ?>
    <div class="mt-3">
        <div class="container">
            <div class="section-title">
                <h4>Más del autor</h4>
            </div>
        </div>
        <div class="container">
            <div class="ta-author-block px-3 py-4">
                <div class="d-flex flex-column flex-md-row">
                    <div class="d-flex flex-row flex-md-column justify-content-between justify-content-md-start px-4">
                        <?php if( $author->photo ): ?>
                        <div class="profile  position-relative ">
                            <div class="picture">
                                <img src="<?php echo esc_attr($author->photo); ?>" alt="<?php echo esc_attr($author->name); ?>">
                            </div>
                            <div class="partner-icon">
                                <div class="icon position-absolute">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/author-pen.svg" alt="">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="author-name mt-3 d-none d-md-block">
                            <p class="m-0"><?php echo esc_html($author->name); ?></p>
                            <p><span>Tiempo Argentino</span></p>
                        </div>
                        <?php if( $author->networks ): ?>
                        <div class="social-btns d-flex flex-column flex-md-row justify-content-around justify-content-md-start my-3">
                            <?php if( isset($author->networks['twitter']) ): ?>
                            <a target="_blank" href="<?php echo esc_attr($author->networks['twitter']); ?>" class="mr-2">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/author-tw.svg" alt="">
                            </a>
                            <?php endif; ?>
                            <?php if( isset($author->networks['email']) ): ?>
                            <a target="_blank" href="<?php echo esc_attr($author->networks['email']); ?>" class="mr-2">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/email.svg" alt="">
                            </a>
                            <?php endif; ?>
                            <?php if( isset($author->networks['instagram']) ): ?>
                            <a target="_blank" href="<?php echo esc_attr($author->networks['instagram']); ?>" class="mr-2">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/instagram.svg" alt="">
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="author-name d-block d-md-none mt-3 px-4">
                        <p><?php echo esc_html($author->name); ?> <span>/ Tiempo Argentino</span></p>
                    </div>
                    <div class="author-content">
                        <div class="featured-quote mt-3">
                            <div class="separator my-3 d-block d-md-none"></div>
                            <div class="author-quoted">
                                <p><?php echo esc_html($author->name); ?></p>
                            </div>
                            <?php if($author->quote): ?>
                            <div class="quote-body  mt-2">
                                <p>“<?php echo esc_attr($author->quote); ?>“</p>
                            </div>
                            <?php endif; ?>
                            <div class="separator my-3"></div>
                        </div>
                        <div class="author-description">
                            <div class="author-summary">
                                <?php if($author->position): ?>
                                <p><span>Cargo: </span><?php echo esc_attr($author->position); ?></p>
                                <?php endif; ?>
                                <?php if($author->subject): ?>
                                <p><span>Temas: </span><?php echo esc_attr($author->subject); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if($author->bio): ?>
                            <div class="description-content mt-4">
                                <p><?php echo $author->bio; ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="btns-container">
                    <div class="ver-mas text-right">
                        <button id="myBtn">ver más<span class="ml-3 "><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/right-arrow.png" alt=""></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="py-3">
        <div class="container">
            <div class="section-title">
                <h4>Notas de <span><?php echo esc_html($author->name); ?></span></h4>
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
                            'show_authors'      => false,
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

<?php get_footer(); ?>
