# **Entities Module**

Management on WordPress entities (posts and taxonomies)

- [Custom Entity Creation Errors](#custom-entity-creation-errors)
    -  [Add An Error](#add-an-error)
    -  [Ignore An Error](#component-controller)

# Entity Types

When we talk about entities, we are refering to the following data structures

- `post_type`
- `taxonomy`

# Entities creation

The regular way can be used (`register_taxonomy`, `register_post_type`); but the theme provide a way to dynamically create
all the entities needed in an organized way, by storing these information the following way.

Add a folder for each entity under `inc/entities` (these path can be changed using the `GEN_Entities::set_entities_path` method).

This folder should contain a file named `entity.php`, which returns an array with the configuration for the new entity.

| Parameter   	| Type             	| Required         	| Default     	| Description                                                                                                  	|
|-------------	|------------------	|------------------	|-------------	|--------------------------------------------------------------------------------------------------------------	|
| id          	| string           	| **yes**              	| null        	| The id for the new entity.                                                                                   	|
| type        	| string           	| no               	| "post_type" 	| Name of the components that need to be loaded before this one. This will require the components controllers. 	|
| args        	| mixed[]          	| no               	| null        	| Array of arguments used when creating the entity normally through the core functions.                        	|
| object_type 	| string\|string[] 	| **only if taxonomy** 	| null        	| Object type or array of object types with which the taxonomy should be associated.                           	|

# Custom Entity Creation Errors

Notices can be shown when creating a new custom entity with improper parameters. That way we can let the developer know that an entity is breaking the standards, and we can take actions accordingly.

For example, the `name_dash` test checks for entities containing `-` in their name.
If that happens, that entity is unregistered, and a notice is thrown in the dashboard,
telling what entities failed this test.

## Add An Error Test

To test for custom errors in the creation of entities, create a new instance of
`GEN_Entity_Error`, that manages the new error, and add it to the errors check by
running `GEN_Entities::add_error_type((string) $id, (GEN_Entity_Error) $error_manager)`

### GEN_Entity_Error Args

| Parameter 	| Type    	| Default 	| Required 	| Description                                                                                                                                         	|
|-----------	|---------	|---------	|----------	|-----------------------------------------------------------------------------------------------------------------------------------------------------	|
| $check_cb 	| string  	| null    	| Yes      	| Function that runs the test on the new entity <br> Takes $entity_type ('post_type' or 'taxonomy'), $entity_name, $entity_object as arguments        	|
| $on_fail  	| mixed[] 	| null    	| Yes      	| Function to run when an entity fails the `$check_cb` <br> Takes $entity_type ('post_type' or 'taxonomy'), $entity_name, $entity_object as arguments 	|
| $args     	| mixed[] 	| array() 	| No       	| The next optional arguments                                                                                                                         	|
| title     	| string  	| ''      	| No       	| The notice title                                                                                                                                    	|
| message   	| string  	| ''      	| No       	| The notice message                                                                                                                                  	|
| tip       	| string  	| ''      	| No       	| A tip to show on the notice on how to solve the problem                                                                                             	|

### Example
This is the definition of the `name_dash` test
````php
<?php
GEN_Entities::add_error_type("name_dash", new GEN_Entity_Error(
    // Error Check Callback
	function($entity_type, $entity_name){
		$check_active = ($entity_type == 'taxonomy' && GEN_NO_DASH_TAXONOMY_NAME) || ($entity_type == 'post_type' && GEN_NO_DASH_POST_TYPE);
		$is_valid = !$check_active || strpos($entity_name, '-') === false;
		return $is_valid;
	},
    // Fail sequence
	function($entity_type, $entity_name){
		if( $entity_type == 'post_type' )
			unregister_post_type($entity_name);
		else if( $entity_type == 'taxonomy' )
			unregister_taxonomy($entity_name);
	},
    // Extra Arguments
	array(
		'title'		=> 'Invalid Entity Names',
		'message'	=> 'The following entities contain dashes (<b>-</b>) in their names, which are not allowed.',
		'tip'		=> 'If you have no control over some entity, the error can be ignored using the "<b>gen_post_type_dash_error</b>" filter.',
	),
));
````

## Ignore An Error

The filter `gen_check_{$entity_type}_{$error_id}_error` allows you to disable the error check of id `$error_id`
by returning `false` for either some or all the entities of type `$entity_type`

##### Example: Name Dash Error

In this example, when the post type is `lr-article`, we ignore the error the check for dashes in the name.
For this, `$entity_type` is `post_type`, and `$error_id` is `name_dash`.
````php
<?php
add_filter('gen_check_post_type_name_dash_error', function($check, $post_type){
    if($post_type == 'lr-article')
        return false; // return true to ignore the error on this post type
    return $check;
}, 10, 2);
````
