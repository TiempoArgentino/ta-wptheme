<?php

if ( function_exists( 'lazyblocks' ) ) :

    lazyblocks()->add_block( array(
        'id' => 10517,
        'title' => 'Newsletter Home',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" /></svg>',
        'keywords' => array(
        ),
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
        'condition' => array(
        ),
    ) );
    
endif;