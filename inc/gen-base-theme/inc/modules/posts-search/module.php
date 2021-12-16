<?php

class GEN_Posts_Search
{

    /**
    *   @param mixed[] query
    *   @param mixed[] settings
    */
    public function __construct($args = array())
    {
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

    public function render()
    {
    }
}

add_action("wp_enqueue_scripts", function () {
    wp_enqueue_script('gen-posts-seach', GEN_MODULES_URI . '/posts-search/index.min.js', array('jquery'), true);
    wp_localize_script(
        "gen-posts-seach",
        'postSearch',
        array(
        'homeurl' => home_url(),
    ));
});
