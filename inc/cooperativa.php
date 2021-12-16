<?php

class Cooperativa_TA
{
    public function __construct()
    {
        add_action( 'init', [$this,'cooperativa'] );
        add_action( 'init', [$this,'sectores'] );


    }

    public function cooperativa() {

        /**
         * Post Type: Cooperativa.
         */
    
        $labels = [
            'name' => __( 'Cooperativa', 'gen-base-theme' ),
            'singular_name' => __( 'Cooperativa', 'gen-base-theme' ),
            'menu_name' => __( 'Cooperativa', 'gen-base-theme' ),
            'all_items' => __( 'Todes', 'gen-base-theme' ),
            'add_new' => __( 'Añadir', 'gen-base-theme' ),
            'add_new_item' => __( 'Añadir', 'gen-base-theme' ),
            'edit_item' => __( 'Editar', 'gen-base-theme' ),
            'new_item' => __( 'Añadir', 'gen-base-theme' ),
            'view_item' => __( 'Ver', 'gen-base-theme' ),
            'view_items' => __( 'Ver', 'gen-base-theme' ),
            'search_items' => __( 'Buscar', 'gen-base-theme' ),
            'parent' => __( 'Superior', 'gen-base-theme' ),
            'parent_item_colon' => __( 'Superior', 'gen-base-theme' ),
        ];
    
        $args = [
            'label' => __( 'Cooperativa', 'gen-base-theme' ),
            'labels' => $labels,
            'description' => '',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'rest_base' => '',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'has_archive' => false,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'delete_with_user' => false,
            'exclude_from_search' => false,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'hierarchical' => false,
            'rewrite' => [ 'slug' => 'cooperativa', 'with_front' => true ],
            'query_var' => true,
            'supports' => [ 'title', 'editor', 'thumbnail' ],
            'taxonomies' => [ 'sector' ],
            'menu_icon' => 'dashicons-edit',
            'show_in_graphql' => false,
        ];
    
        register_post_type( 'cooperativa', $args );
    }
    
    public function sectores() {

        /**
         * Taxonomy: Sectores.
         */
    
        $labels = [
            'name' => __( 'Sectores', 'gen-base-theme' ),
            'singular_name' => __( 'Sector', 'gen-base-theme' ),
            'menu_name' => __( 'Sectores', 'gen-base-theme' ),
        ];
    
        
        $args = [
            'label' => __( 'Sectores', 'gen-base-theme' ),
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'query_var' => true,
            'rewrite' => [ 'slug' => 'sector', 'with_front' => true, ],
            'show_admin_column' => false,
            'show_in_rest' => true,
            'rest_base' => 'sector',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'show_in_quick_edit' => false,
            'show_in_graphql' => false,
        ];
        register_taxonomy( 'sector', [ 'cooperativa' ], $args );
    }

    public function parent_terms()
    {
        $parents = get_terms(['taxonomy' => 'sector', 'parent' => 0]);

        return $parents;
    }

    public function child_terms($parent_id)
    {
        $parents = get_terms(['taxonomy' => 'sector', 'parent' => $parent_id]);

        return $parents;
    }

    public function get_coop($terms)
    {
        $args = [
            'post_type' => 'cooperativa',
            'post_status' => 'publish',
            'numberposts' => -1,
            'tax_query' => [
                [
                    'taxonomy' => 'sector',
                    'field' => 'slug',
                    'terms' => $terms
                ]
            ]
        ];

        return get_posts($args);
    }
      
}

function cooperativa()
{
    return new Cooperativa_TA();
}

cooperativa();