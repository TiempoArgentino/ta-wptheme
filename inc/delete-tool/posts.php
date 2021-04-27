<?php
/**
 * Users
 */

class TA_Tools_Admin{

    public function __construct()
    {
        add_action('admin_menu', [$this,'menu_borrar']);

        //add_action('admin_enqueue_scripts', [$this,'js']);

        add_action( 'wp_ajax_nopriv_delete-article', [$this,'delete_ajax'] );
        add_action( 'wp_ajax_delete-article', [$this,'delete_ajax'] );
    }

    public function js()
    {
        wp_enqueue_script('delete-tool', get_stylesheet_directory_uri().'/inc/delete-tool/delete-tool.js');

        wp_localize_script( 'delete-tool', 'ajax_delete', array(
            'url'    => admin_url( 'admin-ajax.php' ),
            'nonce'  => wp_create_nonce( 'my-ajax-nonce' ),
            'action' => 'delete-article'
        ) );
    }

    public function delete_ajax()
    {
        if(isset($_POST['action'])) {
            $nonce = sanitize_text_field( $_POST['nonce'] );

            if ( ! wp_verify_nonce( $nonce, 'my-ajax-nonce' ) ) {
                die ( 'Busted!');
            }

            if(isset($_POST['id'])) {
                delete_posts_by_user($_POST['id']);
                echo wp_send_json_success();
                wp_die();
            } else {
                echo wp_send_json_error();
                wp_die();
            }
        }
    }

    public function get_all_users()
    {
        $users = get_users(array( 'role__in' => array( 'administrator' ) ));
    
        $select = '<div class="wrap">
            <h1>Borrar Articulos por Usuario</h1>
        <form method="post">';
    
        $select .= '<label>Seleccionar usuario: </label><select name="usuarios-borralos" id="usuarios-borralos">';
        foreach($users as $user) {
            $select .= '<option value="'.$user->ID.'">'.esc_html( $user->display_name ).'</option>';
        }
        $select .= '</select>
            <input type="button" name="borrar" id="borrar-articulos" class="button button-primary" value="Borrar" />
        </form></div>';
    
        echo $select;
    }

    public function menu_borrar() {
        add_submenu_page(
            'tools.php',
            __( 'Borrar Articulos', 'gen-theme-base' ),
            __( 'Borrar Articulos', 'gen-theme-base' ),
            'manage_options',
            'borrar-articulos',
            [$this,'get_all_users']
        );
    }

    public function delete_posts_by_user($user_id){
        if(isset($user_id)) {
    
            $args = [
                'author' => $user_id,
                'post_type' => 'ta_article',
                'posts_per_page' => -1 // no limit
            ];
    
            $posts = get_posts($args);

            $hola = count($posts);

            for($i = 0;$i<$hola;$i++){
               //wp_delete_post($posts[$i]->{'ID'}, true);
               return $posts[$i]->{'ID'};
            }
        }
    }
}

function ta_tools()
{
    return new TA_Tools_Admin();
}

ta_tools();





