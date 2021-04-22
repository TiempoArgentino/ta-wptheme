<?php

$config = array_merge(array(
    'slides_amount'      => 4,
), $row);
extract($config);
$is_first = true;
$slides_amount = $slides_amount == -1 ? count($articles) : $slides_amount;
$printed_slides = 0;

if( $slides_amount == 0 )
    return;

if(!isset($GLOBALS['ta_article_slider_row_count']))
    $GLOBALS['ta_article_slider_row_count'] = 0;
else
    $GLOBALS['ta_article_slider_row_count']++;

$ta_article_slider_row_count = $GLOBALS['ta_article_slider_row_count'];
$slider_id = "ta_slider__$ta_article_slider_row_count";
register_articles_block_cells_count($slides_amount);

?>

<div class="slider-micrositio ta-context micrositio ambiental my-3">
    <div class="context-bg">
        <div id="<?php echo esc_attr($slider_id); ?>" class="carousel slide context-color pt-3" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    for ($i=0; $i < $slides_amount; $i++):
                        if(!isset($articles[$i]))
                            break;
                        $article = $articles[$i];
                        $thumbnail_url = $article->thumbnail_common && $article->thumbnail_common['url'] ? $article->thumbnail_common['url'] : '';
                        $item_class = $printed_slides == 0 ? 'active' : '';
                    ?>
                    <div class="carousel-item <?php echo esc_attr($item_class); ?>">
                        <div class="img-container">
                            <img class="d-block w-100" src="<?php echo esc_attr($thumbnail_url); ?>"
                                alt="Third slide">
                            <div class="overlay"></div>
                        </div>
                        <div class="carousel-caption text-left pt-0 mb-md-4">
                            <div class="separator"></div>
                            <?php if($article->cintillo): ?>
                            <div class="category-title mt-2">
                                <h4><?php echo $article->cintillo; ?></h4>
                            </div>
                            <?php endif; ?>
                            <div class="title">
                                <a href="<?php echo esc_attr($article->url); ?>">
                                    <p><?php echo esc_html($article->title); ?></p>
                                </a>
                            </div>
                            <div class="article-info-container">
                                <div>
                                    <?php if($article->authors): ?>
                                    <div class="author">
                                        <p>Por:
                                        <?php get_template_part('parts/article', 'authors_links', array(
                                            'authors'   => $article->authors,
                                        )); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $printed_slides++;
                    endfor; ?>
                </div>
                <?php if($printed_slides > 1): ?>
                <ol class="carousel-indicators pb-3">
                    <?php
                    for ($i=0; $i < $printed_slides; $i++):
                        $bullet_class = $i == 0 ? 'active' : '';
                    ?>
                        <li data-target="#<?php echo esc_attr($slider_id); ?>" data-slide-to="<?php echo esc_attr($i); ?>"
                            class="d-flex align-items-center justify-content-center <?php echo esc_attr($bullet_class); ?>">
                            <p><?php echo $i + 1; ?></p>
                        </li>
                    <?php endfor; ?>
                </ol>
                <?php endif; ?>
            </div>
    </div>
</div>
