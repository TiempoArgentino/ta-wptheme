<?php

/**
*   Test of custom entities creation
*/


//=================================================
//  CUSTOM POST
//=================================================

RB_Filters_Manager::add_action('gen_custom_post_type_test', 'init', function(){
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	register_post_type( 'lr-article',
		array(
			'labels' 			=> array(
				'name' 				 => __( 'Artículos' ),
				'singular_name' 	 => __( 'Artículo' ),
				'add_new'            => __( 'Agregar' ),
				'add_new_item'       => __( 'Agregar nuevo artículo' ),
				'edit_item'          => __( 'Editar artículo' ),
				'new_item'           => __( 'Nuevo artículo' ),
				'view_item'          => __( 'Ver' ),
				'search_items'       => __( 'Buscar artículo' ),
				'not_found'          => __( 'No se encontraron artículos' ),
				'not_found_in_trash' => __( 'No se encontraron artículos' ),
			),
			'public' 				=> true,
			'has_archive' 			=> 'articulos', //slug para archivo (usado por fecha en este caso)
			'rewrite' 				=> true, //true para que si tenga url amigable y no definimos slug para poder sobre escribirlo como queramos
			'menu_position'			=> 5,
			'supports'				=> array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
			'publicly_queryable' => true,
			'query_var'				=> true,
			'show_in_rest' 			=> true,
			'show_in_nav_menus' 	=> true,
			'post_per_page'			=> 10,
			'paged' 				=> $paged,
			'capability_type'		=> 'post', //para poder cambiar el tipo de regla (apuntar a una pagina por ejemplo con pagename),
			'taxonomies'			=> ['lr-article-suplement','lr-article-section']
		)
	);
});

//=================================================
//  CUSTOM TAXONOMY
//=================================================

// function lr_register_article_suplements() {
//     register_taxonomy(
//         'lr-article-suplement',
//         'lr-article',
//         array(
//             'hierarchical'      => true,
//             'label'             => __( 'Suplemento' ),
//             'labels' => array(
//                 'name'          => __('Suplementos'),
//                 'add_new_item'  => __('Agregar Suplemento'),
//                 'new_item_name' => __('Agregar Suplemento'),
//             ),
//             'rewrite'           => array( 'slug' => 'suplementos' ),
//             'show_in_rest' => true, // This enables the REST API endpoint
//             'query_var' => true, // This allows us to append the taxonomy param to the custom post api request.
//             'show_in_nav_menus' 	=> true,
//         )
//     );
// }
// add_action( 'init', 'lr_register_article_suplements' );

//===================================================================
//  REMOVE DASH ERROR IN CUSTOM POST TYPE NAME ONLY FOR lr-article
//===================================================================

add_filter('gen_check_post_type_name_dash_error', function($check, $post_type){
    if($post_type == 'lr-article')
        return false; // return false to ignore the error
    return $check;
}, 10, 2);

//===================================================================
//  CUSTOM ENTITY REGISTER ERROR
//===================================================================

RB_Filters_Manager::add_action("custom_entity_register_errors", 'gen_module_entities_loaded', function(){

	GEN_Entities::add_error_type("test_error", new GEN_Entity_Error(
		function($entity_type, $entity_name){
			return true; // set this to false to throw error
		},
		function($entity_type, $entity_name){
		},
		array(
			'title'		=> __('Test Error For Entities', 'gen-base-theme'),
			'message'	=> __('The following entities are BAD.', 'gen-base-theme'),
			'tip'		=> __('This is the footer message. A tip on how to solve the problem can be placed here.', 'gen-base-theme'),
		)
	));
});
