<?php
$defaults = array(
    'article'   => null,
);
extract( array_merge( $defaults, $args ) );
if(!$article || empty($article) )
    return;

balancer_front()->show_interest_post(get_current_user_id(), $article->ID, null, null, null);
?>
