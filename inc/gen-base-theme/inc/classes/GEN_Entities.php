<?php

/**
*	Main class to manage entities.
*	For the moment is only in charge of checking for errors in the creation of entities.
*/
class GEN_Entities{
	static private $entities_path = GEN_THEME_PATH . '/inc/entities';
	static private $entities_loaded = false;
	static private $initialized = false;

	static private $errors = [];

	static public function initialize(){
		if(self::$initialized)
			return false;
		self::$initialized = true;

		RB_Filters_Manager::add_action('gen_custom_post_type_creation_check', 'registered_post_type', array(self::class, 'check_custom_post_type') );
		RB_Filters_Manager::add_action('gen_custom_taxonomy_creation_check', 'registered_taxonomy', array(self::class, 'check_custom_taxonomy') );
		RB_Filters_Manager::add_action('gen_entities_invalid_name_notice_enqueue', 'init', array(self::class, 'enqueue_dashboard_notices'), array(
            'priority'  => 20,
        ));
		RB_Filters_Manager::add_action('gen_load_entities', 'init', array(self::class, 'load_entities'), array(
            'priority'  => 0,
        ));

		return true;
	}

	/**
	*	Changes the path where the entities are stored
	*	@param string $path														Absolute path for new folder
	*/
	static public function set_entities_path( $path ){
		self::$entities_path = $path;
	}

	/**
	*	Dinamically loads every
	*	@param string $path														Absolute path for new folder
	*/
	static public function load_entities(){
		if(self::$entities_loaded)
			return;
		self::$entities_loaded = true;

		foreach (new DirectoryIterator(GEN_Entities::$entities_path) as $entity_info) {
		    if ($entity_info->isDot())
				continue;
		    $entity_file = $entity_info->getPathname() . '/entity.php';
		    if ( !file_exists($entity_file) )
				continue;

			$extensions_file = $entity_info->getPathname() . '/extension.php';
		    $config = require_once $entity_file;
			$entity_id = isset($config['id']) ? $config['id'] : null;
			$type = isset($config['type']) ? $config['type'] : 'post_type';
			$is_valid_type = $type == 'taxonomy' || $type == 'post_type';

			if( $entity_id && $is_valid_type ){

				// ENTITY REGISTRATION
				RB_Filters_Manager::add_action("gen_register_{$type}_entity_{$entity_id}", 'init', function () use ($config, $entity_id, $type){
					$args = isset($config['args']) ? $config['args'] : null;

					switch($type){
						case 'taxonomy':
							$object_type = isset($config['object_type']) ? $config['object_type'] : null;
							if(!$object_type)
								return;
							register_taxonomy( $entity_id, $object_type, $args);
						break;
						case 'post_type':
							register_post_type( $entity_id, $args);
						break;
						default:
							return;
						break;
					}
				});

				if( is_admin() ){
					// METABOXES
					$metaboxes = isset($config['metaboxes']) ? $config['metaboxes'] : null;

					if($metaboxes  && !empty($metaboxes)){
						$metabox_class_name = '';
						$objects_type = '';
						switch($type){
							case 'taxonomy':
								$metabox_class_name = 'RB_Taxonomy_Form_Field';
								$objects_type = 'terms';
							break;
							case 'post_type':
								$metabox_class_name = 'RB_Metabox';
								$objects_type = 'admin_page';
							break;
						}

						foreach ($metaboxes as $meta_key => $metabox_config) {
							$settings = isset($metabox_config['settings']) ? $metabox_config['settings'] : array();
							$settings[$objects_type] = array($entity_id);
							$meta_input = isset($metabox_config['input']) ? $metabox_config['input'] : null;

							new $metabox_class_name($meta_key, $settings, $meta_input);
						}
					}
				}

			}
		}
	}

	/**
	*	@param string $id														Error ID
	*	@param GEN_Entity_Error $error_manager									The controller that checks for an specific error on the entities
	*																			Provides the function to run on error, and the data to show on the notice.
	*/
	static public function add_error_type($id, $error_manager){
		if( !isset(self::$errors[$id]) )
			self::$errors[$id] = $error_manager;
	}

	/**
	*	Checks if a post_type was created correctly
	*	@param string $post_type												The custom post type name
	*/
	static public function check_custom_post_type($post_type, $post_type_object = null){
		foreach(self::$errors as $error_id => $error_manager){
            if( apply_filters( "gen_check_post_type_{$error_id}_error", true, $post_type, $post_type_object ) )
			         $error_manager->test('post_type', $post_type, $post_type_object);
		}
	}

	/**
	*	Checks if a taxonomy was created correctly
	*	@param string $taxonomy_name											The new taxonomy name
	*/
	static public function check_custom_taxonomy($taxonomy_name, $object_type = null){
		foreach(self::$errors as $error_id => $error_manager){
            if( apply_filters( "gen_check_taxonomy_{$error_id}_error", true, $taxonomy_name, $object_type ) )
			         $error_manager->test('taxonomy', $taxonomy_name, $object_type);
		}
	}

	/**
	*	Checks if there is at least one error with the registered entities
	*/
	static public function have_errors(){
		$have_errors = false;
		foreach(self::$errors as $error_manager){
			if( $error_manager->have_errors() ){
				$have_errors = true;
				break;
			}
		}
		return $have_errors;
	}

	/*
	*	Adds a notice to the dashboard for every group of errors. It tells which entities
	*	failed the test.
	*/
	static public function enqueue_dashboard_notices(){
		foreach(self::$errors as $error_id => $error_manager){
			if( !$error_manager->have_errors() )
				continue;

			RB_Filters_Manager::add_action("gen_entities_error-$error_id", 'admin_notices', function() use ($error_manager){
				$title = $error_manager->title;
				$message = $error_manager->message;
				$tip = $error_manager->tip;
				?>
				<div class="notice notice-error is-dismissible error-<?php echo $error_id; ?>">

					<?php if($title): ?>
					<h2><?php echo $title; ?></h2>

					<?php endif; ?>
					<p><?php echo $message; ?></p>

					<?php if($error_manager->have_post_types_errors()): ?>
					<h4>Post Types</h4>
					<ul>
						<?php foreach($error_manager->post_types as $post_name): ?>
						<li><?php echo $post_name; ?></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>

					<?php if($error_manager->have_taxonomy_errors()): ?>
					<h4>Taxonomies</h4>
					<ul>
						<?php foreach($error_manager->taxonomies as $tax_name): ?>
						<li><?php echo $tax_name; ?></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>

					<?php if($tip): ?>
					<p><?php echo $tip; ?></p>
					<?php endif; ?>

				</div>

				<?php
			} );
		}

	}

}
