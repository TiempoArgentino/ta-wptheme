<?php
/*
*  Taxonomy page for micrositios
*
*/

$micrositio = TA_Micrositio::get_micrositio($term);
$content = $micrositio->get_content();
?>
<?php get_header('micrositio');?>
    <?php //get_template_part('parts/common-header'); ?>
    <div id="main" class="index">
        <div class="posts-content">
            <div class="post-content ta-context micrositio <?php echo esc_attr($micrositio->slug); ?>">
                <?php TA_Blocks_Container_Manager::open_new(); ?>
                <?php echo apply_filters( 'the_content', $content ); ?>
                <?php TA_Blocks_Container_Manager::close(); ?>
            </div>
        </div>
    </div>
    <?php //get_template_part('parts/common-footer'); ?>
<?php get_footer(); ?>
