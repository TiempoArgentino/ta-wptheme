<?php
// Prevent slug modification
RB_Filters_Manager::add_filter( 'ta_prevent_micrositio_slug_change', 'wp_update_term_data', function( $data, $term_id, $taxonomy ) {
    if ( $taxonomy == 'ta_article_micrositio' && !TA_Micrositio::is_setting_up_entities() ){
        $old_term = get_term($term_id);
        if($old_term->slug != $data['slug']){
            $data['slug'] = $old_term->slug;
            // wp_die('No está permitida la modificación del slug de un micrositio. Si intento editar este campo a través de un formulario, comuniqueselo a un administrador.', 'Error');
        }
    }
    return $data;
}, array(
    'priority'      => 20,
    'accepted_args' => 3,
) );

// Prevent the manual creation of new micrositio terms
RB_Filters_Manager::add_filter( 'ta_prevent_new_micrositio_term', 'pre_insert_term', function( $term, $taxonomy ) {
    if ( $taxonomy == 'ta_article_micrositio' && !TA_Micrositio::is_setting_up_entities() )
        $term = new WP_Error( 'invalid_term', 'No esta permitido agregar terms de micrositio manualmente. Estos se deben establecer desde el codigo en <b>inc\micrositios.php</b>' );
    return $term;
}, array(
    'priority'      => 20,
    'accepted_args' => 2,
) );

return array(
    'id'            => 'ta_article_micrositio',
    'type'          => 'taxonomy',
    'object_type'   => TA_ARTICLES_COMPATIBLE_POST_TYPES,
    'args'          => array(
        'labels' 			=> array(
            'name'                       => _x( 'Micrositios', 'taxonomy general name', 'ta-genosha' ),
            'singular_name'              => _x( 'Micrositio', 'taxonomy singular name', 'ta-genosha' ),
            'search_items'               => __( 'Buscar Micrositio', 'ta-genosha' ),
            'popular_items'              => __( 'Micrositios Populares', 'ta-genosha' ),
            'all_items'                  => __( 'Todos los Micrositios', 'ta-genosha' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Editar Micrositio', 'ta-genosha' ),
            'update_item'                => __( 'Actualizar Micrositio', 'ta-genosha' ),
            'add_new_item'               => __( 'Agregar un nuevo Micrositio', 'ta-genosha' ),
            'new_item_name'              => __( 'Nuevo Micrositio', 'ta-genosha' ),
            'separate_items_with_commas' => __( 'Separar Micrositios con comas', 'ta-genosha' ),
            'add_or_remove_items'        => __( 'Agregar o remover Micrositios', 'ta-genosha' ),
            'choose_from_most_used'      => __( 'Seleccionar de los Micrositios mas usados', 'ta-genosha' ),
            'not_found'                  => __( 'No se encontraron Micrositios.', 'ta-genosha' ),
            'menu_name'                  => __( 'Micrositios', 'ta-genosha' ),
        ),
        'hierarchical'      => true,
        'label'             => __( 'Micrositios' ),
        'rewrite'           => array( 'slug' => 'micrositio' ),
        'capabilities' => array(
            'manage_terms'  => 'edit_micrositios_terms',
            'edit_terms'    => 'edit_micrositios_terms',
            'delete_terms'  => 'delete_micrositios_terms',
            'assign_terms'  => 'edit_articles'
        ),
        'show_in_rest' => true, // This enables the REST API endpoint
        'query_var' => true, // This allows us to append the taxonomy param to the custom post api request.
        'show_in_nav_menus' 	=> true,
        "rb_config"			=> array(
            'unique'	=> true,
        ),
    ),
    'metaboxes'     => array(
        'ta_micrositio_sponsor' => array(
            'settings'  => array(
                'title'             => __('Sponsor', 'ta-genosha'),
                'context'           => 'side',
                'priority'          => 'high',
                'classes'           => array('ta-metabox'),
                'quick_edit'        => true,
            ),
            'input'  => array(
                'controls'		=> array(
                    'logo'      => array(
                        'label'     => __('Logo', 'ta-genosha'),
                        'type'          => 'RB_Media_Control',
                        'store_value'   => 'id',
                    ),
                    'name'      => array(
                        'label'     => __('Nombre', 'ta-genosha'),
                        'input_type'            => 'text',
                    ),
                    'link'      => array(
                        'label'     => __('Link', 'ta-genosha'),
                        'input_type'            => 'text',
                    ),
                ),
            ),
        ),
    ),
);
