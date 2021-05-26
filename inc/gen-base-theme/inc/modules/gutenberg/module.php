<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GEN_Gutenberg_Build{
	static private $initialized = false;
    static private $build_url = GEN_THEME_URL . '/inc/gutenberg';
	static private $build_path = GEN_THEME_PATH . '/inc/gutenberg';
    static private $block_categories = [];


	static public function initialize(){
		if(self::$initialized)
			return false;
		self::$initialized = true;

		self::main();
	}

    static public function get_dist_url(){
		return self::$build_url . '/dist';
	}

	static public function get_dist_path(){
		return self::$build_path . '/dist';
	}

	static public function get_src_url(){
		return self::$build_url . '/src';
	}

	static public function get_src_path(){
		return self::$build_path . '/src';
	}

	static public function get_blocks_url(){
		return self::get_src_url() . '/blocks';
	}

	static public function get_components_url(){
		return self::get_src_url() . '/components';
	}

	static public function get_helpers_url(){
		return self::get_src_url() . '/helpers';
	}

	static public function get_blocks_path(){
		return self::get_src_path() . '/blocks';
	}

	static public function get_components_path(){
		return self::get_src_path() . '/components';
	}

	static public function get_helpers_path(){
		return self::get_src_path() . '/helpers';
	}

	static public function main(){
		RB_Wordpress_Framework::load_module('gutenberg');
        require_once plugin_dir_path(__FILE__) . 'inc/classes/GEN_Gutenberg_Block.php';

		// ===========================================================================
		// BLOCKS ASSETS
		// ===========================================================================
		// Hook: Block assets.
		RB_Filters_Manager::add_action('gen_blocks_enqueue_blocks_assets', 'init', array(self::class, 'enqueue_blocks_assets'));

		// =============================================================================
		// HOOK BLOCKS PHP
		// =============================================================================
		// self::require_blocks_files();
		self::require_components_files();
		self::require_helpers_files();
	}

	/**
	 * Enqueue Gutenberg block assets for both frontend + backend.
	 *
	 * Assets enqueued:
	 * 1. blocks.style.build.css - Frontend + Backend.
	 * 2. blocks.build.js - Backend.
	 * 3. blocks.editor.build.css - Backend.
	 *
	 * @uses {wp-blocks} for block type registration & related functions.
	 * @uses {wp-element} for WP Element abstraction — structure of blocks.
	 * @uses {wp-i18n} to internationalize the block's text.
	 * @uses {wp-editor} for WP editor styles.
	 * @since 1.0.0
	 */
	static public function enqueue_blocks_assets(){

		$default_block_args = array(
			'script_dependencies'	=> array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-plugins', 'wp-edit-post' ),
		);

		foreach (new DirectoryIterator( self::get_src_path() . '/blocks' ) as $block) {
			if($block->isDot()) continue;
			$block_name = $block->getBasename();
			$block_dist_url = self::get_dist_url() . "/blocks/$block_name";
			$block_dist_path = self::get_dist_path() . "/blocks/$block_name";

			$block_file = self::get_src_path() . "/blocks/$block_name/$block_name.php";
			if( !file_exists($block_file) )
				continue;

			$block_args = include $block_file;

			if( !$block_args || !is_array($block_args) || !isset($block_args['id']) )
				continue;

			$block_args = array_merge($default_block_args, $block_args);
			$rb_block = new RB_Gutenberg_Block($block_args['id']);

			// Attributes registration
			if( isset( $block_args['attributes'] ) && is_array($block_args['attributes']) ){
				$rb_block->register_attributes( $block_args['attributes'] );
			}

			// Render Callback
			if( isset( $block_args['render_callback'] ) ){
				$rb_block->register_render_callback( $block_args['render_callback'] );
			}

			// When the block exists in the build
			if( file_exists($block_dist_path) ){

				// Register block styles for both frontend + backend.
				if( file_exists("$block_dist_path/css/style.min.css") ){
					wp_register_style(
						"$block_name-front-css", // Handle.
						"$block_dist_url/css/style.min.css", // Block style CSS.
						array( 'wp-editor' ), // Dependency to include the CSS after it.
						null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
					);
					$rb_block->set_front_style("$block_name-front-css");
				}

				// Register block editor script for backend.
				if( file_exists("$block_dist_path/block.min.js") ){
					wp_register_script(
						"$block_name-block-js", // Handle.
						"$block_dist_url/block.min.js", // Block.build.js: We register the block here. Built with Webpack.
						$block_args['script_dependencies'], // Dependencies, defined above.
						null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
						true // Enqueue the script in the footer.
					);

					// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
					wp_localize_script(
						"$block_name-block-js",
						'genBlocksGlobal', // Array containing dynamic data for a JS Global.
						[
							'pluginDirPath' => plugin_dir_path( __DIR__ ),
							'pluginDirUrl'  => rb_get_file_url( __DIR__ ),
							'blocksUrl'		=> self::get_blocks_url(),
							'componentsUrl'	=> self::get_components_url(),
							'helpersUrl'	=> self::get_helpers_url(),
							// Add more data here that you want to access from `cgbGlobal` object.
						]
					);

					$rb_block->set_editor_script("$block_name-block-js");
				}

				// Register block editor styles for backend.
				if( file_exists("$block_dist_path/css/editor.min.css") ){
					wp_register_style(
						"$block_name-editor-css", // Handle.
						"$block_dist_url/css/editor.min.css", // Block editor CSS.
						array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
						null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
					);
					$rb_block->set_editor_style("$block_name-editor-css");
				}

			}

			/**
			 * Register Gutenberg block on server-side.
			 *
			 * Register the block on server-side to ensure that the block
			 * scripts and styles for both frontend and backend are
			 * enqueued when the editor loads.
			 *
			 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
			 * @since 1.16.0
			 */
			$rb_block->register_block();

			// register_block_type(
			// 	"$block_id", array(
			// 		// Enqueue blocks.style.build.css on both frontend & backend.
			// 		'style'         => "$block_name-front-css",
			// 		// Enqueue blocks.build.js in the editor only.
			// 		'editor_script' => "$block_name-block-js",
			// 		// Enqueue blocks.editor.build.css in the editor only.
			// 		'editor_style'  => "$block_name-editor-css",
			// 	)
			// );
		}

		$extra_styles_path = "/css/styles.min.css";
		// Register bundle of extra css filex
		if( file_exists(self::get_dist_path() . $extra_styles_path) ){
			wp_register_style(
				"gen-blocks-extra-styles",
				self::get_dist_url() . "$extra_styles_path",
				array( 'wp-editor' ), // Dependency to include the CSS after it.
				null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
			);

			register_block_type(
				"gen/blocks-builder-extra-bundle", array(
					// Enqueue blocks.style.build.css on both frontend & backend.
					'style'         => "gen-blocks-extra-styles",
				)
			);
		}

	}

	// Incluye el archivo .php principal de los bloques
	// Deprecated. Already done in the enqueue_blocks_assets method
	static private function require_blocks_files(){
		$blocks_path = self::get_blocks_path();
		if(!file_exists( $$blocks_path ))
			return;

		foreach (new DirectoryIterator( $blocks_path ) as $block) {
			if($block->isDot()) continue;
			$block_file = $block->getPathname() . '/' . $block->getBasename() . '.php';
			if(file_exists($block_file))
				require_once $block_file;
		}
	}

	//Incluye el archivo .php principal de los componentes
	static private function require_components_files(){
		$components_path = self::get_components_path();
		if(!file_exists( $components_path ))
			return;

		foreach (new DirectoryIterator( $components_path ) as $component) {
			if($component->isDot()) continue;
			$component_php = $component->getPathname() . '/' . $component->getBasename() . '.php';
			if(file_exists($component_php))
				require_once $component_php;
		}
	}

	//Incluye el archivo .php principal de los helpers
	static private function require_helpers_files(){
		$helpers_path = self::get_helpers_path();
		if(!file_exists( $helpers_path ))
			return;

		foreach (new DirectoryIterator( $helpers_path ) as $hocomponent) {
			if($hocomponent->isDot()) continue;
			$hocomponent_php = $hocomponent->getPathname() . '/' . $hocomponent->getBasename() . '.php';
			if(file_exists($hocomponent_php))
				require_once $hocomponent_php;
		}
	}
}
GEN_Gutenberg_Build::initialize();
