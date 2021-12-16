<?php
?>
<div id="rb-edition-panel">
    <?php
        foreach(RB_Customizer_Control::$controls as $control_data):
            if(!isset($control_data->control_class) || $control_data->control_class != 'RB_Customizer_Field_Control')
                continue;
            $control = new RB_Form_Field_Factory($control_data->id, '', $control_data->options);
            ?>
            <div class="rb-edition-panel-control">
            <?php $control->render(); ?>
            </div>
            <?php
        endforeach;
    ?>
</div>
