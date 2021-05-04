<?php
/*
*  Single article page template
*
*/
$article = TA_Article_Factory::get_article($post);
$header_slug = $article->micrositio ? 'micrositio' : '';
$article_part_slug = $article->micrositio ? 'special_article' : 'article';
?>
<?php get_header($header_slug); ?>

<?php get_template_part('parts/single', $article_part_slug); ?>

<?php get_footer(); ?>
