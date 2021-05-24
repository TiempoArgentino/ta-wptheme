<?php
$defaults = array(
    'article'   => null,
);

if(!function_exists('balancer_front'))
    return;
    
extract( array_merge( $defaults, $args ) );
if(!$article || empty($article) )
    return;

balancer_front()->show_interest_post(get_current_user_id(), $article->ID, null, null, null);
?>
