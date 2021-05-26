<?php

return array(
    'id'            => 'ta_article_tag',
    'type'          => 'taxonomy',
    'object_type'   => TA_ARTICLES_COMPATIBLE_POST_TYPES,
    'args'          => array(
        'labels' 			=> array(
            'name'                       => _x( 'Etiquetas', 'taxonomy general name', 'ta-genosha' ),
            'singular_name'              => _x( 'Etiqueta', 'taxonomy singular name', 'ta-genosha' ),
            'search_items'               => __( 'Buscar Etiqueta', 'ta-genosha' ),
            'popular_items'              => __( 'Etiquetas Populares', 'ta-genosha' ),
            'all_items'                  => __( 'Todas las Etiquetas', 'ta-genosha' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Editar Etiqueta', 'ta-genosha' ),
            'update_item'                => __( 'Actualizar Etiqueta', 'ta-genosha' ),
            'add_new_item'               => __( 'Agregar una nueva Etiqueta', 'ta-genosha' ),
            'new_item_name'              => __( 'Nueva Etiqueta', 'ta-genosha' ),
            'separate_items_with_commas' => __( 'Separar Etiquetas con comas', 'ta-genosha' ),
            'add_or_remove_items'        => __( 'Agregar o remover Etiquetas', 'ta-genosha' ),
            'choose_from_most_used'      => __( 'Seleccionar de las Etiqueta mas usadas', 'ta-genosha' ),
            'not_found'                  => __( 'No se encontraron Etiquetas.', 'ta-genosha' ),
            'menu_name'                  => __( 'Etiquetas', 'ta-genosha' ),
        ),
        'hierarchical'      => false,
        'label'             => __( 'Etiquetas', 'ta-genosha' ),
        'rewrite'           => array( 'slug' => 'etiqueta' ),
        'show_in_rest'      => true, // This enables the REST API endpoint
        'query_var'         => true, // This allows us to append the taxonomy param to the custom post api request.
        'show_in_nav_menus' => true,
        'capabilities' => array(
            'manage_terms'  =>   'manage_article_tags',
            'edit_terms'    =>   'edit_article_tags',
            'delete_terms'  =>   'delete_article_tags',
            'assign_terms'  =>   'edit_articles',
        ),
    ),
    'metaboxes'     => array(
        'ta_article_tag_image' => array(
            'settings'  => array(
                'title'             => __('Imagen Destacada', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
            ),
            'input'  => array(
                'controls'        => array(
                    'image'   => array(
                        // 'label'             => __('Imágen Horizontal (3:2)', 'ta-genosha'),
                        // 'description'       => __('Tamaño recomendado 900 x 600 px.', 'ta-genosha'),
                        'type'              => 'RB_Media_Control',
                        'store_value'       => 'id', //guarda el attachment id
                    ),
                ),
            ),
        ),
        'ta_article_tag_description' => array(
            'settings'  => array(
                'title'             => __('Descripción', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
            ),
            'input'  => array(
                'controls'        => array(
                    'image'   => array(
                        'type'              => 'RB_tinymce_control',
                    ),
                ),
            ),
        ),
    ),
);
