<div class="container-with-header py-3">
    <div class="container d-block d-lg-flex justify-content-between align-items-center">
        <div class="section-title">
            <h4><?php echo __('SEGÚN TUS INTERESES','gen-theme-base')?></h4>
        </div>
        <div class="btns-container d-none d-lg-block">
        <?php if(is_user_logged_in()):?>
            <div class="personalizar">
                <button><?php echo __('PERSONALIZAR','gen-theme-base')?></button>
            </div>
        <?php endif;?>
        </div>
    </div>
    <div class="sub-blocks mt-3">
        <div class="container px-0 px-md-1">
            <div class="ta-articles-block d-flex"  id="your_interests">        
            </div>
            <div class="container">
                <div class="btns-container d-flex justify-content-between justify-content-lg-end">
                <?php if(is_user_logged_in()):?>
                    <div class="personalizar d-block d-lg-none">
                        <button><?php echo __('PERSONALIZAR','gen-theme-base')?></button>
                    </div>
                <?php endif;?>
                    <div class="ver-mas">
                        <button><?php echo __('ver más','gen-theme-base')?><span class="ml-3"><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/right-arrow.png"
                                    alt="" /></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>