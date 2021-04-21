<?php

class RB_Gutenberg_Categories {
    static private $initialized = false;
    static private $blocks_categories = [];

    public static function initialize(){
        if( self::$initialized )
            return false;
        self::$initialized = true;

        RB_Filters_Manager::add_filter('rb_add_gutenberg_blocks_categories', 'block_categories', array(self::class, 'register_blocks_categories'), array(
            'priority'		=> 10,
            'accepted_args'	=> 2,
        ));
    }

    /**
    *   Filters the blocks categories, adding the ones added using the add_blocks_category method
    */
    public static function register_blocks_categories($categories, $post){
        $categories_sorted = array();

        foreach (self::$blocks_categories as $category_slug => $category_data) {
            $categories_sorted[] = $category_data;
        }

        foreach ($categories as $category) {
            $categories_sorted[] = $category;
        }

        return $categories_sorted;
        return array_merge($categories, self::$blocks_categories);
    }

    /**
    *   Adds a new block category to classify blocks in the editor
    */
    public static function add_blocks_category($slug, $title, $icon = null){
        if( isset(self::$blocks_categories[$slug]) )
            return false;
        self::$blocks_categories[$slug] = array(
            'slug'      => $slug,
            'title'     => $title,
            'icon'      => $icon,
        );
        return true;
    }

}

RB_Gutenberg_Categories::initialize();
