<?php

// =============================================================================
// SINGLE FIELD
// =============================================================================
class RB_Single_Field extends RB_Field{
    public $default_type = 'RB_Input_Control';

    public function __construct($id, $value, $settings = array(), $control = array()) {
        parent::__construct($id, $value, $settings);
        $this->control = $control;
        $this->value = $this->get_value();
    }

    public function render_field($post = null){
        ?>
        <div class="control-content">
        <?php
            $this->generate_renderer();
            if($this->renderer)
                $this->renderer->print_control($post);
        ?>
        </div>
        <?php
    }

    public function get_container_class(){ return "rb-single-field"; }

    public function get_value(){
        if( !isset($this->value) && is_array($this->control) && isset($this->control['default']) )
            return $this->control['default'];
        return $this->value;
    }

    public function get_id(){ return $this->id; }

    //Saves in $this->renderer the object that renders the control
    public function generate_renderer(){
        $control_class = is_array($this->control) && isset($this->control['type']) && is_string($this->control['type']) ? $this->control['type'] : $this->default_type;
        if($control_class && class_exists($control_class) && method_exists($control_class, 'render_content')){
            $this->control['type'] = $control_class;
            $this->control['id'] = $this->get_id();
            $this->renderer = new $control_class( $this->get_value(), $this->control);
        }
        else
            $this->renderer = null;
    }

    public function get_sanitized_value($value){
        return is_array($value) || is_object($value) ? '' : $value;
    }

}
