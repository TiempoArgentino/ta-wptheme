<?php
/*
*   Manages the load and removal of modules, and requires the necessary files
*/

class GEN_Modules_Manager{
    static protected $initialized = false;
	static protected $loaded_modules = [];
    // Indicates if the modules have been required and cannot add or remove anymore
    static protected $finished = false;

    static public function initialize(){
        if( self::$initialized )
            return false;
        self::$initialized = true;

        RB_Filters_Manager::add_action('gen_load_modules', 'after_setup_theme', array(self::class, 'require_loaded_modules') );
    }

	static public function get_module_path($module_name){
		return GEN_MODULES_PATH . "/$module_name/module.php";
	}

	static public function module_loaded($module_name){
		return isset(self::$loaded_modules[$module_name]);
	}

	static public function module_exists($module_name){
		return file_exists( self::get_module_path($module_name) );
	}

	static protected function require_module($module_name){
		if( self::module_exists($module_name) )
			require_once self::get_module_path($module_name);
	}

    /**
    *   Enqueues the module to be loaded on require_loaded_modules
    *   @param string $module_name
    */
	static public function load_module($module_name){
        if( !self::$finished )
		      self::$loaded_modules[$module_name] = true;
	}

    /**
    *   If the module is enqueued, it is removed from the queue
    *   @param string $module_name
    */
    static public function remove_module($module_name){
        if( !self::$finished )
            unset(self::$loaded_modules[$module_name]);
    }

    static public function require_loaded_modules(){
        foreach ( self::$loaded_modules as $module_name => $data_placeholder ) {
            self::require_module($module_name);
            do_action("gen_module_{$module_name}_loaded");
        }
        self::$finished = true;
        do_action("gen_modules_loaded");
    }
}
GEN_Modules_Manager::initialize();
