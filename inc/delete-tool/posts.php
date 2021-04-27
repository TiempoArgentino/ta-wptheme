<?php
/**
 * Users
 */

class TA_Tools_Admin{

    public function __construct()
    {
        add_action('admin_menu', [$this,'menu_borrar']);
        add_action('init',[$this,'delete_posts_by_user']);
    }

    public function get_all_users()
    {
        $users = get_users(array( 'role__in' => array( 'administrator' ) ));
    
        $select = '<div class="wrap">
            <h1>Borrar Articulos por Usuario</h1>
        <form method="post">';
    
        $select .= '<label>Seleccionar usuario: </label><select name="usuarios-borralos">';
        foreach($users as $user) {
            $select .= '<option value="'.$user->ID.'">'.esc_html( $user->display_name ).'</option>';
        }
        $select .= '</select>
            <input type="submit" name="borrar" class="button button-primary" value="Borrar" />
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

    public function delete_posts_by_user(){
        if(isset($_POST['usuarios-borralos'])) {
    
            $args = [
                'author' => $_POST['usuarios-borralos'],
                'post_type' => 'ta_article',
                'posts_per_page' => -1 // no limit
            ];
    
            $posts = get_posts($args);

            $hola = count($posts);

            for($i = 0;$i<$hola;$i++){
               //var_dump($posts[$i]->{'ID'});
               wp_delete_post($posts[$i]->{'ID'}, true);
            }
        }
    }
}

function ta_tools()
{
    return new TA_Tools_Admin();
}

ta_tools();





