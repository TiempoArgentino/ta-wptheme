<?php

class RB_tinymce_control extends RB_Field_Control{

    public function render_content(){
        extract($this->settings);
        if( $label ): ?>
        <?php $this->print_control_header(); ?>
        <?php endif;?>
        <div class="rb-tinymce-control">
            <div class="editor-placeholder">
                <span class="editor-open-button">Editar</span>
            </div>
            <div class="tinymce-editor-container">
        		<!-- <div class="rb-control-panel-title-container controls-bar">
            		<i class="fas fa-chevron-circle-left rb-control-panel-close-button close-button"></i>
            		<h5 class="rb-control-panel-title"></h5>
        		</div> -->
        		<div class="media-button">Insert multimedia</div>
        		<div class="rb-tinymce-editor" id="<?php echo esc_attr( $this->id ); ?>">
                    <?php if(isset($value)) echo esc_html($value); ?>
        		</div>
                <input placeholder-value class="<?php $this->print_input_classes(); ?>" <?php $this->print_input_link(); ?>
                type="hidden" value="<?php echo esc_attr($this->value); ?>" name="<?php echo $this->id; ?>"></input>
    		</div>
        </div>
        <?php
    }

}
