<?php

return array(
    'id'            => 'ta_article_section',
    'type'          => 'taxonomy',
    'object_type'   => TA_ARTICLES_COMPATIBLE_POST_TYPES,
    'args'          => array(
        'labels' 			=> array(
            'name'                       => _x( 'Secciones', 'taxonomy general name', 'ta-genosha' ),
            'singular_name'              => _x( 'Sección', 'taxonomy singular name', 'ta-genosha' ),
            'search_items'               => __( 'Buscar Sección', 'ta-genosha' ),
            'popular_items'              => __( 'Secciones Populares', 'ta-genosha' ),
            'all_items'                  => __( 'Todas las Secciones', 'ta-genosha' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Editar Sección', 'ta-genosha' ),
            'update_item'                => __( 'Actualizar Sección', 'ta-genosha' ),
            'add_new_item'               => __( 'Agregar una nueva Sección', 'ta-genosha' ),
            'new_item_name'              => __( 'Nueva Sección', 'ta-genosha' ),
            'separate_items_with_commas' => __( 'Separar Secciones con comas', 'ta-genosha' ),
            'add_or_remove_items'        => __( 'Agregar o remover Secciones', 'ta-genosha' ),
            'choose_from_most_used'      => __( 'Seleccionar de las Sección mas usadas', 'ta-genosha' ),
            'not_found'                  => __( 'No se encontraron Secciones.', 'ta-genosha' ),
            'menu_name'                  => __( 'Secciones', 'ta-genosha' ),
        ),
        'hierarchical'      => true,
        'label'             => __( 'Secciones' ),
        'rewrite'           => array( 'slug' => '', 'with_front' => true ),
        'show_in_rest'      => true, // This enables the REST API endpoint
        'query_var'         => true, // This allows us to append the taxonomy param to the custom post api request.
        'show_in_nav_menus' => true,
        'capabilities' => array(
            'manage_terms'  =>   'manage_article_sections',
            'edit_terms'    =>   'edit_article_sections',
            'delete_terms'  =>   'delete_article_sections',
            'assign_terms'  =>   'edit_articles',
        ),
        "rb_config"			=> array(
            'unique'	=> true,
            'labels'    => array(
                'required_term_missing'         => 'Es necesario seleccionar una sección antes de publicar un artículo',
            ),
        ),
    ),
);
