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

        add_action('rest_api_init', [$this, 'endpoint']);
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
        global $wp_query;
        wp_enqueue_script('beneficios-front-js', get_template_directory_uri() . '/beneficios/js/script.js', array(), TA_THEME_VERSION, true);

        wp_localize_script('beneficios-front-js', 'beneficios_theme_ajax', [
            'action' => 'b_theme_ajax',
            'url' => admin_url('admin-ajax.php'),
            'post_id' => isset($_POST['post_id']) ? $_POST['post_id'] : '',
            'user' => isset($_POST['user']) ? $_POST['user'] : '',
            'loadMore' => rest_url('beneficios/v1/more'),
            'loadLoop' => rest_url('beneficios/v1/loop'),
            'loggedIn' => is_user_logged_in(),
            'userID' => wp_get_current_user()->ID
        ]);
    }

    public function delete_user_history()
    {
        if (isset($_POST['action'])) {
            if (isset($_POST['post_id']) && isset($_POST['user'])) {
                if (beneficios_panel()->delete_beneficio($_POST['post_id'], $_POST['user'])) {
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



    public function endpoint()
    {
        register_rest_route('beneficios/v1', '/more', array(
            'methods' => 'POST',
            'callback' => [$this, 'beneficios_posts'],
            'permission_callback' => '__return_true'
        ));

        register_rest_route('beneficios/v1', '/loop', array(
            'methods' => 'POST',
            'callback' => [$this, 'beneficios_loop'],
            'permission_callback' => '__return_true'
        ));
    }

    public function beneficios_posts(WP_REST_Request $request)
    {
        $offset = $request->get_param('offset');
        $term = $request->get_param('term');
        $logged = $request->get_param('logged');
        $userid = $request->get_param('userid');

        $args = [
            'post_type' => 'beneficios',
            'posts_per_page' => 12,
            'offset' => $offset,
            'tax_query' => [
                [
                    'taxonomy' => 'cat_beneficios',
                    'field' => 'id',
                    'terms' => $term
                ]
            ],
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => '_active',
                    'value' => '1',
                    'compare' => 'LIKE'
                ],
                [
                    'key' => '_finish',
                    'value' => date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                ]
            ]
        ];
        $beneficios = get_posts($args);


        $html = [];
        foreach ($beneficios as $beneficio) {
            $html[] = $this->show_beneficio($beneficio->ID, $beneficio->post_title, $logged, $userid);
        }
        return wp_send_json_success($html);
    }

    public function beneficios_loop(WP_REST_Request $request)
    {
        $offset = $request->get_param('offset');
        $logged = $request->get_param('logged');
        $userid = $request->get_param('userid');

        $args = [
            'post_type' => 'beneficios',
            'posts_per_page' => 12,
            'offset' => $offset,
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => '_active',
                    'value' => '1',
                    'compare' => 'LIKE'
                ],
                [
                    'key' => '_finish',
                    'value' => date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                ]
            ]
        ];
        $beneficios = get_posts($args);


        $html = [];
        foreach ($beneficios as $beneficio) {
            $html[] = $this->show_beneficio($beneficio->ID, $beneficio->post_title, $logged, $userid);
        }
        return wp_send_json_success($html);
    }

    public function show_beneficio($id, $title, $logged, $userid)
    {

        $by_user = beneficios_front()->get_beneficio_by_user($userid, $id) ? 'requested' : '';
        $term = beneficios_front()->show_terms_slug_by_post($id);
        $discount = get_post_meta($id, '_beneficio_discount', true) !== null || get_post_meta($id, '_beneficio_discount', true) !== '' ? get_post_meta($id, '_beneficio_discount', true) : '';

        $status = get_user_meta($userid,'_user_status',true);
        $userdata = get_userdata($userid);
        $rol = $userdata->roles[0];


        $html = '<div class="article-preview vertical-article benefits d-flex flex-column mb-3 col-12 col-md-4 px-0 px-md-2 ' . $by_user . '" data-term="' . $term . '">';
        $html .= '<div class="container p-2">';

        $html .= ' <div class="">
            <a href="#" data-content="#content' . $id . '" class="abrir-beneficio">
                <div class="img-container position-relative">
                    <div class="img-wrapper" style="background:url(' . get_the_post_thumbnail_url($id) . ')center no-repeat;"></div>
                </div>
            </a>
        </div>';
        $html .= '<div class="content mt-2">';

        $html .= '<div class="title">
        <a href="#" data-content="#content' . $id . '" class="abrir-beneficio">
            <p>' . $title . '</p>
            ' . $discount . '
            </a>
        </div>';

        $html .= '<div class="options mt-4">';
        if ($logged == 1 && $status == 'active' && $rol == get_option('subscription_digital_role') || $rol == 'administrator' ) :
            if (!beneficios_front()->get_beneficio_by_user($userid, $id)) :
                if (get_post_meta($id, '_beneficio_date', true)) :
                    $html .= '<div id="fechas">';
                    foreach (get_post_meta($id, '_beneficio_date', true) as $key => $val) :
                        $html .= '<label>
                        <input type="radio" data-button="#solicitar-' . $id . '" '.$check.' class="select-dates" name="gender" value="' . date('Y-m-d H:i:s', strtotime($val)) . '"> ' . date_i18n('d M H:i',  strtotime($val)) . 'hs</label><br />';
                    endforeach;
                    $html .= '</div>';
                endif;
            else :
                $html .= '<p>Fecha elegida ' . beneficios_front()->get_beneficio_data($userid, $id)->{'date_hour'} . '</p>';
            endif;
        endif;

        $html .= ' <div class="btns-container d-flex justify-content-between align-items-center">';
        if ($logged == 1 && $status == 'active' && $rol == get_option('subscription_digital_role') || $rol == 'administrator') :
            $html .= '<div class="request">';
            $disabled = get_post_meta($id, '_beneficio_date', true) ? 'disabled' : '';
            $text = beneficios_front()->get_beneficio_by_user($userid, $id) ? __('Solicitado', 'beneficios') : __('Solicitar', 'beneficios');

            $html .= '<button type="button" ' . $disabled . ' class="solicitar" data-id="' . $id . '" data-user="' . $userid . '" data-date="" id="solicitar-' . $id . '"> ' . $text . '</button>';
            $html .= '</div>';

            $html .= '<div id="dni-' . $id . '" class="dni-field" style="display: none;">
                ' . __('Agrega tu DNI para solicitar el beneficio', 'beneficios') . '<br />
                <p>
                    <input type="number" name="dni-number" id="dni-number-' . $id . '" data-id="' . $id . '" data-user="' . $userid . '" data-date="" value="" class="form-control" />
                </p>
                <div class="request">
                    <button type="button" data-id="#dni-number-' . $id . '" class="dni-button btn btn-primary">Solicitar</button>
                </div>
            </div>';
        elseif ($logged == 1 && ($status == 'active' || $status == 'inactive' || $status == 'on-hold' || !$status) && ($rol != get_option('subscription_digital_role') || $rol != 'administrator')) :
            $html .= '<div class="request">
            <button><a href="' . get_permalink(get_option('subscriptions_loop_page')) . '">' . __('Renovar membresía.', 'gen-base-theme') . '</a></button>
        </div>';
        else :
            $html .= '<div class="request">
                <button><a href="' . get_permalink(get_option('subscriptions_login_register_page')) . '">' . __('Iniciar Sesión.', 'gen-base-theme') . '</a></button>
            </div>';
        endif;

        $html .= '<div class="see-description">
                <button type="button" class="collapsed" data-content="#content' . $id . '" data-toggle="collapse" data-target="#content' . $id . '" aria-expanded="false" aria-controls="content' . $id . '">
                    ver más <img src="' . get_stylesheet_directory_uri() . '/assets/img/right-arrow.png" alt="" class="img-fluid" />
                </button>
            </div>
         </div>';
        $html .= '</div>';

        $html .= '<div class="benefit-description collapse mt-4" id="content' . $id . '">
            <div class="benefit-description-header d-flex align-items-end">
                <div class="benefit-icon mr-2">
                    <img src="' . get_stylesheet_directory_uri() . '/assets/img/tiempo-gift.svg" alt="">
                </div>
                <div>
                    <div class="title">
                        <p>' . __('Beneficios tiempo', 'gen-base-theme') . '</p>
                    </div>
                    <div class="category">
                        <p>' . beneficios_front()->show_terms_name_by_post($id) . '</p>
                    </div>
                </div>
            </div>
            <div class="description mt-3">
                ' . get_the_content($id) . '
            </div>
        </div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

function beneficios_assets()
{
    return new Beneficios_Assets();
}

beneficios_assets();
