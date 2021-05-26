<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

define('GEN_FOLDER_PATH', get_template_directory() . '/inc/gen-base-theme');
define('GEN_FOLDER_URI', get_template_directory_uri() . '/inc/gen-base-theme');
define('GEN_THEME_PATH', get_template_directory());
define('GEN_THEME_URL', get_template_directory_uri());
define('GEN_CHILD_PATH', get_stylesheet_directory());
define('GEN_CHILD_URL', get_stylesheet_directory_uri());
define('GEN_CSS_URL', GEN_FOLDER_URI . '/css');
define('GEN_NO_DASH_POST_TYPE', true);
define('GEN_NO_DASH_TAXONOMY_NAME', true);
define('GEN_MODULES_PATH', GEN_FOLDER_PATH . "/inc/modules");
define('GEN_MODULES_URI', GEN_FOLDER_URI . "/inc/modules");
define('GEN_CLASSES_PATH', GEN_FOLDER_PATH . "/inc/classes");

class GEN_Theme{
	static private $initialized = false;

	static public function initialize(){
		if( self::$initialized )
			return false;
		self::$initialized = true;

		require_once GEN_FOLDER_PATH . '/inc/rb-wp-library/rb-wordpress-framework.php';
		require_once GEN_CLASSES_PATH . '/GEN_Modules_Manager.php';

        if(is_admin()){
            RB_Wordpress_Framework::load_module('fields');
			RB_Wordpress_Framework::load_module('wplists');
			RB_Filters_Manager::add_action('gen_base_theme_admin_scripts', 'admin_enqueue_scripts', array(self::class, 'admin_scripts'));
			// require_once GEN_FOLDER_PATH . '/tests/metabox.php';
        }

		RB_Wordpress_Framework::load_module('taxonomies');
		RB_Wordpress_Framework::load_module('posts');
		self::load_module("components");
		self::load_module("entities");
		self::load_module("gutenberg");
		//self::load_module("infinite-scroll");
		// require_once GEN_FOLDER_PATH . '/tests/entities.php';

		RB_Filters_Manager::add_action('gen_after_modules_loaded', 'gen_modules_loaded', function(){
			require_once GEN_FOLDER_PATH . '/tests/columns.php';
		});
		//funciones
		self::wp_theme_support();
	}

	static public function admin_scripts(){
		wp_enqueue_style('gen_base_theme_admin_style', GEN_CSS_URL . '/src/admin.css');
	}

	static public function load_module($module_name){
		GEN_Modules_Manager::load_module($module_name);
	}

	static public function wp_theme_support(){
		add_theme_support( 'title-tag' ); //title html
	}
}
GEN_Theme::initialize();
