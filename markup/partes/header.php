<!-- anuncio sobre header single -->
<?php if(is_single()):?>
    <?php if (is_active_sidebar('over-header-note')) { ?>
<div class="container d-sm-none d-md-block mt-md-3 mb-md-3">
    <div class="row d-flex">
        <div class="col-9 mx-auto">
            <?php dynamic_sidebar('over-header-note'); ?>          
        </div>
    </div>
</div>
<?php } ?>
<?php endif;?>
<!-- anuncio sobre header single -->
<div class="header" id="headerDefault">
    <div class="container">
        <div class="desktop-ribbon d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="beneficios-socios d-flex align-items-center px-2">
                    <p>Beneficios para SOCIOS</p>
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
        <div class="header-content d-flex justify-content-between pb-1 pb-lg-3">
            <div class="d-flex align-self-center pt-2">
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
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/tiempo-logo.svg" class="img-fluid" alt="">
                </div>
                <div
                    class="weather d-none d-lg-flex flex-column align-content-center justify-content-start text-left  mr-5">
                    <div class="mt-2">
                        <div class="date">
                            <p>Mié. 2 de Septiembre de 2020</p>
                        </div>
                        <div class="temp-city ta-gris-color">
                            <p>11.4º C <span>| Buenos Aires | Clima en todo el país</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none d-lg-flex justify-content-between align-items-center">
                <button id="search-btn" class="search-icon mr-3 btn btn-link d-flex collapsed" data-toggle="collapse"
                    data-target="#searchBar" aria-expanded="false" aria-controls="searchBar">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/search-icon.svg" class="img-fluid" alt="">
                    </div>
                </button>
                <div class="profile-icon">
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/profile-icon.svg" class="img-fluid" alt="">
                </div>
            </div>
            <div class="asociate-banner position-relative">
                <div class="asociate-banner-bg">
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/asociate-banner.svg" class="img-fluid" alt="">
                </div>
                <div class="asociate-banner-content position-absolute">
                    <div class="separator"></div>
                    <p class="mt-1">ASOCIATE</p>
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
                    <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#searchBar"
                        aria-expanded="true" aria-controls="searchBar">
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
                        <button class="btn btn-link d-none d-lg-flex" data-toggle="collapse" data-target="#searchBar"
                            aria-expanded="true" aria-controls="searchBar">
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
<div class="d-none d-lg-block">
    <?php include_once(TA_THEME_PATH . '/markup/partes/banner-covid.php');  ?>
</div>
