<?php

abstract class RB_Objects_List_Column{
    /**
    *   @property string $id
    *   Id of the column
    */
    public $id;

    /**
    *   @property string[]|string $admin_pages
    *   String or array of strings representing the slug of the wp object screens where to add the new column
    */
    public $admin_pages;

    /**
    *   @property string $title
    *   Title to show on the column header
    */
    public $title;

    /**
    *   @property callback $render_callback
    *   The callback that renders the column content. This arguments are passed through
    *   @param string $column                               The column id
    *   @param mixed|int|null $wp_object                    The wordpress object
    */
    public $render_callback;

    /**
    *   @property string $cell_class
    *   Class for the div containing the cell content
    */
    public $cell_class = '';

    /**
    *   @property int $position
    *   Position of the column on the list. Defaults to the last position posible during runtime
    *   First position is 0
    */
    public $position = null;

    /**
    *   @property callback|null $should_add
    *   A function that returns a bool indicating wheter the column should be added or not
    *   If the value is null, the column will always be added
    */
    protected $should_add = null;

    public function __construct($id, $admin_pages, $title, $render_callback, $args = array()) {
        $this->id = $id;
        $this->admin_pages = $admin_pages;
        $this->title = $title;
        $this->render_callback = $render_callback;
        $this->cell_class = isset($args['cell_class']) && is_string($args['cell_class']) ? $args['cell_class'] : $this->cell_class;
        $this->position = isset($args['position']) && is_int($args['position']) ? $args['position'] : $this->position;
        $this->should_add = isset($args['should_add']) && is_callable($args['should_add']) ? $args['should_add'] : $this->should_add;
        $this->column_setup();
    }

    /**
    *   Sets up the column to show on the list of wp objects.
    */
    protected function column_setup(){
        foreach($this->get_admin_pages() as $admin_page){
            $this->setup_screen_column($admin_page);
        }
    }

    /**
    *   @param string $admin_page                                               ID of the entity admin page (post, page, category, etc)
    *   @return string filter tag for the column base managment for an admin_page
    */
    abstract static protected function manage_column_base_filter_tag($admin_page);
    /**
    *   Sets up the column to show on the objects list.
    *   @param string $admin_page                                               ID of the entity admin page (post, page, category, etc)
    */
    abstract protected function setup_screen_column($admin_page);
    /**
    *   Must return the correct object to work with.
    *   @param WP_Term|WP_Post|mixed $wp_object
    *   @return mixed
    */
    abstract protected function get_object($wp_object);

    /**
    *   Adds the metabox column to the wp objects list. The content is then set by render_content
    *   @param string[] $columns                            Columns names array
    */
    public function add_column_base($columns){
        $original_columns = $columns;
        if(!$this->check_should_add())
            return $original_columns;
        $columns_amount = count($original_columns);
        $position = is_int($this->position) && $this->position >= 0 && $this->position < $columns_amount ? $this->position : $columns_amount;

        if($position == $columns_amount)
            $columns[$this->id] = $this->title;
        else
            array_splice( $columns, $position, 0, array( $this->id => $this->title) );
        return $columns;
    }

    /**
    *   @return bool Wheter the column should be added, based on a callback provided
    *   on construct through the arg `should_add`. If no callback was provided, then
    *   `true` is returned.
    */
    public function check_should_add(){
        if(!$this->should_add || !is_callable($this->should_add))
            return true;
        return call_user_func($this->should_add);
    }

    /**
    *   Render the content for this column
    *   @param string $columns                              Column name
    *   @param mixed|int|null $wp_object                    ID or instances of the wp object.
    */
    public function render_content($column, $wp_object = null){
        if( is_callable($this->render_callback) ):
            ?>
            <div class="rb-object-column <?php echo esc_attr($this->filter_cell_class()); ?>">
                <?php call_user_func($this->render_callback, $column, $this->get_object($wp_object)); ?>
            </div>
            <?php
        endif;
    }

    /**
    *   Returns the admin pages where this metabox will be added
    *   @return string[]
    */
    public function get_admin_pages(){
        return is_array($this->admin_pages) ? $this->admin_pages : [$this->admin_pages];
    }

    /**
    *
    */
    public function filter_cell_class(){
        return $this->cell_class;
    }

    /**
    *   Removes one or more columns from an objects list
    *   @param string $filter_id                                                ID for the filter stored in the filter manager. It allows this action to be
    *                                                                           removed using RB_Filters_Manager::remove_filter
    *   @param string|string[] $admin_pages                                     Admin page or pages IDs
    *   @param string|string[] $columns_remove                                  Column or columns ids to remove
    *   @param mixed[] $args
    *       @param int $priority                                                Filter priority
    */
    static public function remove($filter_id, $admin_pages, $columns_remove, $args = array()){
        if(!is_array($columns_remove) && !is_string($columns_remove))
            return;

        $default_args = array(
            'priority'  => 10,
        );
        $args = array_merge($default_args, $args);

        $admin_pages = is_array($admin_pages) ? $admin_pages : [$admin_pages];
        foreach($admin_pages as $admin_page){
            $page_filter_id = count($admin_pages) == 1 ? $filter_id : "{$filter_id}-$admin_page";
            RB_Filters_Manager::add_filter( $page_filter_id, static::manage_column_base_filter_tag($admin_page), function($columns) use ($columns_remove){
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
}
