<?php
$preview_class = esc_attr($class);
$section = $article->section;
?>
<div <?php ta_print_article_preview_attr($article, array( 'class' => "d-flex $preview_class" )); ?>>
    <?php if( $thumbnail_url ): ?>
    <div class="col-3 p-0">
        <a href="<?php echo esc_attr($url); ?>">
            <div class="img-container position-relative">
                <div class="img-wrapper" style='background-image: url("<?php echo $thumbnail_url; ?>")' alt="<?php echo esc_attr($thumbnail['alt']); ?>">
                    <div class="icons-container">
                        <div class="article-icons d-flex flex-column position-absolute">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-1.svg" alt="" />
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-2.svg" alt="" />
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-3.svg" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php endif; ?>
    <div class="content mt-0 col-9">
        <?php if( $section ): ?>
        <div class="section-title">
            <h4><?php echo esc_html($section->name); ?></h4>
        </div>
        <?php endif; ?>
        <div class="description">
            <a href="<?php echo esc_attr($url); ?>">
                <p><?php echo esc_html($title); ?></p>
            </a>
        </div>
    </div>
</div>
