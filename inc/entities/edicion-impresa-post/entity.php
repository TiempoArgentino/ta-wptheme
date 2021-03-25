<?php

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
return array(
    'id'            => 'ta_ed_impresa',
    'type'          => 'post_type',
    'args'          => array(
        'labels' 			=> array(
            'name' 				 => __( 'Ediciones Impresas' ),
            'singular_name' 	 => __( 'Edición Impresa' ),
            'add_new'            => __( 'Agregar' ),
            'add_new_item'       => __( 'Agregar nueva Edición Impresa' ),
            'edit_item'          => __( 'Editar Edición Impresa' ),
            'new_item'           => __( 'Nueva Edición Impresa' ),
            'view_item'          => __( 'Ver' ),
            'search_items'       => __( 'Buscar Edición Impresa' ),
            'not_found'          => __( 'No se encontraron Ediciones Impresas' ),
            'not_found_in_trash' => __( 'No se encontraron Ediciones Impresas' ),
        ),
        'public' 				=> true,
        'has_archive' 			=> 'articulos', //slug para archivo (usado por fecha en este caso)
        'rewrite' 				=> true, //true para que si tenga url amigable y no definimos slug para poder sobre escribirlo como queramos
        'menu_position'			=> 5,
        'menu_icon'				=> TA_ASSETS_URL . '/img/articles-icon.png',
        'supports'				=> array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
        'publicly_queryable' => true,
        'query_var'				=> true,
        'show_in_rest' 			=> true,
        'show_in_nav_menus' 	=> true,
        'post_per_page'			=> 10,
        'paged' 				=> $paged,
        'capability_type'		=> 'post', //para poder cambiar el tipo de regla (apuntar a una pagina por ejemplo con pagename),
        // 'rb_config'             => array(
        //     'templates'             => array(
        //         'single'                => 'test.php'
        //     ),
        // ),
    ),
);
