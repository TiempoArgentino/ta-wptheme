<?php
/*
*  Fallback for pages without template
*
*/
?>
<?php get_header();?>
    <?php //get_template_part('parts/common-header'); ?>
    <div id="main" class="index">
        <?php if( have_posts() ): ?>
        <div class="posts-content">
            <?php while( have_posts() ): the_post();?>
            <div class="post-content">
                <?php
                // the_content(); ?>
            </div>
            <?php endwhile; wp_reset_postdata();?>
        </div>
        <?php endif; ?>
    </div>
    <?php //get_template_part('parts/common-footer'); ?>
<?php get_footer(); ?>
