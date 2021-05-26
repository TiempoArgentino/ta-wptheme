<?php

class Beneficios_Assets
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'styles']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);

        add_filter('template_include', [$this, 'search_template']);

        add_action('wp_ajax_nopriv_b_theme_ajax', [$this, 'delete_user_history']);
        add_action('wp_ajax_b_theme_ajax', [$this, 'delete_user_history']);
    }

    public function styles()
    {

        // wp_enqueue_style('beneficios-main-css', get_template_directory_uri() . '/beneficios/css/main.css');
        // wp_enqueue_style('beneficios-article-css', get_template_directory_uri() . '/beneficios/css/articles-block.css');
        // wp_enqueue_style('beneficios-especial-css', get_template_directory_uri() . '/beneficios/css/simple-especial.css');
        wp_enqueue_style('beneficios-front-css', get_template_directory_uri() . '/beneficios/css/beneficios.css');
    }

    public function scripts()
    {
        wp_enqueue_script('beneficios-front-js', get_template_directory_uri() . '/beneficios/js/script.js', array(), null, true);

        wp_localize_script('beneficios-front-js', 'beneficios_theme_ajax', [
            'action' => 'b_theme_ajax',
            'url' => admin_url('admin-ajax.php'),
            'post_id' => isset($_POST['post_id']) ? $_POST['post_id'] : '',
            'user' => isset($_POST['user']) ? $_POST['user'] : ''
        ]);
    }

    public function delete_user_history()
    {
        if (isset($_POST['action'])) {
            if (isset($_POST['post_id']) && isset($_POST['user'])) {
                if(beneficios_panel()->delete_beneficio($_POST['post_id'],$_POST['user'])){
                    wp_send_json_success();
                } else {
                    wp_send_json_error();
                }
                wp_die();
            }
            wp_send_json_error();
            wp_die();
        }
    }

    public function search_template($template)
    {
        global $wp_query;
        $post_type = get_query_var('post_type');
        if ($wp_query->is_search && $post_type == 'beneficios') {
            return locate_template('beneficios/pages/beneficios-search.php');  //  
        }
        return $template;
    }
}

function beneficios_assets()
{
    return new Beneficios_Assets();
}

beneficios_assets();
