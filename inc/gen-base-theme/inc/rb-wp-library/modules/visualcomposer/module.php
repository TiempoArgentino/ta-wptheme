<?php

if(!class_exists('RB_VC_Element')){
    /*
    * Facilitates the creation of a Visual Composer element
    */
    class RB_VC_Element{
        private $vc_map_args = array();
        private $renderer = null;

        /**
        *   @param string $slug                 ID of the shortcode. It will automaticly be placed in the
        *                                       $vc_map_args['base'] argument
        *   @param array $vc_map_args           Array of options for the element to create. It contains the
        *                                       params used. Check vc_map documentation for more information https://kb.wpbakery.com/docs/inner-api/vc_map/#vc_map()-ParametersofparamsArray
        *           @param bool is_parent           Used to declare this shortcode as a parent that can contain
        *                                           other elements inside.
        *   @param callable $renderer           Function that returns the control result html for the front-end.
        *                                       Recieves an argument containing the attributes.
        *
        */
        // Element Init
        public function __construct($slug, $vc_map_args, $renderer = null){
            if(!is_string($slug) || !is_array($vc_map_args) || (!shortcode_exists($slug) && !is_callable($renderer)))
                return null;

            $this->slug = $vc_map_args['base'] = $slug;
            $this->vc_map_args = $vc_map_args;
            $this->renderer = $renderer;

            add_action( 'init', array( $this, 'vc_infobox_mapping' ) );
            if(!shortcode_exists($slug))
                add_shortcode( $slug, array( $this, 'vc_infobox_html' ) );
            add_action( 'init', array( $this, 'make_parent' ) );
        }

        // Element Mapping
        public function vc_infobox_mapping() {
            // Stop all if VC is not enabled
            if ( !defined( 'WPB_VC_VERSION' ) ) {
                return;
            }

            // Map the block with vc_map()
            vc_map($this->vc_map_args);
        }

        public function vc_infobox_html($atts, $content = null){
            return call_user_func($this->renderer, $atts, $content);
        }

        public function get_slug_as_class_name(){
            $class_name = $this->slug;
            $class_name[0] = strtoupper($class_name[0]);
            return preg_replace_callback('/(^[a-z0-9_ ]?)?.(?<=_)[a-z]/', function($match) {
                return strtoupper($match[0]);
            }, $class_name);
        }

        public function make_parent(){
            if(class_exists('WPBakeryShortCodesContainer') && isset($this->vc_map_args['is_parent'])){
                $class_name = 'WPBakeryShortCode_' . $this->get_slug_as_class_name();
                eval("class $class_name extends WPBakeryShortCodesContainer{}");
            }
        }
    }
}
