<?php

new RB_Metabox('test_metakey', array(
    'title'			=> __('GEN Base', 'gen-theme'),
    'admin_page'	=> 'post',
    'context'		=> 'side',
    'priority'		=> 'high',
    'classes'		=> array('gen-metabox'),
), array(
    'group'         => true,
    'collapsible'   => true,
    'title'         => "Test GENOSHA",
    'controls'		=> array(
        'test'   => array(
            'label'         => 'Test Field 1',
            'input_type'    => 'text',
            'default'       => 'probando',
        ),
        'test2'   => array(
            'label'         => 'Test Field 2',
            'input_type'    => 'text',
            'default'       => 'libreria',
        ),
    )
));
