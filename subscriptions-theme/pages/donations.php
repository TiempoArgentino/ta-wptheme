<?php get_header() ?>


<div class="container ta-context asociate mt-2 my-lg-5" id="subscriptions-loop">
    <div class="line-height-0 donation-container">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container donation-container">
        <!-- loop container -->
        <div class="section-title p-2">
            <h4><?php echo __('apoyanos', 'gen-base-theme') ?><span class="ml-2"><?php echo __('ELEGÍ TU APORTE', 'gen-base-theme') ?></span></h4>
        </div>

        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="title text-center donation-section-title">
                            <h4 class="italic"><?php echo __('Tu aporte nos hace posible llevar adelante nuestra labor periodística', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="text-center subtitle-donations mt-5">
                            <strong>Selecciona el importe con que deseás colaborar</strong>
                        </div>
                        <div class="opt-list">
                            <div class="d-flex flex-column flex-lg-row justify-content-center">
                                <?php
                                $args = array(
                                    'post_type' => 'subscriptions',
                                    'meta_query' => [
                                        'relation' => 'AND',
                                        [
                                            'key' => '_is_donation',
                                            'compare' => 'EXISTS'
                                        ],
                                        [
                                            'key' => '_is_donation',
                                            'value' => ['1'],
                                            'compare' => 'IN'
                                        ],
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
                                        <div class="col-12 col-lg-6 p-0 pr-lg-3 item-subscription item-donation">
                                            <div class="opt digital py-3">
                                                <div class="container">
                                                    <div class="content">
                                                        <div class="container p-0">
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
                                                                            <button class="custom-price-button open-price" data-id="' . get_the_ID() . '" data-min="' . $price_min . '" data-title="' . get_the_title() . '">
                                                                                <p>' . __('aportar más', 'gen-base-theme') . '</p>
                                                                            </button>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="btns-container">
                                                                <div class="d-flex justify-content-center mx-auto uppercase mt-3">
                                                                    <button class="continue-btn yellow-btn-yellow-text button-suscribe-1" data-type="donation" id="button<?php echo get_the_ID() ?>" disabled data-id="<?php echo get_the_ID() ?>" data-price="" data-name="<?php echo get_the_title() ?>" data-paper="<?php echo $paper === '1' ? 1 : 0 ?>"><?php echo __('continuar', 'gen-base-theme') ?></button>
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
                            <div class="row flex-column pb-5">
                                <div class="col-md-7 mx-auto col-12 donation-footer text-center mt-5 ">
                                    <?php echo sprintf(__('Para recibir ayuda con el proceso de tu colaboración podés escribir un mail a %s', 'gen-base-theme'), '<a href="mailto:' . get_option('subscriptions_email_sender') . '" class="notif-link">' . get_option('subscriptions_email_sender') . '</a>') ?>
                                </div>
                                <div class="col-md-7 mx-auto col-12 donation-footer text-center mt-5">
                                    <?php echo __('Si sos jubilado, estudiante o podés colaborar con un importe menor', 'gen-base-theme') ?>
                                    <div class="btns-container text-center mt-3">
                                        <button type="button" class="login-btn gray-btn-black-text" id="discount-button"><?php echo __('INGRESA ACÁ', 'gen-base-theme') ?></button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- loop container -->
    </div>
    <!-- discounts -->
    <div class="container ta-context apoyanos gray-border mt-2 my-lg-5" id="discount-data">
        <div class="line-height-0">
            <div class="separator m-0"></div>
        </div>
        <div class="apoyanos-block-container">
            <div class="section-title p-2">
                <h4>apoyanos<span class="ml-2">SOLICITAR UN DESCUENTO</span></h4>
            </div>
            <div class="container">
                <div class="container-with-header">
                    <div class="py-2">
                    <?php
                                $args = array(
                                    'post_type' => 'subscriptions',
                                    'meta_query' => [
                                        'relation' => 'AND',
                                        [
                                            'key' => '_is_donation',
                                            'compare' => 'EXISTS'
                                        ],
                                        [
                                            'key' => '_is_donation',
                                            'value' => ['1'],
                                            'compare' => 'IN'
                                        ],
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
                        <div class="subs-opt mt-3 mt-md-5">
                            <div class="title text-center">
                                <h4 class="italic m-0">Desde Tiempo Argentino queremos ofrecerte la </h4>
                                <h4 class="italic m-0">posibilidad de apoyar
                                    nuestro medio ofreciendote un </h4>
                                <h4 class="italic m-0"><span><?php echo get_post_meta(get_the_ID(),'_discount',true)?>% de descuento</span> en tu aporte</h4>
                            </div>
                      
                            <div class="apoyanos-wrapper">
                            <?php $new_price = ($price_min * 20) / 100;?>
                                <div class="discount  text-center mt-5">
                                    <div class="wout-discount-price">
                                        <p>ANTES: <?php echo get_option('subscriptions_currency_symbol', 'ARS')?> <?php echo $price_min?></p>
                                    </div>
                                    <div class="discount-price mx-auto">
                                        <h4>AHORA: <?php echo get_option('subscriptions_currency_symbol', 'ARS')?> <?php echo $new_price?></h4>
                                    </div>
                                </div>
                                <div class="btns-container text-center mt-4">
                                <input type="hidden" id="new_price" data-type="donation" data-name="<?php echo get_the_title() ?>" data-id="<?php echo get_the_ID() ?>" value="<?php echo $new_price?>" />
                                    <button type="button" data-payment_page="<?php echo get_permalink(get_option('subscriptions_payment_page')); ?>" id="next-discount">Siguiente</button>
                                </div>
                                <?php
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                 <?php endif; ?>
                                <div class="text-center mt-5 ">
                                    <p>Si necesitás un descuento mayor</p>
                                </div>
                                <div class="btns-container text-center mb-5">
                                    <button class="gray-btn-black-text" id="next-contact">INGRESÁ ACÁ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- discounts -->
    <!-- form -->
    <div class="container ta-context apoyanos gray-border mt-2 my-lg-5" id="contact-form">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="apoyanos-block-container">
        <div class="section-title p-2">
            <h4>apoyanos<span class="ml-2">SOLICITAR UN DESCUENTO</span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5">
                        <div class="apoyanos-wrapper">
                            <div class="address-block">
                                <div class="title text-center mt-4">
                                    <p><b>Deseamos conocer tu situación:</b>
                                    </p>
                                </div>
                                <div class="subtitle text-center mt-4">
                                    <p class="m-0">Indicanos tu nombre, tu e-mail y por qué
                                    </p>
                                    <p>considerás que necesitás este descuento:</p>
                                </div>
                                <div class="form-container mt-4">
                                    <div class="input-container">
                                        <input type="text" placeholder="Nombre y Apellido" required name="name" id="name_support_us">
                                    </div>
                                    <div class="input-container">
                                        <input type="email" placeholder="Email" required name="email" id="email_support_us">
                                    </div>
                                    <div class="input-container text-center">
                                        <label for="message">Escribinos un mensaje:</label>
                                        <textarea rows="8" required name="msg" id="msg_support_us"></textarea>
                                    </div>

                                    <div class="btns-container text-center my-4">
                                        <button type="button" id="send-contact">enviar</button>
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
    <!-- form -->
    <!-- gracias --> 
    <div class="container ta-context asociate gray-border mt-2 my-lg-5" id="contact-thankyou">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4>apoyanos<span class="ml-2">SOLICITAR UN DESCUENTO</span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4 class="italic m-0">Gracias <span id="name-thanks"></span></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="subtitle text-center mt-4">
                                <p>Muy pronto alguien de Tiempo Argentino te
                                </p>
                                <p>escribirá por e-mail. Mientras tanto podés </p>
                                <p>seguir leyendo nuestro sitio.</p>
                            </div>
                            <div class="title text-center mt-5">
                                <p><b>¿Querés contarnos un poco más de vos?</b></p>
                            </div>
                            <div class="text-center">
                                <p>De esta forma podremos ofrecerte contenidos de acuerdo a tus preferencias</p>
                            </div>
                            <div class="btns-container text-center">
                                <button>Personalizar</button>
                            </div>
                            <div class="text-center mt-4">
                                <p>o podés seguir navegando nuestro sitio y personalizar en otro momento</p>
                            </div>
                            <div class="btns-container text-center">
                                <button class="gray-btn-black-text">ir al sitio</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- gracias --> 
</div>
<!-- custom price -->
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="custom-price-row">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container pb-md-5">
        <div class="section-title p-2">
            <h4><?php echo __('apoyanos', 'gen-base-theme') ?><span class="ml-2"><?php echo __('OTRO IMPORTE', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4><?php echo __('¿Con qué importe deseás colaborar?', 'gen-base-theme') ?></h4>
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
                                    <button class="yellow-btn-white-text" id="custom-next-2" data-paper="<?php echo $paper === '1' ? 1 : 0 ?>" data-type="donation"><?php echo __('SIGUIENTE', 'gen-base-theme') ?></button>
                                </div>
                            </div>
                            <div class="info text-md-center mt-5">
                                <h6><?php echo sprintf(__('Recordá que el valor %s', 'gen-base-theme'), '<b>' . __('mínimo es', 'gen-base-theme') . ' <span id="minimo"></span></b>') ?> </h6>
                            </div>
                            <div class="ayuda text-md-center mb-4 mt-5">
                                <h6><?php echo __('Si deseás obtener ayuda con el proceso de tu colaboración, podés escribir un mail a', 'gen-base-theme') ?>
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
            <h4><?php echo __('apoyanos', 'gen-base-theme') ?><span class="ml-2"><?php echo __('Tu colaboración', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4 class="italic"><?php echo __('Elegiste colaborar con:', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="chosen-amount-block">
                                <div class="chosen-amount-container mt-3">
                                    <p>$ <span id="price-paquete"></span></p>
                                </div>
                            </div>
                            <div class="sign-up-sign-in text-center mt-4">
                                <?php if (is_user_logged_in()) : ?>
                                    <div id="user-logged-in">
                                        <div class="btns-container text-center">
                                            <button><a href="<?php echo get_permalink(get_option('subscriptions_payment_page')) ?>"><?php echo __('CONTINUAR AL PAGO', 'gen-base-theme') ?></a></button>
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
                                <h6 class="mt-2"><?php echo sprintf(__('Podrás %s %s', 'gen-base-theme'), '<b>' . __('suspender tu abono', 'gen-base-theme') . '</b>', __('cuando quieras desde tu perfil de usuario', 'gen-base-theme')) ?></h6>
                            </div>
                            <div class="ayuda text-md-center mb-4 mt-5">
                                <h6><?php echo __('Si deseás obtener ayuda con el proceso de tu colaboración, podés escribir un mail a', 'gen-base-theme') ?>
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
                                        <div id="message-register-response"></div>
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



<?php get_footer(); ?>