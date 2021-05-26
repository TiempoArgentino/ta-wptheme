<?php
/**
*   Manages the fields on a menu item of a post type.
*/
class RB_Menu_Item_Meta extends RB_Metabox_Base{
    use RB_Post_Methods;
    public $metabox_settings = array(
        'title'         => '',
        'admin_page'	=> null,
        'context'		=> 'advanced',
        'priority'		=> 'default',
        'classes'		=> '',
    );

    public function __construct($id, $metabox_settings, $control_settings ) {
        parent::__construct($id, $metabox_settings, $control_settings);
        $this->register();
    }

    protected function set_metafield(){
        $this->meta_field = new RB_Post_Meta_Control($this->meta_id, $this->control_settings, $this->get_field_args());
    }

    // Registers the metabox render and save
    public function register_metabox(){
        /* Hook the fields to the menu item of the post type. */
        add_action( 'wp_nav_menu_item_custom_fields', array($this, 'render_metafield'), 10, 4 );
        /* Save post meta on the 'save_post' hook. */
        add_action( 'wp_update_nav_menu_item', array($this, 'save_meta_value'), 10, 2 );
    }

    /* Renders the metabox */
    public function render_metafield($item_id, $item, $depth, $args){
        if(!$this->is_on_admin_page($item->object))
            return false;
        $this->set_current_item_id($item_id);
        $this->meta_field->field_controller->set_value($this->get_value($item));
        ?><div class="description description-wide"><?php
        $this->render_meta_field($item);
        ?></div><?php
    }

    public function save_meta_value( $menu_id, $item_id ) {
        $this->set_current_item_id($item_id);
        $this->meta_field->save_metabox($item_id, null);
    }

    /**
    *   Returns if the current menu item if of any of the types wanted.
    *   @param string $item_object                                  An object type from a menu item
    */
    public function is_on_admin_page($item_object){
        if(!isset($this->metabox_settings['admin_page']) || empty($this->metabox_settings['admin_page']))
            return true;

        if(is_array($this->metabox_settings['admin_page'])){
            foreach($this->metabox_settings['admin_page'] as $admin_page){
                if($item_object == $admin_page)
                    return true;
            }
        }

        if($item_object == $this->metabox_settings['admin_page'])
            return true;

        return false;
    }

    /**
    *   Sets the id for the current item being processed
    *   @param int $item_id                                 The menu item ID
    */
    public function set_current_item_id($item_id){
        $this->item_id = $item_id;
        $this->field_id = "{$this->meta_id}__{$this->item_id}";
        $this->meta_field->set_field_id($this->field_id);
    }

    /**
    *   Returns the meta value for a post
    *   @param WP_Post|int $post                                Post id or instance from which to get the meta value from
    */
    public function get_value($post){
        $post = get_post($post);
        return $post && metadata_exists('post', $post->ID, $this->meta_id) ? get_post_meta( $post->ID, $this->meta_id, true ) : null;
    }

    public function meta_exists($post_id){
        return metadata_exists( 'post', $post_id, $this->meta_id );
    }
}
