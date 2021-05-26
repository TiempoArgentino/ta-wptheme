<?php

// FILTERS THE TITLE OF A EDICION IMPRESA POST PAGE
RB_Filters_Manager::add_filter('ta_ed_impresa_single_title', 'document_title_parts', function($title_parts){
    if(is_single() && get_post_type() == 'ta_ed_impresa'){
        global $post;
        $ed_impresa = TA_Article_Factory::get_article($post);
        $title_parts['title'] = 'Edición Impresa ' . $ed_impresa->title;
    }
    return $title_parts;
}, array(
    'accepted_args' => 1,
));

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
return array(
    'id'            => 'ta_ed_impresa',
    'type'          => 'post_type',
    'args'          => array(
        'labels' 			=> array(
            'name' 				 => __( 'Ediciones Impresas' ),
            'singular_name' 	 => __( 'Edición Impresa' ),
            'add_new'            => __( 'Agregar' ),
            'add_new_item'       => __( 'Agregar nueva Edición Impresa' ),
            'edit_item'          => __( 'Editar Edición Impresa' ),
            'new_item'           => __( 'Nueva Edición Impresa' ),
            'view_item'          => __( 'Ver' ),
            'search_items'       => __( 'Buscar Edición Impresa' ),
            'not_found'          => __( 'No se encontraron Ediciones Impresas' ),
            'not_found_in_trash' => __( 'No se encontraron Ediciones Impresas' ),
        ),
        'public' 				=> true,
        'has_archive' 			=> 'ediciones-impresas', //slug para archivo (usado por fecha en este caso)
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
        'capability_type'		=> ['ed_impresa', 'eds_impresas'], //para poder cambiar el tipo de regla (apuntar a una pagina por ejemplo con pagename),
        // 'rb_config'             => array(
        //     'templates'             => array(
        //         'single'                => 'test.php'
        //     ),
        // ),
    ),
    'metaboxes'     => array(
        'issuefile_attachment_id' => array(
            'settings'  => array(
                'title'             => __('PDF Portada', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
                'quick_edit'        => true,
            ),
            'input'  => array(
                'controls'		=> array(
                    'logo'      => array(
                        //'label'     => __('Logo a color', 'ta-genosha'),
                        'button_label'  => 'Seleccionar PDF',
                        'type'          => 'RB_Media_Control',
                        'store_value'   => 'id',
                        'mime_type'     => ['application/pdf'],
                    ),
                ),
            ),
        ),
    ),
);
