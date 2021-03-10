<?php


class Subscriptions_Assets
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', [$this,'styles'] );
    }

    public function styles()
    {
        wp_enqueue_style('subscriptions-front-css', get_template_directory_uri() . '/suscriptions-theme/css/style.css');
    }
}

function subscriptions_assets()
{
    return new Subscriptions_Assets();
}
subscriptions_assets();