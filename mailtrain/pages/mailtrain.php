<?php get_header() ?>
<div class="container ta-context asociate gray-border mt-2 my-lg-5">

    <?php do_action('before_lists_page') ?>
    <?php do_action('before_lists_form') ?>
    <div id="msg-ok"></div>
    <?php if (!is_user_logged_in()) : ?>
        <form method="post" id="mailtrain">
            <div class="line-height-0" id="separator-1">
                <div class="separator m-0"></div>
            </div>
            <div class="asociate-block-container" id="user-data">
                <div class="section-title p-2">
                    <h4><?php echo __('informate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('inicio', 'gen-base-theme') ?></span></h4>
                </div>
                <div class="container">
                    <div class="container-with-header">
                        <div class="py-2">
                            <div class="subs-opt mt-3 mt-md-5">
                                <div class="asociate-wrapper">
                                    <div class="title text-center">
                                        <h4 class="italic"><?php echo __('Recibí actualizaciones con la mirada de Tiempo.', 'gen-base-theme') ?></h4>
                                    </div>
                                    <div class="subtitle text-center mt-4">
                                        <p><?php echo __('Deseamos conocerte, indicanos tu nombre y tu e-mail:', 'gen-base-theme') ?></p>
                                    </div>
                                    <div class="form-container mt-4">
                                        <div class="input-container">
                                            <input type="text" name="mailtrain_name" id="mailtrain_name" placeholder="<?php echo __('Nombre', 'gen-base-theme') ?>">
                                        </div>
                                        <div class="input-container">
                                            <input type="text" name="mailtrain_email" id="mailtrain_email" placeholder="<?php echo __('Email', 'gen-base-theme') ?>">
                                        </div>
                                        <div class="btns-container text-center mt-4">
                                            <button class="yellow-btn-white-text" type="button" id="mailtrain-next-1"><?php echo __('Siguiente', 'gen-base-theme') ?></button>
                                        </div>
                                    </div>
                                    <div class="info text-center mt-5 d-none">
                                        <p> Podrás editar tus preferencias, desde tu panel de usuario, cuando quieras.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <input type="hidden" name="mailtrain_name" id="mailtrain_name" value="<?php echo wp_get_current_user()->user_firstname . ' ' . wp_get_current_user()->user_lastname; ?>" />
            <input type="hidden" name="mailtrain_email" id="mailtrain_email" value="<?php echo wp_get_current_user()->user_email ?>" />
            <input type="hidden" name="mailtrain_user_id" id="mailtrain_user_id" value="<?php echo wp_get_current_user()->ID ?>" />
        <?php endif; ?>
</div>
<!-- listas -->
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="lists" <?php if (!is_user_logged_in()) {
                                                                                    echo 'style="display:none;"';
                                                                                } ?>>
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('informate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('tus temas', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="asociate-wrapper">
                            <div class="title text-center mt-4">
                                <h4 class="italic"><?php echo __('¡Hola ', 'gen-base-theme') ?> <?php echo is_user_logged_in() ? wp_get_current_user()->user_firstname : '<div id="name-user"></div>'; ?>!
                                </h4>
                            </div>
                            <div class="subtitle text-center mt-4">
                                <p><?php echo __('Podés elegir entre estas alternativas para informarte.', 'gen-base-theme') ?>
                                </p>
                            </div>
                            <div class="articulos mh-75 mh-md-50 overflow-auto d-flex flex-column my-3">
                                <?php
                                $args = [
                                    'post_type' => 'mailtrain_lists'
                                ];

                                $query = new WP_Query($args);
                                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                                ?>
                                        <!-- lista -->
                                        <div class="articulo with-thumbnail mt-3">
                                            <button type="button" class="d-flex align-items-center" id="topic-<?php echo get_the_ID() ?>">
                                                <div class="thumbnail d-none d-md-block col-12 col-md-3 p-0">
                                                    <div class="img-container" style="background-image:url('<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>');">
                                                    </div>
                                                </div>
                                                <div class="content col-12 col-md-9 p-0">
                                                    <div class="line-height-0">
                                                        <div class="separator m-0"></div>
                                                    </div>
                                                    <div class="articulo-content my-md-3">
                                                        <div class="topic text-uppercase">
                                                            <p><?php echo get_post_meta(get_the_ID(), '_frecuency', true) ?></p>
                                                        </div>
                                                        <div class="title">
                                                            <h5><?php echo get_the_title(get_the_ID()) ?></h5>
                                                        </div>
                                                        <div class="description mt-2">
                                                            <p><?php echo get_the_content(get_the_ID()) ?>
                                                            </p>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="author">
                                                                <p>Por: <?php echo get_post_meta(get_the_ID(), '_author_newsletter', true) ?></p>
                                                            </div>
                                                            <div class="checkbox-container text-right">
                                                                <input type="checkbox" name="list-cid[]" data-listId="<?php echo get_the_ID()?>" class="topic-checkbox list-item-select" value="<?php echo get_post_meta(get_the_ID(), '_list_cid', true) ?>">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                        <!-- lista -->
                                    <?php
                                    endwhile;
                                    ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="checkbox-container text-center mt-2">
            <input type="checkbox" class="terms-checkbox" name="terms" id="terms-and-conditions" value="">
            <label for="terminos"><?php echo __('Acepto', 'gen-base-theme') ?><a href="<?php echo get_permalink(get_option('mailtrain_terms_page'))?>"><u><?php echo __('Términos y Condiciones', 'gen-base-theme') ?></u></a></label>
        </div>
        <div class="btns-container <?php echo !is_user_logged_in() ? 'd-flex justify-content-between align-items-center' : 'text-center'; ?> mt-3">
            <?php if (!is_user_logged_in()) : ?>
                <button type="button" id="prev-button-1" class="gray-btn-black-text w-50"><?php echo __('anterior', 'gen-base-theme') ?></button>
            <?php endif; ?>
            <button type="button" id="finish-button-1" class="w-50 <?php echo is_user_logged_in() ? 'mx-auto' : ''; ?>"><?php echo __('siguiente', 'gen-base-theme') ?></button>
        </div>
    </div>
<?php
                                else :
                                    echo '<div class="col-12 text-center"> ' . __('Sorry, no lists there.', 'gen-base-theme') . '</div>';
                                endif;
?>
</div>
<!-- listas -->
</form>
<?php do_action('after_lists_form') ?>

<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="thanks-newsletter">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('informate', 'gen-base-theme') ?><span class="ml-2"><?php echo __('finalizar', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4 class="italic m-0"><?php echo sprintf(__('Gracias %s', 'gen-base-theme'), '<span id="name-user"></span>'); ?></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="subtitle text-center mt-4">
                                <p><?php echo __('Ahora recibirás información de Tiempo Argentino. Un medio autogestionado, es posible.', 'gen-base-theme') ?></p>
                            </div>

                            <div class="btns-container text-center">
                                <a href="<?php echo home_url()?>"><button>IR AL SITIO</button></a>
                            </div>
                            <div class="img-container mt-5">
                                <img src="<?php echo get_template_directory_uri()?>/assets/img/asociate.svg" alt="" class="img-fluid">
                            </div>
                            <div class="text-center mt-4">
                                <p>¿Querés ser socio?</p>
                            </div>
                            <div class="btns-container text-center">
                                <button class="gray-btn-black-text"><a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>">CLICK AQUÍ</a></button>
                            </div>
                            <div class="text-center mt-4">
                                <p><?php echo __('Podrás editar tus preferencias, desde tu perfil de usuario, cuando quieras.', 'gen-base-theme') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>