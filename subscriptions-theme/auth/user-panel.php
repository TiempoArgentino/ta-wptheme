<?php do_action('before_subscriptions_profile_page') ?>
<?php do_action('subscriptions_edit_actions') ?>

<div class="tab-pane content-panel" id="subscription">

    <?php if (membership()->get_membership(wp_get_current_user()->ID)['id'] === null || isset(membership()->get_membership(wp_get_current_user()->ID)['status']) === 'cancel') : ?>
        <div class="subs-block mt-4">
            <div class="container">
                <div class="title text-center">
                    <h4><?php echo __('¡Suscribite a Tiempo Argentino!', 'gen-theme-base') ?></h4>
                </div>
                <div class="your-subscription mw-md-60 mx-auto text-center">
                    <div class="description">
                        <p><?php echo __('Hacete socio de Tiempo Argentino, mantenete informado apoyando al periedismo independiente y colaborá con un proyecto autogestivo. Vos decidís con que monto colaborar.', 'gen-theme-base') ?></p>
                    </div>
                    <div class="btns-container mt-3">
                        <a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>" class="btn btn-primary text-white text-uppercase"><?php echo __('SUSCRIBITE', 'gen-theme-base') ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="subs-block mt-4">
            <div class="container">
                <div class="title text-center">

                    <?php if (membership()->get_membership(wp_get_current_user()->ID)['type'] === 'subscription') : ?>
                        <h4><?php echo __('Estás suscrita/o a:', 'gen-theme-base') ?></h4>
                    <?php else : ?>
                        <h4><?php echo __('Tu aporte:', 'gen-theme-base') ?></h4>
                    <?php endif; ?>
                </div>
                <div class="your-subscription mw-md-60 mx-auto">
                    <div class="plan-container py-3">
                        <div class="container">
                            <?php if (membership()->get_membership(wp_get_current_user()->ID)['type'] === 'subscription') : ?>
                                <div class="icon d-flex justify-content-center">
                                    <img src="<?php echo membership()->get_membership(wp_get_current_user()->ID)['image'] ?>" />
                                </div>
                            <?php endif; ?>
                            <div class="content">
                                <div class="container p-0">
                                    <div class="description text-center">
                                        <h4 class="m-0"><?php echo membership()->get_membership(wp_get_current_user()->ID)['title'] ?></h4>
                                        <p><?php echo __('Por un abono mensual de','gen-theme-base')?> <span><?php echo get_option('subscriptions_currency_symbol') ?><?php echo membership()->get_membership(wp_get_current_user()->ID)['price'] ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btns-container d-flex justify-content-between justify-content-md-center mt-3">
                        <button>Editar plan</button>
                        <form method="post" id="cancel-form-membership">
                        <input type="hidden" name="membership_id" value="<?php echo membership()->get_membership(wp_get_current_user()->ID)['id'] ?>">
                        <input type="hidden" name="payment_method_id" value="<?php echo membership()->get_membership(wp_get_current_user()->ID)['payment'] ?>">
                        <input type="hidden" name="action" value="cancel_membership" />
                        <input type="hidden" name="user_id" value="<?php echo wp_get_current_user()->ID ?>">
                        <button type="submit" name="cancel_subscription" class="gray-btn-black-text ml-2"><?php echo __('dar de baja', 'subscriptions') ?></button>
                    </form>
                        
                    </div>
                </div>
                <div class="benefits mw-md-60 mx-auto my-5">
                    <div class="title text-center">
                        <h4>Beneficios</h4>
                    </div>
                    <div class="btns-container">
                        <button class="d-flex align-items-center mt-3">
                            <div class="benefit-icon mr-2">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/img/historial-icon.svg" alt="" class="img-fluid">
                            </div>
                            <div class="benefit-title">
                                <p>Ver tu Historial <span>(3)</span></p>
                            </div>
                        </button>
                        <button class="d-flex align-items-center mt-3">
                            <div class="benefit-icon mr-2">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/img/benefits-icon.svg" alt="" class="img-fluid">
                            </div>
                            <div class="benefit-title">
                                <p>Ver todos tus beneficios</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>