<?php


class Newsletter_Assets
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', [$this,'styles'] );
        add_action( 'wp_enqueue_scripts', [$this,'scripts'] );
        add_action( 'widgets_init', [$this,'mailtrain_api_widgets_init'] );
    }

    public function styles()
    {
        wp_enqueue_style('maitrain-front-css', get_template_directory_uri() . '/mailtrain/css/style.css');
    }

    public function scripts()
    {
        wp_enqueue_script( 'maitrain-front-js', get_template_directory_uri() . '/mailtrain/js/script.js', array(), null, true );

    }

    public function mailtrain_api_widgets_init() {
        register_sidebar( array(
            'name'          => __( 'Sidebar Notas', 'gen-theme-base' ),
            'id'            => 'sidebar-1',
            'before_widget' => '',
            'after_widget'  => '',
        ) );
    }
}

function newsletter_assets()
{
    return new Newsletter_Assets();
}
newsletter_assets();