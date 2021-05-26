<?php
class RB_Customizer_Field_Control extends WP_Customize_Control{
    public $controls;

    public function __construct($manager, $id, $args = array()){
        parent::__construct($manager, $id, $args);
        $this->setting = $manager->get_setting($id);
        if($this->setting)
            $this->setting->rb_cutomizer_control = true;
        $this->options = $args;
        $this->options['meta_id'] = $id;

        $this->field_controller = new RB_Field_Factory($this->id, $this->sanitazed_value(), $this->options);
        $this->add_rb_sanitazion();
    }

    public function get_input_link(){
        ob_start();
        $this->link();
        return ob_get_clean();
    }

    public function sanitazed_value(){
        $value = $this->value();//get_theme_mod($this->id, null)
        /*If is group
         if( is_array($this->controls) && count($this->controls) > 1 ){
             $value = json_decode($value, true);
        }*/
        return $value;
    }

    public function render_content(){
        ?>
        <div class="rb-customizer-control">
            <?php $this->field_controller->render(); ?>
            <input rb-customizer-control-value type='hidden' <?php $this->link(); ?>>
        </div>
        <?php
    }

    public function add_rb_sanitazion(){
        //print_r("Customizer sanitation of: $this->id \n");
        add_action( "customize_sanitize_$this->id", function($value) {
            $new_meta_value = $this->field_controller->get_sanitized_value($value);
            return $new_meta_value;
        });
    }
}
