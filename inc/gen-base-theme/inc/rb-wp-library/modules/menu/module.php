<?php

if(!class_exists('RB_Menu_Module')){
    define('RB_MENU_MASTER_DIR', plugin_dir_path(__FILE__));

    class RB_Menu_Module{
        static private $initialized = false;

    	static public function initialize(){
    		if(self::$initialized)
    			return false;
            self::$initialized = true;

            require_once RB_MENU_MASTER_DIR . 'inc/RB_Menu_Item_Type.php';
            require_once RB_MENU_MASTER_DIR . 'inc/RB_Menu.php';
    	}
    }

    RB_Menu_Module::initialize();
}

// new RB_Menu_Item_Type('test_type', array(
//     'labels' => array(
//         'name'              => 'Tests',
//         'singular_name'     => 'Test',
//     )
// ));
//
// if(is_admin()){
//     new RB_Menu_Item_Meta('meta_key_test', array(
//         'admin_page'    => 'test_type',
//     ), array(
//         'controls'      => array(
//             'url'  => array(
//                 'input_type'    => 'text',
//                 'label'         => 'Link',
//             ),
//             'fa'  => array(
//                 'type'    => 'RB_Fontawesome_Control',
//                 'label'         => 'Icono',
//             ),
//             'position_y'   => array(
//                 'input_type'    => 'select',
//                 'choices'       => array(
//                     'top'                   => 'Arriba',
//                     'bottom'                => 'Abajo',
//                     'center'                => 'Centro'
//                 ),
//                 'input_options' => array(
//                     'option_none'   => array('top', 'Por defecto'),
//                 ),
//                 'default'       => 'top',
//             ),
//         ),
//     ));
// }
