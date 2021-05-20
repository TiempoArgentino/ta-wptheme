<?php

class User_Panel_Theme
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'styles']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);
        
        add_filter('panel_tabs_profile', [$this, 'profile_tab']);
        add_filter('panel_tabs_account', [$this, 'account_tab']);

        add_action('profile_details',[$this,'comments_count']);

    }

    public function styles()
    {
        wp_enqueue_style('user-panel-front-css', get_template_directory_uri() . '/user-panel/css/style.css');
    }

    public function scripts()
    {
        wp_enqueue_script('user-panel-front-js', get_template_directory_uri() . '/user-panel/js/script.js', array(), null, true);
    }

    public function profile_tab()
    {
        echo ' <li class="nav-item position-relative">
            <a class="nav-link d-flex flex-row-reverse active tab-select tab-active" id="profile-tab" data-toggle="tab" href="#profile" data-content="#profile">
                <div></div>
                <p>' . __('Perfil', 'gen-base-theme') . '</p>
            </a>
        </li>';
    }

    public function account_tab()
    {
        echo ' <li class="nav-item position-relative ">
            <a class="nav-link d-flex flex-row-reverse tab-select" id="account-tab" data-toggle="tab" href="#account" data-content="#account">
                <div></div>
                <p>'.__('Cuenta','gen-base-theme').'</p>
            </a>
        </li>';
    }

    public function comments_count()
    {
        $args = [
            'user_id' => wp_get_current_user()->ID,
            'count' => true,
        ]; 
        echo '<div class="option mt-3">
            <button class="d-flex align-items-center">
                <div class="opt-icon">
                    <img src="'.get_template_directory_uri().'/assets/img/comments-icon.svg" alt="" class="img-fluid">
                </div>
                <div class="opt-title">
                    <p>'.__('Tus comentarios: ','user-panel').'  <span>('.get_comments($args).')</span></p>
                </div>
            </button>
        </div>';
    }
}

function user_panel_theme()
{
    return new User_Panel_Theme();
}
user_panel_theme();
