<?php
if(!rb_customizer_front_edition_is_active())
    return;

// =============================================================================
// PANEL BUILDER
// =============================================================================
/*We need the panel builder in the front to get every control and setting that can be
/*edited*/
require_once RB_CUSTOMIZER_FRAMEWORK_PATH . '/inc/rb-customizer-panel-builder.php';

// =============================================================================
// RB CUSTOMIZER REST ROUTES
// =============================================================================
require_once RB_CUSTOMIZER_FRAMEWORK_PATH . '/inc/rb-customizer-routes.php';

// =============================================================================
// MARKUP
// =============================================================================
add_action('wp_footer', 'rb_customizer_front_edition');
function rb_customizer_front_edition(){
    if(current_user_can('edit_theme_options') && !is_customize_preview()){
        /*Save button*/
        require RB_CUSTOMIZER_FRAMEWORK_PATH . '/templates/front-edition-save-box.php';
    }
}

// =============================================================================
// PANEL PREVIEW JAVASCRIPT
// =============================================================================
add_action ("wp_enqueue_scripts", "rb_customizer_front_scripts");
function rb_customizer_front_scripts() {
    if(current_user_can('edit_theme_options') && !is_customize_preview()){
        wp_enqueue_style( "rb-front-edition", RB_CUSTOMIZER_FRAMEWORK_URI ."/css/rb-front-edition.css", array() );
        wp_enqueue_script("jquery-ui-draggable");
        wp_enqueue_script( 'rb-customizer-preview-js',  RB_CUSTOMIZER_FRAMEWORK_URI. '/js/rb-customizer-preview.js', array( 'customize-preview', 'jquery-ui-draggable' ), '1.0', true );
        wp_localize_script( 'rb-customizer-preview-js', 'rbCustomizer', array(
            'assetsUrl'         => RB_CUSTOMIZER_FRAMEWORK_ASSETS_URI,
            'templateUrl'       => get_site_url(null, '', 'http'),
            'settings'          => RB_Customizer_Setting::$settings,
            'controls'          => RB_Customizer_Control::$controls,
            'helperPanel'       => rb_get_customizable_element_panel_html(),
        ) );
    }
}
