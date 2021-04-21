<?php
add_action('init','showcoso');
function showcoso()
{
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

if (function_exists('lazyblocks')) :

    lazyblocks()->add_block(array(
        'id' => 667,
        'title' => 'Newsletter Home',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" /></svg>',
        'keywords' => array(),
        'slug' => 'lazyblock/newsletter-home',
        'description' => '',
        'category' => 'design',
        'category_label' => 'design',
        'supports' => array(
            'customClassName' => true,
            'anchor' => true,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => false,
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
            'control_cd49184764' => array(
                'type' => 'url',
                'name' => 'newsletter',
                'default' => '',
                'label' => 'Link a newsletter',
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
            'editor_html' => '<div class="text-align-center">Bloque newsletter portada</div>',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="m-3 m-md-5">
            <div class="ta-context blue-border newsletter newsletter-personalizar">
                    <div class="py-4">
                            <div class="container d-flex flex-column flex-md-row align-items-end text-center text-md-left">
                                    <div class="w-100">
                                            <div class="envelope-icon text-left">
                                                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/envelope.svg" alt="" />
                                            </div>
                                            <div class=" text-center">
                                                    <div class="section-title">
                                                            <h4>Sumate a nuestro NEWSLETTER</h4>
                                                    </div>
                                                    <div class="subtitle mt-2">
                                                            <p class="mb-0">Recibí contenido adecuado a tus intereses. </p>
                                                            <p>Podés personalizar el Newsletter para que se ajuste tus preferencias:</p>
                                                    </div>
                                                    <div class="newsletter-options mt-4">
                                                            <button class="uppercase"><a href="<?php echo $attributes[\'newsletter\']; ?>">PERSONALIZAR</a></button>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </div>
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
            'show_preview' => 'always',
            'single_output' => false,
        ),
        'condition' => array(),
    ));

    lazyblocks()->add_block( array(
        'id' => 10111,
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
                'choices' => showcoso(),
                'allow_null' => 'false',
                'multiple' => 'false',
                'output_format' => '',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_01a96149c1' => array(
                'type' => 'select',
                'name' => 'tamanio',
                'default' => '-- seleccionar tamaño --',
                'label' => 'Tamaño',
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
                        'label' => '-- seleccionar tamaño --',
                        'value' => '',
                    ),
                    array(
                        'label' => '1/3',
                        'value' => 'col-4',
                    ),
                    array(
                        'label' => '1/4',
                        'value' => 'col-3',
                    ),
                    array(
                        'label' => '1/6',
                        'value' => 'col-6',
                    ),
                    array(
                        'label' => 'Entero',
                        'value' => 'col-12',
                    ),
                ),
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
            'frontend_html' => '<div class="<?php echo $attributes[\'tamanio\']; ?>">
        hola <?php echo $attributes[\'tamanio\']; ?>
        <?php if(function_exists(\'widgets_ta\')): ?>
            <?php echo widgets_ta()->shortcode_portada($attributes[\'aviso-1\'],$attributes[\'grupo-1\'])?>
        <?php endif;?>
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
            'show_preview' => 'always',
            'single_output' => false,
        ),
        'condition' => array(
        ),
    ) );
    
    lazyblocks()->add_block( array(
        'id' => 10110,
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
