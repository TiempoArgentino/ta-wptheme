<?php

function get_terms_ids_by_slug($term_slug, $taxonomy = 'post_tag'){
    $terms_slugs = array();
    if(is_array($term_slug))
        $terms_slugs = $term_slug;
    else if(is_string($term_slug))
        $terms_slugs = [$term_slug];

    $terms_ids =  get_terms(
        array(
            'fields'    => 'ids',
            'slug'      => $terms_slugs,
            'taxonomy'  => $taxonomy,
        )
    );

    return is_wp_error($terms_ids) ? null : $terms_ids;
}

// Exclude terms by slug
function add_excluded_slug_to_args($args){
    if(!$args['exclude_slugs'] || !is_array($args['exclude_slugs']) || !count($args['exclude_slugs']))
        return $args;
    $excluded_terms_ids = get_terms_ids_by_slug($args['exclude_slugs'], $args['taxonomy']);
    $new_exclude = $excluded_terms_ids;
    if($args['exclude']){
        if(is_array($args['exclude']))
            $new_exclude = array_merge($args['exclude'], $new_exclude);
        else if(is_string($args['exclude']) && !empty($args['exclude']))
            $new_exclude = array_merge(explode(',', $args['exclude']), $new_exclude);
    }
    $args['exclude'] = $new_exclude;
    return $args;
}

function rb_terms_rest_route_callback($request){
    $bool_args = ['hide_empty','count','hierarchical','pad_counts','childless','update_term_meta_cache', 'only_include'];
    $args_default = array(
        'taxonomy'      => 'post_tag',
        'page'          => 1,
        'number'        => 0,//Get all terms
        'only_include'  => false,
        'exclude_slugs' => null,//array of slugs of terms to exclude
    );
    $args = wp_parse_args($_GET, $args_default);
    $args = add_excluded_slug_to_args($args);

    foreach($bool_args as $arg_key){
        if(isset($args[$arg_key]))
            $args[$arg_key] = rest_sanitize_boolean($args[$arg_key]);
    }

    $total_pages = 1;
    if((int)$args['number'] >= 1){
        $args['offset'] = $args['page'] >= 1 ? $args['page'] * (int)$args['number'] - (int)$args['number'] : 0;

        $every_term_query = new WP_Term_Query( wp_parse_args(['number' => 0], $args) );
        if($every_term_query && !is_wp_error($every_term_query))
            $total_pages = $every_term_query->terms ? ceil(count($every_term_query->terms) / (int)$args['number']) : 0;
    }

    $term_query = new WP_Term_Query( $args );
    if(!$term_query || is_wp_error($term_query))
        return new WP_REST_Response($term_query, 500);

    $terms = $term_query->terms;
    if( $args['only_include'] && empty($args['include']) ){
        $terms = [];
        $total_pages = 1;
    }
    $response = new WP_REST_Response($terms ? array_values($terms) : [], 200);//Array values to rebase array indexes (to avoid transformation to object in js)
    $response->header('X-WP-TotalPages', $total_pages);
    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route('rb/v1', '/terms', array(
        'methods'               => 'GET',
        'callback'              => 'rb_terms_rest_route_callback',
        'permission_callback'   => function(){
            return true;
        }
    ));
});
