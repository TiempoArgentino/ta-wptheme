<?php
/*
*  Single article page template
*
*/
$article = TA_Article_Factory::get_article($post);
?>
<?php get_header($header_slug); ?>

<?php get_template_part('parts/single', 'article'); ?>

<?php get_footer(); ?>
