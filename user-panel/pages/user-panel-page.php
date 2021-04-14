<?php get_header() ?>

<?php do_action('before_panel_user')?>

<div class="container ta-context user-tabs gray-border mt-2 my-lg-5">

    <div class="user-block-container">
        <div class="user-tabs">
            <ul class="nav nav-tabs justify-content-between justify-content-md-start" id="tab">
                <?php do_action('panel_user_tabs') ?>
            </ul>
            <div class="tab-content">
                <?php do_action('panel_user_content') ?>
            </div>
        </div>
    </div>
</div>

<?php do_action('after_panel_user')?>

<?php get_footer() ?>