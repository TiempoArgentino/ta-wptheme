<?php

//$field-id, $settings
new RB_Metabox('meta_id_test', array(
    'title'			=> __('Información del producto', 'test-genosha'),//Box title
    'admin_page'	=> 'post',//wich page to appear
    'context'		=> 'normal',
    'priority'		=> 'high',
    'classes'		=> array('test-metabox'),//extra classes to add to the metabox
    'controls'		=> array(
        'weight'		=> array(
            'label'			=> 'Cantidad de contenido',
            'type'			=> 'RB_Input_Control',
            'input_type'	=> 'number',
        ),
        'weight_type'	=> array(
            'label'			=> 'Tipo de contenido',
            'type'			=> 'RB_Input_Control',
            'input_type'	=> 'select',
            'choices'		=> array(
                'gr'	=> 'Gramos',
                'cc'	=> 'CC',
                'kg'	=> 'Kilos',
                'pack'	=> 'Paquetes',
            ),
            'option_none'	=> array('lt','Litros'),
        ),
        'prod_rel_id'		=> array(
            'label'			=> 'ID de relacion de productos',
            'description'	=> 'Los productos que tengan esta misma ID seran relacionados. Ej: After Eight 200gr y After Eight 400gr deberían tener la misma ID',
            'type'			=> 'RB_Input_Control',
            'input_type'	=> 'text',
        ),
    )
));

new RB_Metabox('_TEST__testtest____', array(
    'title'			=> __('Testeando', 'test-genosha'),
    'admin_page'	=> 'post',
    'context'		=> 'normal',
    'priority'		=> 'high',
    'classes'		=> array('test-metabox'),
    'controls'		=> array(
        'weight'		=> array(
            'label'			=> 'Cantidad de contenido',
            'type'			=> 'RB_Input_Control',
            'input_type'	=> 'number',
        ),
        'weight_type'	=> array(
            'label'			=> 'Tipo de contenido',
            'type'			=> 'RB_Input_Control',
            'input_type'	=> 'select',
            'choices'		=> array(
                'gr'	=> 'Gramos',
                'cc'	=> 'CC',
                'kg'	=> 'Kilos',
                'pack'	=> 'Paquetes',
            ),
            'option_none'	=> array('lt','Litros'),
        ),
        'prod_rel_id'		=> array(
            'label'			=> 'ID de relacion de productos',
            'description'	=> 'Los productos que tengan esta misma ID seran relacionados. Ej: After Eight 200gr y After Eight 400gr deberían tener la misma ID',
            'type'			=> 'RB_Input_Control',
            'input_type'	=> 'text',
        ),
    ),
    //'collapsible'	=> false,
    'item_title'	=> 'Peso ($n)',
    'title_link'	=> 'prod_rel_id',
    'repeater'		=> true,
));

new RB_Metabox('gallery_control_test_235242424242434', array(
    'title'			=> __('Test gallery control', 'test-genosha'),
    'admin_page'	=> 'test_product',
    'context'		=> 'normal',
    'priority'		=> 'high',
    'classes'		=> array('test-metabox'),
    'controls'		=> array(
        'media'		=> array(
            'label'			=> 'Media',
            'type'			=> 'RB_Media_Control',
        ),
    ),
    //'collapsible'	=> false,
    'item_title'	=> 'Peso ($n)',
    'title_link'	=> 'prod_rel_id',
    'repeater'		=> true,
));

new RB_Metabox('test_product_weights', array(
    'title'			=> __('Variaciones', 'test-genosha'),
    'admin_page'	=> 'test_product',
    'context'		=> 'normal',
    'priority'		=> 'high',
    'classes'		=> array('test-metabox'),
    'controls'		=> array(
        'weight'		=> array(
            'label'			=> 'Cantidad de contenido',
            'type'			=> 'RB_Input_Control',
            'input_type'	=> 'number',
        ),
        'weight_type'	=> array(
            'label'			=> 'Tipo de contenido',
            'type'			=> 'RB_Input_Control',
            'input_type'	=> 'select',
            'choices'		=> array(
                'gr'	=> 'Gramos',
                'cc'	=> 'CC',
                'kg'	=> 'Kilos',
                'pack'	=> 'Paquetes',
            ),
            'option_none'	=> array('lt','Litros'),
        ),
        'image'			=> array(
            'label'			=> 'Media',
            'type'			=> 'RB_Media_Control',
        ),
    ),
    'collapsible'	=> false,
    'repeater'		=> true,
    'item_title'	=> 'Peso ($n)',
));

// new RB_Metabox('test-product-images', 'test_product_images', array(
// 	'title'			=> __('Imagenes', 'test-genosha'),
// 	'admin_page'	=> 'test_product',
// 	'context'		=> 'normal',
// 	'priority'		=> 'high',
// 	//'label'			=> 'Características del producto',
// 	'classes'		=> array('test-metabox'),
// 	'type'			=> 'RB_Images_Gallery_Control',
// ));
