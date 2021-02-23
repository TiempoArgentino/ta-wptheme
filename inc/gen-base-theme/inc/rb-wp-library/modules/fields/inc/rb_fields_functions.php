<?php

function rb_register_control_as_vc_param($param_slug, $field_class, $control_settings){
    if( !class_exists($field_class) || !function_exists('vc_add_shortcode_param') )
        return false;

    return vc_add_shortcode_param( $param_slug, function ($param_settings, $value) use ($field_class, $control_settings){
        if( isset($param_settings['rb_settings']) && is_array($param_settings['rb_settings']) )
            $control_settings = array_merge($control_settings, $param_settings['rb_settings']);
        $rb_control = new $field_class($value, $control_settings);
        $rb_control->id = $param_settings['param_name'];
        return $rb_control->get_control_markup();// This is html markup that will be outputted in content elements edit form
    });
}
