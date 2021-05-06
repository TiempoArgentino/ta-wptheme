<?php
//add_action('init','avisos_lista');

function avisos_lista()
{
    if(function_exists('ADDB')) {
        $avisos = ADDB()->get_all_data('tar_ads_manager_ads', 'ORDER BY name DESC LIMIT ', 200, 0);
        $coso = [];
        foreach($avisos as $aviso)
        {
        $coso[] = [
            'label' => $aviso->{'group'}.' - '.$aviso->{'name'},
            'value' => $aviso->{'ID'}
        ];
        }
        return $coso;
    }
    
}

if ( function_exists( 'lazyblocks' ) ) :

    lazyblocks()->add_block( array(
        'id' => 10513,
        'title' => 'Avisos',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 9h-2V5h2v6zm0 4h-2v-2h2v2z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/avisos',
        'description' => '',
        'category' => 'widgets',
        'category_label' => 'widgets',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'ghostkit' => array(
            'supports' => array(
                'spacings' => false,
                'display' => false,
                'scrollReveal' => false,
                'frame' => false,
                'customCSS' => false,
            ),
        ),
        'controls' => array(
            'control_65e82c4017' => array(
                'type' => 'select',
                'name' => 'aviso',
                'default' => '-- seleccionar aviso --',
                'label' => 'Aviso',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'choices' => avisos_lista(),
                'allow_null' => 'false',
                'multiple' => 'false',
                'output_format' => '',
                'placeholder' => '',
                'characters_limit' => '',
            ),
        ),
        'code' => array(
            'output_method' => 'php',
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '
            <?php if(function_exists(\'widgets_ta\')): ?>
                <?php echo widgets_ta()->shortcode_portada($attributes[\'aviso\'])?>
            <?php endif;?>',
            'frontend_callback' => '',
            'frontend_css' => '',
            'show_preview' => 'always',
            'single_output' => false,
        ),
        'condition' => array(
        ),
    ) );
    
    lazyblocks()->add_block( array(
        'id' => 10512,
        'title' => 'Contenedor Avisos',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 9h-2V5h2v6zm0 4h-2v-2h2v2z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/contenedor-avisos',
        'description' => '',
        'category' => 'widgets',
        'category_label' => 'widgets',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'ghostkit' => array(
            'supports' => array(
                'spacings' => false,
                'display' => false,
                'scrollReveal' => false,
                'frame' => false,
                'customCSS' => false,
            ),
        ),
        'controls' => array(
            'control_c94a6f4b9a' => array(
                'type' => 'select',
                'name' => 'pantalla',
                'default' => '-- seleccionar pantalla --',
                'label' => 'Pantalla',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'choices' => array(
                    array(
                        'label' => '-- seleccionar pantalla --',
                        'value' => '',
                    ),
                    array(
                        'label' => 'Desktop',
                        'value' => 'avisos-contenedor-desktop row d-none d-sm-none d-md-flex d-lg-flex',
                    ),
                    array(
                        'label' => 'Mobile',
                        'value' => 'avisos-contenedor-mobile rowd-block d-sm-none d-md-none d-lg-none',
                    ),
                ),
                'allow_null' => 'false',
                'multiple' => 'false',
                'output_format' => '',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_4548fc4fe7' => array(
                'type' => 'inner_blocks',
                'name' => 'contenedor',
                'default' => '',
                'label' => 'Contenedor',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'placeholder' => '',
                'characters_limit' => '',
            ),
        ),
        'code' => array(
            'output_method' => 'php',
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="<?php echo $attributes[\'pantalla\']?> ">
        <?php echo $attributes[\'contenedor\']?>
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
            'show_preview' => 'always',
            'single_output' => false,
        ),
        'condition' => array(
        ),
    ) );
    
endif;