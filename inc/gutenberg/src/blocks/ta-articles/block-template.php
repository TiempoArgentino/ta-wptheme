<?php
$block = RB_Gutenberg_Block::get_block('ta/articles');
$article_preview_block = RB_Gutenberg_Block::get_block('ta/article-preview');
$container_header_block = RB_Gutenberg_Block::get_block('ta/container-with-header');
register_articles_block_cells_count(0);

if(!$block) return '';
$block_attributes = $block->get_render_attributes();
extract($block_attributes);

// if(!$amount || $amount <= 0)
//     return '';

$articles = get_ta_articles_block_articles($block_attributes);
if( (!$articles || empty($articles)) || !$rows )
    return '';

$all_articles = $articles;
$articles_left = $all_articles;
$block_path = plugin_dir_path( __FILE__ );
ob_start();
?>

<?php
foreach ($rows as $row) {
    $row = array_merge(array(
        'format'                    => 'common',
        'use_balacer_articles'      => false,
        'balancer_allow_fallback'   => false,
    ), $row);
    $is_balanced = $row['use_balacer_articles'];
    $allows_fallback = $row['balancer_allow_fallback'];
    $articles = [];
    $format = $row['format'];
    $renderer = null;
    $cells_count = null;
    $balancer_articles = [];

    switch($format){
        case 'slider':
            $renderer = new TAArticlesSliderRow($row);
        break;
        case 'miscelanea':
            $renderer = new TAArticlesMiscelaneaRow($row);
        break;
        default:
            $renderer = new TAArticlesCommonRow($row);
        break;
    }

    $balanced_cells_count = $renderer->get_cells_count_if_balanced();

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
        $offset = get_articles_block_cells_count();
        $articles = array_merge($articles, array_slice($articles_left, $offset));
    }

    $renderer->set_articles($articles);

    if($renderer)
        $cells_count = $renderer->render();

    if(is_int($cells_count)){
        if(!$is_balanced || $balancer_needs_fallback){
            $cells_count -= $balancer_articles_count;
            if($cells_count > 0)
                update_articles_block_cells_count($cells_count);
        }
    }
}
register_articles_block_cells_count(0);
?>

<?php if( $footer ): ?>
<div class="footer">
    <?php echo $footer; ?>
</div>
<?php endif; ?>


<?php
$content = ob_get_clean();

if( $use_container && $container ){
    if(isset($container['use_term_format']) && $container['use_term_format']){
        $term_data = ta_is_term_articles_block($block_attributes);
        if( $term_data ){
            $new_container_args = array();
            $term_taxonomy = $term_data->term->taxonomy;
            $term_slug = $term_data->term->slug;
            $new_container_args['title'] = $term_data->name;
            $new_container_args['header_link'] = $term_data->archive_url;

            if(($term_taxonomy == 'ta_article_section') && ($term_slug == 'cultura' || $term_slug == 'deportes' || $term_slug == 'espectaculos')){
                $new_container_args['color_context'] = $term_slug;
                $new_container_args['header_type']  = 'common';
            }

            $container = array_merge( $container, $new_container_args );
        }
    }
    $container_header_block->render($container, $content);
}
else
    echo $content;
