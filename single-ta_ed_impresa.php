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
    <?php 
    $userdata = get_userdata(get_current_user_id());
    $rol = $userdata->roles[0];
    if (is_user_logged_in() && get_user_meta(get_current_user_id(),'_user_status',true) == 'active' && ($rol == get_option('subscription_digital_role') || $rol == 'administrator')) : ?>

        <a class="ta-ed-impresa-link" href="<?php echo esc_attr($article->issue_pdf['url']); ?>">Ver Online</a>
    <?php endif; ?>
<?php
    },
)); ?>

<?php get_footer(); ?>