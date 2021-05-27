<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Merriweather:wght@900&family=Red+Hat+Display:wght@400;500;700;900&family=Caladea:wght@700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.16/mediaelement-and-player.min.js" integrity="sha512-MgxzaA7Bkq7g2ND/4XYgoxUbehuHr3Q/bTuGn4lJkCxfxHEkXzR1Bl0vyCoHhKlMlE2ZaFymsJrRFLiAxQOpPg==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.16/mediaelementplayer.min.css" integrity="sha512-RZKnkU75qu9jzuyC+OJGffPEsJKQa7oNARCA6/8hYsHk2sd7Sj89tUCWZ+mV4uAaUbuzay7xFZhq7RkKFtP4Dw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
</head>

<body <?php body_class('ta-context portada'); ?>>

    <?php wp_body_open(); ?>
    <!-- anuncio sobre portada -->
    <?php if (is_front_page()) : ?>
        <?php if (is_active_sidebar('home_desk_1')) { ?>
            <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
                <div class="row d-flex">
                    <div class="col-9 mx-auto text-center">
                        <?php dynamic_sidebar('home_desk_1'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endif; ?>
    <!-- anuncio sobre portada -->
    <?php if (is_single()) : ?>
        <!-- anuncio single seccion autor tag-->
        <?php if (is_active_sidebar('over-header-note')) { ?>
            <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
                <div class="row d-flex">
                    <div class="col-9 mx-auto text-center">
                        <?php dynamic_sidebar('over-header-note'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- anuncio single seccion autor tag-->
    <?php endif; ?>
    <!-- taxonomia -->
    <?php if (is_tax()) : ?>
        <?php if (is_active_sidebar('seccion_head_1')) { ?>
            <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
                <div class="row d-flex">
                    <div class="col-9 mx-auto text-center">
                        <?php dynamic_sidebar('seccion_head_1'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endif; ?>
    <!-- taxonomia -->
    <div class="header mb-4" id="headerDefault">
        <div class="container">
            <div class="desktop-ribbon d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="beneficios-socios d-flex align-items-center px-2">
                        <p><a href="<?php echo get_permalink(get_option('beneficios_loop_page')) ?>"><?php echo __('Comunidad Tiempo', 'gen-base-theme') ?></a></p>
                    </div>
                    <div class="d-flex justify-content-between flex-fill mx-2">
                        <div class="temas-importantes d-flex align-items-center">
                            <div class="title d-flex p-1">
                                <div class="d-flex mr-2">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/importante-icon.svg" alt="">
                                </div>
                                <div>
                                    <p><?php echo __('IMPORTANTE >', 'gen-base-theme') ?></p>
                                </div>
                            </div>
                            <?php
                            $importante_menu_items = RB_Menu::get_menu_items('importante-menu');

                            if ($importante_menu_items && !empty($importante_menu_items)) :
                                foreach ($importante_menu_items as $menu) :
                            ?>
                                    <div class='d-flex justify-content-between'>
                                        <a href="<?php echo $menu->url ?>">
                                            <p class="mx-3"><?php echo esc_html($menu->title); ?></p>
                                        </a>
                                    </div>
                            <?php endforeach;
                            endif; ?>
                        </div>
                        <!-- redes -->

                        <div class="redes d-flex">
                            <?php
                            $social_data = ta_get_social_data();
                            if($social_data && !empty($social_data)):
                                foreach ($social_data as $social) :
                                ?>
                                    <div class="<?php echo $social['name'] ?>">
                                        <a href="<?php echo esc_attr($social['url']); ?>" target="_blank">
                                            <div>
                                                <img src="<?php echo ta_get_social_image($social['name'], 'white') ?>" class="img-fluid" alt="">
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-content d-flex justify-content-between pb-1">
                <div class="search-and-profile d-flex align-self-center pt-2">
                    <div class="hamburger-menu d-flex align-items-center mr-lg-5">
                        <button id="menuBtn" type="button" class="collapsed" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="tiempo-logo mr-lg-5">
                        <a href="<?php echo home_url() ?>"><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/tiempo-logo.svg" class="img-fluid" alt=""></a>
                    </div>
                    <div class="weather d-none d-lg-flex flex-column align-content-center justify-content-start text-left  mr-5">
                        <div class="mt-2">
                            <div class="date">
                                <p class="text-capitalize"><?php echo date_i18n('l, j F , Y'); ?></p>
                            </div>
                            <div class="temp-city ta-gris-color">
                                <p>11.4º C <span>| Buenos Aires | Clima en todo el país</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-lg-flex justify-content-between align-items-center">
                    <button id="search-btn" class="search-icon mr-3 btn btn-link d-flex collapsed" data-toggle="collapse" data-target="#searchBar" aria-expanded="false" aria-controls="searchBar">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/search-icon.svg" class="img-fluid" alt="">
                        </div>
                    </button>
                    <?php if (!is_user_logged_in()) : ?>
                        <div class="profile-icon">
                            <a href="<?php echo get_permalink(get_option('user_panel_page')) ?>"><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/profile-icon.svg" class="img-fluid" alt=""></a>
                        </div>
                    <?php else : ?>
                        <div class="logged-user mx-2">
                            <div class="d-flex align-items-center">
                                <div class="welcome">
                                    <div>
                                        <p>hola</p>
                                    </div>
                                    <div class="user-name">
                                        <p><?php echo wp_get_current_user()->first_name ?></p>
                                    </div>
                                </div>
                                <div class="user-img ml-2">
                                    <a href="<?php echo get_permalink(get_option('user_panel_page')) ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/logged-profile-icon.svg" alt=""></a>
                                    <a href="<?php echo wp_logout_url(home_url()); ?>">Salir</a>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="asociate-banner position-relative ml-md-3">
                    <div class="asociate-banner-bg h-100 ">
                        <a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>"> <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/asociate-banner.svg" class="img-fluid" alt=""></a>
                    </div>
                    <div class="asociate-banner-content position-absolute">
                        <div class="separator"></div>
                        <p class="mt-1"><a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>"><?php echo __('SUMATE','gen-base-theme')?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="searchBar" class="collapse my-4" aria-labelledby="searchBar" data-parent="#search-btn">
        <div class="container">
            <?php get_template_part('parts/common', 'searchform', array(
                'search_query'  => get_search_query(),
                'close_button'  => true,
            )); ?>
        </div>
    </div>
    <?php include_once(TA_THEME_PATH . '/markup/partes/menu.php');  ?>

    <!-- anuncio sobre portada -->
    <?php if (is_front_page()) : ?>
        <?php if (is_active_sidebar('home_desk_2')) { ?>
            <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
                <div class="row d-flex">
                    <div class="col-9 mx-auto text-center">
                        <?php dynamic_sidebar('home_desk_2'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endif; ?>
    <?php if (is_front_page()) : ?>
        <?php if (is_active_sidebar('home_mob_1')) { ?>
            <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 text-center mt-3">
                <div class="row d-flex">
                    <div class="col-12 mx-auto text-center">
                        <?php dynamic_sidebar('home_mob_1'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endif; ?>
    <!-- taxonomia -->
    <?php if (is_tax()) : ?>
        <?php if (is_active_sidebar('seccion_head_2')) { ?>
            <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
                <div class="row d-flex">
                    <div class="col-9 mx-auto text-center">
                        <?php dynamic_sidebar('seccion_head_2'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (is_active_sidebar('seccion_mob_1')) { ?>
            <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 text-center mt-3">
                <div class="row d-flex">
                    <div class="col-12 mx-auto text-center">
                        <?php dynamic_sidebar('seccion_mob_1'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endif; ?>
    <!-- taxonomia -->
    <!-- pops -->
    <?php if (is_front_page()) : ?>
        <?php if (is_active_sidebar('popup')) { ?>
            <div id="popup-avis" class="d-none d-sm-none d-md-block d-lg-block position-fixed">
                <div class="popup">
                    <span class="cerrar-pop">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/times-circle-regular.svg" />
                    </span>
                    <?php dynamic_sidebar('popup'); ?>
                </div>
            </div>
        <?php } ?>
    <?php endif; ?>

    <?php if (is_front_page()) : ?>
        <?php if (is_active_sidebar('vslider_mobile')) { ?>
            <div id="popup-avis" class="d-block d-sm-none d-md-none d-lg-none position-fixed">
                <div class="popup popup-mobile">
                    <span class="cerrar-pop pop-mobile-close">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/times-circle-regular.svg" />
                    </span>
                    <?php dynamic_sidebar('vslider_mobile'); ?>
                </div>
            </div>
        <?php } ?>
    <?php endif; ?>
