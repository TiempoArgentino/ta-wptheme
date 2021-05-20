<?php get_header();
do_action('header_thankyou_page');
?>

<div class="container ta-context asociate gray-border mt-2 my-lg-5">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4>asociate<span class="ml-2">Finalizar</span></h4>
        </div>
        <?php if (null === Subscriptions_Sessions::get_session('subscriptions_add_session') || !is_user_logged_in()) : ?>
            <div class="container">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4 class="italic"><?php echo __('Hola, antes debés seleccionar ', 'gen-base-theme') ?><span><?php echo __('un paquete.', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="metodo-pago-block">
                                <div class="subtitle text-center mt-4">
                                    <p><?php echo __('Para continuar al pago, primero debes seleccionar un paquete, haz click en el bóton para volver.', 'gen-base-theme') ?></b>
                                </div>
                                <div class="btns-container text-center mt-4">
                                    <button><a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>"><?php echo __('Volver.', 'gen-base-theme') ?></a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>

            <div class="container">
                <div class="container-with-header">
                    <div class="py-2">
                        <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5">
                            <div class="title text-center">
                                <h4 class="italic m-0"><?php echo __('Gracias', 'gen-base-theme') ?> <span><?php echo wp_get_current_user()->first_name . ' ' . wp_get_current_user()->last_name ?></span>, </h4>
                                <h4 class="italic m-0"><?php echo __('por elegir Tiempo Argentino, un medio autogestionado es posible gracias a personas como vos!', 'gen-base-theme') ?></h4>
                                <h4 class="italic m-0"></h4>
                            </div>
                            <div class="asociate-wrapper">
                                <!--<div class="subtitle text-center mt-4">
                                    <p>Muy pronto alguien de Tiempo Argentino te escribirá por e-mail para efectuar el pago.</p>
                                </div>-->
                                <div class="title text-center mt-5">
                                    <p><b><?php echo __('¿Querés contarnos un poco más de vos?','gen-base-theme')?></b></p>
                                </div>
                                <div class="text-center">
                                    <p><?php echo __('De esta forma podremos ofrecerte contenidos de acuerdo a tus preferencias','gen-base-theme')?></p>
                                </div>
                                <div class="btns-container text-center">
                                    <button><a href="<?php echo get_permalink(get_option('personalize'))?>"><?php echo __('Personalizar','gen-base-theme')?></a></button>
                                    <button class="gray-btn-black-text"><a href="<?php echo home_url()?>"><?php echo __('ir al sitio','gen-base-theme')?></a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer() ?>