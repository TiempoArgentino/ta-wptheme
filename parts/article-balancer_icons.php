<?php
$defaults = array(
    'article'   => null,
);

// if(!function_exists('balancer_front'))
    // return;

// extract( array_merge( $defaults, $args ) );
// if(!$article || empty($article) )
//     return;
//
// balancer_front()->show_interest_post(get_current_user_id(), $article->ID, null, null, null);
?>
<div class="article-icons d-flex flex-column position-absolute">
    <img data-icon="location" src="<?php echo TA_THEME_URL; ?>/assets/img/icon-img-1.svg" alt="" />
    <img data-icon="favorite" src="<?php echo TA_THEME_URL; ?>/assets/img/icon-img-2.svg" alt="" />
    <img data-icon="author" src="<?php echo TA_THEME_URL; ?>/assets/img/icon-img-3.svg" alt="" />
</div>
