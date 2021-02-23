<?php

//Color picker
/** Settings
* @param string palettes          Array of predefined colors that shows below the picker
*/
class RB_Gradient_Picker extends RB_Field_Control{

    public function __construct($value, $settings) {
         parent::__construct($value, $settings);
    }

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
        <div class="rb-gradient-picker-control">
            <div class="btn gradient-picker-creator"><?php $this->print_button_label(); ?></div>
            <div class="controls-container">
                <div class="gradient-controls">
                    <div class="control duplicate-selected">
                        <i class="fas fa-clone" title="Duplicate color"></i>
                    </div>
                </div>
                <div class="gradient-picker-holder"></div>
                <div class="inputs">
                    <select class="form-control switch-type">
                        <option value="">- Select Type -</option>
                        <option value="radial">Radial</option>
                        <option value="linear">Linear</option>
                        <option value="repeating-radial">Repeating Radial</option>
                        <option value="repeating-linear">Repeating Linear</option>
                    </select>

                    <select class="form-control switch-angle">
                        <option value="">- Select Direction -</option>
                        <option value="top">Top</option>
                        <option value="right">Right</option>
                        <option value="center">Center</option>
                        <option value="bottom">Bottom</option>
                        <option value="left">Left</option>
                    </select>
                </div>
                <div class="preview">
                    <span>PREVIEW</span>
                </div>
            </div>
            <input
            type="hidden"
            <?php $this->print_input_link(); ?>
            class="<?php $this->print_input_classes(); ?>"
            name="<?php echo $id; ?>"
            value="<?php echo esc_attr($this->value); ?>"></input>
        </div>
        <?php
    }

    public function print_button_label(){
        echo isset($this->settings['button']) ? esc_html($this->settings['button']) : 'Gradient Picker';
    }
}
