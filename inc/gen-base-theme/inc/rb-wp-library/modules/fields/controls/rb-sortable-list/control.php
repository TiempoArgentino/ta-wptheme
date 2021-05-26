<?php

class RB_Sortable_List_Control extends RB_Field_Control{
    /**
    *	Array with the list items. Ex:
    *		array(
    *			'value' => 'List item content',
    *		)
    *	Commas on the 'value' will be replace with '-'
    */
    public $items = array();
    public $current_value;

    public function __construct($value, $settings) {
         parent::__construct($value, $settings);
         $this->items = $this->array_replace_keys_commas( $settings["items"] );
         $this->update_value();
    }

    public function value(){
        return $this->value;
    }

    public function array_replace_keys_commas( $strings, $replace_value = "-"){
        $temp_array = array_flip($strings);

        foreach( $temp_array as $item_key => $item_value )
            $temp_array[$item_key] = str_replace(",", $replace_value, $item_value);

        return array_flip($temp_array);
    }

    public function update_value(){
        $items_keys = array_keys ( $this->items );
        $current_order = $this->value() ? explode(',', $this->value()) : array();

        //Eliminates the items that are no longer in the items array

        foreach( $current_order as $item_key ){
            if ( !in_array ( $item_key, $items_keys ) )
                unset($current_order[ array_search ( $item_key, $current_order ) ]);
        }

        //Reindex the array ( unset deletes the element from the array but doesnt change the index of the rest)
        $current_order = array_values($current_order);

        //Push new items to the array
        foreach( $items_keys as $item_key ){
            if ( !in_array ( $item_key, $current_order ) )
                array_push ( $current_order, $item_key );
        }

        $this->current_value = $current_order;
        //print_r( $this->current_value );
    }

    /**
     * Render the control's content.
     *
     * @since 3.4.0
    */
    public function render_content() {
        extract($this->settings);
        $name = '_customize-sortable-list-' . $this->id;
        $input_id = '_customize-sortable-item' . $this->id;
        $description_id = '_customize-description-' . $this->id;
        $describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
        $amount_of_items = count($this->items);
        $ordered_items_values = $this->current_value;

        ?>
        <div class="customize-control-sortable-list">
            <?php if(isset($this->label)): ?>
            <span class="customize-control-title"><?php echo $this->label; ?></span>
            <?php endif; ?>
            <?php if(isset($this->description)): ?>
            <span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php endif; ?>
            <ul class="sortables-ul">
                <?php
                    for ( $i = 0; $i < $amount_of_items; $i++){
                        $item_value = $ordered_items_values[$i];
                        $item_nice_name = $this->items[$ordered_items_values[$i]];
                        $id = esc_attr( $input_id . '-' . str_replace( '', '-', $item_value ) );
                        ?>
                        <li
                            class="sortable-li"
                            id="<?php echo $id?>"
                            <?php echo $describedby_attr; ?>
                            name="<?php echo esc_attr( $item_value ); ?>"
                        >
                            <?php echo $item_nice_name ?>
                        </li>
                        <?php
                    }
                ?>
                <input type="hidden" value="<?php echo $this->value(); ?>" class="<?php $this->print_input_classes(); ?>" <?php $this->print_input_link(); ?> name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>">
            </ul>
        </div>
        <?php
    }
}
