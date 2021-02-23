<?php

$articles_block = RB_Gutenberg_Block::get_block('ta/articles');
$articles_interest_block = RB_Gutenberg_Block::get_block('ta/articles-interest');
$query = new WP_Query(array(
    'post_type' => 'ta_article',
));

if( !$query || is_wp_error($query) || !$query->post_count || !$articles_block )
    return '';

extract($articles_interest_block->get_render_attributes());
$block_path = plugin_dir_path( __FILE__ );
$articles = $query->posts;

$articles_block->render(array(
    'articles'          => $articles,
    'articles_type'     => 'article_post',
    'container_title'   => 'Según tus intereses',
    'header_right'      => rb_get_include_string($block_path . '/container-buttons.php') ,
    'footer'            => rb_get_include_string($block_path . '/footer.php'),
    'layout'            => 'slider',
    'color_context'     => $color_context,
    'use_container'     => $use_container,
));

?>
