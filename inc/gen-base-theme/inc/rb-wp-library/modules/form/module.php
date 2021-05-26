<?php

if(!class_exists('RB_Form_Module')){
    class RB_Form_Module{
        static private $initialized = false;

    	static public function initialize(){
    		if(self::$initialized)
    			return false;
            self::$initialized = true;

            require plugin_dir_path(__FILE__) . 'inc/RB_Wordpress_Form_Handler.php';
            require plugin_dir_path(__FILE__) . 'inc/RB_Form.php';
            require plugin_dir_path(__FILE__) . 'inc/RB_Form_Field.php';

            self::enqueue_scripts();
    	}

        static public function form_validation_scripts(){
        	wp_enqueue_script( "rb-wp-form-validation-js", rb_get_file_url(__FILE__) . "/js/rb-form-validator.js", true );
        }

        static public function enqueue_scripts(){
            add_action ("wp_enqueue_scripts", array(self::class, 'form_validation_scripts'));
        }
    }
    RB_Form_Module::initialize();
}
