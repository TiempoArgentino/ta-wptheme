<?php get_header() ?>
<?php do_action('subscriptions_password_lost_before') ?>
<div class="container ta-context asociate gray-border mt-2 my-lg-5">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">

        <div class="section-title p-2">
            <h4><?php echo __('Tiempo Argentino', 'gen-base-theme') ?><span class="ml-2"><?php echo __('Recuperar contraseña', 'gen-base-theme') ?></span></h4>
        </div>
        <?php if (!is_user_logged_in()) : ?>
            <div class="container">
                <div class="container-with-header">
                    <div class="py-2">
                        <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5">
                            <div class="title text-center">
                                <h4 class="italic m-0"><?php echo __('Recuperar contraseña', 'gen-base-theme') ?></h4>
                                <h4 class="italic m-0"></h4>
                            </div>
                            <div class="asociate-wrapper">
                                <?php do_action('subscriptions_password_lost_errors')?>
                                <div class="subtitle text-center mt-4">
                                    <form method="post" class="subscritpions-form" id="lost-password-form" action="<?php echo wp_lostpassword_url(); ?>">
                                        <div class="input-container">
                                            <input type="email" name="user_login" autocomplete="off" value="" id="user_login" class="form-control" placeholder="<?php echo __('Ingresa tu email','subscriptions')?>" required />
                                        </div>
                                        <div class="btns-container text-center mt-3">
                                        <button type="submit" name="send-password" class="yellow-btn-white-text reset-password"><?php echo __( 'Recuperar contraseña', 'personalize-login' ); ?></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="btns-container text-center mt-5">
                                    <button class="gray-btn-black-text"><a href="<?php echo home_url()?>"><?php echo __('Cancelar y volver','gen-base-theme')?></a></button>
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
                                <h4 class="italic m-0"><?php echo sprintf(__('Hola %s, ya estas logueado.', 'gen-base-theme'), '<span>' . wp_get_current_user()->first_name . '</span>') ?></h4>
                                <h4 class="italic m-0"></h4>
                            </div>
                            <div class="btns-container text-center mt-5">
                                <button class="yellow-btn-white-text"><a href="<?php echo get_permalink(get_option('subscriptions_profile')) ?>"><?php echo __('Ir a tu perfil', 'gen-base-theme') ?></a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<?php do_action('subscriptions_password_lost_after')?>
<?php get_footer() ?>