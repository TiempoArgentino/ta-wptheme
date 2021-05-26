<?php

// =========================================================================
// FEATURE TESTING
// =========================================================================
$customizer_api->add_section(
    'rb-fields-test',
    array(
        'title'     => 'RB: Testing Features',
        'priority'  => 1,
    ),
    array(
        // 'activated' 		=> true,
        // 'selector'			=>	"#main-grid",
    )
)
->add_control(//Control creation
    'rb-test-single',//id
    'RB_Customizer_Field_Control',//control class
    array(//Settings creation
        'rb-test-single' => array(
            'options' => array(
                'transport' => 'postMessage',
                'default'	=> '',
            ),
            'selective_refresh' => array(
                'activated' 			=> true,
                'selector'  			=> '#landing-header-title',
                'container_inclusive'	=>	false,
                'render_callback'       => function(){ print_r('test'); },
            ),
        )
    ),
    array(//Control options
        'title'		    => __( 'Test de single field', 'genosha-web' ),
        'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
        'collapsible'   => true,
        'controls'	=> array(
            'name'	=> array(
                'input_type'    => 'text',
                'label'         => 'Nombre',
            ),
        ),
    )
)
->add_control(//Control creation
    'rb-test-singles-group',//id
    'RB_Customizer_Field_Control',//control class
    array(//Settings creation
        'rb-test-singles-group' => array(
            'options' => array(
                'transport' => 'postMessage',
                'default'	=> '',
            ),
            'selective_refresh' => array(
                'activated' 			=> true,
                'selector'  			=> '#landing-header-title',
                'container_inclusive'	=>	false,
                'render_callback'       => function(){ print_r('test'); },
            ),
        )
    ),
    array(//Control options
        'title'		    => __( 'Test de grupo de singles', 'genosha-web' ),
        'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
        'collapsible'   => true,
        'controls'	=> array(
            'first'	=> array(
                'input_type'    => 'text',
                'label'         => 'Single Nº1',
            ),
            'secnod'	=> array(
                'input_type'    => 'text',
                'label'         => 'Single Nº2',
            ),
        ),
    )
)
->add_control(//Control creation
    'rb-test-groups-group',//id
    'RB_Customizer_Field_Control',//control class
    array(//Settings creation
        'rb-test-groups-group' => array(
            'options' => array(
                'transport' => 'postMessage',
                'default'	=> '',
            ),
            'selective_refresh' => array(
                'activated' 			=> true,
                'selector'  			=> '#landing-header-title',
                'container_inclusive'	=>	false,
                'render_callback'       => function(){ print_r('test'); },
            ),
        )
    ),
    array(//Control options
        'title'		    => __( 'Test de grupo de grupos', 'genosha-web' ),
        'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
        'collapsible'   => true,
        'controls'	=> array(
            'first'	=> array(
                'controller'    => array(
                    'title' => 'Subgrupo Nº1',
                    'description'   => 'Soy la description del grupo dentro del grupo (inception)',
                ),
                'controls'  => array(
                    'first' => array(
                        'label'         => 'Single Nº1',
                        'input_type'    => 'text',
                    ),
                    'second' => array(
                        'label'         => 'Single Nº2',
                        'input_type'    => 'text',
                    ),
                ),
            ),
            'second'	=> array(
                'controller'    => array(
                    'title' => 'Subgrupo Nº2',
                ),
                'controls'  => array(
                    'first' => array(
                        'label'         => 'Single Nº1',
                        'input_type'    => 'text',
                    ),
                    'second' => array(
                        'label'         => 'Single Nº2',
                        'input_type'    => 'text',
                    ),
                ),
            ),
        ),
    )
)
->add_control(//Control creation
    'rb-test-repeaters-group',//id
    'RB_Customizer_Field_Control',//control class
    array(//Settings creation
        'rb-test-repeaters-group' => array(
            'options' => array(
                'transport' => 'postMessage',
                'default'	=> '',
            ),
            'selective_refresh' => array(
                'activated' 			=> true,
                'selector'  			=> '#landing-header-title',
                'container_inclusive'	=>	false,
                'render_callback'       => function(){ print_r('test'); },
            ),
        )
    ),
    array(//Control options
        'title'		    => __( 'Test de grupo de repetidores', 'genosha-web' ),
        'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
        'collapsible'   => true,
        'controls'	=> array(
            'first'	=> array(
                'controller'    => array(
                    'title' => 'Repeater Nº1',
                    'description'   => 'Soy la description del repeater dentro del grupo',
                    'repeater'      => true,
                ),
                'controls'  => array(
                    'first' => array(
                        'label'         => 'Single Nº1',
                        'input_type'    => 'text',
                    ),
                    'second' => array(
                        'label'         => 'Single Nº2',
                        'input_type'    => 'text',
                    ),
                ),
            ),
            'second'	=> array(
                'controller'    => array(
                    'title' => 'Repeater Nº2',
                    'repeater'      => true,
                ),
                'controls'  => array(
                    'first' => array(
                        'label'         => 'Single Nº1',
                        'input_type'    => 'text',
                    ),
                    'second' => array(
                        'label'         => 'Single Nº2',
                        'input_type'    => 'text',
                    ),
                ),
            ),
        ),
    )
)
->add_control(//Control creation
    'rb-test-singles-repeater',//id
    'RB_Customizer_Field_Control',//control class
    array(//Settings creation
        'rb-test-singles-repeater' => array(
            'options' => array(
                'transport' => 'postMessage',
                'default'	=> '',
            ),
            'selective_refresh' => array(
                'activated' 			=> true,
                'selector'  			=> '#landing-header-title',
                'container_inclusive'	=>	false,
                'render_callback'       => function(){ print_r('test'); },
            ),
        )
    ),
    array(//Control options
        'title'		    => __( 'Repetidor de singles', 'genosha-web' ),
        'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
        'collapsible'   => true,
        'repeater'      => true,
        'controls'	=> array(
            'first'	=> array(
                'label'         => 'Single Nº1',
                'input_type'    => 'text',
            ),
        ),
    )
)
->add_control(//Control creation
    'rb-test-groups-repeater',//id
    'RB_Customizer_Field_Control',//control class
    array(//Settings creation
        'rb-test-groups-repeater' => array(
            'options' => array(
                'transport' => 'postMessage',
                'default'	=> '',
            ),
            'selective_refresh' => array(
                'activated' 			=> true,
                'selector'  			=> '#landing-header-title',
                'container_inclusive'	=>	false,
                'render_callback'       => function(){ print_r('test'); },
            ),
        )
    ),
    array(//Control options
        'title'		    => __( 'Repetidor de grupos', 'genosha-web' ),
        'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
        'collapsible'   => true,
        'repeater'  => array(
            'item_controller'   => array(
                'title'     => 'Titulo del item',
                //'repeater'  => true,
            )
        ),
        'controls'	=> array(
            'first'	=> array(
                'label'         => 'Single Nº1',
                'input_type'    => 'text',
            ),
            'second'	=> array(
                'label'         => 'Single Nº2',
                'input_type'    => 'text',
            ),
        ),
    )
)
->add_control(//Control creation
    'rb-test-repeaters-repeater',//id
    'RB_Customizer_Field_Control',//control class
    array(//Settings creation
        'rb-test-repeaters-repeater' => array(
            'options' => array(
                'transport' => 'postMessage',
                'default'	=> '',
            ),
            'selective_refresh' => array(
                'activated' 			=> true,
                'selector'  			=> '#landing-header-title',
                'container_inclusive'	=>	false,
                'render_callback'       => function(){ print_r('test'); },
            ),
        )
    ),
    array(//Control options
        'title'		    => __( 'Repetidor de repetidores', 'genosha-web' ),
        'description'   => __( 'Genero repetidores', 'genosha-web' ),
        'collapsible'   => true,
        'repeater'  => array(
            'accordion'         => true,
            'item_controller'   => array(
                'title'     => 'Titulo del item',
                'repeater'  => true,
            )
        ),
        'controls'	=> array(
            'first'	=> array(
                'label'         => 'Single Nº1',
                'input_type'    => 'number',
            ),
        ),
    )
);
