<?php

class RB_Posts_Views_Tracker{
    static private $check_ip = true;
    static private $check_cookie = true;
    static private $track_views = false;
    static private $posts_views_meta_key = 'rb_post_views_count';

    /**
    *   Tracks the amount of views a post have and stores it in the rb_post_views_count post meta
    *   @param mixed[] $config                                                  Array containing the params. See set_config
    */
    static public function track_views($config = array()){
        if(self::$track_views)
            return false;
        self::$track_views = true;
        self::set_config($config);


        require_once plugin_dir_path( __FILE__ ) . 'RB_Posts_Views_Database.php';
        //To keep the count accurate, lets get rid of prefetching
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        add_action('save_post', array(self::class, 'set_default_post_views_meta'), 10, 3);
        return add_action( 'wp_head', array(self::class, 'track_post_views'), 0);
    }

    /**
    *   Sets the tracker configuration
    *   @param bool check_ip                                                    Indicates if the view shouldn't be counted if the current
    *                                                                           ip has already visited the post
    *   @param bool check_cookie                                                Indicates if the view shouldn't be counted if the current
    *                                                                           browser has the tracker cookie stored for this post
    */
    static private function set_config($config = array()){
        $config = array_merge(array(
            'check_ip'      => true,
            'check_cookie'  => true,
        ), is_array($config) ? $config : []);
        self::$check_ip = $config['check_ip'];
        self::$check_cookie = $config['check_cookie'];
    }

    /**
    *   Sets a default value of 0 on post creation/update to the posts views meta
    */
    static public function set_default_post_views_meta($postID){
        $meta_value = get_post_meta($postID, self::$posts_views_meta_key, true);
        if( !wp_is_post_revision($postID) && $meta_value !== '0' && (!$meta_value || $meta_value == '')  )
            update_post_meta( $postID, 'rb_post_views_count', '0');
    }

    /**
    *   If on a single template, update de current post views counter
    *   @param int|WP_Post|null $post                                     Post ID or WP_Post instance. Global post if null
    */
    static public function track_post_views($post = null){
        if ( !is_single() ) return;
        $post = get_post( $post );
        self::update_post_views($post->ID);
    }

    /**
    *   Increases by one the post views counter in the post meta
    *   @param int|WP_Post|null $post                                     Post ID or WP_Post instance. Global post if null
    */
    static private function update_post_views($post = null){
        if(!self::is_viewer_accountable($post))
            return false;
        $post = get_post( $post );
        $count = get_post_meta($post->ID, self::$posts_views_meta_key, true);
        $count = !$count && $count !== 0 ? 0 : $count;
        update_post_meta($post->ID, self::$posts_views_meta_key, $count + 1);
        self::store_user_info($post);
    }

    /**
    *   Indicates if this view should be counted
    *   @param int|WP_Post|null $post                                     Post ID or WP_Post instance. Global post if null
    */
    static private function is_viewer_accountable($post = null){
        $post = get_post( $post );

        //Check cookies
        if(self::$check_cookie && isset($_COOKIE["rb-postviewed-$post->ID"]) && $_COOKIE["rb-postviewed-$post->ID"])
            return false;
        //Check ip on database
        if(self::$check_ip && RB_Post_Views_Database::get_view($post))
            return false;

        return true;
    }

    /**
    *   Set cookies and store the user ips on the database
    *   @param int|WP_Post|null $post                                     Post ID or WP_Post instance. Global post if null
    */
    static private function store_user_info($post = null){
        if(self::$check_cookie)
            self::set_viewed_post_cookie($post = null);
        if(self::$check_ip)
            self::store_viewer_data($post = null);
    }

    /**
    *   Sets a post viewed cookie
    *   @param int|WP_Post|null $post                                     Post ID or WP_Post instance. Global post if null
    */
    static private function set_viewed_post_cookie($post = null){
        $post = get_post( $post );
        $cookielength = time()+(60*60*24*0.3);
        setcookie("rb-postviewed-$post->ID", $post->ID, $cookielength);
    }

    /**
    *   Stores the ips of the current viewer
    */
    static private function store_viewer_data($post = null){
        $post = get_post( $post );
        RB_Post_Views_Database::insert_view(array(
            'post_id'                           => $post->ID,
            'view_date'                         => date('Y-m-d H:i:s', time()),
            'user_remote_addr'                  => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null,
            'user_http_x_forwarded_for'         => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : null,
        ));
    }

}
