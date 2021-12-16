<?php

/*
*	Throws a notice and unregisters the entity if it has a dash on its name
*/
GEN_Entities::add_error_type("name_dash", new GEN_Entity_Error(
	function($entity_type, $entity_name){
		$check_active = ($entity_type == 'taxonomy' && GEN_NO_DASH_TAXONOMY_NAME) || ($entity_type == 'post_type' && GEN_NO_DASH_POST_TYPE);
		$is_valid = !$check_active || strpos($entity_name, '-') === false;
		return $is_valid;
	},
	function($entity_type, $entity_name){
		// if( $entity_type == 'post_type' )
		// 	unregister_post_type($entity_name);
		// else if( $entity_type == 'taxonomy' )
		// 	unregister_taxonomy($entity_name);
	},
	array(
		'title'		=> __('Invalid Entity Names', 'gen-base-theme'),
		'message'	=> __('The following entities contain dashes (<b>-</b>) in their names, which are not allowed.', 'gen-base-theme'),
		'tip'		=> __('If you have no control over some entity, the error can be ignored using the "<b>gen_check_post_type_name_dash_error</b>" or "<b>gen_check_taxonomy_name_dash_error</b>" filters.', 'gen-base-theme'),
	)
));
