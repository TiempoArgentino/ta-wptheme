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
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php include_once(TA_THEME_PATH . '/markup/partes/micrositio/header-micrositio.php');  ?>
    <?php if (is_active_sidebar('micrositio_head_1')) { ?>
        <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 text-center mt-3">
            <div class="row d-flex">
                <div class="col-12 mx-auto text-center">
                    <?php dynamic_sidebar('micrositio_head_1'); ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (is_active_sidebar('micrositio_mob_1')) { ?>
        <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 text-center mt-3">
            <div class="row d-flex">
                <div class="col-12 mx-auto text-center">
                    <?php dynamic_sidebar('micrositio_mob_1'); ?>
                </div>
            </div>
        </div>
    <?php } ?>