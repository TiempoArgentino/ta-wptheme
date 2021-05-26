<?php

class RB_Input_Control extends RB_Field_Control{
    public $input_render;
    public $id;
    public $value;
    public $input_type;
    public $choices;
    public $default_input_options = array(
        'max'           => null,
        'min'           => null,
        'step'          => 1,
        'readonly'      => null,
        'disabled'      => null,
        'size'          => null,
        'maxlength'     => null,
        'pattern'       => null,
        'placeholder'   => null,
        'rows'          => 5,
        'columns'       => null,
        'option_none'   => null, //$option_none = array($value, $title)
    );

    public function __construct($value, $settings) {
        parent::__construct($value, $settings);
        if( isset($this->settings['input_type']) && $this->settings['input_type'] == 'checkbox' )
            $this->strict_type = 'bool';
    }

    public function render_content(){
        extract($this->settings);
        $this->value = esc_attr($this->value);
        $this->choices = isset($choices) ? $choices : null;
        $this->input_type = isset($input_type) ? $input_type : 'text';
        //$this->option_none = isset($option_none) ? $option_none : null;


        if( $label && $this->input_type != 'checkbox' )
            $this->print_control_header();
        ?>
        <div class="rb-inputs-control">
            <?php $this->render_the_input(); ?>
        </div>
        <?php
    }

    public function render_the_input(){
        $this->select_input();
        if( is_array($this->input_render) ){
            call_user_func($this->input_render);
        }
    }

    public function select_input(){
        switch($this->input_type){
            case 'text': $this->input_render = array($this, 'render_common_input'); break;
            case 'number': $this->input_render = array($this, 'render_common_input'); break;
            case 'date': $this->input_render = array($this, 'render_common_input'); break;
            case 'datetime-local': $this->input_render = array($this, 'render_common_input'); break;
            case 'time': $this->input_render = array($this, 'render_common_input'); break;
            case 'textarea': $this->input_render = array($this, 'render_textarea_input'); break;
            case 'checkbox': $this->input_render = array($this, 'render_checkbox_input'); break;
            case 'select': $this->input_render = array($this, 'render_select_input'); break;
            default: $this->input_render = false; break;
        }
    }

    public function render_common_input(){
        $type = esc_attr($this->input_type);
        $name = esc_attr($this->id);
        $value = esc_attr($this->value);
        ?><input type="<?php echo $type; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" class="<?php $this->print_input_classes(); ?>" <?php $this->print_input_attributes(); ?> <?php $this->print_input_link(); ?>></input><?php
    }

    public function render_textarea_input(){
        $name = esc_attr($this->id);
        $value = esc_attr($this->value);
        ?><textarea type="textarea" name="<?php echo $name; ?>" value="<?php echo $value; ?>" class="<?php $this->print_input_classes(); ?>" <?php $this->print_input_attributes(); ?> <?php $this->print_input_link(); ?>><?php echo $value; ?></textarea><?php
    }

    public function render_checkbox_input(){
        $this->sanitaze_checkbox_value();
        $checked_attr = $this->value ? 'checked' : '';
        ?>
        <label>
            <input type="hidden" value-as-bool-not class="<?php $this->print_input_classes(); ?>" <?php $this->print_input_link(); ?> name="<?php echo $this->id; ?>" value=<?php echo $this->value; ?>>
            <input type="checkbox" <?php echo $checked_attr; ?> <?php $this->print_input_attributes(); ?> onclick="this.previousElementSibling.value=1-this.previousElementSibling.value; jQuery(this.previousElementSibling).trigger('input');">
            <span class="control-title"><?php echo $this->settings['label']; ?></span>
            <?php $this->print_description(); ?>
        </label>
        <?php
    }

    public function render_select_input(){
        //$choices = array( $value => $title, ...)
        //$option_none = array($value, $title)
        if( is_array($this->choices) && !empty($this->choices) ): $option_none = $this->get_input_option('option_none')?>
            <?php $this->print_description(); ?>
            <select class="browser-default <?php $this->print_input_classes(); ?>" <?php $this->print_input_link(); ?> name="<?php echo $this->id; ?>">
                <?php if( is_array($option_none) && !empty($option_none) ): ?>
                    <option value="<?php echo $option_none[0]; ?>"><?php echo $option_none[1]; ?></option>
                <?php else: ?>
                    <option value=""></option>
                <?php endif; ?>
                <?php
                    foreach($this->choices as $value => $title):
                        $selected_attr = $value == $this->value ? 'selected' : '';
                ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php echo $selected_attr; ?>><?php echo esc_html($title); ?></option>
                <?php endforeach; ?>
            </select>
        <?php
        else:?>
            <p>No choices were given for the selection control</p>
        <?php endif;
    }

    public function sanitaze_checkbox_value(){
        if( !isset($this->value) || $this->value == '' || $this->value == 'false' || $this->value == '0' )
            $this->value = false;
        else
            $this->value = true;
    }

    // =========================================================================
    // ATTRIBUTES SET
    // =========================================================================
    public function get_option($attr_name){
        return isset($this->settings[$attr_name]) ? $this->settings[$attr_name] : null;
    }

    public function get_input_option($attr_name){
        return isset($this->settings['input_options']) && isset($this->settings['input_options'][$attr_name]) ? $this->settings['input_options'][$attr_name] : null;
    }

    public function print_input_attributes(){
        if(is_array($this->default_input_options) && isset($this->settings['input_options']) && is_array($this->settings['input_options'])){
            foreach($this->default_input_options as $attr_name => $default_attr_value){
                $user_attr_val = $this->get_input_option($attr_name);
                $attr_value = isset($user_attr_val) ? esc_attr($user_attr_val) : $default_attr_value;
                if(isset($attr_value))
                    echo "$attr_name='$user_attr_val' ";
            }
        }
    }
}
