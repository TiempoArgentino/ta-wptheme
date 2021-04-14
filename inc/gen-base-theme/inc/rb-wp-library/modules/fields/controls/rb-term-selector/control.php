<?php

class RB_Term_Selector extends RB_Field_Control{
    public $options = array(
        'class'         => '',
        'option_none'   => 'None',
        'post_type'     => 'post',
    );

    public function __construct($value, $settings) {
         parent::__construct($value, $settings);
         $this->options = wp_parse_args( $settings, $this->options );
    }

    public function get_dropdown(){
        extract($this->settings);
        extract($this->options);
        /*Dropdown generation*/
        $dropdown = '';
        $terms = get_terms($this->options);
        //ERROR
        if( is_wp_error($terms) ){
            $error_message = "An unknown error ocurred while trying to render the term selector";
            $error_message = isset($terms->errors) && isset($terms->errors["invalid_taxonomy"]) ? $terms->errors["invalid_taxonomy"][0] : $error_message;
            $dropdown = "<p>". $error_message ."</p>";
        }
        else{
            //Open
            $dropdown = "<select
                name='$this->id'
                class='$class rb-tax-value ". $this->get_control_input_class() . "' "
                . $this->get_control_input_link() . "
            >";
            //Option none
            $dropdown .= '<option value=""'.selected($this->value, '', false).'>'.__( $option_none ).'</option>';
            //Term option
            foreach ( $terms as $term ){
                $dropdown .= '<option value="'. $term->term_id .'"'.selected($this->value, $term->term_id, false).'>'.$term->name.'</option>';
            }
            //Close
            $dropdown .= "</select>";
        }

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
