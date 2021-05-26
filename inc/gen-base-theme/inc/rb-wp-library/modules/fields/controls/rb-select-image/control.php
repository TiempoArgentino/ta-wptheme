<?php

class RB_Select_Image extends RB_Field_Control{

    public function render_content(){
        extract($this->settings);
        $this->print_control_header();
        ?>
        <div class="rb-image-selection-control">
            <?php if(is_array( $options )): ?>
                <div class="images-options-container">
                <?php foreach($options as $image_data): ?>
                    <?php
                    $option_value = $this->get_option_value($image_data);
                    $option_title = isset($image_data["title"]) && is_string($image_data["title"]) ? $image_data["title"] : '';
                    ?>
                    <div class="image-option" <?php echo $this->get_container_style_attr(); ?>>
                        <input
                            class="image-option-input"
                            type="radio"
                            value="<?php echo esc_attr( $option_value ); ?>"
                            <?php checked( $this->value, $option_value ); ?>
                            aria-label="<?php echo $option_title; ?>"
                            title="<?php echo $option_title; ?>"
                            name="<?php echo esc_attr("$id-rb-radius-option-sf4534ta214763nnmt"); ?>"
                        />
                        <?php $this->print_image_div($image_data); ?>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <input class="<?php $this->print_input_classes();; ?>" <?php $this->print_input_link(); ?> type="hidden" value="<?php echo esc_attr( $option_value ); ?>" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($id); ?>"/>
        </div>
        <?php
    }

    //Checks if the control uses images instead of background img
    public function uses_img(){
        return isset($this->settings['uses_img']) && $this->settings['uses_img'];
    }

    //Print the image for the select option
    public function print_image_div($image_data){
        if( $this->uses_img() ):?>
            <img class="image-selection-image" src="<?php echo $this->get_image_src($image_data); ?>" <?php echo $this->get_image_style_attr($image_data); ?>/>
        <?php else: ?>
            <div class="image-selection-image" <?php echo $this->get_image_style_attr($image_data); ?>></div>
        <?php
        endif;
    }

    //returns an option value
    public function get_option_value($image_data){
        return isset($image_data["value"]) ? $image_data["value"] : $this->get_image_src($image_data);
    }

    //Returns the src of an option's image
    public function get_image_src($image_data){
        return isset($image_data["src"]) && is_string($image_data["src"]) ? $image_data["src"] : '';
    }

    //Returns the style attribute for the option's image, with custom styles and img src
    public function get_image_style_attr( $image_data ){
        $sty_attr = 'style=\'';

        if( !$this->uses_img() )
            $sty_attr .= 'background-image: url("'.$image_data["src"].'"); ';

        if(isset($this->settings['height']) && is_string($this->settings['height'])){
            $height = esc_attr($this->settings['height']);
            $sty_attr .= "height: $height;";
        }

        $sty_attr .= "'";
        return $sty_attr;
    }

    public function get_container_style_attr(){
        $sty_attr = "";
        $max_width_ok = isset($this->settings['max_width']) && is_string($this->settings['max_width']);
        $min_width_ok = isset($this->settings['min_width']) && is_string($this->settings['min_width']);
        if( $max_width_ok || $min_width_ok ){
            $sty_attr = 'style="';
            if($max_width_ok){
                $max_width = esc_attr($this->settings['max_width']);
                $sty_attr .= "max-width: $max_width;";
            }
            if($min_width_ok){
                $min_width = esc_attr($this->settings['min_width']);
                $sty_attr .= "min-width: $min_width;";
            }
            $sty_attr .= '"';
        }
        return $sty_attr;
    }

}
