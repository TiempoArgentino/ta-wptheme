<?php

/**
*   @param array query_args             Array of options for the get_posts function. Check wp_query docs.
*
*/
class RB_Post_Selector extends RB_Field_Control{
    public $options = array(
        'option_none'   => 'None',
    );

    public $default_query_args = array(
        'posts_per_page'       	=> -1,
        'orderby'               => 'title',
        'order'                 => 'ASC',
        'post_type'             => 'post',
    );

    public function __construct($value, $settings) {
         parent::__construct($value, $settings);
         $this->options = wp_parse_args( $settings, $this->options );
    }

    public function get_query_args(){
        $args = $this->default_query_args;
        if(isset($this->settings['query_args']) && is_array($this->settings['query_args'])){
            $args = array_merge($args,$this->settings['query_args']);
        }
        return $args;
    }

    public function get_dropdown(){
        extract($this->settings);
        extract($this->options);

        /*Dropdown generation*/
        $dropdown = "<select
            name='$this->id'
            class='rb-tax-value ". $this->get_control_input_class() ."' "
            . $this->get_control_input_link() . "
        >";
        $dropdown .= '<option value=""'.selected($this->value, '', false).'>'.__( $option_none ).'</option>';

        $posts = get_posts($this->get_query_args());
        if(is_array($posts)){
            foreach( $posts as $post ){
                $dropdown .= '<option value="'. $post->ID .'"'.selected($this->value, $post->ID, false).'>'.$post->post_title.'</option>';
            }
        }

        $dropdown .= "</select>";

        return $dropdown;
    }

    public function render_content(){
        $this->print_control_header();
        ?>
        <div class="rb-post-selection">
            <?php echo $this->get_dropdown();  ?>
        </div>
        <?php
    }
}
