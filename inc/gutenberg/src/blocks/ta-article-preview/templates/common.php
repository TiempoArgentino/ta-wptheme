<?php

$thumb_cont_class = $desktop_horizontal ? 'col-5 col-md-6 pr-0 pl-0' : '';
$info_class = $desktop_horizontal ? 'col-7 col-md-6' : '';
$preview_class = $desktop_horizontal ? 'd-flex' : '';
$preview_class .= " $class";
$preview_class = esc_attr($preview_class);
?>
<div
    <?php
    ta_print_article_preview_attr($article, array(
        'class'                 => "mb-3 $preview_class",
        'use_balancer_icons'    => true 
    ));
    ?>
>
    <?php if( $thumbnail_url ): ?>
    <div class="<?php echo esc_attr($thumb_cont_class); ?>">
        <a href="<?php echo esc_attr($url); ?>">
            <div class="img-container">
                <div class="img-wrapper d-flex align-items-end" style='background-image: url("<?php echo $thumbnail_url; ?>")' alt="<?php echo esc_attr($thumbnail['alt']); ?>">
                    <div class="icons-container">
                        <div class="article-icons d-flex flex-column mb-2">
                            <?php get_template_part( 'parts/article', 'balancer_icons', array( 'article' => $article ) ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php endif; ?>
    <div class="content <?php echo esc_attr($info_class); ?>">
        <?php if($article instanceof TA_Edicion_Impresa): ?>
        <?php endif; ?>
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
        <?php if($authors): ?>
        <div class="article-info-container">
            <div class="author">
                <p>Por <?php get_template_part('parts/article','authors_links', array( 'authors' => $authors )); ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
