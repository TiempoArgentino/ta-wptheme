<?php

// =============================================================================
// SINGLE
// =============================================================================
class RB_Single_Field{
    public $id;
    public $settings = array();
    public $type = 'RB_Input_Control';
    public $value = '';
    public $control_settings;

    public function __construct($id, $value, $control_settings, $type = 'RB_Input_Control', $settings = array()) {
        $this->id = $id;
        $this->value = $value;
        //var_dump($value);
        if( ($value == null) && is_array($control_settings) && isset($control_settings['default']) ){
            $this->value = $control_settings['default'];
            $this->default_value = $control_settings['default'];
        }
        $this->control_settings = $control_settings;
        $this->control_settings['id'] = $this->id;
        $this->type = $type;
        $this->settings = wp_parse_args($this->settings, $settings);
        $this->generate_renderer();
    }

    public function render($post = null){
        if( $this->renderer ){
            ?>
            <div class="rb-form-control-single-field rb-form-control" data-dependencies="<?php echo esc_attr($this->get_field_dependencies_attr()); ?>">
                <div class="rb-collapsible-body control-content">
                <?php
                $this->print_action_controls();
                $this->renderer->print_control($post);
                ?>
                </div>
                <?php $this->print_value_input(); ?>
            </div>
            <?php
        }
    }

    //Returns the value of one of the repeater settings
    public function get_setting( $name ){
        $setting = '';
        if( isset($this->settings[$name]) )
            $setting = $this->settings[$name];
        return $setting;
    }

    //Will print the control value input for this single field
    //Doesnt do anything as of now
    public function print_value_input(){
        return false;
        ?>
        <input
        class="<?php echo RB_Field_Factory::get_input_class_link(); ?>"
        rb-control-final-value
        name="<?php echo $this->id; ?>"
        value="<?php echo $this->value; ?>"
        type="hidden"></input>
        <?php
    }

    public function print_action_controls(){
        $action_controls = $this->get_setting('action_controls');
        if( is_array($action_controls) && !empty($action_controls) ):
        ?>
            <div class="action-controls">
                <?php if( in_array('delete_button', $action_controls) ): ?>
                <div class="delete-button">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <?php endif; ?>
            </div>
        <?php
        endif;
    }

    //Saves in $this->renderer the object that renders the control
    public function generate_renderer(){
        if(class_exists($this->type) && method_exists($this->type, 'render_content'))
            $this->renderer = new $this->type( $this->value, $this->control_settings);
        else
            $this->renderer = null;
    }

    public function get_field_dependencies_attr(){
        if(!isset($this->control_settings['dependencies']))
            return '';

        $dependecies = array();
        $has_operator = isset($this->control_settings['dependencies'][1]) && is_array($this->control_settings['dependencies'][1]) && is_string($this->control_settings['dependencies'][0]);
        $dependecies[0] = $has_operator ? $this->control_settings['dependencies'][0] : 'AND';
        $dependecies[1] = $has_operator ? $this->control_settings['dependencies'][1] : $this->control_settings['dependencies'];

        return json_encode($dependecies);
    }
}

// =============================================================================
// GROUP
// =============================================================================
class RB_Group_Field{
    public $id;
    public $settings = array();
    public $value = array();
    public $controls;
    public $collapsible = false;

    /**
    * @param array $value
    *   Controls values.
    *   array( $control_id => $control_value, ... )
    * @param array $controls
    *   Controls information. One value for each control.
    *   array( $control_id => $control_settings, ... )
    */
    public function __construct($id, $value, $controls, $settings = array()) {
        $this->id = $id;
        $this->value = $value;
        $this->sanitize_value();
        $this->controls = $controls;
        $this->settings = wp_parse_args($this->settings, $settings);
        $this->collapsible = isset($settings['collapsible']) && $settings['collapsible'] ? $settings['collapsible'] : false;
    }


    /*The value of a group must be an array of controls values. This is taken
    *care of once the group value has been submited, when the environment compability
    *functions (customizer,taxonomy,attachment) sanitize the value before storing it.
    *When the control is used outside of a registered environment, the value doesn't get
    *sanitized, wich causes it to be a json string*/
    public function sanitize_value(){
        if(is_string($this->value)){
            $json_value = json_decode($this->value, true);
            if(json_last_error() == JSON_ERROR_NONE)
                $this->value = $json_value;
        }
    }

    //Renders the repeater html
    public function render($post = null){
        $collapsible_class = $this->collapsible ? 'rb-collapsible' : '';
        $value_is_set = is_array($this->value) && !empty($this->value);

        ?>
        <div data-id="<?php echo $this->id; ?>" class="rb-form-control-group-field rb-form-control <?php echo $collapsible_class; ?>">
            <?php $this->print_group_value_input(); ?>
            <?php
                if( $this->collapsible )
                    $this->print_collapsible_header();
            ?>
            <div class="rb-collapsible-body control-content">
                <?php
                    if( !$this->collapsible && isset($action_controls) && is_array($action_controls) )
                        $this->print_action_controls( $action_controls );
                ?>
                <div class="controls">
                <?php
                foreach($this->controls as $control_ID => $control){
                    $def_control_settings = array(
                        'type'          => 'RB_Input_Control',
                        'controls'      => null,
                        'field_class'   => '',
                    );
                    $control_settings = array_merge($def_control_settings, $control);

                    $control_settings['id'] = $this->get_input_id($control_ID);
                    $control_value = $value_is_set && isset($this->value[$control_ID]) ? $this->value[$control_ID] : '';
                    $control_type = $control_settings['type'];

                    if( $control_settings['controls'] ){
                        $field_controller = new RB_Field_Factory($control_settings['id'], $control_value, $control_settings);
                    }
                    else{
                        $field_controller = new RB_Single_Field($control_settings['id'], $control_value, $control_settings, $control_type);
                    }

                    $class = $this->get_setting('field_classes') . ' ' . $control_settings['field_class'];
                    ?>
                    <div class="group-control-single <?php echo $class; ?>" data-id="<?php echo $control_ID; ?>">
                        <?php $field_controller->render($post); ?>
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
        </div>
        <?php
    }

    //Gets one of the repeaters controls id, sufixing the control_id to the repeater_id
    public function get_input_id($control_id){
        return $this->id . '-' . $control_id;
    }

    public function print_group_value_input(){
        ?>
        <input
        class="<?php echo RB_Field_Factory::get_input_class_link(); ?>"
        rb-control-group-value
        name="<?php echo $this->id; ?>"
        value="<?php echo esc_attr(json_encode($this->value, JSON_UNESCAPED_UNICODE)); ?>"
        type="hidden"></input>
        <?php
    }

    public function get_setting( $name ){
        $setting = '';
        if( isset($this->settings[$name]) )
            $setting = $this->settings[$name];
        return $setting;
    }

    // =============================================================================
    //
    // =============================================================================
    public function print_action_controls(){
        $action_controls = $this->get_setting('action_controls');
        if( is_array($action_controls) && !empty($action_controls) ):
        ?>
            <div class="action-controls">
                <?php if( in_array('delete_button', $action_controls) ): ?>
                <div class="delete-button">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <?php endif; ?>
            </div>
        <?php
        endif;
    }
    // =========================================================================
    // COLLAPSIBLE
    // =========================================================================
    public function print_collapsible_header( $options = array() ){
        $defaults = array(
            'title' => $this->settings['title'] ? $this->settings['title'] : 'Item',
            'link'  => '',
        );
        $settings = $defaults;
        if( is_array($this->collapsible) )
            $settings = array_merge($settings, $this->collapsible);

        ?>
        <div class="rb-collapsible-header container">
            <h1 data-title="<?php echo $settings['title']; ?>" class="title"><?php echo $settings['title']; ?></h1>
            <?php $this->print_action_controls(); ?>
        </div>
        <?php
    }
}

// =============================================================================
// REPEATER
// =============================================================================
class RB_Repeater_Field{
    public $id;
    public $settings = array();
    public $value = array();
    public $controls = array();
    public $items_settings = array();
    public $render_nonce = true;

    public function __construct($id, $value, $controls, $items_settings = array(), $settings = array()) {
        $this->id = $id;
        $this->value = $value;
        $this->sanitize_value();
        $this->controls = $controls;
        $this->items_settings = $items_settings;
        $this->settings = wp_parse_args($this->settings, $settings);
    }

    /*The value of a repeater must be an array of controls values. This is taken
    *care of once the repeater value has been submited, when the envirioment compability
    *functions (customizer,taxonomy,attachment) sanitize the value before storing it.
    *When the control is used outside of a registered envirioment, the value doesn't get
    *sanitized, wich causes it to be a json string*/
    public function sanitize_value(){
        if(is_string($this->value)){
            $json_value = json_decode($this->value, true);
            if(json_last_error() == JSON_ERROR_NONE)
                $this->value = $json_value;
        }
    }

    public function render($post = null){
        $max_fields = $this->get_max_amount_of_fields();
        ?>
        <div class="rb-form-control-repeater-container">
            <div class="rb-form-control-repeater <?php echo $this->get_repeater_classes(); ?>" data-max="<?php echo $max_fields; ?>"
            data-id="<?php echo $this->id; ?>" data-type="<?php echo $this->get_repeater_type(); ?>" <?php echo $this->get_dinamic_title_attr(); ?>
            <?php echo $this->get_base_title_attr(); ?>>
                <div class="empty-control">
                    <?php $this->print_item('(__COUNTER_PLACEHOLDER)', '', $post); ?>
                </div>
                <!-- REPEATER VALUE -->
                <?php $this->print_field_value_input(); ?>
                <!-- NONCE -->
                <?php if($this->render_nonce) wp_nonce_field( basename( __FILE__ ), $this->id . '_nonce' ); ?>
                <!-- REPEATER CONTROLS -->
                <div class="controls" <?php echo $this->get_accordion_attr(); ?>>
                <?php
                $this->item_index = 1;
                if(is_array($this->value)){
                    foreach($this->value as $value){
                        $this->print_item($this->item_index, $value, $post);
                        $this->item_index++;
                        if($max_fields && ($this->item_index > $max_fields))
                            break;
                    }
                }
                //There is not a value to work on
                else{
                    //prints an empty first item
                    $this->print_item('1', '', $post);
                }
                ?>
                </div>
                <!-- End controls -->
                <?php $this->print_empty_message(); ?>
                <!-- End empty message -->
                <div class="repeater-add-button">
                    <i class="add-button fas fa-plus"></i>
                </div>
            </div>
        </div>
        <?php
    }

    public function print_field_value_input(){
        ?>
        <input
        class="<?php echo RB_Field_Factory::get_input_class_link(); ?>"
        rb-control-repeater-value
        name="<?php echo $this->id; ?>"
        value="<?php echo esc_attr(json_encode($this->value, JSON_UNESCAPED_UNICODE)); ?>"
        type="hidden" ></input>
        <?php
    }

    public function get_max_amount_of_fields(){
        return isset($this->settings['max']) && is_int($this->settings['max']) && $this->settings['max'] > 1 ? $this->settings['max'] : null;
    }

    public function get_repeater_classes(){
        $class = '';
        if(isset($this->settings['sortable']))
            $class .= !$this->settings['sortable'] ? 'no-sortable' : '';
        return $class;
    }

    public function get_item_as_string($item_index, $item_value, $post = null){
        ob_start();
        $this->print_item($item_index, $item_value, $post);
        return ob_get_clean();
    }

    public function print_item($item_index, $item_value, $post = null){
        $renderer = null;
        $item_id = $this->id  . '__' . $item_index;

        if( $this->is_group() ){
            $renderer = new RB_Group_Field($item_id, $item_value, $this->controls, array(
                'title'             => str_replace('($n)',$item_index,$this->get_setting('item_title')),
                'collapsible'       => $this->get_items_setting('collapsible'),
                'action_controls'   => array('delete_button'),
            ));
        }
        else{
            $control_settings = reset($this->controls);
            if( isset($control_settings['controls']) && $control_settings['controls'] ){
                $renderer = new RB_Field_Factory($item_id, $item_value,$control_settings);
            }
            else{
                $control_settings = reset($this->controls);//First item in the controls array
                $control_type = $control_settings['type'] ? $control_settings['type'] : 'RB_Input_Control';
                $renderer = new RB_Single_Field($item_id, $item_value, $control_settings, $control_type, array(
                    //'title'             => str_replace('($n)',$this->item_index,$this->get_setting('item_title')),
                    'action_controls'   => array('delete_button'),
                ));
            }
        }

        if($renderer)
            $renderer->render($post);
    }
    // =========================================================================
    // ATTRIBUTES
    // =========================================================================
    public function get_accordion_attr(){
        return $this->get_setting('accordion') ? 'data-rb-accordion' : '';
    }

    public function get_dinamic_title_attr(){
        return $this->get_setting('title_link') ? 'data-title-link="'. $this->settings['title_link'] . '"' : '';
    }

    public function get_base_title_attr(){
        return $this->get_setting('item_title') ? 'data-base-title="'.$this->settings['item_title'].'"' : '';
    }

    // =========================================================================
    //
    // =========================================================================
    public function print_empty_message(){
        ?>
        <div class="rb-repeater-empty-message">
            <?php
            $message = $this->get_setting('empty_message');
            $message = $message ? $message : 'Click on the button below to start adding content';
            //If the message is a function
            if( is_callable($message) )
                $message($message);
            //If the message is a string
            else if ( is_string($message) ):
            ?>
                <p><?php echo $message; ?></p>
            <?php
            endif;
            ?>
        </div>
        <?php
    }
    // =========================================================================
    // INFORMATION GETTERS
    // =========================================================================
    function get_repeater_type(){
        return $this->is_group() ? 'group' : 'single';
    }

    //If the repeater is items are groups on inputs
    public function is_group(){
        return is_array($this->controls) && count($this->controls) > 1;
    }

    //Returns the value of one of the items settings
    public function get_items_setting( $name ){
        $setting = isset($this->items_settings[$name]) ? $this->items_settings[$name] : '';
        return $setting;
    }

    //Retruns the value of one of the repeater settings
    public function get_setting( $name ){
        $setting = '';
        if( isset($this->settings[$name]) )
            $setting = $this->settings[$name];
        return $setting;
    }

}

// =============================================================================
// CONTROLLER
// =============================================================================
class RB_Field_Factory{
    public $id;
    public $type;
    public $value;
    public $render_nonce = false;
    public $title;
    public $settings = array(
        'title'	        => '',
        'label'			=> '',
        'classes'		=> '',
        'type'          => 'RB_Input_Control',
        'input_type'    => 'text',
        'item_title'    => 'Item',
        'collapsible'   => false,
        'repeater'      => false,
    );

    public function __construct($id, $value, $options = array()) {
        $this->settings = array_merge($this->settings, $options);
        $this->id = $this->settings['id'] = $id;
        $this->controls = $this->settings['controls'];
        $this->type = $this->settings['type'];
        $this->title = $this->settings['title'];
        $this->collapsible = $this->settings['collapsible'];
        $this->value = $value;
    }

    // =========================================================================
    // GETTERS
    // =========================================================================
    public function is_group(){
        return is_array($this->controls) && count($this->controls) > 1;
    }

    public function is_repeater(){
        return $this->settings['repeater'] == true;
    }

    //Retruns the value of one of the settings
    public function get_setting( $name ){
        $setting = '';
        if( isset($this->settings[$name]) )
            $setting = $this->settings[$name];
        return $setting;
    }
    // =========================================================================
    // METHODS
    // =========================================================================

    //Renders the controller accordingly to the settings passed
    public function render($post = null){
        $this->generate_control();
        $title = $this->get_setting('title');
        $description = $this->get_setting('description');
        $is_collapsible = $this->get_setting('collapsible');
        $collapsible_cont_class = $is_collapsible ? 'rb-collapsible' : '';
        $collapsible_header_class = $is_collapsible ? 'rb-collapsible-header' : '';
        $collapsible_body_class = $is_collapsible ? 'rb-collapsible-body' : '';
        ?>
        <div class="rb-form-field-controller-container <?php echo $collapsible_cont_class; ?>">
            <div class="rb-form-field-controller-header <?php echo $collapsible_header_class; ?>">
                <?php if($title): ?>
                    <p class="header-title"><?php echo esc_html($title); ?></p>
                <?php endif; ?>
                <?php if($is_collapsible): ?>
                    <div class="collapsible-trigger action-controls">
                        <div class="action-button trigger-button"><i class="fas fa-caret-down"></i></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="rb-form-field-controller-body <?php echo $collapsible_body_class; ?>">
                <?php if($description): ?>
                <div class="rb-form-field-controller-description">
                    <p class="header-description"><?php echo esc_html($description); ?></p>
                </div>
                <?php endif; ?>
                <div class="rb-form-field-controller-control">
                <?php
                    if( !$this->is_repeater() && $this->render_nonce )
                        wp_nonce_field( basename( __FILE__ ), $this->id . '_nonce' );

                    $this->rb_control_field->render($post);
                ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function get_as_html($post = null){
        ob_start();
        $this->render($post);
        return ob_get_clean();
    }

    //Creates the control based of the information provided, and stores it in $this->rb_control_field
    public function generate_control($args = array()){
        /*Generate a repeater*/
        if($this->is_repeater()){
            $repeater_settings = is_array($this->settings['repeater']) ? $this->settings['repeater'] : array();
            $this->rb_control_field = new RB_Repeater_Field($this->id, $this->value, $this->controls, $items_settings = array(
                'collapsible'   => true,
            ), $repeater_settings);
        }
        //Renders the controls in the controls array
        else if( $this->is_group() ){
            if( is_array($this->settings['controls']) ){
                $group_settings = isset($args['group_settings']) && is_array($args['group_settings']) ? $args['group_settings'] : array();
                $this->rb_control_field = new RB_Group_Field($this->id, $this->value, $this->settings['controls'], $group_settings);
            }
        }
        //Generates the controler when only one control was provided
        else{
            $control_settings = is_array($this->controls) ? reset($this->controls) : array();//First item in the controls array
            $control_settings['id'] = $this->id;
            $control_type = isset($control_settings['type']) && $control_settings['type'] ? $control_settings['type'] : 'RB_Input_Control';
            $this->rb_control_field = new RB_Single_Field($this->id, $this->value, $control_settings, $control_type);
        }
    }

    public function get_group_value(){
        $value = array();
        foreach($this->settings['controls'] as $control_ID => $control_data){
            $field_name = $this->id . '-' . $control_ID;
            if(isset($_POST[$field_name]))
                $value[$control_ID] = $_POST[$field_name];
        }
        return $value;
    }

    public function get_sanitazed_value($value){
        $isset_value = isset($value);

        if( $this->is_repeater() ){
            $sanitized_value = array();
            if( $isset_value ){
                if( $this->is_group() )
                    $sanitized_value = json_decode($value, true);
                else
                    $sanitized_value = json_decode($value, true);
            }
        }
        //If a group of inputs controls were used
        else if( $this->is_group() ){
            $sanitized_value = array();
            if($isset_value)
                $sanitized_value = $this->get_group_value();
        }
        //If a single input control was used
        else{
            /* Get the posted data */
            if(isset($this->rb_control_field) && $this->rb_control_field->renderer->strict_type == 'bool')
                $sanitized_value = $isset_value ? true : false;
            else
                $sanitized_value = $isset_value ? $value : null;
        }

        return $sanitized_value;
    }

    // =========================================================================
    // VALUE RELATION LINKS
    // =========================================================================
    final static function get_input_class_link(){
        return 'wpb_vc_param_value';
    }

    final static function get_control_input_link(){
        return "rb-control-value";
    }
}
