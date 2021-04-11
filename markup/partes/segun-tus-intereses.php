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
            <div class="ta-articles-block d-flex">
                <?php foreach(balancer_front()->show_interest() as $art): ?>
                <div class="article-preview m-2 col-12 col-lg-3 d-flex flex-column p-0">
                    <div>
                        <a href="">
                            <div class="img-container position-relative">
                                <div class="img-wrapper">
                                    <img src="<?php echo get_the_post_thumbnail_url( $art->{'ID'} ) ?>" alt="" style="width:100%" />
                                </div>
                                <div class="icons-container">
                                    <div class="article-icons d-flex flex-column position-absolute">
                                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-1.svg" alt="" />
                                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-2.svg" alt="" />
                                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-3.svg" alt="" />
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content mt-0 mt-lg-3">
                        <div class="description">
                            <a href="<?php echo get_permalink( $art->{'ID'} )?>">
                                <p><?php echo get_the_title($art->{'ID'})?></p>
                            </a>
                        </div>
                        <div class="article-info-container">
                            <div>
                                <div class="author">
                                <?php $terms = get_the_terms($art->{'ID'},get_option('balancer_editorial_autor'))?>
                                    <p>Por: <?php echo join(' y ', wp_list_pluck($terms, 'name'))?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
          
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