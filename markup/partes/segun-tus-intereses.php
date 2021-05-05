<div class="container-with-header light-blue-bg py-3 mt-3">
    <div class="container d-block d-lg-flex justify-content-between align-items-center">
        <div class="section-title">
            <h4>SEGÚN TUS INTERESES</h4>
        </div>
        <div class="btns-container d-none d-lg-block">
            <div class="personalizar">
                <button>PERSONALIZAR</button>
            </div>
        </div>
    </div>
    <div class="sub-blocks mt-3">
        <div class="container px-0 px-md-1">
            <div class="ta-articles-block d-flex">
                <div class="ta-articles-block d-flex" id="your_interests"></div>
            </div>
            <div class="container">
            <?php if(is_user_logged_in()): ?>
                <div class="btns-container d-flex justify-content-between justify-content-lg-end">
                    <div class="personalizar d-block d-lg-none">
                        <button><a href="<?php echo get_permalink(get_option('personalize'))?>">PERSONALIZAR</a></button>
                    </div>
                </div>
            <?php endif;?>
            </div>
        </div>
    </div>
</div>