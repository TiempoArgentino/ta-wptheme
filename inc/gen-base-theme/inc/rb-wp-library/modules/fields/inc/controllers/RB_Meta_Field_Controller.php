<?php
trait RB_Post_Methods{
    public function get_object($post = null){
        return get_post($post);
    }

    public function get_object_id($post = null){
        $post = get_post($post);
        return $post && !is_wp_error($post) ? $post->ID : null;
    }
}

trait RB_Term_Methods{
    public function get_object($term = null){
        return get_term($term);
    }

    public function get_object_id($term = null){
        $term = get_term($term);
        return $term && !is_wp_error($term) ? $term->term_id : null;
    }
}

/**
*   Renders a meta field and manages the saving process
*/
abstract class RB_Meta_Field_Controller{
    protected $meta_type;
    public $meta_id;
    public $render_nonce = true;
    /**
    *   @property   callback            $render_callback                        Callback to render the field content
    *   @param      mixed|int|null      $wp_object
    */
    public $render_callback = null;
    /**
    *   @property   callback            $sanitize_value                         Callback to sanitize the meta value before saving
    *   @param      mixed               $value                                  The value to sanitize
    */
    public $sanitize_value = null;
    /**
    *   @property   string              $field_class                            Class to add to the field container
    */
    public $field_class = '';
    /**
    *   @property   string              $field_id                               ID or name for the html input. Defaults to the meta_id
    */
    public $field_id = '';

    public function __construct($meta_id, $meta_type, $args = array()) {
        $this->meta_type = $meta_type;
        $this->meta_id = $meta_id;
        $this->sanitize_value = isset($args['sanitize_value']) && is_callable($args['sanitize_value']) ? $args['sanitize_value'] : $this->sanitize_value;
        $this->render_callback = isset($args['render_callback']) && is_callable($args['render_callback']) ? $args['render_callback'] : $this->render_callback;
        $this->field_class = isset($args['field_class']) ? $args['field_class'] : $this->field_class;
        $this->field_id = isset($args['field_id']) ? $args['field_id'] : $this->meta_id;
    }

    /**
    *   Renders the meta field
    *   @param mixed    $wp_object                                 The current wp object
    */
    public function render_meta_field($wp_object){
        if(!is_callable($this->render_callback))
            return;
        $class = is_string($this->field_class) ? esc_attr($this->field_class) : '';
        ?>
        <div class="rb-meta-field <?php echo $class; ?>">
            <?php call_user_func($this->render_callback, $wp_object); ?>
        </div>
        <?php
    }

    /**
    *   Saves the metabox value for a wordpress object
    *   @param int      $object_id
    *   @param mixed    $wp_object
    */
    public function save_metabox( $object_id, $wp_object = null ) {
        // /* Verify the nonce before proceeding. */
        // if ( !isset( $_POST[$this->field_id . '_nonce'] ) || !wp_verify_nonce( $_POST[$this->field_id . '_nonce'], basename( __FILE__ ) ) )
        //     return $object_id;

        //JSONS Values in the $_POST get scaped quotes. That makes json_decode
        //not recognize the content as jsons. THE PROBLEM is that it also eliminates
        //th the '\' in the values of the JSON.
        //$_POST = array_map( 'stripslashes_deep', $_POST );
        //echo "-----------METABOX SAVING PROCCESS----------------<br><br>";
        $new_meta_value = null;
        if(isset($_POST[$this->field_id]))
            $new_meta_value = $this->get_sanitized_value($_POST[$this->field_id]);

        $meta_type = $this->meta_type;
        $meta_key = $this->meta_id;
        $meta_exists = metadata_exists( $meta_type, $object_id, $this->meta_id );
        $current_meta_value = $this->get_value($object_id);

        // If the new value is not null
        if( isset($new_meta_value) ){
            /* If a new meta value was added and there was no previous value, add it. */
            if( !$meta_exists )
                add_metadata( $meta_type, $object_id, $meta_key, $new_meta_value, true );
            /* If the new meta value does not match the old value, update it. */
            else if( $new_meta_value != $current_meta_value )
                update_metadata( $meta_type, $object_id, $meta_key, $new_meta_value );
        }
        /* If there is no new meta value but an old value exists, delete it. */
        else if ( $meta_exists )
            delete_metadata( $meta_type, $object_id, $meta_key, $current_meta_value );
    }

    // =========================================================================
    // METHODS
    // =========================================================================

    public function set_field_id($field_id){
        $this->field_id = $field_id;
    }

    /**
    *   Returns the meta value for the wp object meta
    *   @param Mixed|int $wp_object
    */
    public function get_value($wp_object){
        $object_id = $this->get_object_id($wp_object);
        return $object_id && metadata_exists($this->meta_type, $object_id, $this->meta_id) ? get_metadata( $this->meta_type, $object_id, $this->meta_id, true ) : null;
    }

    //
    public function filter_field_class($wp_object){
        return 'rb-field';
    }

    public function get_sanitized_value($value){
        return is_callable($this->sanitize_value) ? call_user_func($this->sanitize_value, $value) : $value;
    }

    /**
    *   @param Mixed|int $wp_object                             Wp object id or instance from which to get the meta value from
    */
    abstract public function get_object_id($wp_object = null);
}

class RB_Post_Meta_Field_Controller extends RB_Meta_Field_Controller{
    use RB_Post_Methods;
}

class RB_Term_Meta_Field_Controller extends RB_Meta_Field_Controller{
    use RB_Term_Methods;
}

/**
*   Extends the meta controller using a field control (RB_Field_Factory) that manages
*   the meta field render and value sanitization
*/
abstract class RB_Meta_Control extends RB_Meta_Field_Controller{
    public function __construct($meta_id, $meta_type, $control_settings, $args = array()) {
        parent::__construct($meta_id, $meta_type, $args);
        $this->render_callback = array($this, 'render_field_controller');
        $this->control_settings = $control_settings;
        $this->set_field_controller();
    }

    // Sets the instance of the controller for the field to display
    public function set_field_controller($value = null){
        $this->field_controller = new RB_Field_Factory($this->field_id, $value, $this->control_settings);
    }

    public function render_field_controller($wp_object){
        $this->field_controller->set_value($this->get_value($wp_object));
        $this->field_controller->render($wp_object);
    }

    public function get_sanitized_value($value){
        return $this->field_controller->get_sanitized_value(parent::get_sanitized_value($value), array(
            'unslash_group'                 => true,
            'escape_child_slashes'          => true,
            'unslash_repeater_slashes'      => true,
            'unslash_single_repeater'       => true,
        ));
    }

    public function set_field_id($field_id){
        parent::set_field_id($field_id);
        $this->field_controller->set_id($field_id);
    }
}

class RB_Post_Meta_Control extends RB_Meta_Control{
    use RB_Post_Methods;

    public function __construct($meta_id, $control_settings, $args = array()) {
        parent::__construct($meta_id, "post", $control_settings, $args);
    }
}

class RB_Term_Meta_Control extends RB_Meta_Control{
    use RB_Term_Methods;

    public function __construct($meta_id, $control_settings, $args = array()) {
        parent::__construct($meta_id, "term", $control_settings, $args);
    }
}
