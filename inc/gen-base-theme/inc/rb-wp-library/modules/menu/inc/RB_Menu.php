<?php

if(!class_exists('RB_Menu')){
    class RB_Menu{
        /*Returns a theme menu, given the theme_location slug with wich it was registered.*/
        static function get_theme_menu( $theme_location ) {
        	if( ! $theme_location ) return false;

        	$theme_locations = get_nav_menu_locations();
        	if( ! isset( $theme_locations[$theme_location] ) ) return false;

        	$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );
        	if( ! $menu_obj ) $menu_obj = false;

        	return $menu_obj;
        }

        /*Returns a menu's items*/
        static function get_menu_items( $theme_location, $args = array() ) {
            $settings = array(
                'tree'  => true,
            );

            if(!is_array($args))
                trigger_error('Argument $args of RB_Menu::get_menu_items() expects an <b>array</b>, <b>'. gettype($args) .'</b> given');
            else
                $settings = is_array($args) ? wp_parse_args($args, $settings) : $settings;

        	$items = array();
        	$menu = self::get_theme_menu($theme_location);
        	if($menu && !is_wp_error($menu)){
        		$items = wp_get_nav_menu_items($menu->term_id, $args);
        		if(is_array($items) && $settings['tree']){
                    $items = array_to_tree($items, function(&$a, &$b){
                        $b->menu_info = self::menu_item_info($b);
                        return $a->menu_item_parent == $b->ID;
                    });
        		}
        	}
        	return $items;
        }

        /* Returns the information for a menu item, related to the current page
        * it is on. */
        static function menu_item_info($item){
            if(!isset($item))
                return null;

            $queried_object = get_queried_object();
            $menu_info = array(
                'is_current'                => false,
                'is_parent'                 => false,
                'is_ancestor'               => false,
                'is_current_term'           => false,
                'is_current_term_ancestor'  => false, //yet to develop
                //'is_child'      => false,
                //'is_decendet'   => false,
            );

            //If there is not a queried object
            if(!isset($queried_object))
                return $menu_info;

            //Current queried object is a POST
            if(property_exists($queried_object, 'post_type')){
                //Item is post and has same type as current post
                if( $item->type == 'post_type' && (get_post_type($queried_object) == $item->object) ){
                    //Item is current post
                    if( $item->object_id == $queried_object->ID )
                        $menu_info['is_current'] = true;
                    //Item is post parent
                    else if( $item->object_id == $queried_object->post_parent ){
                        $menu_info['is_parent'] = true;
                        $menu_info['is_ancestor'] = true;
                    }
                    //Check if item is an ancestor of current post
                    else{
                        $queried_ancestors = get_post_ancestors($queried_object);
                        if(is_array($queried_ancestors)){
                            foreach ($queried_ancestors as $parent_id){
                                if($item->object_id == $parent_id){
                                    $menu_info['is_ancestor'] = true;
                                    break;
                                }
                            }
                        }
                    }
                }
                //Item is term
                if($item->type == 'taxonomy'){
                    $post_terms = wp_get_post_terms($queried_object->ID, $item->object);
                    if(is_array($post_terms)){
                        foreach($post_terms as $post_term){
                            //Item is one of the terms of the post
                            if($item->object_id == $post_term->term_id){
                                $menu_info['is_current_term'] = true;
                                break;
                            }
                        }
                    }
                }
            }
            //Current queried object is a TERM
            else if(property_exists($queried_object, 'term_id') && term_exists($queried_object->term_id)){
                //Item is term and has same taxonomy as current term
                if($item->type == 'taxonomy' && ($item->object == $queried_object->taxonomy)){
                    //Item is current term
                    if( $item->object_id == $queried_object->term_id )
                        $menu_info['is_current'] = true;
                    //Item is term parent
                    else if( $item->object_id == $queried_object->parent ){
                        $menu_info['is_parent'] = true;
                        $menu_info['is_ancestor'] = true;
                    }
                    //Item is term ancestor
                    else{
                        $queried_ancestors = get_ancestors( $queried_object->term_id, $queried_object->taxonomy, 'taxonomy' );
                        if(is_array($queried_ancestors)){
                            foreach ($queried_ancestors as $parent_id){
                                if($item->object_id == $parent_id){
                                    $menu_info['is_ancestor'] = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            return $menu_info;
        }

    }
}
