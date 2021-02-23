<?php

class GEN_Infinite_Scroll{

    /**
    *   @param mixed[] query
    *   @param mixed[] settings
    */
    public function __construct($args = array()){
        $default_query = array(
            'post_type' => get_post_type(),
            'orderby'   => 'date',
            'order'     => 'DESC',
        );

        $default_settings = array(
            /**
            *   @param WP_Post|int|null
            *   The main post. Defaults to global
            */
            'post'                      => null,
            /**
            *   @param string|callback
            *   The render for the new post
            */
            'render_callback'           => null,
            /**
            *   @param string|callback
            *   The render for the "load more" trigger
            */
            'render_trigger'            => null,
            /**
            *   @param string|callback
            *   The render for the "loading" section
            */
            'render_loading'            => null,
            /**
            *   @param string
            *   The DOM selector of the trigger button INSIDE the infinite scroll container
            */
            'trigger_selector'          => '.infinite-trigger',
        );

        $this->settings = isset($args['settings']) && is_array($args['settings']) ? array_merge($default_settings, $args['settings']) : $default_settings;
        $this->post = get_post($this->settings['post']);
        $this->query_args = isset($args['query']) && is_array($args['query']) ? array_merge($default_query, $args['query']) : $default_query;
        $this->query_args['post__not_in'] = [$this->post->ID];
    }

    public function render(){
        $query_args = htmlspecialchars(json_encode($this->query_args), ENT_QUOTES, 'UTF-8');
        $postID = $this->post->ID;
        $trigger_selector = $this->settings['trigger_selector'];
        ?>
        <div
            class="gen-infinite-scroll"
            data-trigger="<?php echo $trigger_selector; ?>"
            data-main="<?php echo $postID; ?>"
            data-current="<?php echo $postID; ?>"
            data-query="<?php echo $query_args; ?>"
        >
            <div class="list">
            </div>
            <div class="states">
                <div class="text-center">
                    <div class="spinner spinner-border text-primary" style="display: none;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="controls">
                <div class="infinite-trigger text-center mb-5">
                    <div class="btn btn-primary btn-lg">Cargar</div>
                </div>
            </div>
        </div>
        <?php
    }

}

add_action("wp_enqueue_scripts", function(){
    wp_enqueue_script( 'gen-infinite-scroll', GEN_MODULES_URI . '/infinite-scroll/index.min.js', array('jquery'), true );
    wp_localize_script(
        "gen-infinite-scroll",
        'genInfiniteScroll',
        array(
            'homeurl' => home_url(),
        )
    );
});

add_action('rest_api_init', function () {
    register_rest_route('gen/v1', '/post/html', array(
        'methods' => 'POST',
        'callback' => "get_query_post_html",
        'permission_callback'   => function(){
            return true;
        }
    ));
});

// Returns the HTML of a post single page
function get_query_post_html($request){
    $params = $request->get_json_params();
    $query_args = $params['query'];
    $query_args = array_merge($query_args, array(
        'posts_per_page'    => 1
    ));

    global $wp_query;
    $wp_query = new WP_Query($query_args);

    $have_posts = $wp_query->have_posts();
    $content = '';
    if( $wp_query->have_posts() ){
        $template = get_post_template_file($wp_query->post->ID);
        ob_start();
            include $template;
        $content = ob_get_clean();
    }

    $response = new WP_REST_Response(array(
        'have_posts'    => $have_posts,
        'found_posts'   => $wp_query->found_posts,
        'content'       => $content,
        'post'          => $have_posts ? $wp_query->post : null,
        'template'      => $template,
    ), 200);

    return $response;
}

// Returns the template file that will be used to display a post
function get_post_template_file($postID){
	global $wp_query;
	// Replace global query and save the real one to restore later
	$backup_wp_query = $wp_query;
	$wp_query = new WP_Query(array(
		'post__in' 				=> array($postID),
		'ignore_sticky_posts'	=> true,
	));
	$template = get_single_template();

	if ( ! $template ) {
		$template = get_index_template();
	}
	$template = apply_filters( 'template_include', $template );

	//Return global query back to normal
	$wp_query = $backup_wp_query;
	return $template;
}
