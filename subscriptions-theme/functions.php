<?php


class Subscriptions_Assets
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'styles']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);

        add_filter('panel_tabs_subscription', [$this, 'tab_subscription']);

        add_filter('subscriptions_ajax_ext',[$this,'add_paper_vars']);

        add_action('wp_ajax_nopriv_subscriptions-ajax-action', [$this, 'add_paper']);
        add_action('wp_ajax_subscriptions-ajax-action', [$this, 'add_paper']);
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
        if(isset($_POST['add_paper'])){
            $old_price = Subscriptions_Sessions::get_session('subscriptions_add_session')['suscription_price'];
            $new_price = Subscriptions_Sessions::update_session('subscriptions_add_session', 'suscription_price', $old_price + $_POST['price_paper']);
            Subscriptions_Sessions::update_session('subscriptions_add_session', 'suscription_address', '1');
            
            echo wp_send_json_success();
            wp_die();
        }
    }
}

function subscriptions_assets()
{
    return new Subscriptions_Assets();
}
subscriptions_assets();
