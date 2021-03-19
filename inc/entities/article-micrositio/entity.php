<?php

return array(
    'id'            => 'ta_micrositio',
    'type'          => 'taxonomy',
    'object_type'   => TA_ARTICLES_COMPATIBLE_POST_TYPES,
    'args'          => array(
        'labels' 			=> array(
            'name'                       => _x( 'Micrositios', 'taxonomy general name', 'ta-genosha' ),
            'singular_name'              => _x( 'Micrositio', 'taxonomy singular name', 'ta-genosha' ),
            'search_items'               => __( 'Buscar Micrositio', 'ta-genosha' ),
            'popular_items'              => __( 'Micrositios Populares', 'ta-genosha' ),
            'all_items'                  => __( 'Todos los Micrositios', 'ta-genosha' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Editar Micrositio', 'ta-genosha' ),
            'update_item'                => __( 'Actualizar Micrositio', 'ta-genosha' ),
            'add_new_item'               => __( 'Agregar un nuevo Micrositio', 'ta-genosha' ),
            'new_item_name'              => __( 'Nuevo Micrositio', 'ta-genosha' ),
            'separate_items_with_commas' => __( 'Separar Micrositios con comas', 'ta-genosha' ),
            'add_or_remove_items'        => __( 'Agregar o remover Micrositios', 'ta-genosha' ),
            'choose_from_most_used'      => __( 'Seleccionar de los Micrositios mas usados', 'ta-genosha' ),
            'not_found'                  => __( 'No se encontraron Micrositios.', 'ta-genosha' ),
            'menu_name'                  => __( 'Micrositios', 'ta-genosha' ),
        ),
        'hierarchical'      => true,
        'label'             => __( 'Micrositios' ),
        'rewrite'           => array( 'slug' => 'micrositio' ),
        'show_in_rest'      => true, // This enables the REST API endpoint
        'query_var'         => true, // This allows us to append the taxonomy param to the custom post api request.
        'show_in_nav_menus' => true,
    ),
    'metaboxes'     => array(
    ),
);
