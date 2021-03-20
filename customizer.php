<?php
// =============================================================================
// PANEL BUILDER
// =============================================================================
function customizer_api_configuration($customizer_api){


    // =========================================================================
    // CUSTOMIZACION GLOBAL
    // =========================================================================
    $customizer_api->add_panel(
		'ta-global',
		array(
			'priority'       => 1,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __('Ajustes Globales', 'ta-theme'),
			'description'    => __('Configuración que afecta a diversos modulos del sitio.', 'ta-theme'),
		)
	);

    // =============================================================================
    // REDES
    // =============================================================================

    $customizer_api->add_section(
        'ta-social',
        array(
            'title'     => 'Redes Sociales',
            'priority'  => 1,
            'panel'  	=> 'ta-global',
        ),
        array(
            // 'activated' 		=> true,
            // 'selector'			=>	"#main-grid",
        )
    )
    ->add_control(//Control creation
        'ta-social-data',//id
        'RB_Customizer_Field_Control',//control class
        array(//Settings creation
            'ta-social-data' => array(
                'options' => array(
                    'transport' => 'postMessage',
                    'default'	=> '',
                ),
                'selective_refresh' => array(
                    'activated' 			=> false,
                    'selector'  			=> '.ta-redes',
                    'container_inclusive'	=>	false,
                    'render_callback'       => function(){
                        get_template_part('parts/social', 'items');
                    },
                ),
            )
        ),
        array(//Control options
            'controls'	=> array(
                'name'	=> array(
                    'input_type'    => 'text',
                    'label'         => 'Nombre',
                ),
                'url'	=> array(
                    'input_type'    => 'text',
                    'label'         => 'Link',
                ),
                'fa'	=> array(
                    'type'      => 'RB_Fontawesome_Control',
                    'label'     => 'Icono',
                ),
            ),
            'title'		    => __( 'Título', 'ta-theme' ),
            //'collapsible'   => true,
            'repeater'      => array(
                'collapsible'   => true,
                'accordion'     => true,
                'item_title'			=> "Red Social (\$n)",
                'title_link'			=> 'name',
                //'sortable'      => false,
                //'max'           => 3,
            ),
        )
    );
}

// =============================================================================
// REGISTER
// =============================================================================
$customizer_api = new RB_Customizer_API($wp_customize, 'customizer_api_configuration');
$customizer_api->initialize();
