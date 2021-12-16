<?php
/*
*   Tags articles archive template
*/
global $wp_query;
$tag = TA_Tag_Factory::get_tag(get_queried_object(), 'ta_article_tag');
$articles = get_ta_articles_from_query($wp_query);
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
        <?php get_template_part('parts/archive', 'simple', array(
            'articles'              => $articles,
            // 'max_num_pages'         => $wp_query->max_num_pages,
            // 'current_page'          => max(1, get_query_var('paged')),
        )); ?>
    </div>

<?php get_footer(); ?>
