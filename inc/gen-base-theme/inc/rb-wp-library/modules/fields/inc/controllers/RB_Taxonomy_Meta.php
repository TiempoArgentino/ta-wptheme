<?php
class RB_Taxonomy_Form_Field extends RB_Metabox_Column_Extension{
    use RB_Term_Methods;
    public $add_form = false;
    public $terms;
    public $metabox_settings = array(
        'context'		=> 'advanced',
        'priority'		=> 'default',
        'classes'		=> '',
        'terms'         => array('post_tag'),
        'column'        => null,
    );

    public function __construct($id, $metabox_settings, $control_settings) {
        parent::__construct($id, $metabox_settings, $control_settings);
        $this->add_form = isset($this->metabox_settings['add_form']) ? $this->metabox_settings['add_form'] : null;
        $this->terms = isset($this->metabox_settings['terms']) ? $this->metabox_settings['terms'] : null;
        $this->register();
    }

    protected function set_metafield(){
        $this->meta_field = new RB_Term_Meta_Control($this->meta_id, $this->control_settings, $this->get_field_args());
    }

    /**
    *   Registers the metabox to be used on the new and edit term forms
    *   Setups the column in the terms list
    */
    public function register_metabox(){
        $this->add_form_actions();
    }

    // =========================================================================
    // METABOX SETUP
    // =========================================================================
    protected function add_form_actions(){
        foreach( $this->terms as $term_slug ){
            add_action( $term_slug . "_edit_form_fields", array($this, 'edit_form_fields_row') );
            if( $this->add_form )
                add_action( $term_slug . "_add_form_fields", array($this, 'add_form_fields_container') );
        }
        add_action('edited_term', array($this->meta_field, 'save_metabox'), 10, 2);
        add_action("created_term", array($this->meta_field, 'save_metabox') );
    }

    //Displays the table row for the edit form
    public function edit_form_fields_row($term_obj){
        ?>
        <tr class="form-field rb-tax-form-field">
            <th scope="row" valign="top"><label for="<?php echo $this->meta_id; ?>"><?php _e( $this->get_title() ); ?></label></th>
            <td>
                <?php $this->render_meta_field($term_obj); ?>
            </td>
        </tr>
        <?php
    }

    //Displays the control on the add term form
    public function add_form_fields_container($term_obj){
        $class = isset($this->metabox_settings['term_add_container_class']) ? $this->metabox_settings['term_add_container_class'] : '';
        ?>
        <div class="form-field add-form-field <?php echo esc_attr($class); ?>">
            <label for="tag-description"><?php echo $this->get_title(); ?></label>
            <?php $this->render_meta_field($term_obj); ?>
        </div>
        <?php
    }

    // =========================================================================
    // COLUMN
    // =========================================================================

    protected function register_column(){
        $column = $this->column_settings;
        new RB_Terms_List_Column($this->meta_id, $this->get_admin_pages(), $column['title'], array($this, 'render_column_content'), $column);
    }

    // =========================================================================
    // METHODS
    // =========================================================================

    /**
    *   Returns the meta value for a term
    *   @param WP_Term|int $term                                Term id or instance from which to get the meta value from
    */
    public function get_value($term){
        $term = get_term($term);
        return $term && !is_wp_error($term) && metadata_exists('term', $term->term_id, $this->meta_id) ? get_term_meta( $term->term_id, $this->meta_id, true ) : null;
    }

    /**
    *   Returns the admin pages where this metabox will be added
    *   @return string[]
    */
    public function get_admin_pages(){
        return is_array($this->metabox_settings['terms']) ? $this->metabox_settings['terms'] : [$this->metabox_settings['terms']];
    }

    public function meta_exists($term_id){
        return metadata_exists( 'term', $term_id, $this->meta_id );
    }


}
