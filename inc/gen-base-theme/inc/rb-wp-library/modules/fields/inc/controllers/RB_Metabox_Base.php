<?php
/**
*   Primary metabox field manager class. Stores the metabox data and the control settings.
*   The method register must be runned for it register the metabox
*
*/
abstract class RB_Metabox_Base{
    public $meta_id;
    public $metabox_settings = array(
        'title'         => '',
        'admin_page'	=> 'post',
        'context'		=> 'advanced',
        'priority'		=> 'default',
        'classes'		=> '',
        'column'        => null,
    );

    public $custom_content = null;
    public $sanitize_value = null;

    /**
    *   @param string   $meta_id                                  Key for the meta to store
    *   @param mixed[]  $metabox_settings                         Options for the metabox
    *   @param mixed[]  $control_settings                         Options for the metabox
    */
    public function __construct($meta_id, $metabox_settings, $control_settings = null) {
        $this->metabox_settings = array_merge($this->metabox_settings, $metabox_settings);
        $this->control_settings = $control_settings;
        $this->meta_id = $this->metabox_settings['meta_id'] = $meta_id;
        $this->custom_content = isset($this->metabox_settings['custom_content']) ? $this->metabox_settings['custom_content'] : $this->custom_content;
        $this->sanitize_value = isset($this->metabox_settings['sanitize_value']) ? $this->metabox_settings['sanitize_value'] : $this->sanitize_value;
    }

    // Sets the field controller and registers the metabox using the child methods
    public function register(){
        $this->set_metafield();
        $this->register_metabox();
    }

    // Should store in $this->meta_field a RB_Meta_Control
    abstract protected function set_metafield();

    // Should enqueue the metabox to the corresponding filter/actions
    abstract protected function register_metabox();

    // =========================================================================
    // METABOX SETUP
    // =========================================================================

    // Renders the control passing a wordpress object
    public function render_meta_field($wp_object){
        ob_start();
        if(is_callable($this->custom_content))
            call_user_func($this->custom_content, $wp_object);
        else
            $this->meta_field->render_meta_field($wp_object);
        echo apply_filters( "rb_metabox_render__$this->meta_id", ob_get_clean(), $this, $wp_object );
    }

    // =========================================================================
    // METHODS
    // =========================================================================

    /**
    *   @return mixed[] returns a set of arguments to pass to the field on set_metafield
    */
    public function get_field_args(){
        return array(
            'sanitize_value'    => $this->sanitize_value,
        );
    }

    /**
    *   @return string the metabox's title
    */
    public function get_title(){
        return isset($this->metabox_settings['title']) ? $this->metabox_settings['title'] : '';
    }

    /**
    *   @return string[] Returns the admin pages where this metabox will be added
    */
    public function get_admin_pages(){
        return is_array($this->metabox_settings['admin_page']) ? $this->metabox_settings['admin_page'] : [$this->metabox_settings['admin_page']];
    }

    /**
    *   @param int      $wp_object_id                               The object ID
    *   @return bool                                                Shuld indicate wheter the meta exists for a $wp_object
    */
    abstract public function meta_exists($wp_object_id);

    /**
    *   @param          $wp_object
    *   @return mixed                                               Should return the wp object based
    */
    abstract public function get_object($wp_object);

    /**
    *   @param          $wp_object
    *   @return mixed                                               Should return the value for the meta of the $wp_object
    */
    abstract public function get_value($wp_object);

}
