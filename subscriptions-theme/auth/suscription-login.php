<?php get_header();
do_action('user_login_actions');
$can_register = get_option('users_can_register');
?>
<div class="container ta-context asociate gray-border mt-2 my-lg-5">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('Tiempo Argentino', 'gen-theme-base') ?><span class="ml-2"><?php echo __('Iniciar Sesión', 'gen-theme-base') ?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="col-md-6 mx-auto col-12">
                        <div class="title text-center mt-5 mb-3">
                            <h4 class="italic m-0"><?php echo __('Iniciar Sesión', 'gen-theme-base') ?></h4>
                            <h4 class="italic m-0"></h4>
                        </div>
                        <?php do_action('subscriptions_before_login_form') ?>
                        <div class="asociate-wraper">
                            <form method="post" class="suscription-login-form subscritpions-form">
                                <div class="form-group">
                                    <input type="email" name="username" id="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" placeholder="<?php echo __('Email', 'gen-theme-base') ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" value="" placeholder="<?php echo __('Contraseña', 'gen-theme-base') ?>" class="form-control">
                                </div>
                                <input type="hidden" name="redirect_to" value="<?php echo wp_get_referer() && wp_get_referer() !== get_permalink(get_option('subscriptions_login_register_page')) ? wp_get_referer() : get_permalink(get_option('subscriptions_profile')) ?>">
                                <div class="btns-container text-center mt-3">
                                    <button type="submit" name="login" class="yellow-btn-white-text"><?php echo __('Ingresar', 'gen-theme-base') ?></button>
                                </div>
                            </form>
                            <div class="sign-up-sign-in text-center mt-4">
                                <div class="login mt-4">
                                    <div>
                                        <p><?php echo __('¿No sos miembro?', 'gen-theme-base') ?></p>
                                    </div>
                                    <div class="btns-container text-center" id="login-button">
                                        <button class="login-btn gray-btn-black-text"><a href="<?php echo get_permalink(get_option('subscriptions_register_page')) ?>"><?php echo __('Crear cuenta', 'gen-theme-base') ?></a></button>
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

<?php get_footer() ?>