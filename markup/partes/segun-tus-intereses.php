<div class="container-with-header light-blue-bg py-3 mt-3">
    <div class="container d-block d-lg-flex justify-content-between align-items-center">
        <div class="section-title">
            <h4><?php echo __('SEGÚN TUS INTERESES','gen-theme-base')?></h4>
        </div>
        <div class="btns-container d-none d-lg-block">
            <div class="personalizar">
                <button><a href="<?php echo get_permalink(get_option('personalize'))?>"><?php echo __('PERSONALIZAR','gen-theme-base')?></a></button>
            </div>
        </div>
    </div>
    <div class="sub-blocks mt-3">
        <div class="container px-0 px-md-1">
            <div class="ta-articles-block d-flex">
                <?php if(function_exists('balancer_front')): 
                    foreach(balancer_front()->interesting(4) as $art):?>
                <div class="article-preview vertical-article d-flex flex-column mb-3 col-12 col-md-3">
                    <div>
                        <a href="<?php echo get_permalink($art->{'ID'}) ?>">
                            <div class="img-container position-relative">
                                <div class="img-wrapper d-flex align-items-end" style="background:url('<?php echo get_the_post_thumbnail_url($art->{'ID'}) ?>') center no-repeat !important;background-size: cover;">
                                      <!-- iconos -->
                                        <?php if (function_exists('balancer_front')) : ?>
                                            <div class="icons-container">
                                            <div class="article-icons d-flex flex-column mb-2">
                                                    <?php balancer_front()->show_interest_post(
                                                        wp_get_current_user()->ID,
                                                        $art->{'ID'},
                                                        get_stylesheet_directory_uri() . '/assets/img/icon-img-1.svg',
                                                        get_stylesheet_directory_uri() . '/assets/img/icon-img-2.svg',
                                                        get_stylesheet_directory_uri() . '/assets/img/icon-img-3.svg'
                                                    ); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <!-- iconos -->
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content">
                        <div class="description">
                        <a href="<?php echo get_permalink($art->{'ID'}) ?>">
                            <p><?php echo get_the_title($art->{'ID'}) ?></p>
                        </a>
                        </div>
                        <div class="article-info-container">
                            <div>
                                <div class="author">
                                <?php $terms = get_the_terms($art->{'ID'}, get_option('balancer_editorial_autor')) ?>
                                <p>Por: <?php echo join(' y ', wp_list_pluck($terms, 'name')) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <?php endforeach; 
               endif;?>
            </div>
            <div class="container">
                <div class="btns-container d-flex justify-content-between justify-content-lg-end">
                    <div class="personalizar d-block d-lg-none">
                        <button><a href="<?php echo get_permalink(get_option('personalize'))?>"><?php echo __('PERSONALIZAR','gen-theme-base')?></a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>