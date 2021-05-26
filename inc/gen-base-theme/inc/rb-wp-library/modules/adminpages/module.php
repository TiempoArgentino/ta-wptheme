<?php
/*The RB_Admin_Pages_Module contains all functionalities related to managing
wordpress admin pages, from editing already existing pages, to creating a new
submenu with subpages, and easily hooking functions to them*/

class RB_Admin_Pages_Module extends RB_Framework_Module{
    static public $dependencies = array();

    static public function initialize(){
        if(!self::are_dependencies_loaded(self::$dependencies))
            self::load_dependencies(self::$dependencies);

        self::define_constants();
        self::require_classes();
    }

    // =============================================================================
    // CONSTANTS
    // =============================================================================
    static private function define_constants(){
        define('RB_ADMIN_PAGES_PATH', RB_Wordpress_Framework::get_module_path("adminpages") );
        define('RB_ADMIN_PAGES_URI',  RB_Wordpress_Framework::get_module_uri("adminpages") );
    }

    // =========================================================================
    // CLASSES
    // =========================================================================
    static private function require_classes(){
        require RB_ADMIN_PAGES_PATH . '/inc/RB_Admin_Panel_Manager.php';
        require RB_ADMIN_PAGES_PATH . '/inc/RB_Admin_Menu_Item.php';
        require RB_ADMIN_PAGES_PATH . '/inc/RB_Admin_Submenu.php';
        require RB_ADMIN_PAGES_PATH . '/inc/RB_Admin_Submenu_Page.php';
    }
}

RB_Admin_Pages_Module::initialize();
