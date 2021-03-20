<?php
/**
*   Page template
*/
?>
<?php get_header(); ?>

<?php include_once(TA_THEME_PATH . '/markup/partes/header.php');  ?>
<?php TA_Blocks_Container_Manager::open_new(); ?>
    <?php if ( have_posts() ) : the_post(); the_content(); endif; ?>
<?php TA_Blocks_Container_Manager::close(); ?>
<?php include_once(TA_THEME_PATH . '/markup/partes/footer.php');  ?>

<?php get_footer(); ?>
