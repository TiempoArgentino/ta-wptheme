<?php

class Balancer_TA
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'place_ajax_vars']);
        add_action('wp_enqueue_scripts', [$this, 'tag_cloud_var']);

        add_action('wp_ajax_nopriv__balancer_action_theme', [$this, 'place_ajax_response']);
        add_action('wp_ajax__balancer_action_theme', [$this, 'place_ajax_response']);

        add_action('cloud_tag', [$this, 'tag_cloud_template']);

        add_action('wp_ajax_nopriv__cloud_ajax', [$this, 'tag_ajax']);
        add_action('wp_ajax__cloud_ajax', [$this, 'tag_ajax']);
    }

    public function place_ajax_vars()
    {
        wp_enqueue_script('tar_balancer_ajax_script', get_template_directory_uri()  . '/balancer/js/tar-balancer-ajax.js', array('jquery'), '1.0', true);
        wp_localize_script('tar_balancer_ajax_script', 'balancer_place_ajax', [
            'url'    => admin_url('admin-ajax.php'),
            'action' => '_balancer_action_theme',
            'b_search' => isset($_POST['b_search']) ? $_POST['b_search'] : ''
        ]);
    }

    public function place_ajax_response()
    {
        if (isset($_POST['action'])) {

            if (isset($_POST['b_search'])) {
                global $wpdb;
                $results = $wpdb->get_results(
                    $wpdb->prepare("SELECT * FROM wp_terms LEFT join wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id WHERE wp_term_taxonomy.taxonomy = %s AND wp_terms.slug LIKE %s", [get_option('balancer_editorial_place'), '%' . sanitize_title($_POST['b_search']) . '%'])
                );
                $form = '<ul id="suggest-ul">';
                foreach ($results as $r) {
                    $form .= '<li class="suggest" data-id="' . $r->{'term_id'} . '">' . $r->{'name'} . '</li>';
                }
                $form .= '</ul>';
                echo $form;
                wp_die();
            } else {
                wp_send_json_error();
                wp_die();
            }
        }
    }

    /** tag cloud */

    public function tag_cloud_template()
    {
        if (function_exists('balancer_personalize')) {

            if (is_user_logged_in()) {
                $topics = get_user_meta(wp_get_current_user()->ID, '_personalizer_topics', true);
            }
            if ($topics === null) {
                require_once TA_THEME_PATH . '/balancer/tags/topics-cloud.php';
            }
        }
    }

    public function tag_cloud_var()
    {
        wp_localize_script('tar_balancer_ajax_script', 'balancer_cloud_ajax', [
            'url'    => admin_url('admin-ajax.php'),
            'action' => '_cloud_ajax',
            'id' => isset($_POST['id']) ? $_POST['id'] : ''
        ]);
    }

    public function tag_ajax()
    {
        if(isset($_POST['action'])) {

            if(isset($_POST['id'])) {
               
                balancer_cookie()->populate_cookie();

                $tag = $_POST['id'];

                $array = [];
                $array['info']['tags'] = [$tag];

                $data = posts_balancer_db()->get_data_row($_COOKIE['balancer'],'id_session','balancer_session');
                $user_data = maybe_unserialize($data->{'content'});

                if($data->{'content'} === '') {
                    posts_balancer_db()->update_data('balancer_session',['content' => maybe_serialize($array)],['id_session'=>$_COOKIE['balancer']],['%s'],['%s']);
                } else {
                    $new_data = [];
                    $new_data['info']['tags'] = [$tag];

                    if($user_data['info']['tags'] != null) {
                        if(array_diff($user_data['info']['tags'], $new_data['info']['tags']) > 0) {
                            $new_tag = array_diff($user_data['info']['tags'], $new_data['info']['tags']);
                            $new_data['info']['tags'] = array_merge($new_tag,$new_data['info']['tags']);
                        }
                    }

                    posts_balancer_db()->update_data('balancer_session',['content' => maybe_serialize($new_data)],['id_session'=>$_COOKIE['balancer']],['%s'],['%s']);
                }

                wp_send_json_success($_POST['id']);
                wp_die();
                
            } else {
                wp_send_json_success();
            }
            wp_die();
        }
    }
}

function balancer_ta()
{
    new Balancer_TA();
}

balancer_ta();
