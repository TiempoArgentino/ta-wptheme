<?php
get_header();

do_action('subscriptions_payment_page_header');
?>

<div class="container ta-context asociate gray-border mt-2 my-lg-5">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <?php do_action('subscriptions_payment_page_message_before'); ?>
        <div class="section-title p-2">
            <h4><?php echo __('asociate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('MÉTODO DE PAGO', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <?php if (null === Subscriptions_Sessions::get_session('subscriptions_add_session') || !is_user_logged_in()) : ?>
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
                    <?php else : ?>
                        <div class="subs-opt mt-3 mt-md-5">
                            <div class="title text-center">
                                <h4 class="italic"><?php echo __('¡Gracias', 'gen-base-theme') ?> <span><?php echo wp_get_current_user()->first_name . ' ' . wp_get_current_user()->last_name ?></span> <?php echo __('por apoyar Tiempo Argentino!', 'gen-base-theme') ?></h4>
                            </div>
                            <div class="asociate-wrapper">
                                <div class="metodo-pago-block">
                                    <div class="subtitle text-center mt-4">
                                        <p><?php echo __('Para continuar con el proceso selecciona un', 'gen-base-theme') ?> <b><?php echo __('método de pago:', 'gen-base-theme') ?></b></p>
                                    </div>
                                    <div class="btns-container text-center mt-4">
                                        <?php do_action('payment_getways') ?>
                                    </div>
                                </div>

                                <div class="info text-center mt-5">
                                    <h6 class="mt-2"><?php echo sprintf(__('Podrás %s %s', 'gen-base-theme'), '<b>' . __('suspender tu abono', 'gen-base-theme') . '</b>', __('cuando quieras desde tu perfil de usuario', 'gen-base-theme')) ?></h6>
                                </div>
                                <div class="ayuda text-center mt-4 mb-3">
                                    <h6><?php echo __('Si deseas obtener ayuda con el proceso de pago, podés escribir un mail a', 'gen-base-theme') ?>
                                    </h6>
                                    <h6><a class="highlighted" href="mailto:<?php echo get_option('subscriptions_email_sender');?>"><?php echo get_option('subscriptions_email_sender');?></a>
                                    </h6>
                                </div>
                                <?php do_action('subscriptions_payment_page_after_methods'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php do_action('subscriptions_payment_page_message_after'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer() ?>