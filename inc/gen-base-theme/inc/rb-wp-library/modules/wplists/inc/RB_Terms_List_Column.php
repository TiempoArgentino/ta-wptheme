<?php

class RB_Terms_List_Column extends RB_Objects_List_Column{

    public function __construct($id, $admin_pages, $title, $render_callback, $args = array()) {
        parent::__construct($id, $admin_pages, $title, $render_callback, $args);
    }

    static protected function manage_column_base_filter_tag($admin_page){
        return "manage_edit-{$admin_page}_columns";
    }

    protected function setup_screen_column($admin_page){
        RB_Filters_Manager::add_filter( "rb_tax_metabox-$this->id-column_base", self::manage_column_base_filter_tag($admin_page), array($this, 'add_column_base') );
        RB_Filters_Manager::add_filter( "rb_tax_metabox-$this->id-column_content", "manage_{$admin_page}_custom_column", array($this, 'add_column_content'), array(
            'accepted_args'  => 3,
        ));
    }

    /**
    *   Adds content to the metabox column cell on the terms list page
    *   @param string $content                              The column content
    *   @param string $columns                              Column name
    *   @param WP_Term|int|null $term                       ID or instances of the term.
    */
    public function add_column_content($content = '', $column = null, $term = null){
        if($column != $this->id)
            return '';
        $this->render_content($column, $term);
    }

    /**
    *
    */
    public function filter_column_class(){
        return "rb-taxonomy-column-content $this->column_class";
    }

    public function get_object($term){
        return get_term($term);
    }
}
