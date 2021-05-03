<?php

return array(
    'id'            => 'ta_article_place',
    'type'          => 'taxonomy',
    'object_type'   => TA_ARTICLES_COMPATIBLE_POST_TYPES,
    'args'          => array(
        'labels' 			=> array(
            'name'                       => _x( 'Lugares', 'taxonomy general name', 'ta-genosha' ),
            'singular_name'              => _x( 'Lugar', 'taxonomy singular name', 'ta-genosha' ),
            'search_items'               => __( 'Buscar Lugar', 'ta-genosha' ),
            'popular_items'              => __( 'Lugares Populares', 'ta-genosha' ),
            'all_items'                  => __( 'Todos los Lugares', 'ta-genosha' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Editar Lugar', 'ta-genosha' ),
            'update_item'                => __( 'Actualizar Lugar', 'ta-genosha' ),
            'add_new_item'               => __( 'Agregar un nuevo Lugar', 'ta-genosha' ),
            'new_item_name'              => __( 'Nuevo Lugar', 'ta-genosha' ),
            'separate_items_with_commas' => __( 'Separar Lugares con comas', 'ta-genosha' ),
            'add_or_remove_items'        => __( 'Agregar o remover Lugares', 'ta-genosha' ),
            'choose_from_most_used'      => __( 'Seleccionar de los Lugares mas usados', 'ta-genosha' ),
            'not_found'                  => __( 'No se encontraron Lugares.', 'ta-genosha' ),
            'menu_name'                  => __( 'Lugares', 'ta-genosha' ),
        ),
        'hierarchical'      => false,
        'label'             => __( 'Lugares' ),
        'rewrite'           => array( 'slug' => '', 'with_front' => true ),
        'show_in_rest'      => true, // This enables the REST API endpoint
        'query_var'         => true, // This allows us to append the taxonomy param to the custom post api request.
        'show_in_nav_menus' => true,
        'capabilities' => array(
            'manage_terms'  =>   'manage_article_places',
            'edit_terms'    =>   'edit_article_places',
            'delete_terms'  =>   'delete_article_places',
            'assign_terms'  =>   'edit_articles',
        ),
        "rb_config"			=> array(
            'unique'	=> true,
        ),
    ),
);
