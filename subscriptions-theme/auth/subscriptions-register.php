<?php get_header();

do_action('user_register_actions');

$can_register = get_option('users_can_register');
?>
<div class="container ta-context asociate gray-border mt-2 my-lg-5">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('Tiempo Argentino', 'gen-base-theme') ?><span class="ml-2"><?php echo __('Crear cuenta', 'gen-base-theme') ?></span></h4>
        </div>
        <div class="container">
            <!-- register form -->
            <?php if ($can_register !== '0') : ?>
                <div class="col-md-6 mx-auto col-12" id="form-register-container">

                    <div class="title text-center mt-5 mb-3">
                        <h4 class="italic m-0"><?php echo __('Crear cuenta', 'gen-base-theme') ?></h4>
                        <h4 class="italic m-0"></h4>
                    </div>
                    <?php do_action('subscriptions_before_register_form') ?>
                    <form method="post" class="suscription-register-form subscritpions-form">
                        <div class="form-group">
                            <input type="text" name="first_name" placeholder="Nombre" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" placeholder="Apellido" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="email" autocomplete="off" placeholder="Email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="password" autocomplete="off" placeholder="Contraseña" name="password" id="passwd" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="password" autocomplete="off" placeholder="Repetir Contraseña" name="password2" id="passwd2" class="form-control" />
                        </div>
                        <input type="hidden" name="register_redirect" value="<?php echo wp_get_referer() && wp_get_referer() !== get_permalink(get_option('subscriptions_login_register_page')) ? wp_get_referer() : get_permalink(get_option('subscriptions_profile')) ?>">
                        <div class="btns-container text-center mt-3">
                            <button class="yellow-btn-white-text" type="submit" name="submit-register"><?php echo __('Registrarse', 'subscriptions') ?></button>
                        </div>
                    </form>
                    <?php do_action('subscriptions_after_register_form') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer() ?>