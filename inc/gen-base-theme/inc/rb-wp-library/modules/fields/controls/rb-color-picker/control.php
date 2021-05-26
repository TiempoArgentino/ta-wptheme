<?php

//Color picker
/** Settings
* @param string palettes          Array of predefined colors that shows below the picker
*/
class RB_Color_Picker extends RB_Field_Control{
    /**
     * Render the control's content.
     *
     * @since 3.4.0
    */
    public function render_content($post = null){
        extract($this->settings);
        if($label){
            $this->print_control_header();
        }
        ?>
        <div class="rb-color-picker-control">
            <input <?php $this->print_input_link(); ?> class="rb-color-picker <?php $this->print_input_classes(); ?>" data-alpha="true" name="<?php echo $id; ?>"
            value="<?php echo esc_attr($this->value); ?>" <?php echo $this->get_palettes_attr(); ?>></input>
        </div>
        <?php
    }

    // =========================================================================
    // Color picker options through attributes
    // =========================================================================
    public function get_palettes_attr(){
        if(!isset($this->settings['palettes']) || !is_array($this->settings['palettes']))
            return '';
        $palettes_json = json_encode($this->settings['palettes']);
        return "data-palettes='$palettes_json'";
    }

}
