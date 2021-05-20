<?php
$default_args = array(
    'show_date' => true,
    'before_social_buttons'   => null,
);
$args = array_merge($default_args, $args);
extract($args);
$article = TA_Article_Factory::get_article($post);

$date = $article->get_date_day('d/m/Y');

$thumbnail = $article->thumbnail_common;
$section = $article->section;
$author = $article->first_author;
$authors = $article->authors;
?>
<?php get_template_part('parts/single_article', 'top'); ?>
<div class="container-fluid container-lg p-0 ">
    <div class="d-flex col-12 flex-column flex-lg-row align-items-start p-0">
        <div class="col-12 col-lg-8 p-0">

            <!-- ARTICLE BODY -->
            <div class="articulo-simple text-right my-4">
                <div class="container">
                    <div class="text-left mx-auto">
                        <?php if( $section ): ?>
                        <div class="categories d-flex">
                            <a href="<?php echo esc_attr($section->archive_url); ?>"><h4 class="theme mr-2"><?php echo esc_html($section->name); ?></h4></a>
                        </div>
                        <?php endif; ?>
                        <div class="pl-lg-5">
                            <div class="title mt-2">
                                <h1><?php echo esc_html($article->title); ?></h1>
                            </div>
                            <?php if( $article->excerpt ): ?>
                            <div class="subtitle">
                                <h3><?php echo esc_html($article->excerpt); ?></h3>
                            </div>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-end mt-3">
                                <?php if( $show_date && $date ): ?>
                                <p class="date mb-0"><?php echo $date; ?></p>
                                <?php endif; ?>
                                <?php if(is_callable($before_social_buttons)){ call_user_func($before_social_buttons); } ?>
                                <div></div>
                                <?php get_template_part( 'parts/article', 'social_buttons', array( 'class' => 'text-right mt-3' ) ); ?>
                            </div>
                        </div>
                        <?php if( $thumbnail ): ?>
                        <div class="img-container mt-3">
                            <div class="img-wrapper" id="article-main-image">
                                <img src="<?php echo esc_attr($thumbnail['url']); ?>" alt="<?php echo esc_attr($thumbnail['alt']); ?>" class="img-fluid w-100" />
                            </div>
                            <?php get_template_part('parts/image', 'copyright', array('photographer' => $thumbnail['author'])); ?>
                        </div>
                        <?php endif; ?>

                        <?php get_template_part('parts/article','authors_data', array( 'article' => $article )); ?>

                        <div class="article-body mt-3">
                            <div class="art-column-w-lpadding">
                                <?php echo apply_filters( 'the_content', $article->content ); ?>
                            </div>
                        </div>
                        <?php get_template_part( 'parts/article', 'social_buttons', array( 'class' => 'text-right mt-3' ) ); ?>
                    </div>
                </div>
                <div class="container-md mb-2 p-0">
                    <div class="separator"></div>
                </div>
            </div>
            <!-- END ARTICLE BODY -->


            <?php include_once(TA_THEME_PATH . '/markup/partes/tags.php');  ?>
            <?php if (is_active_sidebar('note_mob_1')) { ?>

                <div class="row d-flex d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 mt-3">
                    <div class="col-9 mx-auto">
                        <?php dynamic_sidebar('note_mob_1'); ?>
                    </div>
                </div>

            <?php } ?>
            <?php include_once(TA_THEME_PATH . '/markup/partes/mira-tambien.php');  ?>
        </div>

        <?php get_template_part('parts/single_article', 'right_col'); ?>
    </div>
</div>

<?php get_template_part('parts/single_article', 'bottom'); ?>
