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
        add_filter('user_logged_content', [$this, 'entrada_protegida'], 10, 1);
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
            <p>' . __('Subscripciones', 'gen-theme-base') . '</p>

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

        $msg .= '<a href="" class="block-button w-20 d-inline p-3 mx-auto text-uppercase">seamos socios</a>';

        $msg .= '</div>';

        return $msg;
    }

    public function entrada_protegida($content)
    {
        global $wp_query;

        if (!is_single()) {
            return $content;
        }

        $post_id = get_post_meta($wp_query->get_queried_object_id(),'_suscription',true);
        $user = get_userdata(wp_get_current_user()->ID);

        $role_in = in_array(get_option('default_sucription_role'),$user->roles);
        $admin = in_array('administrator',$user->roles);

        $user_subscription = get_user_meta($user->ID,'suscription',true);

        $authorized = in_array($user_subscription,$post_id);


        if (($role_in && $authorized)|| $admin) {
            add_filter('the_content', function(){
                return get_the_content($post_id);
            });
        } else {
           return 'un error';
        }
    }
}

function subscriptions_assets()
{
    return new Subscriptions_Assets();
}
subscriptions_assets();
