<?php
$terms = get_the_terms(get_queried_object_id(),'ta_article_tag');
$term = wp_list_pluck($terms, 'slug');

$args = [
    'post_type'         => 'ta_article',
    'posts_per_page'    => 12,
    'tax_query'         => [
        [
            'taxonomy'  => 'ta_article_tag',
            'field'     => 'slug',
            'terms'     => $term
        ]
    ]
];

$articles = get_ta_articles_from_query($args);

$articles_block = RB_Gutenberg_Block::get_block('ta/articles');
$articles_block->render(array(
    'articles'          => $articles,
    'rows'              => array(
        array(
            'format'            => 'common',
            'cells_amount'      => -1,
            'cells_per_row'     => 4,
        ),
    ),
    'use_container'     => true,
    'container'         => array(
        'header_type'			=> 'common',
        'color_context'			=> 'light-blue',
        'title'					=> 'TAMBIÉN PODÉS LEER',
        // 'header_link'			=> '',
        // 'use_term_format'		=> false,
    ),
));
?>
