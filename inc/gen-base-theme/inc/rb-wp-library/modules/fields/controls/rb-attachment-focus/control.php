<?php
class RB_Attachment_Focus extends RB_Field_Control{
    public $control_data = array(
        'widthPercentage'   => null,
        'heightPercentage'  => null,
        'checkWidthFrom'    => 'right',
        'checkHeightFrom'   => 'bottom',
    );

    public $control_texts = array(
        'width-percentage'      => 'Width percentage',
        'height-percentage'     => 'Height percentage',
        'no-value'              => 'Not set',
        'check-width'           => 'Check width from:',
        'check-height'          => 'Check height from:',
        'left'                  => 'Left',
        'right'                 => 'Right',
        'top'                   => 'Top',
        'bottom'                   => 'Bottom',
    );

    public function __construct($value, $settings) {
         parent::__construct($value, $settings);
         $this->settings['repeatable']  = true;
         $this->settings = wp_parse_args( $settings, $this->settings);
         $this->control_texts = isset($this->settings['control_texts']) && is_array($this->settings['control_texts']) ? wp_parse_args( $this->settings['control_texts'], $this->control_texts) : $this->control_texts;
    }

    public function get_text($name){
        return $this->control_texts[$name];
    }

    public function get_overlay_style(){
        $style = 'style="';
        //Width
        if(isset($this->control_data['widthPercentage'])){
            if($this->control_data['checkWidthFrom'] == 'right'){
                $style .= "left: 0; width: ". $this->control_data['widthPercentage'] . "%;";
            }
            else if($this->control_data['checkWidthFrom'] == 'left'){
                $style .= "left: ". $this->control_data['widthPercentage'] ."%; width: 100%;";
            }
        }
        //Height
        if(isset($this->control_data['heightPercentage'])){
            if($this->control_data['checkHeightFrom'] == 'bottom'){
                $style .= "top: 0; height: ". $this->control_data['heightPercentage'] . "%;";
            }
            else if($this->control_data['checkWidthFrom'] == 'top'){
                $style .= "top: ". $this->control_data['heightPercentage'] ."%; height: 100%;";
            }
        }
        return $style . '"';
    }

    public function get_x_pointer_style(){
        $widthPercentage = $this->control_data['widthPercentage'];
        $style = "";
        if($widthPercentage){
            $style = 'style="' . "left: $widthPercentage" . "%;" . '"';
        }
        return $style;
    }

    public function get_y_pointer_style(){
        $heightPercentage = $this->control_data['heightPercentage'];
        $style = "";
        if($heightPercentage){
            $style = 'style="' . "top: $heightPercentage" . "%;" . '"';
        }
        return $style;
    }

    public function set_data(){
        $data = $this->value ? json_decode($this->value, true) : array();
        $this->control_data = array_merge($this->control_data, $data);
    }

    public function render_content($post = null){
        extract($this->settings);
        if( $label ): ?>
        <?php $this->print_control_header(); ?>
        <?php endif;?>
        <div class="rb-attachment-focus-control" data-setting="<?php echo $id; ?>">
            <?php if(get_post_type($post) == 'attachment' && strpos($post->post_mime_type, 'image') !== false ): ?>
            <?php
                $src = $post->guid;
                $this->set_data();
                $widthPercentage = isset($this->control_data['widthPercentage']) ? $this->control_data['widthPercentage'] : $this->get_text('no-value');
                $heightPercentage = isset($this->control_data['heightPercentage']) ? $this->control_data['heightPercentage'] : $this->get_text('no-value');
            ?>
            <div class="attachment-image-container">
                <div class="selection-overlay-container">
                    <div class="overlay" <?php echo $this->get_overlay_style(); ?>></div>
                </div>
                <div class="selection-table">
                    <div class="pointer x-pointer" <?php echo $this->get_x_pointer_style(); ?>><span>X</span></div>
                    <div class="pointer y-pointer" <?php echo $this->get_y_pointer_style(); ?>><span>Y</span></div>
                </div>
                <img src="<?php echo esc_attr($src); ?>"/>
            </div>
            <div class="info">
                <div class="data-display">
                    <div class="display-item">
                        <p class="title"><?php echo esc_html($this->get_text('width-percentage')); ?></p>
                        <p class="value width-percentage"><?php echo esc_html($widthPercentage); ?></p>
                    </div>
                    <div class="display-item">
                        <p class="title"><?php echo esc_html($this->get_text('height-percentage')); ?></p>
                        <p class="value height-percentage"><?php echo esc_html($heightPercentage); ?></p>
                    </div>
                </div>
                <div class="options-selection">
                    <div class="option-item">
                        <label class="title"><?php echo esc_html($this->get_text('check-width')); ?></label>
                        <select class="option width-option">
                            <option value="left" <?php selected($this->control_data['checkWidthFrom'], 'left', true); ?>><?php echo esc_html($this->get_text('left')); ?></option>
                            <option value="right" <?php selected($this->control_data['checkWidthFrom'], 'right', true); ?>><?php echo esc_html($this->get_text('right')); ?></option>
                        </select>
                    </div>
                    <div class="option-item">
                        <label class="title"><?php echo esc_html($this->get_text('check-height')); ?></label>
                        <select class="option height-option">
                            <option value="top" <?php selected($this->control_data['checkHeightFrom'], 'top', true); ?>><?php echo esc_html($this->get_text('top')); ?></option>
                            <option value="bottom" <?php selected($this->control_data['checkHeightFrom'], 'bottom', true); ?>><?php echo esc_html($this->get_text('bottom')); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="not-attachment">This controll can only be used on an attachment</div>
            <?php endif; ?>
            <input <?php $this->print_input_link(); ?> class="<?php $this->print_input_classes(); ?>" name="<?php echo $id; ?>" type="hidden" value="<?php echo esc_attr($this->value); ?>"></input>
        </div>
        <?php
    }
}
