<?php

// =============================================================================
// RB FIELD CONTROLLER
// =============================================================================
class RB_Field_Factory{
    public $settings = array();
    public $controls = null;

    public function __construct($id, $value, $settings = array()) {
        $this->settings = array_merge($this->settings, $settings);
        $this->set_id($id);
        $this->controls = isset($this->settings['controls']) && is_array($this->settings['controls']) ? $this->settings['controls'] : null;
        $this->set_value($value);
        $this->generate_control();
    }

    public function set_id($id){
        $this->id = $this->settings['id'] = $id;
    }

    public function set_value($value){
        $this->value = $value;
    }

    //Renders the controller accordingly to the settings passed
    public function render($post = null){
        //print_r($this->controls);
        $rb_control = $this->generate_control();
        if($rb_control)
            $rb_control->render($post);
    }

    public function generate_control(){
        $this->control = null;
        if($this->is_repeater()){
            $this->control = new RB_Repeater_Field($this->id, $this->value, $this->get_repeater_settings(), $this->settings, $this->controls);
        }
        else if( $this->is_group() ){
            $this->control = new RB_Group_Field($this->id, $this->value, $this->settings, $this->controls);
        }
        //Generates the controler when only one control was provided
        else{
            $this->control = new RB_Single_Field($this->id, $this->value, $this->settings, $this->get_first_control());
        }
        return $this->control;
    }

    // =============================================================================
    // GETTERS
    // =============================================================================

    //Get the first control in the $controls array. The one that would be used in a single field
    public function get_first_control(){
        if(is_array($this->controls))
            foreach($this->controls as $control) return $control;
        return null;
    }

    //Returns the value of one of the settings
    public function get_setting( $name, $default = null ){
        return isset($this->settings[$name]) ? $this->settings[$name] : $default;
    }

    public function get_repeater_settings(){
        return $this->is_repeater() && is_array($this->settings['repeater']) && !empty($this->settings['repeater']) ? $this->settings['repeater'] : array();
    }

    public function get_sanitized_value($value, $args = array()){
        return $this->control->get_sanitized_value($value, $args);
    }

    final static function get_input_class_link(){
        return 'wpb_vc_param_value';
    }

    final static function get_control_input_link(){
        return "rb-control-value";
    }

    // =========================================================================
    // METHODS
    // =========================================================================
    public function is_single(){
        return !$this->is_group() && !$this->is_repeater();
    }

    public function is_group(){
        return (isset($this->settings['group']) && $this->settings['group'] === true) || (is_array($this->controls) && count($this->controls) > 1);
    }

    public function is_repeater(){
        return isset($this->settings['repeater']) &&
        ( $this->settings['repeater'] === true || (is_array($this->settings['repeater']) && !empty($this->settings['repeater'])) );
    }
}
