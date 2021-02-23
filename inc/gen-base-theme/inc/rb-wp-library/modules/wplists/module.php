<?php

if(!class_exists('RB_Objects_Lists')){
    define('RB_OBJECT_LISTS_MASTER_DIR', plugin_dir_path(__FILE__));

    class RB_Objects_Lists{
        static private $initialized = false;

    	static public function initialize(){
    		if(self::$initialized)
    			return false;
            self::$initialized = true;

            require_once RB_OBJECT_LISTS_MASTER_DIR . 'inc/RB_Objects_List_Column.php';
            require_once RB_OBJECT_LISTS_MASTER_DIR . 'inc/RB_Terms_List_Column.php';
            require_once RB_OBJECT_LISTS_MASTER_DIR . 'inc/RB_Posts_List_Column.php';
            require_once RB_OBJECT_LISTS_MASTER_DIR . 'inc/functions.php';
    	}
    }

    RB_Objects_Lists::initialize();
}
