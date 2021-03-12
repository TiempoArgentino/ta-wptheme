<?php get_header() ?>


<div class="container ta-context asociate mt-2 my-lg-5" id="subscriptions-loop">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('asociate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('ELEGÍ TU PAQUETE', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4 class="italic"><?php echo is_user_logged_in() ? wp_get_current_user()->user_firstname : __('Hola, ','gen-base-theme')?> <?php echo __('estas son las mejores opciones para asociarte', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="opt-list mt-3">
                            <div class="d-flex flex-column flex-lg-row justify-content-center">
                                <?php
                                $args = array(
                                    'post_type' => 'subscriptions',
                                    'meta_query' => [
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
                                                                            <button class="custom-price-button open-price" data-id="' . get_the_ID() . '" data-min="' . $price_min . '" data-title="' . get_the_title() . '">
                                                                                <p>' . __('abonar más', 'gen-base-theme') . '</p>
                                                                            </button>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="btns-container">
                                                                <div class="d-flex justify-content-center mx-auto uppercase mt-3">
                                                                    <button class="continue-btn yellow-btn-yellow-text button-suscribe" data-type="subscription" id="button<?php echo get_the_ID() ?>" disabled data-id="<?php echo get_the_ID() ?>" data-price="" data-name="<?php echo get_the_title() ?>"><?php echo __('continuar', 'gen-base-theme') ?></button>
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
                            <div class="opt papel py-3 py-lg-4">
                                <div class="container">
                                    <div class="content">
                                        <div class="container d-lg-flex justify-content-center align-items-center p-0">
                                            <div class="description text-center mt-2 mt-lg-0">
                                                <div class="d-flex justify-content-center mr-lg-3">
                                                    <div class="paper-icon mr-2">
                                                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/paper-icon.svg" alt="">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <h4 class="m-0"><?php echo __('Solo Edición Impresa', 'gen-base-theme') ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btns-container">
                                                <div class=" d-flex justify-content-center mx-auto uppercase mt-3 mt-lg-0">
                                                    <button class="yellow-btn-white-text button-suscribe"><?php echo __('elegir y continuar', 'gen-base-theme') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                            <h4><?php echo __('¿Con qué importe deseas asociarte?', 'gen-base-theme') ?></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="your-amount-block">
                                <div class="title text-center mt-4">
                                    <h6><?php echo __('Ingresá acá el importe que desees:', 'gen-base-theme') ?></h6>
                                </div>
                                <div
                                    class="your-amount-input-container d-flex align-items-center justify-content-center mt-3">
                                    <p>$</p>
                                    <input type="number" id="custom-price-input">
                                </div>
                                <div id="minimum"></div>
                                <div class="btns-container text-center mt-5">
                                    <button class="yellow-btn-white-text" id="custom-next-2" data-type="subscription"><?php echo __('SIGUIENTE', 'gen-base-theme') ?></button>
                                </div>
                            </div>
                            <div class="info text-md-center mt-5">
                                <h6><?php echo sprintf( __('Recordá que el valor %s', 'gen-base-theme'),'<b>'.__('mínimo es', 'gen-base-theme').' <span id="minimo"></span></b>') ?> </h6>
                                <h6 class="mt-2"><?php echo sprintf(__('Podrás %s', 'gen-base-theme'),'<b>'.__('suspender tu abono', 'gen-base-theme').'</b> '.__('cuando quieras desde tu perfil de usuario', 'gen-base-theme'))?></h6>
                            </div>
                            <div class="ayuda text-md-center mb-4 mt-5">
                                <h6><?php echo __('Si deseas obtener ayuda con el proceso de asociación, podés escribir un mail a', 'gen-base-theme') ?>
                                </h6>
                                <h6><a class="highlighted"
                                        href="mailto:suscripciones@tiempoargentino.com.ar">suscripciones@tiempoargentino.com.ar</a>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <h6>Si deseas obtener ayuda con el proceso de asociación, podés escribir un mail a <a
                            href="mailto:suscripciones@tiempoargentino.com.ar">suscripciones@tiempoargentino.com.ar</a>
                    </h6>
                </div>
                <div class="btns-container">
                    <button class="close-popup darkgray-btn-black-text">cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>