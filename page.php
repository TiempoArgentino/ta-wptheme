<?php
/**
*   Page template
*/
?>
<?php get_header(); ?>
<?php if(is_front_page()): ?>

    <div class="fullpage-onboarding">
    <div class="container">
        <div class="popovers position-relative text-left">
            <div class="asociate-popover text-right">
                <div class="popover-container position-relative">
                    <button id="asociate-popover" class="popover-dismiss" role="button" data-bs-toggle="popover"
                        data-bs-trigger="manual">Dismissible
                        popover</button>
                </div>
            </div>
            <div class="personaliza-popover text-right">
                <div class="popover-container position-relative">
                    <button id="personaliza-popover" class="popover-dismiss" role="button" data-bs-toggle="popover"
                        data-bs-trigger="manual">Dismissible
                        popover</button>
                </div>
            </div>
            <div class="iconos-popover">
                <div class="popover-container position-relative">
                    <button id="iconos-popover" class="popover-dismiss" role="button" data-bs-toggle="popover"
                        data-bs-trigger="manual">Dismissible
                        popover</button>
                </div>
            </div>
            <div class="config-popover text-left text-md-right">
                <div class="popover-container position-relative">
                    <button id="config-popover" class="popover-dismiss" role="button" data-bs-toggle="popover"
                        data-bs-trigger="manual">Dismissible
                        popover</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif;?>


<?php TA_Blocks_Container_Manager::open_new(); ?>
    <?php if ( have_posts() ) : the_post(); 

        if(is_front_page()) {
            do_action('quienes_somos_banner');
        }

        if(is_front_page()) {
            do_action('cloud_tag');
        }
        
        the_content(); 
    endif; ?>
<?php TA_Blocks_Container_Manager::close(); ?>

<?php get_footer(); ?>
