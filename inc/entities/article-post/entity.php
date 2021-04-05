<?php

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
return array(
    'id'            => 'ta_article',
    'type'          => 'post_type',
    'args'          => array(
        'labels' 			=> array(
            'name' 				 => __( 'Artículos' ),
            'singular_name' 	 => __( 'Artículo' ),
            'add_new'            => __( 'Agregar' ),
            'add_new_item'       => __( 'Agregar nuevo Artículo' ),
            'edit_item'          => __( 'Editar Artículo' ),
            'new_item'           => __( 'Nuevo Artículo' ),
            'view_item'          => __( 'Ver' ),
            'search_items'       => __( 'Buscar Artículo' ),
            'not_found'          => __( 'No se encontraron artículos' ),
            'not_found_in_trash' => __( 'No se encontraron artículos' ),
        ),
        'public' 				=> true,
        'has_archive' 			=> 'articulos', //slug para archivo (usado por fecha en este caso)
        'rewrite' 				=>  true, //true para que si tenga url amigable y no definimos slug para poder sobre escribirlo como queramos
        'taxonomies'			=> ['ta_article_section'],
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
        "rb_config"			=> array(
            //     'templates'             => array(
            //         'single'                => 'test.php'
            //     ),
            'required_taxonomies'   => array(
                'ta_article_section'    => true,
            ),
        ),
    ),
    'metaboxes'     => array(
        'ta_article_thumbnail_changed' => array(
            'settings'  => array(
                'title'             => __('Thumb changed', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
            ),
            'input'  => array(
                'controls'		=> array(
                    'logo'      => array(
                        'input_type'          => 'checkbox',
                    ),
                ),
            ),
        ),
        'ta_article_thumbnail_alt_changed' => array(
            'settings'  => array(
                'title'             => __('Thumb alt changed', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
            ),
            'input'  => array(
                'controls'		=> array(
                    'logo'      => array(
                        //'label'     => __('Logo a color', 'ta-genosha'),
                        'input_type'          => 'checkbox',
                    ),
                ),
            ),
        ),
        'ta_article_thumbnail_alt' => array(
            'settings'  => array(
                'title'             => __('Imagen en bloques', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
                'quick_edit'        => true,
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
        'ta_article_cintillo' => array(
            'settings'  => array(
                'title'             => __('Cintillo', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
            ),
            'input'  => array(
                'controls'        => array(
                    'text'   => array(
                        'label'             => __('Texto del cintillo', 'ta-genosha'),
                        // 'description'       => __('Tamaño recomendado 900 x 600 px.', 'ta-genosha'),
                        'input_type'            => 'text',
                    ),
                ),
            ),
        ),
        'ta_article_isopinion' => array(
            'settings'  => array(
                'title'             => __('Opinión', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
            ),
            'input'  => array(
                'controls'        => array(
                    'text'   => array(
                        'label'             => __('Es artículo de opinión', 'ta-genosha'),
                        // 'description'       => __('Tamaño recomendado 900 x 600 px.', 'ta-genosha'),
                        'input_type'            => 'checkbox',
                    ),
                ),
            ),
        ),
        'ta_article_sister_article' => array(
            'settings'  => array(
                'title'             => __('Nota Hermana', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
            ),
            'input'  => array(
                'controls'        => array(
                    'text'   => array(
                        'label'                 => __('Artículo', 'ta-genosha'),
                        // 'description'       => __('Tamaño recomendado 900 x 600 px.', 'ta-genosha'),
                        'type'                  => 'RB_Post_Selector',
                        'query_args'            => array(
                            'post_type'             => 'ta_article'
                        ),
                    ),
                ),
            ),
        ),
    ),
);
