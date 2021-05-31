<?php

$author = $article->first_author;
$thumb_cont_class = $desktop_horizontal ? 'col-5 col-md-6 p-0' : 'col-4 col-md-12 p-0';
$info_class = $desktop_horizontal ? 'col-7 col-md-6' : 'col-8 col-md-12 text-md-center';
$title_class = $desktop_horizontal ? '' : 'w-75 mx-md-auto';
$preview_class = $desktop_horizontal ? 'd-flex py-3' : 'py-2 d-flex flex-row flex-md-column';
?>

<div
    <?php
    ta_print_article_preview_attr($article, array(
        'class'                 => 'autor light-blue-bg context-bg mb-3',
        'use_balancer_icons'    => false,
    ));
    ?>
>
    <div class="<?php echo esc_attr($preview_class); ?>">
        <div class="<?php echo esc_attr($thumb_cont_class); ?>">
            <a href="<?php echo esc_attr($url); ?>">
                <div class="img-container position-relative">
                    <div class="img-wrapper" style='background-image: url("<?php echo $author->photo; ?>")' alt="<?php echo esc_attr($author->name); ?>"></div>
                </div>
            </a>
        </div>
        <div class="content <?php echo esc_attr($info_class); ?>">
            <div class="title">
                <a href="<?php echo esc_attr($url); ?>">
                    <p class="nota-title <?php echo esc_attr($title_class); ?>">“<?php echo $title; ?>”</p>
                </a>
            </div>
            <div class="article-info-container d-block">
                <?php if($author): ?>
                <div class="author">
                    <p>Por <?php get_template_part('parts/article','authors_links', array( 'authors' => [$author] )); ?></p>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
