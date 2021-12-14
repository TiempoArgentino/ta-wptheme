<?php do_action('before_subscriptions_profile_page') ?>
<?php do_action('subscriptions_edit_actions') ?>

<div class="tab-pane content-panel" id="subscription">

    <?php if (membership()->get_membership(wp_get_current_user()->ID)['id'] === null || isset(membership()->get_membership(wp_get_current_user()->ID)['status']) === 'cancel') : ?>
        <div class="subs-block mt-4">
            <div class="container">
                <div class="title text-center">
                    <h4><?php echo __('¡Suscribite a Tiempo Argentino!', 'gen-base-theme') ?></h4>
                </div>
                <div class="your-subscription mw-md-60 mx-auto text-center">
                    <div class="description">
                        <p><?php echo __('Hacete socio de Tiempo Argentino, mantenete informado apoyando al periedismo independiente y colaborá con un proyecto autogestivo. Vos decidís con que monto colaborar.', 'gen-base-theme') ?></p>
                    </div>
                    <div class="btns-container mt-3">
                        <a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>" class="btn btn-primary text-white text-uppercase"><?php echo __('SUSCRIBITE', 'gen-base-theme') ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="subs-block mt-4">
            <div class="container">
                <div class="title text-center">

                    <?php if (membership()->get_membership(wp_get_current_user()->ID)['type'] === 'subscription') : ?>
                        <h4><?php echo __('Estás suscrita/o a:', 'gen-base-theme') ?></h4>
                    <?php else : ?>
                        <h4><?php echo __('Tu aporte:', 'gen-base-theme') ?></h4>
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
                                        <p><?php echo __('Por un abono mensual de', 'gen-base-theme') ?> <span><?php echo get_option('subscriptions_currency_symbol') ?><?php echo membership()->get_membership(wp_get_current_user()->ID)['price'] ?></span></p>
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
                            <button type="submit" name="cancel_subscription" class="gray-btn-black-text ml-2"><?php echo __('dar de baja', 'gen-base-theme') ?></button>
                        </form>
                        <div id="become-a-member">
                            <?php if (membership()->get_membership(wp_get_current_user()->ID)['type'] === 'donation') : ?>
                                <h3 class="mt-5 mb-3"><?php echo __('Convert your contribution in a subscription', 'gen-base-theme') ?></h3>
                                <a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>" class="btn btn-primary text-white text-uppercase"><?php echo __('become a member', 'gen-base-theme') ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- edit form -->
                    <div class="mt-3">
                        <div class="row mt-3" id="membership-edit-subscriptions">
                            <div class="col-12 mx-auto text-center">

                                <?php do_action('subscriptions_edit_actions') ?>

                                <h3><?php echo __('Editar membresía', 'gen-base-theme') ?></h3>
                                <p><?php echo __('Recorda, el mínimo es de: ', 'gen-base-theme') ?>$ <span id="min-price-show"><?php echo membership()->get_minimun() ?></span></p>
                                <div id="msg-form"></div>
                                <form method="post" id="paymentForm<?php echo membership()->get_membership(wp_get_current_user()->ID)['payment'] ?>" class="subscritpions-form">
                                    <?php if (membership()->get_membership(wp_get_current_user()->ID)['type'] === 'subscription') : ?>
                                        <div class="form-group">
                                            <label><?php echo __('Cambiar mi plan', 'gen-base-theme') ?></label>
                                            <?php membership()->get_subscriptions_names('form-control') ?>
                                        </div>
                                            <div class="form-group checkbox-container" id="paper-option">
                                                <input type="checkbox" 
                                                class="paper-checkbox" 
                                                name="paper" 
                                                id="paper" 
                                                value="<?php echo membership()->get_paper_value() ?>" 
                                                <?php echo checked('1', get_user_meta(wp_get_current_user()->ID,'_user_paper',true), false) ?> />
                                                <label for=""><?php echo __('Agregá el diario en papel', 'gen-base-theme') ?></label>
                                                <p class="help"><?php echo __('Recorda llenar tu dirección para el envío', 'gen-base-theme') ?></p>
                                            </div>
                                    <?php endif; ?>
                                    <div class="from-group prices price-container mb-3" id="users-prices-container">
                                        <?php echo __('Selecionar monto: ', 'gen-base-theme') ?>
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

                                    <p class="monto"><?php echo __('o agrega un monto', 'gen-base-theme') ?></p>
                                    <div class="form-group">
                                        <label for=""><?php echo __('Abonar más', 'gen-base-theme') ?></label>
                                        <input type="number" min="<?php echo membership()->get_minimun() ?>" name="amount" id="amount-subscription" placeholder="<?php echo __('Price', 'gen-base-theme') ?>" class="form-control" value="<?php echo membership()->get_minimun() ?>" />
                                    </div>
                                    <?php do_action('edit_form_extra') ?>
                                    <input type="hidden" name="payment_method_id" value="<?php echo membership()->get_membership(wp_get_current_user()->ID)['payment'] ?>">
                                    <input type="hidden" name="payment_min" id="payment_min_s" value="<?php echo membership()->get_minimun() ?>" />
                                    <input type="hidden" name="membership_id" value="<?php echo membership()->get_membership(wp_get_current_user()->ID)['id'] ?>" />
                                    <input type="hidden" name="user_id" value="<?php echo wp_get_current_user()->ID ?>">
                                    <input type="hidden" name="subscription_name" value="" id="subscription_name">
                                    <input type="hidden" name="action" value="edit_membership" />
                                    <input type="hidden" id="user_edit_email" name="user_edit_email" class="form-control" value="<?php echo wp_get_current_user()->user_email ?>" />
                                    <div id="msg-edit-mp"></div>
                                    <div class="btns-container" id="panel-mp-buttons">
                                        <button type="submit" name="send-edit-subscription" class="send-edit-subscription"><?php echo __('Editar', 'gen-base-theme') ?></button>
                                        <button type="button" id="cancel-edit-subscription" class="gray-btn-black-text ml-2"><?php echo __('Cancelar', 'gen-base-theme') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- edit form -->
                </div>
                <div class="benefits mw-md-60 mx-auto my-5">
                    <div class="title text-center">
                        <h4><?php echo __('Beneficios', 'gen-base-theme') ?></h4>
                    </div>
                    <div class="btns-container">
                        <button class="d-flex align-items-center mt-3"  id="historial-see">
                            <div class="benefit-icon mr-2">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/img/historial-icon.svg" alt="" class="img-fluid">
                            </div>
                            <div class="benefit-title">
                                <p><?php echo __('Ver tu Historial', 'gen-base-theme') ?> <span>(<?php echo count(beneficios_panel()->show_taken_beneficios(wp_get_current_user()->ID)) ?>)</span></p>
                            </div>
                        </button>
                        <button class="d-flex align-items-center mt-3" id="historial-see-2">
                            <div class="benefit-icon mr-2">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/img/benefits-icon.svg" alt="" class="img-fluid">
                            </div>
                            <div class="benefit-title">
                                <p><?php echo __('Ver todos tus beneficios', 'gen-base-theme') ?></p>
                            </div>
                        </button>
                    </div>
                </div>
                
                <!-- historial -->
                <div class="subs-block mt-4" id="historial-taken">
                    <div class="container">
                        <div class="title text-center">
                            <h4><?php echo __('Historial de beneficios', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="your-subscription">
                            <?php
                            $user_data = beneficios_panel()->show_taken_beneficios(wp_get_current_user()->ID);
                            $beneficios = [];
                            foreach ($user_data as $b) {
                                $beneficios[] = $b->{'id_beneficio'};
                            }
                            $args = [
                                'post_type' => 'beneficios',
                                'numberposts' => -1,
                                'include' => $beneficios

                            ];
                            $historial = get_posts($args);

                            foreach ($historial as $h) :
                            ?>
                                <div class="history-item my-3" id="history-<?php echo $h->{'ID'}?>">
                                    <div class="history-header d-flex justify-content-end align-items-start">
                                        <div class="close-btn delete-beneficio-user mt-1" data-id_beneficio="<?php echo $h->{'ID'}?>" data-user="<?php echo wp_get_current_user()->ID?>">
                                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/black-close.svg" alt="">
                                        </div>
                                    </div>
                                    <div class="history-body mt-2">
                                        <div class="title">
                                            <p><?php echo get_the_title($h->{'ID'}) ?></p>
                                        </div>
                                        <div class="description">
                                            <p><?php echo get_the_excerpt($h->{'ID'}) ?></p>
                                        </div>
                                        <div class="date">
                                            <small><?php echo get_the_date('d F Y', $h->{'ID'}) ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!--<div class="clearall mb-4">
                                <div class="btns-container text-center mt-4">
                                    <button><?php echo __('limpiar lista', 'gen-base-theme') ?></button>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <!-- historial -->


                <!-- historial todos-->
                <div class="subs-block mt-4" id="historial-all">
                    <div class="container">
                        <div class="title text-center">
                            <h4><?php echo __('Todos tus beneficios', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="your-subscription">
                            <?php
                            $user_data = beneficios_panel()->show_user_beneficios(wp_get_current_user()->ID);
                            $beneficios = [];
                            foreach ($user_data as $b) {
                                $beneficios[] = $b->{'id_beneficio'};
                            }
                            $args = [
                                'post_type' => 'beneficios',
                                'numberposts' => -1,
                                'include' => $beneficios

                            ];
                            $historial = get_posts($args);

                            foreach ($historial as $h) :
                            ?>
                                <div class="history-item my-3" id="history-<?php echo $h->{'ID'}?>">
                                    <div class="history-header d-flex justify-content-end align-items-start">
                                        <div class="close-btn delete-beneficio-user mt-1" data-id_beneficio="<?php echo $h->{'ID'}?>" data-user="<?php echo wp_get_current_user()->ID?>">
                                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/black-close.svg" alt="">
                                        </div>
                                    </div>
                                    <div class="history-body mt-2">
                                        <div class="title">
                                            <p><?php echo get_the_title($h->{'ID'}) ?></p>
                                        </div>
                                        <div class="description">
                                            <p><?php echo get_the_excerpt($h->{'ID'}) ?></p>
                                        </div>
                                        <div class="date">
                                            <small><?php echo get_the_date('d F Y', $h->{'ID'}) ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!--<div class="clearall mb-4">
                                <div class="btns-container text-center mt-4">
                                    <button><?php echo __('limpiar lista', 'gen-base-theme') ?></button>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <!-- historial -->
            </div>
        </div>
    <?php endif; ?>
</div>