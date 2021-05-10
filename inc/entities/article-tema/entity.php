<?php

return array(
    'id'            => 'ta_article_tema',
    'type'          => 'taxonomy',
    'object_type'   => TA_ARTICLES_COMPATIBLE_POST_TYPES,
    'args'          => array(
        'labels' 			=> array(
            'name'                       => _x( 'Temas', 'taxonomy general name', 'ta-genosha' ),
            'singular_name'              => _x( 'Tema', 'taxonomy singular name', 'ta-genosha' ),
            'search_items'               => __( 'Buscar Tema', 'ta-genosha' ),
            'popular_items'              => __( 'Temas Populares', 'ta-genosha' ),
            'all_items'                  => __( 'Todos los Temas', 'ta-genosha' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Editar Tema', 'ta-genosha' ),
            'update_item'                => __( 'Actualizar Tema', 'ta-genosha' ),
            'add_new_item'               => __( 'Agregar un nuevo Tema', 'ta-genosha' ),
            'new_item_name'              => __( 'Nuevo Tema', 'ta-genosha' ),
            'separate_items_with_commas' => __( 'Separar Temas con comas', 'ta-genosha' ),
            'add_or_remove_items'        => __( 'Agregar o remover Temas', 'ta-genosha' ),
            'choose_from_most_used'      => __( 'Seleccionar de los Temas mas usados', 'ta-genosha' ),
            'not_found'                  => __( 'No se encontraron Temas.', 'ta-genosha' ),
            'menu_name'                  => __( 'Temas', 'ta-genosha' ),
        ),
        'hierarchical'      => true,
        'label'             => __( 'Temas' ),
        'rewrite'           => array( 'slug' => '', 'with_front' => true ),
        'show_in_rest'      => true, // This enables the REST API endpoint
        'query_var'         => true, // This allows us to append the taxonomy param to the custom post api request.
        'show_in_nav_menus' => true,
        'capabilities' => array(
            'manage_terms'  =>   'manage_article_temas',
            'edit_terms'    =>   'edit_article_temas',
            'delete_terms'  =>   'delete_article_temas',
            'assign_terms'  =>   'assign_article_temas',
        ),
        // "rb_config"			=> array(
        //     'unique'	=> true,
        // ),
    ),
);
