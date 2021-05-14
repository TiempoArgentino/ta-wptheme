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
<script>
(function($){
     /** share */
 $(document).ready(function () {
    $("#share-popover").popover({
      placement: "bottom",
      trigger: "focus",
      template:
        '<div class="popover share" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      html: true,
      sanitize: false,
      title: "",
      content: function () {
        return (
          '<ul class="d-flex justify-content-between align-items-center m-0">' +
          '<li class="mr-2 mt-0">' +
          '<a href="https://facebook.com/sharer.php?u=<?php echo get_permalink( get_queried_object_id() )?>" target="_blank">' +
          '<img class="img-fluid m-0" src="<?php echo get_stylesheet_directory_uri()?>/assets/img/fb-share-popover.svg">' +
          "</a>" +
          "</li>" +
          '<li class="mr-2 mt-0">' +
          '<a href="https://api.whatsapp.com/send?text=<?php echo get_permalink( get_queried_object_id() )?>" target="_blank">' +
          '<img class="img-fluid m-0" src="<?php echo get_stylesheet_directory_uri()?>/assets/img/whatsapp-share-popover.svg">' +
          "</a>" +
          "</li>" +
          '<li class="mt-0">' +
          '<a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink( get_queried_object_id() )?>" target="_blank">' +
          '<img class="img-fluid m-0" src="<?php echo get_stylesheet_directory_uri()?>/assets/img/twitter-share-popover.svg">' +
          "</a>" +
          "</li>" +
          "</ul>"
        );
      }
    });
  });
})(jQuery);

</script>
