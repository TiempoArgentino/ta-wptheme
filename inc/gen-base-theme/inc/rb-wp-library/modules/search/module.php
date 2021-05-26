<?php

class RB_Search_Module extends RB_Framework_Module{
    static public $dependencies = array();
    static private $initialized = false;
    static private $post_type_custom_search_template = false;

    static public function initialize(){
        if(self::$initialized)
            return false;
        add_action( 'template_include', array(self::class, 'search_redirect') );
        //deprecated
        //add_filter( 'pre_get_posts', array(self::class, 'set_search_query_post_type') );
        return true;
    }

    /**
    *   Activates the use of custom posts type search templates.
    *   Global post type will be used
    *   Search templates must have the next format: search-{$post_type}.php
    *   If the template is not found, search will fallback to the basic template search.php
    */
    static public function activate_post_type_search_template(){
        self::$post_type_custom_search_template = true;
    }

    static public function search_redirect($template){
        if(!self::$post_type_custom_search_template)
            return $template;

        $is_search = is_search();
        $post_type = get_post_type();

        if($is_search && is_string($post_type)){
            $new_template = locate_template( array( "search-$post_type.php" ) );
            if ( '' != $new_template ) {
                return $new_template ;
            }
        }

        return $template;
    }

    //deprecated
    static public function set_search_query_post_type( $query ) {
        if(!self::$post_type_custom_search_template)
            return $query;

        $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : null;

        if ( $query->is_search && $post_type ) {
    	       $query->set( 'post_type', $post_type );
        }
        //var_dump($query);
        return $query;
    }
}
RB_Search_Module::initialize();
