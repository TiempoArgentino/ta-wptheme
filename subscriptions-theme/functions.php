<?php


class Subscriptions_Assets
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', [$this,'styles'] );
        add_action( 'wp_enqueue_scripts', [$this,'scripts'] );
    }

    public function styles()
    {
        wp_enqueue_style('subscriptions-front-css', get_template_directory_uri() . '/subscriptions-theme/css/style.css');
    }

    public function scripts()
    {
        wp_enqueue_script( 'subscriptions-front-js', get_template_directory_uri() . '/subscriptions-theme/js/script.js', array(), null, true );

    }
}

function subscriptions_assets()
{
    return new Subscriptions_Assets();
}
subscriptions_assets();