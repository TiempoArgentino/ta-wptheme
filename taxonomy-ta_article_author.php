<?php
/*
*   Author articles archive template
*/
global $wp_query;
$author = TA_Author_Factory::get_author(get_queried_object(), 'ta_article_author');
$articles = get_ta_articles_from_query($wp_query);
//include_once(TA_THEME_PATH . '/markup/partes/podes-leer.php');
?>

<?php get_header();?>

    <?php //if( $author->bio || $author->quote ): ?>
    <div class="mt-3">
        <div class="container">
            <div class="section-title">
                <h4>Más del autor</h4>
            </div>
        </div>
        <div class="container">
            <div class="ta-author-block px-3 py-4">
                <div class="d-flex flex-column flex-md-row">
                    <div class="d-flex flex-row flex-md-column justify-content-center justify-content-md-start px-4">
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
                        <div class="social-btns d-flex flex-column flex-md-row justify-content-around justify-content-md-start my-3 ml-3">
                            <?php if( !empty($author->networks['twitter']['username']) ): ?>
                            <a target="_blank" href="<?php echo esc_attr($author->networks['twitter']['username']); ?>" class="mr-2">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/author-tw.svg" alt="">
                            </a>
                            <?php endif; ?>
                            <?php if( !empty($author->networks['email']['username']) ): ?>
                            <a target="_blank" href="<?php echo esc_attr($author->networks['email']['username']); ?>" class="mr-2">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/email.svg" alt="">
                            </a>
                            <?php endif; ?>
                            <?php if( !empty($author->networks['instagram']['username']) ): ?>
                            <a target="_blank" href="<?php echo esc_attr($author->networks['instagram']['username']); ?>" class="mr-2">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/instagram.svg" alt="">
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="author-name d-block d-md-none mt-3 px-3">
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
            </div>
        </div>
    </div>
    <?php //endif; ?>
    <div class="py-3">
        <div class="container">
            <div class="section-title">
                <h4>Notas de <span><?php echo esc_html($author->name); ?></span></h4>
            </div>
        </div>
        <?php get_template_part('parts/archive', 'simple', array(
            'articles'              => $articles,
            // 'max_num_pages'         => $wp_query->max_num_pages,
            // 'current_page'          => max(1, get_query_var('paged')),
        )); ?>

<?php get_footer(); ?>
