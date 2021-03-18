<?php

$thumb_cont_class = $desktop_horizontal ? 'col-5 col-md-6 pr-0 pl-0' : '';
$info_class = $desktop_horizontal ? 'col-7 col-md-6' : '';
$preview_class = $desktop_horizontal ? 'd-flex' : '';
$preview_class .= " $class";
?>
<div class="article-preview mb-3 <?php echo esc_attr($preview_class); ?>">
    <?php if( $thumbnail_url ): ?>
    <div class="<?php echo esc_attr($thumb_cont_class); ?>">
        <a href="<?php echo esc_attr($url); ?>">
            <div class="img-container position-relative">
                <div class="img-wrapper" style='background-image: url("<?php echo $thumbnail_url; ?>")' alt="<?php echo esc_attr($thumbnail['alt']); ?>"></div>
                <div class="icons-container">
                    <div class="article-icons d-flex flex-column position-absolute">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-1.svg" alt="" />
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-2.svg" alt="" />
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-3.svg" alt="" />
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php endif; ?>
    <div class="content <?php echo esc_attr($info_class); ?>">
        <?php if($cintillo): ?>
        <div class="article-border"></div>
        <div class="category-title">
            <h4><?php echo $cintillo; ?></h4>
        </div>
        <?php endif; ?>
        <div class="title">
            <a href="<?php echo esc_attr($url); ?>">
                <p><?php echo $title; ?></p>
            </a>
        </div>
        <?php
        if($authors):
            $authors_text = "";
        ?>
        <div class="article-info-container">
            <div class="author">
                <p>Por:
                    <?php include plugin_dir_path( __FILE__ ) . "/authors-links.php"; ?>
                </p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
