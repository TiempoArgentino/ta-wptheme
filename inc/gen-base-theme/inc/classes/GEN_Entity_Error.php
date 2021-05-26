<?php

/**
*	Used to test for errors when creating an entity (post_type, taxonomy)
*	Checks for an specific error on the entities
*	Provides the function to run on error, and the data to show on the notice.
*/
class GEN_Entity_Error{
	/**
	*	@property string[] $post_types
	*	The posts types names that failed the test
	*/
	public $post_types = [];

	/**
	*	@property string[] $taxonomies
	*	The taxonomy names that failed the test
	*/
	public $taxonomies = [];

	/**
	*	@property callback $check_cb
	*	The callback that defines if an entity has the error or not
	*	@param string $entity_type												Type of entity: post_type, taxonomy
	*	@param string $entity_name
	*	@param string $entity_object											The object related to the entity
	*/
	private $check_cb = null;

	/**
	*	@property callback $on_fail
	*	What to do with the entity that has the error
	*	@param string $entity_type												Type of entity: post_type, taxonomy
	*	@param string $entity_name
	*	@param string $entity_object											The object related to the entity
	*/
	private $on_fail = null;

	/**
	*	@property string[] $title
	*	Notice's title
	*/
	public $title = '';

	/**
	*	@property string[] $message
	*	Notice's message
	*/
	public $message = '';

	/**
	*	@property string[] $tip
	*	Notice's tip. Footer message
	*/
	public $tip = '';

	public function __construct($check_cb, $on_fail, $args = array()){
		$this->check_cb = $check_cb;
		$this->on_fail = $on_fail;
		$this->title = isset($args['title']) ? $args['title'] : $this->title;
		$this->message = isset($args['message']) ? $args['message'] : $this->message;
		$this->tip = isset($args['tip']) ? $args['tip'] : $this->tip;
	}

	/**
	*	Checks using the $check_cb if the entity is valid (doesn't have the error) or invalid
	*/
	public function is_valid($entity_type, $entity_name, $entity_object = null){
		if( is_callable( $this->check_cb ) )
			return call_user_func( $this->check_cb, $entity_type, $entity_name, $entity_object );
		return true;
	}

	/**
	*	If the entity is invalid it adds it to the wrong entities list, and runs the fail callback on it
	*/
	public function test($entity_type, $entity_name, $entity_object = null){
		$is_valid = $this->is_valid($entity_type, $entity_name, $entity_object);
		if($is_valid)
			return true;

		if($entity_type == 'post_type')
			$this->post_types[] = $entity_name;
		else if($entity_type == 'taxonomy')
			$this->taxonomies[] = $entity_name;

		$this->fail($entity_type, $entity_name, $entity_object);
		return false;
	}

	public function fail($entity_type, $entity_name, $entity_object = null){
		if( is_callable( $this->on_fail ) )
			call_user_func( $this->on_fail, $entity_type, $entity_name, $entity_object );
	}

	/**
	*	Register a post type as having this error
	*	@param string $post_type												The post type name
	*/
	public function add_post($post_type){
		$this->post_types[] = $post_type;
	}

	/**
	*	Register a taxonomy as having this error
	*	@param string $taxonomy_name											The taxonomy name
	*/
	public function add_taxonomy($taxonomy_name){
		$this->taxonomies[] = $taxonomy_name;
	}

	public function have_post_types_errors(){
		return !empty($this->post_types);
	}

	public function have_taxonomy_errors(){
		return !empty($this->taxonomies);
	}

	public function have_errors(){
		return $this->have_taxonomy_errors() || $this->have_post_types_errors();
	}
}
