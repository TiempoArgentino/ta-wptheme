<?php
/**
 * Users
 */

class TA_Tools_Admin{

    public function __construct()
    {
        add_action('admin_menu', [$this,'menu_borrar']);

        add_action('admin_enqueue_scripts', [$this,'js']);

        add_action( 'wp_ajax_nopriv_delete-article', [$this,'delete_ajax'] );
        add_action( 'wp_ajax_delete-article', [$this,'delete_ajax'] );

        add_action( 'wp_ajax_nopriv_delete-coso', [$this,'delete_coso'] );
        add_action( 'wp_ajax_delete-coso', [$this,'delete_coso'] );
    }

    public function get_all_users()
    {
        $users = get_users(array( 'role__in' => array( 'administrator' ) ));

        $post_types = get_post_types([
            'public' => true
        ],
        'names',
        'and');

      
    
        $select = '<div class="wrap">
            <h1>Borrar Articulos por Usuario</h1>
        <form method="post"> ';
    
        $select .= '<label>Seleccionar usuario: </label> <select name="usuarios-borralos" id="usuarios-borralos">';
        foreach($users as $user) {
            $select .= '<option value="'.$user->ID.'">'.esc_html( $user->display_name ).'</option>';
        }
        $select .= '</select><br /> ';

        $select .= '<label>Tipo de post: </label> <select name="types" id="types">';
        foreach($post_types as $key => $val) {
            $select .= '<option value="'.$val.'">'.$val.'</option>';
        }
        $select .= '</select><br />';
        $select .= '  <input type="button" name="borrar" id="borrar-articulos" class="button button-primary" value="Borrar" />
        </form></div>';
        $select .= '<div id="mensaje-fin" style="display:block;font-size:16px; padding-top:10px; text-transform:uppercase;"></div></div>';
    
        echo $select;
    }

    public function js()
    {
        wp_enqueue_script('delete-tool', get_stylesheet_directory_uri().'/inc/delete-tool/delete-tool.js');

        wp_localize_script( 'delete-tool', 'ajax_delete', array(
            'url'    => admin_url( 'admin-ajax.php' ),
            'nonce'  => wp_create_nonce( 'my-ajax-nonce' ),
            'action' => 'delete-article'
        ) );

        wp_localize_script( 'delete-tool', 'ajax_delete_coso', array(
            'url'    => admin_url( 'admin-ajax.php' ),
            'nonce'  => wp_create_nonce( 'my-ajax-nonce' ),
            'action' => 'delete-coso'
        ) );
    }

    public function delete_ajax()
    {
        if(isset($_POST['action'])) {
            $nonce = sanitize_text_field( $_POST['nonce'] );

            if ( ! wp_verify_nonce( $nonce, 'my-ajax-nonce' ) ) {
                die ( 'Busted!');
            }

            if(isset($_POST['id']) && isset($_POST['types'])) {
                $args = [
                    'author' => $_POST['id'],
                    'post_type' => $_POST['types'],
                    'posts_per_page' => 1 // no limit
                ];
        
                $posts = get_posts($args);

                $ids = [];

                foreach($posts as $p) {
                    $ids[] = $p->{'ID'};
                }

                echo wp_send_json_success($posts[0]->{'ID'});
                wp_die();
            } else {
                echo wp_send_json_error();
                wp_die();
            }
        }
    }

    public function delete_coso()
    {
        if(isset($_POST['action']) && $_POST['action'] === 'delete-coso') {
            $nonce = sanitize_text_field( $_POST['nonce'] );

            if ( ! wp_verify_nonce( $nonce, 'my-ajax-nonce' ) ) {
                die ( 'Busted!');
            }

            if(isset($_POST['id_post'])) {
                if($this->delete_posts_by_user($_POST['id_post'])){
                    echo wp_send_json_success( 'delete id: '.$_POST['id_post'] );
                } else {
                    echo wp_send_json_error( 'no' );
                }
               
                wp_die();
            }

            echo wp_send_json_error();
            wp_die();
        }
    }
    public function delete_posts_by_user($post_id){
            $delete = wp_delete_post($post_id, true);
            if($delete){
                return true;
            }
            return false;
    }
    

    public function menu_borrar() {
        add_submenu_page(
            'tools.php',
            __( 'Borrar Articulos', 'gen-base-theme' ),
            __( 'Borrar Articulos', 'gen-base-theme' ),
            'manage_options',
            'borrar-articulos',
            [$this,'get_all_users']
        );
    }

    
}

function ta_tools()
{
    return new TA_Tools_Admin();
}

ta_tools();





