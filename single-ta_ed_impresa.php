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
    'before_social_buttons' => function() use ($article){
        if(!$article->issue_pdf)
            return;
        ?>
        <a class="ta-ed-impresa-link" href="<?php echo esc_attr($article->issue_pdf['url']); ?>">Ver Online</a>
        <?php
    },
)); ?>

<?php get_footer(); ?>
