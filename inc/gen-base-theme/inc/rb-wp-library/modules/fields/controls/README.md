# Controls

The controls are the part of the fields API that manages the value of the input of a ´single field´. They can be used
apart from the field API, as stand alone controls.

## Creating a Control

A control must extend the class ´RB_Field_Control´, defining the ´render_content´ method that generates the control's content.

For example, the `RB_Color_Picker` control defines the following `render_content`.

````php
<?php
class RB_Color_Picker extends RB_Field_Control{
    public function render_content($wp_object = null){
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
}
````

### Final Value Input Element
The most consistent element through out all controls is the final value input HTML. This doesn't have to be visible, but must contain the following:

-   name: The `$id` of the control must be outputted into the name attribute.

A couple of functions are used to print some attributes and classes that links the input to the various WordPress environments that may use them. These are:

-  `print_input_link`: prints attributes.
-  `print_input_classes`: prints CSS classes.

#### Dynamic Value

When setting the value of the input dynamically, a `change` and `input` event must be triggered for the value change to be recognized by some environments.

````js
$('.rb-color-picker').value('new value').trigger('change').trigger('input');
````
