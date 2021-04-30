<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
return array(
    'id'            => 'ta_fotogaleria',
    'type'          => 'post_type',
    'args'          => array(
        'labels' 			=> array(
            'name' 				 => __( 'Fotogalerias' ),
            'singular_name' 	 => __( 'Fotogaleria' ),
            'add_new'            => __( 'Agregar' ),
            'add_new_item'       => __( 'Agregar nueva Fotogaleria' ),
            'edit_item'          => __( 'Editar Fotogaleria' ),
            'new_item'           => __( 'Nueva Fotogaleria' ),
            'view_item'          => __( 'Ver' ),
            'search_items'       => __( 'Buscar Fotogaleria' ),
            'not_found'          => __( 'No se encontraron Fotogalerias' ),
            'not_found_in_trash' => __( 'No se encontraron Fotogalerias' ),
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
        'capability_type'		=> ['fotogaleria', 'fotogalerias'], //para poder cambiar el tipo de regla (apuntar a una pagina por ejemplo con pagename),
        // 'rb_config'             => array(
        //     'templates'             => array(
        //         'single'                => 'test.php'
        //     ),
        // ),
    ),
    'metaboxes'     => array(
        'ta_article_gallery' => array(
            'settings'  => array(
                'title'             => __('Galeria', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
                'quick_edit'        => false,
            ),
            'input'  => array(
                'repeater'          => array(
                    'item_title'        => 'Media ($n)',
                    'accordion'         => true,
                ),
                'controls'		=> array(
                    'media'      => array(
                        //'label'     => __('Logo a color', 'ta-genosha'),
                        'type'          => 'RB_Media_Control',
                        'store_value'   => 'id',
                    ),
                ),
            ),
        ),
    ),
);
