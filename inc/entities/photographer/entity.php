<?php

return array(
    'id'            => 'ta_photographer',
    'type'          => 'taxonomy',
    'object_type'   => ['attachment'],
    'args'          => array(
        'labels' 			=> array(
            'name'                       => _x( 'Fotógrafos', 'taxonomy general name', 'ta-genosha' ),
            'singular_name'              => _x( 'Fotógrafo', 'taxonomy singular name', 'ta-genosha' ),
            'search_items'               => __( 'Buscar Fotógrafo', 'ta-genosha' ),
            'popular_items'              => __( 'Fotógrafos Populares', 'ta-genosha' ),
            'all_items'                  => __( 'Todos los autores', 'ta-genosha' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Editar Fotógrafo', 'ta-genosha' ),
            'update_item'                => __( 'Actualizar Fotógrafo', 'ta-genosha' ),
            'add_new_item'               => __( 'Agregar un nuevo Fotógrafo', 'ta-genosha' ),
            'new_item_name'              => __( 'Nuevo Fotógrafo', 'ta-genosha' ),
            'separate_items_with_commas' => __( 'Separar Fotógrafos con comas', 'ta-genosha' ),
            'add_or_remove_items'        => __( 'Agregar o remover Fotógrafos', 'ta-genosha' ),
            'choose_from_most_used'      => __( 'Seleccionar de los Fotógrafos mas usados', 'ta-genosha' ),
            'not_found'                  => __( 'No se encontraron Fotógrafos.', 'ta-genosha' ),
            'menu_name'                  => __( 'Fotógrafos', 'ta-genosha' ),
        ),
        'hierarchical'      => true,
        'label'             => __( 'Fotógrafos' ),
        'rewrite'           => array( 'slug' => 'fotografo' ),
        'show_in_rest'      => true, // This enables the REST API endpoint
        'query_var'         => true, // This allows us to append the taxonomy param to the custom post api request.
        'show_in_nav_menus' => true,
        "rb_config"			=> array(
            'unique'	=> true,
            // 'labels'    => array(
            //     'required_term_missing'         => 'Es necesario seleccionar una sección antes de publicar un artículo',
            // ),
        ),
    ),
    'metaboxes'     => array(
        'ta_photographer_is_from_tiempo_arg' => array(
            'settings'  => array(
                'title'             => __('Interno', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
            ),
            'input'  => array(
                'controls'        => array(
                    'text'   => array(
                        'label'             => __('Es de Tiempo Argentino', 'ta-genosha'),
                        // 'description'       => __('Tamaño recomendado 900 x 600 px.', 'ta-genosha'),
                        'input_type'            => 'checkbox',
                    ),
                ),
            ),
        ),
        'ta_photographer_networks' => array(
            'settings'  => array(
                'title'			=> __('Redes y Contacto', 'ta-genosha'),
                'context'		=> 'normal',
                'priority'		=> 'high',
                'classes'		=> array('ta-metabox'),
                'add_form'      => true,
                'collapsible'   => true,
            ),
            'input'  => array(
                'accordion'   => true,
                'controls'		=> array(
                    'twitter'      => array(
                        'controller'    => array(// Field Settings
                             'title'        => 'Twitter',
                             'collapsible'  => true,
                             'group'        => true,
                             // 'description'   => 'Soy la description del grupo dentro del grupo (inception)',
                         ),
                        'controls'  => array(
                            'username'      => array(
                                'label'     => __('Nombre de usuario:', 'ta-genosha'),
                                'input_type'    => 'text',
                            ),
                        ),
                    ),
                    'instagram'      => array(
                        'controller'    => array(// Field Settings
                             'title' => 'Instagram',
                             'collapsible'  => true,
                             'group'        => true,
                             // 'description'   => 'Soy la description del grupo dentro del grupo (inception)',
                         ),
                        'controls'  => array(
                            'username'      => array(
                                'label'     => __('Nombre de usuario:', 'ta-genosha'),
                                'input_type'    => 'text',
                            ),
                        ),
                    ),
                    'email'      => array(
                        'controller'    => array(// Field Settings
                             'title' => 'Email',
                             'collapsible'  => true,
                             'group'        => true,
                             // 'description'   => 'Soy la description del grupo dentro del grupo (inception)',
                         ),
                        'controls'  => array(
                            'username'      => array(
                                'label'     => __('Dirección de Email:', 'ta-genosha'),
                                'input_type'    => 'text',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
