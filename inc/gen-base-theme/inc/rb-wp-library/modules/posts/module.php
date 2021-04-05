<?php
if(!class_exists('RB_Posts_Module')){
    class RB_Posts_Module extends RB_Framework_Module{
        static private $initialized = false;
        static private $tracking_views = false;
        static public $dependencies = array();

        static public function initialize(){
            if(self::$initialized)
                return false;
            self::$initialized = true;
            self::add_rb_config_support();
        }

        /**
        *   Adds support for extra config when creating a post type.
        *   The extra configuration goes into an extra argument `rb_config`, in
        *   the arguments array on register_post_type
        */
        static private function add_rb_config_support(){
            add_action( 'registered_post_type', array(self::class, 'rest_post_type_rb_config'), 10, 2 );
            add_filter( 'register_post_type_args', array(self::class, 'add_rb_config'), 10, 2);
            add_action( 'registered_post_type', array(self::class, 'redirect_post_type_templates'), 10, 2);
        }

        /**
        *   Adds the rb_config to the post request response
        */
        static public function rest_post_type_rb_config($post_type, $post_type_object){
            register_rest_field( $post_type, 'rb_config', array(
                'get_callback'  => function() use ($post_type_object){
                    return $post_type_object->rb_config;
                },
            ) );
        }

        /**
        *   Merges the rb_config argument with default values.
        *   @param mixed[] templates                                            Redirections of post type templates. See `redirect_object_templates` for docs
        *
        */
        static public function add_rb_config($args, $post_type){
            $rb_config_default = array(
                'templates'	=> null,
            );
            $rb_config = isset($args['rb_config']) ? $args['rb_config'] : [];
            $rb_config = array_merge($rb_config_default, $rb_config);
            $args['rb_config'] = $rb_config;
            return $args;
        }

        /**
        *   Redirects templates if needed
        */
        static public function redirect_post_type_templates($post_type, $post_type_object){
            redirect_object_templates($post_type, 'post_type', $post_type_object->rb_config['templates']);
        }

        /**
        *   Tracks the amount of views a post has and stores it in the rb_post_views_count post meta
        */
        static public function track_views($config = array()){
            if(self::$tracking_views)
                return false;
            self::$tracking_views = true;
            require_once plugin_dir_path( __FILE__ ) . 'RB_Posts_Views_Tracker.php';
            RB_Posts_Views_Tracker::track_views($config);
        }

        /**
        *   Sets new labels for a post type
        *   @param string $action_id                        An string with which to identify the action hook.
        *                                                   It can be used to remove the hook if necessary, avoiding any
        *                                                   changes to the posts labels.
        *   @param string $post_type                        The post type to which to change the labels
        *   @param string[] $labels                         Array of labels to set
        *   @param int $priority                            Indicates how soon on the action hooks is the callback runned
        */
        static public function change_post_type_labels($action_id, $post_type, $new_labels, $priority = 10){
            if(!is_string($action_id) || !is_array($new_labels) || empty($new_labels) || !is_string($post_type))
                return false;

            $post_labels_callback = function() use ($post_type, $new_labels){
                $post_type_object = get_post_type_object($post_type);
                if(!$post_type_object)
                    return false;
                $labels = $post_type_object->labels;
                foreach($new_labels as $label_name => $label){
                    $labels->$label_name = $label;
                }
                return true;
            };

            RB_Filters_Manager::add_action($action_id, 'init', $post_labels_callback, array(
                'priority'      => $priority,
            ));
        }

        /**
        *   Returns a post with a field that matches a value. Can be any field in the wp_posts table
        *   @param string $field_value                          The value that must have the field of the post we are searching for
        *   @param string $field                                The field for which we are searching the post
        *   @param string $post_type                            The post type of the post
        *   @param mixed $output                                Output that the 'get_post' function accepts
        */
        static public function get_post_by($field_value, $field = 'post_title', $post_type = "post", $output = OBJECT){
            global $wpdb;

            if ( is_array( $post_type ) ) {
                $post_type = esc_sql( $post_type );
                $post_type_in_string = "'" . implode( "','", $post_type ) . "'";
                $sql = $wpdb->prepare(
                    "
                    SELECT ID
                    FROM $wpdb->posts
                    WHERE $field = %s
                    AND post_type IN ($post_type_in_string)
                ",
                    $field_value
                );
            } else {
                $sql = $wpdb->prepare(
                    "
                    SELECT ID
                    FROM $wpdb->posts
                    WHERE $field = %s
                    AND post_type = %s
                ",
                    $field_value, $post_type
                );
            }

            $post = $wpdb->get_var( $sql );

            if ( $post ) {
                return get_post( $post, $output );
            }
        }
    }

    RB_Posts_Module::initialize();
}
