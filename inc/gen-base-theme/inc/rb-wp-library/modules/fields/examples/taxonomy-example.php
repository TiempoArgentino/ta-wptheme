<?php

add_action( 'current_screen', function(){

    // =============================================================================
    // TAXONOMIES
    // =============================================================================
    if( $screen->taxonomy == 'category' ){
        // =============================================================================
        // METABOXES
        // =============================================================================
        // new RB_Taxonomy_Form_Field('product_brand_logo', array(
        //     'title'			=> __('Logo', 'gen-plugin'),
        //     'terms'	        => array('product_brand'),
        //     'context'		=> 'normal',
        //     'priority'		=> 'high',
        //     'classes'		=> array('gg-metabox'),
        //     'add_form'      => true,
        // ), array(
        //     'controls'		=> array(
        //         'img'      => array(
        // 			'type'    => 'RB_Media_Control',
        //         ),
        //     ),
        // ));

        // =========================================================================
        // SINGLE EXAMPLE
        // =========================================================================
        /*The single control is the most simple one. It takes only one control and
        displays it.*/

        new RB_Taxonomy_Form_Field('rb-test-single', array(
            'title'			=> __('Single', 'gen-plugin'),
            'terms'	        => array('category'),
            'add_form'      => true,
            'context'		=> 'normal',
            'priority'		=> 'high',
            'classes'		=> array(''),
        ), array(
            'controls'		=> array(
                'text'      => array(
                    'label'         => 'Single field',
                    'input_type'    => 'text',
                ),
            ),
        ));

        // =============================================================================
        // GROUPS EXAMPLES
        // =============================================================================
        /*****************************************************************************
        The controller group is a controller composed of more than one control. It can
        be built with any of the existant controllers (single, group, repeater).
        To create a group, just add more than one control to the controls array
        *****************************************************************************/

        // =============================================================================
        // SINGLES GROUP
        // =============================================================================
        new RB_Taxonomy_Form_Field('rb-test-single-group', array(
            'title'			=> __('Grupo de singles', 'gen-plugin'),
            'terms'	        => array('category'),
    'add_form'      => true,
            'context'		=> 'normal',
            'priority'		=> 'high',
            'classes'		=> array(''),
        ), array(
            'title'		    => __( 'Test de grupo de singles', 'genosha-web' ),
            'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
            'collapsible'   => false,
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
        ));

        // =============================================================================
        // GROUPS GROUP
        // =============================================================================
        /*****************************************************************************
        Controls inside the 'controls' array can be any of the controllers available.
        If a control on a group or repeater has a 'controls' array inside, and that
        array has more than one item, it will be considered a group. The same happens
        with the controls inside that group, and so on.
        *****************************************************************************/

        new RB_Taxonomy_Form_Field('rb-test-groups-group', array(
            'title'			=> __('Grupo de grupos', 'gen-plugin'),
            'terms'	        => array('category'),
    'add_form'      => true,
            'context'		=> 'normal',
            'priority'		=> 'high',
            'classes'		=> array(''),
        ), array(
            'title'		    => __( 'Test de grupo de grupos', 'genosha-web' ),
            'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
            'collapsible'   => false,
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
        ));

        // =============================================================================
        // REPEATERS GROUP
        // =============================================================================
        /*****************************************************************************
        If in the child control 'controller' options, it is especified that the control
        should be a 'repeater', it will be rendered as such.
        *****************************************************************************/

        new RB_Taxonomy_Form_Field('rb-test-repeaters-group', array(
            'title'			=> __('Grupo de repeaters', 'gen-plugin'),
            'terms'	        => array('category'),
    'add_form'      => true,
            'context'		=> 'normal',
            'priority'		=> 'high',
            'classes'		=> array(''),
        ), array(
            'title'		    => __( 'Test de grupo de repetidores', 'genosha-web' ),
            'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
            'collapsible'   => false,
            'controls'	=> array(
                'first'	=> array(
                    'controller'    => array(
                        'title' => 'Repeater Nº1',
                        'description'   => 'Soy la description del repeater dentro del grupo',
                        'repeater'      => array(
                            'item_title'    => 'Item ($n)',
                            'accordion'     => true,
                        ),
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
                        'repeater'      => array(
                            'item_title'    => 'Item ($n)',
                            'accordion'     => true,
                        ),
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
        ));

        // =============================================================================
        // REPEATERS EXAMPLES
        // =============================================================================
        /*****************************************************************************
        The repeater is a controller that takes a controller, and generates
        a list of that controller as 'items' that the user can add, remove and sort as he likes.
        For a controller to be a repeater, the 'repeater' field must evaluate to true.
        The repeater field can also be an array that contains the repeater settings, such as
        collapsible, accordion, item_title, etc.
        The item 'controls' are provided by the 'controls' field. While the item
        'controller settings' must be provided inside the 'repeater' field in the 'item_controller' index
        *****************************************************************************/

        // =============================================================================
        // SINGLES REPEATER
        // =============================================================================
        new RB_Taxonomy_Form_Field('rb-test-singles-repeater', array(
            'title'			=> __('Repeater de singles', 'gen-plugin'),
            'terms'	        => array('category'),
    'add_form'      => true,
            'context'		=> 'normal',
            'priority'		=> 'high',
            'classes'		=> array(''),
        ), array(
            'title'		    => __( 'Repetidor de singles', 'genosha-web' ),
            'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
            'collapsible'   => false,
            'repeater'      => array(
                'item_title'    => 'Item ($n)',
                'collapsible'   => false,
            ),
            'controls'	=> array(
                'first'	=> array(
                    'label'         => 'Single Nº1',
                    'input_type'    => 'text',
                ),
            ),
        ));

        // =============================================================================
        // GROUPS REPEATER
        // =============================================================================
        new RB_Taxonomy_Form_Field('rb-test-groups-repeater', array(
            'title'			=> __('Repeater de grupos', 'gen-plugin'),
            'terms'	        => array('category'),
    'add_form'      => true,
            'context'		=> 'normal',
            'priority'		=> 'high',
            'classes'		=> array(''),
        ), array(
            'title'		    => __( 'Repetidor de grupos', 'genosha-web' ),
            'description'   => __( 'Soy la descripcion del controller', 'genosha-web' ),
            'collapsible'   => false,
            'repeater'  => array(
                'item_title'    => 'Item ($n)',
                'accordion'     => true,
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
        ));

        // =============================================================================
        // REPEATERS REPEATER
        // =============================================================================
        new RB_Taxonomy_Form_Field('rb-test-repeaters-repeater', array(
            'title'			=> __('Repeater de repeaters', 'gen-plugin'),
            'terms'	        => array('category'),
    'add_form'      => true,
            'context'		=> 'normal',
            'priority'		=> 'high',
            'classes'		=> array(''),
        ), array(
            'title'		    => __( 'Repetidor de repetidores', 'genosha-web' ),
            'description'   => __( 'Genero repetidores', 'genosha-web' ),
            'collapsible'   => false,
            'repeater'      => array(
                'item_title'        => 'Item ($n)',
                'accordion'         => true,
                'item_controller'   => array(
                    'title'     => 'Titulo del item',
                    'repeater'  => array(
                        'item_title'    => 'Item ($n)',
                        'collapsible'   => false,
                    ),
                )
            ),
            'controls'	=> array(
                'first'	=> array(
                    'label'         => 'Single Nº1',
                    'input_type'    => 'text',
                ),
            ),
        ));

    }

}
