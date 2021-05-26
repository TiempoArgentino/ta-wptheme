<?php
$default_args = array(
    'post_id'		=> null,
    'paged'			=> 1,
    'number'		=> get_option('comments_per_page'),
);
$args = array_merge($default_args, $args);

if(!isset($args['post_id']) || !is_int($args['post_id']) || $args['post_id'] <= 0 )
    return;

$comments = ta_get_top_level_comments($args);

foreach($comments as $comment){
    get_template_part('parts/comments', 'single_thread', array( 'comment' => $comment ));
}
