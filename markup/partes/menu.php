<?php
$social_data = ta_get_social_data();
$sections_menu = RB_Menu::get_theme_menu('sections-menu');
$sections_menu_items = RB_Menu::get_menu_items('sections-menu');
$special_menu = RB_Menu::get_theme_menu('special-menu');
$special_menu_items = RB_Menu::get_menu_items('special-menu');
$extra_menu = RB_Menu::get_theme_menu('extra-menu');
$extra_menu_items = RB_Menu::get_menu_items('extra-menu');
?>
<div class="menu container-lg collapse" id="navbarToggleExternalContent">
    <div class="container">
        <div class="menu-header d-flex justify-content-between">
            <div class="d-flex justify-content-between">
                <div class="hamburger-menu">
                    <button id="menuBtn" type="button" class="collapsed" data-toggle="collapse"
                        data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
                <div class="tiempo-menu-logo mb-lg-3">
                <a href="<?php echo home_url()?>"><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/ta-min-logo-color.svg" class="img-fluid" alt=""></a>
                </div>
            </div>
            <div class="d-flex d-lg-none justify-content-between">
                <button id="search-btn2" class="search-icon mr-3 btn btn-link d-flex collapsed" data-toggle="collapse"
                    data-target="#searchBarMenu" aria-expanded="false" aria-controls="searchBarMenu">
                    <div>
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/search-icon.svg" class="img-fluid" alt="">
                    </div>
                </button>
                <div class="profile-icon">
                <a href="<?php echo get_permalink( get_option('user_panel_page') )?>"><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/profile-icon.svg" class="img-fluid" alt=""></a>
                </div>
            </div>
        </div>
        <div id="searchBarMenu" class="collapse mb-4" aria-labelledby="searchBarMenu" data-parent="#search-btn2">
            <div class="search-bar-container px-3 pt-3 pb-4">
                <div class="close d-flex d-lg-none justify-content-end">
                    <div>
                        <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#searchBarMenu"
                            aria-expanded="true" aria-controls="searchBarMenu">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/close.svg" class="img-fluid" alt="">
                        </button>
                    </div>
                </div>
                <div class="input-container d-flex justify-content-center mt-3">
                    <div class="search-icon mr-2">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/search-icon-blue.svg" class="img-fluid" alt="">
                    </div>
                    <div class="input-wrapper flex-fill">
                        <input type="text" placeholder="buscar en Tiempo Argentino_" />
                    </div>
                    <div class="search d-none d-lg-flex justify-content-center ml-3">
                        <button>BUSCAR</button>
                    </div>
                    <div class="close d-none d-lg-flex justify-content-end align-items-center ml-3">
                        <div>
                            <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#searchBarMenu"
                                aria-expanded="true" aria-controls="searchBarMenu">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/close.svg" class="img-fluid" alt="">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="search d-flex d-lg-none justify-content-center mt-4">
                    <button>BUSCAR</button>
                </div>
            </div>
        </div>
        <div class="d-block d-lg-flex flex-column flex-lg-row">
            <div class="menu-section-wrapper">
                <div class="separator"></div>
                <div class="menu-section d-none d-lg-block pt-0">
                    <div class="menu-item destacados">
                        <div class="d-flex align-items-center">
                            <button id="search-btn2" class="search-icon mr-3 btn btn-link d-flex collapsed"
                                data-toggle="collapse" data-target="#searchBarMenu" aria-expanded="false"
                                aria-controls="searchBarMenu">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/search-icon.svg" class="img-fluid" alt="">
                                    <p>BUSCAR</p>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="menu-section d-none d-lg-block pt-0">
                    <div class="separator"></div>
                    <div class="menu-item destacados mt-3">
                        <a href="">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/profile-icon.svg" alt="">
                                <?php if(is_user_logged_in()): ?>
                                <p><a href="<?php echo get_permalink( get_option('user_panel_page') )?>">PERFIL</a></p>
                                <?php else: ?>
                                <p><a href="<?php echo get_permalink( get_option('user_login_page') )?>">INGRESAR</a></p>
                                <?php endif;?>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="menu-section">
                    <div class="menu-item destacados seamos-socios">
                        <a href="<?php echo get_permalink( 65903  )?>">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/marker-socios.svg" alt="">
                                <h5>SEAMOS SOCIOS</h5>
                            </div>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="<?php echo get_permalink( get_option('beneficios_loop_page') )?>">
                            <div>
                                <p class="pl-3">Beneficios para socios</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="separator d-none"></div>
                <div class="ta-redes d-none d-lg-block">
                    <div class="separator"></div>
                    <div class="menu-section">
                        <div class="menu-item destacados">
                            <a href="<?php echo get_permalink( 65814 )?>">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/tiempo-min-logo.svg" alt="">
                                    <p>SOBRE TIEMPO</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php if( $social_data && !empty($social_data) ): ?>
                    <div class="redes-sociales d-flex my-4">
                        <?php
                            foreach ($social_data as $social):
                                ?>
                                <div class="">
                                    <a href="<?php echo esc_attr($social['url']); ?>">
                                        <?php if( $social['image'] ): ?>
                                        <img src="<?php echo esc_attr($social['image']); ?>" alt="<?php echo esc_attr($social['name']); ?>">
                                        <?php else: ?>
                                        <i class="<?php echo $social['fa']; ?>"></i>
                                    <?php endif; ?>
                                    </a>
                                </div>
                                <?php
                            endforeach;
                        ?>
                    </div>
                    <?php endif; ?>
                    <div class="separator"></div>
                </div>
            </div>
            <div class="d-block d-lg-flex flex-column flex-lg-row flex-fill">
                <?php if( $sections_menu_items && !empty($sections_menu_items) ): ?>
                <div class="menu-section-wrapper">
                    <div class="separator"></div>
                    <div class="accordion-menu-section" id="accordion1">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/gray-arrow.svg" class="accordion-arrow" alt="">
                                    <h5>SECCIONES</h5>
                                </button>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordion1">
                                <div class="card-body pt-0 pb-3">
                                    <div class="menu-section">
                                        <?php
                                        foreach ($sections_menu_items as $section_menu_item):
                                            if($section_menu_item->object != 'ta_article_section')
                                                continue;
                                            $section = TA_Section_Factory::get_section( get_term($section_menu_item->object_id, 'ta_article_section'));
                                            if(!$section)
                                                continue;

                                            if(!ta_is_featured_section($section->slug)):
                                            ?>
                                                <div class="menu-item">
                                                    <div>
                                                        <a href="<?php echo esc_attr( $section->archive_url ); ?>">
                                                            <p><?php echo esc_html($section->name); ?></p>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="menu-item destacados <?php echo esc_attr($section->slug); ?> mb-3">
                                                    <a href="<?php echo esc_attr( $section->archive_url ); ?>">
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/marker-<?php echo esc_attr($section->slug); ?>.svg" alt="<?php echo esc_attr($section->name); ?>">
                                                            <h6><?php echo esc_html($section->name); ?></h6>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="separator d-none"></div>
                </div>
                <?php endif; ?>

                <?php if( $special_menu_items && !empty($special_menu_items) ): ?>
                <div class="menu-section-wrapper">
                    <div class="separator"></div>
                    <div class="accordion-menu-section" id="accordion2">
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/gray-arrow.svg" class="accordion-arrow" alt="">
                                    <h5>ESPECIALES</h5>
                                </button>
                            </div>

                            <div id="collapseTwo" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordion2">
                                <div class="card-body pt-0 pb-3">
                                    <div class="menu-section">
                                        <?php
                                        foreach ($special_menu_items as $special_menu_item):
                                            if($special_menu_item->object != 'ta_article_micrositio')
                                                continue;
                                            $micrositio_term = get_term($special_menu_item->object_id, 'ta_article_micrositio');
                                            $micrositio = $micrositio_term ? TA_Micrositio::get_micrositio( $micrositio_term->slug ) : null;
                                            if(!$micrositio)
                                                continue;
                                            ?>
                                            <div class="menu-item">
                                                <div>
                                                    <a href="<?php echo esc_attr($micrositio->archive_url); ?>">
                                                        <p><?php echo esc_html($micrositio->get_name()); ?></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator  d-none"></div>
                </div>
                <?php endif; ?>

                <?php if( $extra_menu_items && !empty($extra_menu_items) ): ?>
                <div class="menu-section-wrapper">
                    <div class="separator"></div>
                    <div class="menu-section pb-3">
                        <?php
                        foreach ($extra_menu_items as $extra_menu_item):
                            $attachment_id = get_post_meta($extra_menu_item->ID, 'ta_menu_item_image', true);
                            $img_url = $attachment_id ? wp_get_attachment_url($attachment_id) : '';
                            ?>
                            <div class="menu-item destacados">
                                <a href="" class="d-flex align-items-center">
                                    <div class="d-flex">
                                        <?php if( $img_url ): ?>
                                        <img src="<?php echo esc_attr($img_url); ?>" alt="">
                                        <?php endif; ?>
                                        <p><?php echo esc_html($extra_menu_item->title); ?></p>
                                    </div>
                                </a>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>
                    <div class="separator d-none"></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="menu-section-wrapper d-block d-lg-none">
                <div class="ta-redes">
                    <div class="separator"></div>
                    <div class="menu-section">
                        <div class="menu-item destacados">
                            <a href="<?php echo get_permalink( 65814 )?>">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/tiempo-min-logo.svg" alt="">
                                    <p>SOBRE TIEMPO</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php if( $social_data && !empty($social_data) ): ?>
                    <div class="redes-sociales d-flex my-4">
                        <?php
                            foreach ($social_data as $social):
                                ?>
                                <div class="">
                                    <a href="<?php echo esc_attr($social['url']); ?>">
                                        <?php if( $social['image'] ): ?>
                                        <img src="<?php echo esc_attr($social['image']); ?>" alt="<?php echo esc_attr($social['name']); ?>">
                                        <?php else: ?>
                                        <i class="<?php echo $social['fa']; ?>"></i>
                                    <?php endif; ?>
                                    </a>
                                </div>
                                <?php
                            endforeach;
                        ?>
                    </div>
                    <?php endif; ?>
                    <div class="separator"></div>
                </div>
            </div>
        </div>

    </div>
</div>
