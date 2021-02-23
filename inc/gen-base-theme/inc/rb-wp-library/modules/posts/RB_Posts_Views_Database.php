<?php

class RB_Post_Views_Database{
    const views_table = 'rb_posts_views';

    static private $initialized = false;

    static public function initialize(){
        if(self::$initialized)
            return false;
        self::$initialized = true;

        self::create_tables();
    }

    // =========================================================================
    // TABLES NAMES
    // =========================================================================
    static public function wpdb_prefix(){
		global $wpdb;
		return $wpdb->prefix;
	}

    static public function get_table_name($table){
        return (self::wpdb_prefix()) . $table;
    }

    static public function get_views_table_name(){
        return self::get_table_name(self::views_table);
    }

    // =========================================================================
    // SANITATION
    // =========================================================================
    /**
    *   Limpia el array $data dejando solo los items que pertenezcan al $format
    *   @param mixed[] $data                            Array de datos
    *   @param array[] $format                          Array de formatos. Uno para cada item que debe tener
    *                                                   $data. [ 'itemID'   => [ $formato ] ];
    */
    static public function get_sanitized_data($data, $format){
        $sanitized_data = array();
        $types = array();

        if(is_array($data) && is_array($format)){
            foreach($data as $name => $value){
                if($format[$name] && isset($value)){
                    $sanitized_data[$name] = $value;
                    array_push($types, $format[$name][0]);
                }
            }
        }

        return array(
            'data'  => $sanitized_data,
            'types' => $types,
        );
    }

    static public function get_view_sanitized_data($view_data){
        return self::get_sanitized_data($view_data, array(
            'view_id'                           => array('%s', false),
            'post_id'                           => array('%d', false),
            'user_remote_addr'                  => array('%s', false),
            'user_http_x_forwarded_for'         => array('%s', false),
            'view_date'                         => array('%s', false),
        ));
    }


    // =========================================================================
    // TABLES CREATION
    // =========================================================================

    //Crea las tablas necesarias para el funcionamiento del modulo
    static private function create_tables(){
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        self::create_views_table();
    }

    //Crea la tabla de views
    static private function create_views_table(){
        global $wpdb;
        $table_name = self::get_views_table_name();
        $charset_collate = $wpdb->get_charset_collate();
        // $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
        $sql = "CREATE TABLE $table_name (
            view_id int NOT NULL AUTO_INCREMENT,
            post_id int NOT NULL,
            user_remote_addr varchar(50) DEFAULT NULL,
            user_http_x_forwarded_for varchar(50) DEFAULT NULL,
            view_date DATETIME NOT NULL,
            primary key (view_id)
        ) $charset_collate;";

        maybe_create_table($table_name, $sql);
    }

    // =========================================================================
    // DB MANIPULATION
    // =========================================================================

    //Inserta una view en la base de datos.
    static public function insert_view($view_data){
        global $wpdb;

        $sanitized_data_and_types = self::get_view_sanitized_data($view_data);
        $view_sanitized_data = $sanitized_data_and_types['data'];
        $data_types = $sanitized_data_and_types['types'];
        $wpdb->insert(self::get_views_table_name(), $view_sanitized_data, $data_types);
        if($wpdb->last_error){
            if (strpos($wpdb->last_error, 'Duplicate entry') !== false)
                return new WP_Error( 'view_insertion_duplicated_id', __( 'This view already exists' ), $wpdb );
            return new WP_Error( 'view_insertion_unknown_error', __( 'No se pudo insertar el voto. Error desconocido.' ), $wpdb );
        }
        return true;
    }

    /**
    *   Returns the view data of the current user for a post
    *   @param int|WP_Post|null $post
    */
    static public function get_view($post = null){
        global $wpdb;
        $post = get_post($post);
        $user_http_x_forwarded_for = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : null;
        $user_remote_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
        $views_table_name = self::get_views_table_name();
        $user_view = $wpdb->get_row(
            "SELECT * FROM $views_table_name
            WHERE post_id = '$post->ID' AND
            (
                ( user_remote_addr IS NOT NULL AND user_remote_addr = '$user_remote_addr')
                OR
                (user_http_x_forwarded_for IS NOT NULL AND user_http_x_forwarded_for = '$user_http_x_forwarded_for')
            )"
        );
        return $user_view;
    }

}

RB_Post_Views_Database::initialize();
