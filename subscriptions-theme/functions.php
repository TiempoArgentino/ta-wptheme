<?php


class Subscriptions_Assets
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'styles']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);

        add_filter('panel_tabs_subscription', [$this, 'tab_subscription']);

        add_filter('subscriptions_ajax_ext', [$this, 'add_paper_vars']);

        add_action('wp_ajax_nopriv_subscriptions-ajax-action', [$this, 'add_paper']);
        add_action('wp_ajax_subscriptions-ajax-action', [$this, 'add_paper']);

        add_filter('protected_content', [$this, 'contenido_protegido'], 10, 1);
        add_filter('the_content', [$this, 'entrada_protegida'], 1);

        add_filter('bk_success_filter', [$this, 'bk_mailer_user_data']);
        add_filter('mp_success_filter', [$this, 'mp_mailer_user_data']);

        add_filter('bk_error_filter', [$this, 'bk_mailer_user_fail']);
        add_filter('mp_error_filter', [$this, 'mp_mailer_user_fail']);
    }

    public function styles()
    {
        wp_enqueue_style('subscriptions-front-css', get_template_directory_uri() . '/subscriptions-theme/css/style.css');
    }

    public function scripts()
    {
        wp_enqueue_script('subscriptions-front-js', get_template_directory_uri() . '/subscriptions-theme/js/script.js', array(), null, true);
    }

    public function tab_subscription()
    {
        echo '<li class="nav-item position-relative">
        <a class="nav-link d-flex flex-row-reverse tab-select" id="subscriptions-tab" data-toggle="tab" href="#subscriptions" data-content="#subscription">
            <div></div>
            <p>' . __('Subscripciones', 'gen-base-theme') . '</p>

        </a>
    </li>';
    }

    public function add_paper_vars()
    {
        $add_paper = isset($_POST['add_paper']) ? $_POST['add_paper'] : '';
        $price_paper = isset($_POST['price_paper']) ? $_POST['price_paper'] : '';

        $fields = [
            'add_paper' => $add_paper,
            'price_paper' => $price_paper
        ];
        return subscriptions_proccess()->subscriptions_localize_script('ajax_add_paper', $fields);
    }

    public function add_paper()
    {
        if (isset($_POST['add_paper'])) {
            $old_price = Subscriptions_Sessions::get_session('subscriptions_add_session')['suscription_price'];
            $new_price = Subscriptions_Sessions::update_session('subscriptions_add_session', 'suscription_price', $old_price + $_POST['price_paper']);
            Subscriptions_Sessions::update_session('subscriptions_add_session', 'suscription_address', '1');

            echo wp_send_json_success();
            wp_die();
        }
    }

    public function contenido_protegido()
    {
        $msg = '<div class="text-center pt-5 pb-5 block-message">';
        $msg .= SF()->show_message();

        $msg .= '<img src="' . get_stylesheet_directory_uri() . '/subscriptions-theme/img/protected.png" class="img-fluid d-block mx-auto mt-3 mb-5">';

        $msg .= '<a href="' . get_permalink(get_option('subscriptions_loop_page')) . '" class="block-button d-block p-3 mx-auto text-uppercase">' . __('Seamos socios', 'gen-base-theme') . '</a><br />';

        $msg .= __('Si ya eres socio:', 'gen-base-theme');

        $msg .= '<div class="d-block pt-3"><a href="' . get_permalink(get_option('subscriptions_login_register_page')) . '" class="block-button d-block p-3 mx-auto text-uppercase">' . __('Inicia sesión', 'gen-base-theme') . '</a></div>';
        $msg .= '</div>';

        return $msg;
    }

    public function entrada_protegida($content)
    {
        global $wp_query;

        if (!is_single()) {
            return $content;
        }

        $id_post = get_post_meta($wp_query->get_queried_object_id(), '_suscription', true);
        $user = get_userdata(wp_get_current_user()->ID);

        $role_in = in_array(get_option('default_sucription_role'), [$user->roles]);

        $admin = in_array('administrator', [$user->roles]);

        if ($admin) {
                return $content;
        }
        if ($id_post === '' || !empty($id_post) || $id_post === null) {
                return $content;
        } else {
            $active = get_user_meta($user->ID, '_user_status', true);

            $user_subscription = get_user_meta($user->ID, 'suscription', true);

            $authorized = in_array($user_subscription, $id_post);


            if ($active === null || $active !== 'active' || $active === '') {
                $msg = '<div class="text-center pt-5 pb-5 block-message">';
                $msg .= __('Hola :', 'gen-base-theme') . ' ' . wp_get_current_user()->first_name . ' ' . __('parece que tu membresía caducó o no tienes una, puedes actualizarla en tu perfil.', 'gen-base-theme');

                $msg .= '<img src="' . get_stylesheet_directory_uri() . '/subscriptions-theme/img/protected.png" class="img-fluid d-block mx-auto mt-3 mb-5">';

                $msg .= '<a href="' . get_permalink(get_option('user_panel_page')) . '" class="block-button d-block p-3 mx-auto text-uppercase">' . __('Mi Perfil', 'gen-base-theme') . '</a><br />';

                $msg .= '</div>';

                return $msg;
            } else if (!$role_in || !$authorized) {
                $msg = '<div class="text-center pt-5 pb-5 block-message">';
                $msg .= __('Hola :', 'gen-base-theme') . ' ' . wp_get_current_user()->first_name . ' ' . __('parece que tu membresía no es para este contenido, puedes cambiar el tipo en tu perfil personal.', 'gen-base-theme');

                $msg .= '<img src="' . get_stylesheet_directory_uri() . '/subscriptions-theme/img/protected.png" class="img-fluid d-block mx-auto mt-3 mb-5">';

                $msg .= '<a href="' . get_permalink(get_option('user_panel_page')) . '" class="block-button d-block p-3 mx-auto text-uppercase">' . __('Mi Perfil', 'gen-base-theme') . '</a><br />';

                $msg .= '</div>';

                return $msg;
            } else if ($role_in && $authorized) {
                return $content;
            }
        }
    }

    public function bk_mailer_user_data()
    {

        $user = get_userdata(wp_get_current_user()->ID);
        $get_subscription = get_the_title(get_user_meta($user->ID, 'suscription', true));

        $data = '{
            "EMAIL":"' . $user->user_email . '",
            "MERGE_EN_ESPERA":"yes",
            "MERGE_DEBITO":"yes",
            "MERGE_MEMBRESIA":"' . $get_subscription . '",
            "FORCE_SUBSCRIBE":"yes"
        }';

        if (function_exists('mailtrain_api')) {
            $membresia = mailtrain_api()->payment_user_data('25SCu2czE', $data);
        }

        wp_redirect(get_permalink(get_option('subscriptions_thankyou')));
        exit();
    }

    public function bk_mailer_user_fail()
    {

        $user = get_userdata(wp_get_current_user()->ID);
        $get_subscription = get_the_title(get_user_meta($user->ID, 'suscription', true));

        $data = '{
            "EMAIL":"' . $user->user_email . '",
            "ERROR_DE_PAGO":"yes",
            "MERGE_DEBITO":"yes",
            "MERGE_MEMBRESIA":"' . $get_subscription . '",
            "FORCE_SUBSCRIBE":"yes"
        }';

        if (function_exists('mailtrain_api')) {
            $membresia = mailtrain_api()->payment_user_data('25SCu2czE', $data);
        }

        wp_redirect(get_permalink(get_option('subscriptions_thankyou')));
        exit();
    }

    public function mp_mailer_user_data()
    {

        $user = get_userdata(wp_get_current_user()->ID);
        $get_subscription = get_the_title(get_user_meta($user->ID, 'suscription', true));

        $data = '{
            "EMAIL":"' . $user->user_email . '",
            "MERGE_MP":"yes",
            "FORCE_SUBSCRIBE":"yes",
            "MERGE_ACTIVO":"yes",
            "MERGE_MEMBRESIA":"' . $get_subscription . '"
        }';

        if (function_exists('mailtrain_api')) {
            $membresia = mailtrain_api()->payment_user_data('25SCu2czE', $data);
        }

        wp_redirect(get_permalink(get_option('subscriptions_thankyou')));
        exit();
    }

    public function mp_mailer_user_fail()
    {

        $user = get_userdata(wp_get_current_user()->ID);
        $get_subscription = get_the_title(get_user_meta($user->ID, 'suscription', true));

        $data = '{
            "EMAIL":"' . $user->user_email . '",
            "MERGE_MP":"yes",
            "FORCE_SUBSCRIBE":"yes",
            "ERROR_DE_PAGO":"yes",
            "MERGE_MEMBRESIA":"' . $get_subscription . '"
        }';

        if (function_exists('mailtrain_api')) {
            $membresia = mailtrain_api()->payment_user_data('25SCu2czE', $data);
        }
    }
}

function subscriptions_assets()
{
    return new Subscriptions_Assets();
}
subscriptions_assets();
