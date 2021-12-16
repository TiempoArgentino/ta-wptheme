<?php
RB_Wordpress_Framework::load_module('rest');

// =============================================================================
// ADMINISTRATOR ONLY ROUTES
// A estas rutas solo puede acceder un usuario logeado con rol de administrador
// =============================================================================
RB_WP_Rest_API_Extended::group(['role'   =>  'administrator'], function(){
    // =========================================================================
    // ROUTES
    // =========================================================================
    RB_WP_Rest_API_Extended::get('rb-customizer/v1', '/control', function($request){
        $control = new RB_Form_Field_Factory($request['id'], '', $request['options']);
        ob_start();
        $control->render();
        return ob_get_clean();
    });

    RB_WP_Rest_API_Extended::post('rb-customizer/v1', '/setting/(?P<settingID>[a-zA-Z0-9-]+)/update', function($request){
        return set_theme_mod( $request['settingID'], $request['value'] );
    });

    RB_WP_Rest_API_Extended::post('rb-customizer/v1', '/settings/update', function($request){
        if(!isset($request['settings']) || !is_array($request['settings'])){
            return new WP_Error( 'no_settings', __( "No settings were passed" ) );
        }

        foreach($request['settings'] as $setting_id => $value){
            set_theme_mod( $setting_id, $value );
        }

        return true;
    });
});
