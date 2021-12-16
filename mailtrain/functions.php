<?php


class Newsletter_Assets
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', [$this,'styles'] );
        add_action( 'wp_enqueue_scripts', [$this,'scripts'] );
        add_action( 'widgets_init', [$this,'mailtrain_api_widgets_init'] );

        add_filter('panel_tabs_newsletter', [$this, 'tab_newsletter']);
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
            'name'          => __( 'Newsletter Notas', 'gen-base-theme' ),
            'id'            => 'sidebar-1',
            'before_widget' => '',
            'after_widget'  => '',
        ) );
    }

    public function tab_newsletter()
    {
        echo ' <li class="nav-item position-relative last-nav-item">
            <a class="nav-link d-flex flex-row-reverse tab-select" id="news-tab" data-toggle="tab" href="#news">
                <p>'.__('News','gen-base-theme').'</p>
            </a>
        </li>';
    }
}

function newsletter_assets()
{
    return new Newsletter_Assets();
}
newsletter_assets();