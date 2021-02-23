<?php
class RB_Framework_Module{
    static public function load_dependencies($dependencies){
        if(is_array($dependencies)){
            foreach($dependencies as $module_name){
                RB_Wordpress_Framework::load_module($module_name);
            }
        }
    }

    static public function are_dependencies_loaded($dependencies){
        $loaded = false;
        if(is_array($dependencies)){
            foreach($dependencies as $module_name){
                $loaded = RB_Wordpress_Framework::module_is_loaded($module_name);
                if(!$loaded) break;
            }
        }
        return $loaded;
    }
}
