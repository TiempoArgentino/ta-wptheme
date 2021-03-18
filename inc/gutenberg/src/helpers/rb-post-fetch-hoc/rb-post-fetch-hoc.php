<?php

function rb_posts_rests_route_callback($request){
    $params = $request->get_json_params();
    $query_args = isset($params['args']) && is_array($params['args']) ? $params['args'] : null;
    $posts_fetch_data = rb_get_posts($query_args);

    if(!$posts_fetch_data || is_wp_error($posts_fetch_data))
        return new WP_REST_Response($posts_fetch_data, 500);

    $posts = $posts_fetch_data['posts'];
    // =============================================================================
    // RESPONSE
    // =============================================================================
    $response = new WP_REST_Response($posts, 200);
    $response->header('X-WP-TotalPages', $total_pages);
    // print_r($args);
    // var_dump(count($posts));
    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route('rb/v1', '/posts', array(
        'methods' => 'POST',
        'callback' => 'rb_posts_rests_route_callback',
        'permission_callback'	=> '__return_true',
    ));
});
