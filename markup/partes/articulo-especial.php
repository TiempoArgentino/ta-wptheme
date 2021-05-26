<?php
$article = TA_Article_Factory::get_article($post);
if(!$article)
    return;
?>
<div class="articulo-especial text-right my-4">
    <?php TA_Blocks_Container_Manager::open_new(); ?>
        <div class="text-left mx-auto">
            <div class="categories d-flex">
                <h4 class="theme mr-2"><?php echo esc_html($article->micrositio->title); ?></h4>
                <?php if($article->section): ?>
                <h4 class="subtheme"><?php echo $article->section->name; ?></h4>
                <?php endif; ?>
            </div>
            <div class="art-column-w-xpadding">
                <?php if($article->title): ?>
                <div class="title mt-2">
                    <h1><?php echo esc_html($article->title); ?></h1>
                </div>
                <?php endif; ?>
                <?php if($article->excerpt): ?>
                <div class="subtitle">
                    <h3><?php echo esc_html($article->excerpt); ?></h3>
                </div>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="date mb-0"><?php echo esc_html($article->get_date_day('d/m/Y')); ?></p>
                <?php get_template_part( 'parts/article', 'social_buttons', array( 'class' => 'text-right mt-3' ) ); ?>
            </div>
            <?php if( !$article->thumbnail_common['is_default'] ): ?>
            <div class="img-container mt-3">
                <div class="img-wrapper">
                    <img src="<?php echo esc_attr($article->thumbnail_common['url']); ?>" alt="" class="img-fluid w-100" />
                </div>
                <?php if($article->thumbnail_common['author']): ?>
                <div class="credits text-right text-md-left mt-2">
                    <p>Foto: <?php echo esc_html($article->thumbnail_common['author']->name); ?></p>
                </div>
                <?php endif; ?>
                <?php if($article->thumbnail_common['caption']): ?>
                <div class="bajada mt-3">
                    <p><?php echo esc_html($article->thumbnail_common['caption']); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php get_template_part('parts/article','authors_data', array( 'article' => $article )); ?>

            <div class="article-body mt-3">
                <div class="art-column-w-xpadding">
                    <?php echo apply_filters( 'the_content', $article->content ); ?>
                </div>
            </div>

            <?php get_template_part( 'parts/article', 'social_buttons', array( 'class' => 'text-right mt-3' ) ); ?>
        </div>
    <?php TA_Blocks_Container_Manager::close(); ?>
    <div class="container-md mb-2 p-0">
        <div class="separator"></div>
    </div>
</div>
