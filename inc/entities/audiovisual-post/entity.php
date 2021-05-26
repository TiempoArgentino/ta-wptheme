<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
return array(
    'id'            => 'ta_audiovisual',
    'type'          => 'post_type',
    'args'          => array(
        'labels' 			=> array(
            'name' 				 => __( 'Audiovisual' ),
            'singular_name' 	 => __( 'Audiovisual' ),
            'add_new'            => __( 'Agregar' ),
            'add_new_item'       => __( 'Agregar nuevo Audiovisual' ),
            'edit_item'          => __( 'Editar Audiovisual' ),
            'new_item'           => __( 'Nuevo Audiovisual' ),
            'view_item'          => __( 'Ver' ),
            'search_items'       => __( 'Buscar Audiovisual' ),
            'not_found'          => __( 'No se encontraron Audiovisuales' ),
            'not_found_in_trash' => __( 'No se encontraron Audiovisuales' ),
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
        'capability_type'		=> ['article', 'articles'], //para poder cambiar el tipo de regla (apuntar a una pagina por ejemplo con pagename),
        // 'rb_config'             => array(
        //     'templates'             => array(
        //         'single'                => 'test.php'
        //     ),
        // ),
    ),
    'metaboxes'     => array(
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
        // 'ta_article_related' => array(
        //     'settings'  => array(
        //         'title'             => __('Audiovisual Relacionado', 'ta-genosha'),
        //         'context'           => 'side',
        //         'priority'          => 'high',
        //         'classes'           => array('ta-metabox'),
        //     ),
        //     'input'  => array(
        //         'controls'        => array(
        //             'text'   => array(
        //                 'label'                 => __('Audiovisual', 'ta-genosha'),
        //                 // 'description'       => __('Tamaño recomendado 900 x 600 px.', 'ta-genosha'),
        //                 'type'                  => 'RB_Post_Selector',
        //                 'query_args'            => array(
        //                     'post_type'             => 'ta_article'
        //                 ),
        //             ),
        //         ),
        //     ),
        // ),
    ),
);
