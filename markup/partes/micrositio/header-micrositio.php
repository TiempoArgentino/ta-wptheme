<?php

$queried_object = get_queried_object();
$micrositio = null;

if (isset($queried_object->taxonomy) && $queried_object->taxonomy == 'ta_article_micrositio') {
    $micrositio = TA_Micrositio::get_micrositio($queried_object->slug);
} else if (isset($queried_object->post_type)) {
    $article = TA_Article_Factory::get_article($queried_object);
    if ($article && $article->micrositio)
        $micrositio = $article->micrositio;
}

if (!$micrositio)
    return;

?>

<div class="header header-micrositio ta-context micrositio <?php echo esc_attr($micrositio->slug); ?>">
    <div class="context-bg">
        <div class="context-color">
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
                    <!-- <div class="weather d-none d-lg-flex flex-column align-content-center justify-content-start text-left  mr-5">
                        <div class="mt-2">
                            <div class="date">
                                <p class="text-capitalize"><?php //echo date_i18n('l, j F , Y'); ?></p>
                            </div>
                            <div class="temp-city ta-gris-color">
                                <p>11.4º C <span>| Buenos Aires | Clima en todo el país</span></p>
                            </div>
                        </div>
                    </div> -->
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
            <div class="banner-micrositio">
                <div class="topic-tag d-flex justify-content-center">
                    <div class="triangle-left"></div>
                    <div class="content d-flex align-items-center justify-content-center">
                        <p><?php echo esc_html($micrositio->title); ?></p>
                    </div>
                    <div class="triangle-right"></div>
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
<div class="header header-sticky-micrositio ta-context micrositio <?php echo esc_attr($micrositio->slug); ?>" id="headerStickyMobile">
    <div class="context-bg">
        <div class="context-color">
            <div class="header-content d-flex justify-content-between">
                <div class="banner-micrositio sticky position-relative">
                    <div class="topic-tag d-flex justify-content-center align-items-center">
                        <div class="content">
                            <div class="container h-100 pr-0">
                                <div class="d-flex align-self-center h-100">
                                    <div class="hamburger-menu d-flex align-items-center mr-lg-5">
                                        <button id="menuBtn" type="button" class="collapsed" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </button>
                                    </div>
                                    <div class="tiempo-logo mr-lg-5">
                                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/logo-min-tiempo.svg" class="img-fluid" alt="">
                                    </div>
                                    <div class="title d-flex align-items-center">
                                        <h2>Activo Ambiental</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="triangle-right"></div>
                    </div>
                </div>

                <div class="asociate-banner-micrositio">
                    <div class="container h-100 pl-0">
                        <div class="asociate-banner-content d-flex align-items-center h-100">
                            <a href="">
                                <p class="m-0">Asociate</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="d-none d-lg-flex justify-content-between align-items-center">
                    <button id="search-btn" class="search-icon mr-3 btn btn-link d-flex collapsed" data-toggle="collapse" data-target="#searchBar" aria-expanded="false" aria-controls="searchBar">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/search-icon.svg" class="img-fluid" alt="">
                        </div>
                    </button>
                    <div class="profile-icon">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/profile-icon.svg" class="img-fluid" alt="">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="header header-sticky-micrositio ta-context micrositio ambiental" id="headerStickyDesktop">
    <div class="context-bg">
        <div class="context-color">
            <div class="container">
                <div class="header-content d-flex justify-content-between">
                    <div class="hamburger-and-logo d-flex align-self-center">
                        <div class="hamburger-menu d-flex align-items-center">
                            <button id="menuBtn" type="button" class="collapsed" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                        <div class="tiempo-logo mr-lg-5">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/tiempo-logo-gris.svg" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="banner-micrositio d-flex align-items-center">
                        <div class="topic-tag d-flex justify-content-center w-100">
                            <div class="triangle-left"></div>
                            <div class="content d-flex align-items-center justify-content-center">
                                <p>ACTIVO AMBIENTAL</p>
                            </div>
                            <div class="triangle-right"></div>
                        </div>
                    </div>
                    <div class="search-and-profile d-none d-lg-flex justify-content-end align-items-center">
                        <button id="search-btn" class="search-icon mr-3 btn btn-link d-flex collapsed" data-toggle="collapse" data-target="#searchBar" aria-expanded="false" aria-controls="searchBar">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/search-icon.svg" class="img-fluid" alt="">
                            </div>
                        </button>
                        <div class="profile-icon">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/profile-icon.svg" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>