<?php

/**
*   Extends the metabox manager class, adding support for list columns for the meta value
*/
abstract class RB_Metabox_Column_Extension extends RB_Metabox_Base{
    /**
    *   @property mixed[]|bool $column                                      Options for the column. Can be set to true to use
    *                                                                       basic content for the column
    *   @property string|null       $title                                  Column title. If null, the meta title is used instead.
    *   @property string|callback   $content                                Content of a column cell. Can be a string or a callback
    *                                                                       that prints the content. If it is a callback, it thakes
    *                                                                       the cells $meta_value and the $wp_object as parameters.
    */
    public $column_settings = null;

    /**
    *   @param string   $meta_id                                            Key for the meta to store
    *   @property mixed[] $metabox_settings                                 The following are the extra configuration settings.
    *       @property mixed[]|bool $column                                  Options for the column. See $column_settings
    *   @param mixed[]  $control_settings                                   Options for the metabox
    */
    public function __construct($meta_id, $metabox_settings, $control_settings) {
        parent::__construct($meta_id, $metabox_settings, $control_settings);
        $this->column_settings = isset($this->metabox_settings['column']) && $this->metabox_settings['column'] ? $this->metabox_settings['column'] : null;
        $this->sanitize_column_settings();
    }

    // Registers the metabox and the column
    public function register(){
        parent::register();
        $this->column_setup();
    }

    // returns the column data based on the one stored in metabox_settings
    public function sanitize_column_settings(){
        if(!$this->has_column())
            return;
        $column = $this->column_settings;
        if(!isset($column['title']))
            $column['title'] = $this->get_title();
        $this->column_settings = $column;
    }

    public function has_column(){
        return isset($this->column_settings) && $this->column_settings;
    }

    // Sets up the column to show on the objects list.
    protected function column_setup(){
        if(!$this->has_column())
            return;
        $this->register_column();
    }

    // Should register the column using an RB_Objects_List_Column extension
    abstract protected function register_column();

    /**
    *   Renders the column content.
    *   @param string $column_id
    *   @param mixed|int|null $wp_object
    */
    public function render_column_content($column_id, $wp_object){
        if(!$this->has_column())
            return;
        $column = $this->column_settings;
        $meta_value = $this->get_value($wp_object);
        if(isset($column['content'])){
            if(is_callable($column['content']))
                call_user_func($column['content'], $meta_value, $this->get_object($wp_object));
            else if(is_string($column['content']))
                echo $column['content'];
        }
        else if(is_string($meta_value))
            echo $meta_value;
    }
}
