<?php

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
return array(
    'id'            => 'ta_micrositio_home',
    'type'          => 'post_type',
    'args'          => array(
        'labels' 			=> array(
            'name' 				 => __( 'Micrositios' ),
            'singular_name' 	 => __( 'Micrositio' ),
            'add_new'            => __( 'Agregar' ),
            'add_new_item'       => __( 'Agregar nuevo Micrositio' ),
            'edit_item'          => __( 'Editar Micrositio' ),
            'new_item'           => __( 'Nuevo Micrositio' ),
            'view_item'          => __( 'Ver' ),
            'search_items'       => __( 'Buscar Micrositio' ),
            'not_found'          => __( 'No se encontraron Micrositios' ),
            'not_found_in_trash' => __( 'No se encontraron Micrositios' ),
        ),
        'public' 				=> true,
        'has_archive' 			=> false,
        'rewrite' 				=>  true, //true para que si tenga url amigable y no definimos slug para poder sobre escribirlo como queramos
        'taxonomies'			=> ['ta_article_section'],
        'menu_position'			=> 5,
        'menu_icon'				=> TA_ASSETS_URL . '/img/articles-icon.png',
        'supports'				=> array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields'),
        'publicly_queryable'    => true,
        'query_var'				=> true,
        'show_in_rest' 			=> true,
        'show_in_nav_menus' 	=> false,
        'post_per_page'			=> 10,
        'paged' 				=> $paged,
        'capability_type'		=> ['micrositio_home', 'micrositios_homes'], //para poder cambiar el tipo de regla (apuntar a una pagina por ejemplo con pagename),
        // 'capabilities' 			=> array(
        //     'edit_posts'                                => 'edit_micrositios_homes',
        //     'publish_posts'                             => 'publish_micrositios_homes',
        //     'edit_others_posts'                         => 'edit_others_micrositios_homes',
        //     'delete_posts'                              => 'delete_micrositios_homes',
        //     'delete_others_posts'                       => 'delete_others_micrositios_homes',
        //     'edit_published_posts'                      => 'edit_published_micrositios_homes',
        //     'delete_published_posts'                    => 'delete_published_micrositios_homes',
        //     'delete_private_posts'                      => 'delete_private_micrositios_homes',
        //     'edit_private_posts'                        => 'edit_private_micrositios_homes',
        //     'read_private_posts'                        => 'read_private_micrositios_homes',
        // ),
        "rb_config"			=> array(),
    ),
    'metaboxes'     => array(
    ),
);
