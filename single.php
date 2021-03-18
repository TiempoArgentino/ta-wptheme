<?php get_header() ?>
<div id="primary" class="container">
    <main id="main" class="row" role="main">
        <div class="col-8">
            <?php
            // Start the loop.
            while (have_posts()) : the_post();

                echo '<div class="col-12">';
                the_title('<h3>', '</h3>');
                echo '<p>' . apply_filters( 'the_content', get_the_content() ) . '</p>';
                echo '</div>';


                // Previous/next post navigation.
                the_post_navigation(array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true">' . __('Next', 'twentyfifteen') . '</span> ' .
                        '<span class="screen-reader-text">' . __('Next post:', 'twentyfifteen') . '</span> ' .
                        '<span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __('Previous', 'twentyfifteen') . '</span> ' .
                        '<span class="screen-reader-text">' . __('Previous post:', 'twentyfifteen') . '</span> ' .
                        '<span class="post-title">%title</span>',
                ));

            // End the loop.
            endwhile;
            ?>
            <!-- footer sidebar -->
            <?php if (is_active_sidebar('post_internal')) { ?>
                <?php dynamic_sidebar('post_internal'); ?>
            <?php } ?>
        </div>

        <div class="col-4" id="sidebar">
            <?php if (is_active_sidebar('primary')) { ?>
                <?php dynamic_sidebar('primary'); ?>
            <?php } ?>
        </div>
    </main><!-- .site-main -->
</div><!-- .content-area -->
<?php get_footer() ?>