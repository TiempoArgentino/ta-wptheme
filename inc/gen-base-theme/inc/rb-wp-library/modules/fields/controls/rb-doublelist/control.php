<?php


class RB_doublelist_control extends RB_Field_Control{

    public function render_content(){
        extract($this->settings);
        if( $label ): ?>
        <?php $this->print_control_header(); ?>
        <?php endif;?>
        <div class="rb-double-list-control" data-empty-item="<?php echo esc_attr( $this->get_empty_input() ); ?>">
            <ul class="items">
                <?php
                    $items = null;
                    if( $this->value ){
                        $items = json_decode($this->value, true);
                    }

                    if( !isset($items) ){
                        $this->print_inputs_pair();
                    }
                    else{
                        foreach($items as $item){
                            $this->print_inputs_pair($item['name'], $item['value']);
                        }
                    }
                ?>
            </ul>
            <div class="add-item-button-container">
                <span class="add-item dashicons dashicons-plus-alt"></span>
            </div>
            <input <?php $this->print_input_link(); ?> class="<?php $this->print_input_classes(); ?>" name="<?php echo $id; ?>" type="hidden" value="<?php echo esc_attr($this->value); ?>"></input>
        </div>
        <?php
    }

    public function get_empty_input(){
        ob_start();
        $this->print_inputs_pair();
        return ob_get_clean();
    }

    public function print_inputs_pair($name = "", $value = ""){
        ?>
        <li class="item">
            <div class="handle">
                <div></div>
            </div>
            <div class="content">
                <div class="name">
                    <input value="<?php echo $name; ?>" type="text">
                </div>
                <div class="value">
                    <input value="<?php echo $value; ?>" type="text">
                </div>
            </div>
            <div class="delete-button">
                <span class="dashicons dashicons-trash"></span>
            </div>
        </li>
        <?php
    }
}
