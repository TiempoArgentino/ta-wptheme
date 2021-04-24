<?php
/**
*   Page template
*/
?>
<?php get_header(); ?>

<?php TA_Blocks_Container_Manager::open_new(); ?>
    <?php if ( have_posts() ) : the_post(); 
    
        if(is_front_page()) {
            do_action('cloud_tag');
        }
        
        the_content(); 
    endif; ?>
<?php TA_Blocks_Container_Manager::close(); ?>

<?php get_footer(); ?>
