<?php
// =============================================================================
// CONTROLS
// =============================================================================
/* Para que un control funcione correctamente, debe tener la function render_content($value, $settings)
/* $value => metabox value
/* $settings => configuracion del control
/* Tiene que tener un input donde se guarde el valor a guardar con las siguientas caracteristicas:
/* <input name="<?php echo $settings->id; ?>" value="<?php echo esc_attr($settings->value); ?>"></input>
*/

abstract class RB_Field_Control{
    public $id;
    public $value;
    public $settings = array(
        'label'         => '',
        'description'   => '',
    );
    //Forces the control value to be of a certain type
    public $strict_type;
    static public $controls;

    public function __construct($value, $settings) {
        $this->value = $value;
        $this->settings = array_merge($this->settings, $settings);
        $this->id = $settings['id'];
        self::$controls[] = $this;
    }

    //Wraps the content of the control and renders it.
    public function print_control($post = null){
        ?><div class="rb-wp-control"><?php $this->render_content($post); ?></div><?php
    }

    //The method that renders the control. Should be overriden by the children
    abstract public function render_content();

    //Prints the control descriptions.
    public function print_control_header(){
        ?>
        <div class="control-header">
            <?php $this->print_label(); ?>
            <?php $this->print_description(); ?>
        </div>
        <?php
    }

    final public function get_description(){
        return isset($this->settings['description']) && is_string($this->settings['description']) ? $this->settings['description'] : '';
    }

    final public function get_label(){
        return isset($this->settings['label']) && is_string($this->settings['label']) ? $this->settings['label'] : '';
    }

    public function print_description(){
        $description = $this->get_description();
        if(isset($this->settings['description']) && is_string($this->settings['description'])):
        ?> <p class="control-description"><?php echo esc_html($this->settings['description']); ?></p> <?php
        endif;
    }

    public function print_label( $for = '' ){
        $for = $for ? $for : $this->id;
        $label = $this->get_label();
        if($label):
        ?> <label class="control-title" for="<?php echo $for; ?>"><?php echo esc_html($this->settings['label']); ?></label> <?php
        endif;
    }

    //Prints the attributes that relates an input with the control value
    //The value should be in this input
    final public function print_input_link(){
        echo $this->get_control_input_link();
    }

    final public function get_control_input_link(){
        return class_exists('RB_Field_Factory') ? RB_Field_Factory::get_control_input_link() : '';
    }

    //Prints special classes for the control's value input
    //Some of the are necessary for the control to work on specefic envirioments,
    //such as Visual Composer.
    //Currenty only for Visual Composer compability
    final public function print_input_classes(){
        echo $this->get_control_input_class();
    }

    final public function get_control_input_class(){
        return class_exists('RB_Field_Factory') ? RB_Field_Factory::get_input_class_link() : '';
    }

    //Returns the control markup as n string
    final public function get_control_markup(){
        ob_start();
        $this->render_content();
        return ob_get_clean();
    }
}
