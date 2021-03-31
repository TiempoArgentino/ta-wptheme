<?php


class Subscriptions_Assets
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'styles']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);

        add_filter('panel_tabs_subscription', [$this, 'tab_subscription']);
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
}

function subscriptions_assets()
{
    return new Subscriptions_Assets();
}
subscriptions_assets();
