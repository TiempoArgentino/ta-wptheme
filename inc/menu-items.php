<?php

add_action( 'admin_enqueue_scripts', function(){
    wp_enqueue_media();
});

new RB_Menu_Item_Meta('ta_menu_item_image', array(
    // 'admin_page'		=> 'ta_article',
    'custom_content'    => null,
    'sanitize_value'    => null,
), array(
    'controls'		=> array(
        'image'  => array(
            'label'     			=> __('Imagen del item', 'ta-genosha'),
            'description'           => __('Solo se utiliza en el último menú', 'ta-genosha'),
            'type'          		=> 'RB_Media_Control',
            'store_value'   		=> 'id',
        ),
    ),
));
