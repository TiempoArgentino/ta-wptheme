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
                    <!-- info-->
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
                                        <p><?php echo __('Por un abono mensual de', 'gen-theme-base') ?> <span><?php echo get_option('subscriptions_currency_symbol') ?><?php echo membership()->get_membership(wp_get_current_user()->ID)['price'] ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- button -->
                    <div class="btns-container d-flex justify-content-between justify-content-md-center mt-3">
                        <button type="button" name="edit_subscription" id="edit_subscription" type="button" name="edit_subscription" id="edit_subscription">Editar plan</button>
                        <?php do_action('edit_membership_user_panel') ?>
                        <form method="post" id="cancel-form-membership">
                            <input type="hidden" name="membership_id" value="<?php echo membership()->get_membership(wp_get_current_user()->ID)['id'] ?>">
                            <input type="hidden" name="payment_method_id" value="<?php echo membership()->get_membership(wp_get_current_user()->ID)['payment'] ?>">
                            <input type="hidden" name="action" value="cancel_membership" />
                            <input type="hidden" name="user_id" value="<?php echo wp_get_current_user()->ID ?>">
                            <button type="submit" name="cancel_subscription" class="gray-btn-black-text ml-2"><?php echo __('dar de baja', 'gen-theme-base') ?></button>
                        </form>
                        <div id="become-a-member">
                            <?php if (membership()->get_membership(wp_get_current_user()->ID)['type'] === 'donation') : ?>
                                <h3 class="mt-5 mb-3"><?php echo __('Convert your contribution in a subscription', 'gen-theme-base') ?></h3>
                                <a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>" class="btn btn-primary text-white text-uppercase"><?php echo __('become a member', 'gen-theme-base') ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- edit form -->
                    <div class="mt-3">
                        <div class="row mt-3" id="membership-edit-subscriptions">
                            <div class="col-12 mx-auto text-center">

                                <?php do_action('subscriptions_edit_actions') ?>

                                <h3><?php echo __('Edit your subscription', 'gen-theme-base') ?></h3>
                                <p><?php echo __('Remember, the minimun for this transaction is: ', 'gen-theme-base') ?>$ <span id="min-price-show"><?php echo membership()->get_minimun() ?></span></p>
                                <div id="msg-form"></div>
                                <form method="post" id="paymentForm<?php echo membership()->get_membership(wp_get_current_user()->ID)['payment'] ?>" class="subscritpions-form">
                                    <?php if (membership()->get_membership(wp_get_current_user()->ID)['type'] === 'subscription') : ?>
                                        <div class="form-group">
                                            <label><?php echo __('Cambiar mi plan', 'gen-theme-base') ?></label>
                                            <?php membership()->get_subscriptions_names('form-control') ?>
                                        </div>
                                        <div class="form-group checkbox-container" id="paper-option">
                                            <input type="checkbox" class="paper-checkbox" name="paper" id="paper" value="<?php echo membership()->get_paper_value() ?>" <?php echo checked('1', membership()->get_membership(wp_get_current_user()->ID)['physical'], false) ?> />
                                            <label for=""><?php echo __('Agrega diaro en papel', 'gen-theme-base') ?></label>
                                            <p class="help"><?php echo __('Recorda llenar tu dirección para el envío','gen-theme-base')?></p>
                                        </div>
                                    <?php endif; ?>
                                    <div class="from-group prices price-container mb-3">
                                        <?php echo __('Selecionar monto: ', 'gen-theme-base') ?>
                                        <?php if (membership()->get_price()) : ?>
                                            <div class="amount">
                                                <span class="price-select price"><?php echo membership()->get_price() ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php foreach (membership()->extra_price() as $key => $val) : ?>
                                            <div class="amount">
                                                <span class="price-select price"><?php echo $val ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <p class="monto"><?php echo __('o agrega un monto', 'gen-theme-base') ?></p>
                                    <div class="form-group">
                                        <label for=""><?php echo __('Abonar más', 'gen-theme-base') ?></label>
                                        <input type="number" min="<?php echo membership()->get_minimun() ?>" name="amount" id="amount-subscription" placeholder="<?php echo __('Price', 'gen-theme-base') ?>" class="form-control" value="<?php echo membership()->get_minimun() ?>" />
                                    </div>
                                    <?php do_action('edit_form_extra') ?>
                                    <input type="hidden" name="payment_method_id" value="<?php echo membership()->get_membership(wp_get_current_user()->ID)['payment'] ?>">
                                    <input type="hidden" name="payment_min" id="payment_min_s" value="<?php echo membership()->get_minimun() ?>" />
                                    <input type="hidden" name="membership_id" value="<?php echo membership()->get_membership(wp_get_current_user()->ID)['id'] ?>" />
                                    <input type="hidden" name="user_id" value="<?php echo wp_get_current_user()->ID ?>">
                                    <input type="hidden" name="subscription_name" value="" id="subscription_name">
                                    <input type="hidden" name="action" value="edit_membership" />
                                    <input type="hidden" id="user_edit_email" name="user_edit_email" class="form-control" value="<?php echo wp_get_current_user()->user_email ?>" />
                                    <div class="btns-container">
                                        <button type="submit" name="send-edit-subscription" id="paymentMP"><?php echo __('Editar', 'gen-theme-base') ?></button>
                                        <button type="button" id="cancel-edit-subscription" class="gray-btn-black-text ml-2"><?php echo __('Cancelar', 'gen-theme-base') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- edit form -->
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