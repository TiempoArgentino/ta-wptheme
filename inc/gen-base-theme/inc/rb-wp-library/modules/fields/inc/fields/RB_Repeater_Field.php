<?php

// =============================================================================
// REPEATER
// =============================================================================
class RB_Repeater_Field extends RB_Field{
    public $repeater_settings = array(
        'collapsible'   => true,
        'accordion'     => false,
        'empty_message' => 'Start adding items!',
    );

    public function __construct($id, $value, $repeater_settings, $controller_settings, $controls){
        parent::__construct($id, $value, $controller_settings);
        $this->repeater_settings = is_array($repeater_settings) ? array_merge($this->repeater_settings, $repeater_settings) : $this->repeater_settings;
        $this->controls = $controls;
        $this->sanitize_value();
    }

    public function render_field($post = null){
        if(is_array($this->controls)):
        ?>
        <div class="repeater-container <?php echo $this->empty_class(); ?>">
            <?php $this->print_empty_message(); ?>
            <div class="rb-repeater-items <?php $this->accordion_class(); ?>">
                <?php
                if(!$this->is_empty()):
                    $i = 1;
                    foreach($this->value as $item_value):
                        $this->print_item($item_value, $i, $post);
                        $i++;
                    endforeach;
                // else://There is no value
                //     $this->print_item(null, 1, $post);
                endif;
                ?>
            </div>
            <div class="repeater-add-button">
                <i class="add-button fas fa-plus"></i>
            </div>
            <div class="repeater-empty-control">
                <?php echo esc_attr($this->print_placeholder_item($post)); ?>
            </div>
        </div>
        <?php $this->print_repeater_value_input(); ?>
        <?php
        endif;
    }

    public function print_placeholder_item($post = null){
        $this->print_item('', '__($RB_REPEATER_PLACEHOLDER='.$this->id.')', $post);
    }

    public function get_item_controller($value, $index){
        //Check if it has controller prop
        $item_settings = $this->get_item_controller_settings();
        $item_settings['controls'] = $this->controls;
        return new RB_Repeater_Item($this->get_item_id($index), $value, $index, $item_settings, $this->repeater_settings);
    }

    public function print_item($value, $index, $post){
        $item = $this->get_item_controller($value, $index);
        $item->render($post);
    }

    public function is_empty(){ return !is_array($this->value) || empty($this->value); }

    public function empty_class(){ return $this->is_empty() ? 'empty' : ''; }

    public function get_item_controller_settings(){
        $item_controller = $this->get_repeater_setting('item_controller');
        return is_array($item_controller) ? $this->repeater_settings['item_controller'] : array();
    }

    public function get_item_id($index){ return "$this->id-$index"; }

    public function accordion_class(){ echo $this->is_accordion() ? 'rb-accordion' : ''; }

    public function is_accordion(){ return true && $this->get_repeater_setting('accordion'); }

    public function get_repeater_setting($name){ return isset($this->repeater_settings[$name]) ? $this->repeater_settings[$name] : null; }

    public function print_empty_message(){
        $message = $this->get_repeater_setting('empty_message');
        ?>
        <div class="rb-repeater-empty-message">
            <?php
            //If the message is a function
            if( is_callable($message) )
                $message($message);
            //If the message is a string
            else if ( is_string($message) ):
            ?>
                <p class="message"><?php echo $message; ?></p>
            <?php
            endif;
            ?>
        </div>
        <?php
    }

    public function print_repeater_value_input(){
        ?>
        <input
        class="<?php echo RB_Field_Factory::get_input_class_link(); ?>"
        rb-control-repeater-value
        rb-control-value
        name="<?php echo $this->id; ?>"
        value="<?php echo esc_attr(json_encode($this->value, JSON_UNESCAPED_UNICODE)); ?>"
        type="hidden" ></input>
        <?php
    }

    public function sanitize_value(){
        $this->value = $this->get_sanitized_value($this->value);
    }

    public function get_sanitized_value($value, $item_sanitation_args = array()){
        $item_sanitation = array(
             //Wheter to escape the child value slashes or not. Useful when there is
             //no control over the save method, and it escapes the value slashes (as update_metabox does)
            'unslash_single_repeater'   => false,
            'unslash_group'             => false,
            'unslash_repeater_slashes'  => false,
        );
        $item_sanitation = array_merge($item_sanitation, $item_sanitation_args);
        $item_sanitation['unslash_group'] = false;

        //echo "------------Values for $this->id REPEATER--------------<br><br>";
        //print_r($item_sanitation); echo "<br>";
        //echo "New value: "; var_dump(esc_html($value)); echo "<br><br>";

        $item_controller = $this->get_item_controller('', '0');
        if(is_string($value) || is_array($value)){
            $decoded_value = $value;
            if(is_string($value)){
                if($item_sanitation['unslash_repeater_slashes'] && !$item_controller->is_repeater() && ($item_sanitation['unslash_single_repeater'] || !$item_controller->is_single()))
                    $decoded_value = wp_unslash($decoded_value);//remove slashes if neccesary
                $decoded_value = json_decode($decoded_value, true);
            }

            //echo "Decoded value: "; var_dump(esc_html($value)); echo "<br><br>";
            //Sanitize item value using child controller sanitization function
            if(is_array($decoded_value)){
                foreach($decoded_value as $key => $item_value){
                    $decoded_value[$key] = $item_controller ? $item_controller->get_sanitized_value($item_value, $item_sanitation) : null;
                    //echo "Item value: ";var_dump($decoded_value[$key]); echo "<br><br>";
                }
            }

            if(json_last_error() == JSON_ERROR_NONE)
                $value = $decoded_value;
        }
        else
            $value = null;

        //echo "JSON Error: "; var_dump(json_last_error()); ; echo "<br><br>";
        //echo "Sanitized value: "; var_dump($value); echo "<br><br>";

        return $value;
    }

    public function get_item_base_title(){
        $base_title = $this->get_repeater_setting('item_title');
        return $base_title ? $base_title : 'Item';
    }

    public function get_item_title_link(){
        $title_link = $this->get_repeater_setting('title_link');
        return $title_link ? $title_link : '';
    }

    public function get_container_class(){ return "rb-repeater-field"; }

    public function get_container_attr(){
        $base_title = $this->get_item_base_title();
        $title_link = $this->get_item_title_link();
        $attr = 'data-id="'.esc_attr($this->id).'"';
        if($base_title)
            $attr .= ' data-base-title="'.esc_attr($base_title).'"';
        if($title_link)
            $attr .= ' data-title-link="'.esc_attr($title_link).'"';
        return $attr;
    }
}
