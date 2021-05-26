<?php


class RB_Posts_List_Column extends RB_Objects_List_Column{

    public function __construct($id, $admin_pages, $title, $render_callback, $args = array()) {
        parent::__construct($id, $admin_pages, $title, $render_callback, $args);
    }

    static protected function manage_column_base_filter_tag($admin_page){
        return "manage_{$admin_page}_posts_columns";
    }

    /**
    *   Sets up the column to show on the posts list.
    */
    protected function setup_screen_column($admin_page){
        RB_Filters_Manager::add_filter( "rb_metabox-$this->id-column_base", self::manage_column_base_filter_tag($admin_page), array($this, 'add_column_base') );
        RB_Filters_Manager::add_filter( "rb_metabox-$this->id-column_content", "manage_{$admin_page}_posts_custom_column", array($this, 'add_column_content'), array(
            'accepted_args'  => 2,
        ));
    }

    /**
    *   Adds content to the metabox column cell on the posts list page
    *   @param string $columns                              Column name
    *   @param WP_Post|int|null $post                       ID or instances of the post.
    */
    public function add_column_content($column, $post){
        if($column != $this->id)
            return '';
        $this->render_content($column, $post);
    }

    public function get_object($post){
        return get_post($post);
    }

    static public function remove($filter_id, $admin_page, $columns_remove, $args = array()){
        if(!is_array($columns_remove) && !is_string($columns_remove))
            return;

        $default_args = array(
            'priority'  => 10,
        );
        $args = array_merge($default_args, $args);

        RB_Filters_Manager::add_filter( $filter_id, "manage_{$admin_page}_posts_columns", function($columns) use ($columns_remove){
            $columns_remove = is_array($columns_remove) ? $columns_remove : [$columns_remove];
            foreach($columns_remove as $col_remove_id){
                unset($columns[$col_remove_id]);
            }
            return $columns;
        }, array(
            'priority'  => $args['priority'],
        ));
    }
}
