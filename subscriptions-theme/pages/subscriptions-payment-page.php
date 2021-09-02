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
            <?php if(null !== Subscriptions_Sessions::get_session('flash_messages')): ?>
            <div class="row">
                <div class="col-7 mx-auto text-center alert alert-<?php echo Subscriptions_Sessions::get_session('flash_messages')['name']?>">
                    <?php echo __('Ocurrio un error con tu pago','gen-base-theme')?><br />
                    <i><?php echo Subscriptions_Sessions::get_session('flash_messages')['msg']?></i>
                </div>
            </div>
            <?php endif; ?>
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
                <?php
                if (Subscriptions_Sessions::get_session('subscriptions_add_session')['suscription_address'] === '1') :
                    $address = get_user_meta(get_current_user_id(), '_user_address', false);
                ?>
                    <!-- adreess -->
                    <div class="container-with-header">
                        <div class="py-2">
                            <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5" id="address-container">
                                <div class="asociate-wrapper">
                                    <div class="address-block">
                                        <div class="title text-center mt-4">
                                            <h6><?php echo __('Por favor, indicamos un domicilio donde se te enviará el diario.', 'subscriptions') ?></h6>
                                        </div>
                                        <div id="msg-ok"></div>
                                        <form method="post" id="address-form" class="text-left">
                                            <div class="form-container mt-4">
                                               <div class="input-container">
                                               <select name="state" id="state">
                                                    <option value=""> -- seleccionar -- </option>
                                                    <option value="CABA" <?php selected('CABA',$address[0]['state'])?>>CABA</option>
                                                    <option value="gba" <?php selected('gba',$address[0]['state'])?>>Gran Buenos Aires</option>
                                                    <option value="PBA" <?php selected('PBA',$address[0]['state'])?>>Provincia de Buenos Aires</option>
                                               </select>
                                                </div>
                                                <div class="input-container">
                                                <select name="city" id="city">
                                                    <option value=""> -- seleccionar --</option>
                                                </select>
                                                <input type="hidden" id="localidad" value="<?php echo $address[0]['city']?>">
                                                </div>
                                                <div class="input-container">
                                                    <input type="text" placeholder="<?php echo __('Calle', 'gen-base-theme') ?>" name="address" id="address" value="<?php echo $address[0]['address'] !== null ? $address[0]['address'] : ''; ?>" required />
                                                </div>
                                                <div class="d-flex">
                                                    <div class="input-container mr-3 w-100">
                                                        <input type="text" placeholder="<?php echo __('Número', 'gen-base-theme') ?>" name="number" id="number" value="<?php echo $address[0]['number'] !== null ? $address[0]['number'] : ''; ?>" required />
                                                    </div>
                                                    <div class="input-container w-100">
                                                        <input type="text" placeholder="<?php echo __('CP', 'gen-base-theme') ?>" name="zip" id="zip" value="<?php echo $address[0]['zip'] !== null ? $address[0]['zip'] : ''; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="input-container mr-3 w-100">
                                                        <input type="text" placeholder="<?php echo __('Piso', 'gen-base-theme') ?>" name="floor" id="floor" value="<?php echo $address[0]['floor'] !== null ? $address[0]['floor'] : ''; ?>"/>
                                                    </div>
                                                    <div class="input-container w-100">
                                                        <input type="text" placeholder="<?php echo __('Dpto', 'gen-base-theme') ?>" name="apt" id="apt" value="<?php echo $address[0]['apt'] !== null ? $address[0]['apt'] : ''; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="input-container">
                                                    <input type="text" placeholder="<?php echo __('Entre calles', 'gen-base-theme') ?>" name="bstreet" id="bstreet" value="<?php echo $address[0]['bstreet'] !== null ? $address[0]['bstreet'] : ''; ?>" />
                                                </div>
                                                <div class="input-container">
                                                    <textarea name="observations" placeholder="<?php echo __('Observaciones', 'gen-base-theme') ?>" class="form-control" id="observations" cols="30" rows="4"><?php echo $address[0]['observations'] !== null ? $address[0]['observations'] : ''; ?></textarea>
                                                </div>
                                                <div class="btns-container text-center mt-4">
                                                    <span class="d-none" id="loader-address">
                                                        <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/loader-button.gif" />
                                                        <span class="text-center d-block">Un momento por favor...</span>
                                                    </span>
                                                    <button type="button" name="address-button" id="address-button"><?php echo __('Confirmar', 'gen-base-theme') ?></button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="info text-center mt-5">
                                            <h6>
                                                <?php echo sprintf(__('La distribuidora necesita %s para asignar el envío del diario para que lo recibas en tu casa', 'gen-base-theme'), '<b>' . __('15 días', 'gen-base-theme') . '</b>') ?>
                                            </h6>
                                        </div>
                                        <div class="ayuda text-center my-4">
                                            <h6>Ante cualquier duda, podés escribirnos a</h6>
                                            <h6><a class="highlighted" href="mailto:pagostiempo@gmail.com">pagostiempo@gmail.com</a></h6>
                                            <h6> o <b>llamarnos
                                                    al <a href="tel:4342-5511">4342-5511</a>.</b>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="container-with-header" <?php echo Subscriptions_Sessions::get_session('subscriptions_add_session')['suscription_address'] === '1' ? 'style="display:none"' : '' ?> id="payment-container">
                    <div class="py-2">
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
                                    <h6><a class="highlighted" href="mailto:<?php echo get_option('subscriptions_email_sender'); ?>"><?php echo get_option('subscriptions_email_sender'); ?></a>
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