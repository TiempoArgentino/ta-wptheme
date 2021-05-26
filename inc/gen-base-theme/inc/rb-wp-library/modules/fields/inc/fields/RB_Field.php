<?php

// =============================================================================
// RB FIELD ABSTRACT
// =============================================================================
abstract class RB_Field{
    public $settings = array();

    public function __construct($id, $value, $settings = array()) {
        $this->id = $id;
        $this->value = $value;
        $this->settings = wp_parse_args($this->settings, $settings);
    }

    public function render($post = null){
        $title = $this->get_title();
        ?>
        <div
        id="rb-field-<?php echo $this->id; ?>" data-id="<?php echo $this->id; ?>"
        class="rb-field <?php echo $this->collapsible_class(); ?> <?php echo esc_attr($this->get_container_class()); ?>"
        <?php $this->print_field_dependencies_attr(); ?> <?php echo $this->get_container_attr(); ?>>
            <?php if($title): ?>
            <div class="control-header rb-collapsible-header">
                <h1 class="title"><?php echo esc_html($title); ?></h1>
            </div>
            <?php endif; ?>
            <div class="control-body rb-collapsible-body">
                <?php echo $this->print_description(); ?>
                <?php $this->render_field($post); ?>
            </div>
        </div>
        <?php
    }

    abstract public function render_field($post = null);

    abstract public function get_container_class();

    public function collapsible_class(){
        $class = '';
        if(isset($this->settings['collapsible']) && ( $this->settings['collapsible'] === true || is_array($this->settings['collapsible']) && !empty($this->settings['collapsible']) ) ){
            $class = "rb-collapsible";
            if(isset($this->settings['collapsible']['open']) && $this->settings['collapsible']['open'])
                $class .= " active";
        }
        echo $class;
    }

    public function get_container_attr(){ return ""; }

    public function print_description(){
        $description = $this->get_description();
        if($description):
            if(is_callable($description)):
            ?><div class="control-description"><?php $description(); ?></div><?php
            else:
            ?><p class="control-description"><?php echo esc_html($description); ?></p><?php
            endif;
        endif;
    }

    public function get_description(){
        return isset($this->settings['description']) && (is_string($this->settings['description']) || is_callable($this->settings['description'])) ? $this->settings['description'] : '';
    }

    public function get_title(){
        return isset($this->settings['title']) && is_string($this->settings['title']) ? $this->settings['title'] : '';
    }

    //Returns the value of one of the settings
    public function get_setting( $name, $default = null ){
        return isset($this->settings[$name]) ? $this->settings[$name] : $default;
    }

    public function get_value(){ return $this->value; }

    public function print_field_dependencies_attr(){
        if(!isset($this->settings['dependencies']))
            return '';

        $dependecies_data = array();
        $has_operator = isset($this->settings['dependencies'][1]) && is_array($this->settings['dependencies'][1])
        && is_string($this->settings['dependencies'][0]) && ($this->settings['dependencies'][0] == 'AND' || $this->settings['dependencies'][0] == 'OR');
        $dependecies_data[0] = $has_operator ? $this->settings['dependencies'][0] : 'AND';
        $dependecies_data[1] = $has_operator ? $this->settings['dependencies'][1] : $this->settings['dependencies'];
        $expected_values = array();

        foreach($dependecies_data[1] as $dependency_key => $dependency_value){
            $has_expected_value = !is_int($dependency_key);
            $dependency_name = $has_expected_value ? $dependency_key : $dependency_value;
            $has_not_op = $dependency_name[0] == '!' ? true : false;
            $dependency_name = $has_not_op ? substr($dependency_name, 1) : $dependency_name;
            $expected_value = $has_expected_value ? $dependency_value : !$has_not_op;
            $expected_values[$dependency_name] = $expected_value;
        }

        $dependecies_data[1] = $expected_values;

        if(!empty($expected_values))
            echo 'data-dependencies="'. esc_attr( json_encode($dependecies_data) ).'"';

        if(isset($this->settings['global_dependencies']) && $this->settings['global_dependencies'])
            echo 'data-global-dependencies="1"';
    }
}
