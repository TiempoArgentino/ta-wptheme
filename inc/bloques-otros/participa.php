<?php

if ( function_exists( 'lazyblocks' ) ) :

    lazyblocks()->add_block( array(
        'id' => 11828,
        'title' => 'Participa',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/no-slug',
        'description' => '',
        'category' => 'design',
        'category_label' => 'design',
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
            'control_a31a8c4351' => array(
                'type' => 'text',
                'name' => 'titulo-header',
                'default' => 'PARTICIPÁ',
                'label' => 'Titulo Header',
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
            'control_11484e4592' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => 'Desde Tiempo Argentino queremos generar comunidad:',
                'label' => 'Titulo Principal',
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
            'control_d228aa4da5' => array(
                'type' => 'textarea',
                'name' => 'texto',
                'default' => 'Te ofrecemos la posibilidad de interactuar con tus referentes de opinión y con otrxs socixs y lectorxs de Tiempo.',
                'label' => 'Texto',
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
            'control_cfbbb64bf0' => array(
                'type' => 'image',
                'name' => 'imagen-1',
                'default' => '',
                'label' => 'Imagen 1',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'preview_size' => 'medium',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_0a9a734d66' => array(
                'type' => 'text',
                'name' => 'titulo-1',
                'default' => 'Participá con Tiempo',
                'label' => 'Titulo 1',
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
            'control_5e5b4d4904' => array(
                'type' => 'textarea',
                'name' => 'texto-1',
                'default' => 'Comentá en las últimas noticias y formá comunidad',
                'label' => 'Texto 1',
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
            'control_178925487d' => array(
                'type' => 'image',
                'name' => 'imagen-2',
                'default' => '',
                'label' => 'Imagen 2',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'preview_size' => 'medium',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_f3ea7b4aaf' => array(
                'type' => 'text',
                'name' => 'titulo-2',
                'default' => 'Preguntá y participá',
                'label' => 'Titulo 2',
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
            'control_0b3a2d4169' => array(
                'type' => 'textarea',
                'name' => 'texto-2',
                'default' => 'Dejá tu consulta para que el autor de la nota responda',
                'label' => 'Texto 2',
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
            'control_a82b75439f' => array(
                'type' => 'image',
                'name' => 'imagen-3',
                'default' => '',
                'label' => 'Imagen 3',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'preview_size' => 'medium',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_5baadc4d20' => array(
                'type' => 'text',
                'name' => 'titulo-3',
                'default' => 'Participá de Vivos',
                'label' => 'Titulo 3',
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
            'control_ba6b744dd9' => array(
                'type' => 'textarea',
                'name' => 'texto-3',
                'default' => 'Comentá y debatí en vivos de tus temas de interés',
                'label' => 'Texto 3',
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
            'control_c2c87a4938' => array(
                'type' => 'image',
                'name' => 'imagen-4',
                'default' => '',
                'label' => 'Imagen 4',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'preview_size' => 'medium',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_8c384a4f63' => array(
                'type' => 'text',
                'name' => 'titulo-4',
                'default' => 'Cerca de los autores',
                'label' => 'Titulo 4',
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
            'control_df09624932' => array(
                'type' => 'textarea',
                'name' => 'texto-4',
                'default' => 'Recibí notificaciones de sus respuestas e interacciones',
                'label' => 'Texto 4',
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
            'control_f6092943ae' => array(
                'type' => 'text',
                'name' => 'boton-texto',
                'default' => 'QUIERO SER PARTE',
                'label' => 'Boton Texto',
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
            'control_ce4a5447ab' => array(
                'type' => 'url',
                'name' => 'boton-link',
                'default' => '',
                'label' => 'Boton Link',
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
            'frontend_html' => '        <div class="container ta-context participa mt-2 my-lg-5">
                    <div class="context-bg amarillo">
                            <div class="line-height-0">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class="participa-block-container">
                                    <div class="section-title p-2">
                                            <h4><?php echo $attributes[\'titulo-header\']?></h4>
                                    </div>
                                    <div class="container">
                                            <div class="container-with-header">
                                                    <div class="py-2">
                                                            <div class="subs-opt mt-3 mt-md-5">
                                                                    <div class="title text-center">
                                                                            <h4 class="italic"><?php echo $attributes[\'titulo\']?></h4>
                                                                    </div>
                                                                    <div class="subtitle">
                                                                            <p><?php echo $attributes[\'texto\']?></p>
                                                                    </div>
                                                                    <div id="participaCarousel"
                                                                            class="participa-items carousel slide d-block d-md-none mt-4" data-ride="carousel">
                                                                            <div class="carousel-inner">
                                                                                    <div class="carousel-item item py-3 px-2 active">
                                                                                            <div
                                                                                                    class="d-flex flex-column align-items-start justify-content-center h-100">
                                                                                                    <img class="d-block w-100" src="<?php echo $attributes[\'imagen-1\'][\'url\']?>"
                                                                                                            alt="First slide">
                                                                                                    <div class="caption mt-3 mx-auto">
                                                                                                            <div class="title">
                                                                                                                    <h3><?php echo $attributes[\'titulo-1\']?></h3>
                                                                                                            </div>
                                                                                                            <div class="subtitle">
                                                                                                                    <p><?php echo $attributes[\'texto-1\']?></p>
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="carousel-item item py-3 px-2">
                                                                                            <div
                                                                                                    class="d-flex flex-column align-items-start justify-content-center h-100">
                                                                                                    <img class="d-block w-100" src="<?php echo $attributes[\'imagen-2\'][\'url\']?>"
                                                                                                            alt="Second slide">
                                                                                                    <div class="caption mt-3 mx-auto">
                                                                                                            <div class="title">
                                                                                                                    <h3><?php echo $attributes[\'titulo-2\']?></h3>
                                                                                                            </div>
                                                                                                            <div class="subtitle">
                                                                                                                    <p><?php echo $attributes[\'texto-2\']?></p>
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="carousel-item item py-3 px-2">
                                                                                            <div
                                                                                                    class="d-flex flex-column align-items-start justify-content-center h-100">
                                                                                                    <img class="d-block w-100" src="<?php echo $attributes[\'imagen-3\'][\'url\']?>"
                                                                                                            alt="Third slide">
                                                                                                    <div class="caption mt-3 mx-auto">
                                                                                                            <div class="title">
                                                                                                                    <h3><?php echo $attributes[\'titulo-3\']?></h3>
                                                                                                            </div>
                                                                                                            <div class="subtitle">
                                                                                                                    <p><?php echo $attributes[\'texto-3\']?></p>
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="carousel-item item py-3 px-2">
                                                                                            <div
                                                                                                    class="d-flex flex-column align-items-start justify-content-center h-100">
                                                                                                    <img class="d-block w-100" src="<?php echo $attributes[\'imagen-4\'][\'url\']?>"
                                                                                                            alt="Fourth slide">
                                                                                                    <div class="caption mt-3 mx-auto">
                                                                                                            <div class="title">
                                                                                                                    <h3><?php echo $attributes[\'titulo-4\']?></h3>
                                                                                                            </div>
                                                                                                            <div class="subtitle">
                                                                                                                    <p><?php echo $attributes[\'texto-4\']?></p>
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <ol class="carousel-indicators">
                                                                                    <li data-target="#participaCarousel" data-slide-to="0" class="active"></li>
                                                                                    <li data-target="#participaCarousel" data-slide-to="1"></li>
                                                                                    <li data-target="#participaCarousel" data-slide-to="2"></li>
                                                                                    <li data-target="#participaCarousel" data-slide-to="3"></li>
                                                                            </ol>
                                                                    </div>
                                                                    <div
                                                                            class="participa-items desktop d-none d-md-flex flex-column flex-md-row justify-content-md-between mt-md-5">
                                                                            <div class="item py-3 px-2 mx-3">
                                                                                    <div class="d-flex flex-column align-items-start justify-content-center h-100">
                                                                                            <img class="d-block w-100" src="<?php echo $attributes[\'imagen-1\'][\'url\']?>"
                                                                                                    alt="First slide">
                                                                                            <div class="caption mt-3">
                                                                                                    <div class="title">
                                                                                                            <h3><?php echo $attributes[\'titulo-1\']?></h3>
                                                                                                    </div>
                                                                                                    <div class="subtitle">
                                                                                                            <p><?php echo $attributes[\'texto-1\']?></p>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="item py-3 px-2 mx-3">
                                                                                    <div class="d-flex flex-column align-items-start justify-content-center h-100">
                                                                                            <img class="d-block w-100" src="<?php echo $attributes[\'imagen-2\'][\'url\']?>"
                                                                                                    alt="Second slide">
                                                                                            <div class="caption mt-3">
                                                                                                    <div class="title">
                                                                                                            <h3><?php echo $attributes[\'titulo-2\']?></h3>
                                                                                                    </div>
                                                                                                    <div class="subtitle">
                                                                                                            <p><?php echo $attributes[\'texto-2\']?></p>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="item py-3 px-2 mx-3">
                                                                                    <div class="d-flex flex-column align-items-start justify-content-center h-100">
                                                                                            <img class="d-block w-100" src="<?php echo $attributes[\'imagen-3\'][\'url\']?>"
                                                                                                    alt="Third slide">
                                                                                            <div class="caption mt-3">
                                                                                                    <div class="title">
                                                                                                            <h3><?php echo $attributes[\'titulo-3\']?></h3>
                                                                                                    </div>
                                                                                                    <div class="subtitle">
                                                                                                            <p><?php echo $attributes[\'texto-3\']?></p>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="item py-3 px-2 mx-3">
                                                                                    <div class="d-flex flex-column align-items-start justify-content-center h-100">
                                                                                            <img class="d-block w-100" src="<?php echo $attributes[\'imagen-4\'][\'url\']?>"
                                                                                                    alt="Fourth slide">
                                                                                            <div class="caption mt-3">
                                                                                                    <div class="title">
                                                                                                            <h3><?php echo $attributes[\'titulo-4\']?></h3>
                                                                                                    </div>
                                                                                                    <div class="subtitle">
                                                                                                            <p><?php echo $attributes[\'texto-4\']?></p>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                                    <div class="btns-container text-center my-2 mt-md-5 mb-md-4">
                                                                            <button><a href="<?php echo $attributes[\'boton-link\']?>"><?php echo $attributes[\'boton-texto\']?></a></button>
                                                                    </div>
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