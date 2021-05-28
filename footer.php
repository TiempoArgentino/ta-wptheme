<div class="container">
    <div class="separator"></div>
    <div class="footer-content d-flex flex-column flex-lg-row justify-content-between my-3 mt-md-4 mb-md-5">
        <div class="ta-info col-12 col-lg-4">
            <div class="tiempo-logo">
                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/tiempo-logo.svg" class="img-fluid" alt="">
            </div>
            <div class="description ta-celeste-color mt-3">
                <p>Es una publicación de Cooperativa de Trabajo Por Más Tiempo Limitada</p>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <div>
                <div class="address">
                    <p class="mb-1"><?php echo get_option( 'datos_footer_option_name' )['direccin_0']?></p>
                </div>
                <div class="legal-info">
                    <p class="mb-0"><span>Editores:</span> <?php echo get_option( 'datos_footer_option_name' )['editores_1']?></p>
                    <p><span>Registro de Propiedad Intelectual:</span> <?php echo get_option( 'datos_footer_option_name' )['registro_n_o_texto_2']?></p>
                </div>
            </div>
            <div class="edition mt-3">
                <p class="mb-0"><span class="ta-celeste-color">Edición Nº <?php echo get_option( 'datos_footer_option_name' )['n_edicin_3']?></span> / <?php echo get_option( 'datos_footer_option_name' )['fecha_4']?></p>
                <p class="derechos">Algunos derechos reservados</p>
            </div>
        </div>

    </div>
</div>

<?php if (is_front_page()) : ?>

<?php if (is_active_sidebar('footer_fixed')) { ?>
    <div id="sticky-abajo" class="d-none d-sm-none d-md-block d-lg-block position-fixed text-center">
        <div class="sticky-bajo">
            <span class="cerrar-pop-abajo">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/times-circle-regular.svg" />
            </span>
            <?php dynamic_sidebar('footer_fixed'); ?>
        </div>
    </div>
<?php } ?>

<?php if (is_active_sidebar('footer_fixed_mobile')) { ?>
    <div id="sticky-abajo" class="d-block d-sm-none d-md-none d-lg-none position-fixed text-center">
        <div class="sticky-bajo mobile-fixed">
            <span class="cerrar-pop-abajo mobile-pop-close">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/times-circle-regular.svg" />
            </span>
            <?php dynamic_sidebar('footer_fixed_mobile'); ?>
        </div>
    </div>
<?php } ?>

<?php if (is_active_sidebar('vslider_desktop')) { ?>
    <div id="vslider" class="d-none d-sm-none d-md-block d-lg-block position-fixed text-center">
        <div class="video-bajo">
            <span class="cerrar-vslider-desktop">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/times-circle-regular.svg" />
            </span>
            <?php dynamic_sidebar('vslider_desktop'); ?>
        </div>
    </div>
<?php } ?>

<?php if (is_active_sidebar('vslider_desktop')) { ?>
    <div id="vslider" class="d-block d-sm-none d-md-none d-lg-none position-fixed text-center">
        <div class="video-bajo">
            <span class="cerrar-vslider-desktop cerrar-video-abajo">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/times-circle-regular.svg" />
            </span>
            <?php dynamic_sidebar('vslider_desktop'); ?>
        </div>
    </div>
<?php } ?>

<?php endif?>
<?php wp_footer(); ?>
</body>

</html>