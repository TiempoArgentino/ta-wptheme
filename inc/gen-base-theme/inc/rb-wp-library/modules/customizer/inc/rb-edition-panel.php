<?php

// =============================================================================
// ADMIN PAGE
// =============================================================================
$page = new RB_Admin_Submenu('test', 'Test', 'Menu item', 'edit_theme_options', function(){
    require RB_CUSTOMIZER_FRAMEWORK_PATH . '/templates/edition-panel.php';
});
$page->add_on_page_callback(function(){
    add_action( 'admin_enqueue_scripts', function(){
        wp_enqueue_style( "rb-edition-panel", RB_CUSTOMIZER_FRAMEWORK_URI . "/css/rb-edition-panel.css", array() );
    });
    //RB_Customizer_Module::on_customizer_page(null);
});
RB_Admin_Panel_Manager::remove_page('test');

// =============================================================================
// MARKUP
// =============================================================================
add_action('wp_footer', 'rb_edition_panel_iframe');
function rb_edition_panel_iframe(){
    if(current_user_can('edit_theme_options') && !is_customize_preview()){
        ?><iframe id="rb-customizer-preview" src="http://localhost/wordpress/wp-admin/admin.php?page=test"></iframe><?php
    }
}
