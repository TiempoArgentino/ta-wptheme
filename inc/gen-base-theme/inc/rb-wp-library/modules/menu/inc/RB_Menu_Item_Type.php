<?php

/**
*   Creates a hidden post type that only appears in the menu screen with one post to use as an item.
*/
class RB_Menu_Item_Type{
    static private $static_args = array(
        'public' => true, // All the relevant settings below inherit from this setting
        'exclude_from_search' => false, // When a search is conducted through search.php, should it be excluded?
        'publicly_queryable' => false, // When a parse_request() search is conducted, should it be included?
        'show_ui' => false, // Should the primary admin menu be displayed?
        'show_in_nav_menus' => true, // Should it show up in Appearance > Menus?
        'show_in_menu' => false, // This inherits from show_ui, and determines *where* it should be displayed in the admin
        'show_in_admin_bar' => false, // Should it show up in the toolbar when a user is logged in?
        'has_archive' => false,
    );

    /**
    *   @param string $id                             The Post Type ID
    *   @param array $post_type_args                  Array of options for the post type. Some of the options are static and can not
    *                                                 be changed (setted in $static_args).
    */
    public function __construct($id, $post_type_args = array()) {
        $this->id = $id;
        $this->post_type_args = array_merge($post_type_args, self::$static_args);
        RB_Filters_Manager::add_action("rb_create_menu_item_type__$id", "init", array($this, 'register_post'));
    }

    public function register_post(){
        register_post_type( $this->id, $this->post_type_args );
        $this->create_item_placeholder();
    }

    // Creates the only post of this type that will be used as an item in the menu screen
    public function create_item_placeholder(){
        $query = new WP_Query(array(
            'post_type'         => $this->id,
            'posts_per_page'    => 1
        ));
        if($query->have_posts()) //Only create if there isnt one already
            return true;

        $new_post = array(
            'post_title'    => "Item",
            'post_status'   => 'publish',
            'post_type'     => $this->id,
        );
        $post_id = wp_insert_post($new_post);
    }
}
