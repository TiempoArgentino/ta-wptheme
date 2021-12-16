<?php

/**
*   Prints a row for the articles block, based on the parameters
*   @param TA_Article_Data[] $articles_left                                     Instances of articles left to print.
*   @param mixed[] $row                                                         Arguments for the row instance
*   @param int $offset                                                          Offset index from where to start grabbing articles from the $articles_left array
*   @return int The amount of article from the $articles_left array rendered
*/
function ta_render_articles_block_row($articles_left = [], $row = [], $offset = 0){
    $row = is_array($row) ? $row : [];
    $row = array_merge(array(
        'format'                    => 'common',
        'use_balacer_articles'      => false,
        'balancer_allow_fallback'   => false,
    ), $row);
    $is_balanced = false;//$row['use_balacer_articles'] && function_exists('balancer_front');
    $allows_fallback = $row['balancer_allow_fallback'];
    $articles = [];
    $format = $row['format'];
    $renderer = null;
    $cells_count = null;
    $balancer_articles = [];

    switch($format){
        case 'slider': $renderer = new TAArticlesSliderRow($row); break;
        case 'miscelanea': $renderer = new TAArticlesMiscelaneaRow($row); break;
        default: $renderer = new TAArticlesCommonRow($row); break;
    }

    $balanced_cells_count = $renderer->get_cells_count_if_balanced();
    if($row['use_balacer_articles']){
        $placeholder_article = new TA_Placeholder_Article();
        $placeholder_articles = [];
        for ($i=0; $i < $balanced_cells_count; $i++)
            $placeholder_articles[] = $placeholder_article;
        $renderer->set_articles($placeholder_articles);

        ?> <div class="ta-articles-balanced-row mb-4"
        data-count="<?php echo esc_attr($balanced_cells_count); ?>"
        data-row="<?php echo esc_attr(json_encode($row)); ?>">
            <?php $renderer->render(); ?>
        </div> <?php
        return 0; // 0 rows rendered. Will render from the client with balancer data
    }


    if($is_balanced){
        $balancer_articles_ids = balancer_front()->balancer($balanced_cells_count, true);
        if($balancer_articles_ids && !empty($balancer_articles_ids)){
            $balancer_articles = get_ta_articles_from_query(array(
                'post_type'         => array('ta_article','ta_fotogaleria','ta_audiovisual'),
                // 'posts_per_page'    => 6,
                'post__in'          => $balancer_articles_ids,
            ));
            $articles = $balancer_articles;
        }
    }

    // Fallback to articles from arguments if balancer articles aren't enough to fill the row
    $balancer_articles_count = count($balancer_articles);
    $balancer_needs_fallback = $balancer_articles_count < $balanced_cells_count && $allows_fallback;

    if( !$is_balanced || $balancer_needs_fallback ){
        $articles = array_merge($articles, array_slice($articles_left, $offset));
    }

    $renderer->set_articles($articles);

    if($renderer)
        $cells_count = $renderer->render();


    if(is_int($cells_count)){
        if(!$is_balanced || $balancer_needs_fallback){
            $cells_count -= $balancer_articles_count;
            if($cells_count > 0)
                return $cells_count;
        }
    }

    return 0;
}
