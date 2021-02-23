<?php

// =============================================================================
// GROUP FIELD
// =============================================================================
class RB_Group_Field extends RB_Field{

    /**
    * @param array $value
    *   Controls values.
    *   array( $control_id => $control_value, ... )
    * @param array $controls
    *   Controls information. One value for each control.
    *   array( $control_id => $control_settings, ... )
    */
    public function __construct($id, $value, $settings = array(), $controls = array()) {
        parent::__construct($id, $value, $settings);
        $this->controls = $controls;
        $this->sanitize_value();
    }

    // =========================================================================
    // GETTERS
    // =========================================================================

    public function get_child_settings($control_ID){
        return isset($this->controls[$control_ID]) ? $this->controls[$control_ID] : null;
    }

    /*Creates and returns the renderer for one of the child fields*/
    public function get_child_field_renderer($control_ID, $control_settings){
        $child_id = $this->get_input_id($control_ID);
        $child_value = $this->get_child_field_value($control_ID);
        $controller_settings = isset($control_settings['controller']) ? $control_settings['controller'] : array();
        $controller_settings['controls'] = isset($control_settings['controls']) ? $control_settings['controls'] : array($control_ID => $control_settings);
        //print_r($controller_settings);
        return new RB_Field_Factory($child_id, $child_value, $controller_settings);
    }

    //Gets one of the group controls id, sufixing the control_id to the repeater_id
    public function get_input_id($control_id){ return $this->id . '-' . $control_id; }

    public function get_child_field_value($control_id, $default = null){
        return is_array($this->value) && isset($this->value[$control_id]) ? $this->value[$control_id] : $default;
    }

    public function get_container_class(){ return "rb-group-field"; }

    public function get_container_attr(){ return 'data-id="'. esc_attr($this->id) .'"'; }

    // =========================================================================
    // METHODS
    // =========================================================================

    /*The value of a group must be an array of controls values. This is taken
    *care of once the group value has been submited, when the environment compability
    *functions (customizer,taxonomy,attachment) sanitize the value before storing it.
    *When the control is used outside of a registered environment, the value doesn't get
    *sanitized, wich causes it to be a json string*/
    public function sanitize_value(){
        $this->value = $this->get_sanitized_value($this->value);
    }

    public function get_sanitized_value($value, $args = array()){
        $settings = array(
            //Wheter to escape the child value slashes or not. Useful when there is
            //no control over the save method, and it escapes the value slashes (as update_metabox does)
            'unslash_group'             => false,
            'escape_child_slashes'      => false,
            'settings_to_child'         => true,
        );
        $settings = array_merge($settings, $args);
        //print_r($this->id); echo "<br>";
        //if($this->id == 'rb-test-groups-repeater-0'){echo "------------Values for $this->id GROUP--------------<br><br>\n";}
        //if($this->id == 'rb-test-groups-repeater-0'){print_r($args); echo "<br>";}
        //if($this->id == 'rb-test-groups-repeater-0'){echo "New value: "; var_dump($value); echo "<br><br>\n";}
        if(is_string($value)){
            $json_value = $settings['unslash_group'] ? wp_unslash($value) : $value;
            //if($this->id == 'rb-test-groups-repeater'-0){echo "Unslashed value: "; var_dump($json_value); echo "<br><br>\n";}
            $json_value = json_decode($json_value, true);
            //if($this->id == 'rb-test-groups-repeater-0'){echo "JSON Error: "; var_dump(json_last_error()); ; echo "<br><br>\n";}
            // Sanitize child value using child controller sanitization function
            if(is_array($json_value)){
                foreach($json_value as $child_id => $child_value){
                    $child_settings = $this->get_child_settings($child_id);
                    $child_value = $settings['escape_child_slashes'] ? wp_slash($child_value) : $child_value;
                    $child_controller = $child_settings ? $this->get_child_field_renderer($child_id, $child_settings) : null;
                    $child_sanitation_settings = $settings['settings_to_child'] ? $settings : array();
                    $json_value[$child_id] = $child_controller ? $child_controller->get_sanitized_value($child_value, $child_sanitation_settings) : null;
                }
            }
            if(json_last_error() == JSON_ERROR_NONE)
                $value = $json_value;
        }

        //if($this->id == 'rb-test-groups-repeater-0'){echo "JSON Error: "; var_dump(json_last_error()); echo "<br><br>\n";}
        //if($this->id == 'rb-test-groups-repeater-0'){echo "Sanitized value: "; print_r($value); echo "<br><br>\n";}

        return $value;
    }

    public function print_group_value_input(){
        ?>
        <input
        class="<?php echo RB_Field_Factory::get_input_class_link(); ?>"
        rb-control-group-value
        rb-control-value
        name="<?php echo $this->id; ?>"
        value="<?php echo esc_attr(json_encode($this->value, JSON_UNESCAPED_UNICODE)); ?>"
        type="hidden"></input>
        <?php
    }

    public function render_field($post = null){
        if(is_array($this->controls)):
        ?>
        <div class="controls">
            <?php
            foreach($this->controls as $control_ID => $control){
                $rb_child_field = $this->get_child_field_renderer($control_ID, $control);
                ?>
                <div class="group-child-control" data-id="<?php echo $control_ID; ?>">
                    <?php $rb_child_field->render($post); ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php $this->print_group_value_input(); ?>
        <?php
        endif;
    }
}
