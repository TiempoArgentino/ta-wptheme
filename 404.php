<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 mx-auto text-center p-3 pt-md-5 pb-md-5 mt-md-3 mt-md-5" id="page-404">
            <h1><?php echo __('404','gen-base-theme')?></h1>
            <h2><?php echo __('No encontramos la página, te pedimos disculpas.','gen-base-theme')?></h2>
            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/404.png" alt="404" />
            
        </div>
    </div>
</div>

<?php get_footer();?>