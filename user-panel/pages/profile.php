<?php do_action('before_profile_page') ?>

<div class="content-panel content-active tab-pane active" id="profile">
    <div class="user-profile mt-md-5">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-md-center">
                <div class="user-img mt-4 mx-3 mr-md-5">
                    <div class="img-container position-relative">
                        <div class="img-wrapper" style="background-image:url('<?php echo user_panel_proccess()->profile_image() ?>') !important;">
                            <div class="edit-icon position-absolute">
                                <button class="open-form-edit">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/edit-icon.svg" alt="">
                                </button>
                                <form method="post" id="image-profile" enctype="multipart/form-data">
                                    <div class="form-content">
                                        <h4><?php echo __('Select a image', 'user-panel') ?></h4>
                                        <input type="file" name="profile_imagen" id="profile_image" />
                                        <input type="hidden" name="user_id" value="<?php echo wp_get_current_user()->ID ?>" />
                                        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="name-and-plan d-flex flex-column justify-content-md-between mt-3">
                    <div class="separator mt-0"></div>
                    <div class="name mt-1">
                        <h4><?php echo wp_get_current_user()->first_name . ' ' . wp_get_current_user()->last_name ?></h4>
                    </div>
                    <div class="plan d-flex align-items-center">
                    <?php if(get_user_meta(wp_get_current_user()->ID, 'suscription_name', true) !== ''):?>
                        <div class="plan-icon mr-2">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/partner-yellow.svg" alt="">
                        </div>
                        <div class="type">
                            <h6><?php echo get_user_meta(wp_get_current_user()->ID, 'suscription_name', true)?></h6>
                        </div>
                    <?php endif;?>
                    </div>
                    <div class="separator mt-3"></div>
                </div>
            </div>
            <div class="options mb-3 mt-md-5">
                <?php do_action('profile_details') ?>

                <div class="option mt-3">
                    <button class="d-flex align-items-center">
                        <div class="opt-icon">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/guardados-icon.svg" alt="" class="img-fluid">
                        </div>
                        <div class="opt-title">
                            <p>Guardados <span>(5)</span></p>
                        </div>
                    </button>
                </div>
                <div class="option mt-3">
                    <button class="d-flex align-items-center">
                        <div class="opt-icon">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/preferencias-icon.svg" alt="" class="img-fluid">
                        </div>
                        <div class="opt-title">
                            <p>Tus preferencias</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        
    </div>
    <?php //do_action('profile_extra_content') ?>

</div>