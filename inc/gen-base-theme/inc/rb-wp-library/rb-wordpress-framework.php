<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(defined('RB_WPL_VERSION'))
    return;

// =============================================================================
// CONSTANTS
// =============================================================================
define('RB_WPL_VERSION', '0.1.0');
define('RB_WPL_PATH',  dirname(__FILE__) );

// =============================================================================
// COMMONS
// =============================================================================
require_once RB_WPL_PATH . '/inc/rb-functions.php';
require_once RB_WPL_PATH . '/inc/RB_Globals.php';

define('RB_WPL_URI',  get_template_directory_uri() . '/inc/rb-wordpress-library');
define('RB_WPL_COMMONS_URI', get_template_directory_uri() . '/inc/rb-wordpress-library/commons');
define('RB_WPL_IS_THEME', rb_is_theme_file(__FILE__));

// =============================================================================
// FRAMEWORK
// =============================================================================
if(!class_exists('RB_Wordpress_Framework')){
    class RB_Wordpress_Framework{
        static private $modules_loaded = array();

        static public function get_framework_path($path = ''){
            return RB_WPL_PATH . $path;
        }

        static public function get_framework_uri($path = ''){
            return RB_WPL_URI . $path;
        }

        static public function module_exists($module_name){
            return file_exists(self::get_module_path($module_name));
        }

        static public function get_module_path($module_name){
            return self::get_framework_path('/modules') . "/$module_name";
        }

        static public function get_module_uri($module_name){
            return self::get_framework_uri('/modules') . "/$module_name";
        }

        static public function module_is_loaded($module_name = ''){
            return isset($modules_loaded[$module_name]);
        }

        static public function load_module($module_name){
            if(self::module_is_loaded($module_name))
                return false;
            $module_file = self::get_module_path($module_name) . "/module.php";
            if(!file_exists($module_file))
                return false;
            require_once $module_file;
            $modules_loaded[$module_name] = true;
            return true;
        }
    }

    require RB_WPL_PATH . '/inc/RB_Framework_Module.php';
	require RB_WPL_PATH . '/inc/RB_Filters_Manager.php';
	RB_Wordpress_Framework::load_module('wplists');
}
