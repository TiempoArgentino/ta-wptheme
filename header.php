<!DOCTYPE html>
<html <?php language_attributes();
add_filter( 'wp_title', function(){
    er();
}, 5465446544, 2 );

 ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Merriweather:wght@900&family=Red+Hat+Display:wght@400;500;700;900&family=Caladea:wght@700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.16/mediaelement-and-player.min.js" integrity="sha512-MgxzaA7Bkq7g2ND/4XYgoxUbehuHr3Q/bTuGn4lJkCxfxHEkXzR1Bl0vyCoHhKlMlE2ZaFymsJrRFLiAxQOpPg==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.16/mediaelementplayer.min.css" integrity="sha512-RZKnkU75qu9jzuyC+OJGffPEsJKQa7oNARCA6/8hYsHk2sd7Sj89tUCWZ+mV4uAaUbuzay7xFZhq7RkKFtP4Dw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
</head>

<body <?php body_class(); ?>>


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
    <!-- anuncio sobre header single -->
    <?php if (is_single()) : ?>
        <?php if (is_active_sidebar('over-header-note')) { ?>
            <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
                <div class="row d-flex">
                    <div class="col-9 mx-auto text-center">
                        <?php dynamic_sidebar('over-header-note'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endif; ?>
    <!-- anuncio sobre header single -->
    <div class="header mb-4" id="headerDefault">
        <div class="container">
            <div class="desktop-ribbon d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="beneficios-socios d-flex align-items-center px-2">
                        <p>Comunidad Tiempo</p>
                    </div>
                    <div class="d-flex justify-content-between flex-fill mx-2">
                        <div class="temas-importantes d-flex align-items-center">
                            <div class="title d-flex p-1">
                                <div class="d-flex mr-2">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/importante-icon.svg" alt="">
                                </div>
                                <div>
                                    <p>IMPORTANTE ></p>
                                </div>
                            </div>
                            <div class='d-flex justify-content-between'>
                                <a href="">
                                    <p class="mx-3">Activo Ambiental</p>
                                </a>
                                <a href="">
                                    <p class="mx-3">Hábitat y pandemia</p>
                                </a>
                                <a href="">
                                    <p class="mx-3">Monitor de Medios</p>
                                </a>
                            </div>
                        </div>
                        <div class="redes d-flex">
                            <div class="twitter">
                                <a href="">
                                    <div>
                                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/twitter-white-icon.svg" class="img-fluid" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="instagram">
                                <a href="">
                                    <div>
                                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/instagram-white-icon.svg" class="img-fluid" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="facebook">
                                <a href="">
                                    <div>
                                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/facebook-white-icon.svg" class="img-fluid" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="youtube">
                                <a href="">
                                    <div>
                                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/youtube-white-icon.svg" class="img-fluid" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="spotify">
                                <a href="">
                                    <div><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/spotify-white-icon.svg" class="img-fluid" alt="">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-content d-flex justify-content-between pb-1">
                <div class="search-and-profile d-flex align-self-center pt-2">
                    <div class="hamburger-menu d-flex align-items-center mr-lg-5">
                        <button id="menuBtn" type="button" class="collapsed" data-toggle="collapse"
                            data-target="#menu" aria-controls="menu"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="tiempo-logo mr-lg-5">
                        <a href="<?php echo home_url()?>"><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/tiempo-logo.svg" class="img-fluid" alt=""></a>
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
                <div class="asociate-banner position-relative">
                    <div class="asociate-banner-bg">
                        <a href="<?php echo get_permalink(65903) ?>"> <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/asociate-banner.svg" class="img-fluid" alt=""></a>
                    </div>
                    <div class="asociate-banner-content position-absolute">
                        <div class="separator"></div>
                        <p class="mt-1"><a href="<?php echo get_permalink(65903) ?>">SUMATE</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="searchBar" class="collapse my-4" aria-labelledby="searchBar" data-parent="#search-btn">
        <div class="container">
            <div class="search-bar-container px-3 pt-3 pb-4">
                <div class="close d-flex d-lg-none justify-content-end">
                    <div>
                        <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#searchBar" aria-expanded="true" aria-controls="searchBar">
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
                    <div class="close d-flex justify-content-end align-items-center ml-3">
                        <div>
                            <button class="btn btn-link d-none d-lg-flex" data-toggle="collapse" data-target="#searchBar" aria-expanded="true" aria-controls="searchBar">
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
