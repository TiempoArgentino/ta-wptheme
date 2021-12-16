<?php

// new RB_Attachment_Meta('ta_attachment_author', array(
//     'title'			=> __('Fotógrafo', 'ta-genosha'),
//     'context'		=> 'normal',
//     'priority'		=> 'high',
//     'classes'		=> array('ta-metabox'),
//     'add_form'      => true,
// ), array(
//     'controls'		=> array(
//         'autor'      => array(
//             // 'label'                 => __('Fotógrafo', 'ta-genosha'),
//             // 'description'       => __('Tamaño recomendado 900 x 600 px.', 'ta-genosha'),
//             'type'                  => 'RB_Term_Selector',
//             'taxonomy'              => 'ta_photographer',
//             'hide_empty'            => false,
//             'query_args'            => array(
//                 'taxonomy'             => 'ta_photographer'
//             ),
//         ),
//     ),
// ));

new RB_Attachment_Meta('ta_attachment_position_y', array(
    'title'			=> __('Posición Vertical', 'ta-genosha'),
    'context'		=> 'normal',
    'priority'		=> 'high',
    'classes'		=> array('ta-metabox'),
    'add_form'      => true,
), array(
    'controls'		=> array(
        'position_y'   => array(
            'input_type'    => 'select',
            'choices'       => array(
                'top'                   => 'Arriba',
                'bottom'                => 'Abajo',
                'center'                => 'Centro'
            ),
            'input_options' => array(
                'option_none'   => array('top', 'Por defecto'),
            ),
            'default'       => 'top',
        ),
    ),
));


new RB_Attachment_Meta('lr_attachment_position_x', array(
    'title'			=> __('Posición Horizontal', 'ta-genosha'),
    'context'		=> 'normal',
    'priority'		=> 'high',
    'classes'		=> array('ta-metabox'),
    'add_form'      => true,
), array(
    'controls'		=> array(
        'position_x'   => array(
            'input_type'    => 'select',
            'choices'       => array(
                'left'                  => 'Izquierda',
                'right'                 => 'Derecha',
                'center'                => 'Centro'
            ),
            'input_options' => array(
                'option_none'   => array('center', 'Por defecto'),
            ),
            'default'       => 'center',
        ),
    ),
));
