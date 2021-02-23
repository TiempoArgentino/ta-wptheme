<?php

return array(
    'id'            => 'ta_article_author',
    'type'          => 'taxonomy',
    'object_type'   => ['ta_article'],
    'args'          => array(
        'labels' 			=> array(
            'name'                       => _x( 'Autores', 'taxonomy general name', 'ta-genosha' ),
            'singular_name'              => _x( 'Autor', 'taxonomy singular name', 'ta-genosha' ),
            'search_items'               => __( 'Buscar Autor', 'ta-genosha' ),
            'popular_items'              => __( 'Autores Populares', 'ta-genosha' ),
            'all_items'                  => __( 'Todos los autores', 'ta-genosha' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Editar Autor', 'ta-genosha' ),
            'update_item'                => __( 'Actualizar Autor', 'ta-genosha' ),
            'add_new_item'               => __( 'Agregar un nuevo Autor', 'ta-genosha' ),
            'new_item_name'              => __( 'Nuevo Autor', 'ta-genosha' ),
            'separate_items_with_commas' => __( 'Separar Autores con comas', 'ta-genosha' ),
            'add_or_remove_items'        => __( 'Agregar o remover Autores', 'ta-genosha' ),
            'choose_from_most_used'      => __( 'Seleccionar de los Autores mas usados', 'ta-genosha' ),
            'not_found'                  => __( 'No se encontraron Autores.', 'ta-genosha' ),
            'menu_name'                  => __( 'Autores', 'ta-genosha' ),
        ),
        'hierarchical'      => true,
        'label'             => __( 'Autores' ),
        'rewrite'           => array( 'slug' => 'autor' ),
        'show_in_rest'      => true, // This enables the REST API endpoint
        'query_var'         => true, // This allows us to append the taxonomy param to the custom post api request.
        'show_in_nav_menus' => true,
    ),
    'metaboxes'     => array(
        'ta_author_photo' => array(
            'settings'  => array(
                'title'			=> __('Foto', 'ta-genosha'),
                'context'		=> 'normal',
                'priority'		=> 'high',
                'classes'		=> array('ta-metabox'),
                'add_form'      => true,
            ),
            'input'  => array(
                'controls'		=> array(
                    'logo'      => array(
                        //'label'     => __('Logo a color', 'ta-genosha'),
                        'type'          => 'RB_Media_Control',
                        'store_value'   => 'id',
                    ),
                ),
            ),
        ),
        'ta_author_quote' => array(
            'settings'  => array(
                'title'			=> __('Cita', 'ta-genosha'),
                'context'		=> 'normal',
                'priority'		=> 'high',
                'classes'		=> array('ta-metabox'),
                'add_form'      => true,
            ),
            'input'  => array(
                'controls'		=> array(
                    'logo'      => array(
                        // 'label'     => __('Logo a color', 'ta-genosha'),
                        'input_type'    => 'text',
                    ),
                ),
            ),
        ),
        'ta_author_subject' => array(
            'settings'  => array(
                'title'			=> __('Tema', 'ta-genosha'),
                'context'		=> 'normal',
                'priority'		=> 'high',
                'classes'		=> array('ta-metabox'),
                'add_form'      => true,
            ),
            'input'  => array(
                'controls'		=> array(
                    'logo'      => array(
                        // 'label'     => __('Logo a color', 'ta-genosha'),
                        'input_type'    => 'text',
                    ),
                ),
            ),
        ),
        'ta_author_position' => array(
            'settings'  => array(
                'title'			=> __('Cargo', 'ta-genosha'),
                'context'		=> 'normal',
                'priority'		=> 'high',
                'classes'		=> array('ta-metabox'),
                'add_form'      => true,
            ),
            'input'  => array(
                'controls'		=> array(
                    'logo'      => array(
                        //'label'     => __('Logo a color', 'ta-genosha'),
                        'input_type'    => 'text',
                    ),
                ),
            ),
        ),
        'ta_author_bio' => array(
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
        'ta_author_networks' => array(
            'settings'  => array(
                'title'			=> __('Redes y Contacto', 'ta-genosha'),
                'context'		=> 'normal',
                'priority'		=> 'high',
                'classes'		=> array('ta-metabox'),
                'add_form'      => true,
            ),
            'input'  => array(
                'controls'		=> array(
                    'twitter'      => array(
                        'label'     => __('Twitter', 'ta-genosha'),
                        'input_type'    => 'text',
                    ),
                    'instagram'      => array(
                        'label'     => __('Instagram', 'ta-genosha'),
                        'input_type'    => 'text',
                    ),
                    'email'      => array(
                        'label'     => __('Email', 'ta-genosha'),
                        'input_type'    => 'text',
                    ),
                ),
            ),
        ),
    ),
);
