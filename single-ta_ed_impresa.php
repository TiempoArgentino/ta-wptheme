<?php
/*
*  Single article page template
*
*/
$article = TA_Article_Factory::get_article($post);
?>
<?php get_header(); ?>

<?php
   get_template_part('parts/single', 'article', array(
    'show_date'             => false,
    'before_social_buttons' => function () use ($article) {
?>
<?php if(is_user_logged_in()): 
     if (
        user_active(wp_get_current_user()->ID) && 
        user_active(wp_get_current_user()->ID) == 'active' &&
        subscription_user_type(wp_get_current_user()->ID)  === 'digital' ||
        in_array('administrator', get_user_by('id', wp_get_current_user()->ID)->roles) == 1
    ) : ?>
    
    <a class="ta-ed-impresa-link" href="<?php echo esc_attr($article->issue_pdf['url']); ?>">Ver Online</a>
<?php  endif; 
endif; ?>
<?php
    },
)); ?>

<?php get_footer(); ?>