<?php

class RB_Media_Control extends RB_Field_Control{

    public function render_content(){
        extract($this->settings);

        ?>
        <?php $this->print_control_header(); ?>
        <div class="inputs-generator-inputs-holder" data-value-type="<?php echo esc_attr( $this->get_value_type() ); ?>">
            <div class="input-wp-media-image-holder">
                <img class="input-image-src" src="<?php echo esc_attr( $this->get_img_url() ); ?>">
                <div class="input-image-placeholder">
                <p> Select an image </p>
                </div>
                <input <?php $this->print_input_link(); ?> class="rb-tax-value rb-sub-input <?php $this->print_input_classes(); ?>"  name="<?php echo $id; ?>" type="hidden" value="<?php echo esc_attr($this->value); ?>"></input>
            </div>
            <div class="remove-image-button"><i class="fas fa-times" title="Remove image"></i></div>
        </div>
        <?php
    }

    public function get_img_url(){
        if(!$this->value)
            return '';
        if($this->get_value_type() == 'id'){
            $value = intval($this->value);
            $src = $value ? wp_get_attachment_url($value) : '';
            return $src ? $src : '';
        }
        return $this->value;
    }

    public function get_value_type(){
        return isset($this->settings['store_value']) ? $this->settings['store_value'] : 'url';
    }

}
