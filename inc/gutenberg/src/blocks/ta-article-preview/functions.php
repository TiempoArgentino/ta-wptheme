<?php

function ta_print_article_preview_attr($article, $args = array()){
    if(!$article)
        return;

    $default_args = array(
        'class'                     => '',
        'use_balancer_icons'        => false,
    );
    $args = array_merge($default_args, $args);
    extract($args);

    ?>
    class="article-preview <?php echo esc_attr($class); ?>"
    data-id="<?php echo esc_attr($article->ID); ?>"
    <?php

    if($use_balancer_icons){
        $balancer_data = Post_Balancer_User_Data::get_post_balanceable_data($article->ID);
        if($balancer_data):
            ?>
            data-icons="<?php echo esc_attr(true); ?>"
            data-balancer="<?php echo esc_attr(json_encode($balancer_data)); ?>"
            <?php
        endif;
    }
}
