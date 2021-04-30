<?php

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
return array(
    'id'            => 'ta_taller',
    'type'          => 'post_type',
    'args'          => array(
        'labels' 			=> array(
            'name' 				 => __( 'Talleres' ),
            'singular_name' 	 => __( 'Taller' ),
            'add_new'            => __( 'Agregar' ),
            'add_new_item'       => __( 'Agregar nuevo Taller' ),
            'edit_item'          => __( 'Editar Taller' ),
            'new_item'           => __( 'Nuevo Taller' ),
            'view_item'          => __( 'Ver' ),
            'search_items'       => __( 'Buscar Taller' ),
            'not_found'          => __( 'No se encontraron Talleres' ),
            'not_found_in_trash' => __( 'No se encontraron Talleres' ),
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
        'capability_type'		=> ['taller', 'talleres'], //para poder cambiar el tipo de regla (apuntar a una pagina por ejemplo con pagename),
        // 'rb_config'             => array(
        //     'templates'             => array(
        //         'single'                => 'test.php'
        //     ),
        // ),
    ),
    'metaboxes'     => array(
    ),
);
