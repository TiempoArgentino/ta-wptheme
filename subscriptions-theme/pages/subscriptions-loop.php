<?php get_header() ?>


<div class="container ta-context asociate mt-2 my-lg-5" id="subscriptions-loop">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <?php if (subscriptions_proccess()->verify_subscription(wp_get_current_user()->ID)) : ?>           
            <div class="delivery-zones-popup">
                <div class="popup">
                    <div class="container text-center">
                        <div class="title mt-2">
                            <h4 class=italic><?php echo sprintf(__('Hola %s', 'gen-base-theme'), wp_get_current_user()->first_name) ?></h4>
                        </div>
                        <div class="popup-content">
                            <div class="aviso">
                                <p><?php echo sprintf(__('Ya cuentas con una %s', 'gen-base-theme'), '<b>' . __('suscripción') . '</b>') ?></p>
                            </div>
                            <div class="continue mt-3">
                                <p><?php echo __('Si deseás actualizarla, puedes hacerlo desde tu perfil de usuario', 'gen-base-theme') ?></p>
                                <div class="btns-container">
                                    <button><a href="<?php echo get_permalink(get_option('subscriptions_profile')) ?>">ir a mi perfil</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>

            <!-- loop container -->
            <div class="section-title p-2">
                <h4><?php echo __('asociate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('ELEGÍ TU PAQUETE', 'gen-base-theme') ?></span></h4>
            </div>

            <div class="container">
                <div class="container-with-header">
                    <div class="py-2">
                        <div class="subs-opt mt-3 mt-md-5">
                            <div class="title text-center">
                                <h4 class="italic"><?php echo is_user_logged_in() ? wp_get_current_user()->user_firstname : __('Hola, ', 'gen-base-theme') ?> <?php echo __('estas son las mejores opciones para asociarte', 'gen-base-theme') ?></h4>
                            </div>
                            <div class="opt-list mt-3">
                                <div class="d-flex flex-column flex-lg-row justify-content-center">
                                    <?php
                                    $args = array(
                                        'post_type' => 'subscriptions',
                                        'meta_query' => [
                                            'relation' => 'AND',
                                            [
                                                'relation' => 'OR',
                                                [
                                                    'key' => '_is_donation',
                                                    'compare' => 'NOT EXISTS'
                                                ],
                                                [
                                                    'key' => '_is_donation',
                                                    'value' => ['1'],
                                                    'compare' => 'NOT IN'
                                                ],
                                            ],
                                            [
                                                'relation' => 'OR',
                                                [
                                                    'key' => '_is_special',
                                                    'compare' => 'NOT EXISTS'
                                                ],
                                                [
                                                    'key' => '_is_special',
                                                    'value' => ['1'],
                                                    'compare' => 'NOT IN'
                                                ],
                                            ]
                                            
                                        ]
                                    );
                                    $query = new WP_Query($args);

                                    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();


                                            $price_main = get_post_meta(get_the_ID(), '_s_price', true);
                                            $prices_extra = get_post_meta(get_the_ID(), '_prices_extra', true);
                                            if ($prices_extra) {
                                                array_push($prices_extra, $price_main);
                                            }
                                            $price_min = !$prices_extra ? $price_main : min($prices_extra);
                                            $paper = get_post_meta($post->ID, '_physical', true);

                                    ?>
                                            <div class="col-12 col-lg-6 p-0 pr-lg-3 item-subscription">
                                                <div class="opt digital py-3">
                                                    <div class="container">
                                                        <div class="icon d-flex justify-content-center">
                                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>" alt="<?php echo get_the_title(get_the_ID()) ?>">
                                                        </div>
                                                        <div class="content">
                                                            <div class="container p-0">
                                                                <div class="description text-center">
                                                                    <h4 class="m-0"><?php echo get_the_title(get_the_ID()) ?></h4>
                                                                    <p><?php echo __('Elegí el monto de tu abono mensual', 'gen-base-theme') ?></p>
                                                                </div>
                                                                <div class="amounts d-flex flex-wrap">
                                                                    <div class="col-6 col-lg-4 p-1">
                                                                        <div class="amount">
                                                                            <button class="price" data-id="<?php echo get_the_ID() ?>" data-price="<?php echo get_post_meta(get_the_ID(), '_s_price', true) ?>">
                                                                                <p><?php echo get_option('subscriptions_currency_symbol', 'ARS') . ' ' . get_post_meta(get_the_ID(), '_s_price', true) ?></p>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    if (get_post_meta(get_the_ID(), '_prices_extra', true) && count(get_post_meta(get_the_ID(), '_prices_extra', true)) > 0) {
                                                                        foreach (get_post_meta(get_the_ID(), '_prices_extra', true) as $key => $value) {
                                                                            echo '<div class="col-6 col-lg-4 p-1">
                                                                                <div class="amount">
                                                                                    <button class="price" data-id="' . get_the_ID() . '" data-price="' . $value . '">
                                                                                        <p>' . get_option('subscriptions_currency_symbol', 'ARS') . ' ' . $value . '</p>
                                                                                    </button>
                                                                                </div>
                                                                            </div>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if (get_post_meta(get_the_ID(), '_price_custom', true)) {
                                                                        echo ' <div class="col-6 col-lg-12 p-1">
                                                                        <div class="amount other price-custom">
                                                                            <button class="custom-price-button open-price" data-address="'. get_post_meta(get_the_ID(),'_physical',true).'" data-id="' . get_the_ID() . '" data-min="' . $price_min . '" data-title="' . get_the_title() . '">
                                                                                <p>' . __('abonar más', 'gen-base-theme') . '</p>
                                                                            </button>
                                                                        </div>
                                                                    </div>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="btns-container">
                                                                    <div class="d-flex justify-content-center mx-auto uppercase mt-3">
                                                                        <button class="continue-btn yellow-btn-yellow-text button-suscribe-1" data-type="subscription" id="button<?php echo get_the_ID() ?>" data-address="<?php echo get_post_meta(get_the_ID(),'_physical',true)?>" disabled data-id="<?php echo get_the_ID() ?>" data-price="" data-name="<?php echo get_the_title() ?>" data-paper="<?php echo $paper === '1' ? 1 : 0 ?>"><?php echo __('continuar', 'gen-base-theme') ?></button>
                                                                    </div>
                                                                </div>
                                                                <div class="opt-details mt-3">
                                                                    <button type="button" class="toggle" data-toggle="collapse" data-target="#benefitsDigital-<?php echo get_the_ID() ?>" aria-expanded="false" aria-controls="benefitsDigital">
                                                                        <div class="d-flex">
                                                                            <div class="dropdown-icon mr-2">
                                                                                <img src="<?php echo get_template_directory_uri() ?>/assets/img/arrow.svg" alt="" />
                                                                            </div>
                                                                            <div>
                                                                                <p><?php echo __('¿Qué trae este paquete?', 'gen-base-theme') ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                    <div class="collapse subscription-content" id="benefitsDigital-<?php echo get_the_ID() ?>">
                                                                        <div class="card-body">
                                                                            <?php echo get_the_content(get_the_ID()) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endwhile;
                                        wp_reset_postdata();
                                        ?>
                                </div>
                                <?php endif; ?>
                                <?php
                                     $args = array(
                                        'post_type' => 'subscriptions',
                                        'meta_query' => [
                                            'relation' => 'AND',
                                            [
                                                'relation' => 'OR',
                                                [
                                                    'key' => '_is_donation',
                                                    'compare' => 'NOT EXISTS'
                                                ],
                                                [
                                                    'key' => '_is_donation',
                                                    'value' => ['1'],
                                                    'compare' => 'NOT IN'
                                                ],
                                            ],
                                            [
                                                'relation' => 'AND',
                                                [
                                                    'key' => '_is_special',
                                                    'compare' => 'EXISTS'
                                                ],
                                                [
                                                    'key' => '_is_special',
                                                    'value' => ['1'],
                                                    'compare' => 'IN'
                                                ],
                                            ]
                                            
                                        ]
                                    );
                                    $query = new WP_Query($args);
                                    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                                ?>
                                <div class="opt papel py-3 py-lg-4">
                                    <div class="container">
                                        <div class="content">
                                            <div class="container d-lg-flex justify-content-center align-items-center p-0">
                                                <div class="description text-center mt-2 mt-lg-0">
                                                    <div class="d-flex justify-content-center mr-lg-3">
                                                        <div class="paper-icon mr-2">
                                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>" alt="">
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="m-0"><?php echo get_the_title( get_the_ID() ) ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btns-container">
                                                <?php
                                                        $price_main = get_post_meta(get_the_ID(), '_s_price', true);
                                                        $paper = get_post_meta($post->ID, '_physical', true);
                                                ?>
                                                    <div class=" d-flex justify-content-center mx-auto uppercase mt-3 mt-lg-0">
                                                        <button class="yellow-btn-white-text button-suscribe-1" data-type="subscription" id="button<?php echo get_the_ID() ?>" data-id="<?php echo get_the_ID() ?>" data-address="<?php echo get_post_meta(get_the_ID(),'_physical',true)?>" data-price="<?php echo $price_main ?>" data-name="<?php echo get_the_title() ?>" data-paper="<?php echo $paper === '1' ? 1 : 0 ?>"><?php echo __('elegir y continuar', 'gen-base-theme') ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php   
                            endwhile;
                            wp_reset_postdata(); 
                            endif;
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- loop container -->
    </div>
</div>
<!-- custom price -->
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="custom-price-row">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container pb-md-5">
        <div class="section-title p-2">
            <h4><?php echo __('asociate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('OTRO IMPORTE', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4><?php echo __('¿Con qué importe deseás asociarte?', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="your-amount-block">
                                <div class="title text-center mt-4">
                                    <h6><?php echo __('Ingresá acá el importe que desees:', 'gen-base-theme') ?></h6>
                                </div>
                                <div class="your-amount-input-container d-flex align-items-center justify-content-center mt-3">
                                    <p>$</p>
                                    <input type="number" id="custom-price-input">
                                </div>
                                <div id="minimum"></div>
                                <div class="btns-container text-center mt-5">
                                    <button class="yellow-btn-white-text" id="custom-next-2" data-paper="<?php echo $paper === '1' ? 1 : 0 ?>" data-type="subscription"><?php echo __('SIGUIENTE', 'gen-base-theme') ?></button>
                                </div>
                            </div>
                            <div class="info text-md-center mt-5">
                                <h6><?php echo sprintf(__('Recordá que el valor %s', 'gen-base-theme'), '<b>' . __('mínimo es', 'gen-base-theme') . ' <span id="minimo"></span></b>') ?> </h6>
                                <h6 class="mt-2"><?php echo sprintf(__('Podés %s', 'gen-base-theme'), '<b>' . __('suspender tu abono', 'gen-base-theme') . '</b> ' . __('cuando quieras desde tu perfil de usuario', 'gen-base-theme')) ?></h6>
                            </div>
                            <div class="ayuda text-md-center mb-4 mt-5">
                                <h6><?php echo __('Si necesitás ayuda escribinos a', 'gen-base-theme') ?>
                                </h6>
                                <h6><a class="highlighted" href="mailto:<?php echo get_option('subscriptions_email_sender'); ?>"><?php echo get_option('subscriptions_email_sender'); ?></a>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- custom price -->
<!-- paquete elegido -->
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="paquete-elegido">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('asociate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('Tu paquete', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4 class="italic"><?php echo __('Elegiste el paquete', 'gen-base-theme') ?></h4>
                            <h4 class="pack-name" id="pack-name"></h4>
                            <h4 class="italic"><?php echo __('por un abono mensual de:', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="chosen-amount-block">
                                <div class="chosen-amount-container mt-3">
                                    <p>$ <span id="price-paquete"></span></p>
                                </div>
                                <div class="checkbox-container text-center mt-3" id="paper-option">
                                <?php
                                     $args = array(
                                        'post_type' => 'subscriptions',
                                        'meta_query' => [
                                            'relation' => 'AND',
                                            [
                                                'relation' => 'OR',
                                                [
                                                    'key' => '_is_donation',
                                                    'compare' => 'NOT EXISTS'
                                                ],
                                                [
                                                    'key' => '_is_donation',
                                                    'value' => ['1'],
                                                    'compare' => 'NOT IN'
                                                ],
                                            ],
                                            [
                                                'relation' => 'AND',
                                                [
                                                    'key' => '_is_special',
                                                    'compare' => 'EXISTS'
                                                ],
                                                [
                                                    'key' => '_is_special',
                                                    'value' => ['1'],
                                                    'compare' => 'IN'
                                                ],
                                            ]
                                            
                                        ]
                                    );
                                    $query = new WP_Query($args);
                                    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                                ?>
                                    <input type="checkbox" class="paper-checkbox" value="<?php echo get_post_meta(get_the_ID(), '_s_price', true)?>" id="add-paper" name="addpaper">
                                    <label for="add-paper"><?php echo __('Agregá el diario en papel por', 'gen-base-theme') ?> <b>$<span id="price-papper"><?php echo get_post_meta(get_the_ID(), '_s_price', true)?></span></b></label>
                                    <?php   
                                        endwhile;
                                        wp_reset_postdata(); 
                                        endif;
                                     ?>
                                </div>
                            </div>
                            <div class="sign-up-sign-in text-center mt-4">
                                <?php if (is_user_logged_in()) : ?>
                                    <div id="user-logged-in">
                                        <div class="btns-container text-center">
                                            <button id="payment-continue"><a href="<?php echo get_permalink(get_option('subscriptions_payment_page')) ?>"><?php echo __('CONTINUAR AL PAGO', 'gen-base-theme') ?></a></button>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="create-account">
                                        <div class="title">
                                            <p><?php echo sprintf(__('%s para terminar de asociarte a Tiempo Argentino', 'gen-base-theme'), '<b>' . __('Creá tu cuenta', 'gen-base-theme') . '</b>') ?></p>
                                        </div>
                                        <div class="btns-container text-center">
                                            <button type="button" id="register-button"><?php echo __('CREAR CUENTA', 'gen-base-theme') ?></button>
                                        </div>
                                    </div>
                                    <div class="login mt-4">
                                        <div>
                                            <p><?php echo __('¿Ya tenés cuenta?', 'gen-base-theme') ?></p>
                                        </div>
                                        <div class="btns-container text-center" id="login-button">
                                            <button class="login-btn gray-btn-black-text"><?php echo __('INGRESA', 'gen-base-theme') ?></button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="info text-center mt-5">
                                <h6 class="mt-2"><?php echo sprintf(__('Podés %s %s', 'gen-base-theme'), '<b>' . __('suspender tu abono', 'gen-base-theme') . '</b>', __('cuando quieras desde tu perfil de usuario', 'gen-base-theme')) ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- login-->
<?php if (!is_user_logged_in()) : ?>
    <div class="container ta-context asociate gray-border mt-2 my-lg-5" id="login-form">
        <div class="line-height-0">
            <div class="separator m-0"></div>
        </div>
        <div class="asociate-block-container">
            <div class="section-title p-2">
                <h4><?php echo __('asociate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('Ingresar', 'gen-base-theme') ?></span></h4>
            </div>
            <div class="container">
                <div class="container-with-header">
                    <div class="py-2">
                        <div class="subs-opt mt-3 mt-md-5">
                            <div class="asociate-wrapper">
                                <div class="img-container text-center">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/login.svg" alt="" class="img-fluid">
                                </div>
                                <div class="login-block">
                                    <div class="form-container mt-4">
                                        <div id="message-login-response"></div>
                                        <form method="post" class="mb-5 login-form-loop">
                                            <div class="input-container">
                                                <input type="email" placeholder="Email" autocomplete="off" name="username" id="username" required>
                                                <div class="username_error text-center alert alert-danger"></div>
                                            </div>
                                            <div class="input-container">
                                                <input type="password" placeholder="Contraseña" name="password" id="password" required>
                                                <div class="pass_error text-center alert alert-danger"></div>
                                            </div>
                                            <input type="hidden" name="redirect_to" id="redirect_to" value="<?php echo get_permalink(get_option('subscriptions_payment_page')); ?>">
                                            <div class="btns-container text-center mt-4">
                                                <button class="yellow-btn-white-text" name="send-login" type="button" id="send-login"><?php echo __('Ingresar', 'gen-base-theme') ?></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="login-opt-container d-flex flex-column flex-lg-row justify-content-lg-around mt-3 mt-lg-5">
                                        <div class="reset-password mt-4">
                                            <div class="text-center">
                                                <p><?php echo __('¿Olvidaste tu contraseña?', 'gen-base-theme') ?></p>
                                            </div>
                                            <div class="btns-container text-center">
                                                <button class="gray-btn-black-text"><a href="<?php echo get_permalink(get_option('subscriptions_lost_password_page')) ?>"><?php echo __('RECUPERAR', 'gen-base-theme') ?></a></button>
                                            </div>
                                        </div>
                                        <div class="sign-in mt-4">
                                            <div class="text-center">
                                                <p><?php echo __('¿No tenés cuenta?', 'gen-base-theme') ?></p>
                                            </div>
                                            <div class="btns-container text-center">
                                                <button class="gray-btn-black-text" type="button" id="register-button"><?php echo __('CREAR CUENTA', 'gen-base-theme') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- register -->
    <?php if (get_option('users_can_register') !== '0') : ?>
        <div class="container ta-context asociate gray-border mt-2 my-lg-5" id="register-form">
            <div class="line-height-0">
                <div class="separator m-0"></div>
            </div>
            <div class="asociate-block-container">
                <div class="section-title p-2">
                    <h4><?php echo __('asociate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('Registrarse', 'gen-base-theme') ?></span></h4>
                </div>
                <div class="container">
                    <div class="container-with-header">
                        <div class="py-2">
                            <div class="subs-opt mt-3 mt-md-5">
                                <div class="asociate-wrapper">
                                    <div class="address-block">
                                        <div id="message-register-response" style="display:none"></div>
                                        <form method="post" class="register-form-loop">
                                            <div class="form-container mt-4">
                                                <div class="input-container">
                                                    <input type="text" placeholder="Nombre" name="first_name" id="first_name" required>
                                                    <div class="first_name_error text-center alert alert-danger"></div>
                                                </div>
                                                <div class="input-container">
                                                    <input type="text" placeholder="Apellido" name="last_name" id="last_name" required>
                                                    <div class="last_name_error text-center alert alert-danger"></div>
                                                </div>
                                                <div class="input-container">
                                                    <input type="email" placeholder="Email" autocomplete="off" name="email" id="email" required>
                                                    <div class="email_error text-center alert alert-danger"></div>
                                                </div>
                                                <div class="input-container">
                                                    <input type="password" placeholder="Contraseña" name="password" id="passwd" required>
                                                    <div class="password_error text-center alert alert-danger"></div>
                                                </div>
                                                <div class="input-container">
                                                    <input type="password" placeholder="Verificar Contraseña" name="password2" id="passwd2" required>
                                                    <div class="password2_error text-center alert alert-danger"></div>
                                                </div>
                                                <input type="hidden" name="register_redirect" id="register_redirect" value="<?php echo get_permalink(get_option('subscriptions_payment_page')); ?>">
                                                <div class="btns-container text-center mt-4">
                                                    <button class="yellow-btn-white-text" type="button" name="submit-register" id="submit-register"><?php echo __('REGISTRARSE', 'gen-base-theme') ?></button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="info text-center mt-5">
                                            <h6><?php echo sprintf(__('Al hacer click en registrarse, estás aceptando nuestros %s', 'gen-base-theme'), '<a href="' . get_permalink(get_option('subscriptions_terms_page')) . '" class="highlighted">' . __('términos y condiciones', 'gen-base-theme') . '</a>') ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>


<?php endif; ?>
<!-- errors -->

<div class="popup-container" id="continuarErrorPopup">
    <div class="continuar-error-popup">
        <div class="popup">
            <div class="container text-center">
                <div class="close-cross text-right close-popup">
                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/grey-close.svg" alt="">
                </div>
                <div class="aviso mt-2">
                    <p>Debes <b>elegir un abono mensual</b> para continuar.</p>
                </div>
                <div class="ayuda mt-4">
                    <h6>Si deseás obtener ayuda con el proceso de asociación, podés escribir un mail a <a href="mailto:suscripciones@tiempoargentino.com.ar">suscripciones@tiempoargentino.com.ar</a>
                    </h6>
                </div>
                <div class="btns-container">
                    <button class="close-popup darkgray-btn-black-text">cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- diario impreso info -->

<div class="popup-container" id="warningDeliveryZones">
    <div class="delivery-zones-popup">
        <div class="popup">
            <div class="container text-center">
                <div class="close-cross text-right close-popup">
                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/grey-close.svg" alt="">
                </div>
                <div class="title mt-2">
                    <h4 class=italic>Diario Impreso</h4>
                    <h4>Información importante:</h4>
                </div>
                <div class="popup-content">
                    <div class="aviso">
                        <p>Por el momento, el diario impreso se distribuye solo en la <b>ciudad de Buenos Aires, Gran
                                Buenos Aires</b> y <b>La Plata</b>.</p>
                    </div>
                    <div class="continue mt-3">
                        <p>¿Vivís en estas zonas?</p>
                        <div class="btns-container">
                            <button>continuar</button>
                        </div>
                    </div>
                    <div class="close-popup mt-3">
                        <p>Si no vivís en estas zonas, te recomendamos ser Socio DIGITAL</p>
                        <div class="btns-container close-btn">
                            <button>cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>