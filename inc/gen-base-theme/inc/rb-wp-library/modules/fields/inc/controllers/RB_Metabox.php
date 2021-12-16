<?php

class RB_Metabox extends RB_Metabox_Column_Extension{
    use RB_Post_Methods;
    public $metabox_settings = array(
        'title'         => '',
        'admin_page'	=> 'post',
        'context'		=> 'advanced',
        'priority'		=> 'default',
        'classes'		=> '',
        'column'        => null,
    );

    public function __construct($id, $metabox_settings, $control_settings) {
        parent::__construct($id, $metabox_settings, $control_settings);
        $this->register();
    }

    protected function set_metafield(){
        $this->meta_field = new RB_Post_Meta_Control($this->meta_id, $this->control_settings, $this->get_field_args());
    }

    /**
    *   Registers the metabox to be used on the post edition page.
    */
    public function register_metabox(){
        // add_action( 'load-post.php', array($this, 'metabox_setup') );
        // add_action( 'load-post-new.php', array($this, 'metabox_setup') );
        $this->metabox_setup();
        // quick edit
        if( isset($this->metabox_settings['quick_edit']) && $this->metabox_settings['quick_edit'] ){
            $admin_pages = $this->get_admin_pages();
            foreach($admin_pages as $admin_page){
                add_filter( "manage_{$admin_page}_posts_columns", array($this, 'add_dummy_column'));
                add_filter( "manage_edit-{$admin_page}_columns", array($this, 'remove_dummy_column'));
            }
            add_filter( "quick_edit_custom_box", array($this, 'render_quick_edit_content'), 10, 2);
        }

    }

    // =========================================================================
    // METABOX SETUP
    // =========================================================================

    public function metabox_setup(){
        /* Add meta boxes on the 'add_meta_boxes' hook. */
        add_action( 'add_meta_boxes', array($this, 'add_metabox') );
        /* Save post meta on the 'save_post' hook. */
        add_action( 'save_post', array($this->meta_field, 'save_metabox'), 10, 2 );
    }

    /* Creates the metabox to be displayed on the post editor screen. */
    public function add_metabox(){
        extract( $this->metabox_settings );
        add_meta_box( $this->meta_id, $title, array($this, 'render_meta_field'), $this->get_admin_pages(), $context, $priority);
        $this->add_metabox_classes();
    }

    // Adds classes to the metabox container
    public function add_metabox_classes(){
        if( is_array($this->metabox_settings['classes']) ){
            $admin_pages = $this->get_admin_pages();
            foreach($admin_pages as $admin_page){
                add_filter( "postbox_classes_{$admin_page}_{$this->meta_id}", function( $classes = array() ){
                    foreach ( $this->metabox_settings['classes'] as $class ) {
                        if ( ! in_array( $class, $classes ) ) {
                            $classes[] = sanitize_html_class( $class );
                        }
                    }
                    return $classes;
                });
            }
        }
    }

    // =========================================================================
    // COLUMN
    // =========================================================================

    protected function register_column(){
        $column = $this->column_settings;
        new RB_Posts_List_Column($this->meta_id, $this->get_admin_pages(), $column['title'], array($this, 'render_column_content'), $column);
    }

    // =========================================================================
    // METHODS
    // =========================================================================

    public function meta_exists($post_id){
        return metadata_exists( 'post', $post_id, $this->meta_id );
    }

    /**
    *   Returns the meta value for a post
    *   @param WP_Post|int $post                                Post id or instance from which to get the meta value from
    */
    public function get_value($post){
        $post = get_post($post);
        return $post && !is_wp_error($post) && metadata_exists('post', $post->ID, $this->meta_id) ? get_post_meta( $post->ID, $this->meta_id, true ) : null;
    }


    // =========================================================================
    // QUICK EDIT
    // =========================================================================

    /**
    *   Adds a placeholder column that will be hidden from the UI.
    *   Wordpress needs a custom column to render a quick edit fild
    */
    public function add_dummy_column( $posts_columns ){
        $posts_columns[$this->meta_id] = $this->meta_id;
    	return $posts_columns;
    }

    // But remove it again on the edit screen (other screens to?)
    public function remove_dummy_column($posts_columns){
        // unset($posts_columns[$this->meta_id]);
        return $posts_columns;
    }

    // Quick edit render
    public function render_quick_edit_content( $column_name, $post_type ){
        if ($column_name != $this->meta_id) return;

        ?>
        <fieldset id="<?php esc_attr($this->meta_id); ?>" class="inline-edit-col-left">
            <div class="inline-edit-col">
                <span class="title">-----------</span>
                <div>
                    <?php $this->render_meta_field(null); ?>
                </div>
            </div>
        </fieldset>
        <?php

    }


}
