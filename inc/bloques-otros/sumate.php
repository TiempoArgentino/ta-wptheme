<?php
if ( function_exists( 'lazyblocks' ) ) :

    lazyblocks()->add_block( array(
        'id' => 10502,
        'title' => 'Sumate - Visión',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/sumate-nosotros',
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
            'control_e80b15490a' => array(
                'type' => 'text',
                'name' => 'titulo-header',
                'default' => 'NOSOTROS',
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
            'control_daf93a49e8' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => '¿Cuál es nuestra visión?',
                'label' => 'Titulo',
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
            'control_f4881d4410' => array(
                'type' => 'code_editor',
                'name' => 'mensaje',
                'default' => '',
                'label' => 'Mensaje',
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
            'control_7798444330' => array(
                'type' => 'image',
                'name' => 'imagen',
                'default' => '',
                'label' => 'Imagen',
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
        ),
        'code' => array(
            'output_method' => 'php',
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="ta-context sumate mt-3">
            <div class="container-with-header">
                    <div class="">
                            <div class="container line-height-0 px-0 px-md-2">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class="context-bg py-3">
                                    <div class="container">
                                            <a class="scrollTo" id="nosotrosFocus"></a>
                                            <div class="section-title">
                                                    <h4><?php echo $attributes[\'titulo-header\']?></h4>
                                            </div>
                                    </div>
                                    <div class="content mt-3">
                                            <div class="container">
                                                    <div class="title">
                                                            <h3><?php echo $attributes[\'titulo\']?></h3>
                                                    </div>
    
                                                    <div class="ver-mas text-center">
                                                            <button class="d-md-none" type="button" data-toggle="collapse" data-target="#visionSumate"
                                                                    aria-expanded="false" aria-controls="visionSumate" id="verMasDropdown">
                                                                    ver más <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/gray-arrow.svg" alt="">
                                                            </button>
                                                            <div class="vision-sumate dropdown collapse mt-3 show" id="visionSumate">
                                                                    <p><?php echo $attributes[\'mensaje\']?></p>
                                                                    <div class="img-container">
                                                                            <img src="<?php echo $attributes[\'imagen\'][\'url\']?>" class="img-fluid" alt="">
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
    
    lazyblocks()->add_block( array(
        'id' => 10486,
        'title' => 'Sumate - Formas',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/sumate-formas',
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
            'control_27bb8843f4' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => '¡Hay muchas formas de sumarte!',
                'label' => 'Titulo',
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
            'control_9f8afb454d' => array(
                'type' => 'code_editor',
                'name' => 'texto-color-1',
                'default' => '',
                'label' => 'Texto',
                'help' => 'Suscribite gratis al Newsletter o
                                                                            sumate a los Vivos que
                                                                            organizamos.',
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
            'frontend_html' => '<div class="ta-context sumate mt-3">
            <div class="container-with-header">
                    <div class="">
                            <div class="container line-height-0 text-center">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class=" py-3">
                                    <div class="content mt-3">
                                            <div class="container">
                                                    <div class="subtitle">
                                                            <p><?php echo $attributes[\'titulo\']?></p>
                                                    </div>
                                                    <div class="ver-mas text-center">
                                                            <button class="d-md-none" type="button" data-toggle="collapse" data-target="#formasSumate"
                                                                    aria-expanded="false" aria-controls="formasSumate" id="verMasDropdown">
                                                                    ver más <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/gray-arrow.svg" alt="">
                                                            </button>
                                                            <div class="formas-sumate dropdown collapse mt-3 show" id="formasSumate">
                                                                    <?php echo $attributes[\'texto-color-1\']?>
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
    
    lazyblocks()->add_block( array(
        'id' => 10474,
        'title' => 'Sumate - Que Ofrecemos',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/sumate-que-ofrecemos',
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
            'control_7d19aa48b2' => array(
                'type' => 'text',
                'name' => 'titulo-header',
                'default' => 'QUÉ OFRECEMOS',
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
            'control_2feb0c4dcb' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => '¿Qué contenido ofrecemos?',
                'label' => 'Titulo',
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
            'control_942ab24bd3' => array(
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
                'preview_size' => 'full',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_d498d3409f' => array(
                'type' => 'text',
                'name' => 'link-1',
                'default' => '',
                'label' => 'Link 1',
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
            'control_b7e89f44a1' => array(
                'type' => 'text',
                'name' => 'titulo-1',
                'default' => 'Cooperativas de mujeres y disidencias, una respuesta a la desigualdad estructural',
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
            'control_5b39cf487a' => array(
                'type' => 'text',
                'name' => 'autor-1',
                'default' => '',
                'label' => 'Autor 1',
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
            'control_eba8df49bf' => array(
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
                'preview_size' => 'full',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_71e9dc4d2e' => array(
                'type' => 'url',
                'name' => 'link-2',
                'default' => '',
                'label' => 'Link 2',
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
            'control_820b5147c4' => array(
                'type' => 'text',
                'name' => 'titulo-2',
                'default' => 'Alé Alé, un restaurante recuperado que cuenta la lucha desde el menú',
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
            'control_cb08ad49a8' => array(
                'type' => 'text',
                'name' => 'autor-2',
                'default' => 'Juli Ramos y Carlos Mendoza',
                'label' => 'Autor 2',
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
            'control_a3184247b6' => array(
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
                'preview_size' => 'full',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_6d7bd941ee' => array(
                'type' => 'url',
                'name' => 'link-3',
                'default' => '',
                'label' => 'Link 3',
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
            'control_1a58364a80' => array(
                'type' => 'text',
                'name' => 'titulo-3',
                'default' => 'Crédito cooperativo, la historia de una resistencia al Fondo y a las dictaduras',
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
            'control_f00a7c4943' => array(
                'type' => 'text',
                'name' => 'autor-3',
                'default' => 'Juli Ramos y Carlos Mendoza',
                'label' => 'Autor 3',
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
            'frontend_html' => '<div class="ta-context sumate mt-3">
            <div class="container-with-header">
                    <div class="">
                            <div class="container line-height-0 px-0 px-md-2">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class="context-bg py-3">
                                    <div class="container">
                                            <div class="section-title">
                                                    <h4><?php echo $attributes[\'titulo-header\']?></h4>
                                            </div>
                                    </div>
                                    <div class="content mt-3">
                                            <div class="container">
                                                    <div class="subtitle">
                                                            <p><?php echo $attributes[\'titulo\']?></p>
                                                    </div>
                                                    <div class="ver-mas text-center">
                                                            <button class="d-md-none" type="button" data-toggle="collapse" data-target="#queOfrecemos"
                                                                    aria-expanded="false" aria-controls="queOfrecemos" id="verMasDropdown">
                                                                    ver más <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/gray-arrow.svg" alt="">
                                                            </button>
                                                            <div class="que-ofrecemos dropdown collapse mt-3 mt-md-4 d-md-flex flex-md-row"
                                                                    id="queOfrecemos">
                                                                    <div class="article-preview text-left d-flex flex-md-column mb-3">
                                                                            <div class="col-5 col-md-12 pr-0 pr-md-3">
                                                                                    <a href="">
                                                                                            <div class="img-container position-relative">
                                                                                                    <div class="img-wrapper" style="background:url(<?php echo $attributes[\'imagen-1\'][\'url\']?>) center no-repeat;background-size: cover !important;"></div>
                                                                                            </div>
                                                                                    </a>
                                                                            </div>
                                                                            <div class="content col-7 col-md-12">
                                                                                    <div>
                                                                                            <a href="<?php echo $attributes[\'link-1\']?>">
                                                                                                    <p><?php echo $attributes[\'titulo-1\']?>
                                                                                                    </p>
                                                                                            </a>
                                                                                    </div>
                                                                                    <div class="article-info-container">
                                                                                            <div class="author">
                                                                                                    <p>Por: <?php echo $attributes[\'autor-1\']?></p>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                                    <div class="article-preview text-left d-flex flex-md-column mb-3">
                                                                            <div class="col-5 col-md-12 pr-0 pr-md-3">
                                                                                    <a href="">
                                                                                            <div class="img-container position-relative">
                                                                                                    <div class="img-wrapper" style="background:url(<?php echo $attributes[\'imagen-2\'][\'url\']?>) center no-repeat;background-size: cover !important;"></div>
                                                                                            </div>
                                                                                    </a>
                                                                            </div>
                                                                            <div class="content col-7 col-md-12">
                                                                                    <div>
                                                                                            <a href="<?php echo $attributes[\'link-2\']?>">
                                                                                                    <p><?php echo $attributes[\'titulo-2\']?>
                                                                                                    </p>
                                                                                            </a>
                                                                                    </div>
                                                                                    <div class="article-info-container">
                                                                                            <div class="author">
                                                                                                    <p>Por: <?php echo $attributes[\'autor-2\']?></p>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                                    <div class="article-preview text-left d-flex flex-md-column mb-3">
                                                                            <div class="col-5 col-md-12 pr-0 pr-md-3">
                                                                                    <a href="">
                                                                                            <div class="img-container position-relative">
                                                                                                    <div class="img-wrapper" style="background:url(<?php echo $attributes[\'imagen-3\'][\'url\']?>) center no-repeat;background-size: cover !important;"></div>
                                                                                            </div>
                                                                                    </a>
                                                                            </div>
                                                                            <div class="content col-7 col-md-12">
                                                                                    <div>
                                                                                            <a href="<?php echo $attributes[\'link-3\']?>">
                                                                                                    <p><?php echo $attributes[\'titulo-3\']?>
                                                                                                    </p>
                                                                                            </a>
                                                                                    </div>
                                                                                    <div class="article-info-container">
                                                                                            <div class="author">
                                                                                                    <p>Por: <?php echo $attributes[\'autor-3\']?></p>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
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
    
    lazyblocks()->add_block( array(
        'id' => 10471,
        'title' => 'Sumate - Contenedor texto titulo',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/sumate-contenedor-texto-titulo',
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
            'control_cc7a8849c4' => array(
                'type' => 'text',
                'name' => 'titulo-header',
                'default' => 'nuestro compromiso',
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
            'control_e54be44fa5' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => 'Apoyá la autogestión',
                'label' => 'Titulo',
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
            'control_d968c547ae' => array(
                'type' => 'text',
                'name' => 'sub-titulo',
                'default' => '¿A qué contribuís cuando apoyás a Tiempo Argentino?',
                'label' => 'Sub titulo',
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
            'control_3959924e41' => array(
                'type' => 'rich_text',
                'name' => 'texto',
                'default' => '',
                'label' => 'Texto',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'multiline' => 'true',
                'placeholder' => '',
                'characters_limit' => '',
            ),
        ),
        'code' => array(
            'output_method' => 'php',
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="ta-context sumate mt-3">
            <div class="container-with-header">
                    <div class="">
                            <div class="container line-height-0 px-0 px-md-2">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class=" py-3">
                                    <div class="container">
                                            <div class="section-title">
                                                    <h4><?php echo $attributes[\'titulo-header\']?></h4>
                                            </div>
                                    </div>
                                    <div class="content mt-3">
                                            <div class="container">
                                                    <div class="title">
                                                            <h3><?php echo $attributes[\'titulo\']?></h3>
                                                    </div>
                                                    <div class="subtitle">
                                                            <p><?php echo $attributes[\'sub-titulo\']?></p>
                                                    </div>
                                                    <div class="ver-mas text-center">
                                                            <button class="d-md-none" type="button" data-toggle="collapse" data-target="#ntroCompromiso"
                                                                    aria-expanded="false" aria-controls="ntroCompromiso" id="verMasDropdown">
                                                                    ver más <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/gray-arrow.svg" alt="">
                                                            </button>
                                                            <div class="ntro-compromiso dropdown collapse mt-3 mt-md-5 show" id="ntroCompromiso">
                                                                    <p>
                                                                        <?php echo $attributes[\'texto\']?>
                                                                    </p>
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
    
    lazyblocks()->add_block( array(
        'id' => 10460,
        'title' => 'Sumate - Bloque 1',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/sumate',
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
            'control_f1fbd64ab1' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => 'Sumate al nuevo Tiempo Argentino',
                'label' => 'Titulo',
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
            'control_05eba346f0' => array(
                'type' => 'text',
                'name' => 'socio-titulo',
                'default' => 'Hacete Socio',
                'label' => 'Socio titulo',
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
            'control_e3e8e047a1' => array(
                'type' => 'image',
                'name' => 'socio-imagen',
                'default' => '',
                'label' => 'Socio Imagen',
                'help' => '',
                'child_of' => '',
                'placement' => 'content',
                'width' => '100',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'preview_size' => 'full',
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_e5491e48a8' => array(
                'type' => 'text',
                'name' => 'socio-texto-principal',
                'default' => 'Puedes decidir con qué monto colaborar',
                'label' => 'Socio Texto Principal',
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
            'control_f63bab49d1' => array(
                'type' => 'text',
                'name' => 'socio-boton-texto',
                'default' => 'asociarme',
                'label' => 'Socio Botón Texto',
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
            'control_f1faa54a1f' => array(
                'type' => 'url',
                'name' => 'socio-link-boton',
                'default' => '',
                'label' => 'Socio Link boton',
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
            'control_7369914089' => array(
                'type' => 'text',
                'name' => 'socio-item-1',
                'default' => 'Diario Domingo Digital',
                'label' => 'Socio Item 1',
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
            'control_60984a4bad' => array(
                'type' => 'text',
                'name' => 'socio-item-2',
                'default' => 'Beneficios /descuento',
                'label' => 'Socio Item 2',
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
            'control_0a78394423' => array(
                'type' => 'text',
                'name' => 'socio-item-3',
                'default' => 'Comentarios e interacciones directas con los periodistas',
                'label' => 'Socio Item 3',
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
            'control_237a7445cf' => array(
                'type' => 'text',
                'name' => 'cancelar-texto',
                'default' => 'Podés cancelar el pago cuando quieras.',
                'label' => 'Cancelar Texto',
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
            'control_db4bf7437c' => array(
                'type' => 'text',
                'name' => 'apoyanos-titulo',
                'default' => 'Apoyanos con una donación',
                'label' => 'Apoyanos Titulo',
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
            'control_9ce9454f3f' => array(
                'type' => 'image',
                'name' => 'apoyanos-imagen',
                'default' => '',
                'label' => 'Apoyanos Imagen',
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
            'control_c0eb1948be' => array(
                'type' => 'text',
                'name' => 'apoyanos-texto-principal',
                'default' => 'Puedes decidir con qué monto colaborar',
                'label' => 'Apoyanos texto principal',
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
            'control_1fab2e4951' => array(
                'type' => 'text',
                'name' => 'apoyanos-texto-boton',
                'default' => 'HACER DONACIÓN',
                'label' => 'Apoyanos texto boton',
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
            'control_b75bf74442' => array(
                'type' => 'url',
                'name' => 'apoyanos-link-boton',
                'default' => '',
                'label' => 'Apoyanos Link boton',
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
            'control_682b9149e4' => array(
                'type' => 'text',
                'name' => 'apoyanos-item-1',
                'default' => 'Diario Domingo Digital',
                'label' => 'Apoyanos Item 1',
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
            'control_1568374590' => array(
                'type' => 'text',
                'name' => 'apoyanos-item-2',
                'default' => 'Beneficios /descuento',
                'label' => 'Apoyanos Item 2',
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
            'control_2029d647cc' => array(
                'type' => 'text',
                'name' => 'apoyanos-item-3',
                'default' => 'Comentarios e interacciones directas con los periodistas',
                'label' => 'Apoyanos Item 3',
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
            'control_a08ba8407a' => array(
                'type' => 'text',
                'name' => 'texto-pie',
                'default' => 'Si tenés dudas llamanos al 47195655 o envianos un mail a',
                'label' => 'Texto Pie',
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
            'control_869a934243' => array(
                'type' => 'text',
                'name' => 'email-bloque',
                'default' => 'suscripciones@tiempoargentino.com.ar',
                'label' => 'Email Bloque',
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
            'frontend_html' => '<div class="ta-context sumate mt-3">
            <div class="container">
                    <div class="title">
                            <h3><?php echo $attributes[\'titulo\']?></h3>
                    </div>
                    <div class="sumate-opts d-block d-md-flex justify-content-center">
                            <div class="opt socio mt-4 mx-md-4">
                                    <div class="opt-border h-100">
                                            <div class="container py-md-3">
                                                    <div class="title mt-3">
                                                            <h4><?php echo $attributes[\'socio-titulo\']?></h4>
                                                    </div>
                                                    <div class="img-container d-flex align-items-center justify-content-center mt-3 text-center">
                                                            <img src="<?php echo $attributes[\'socio-imagen\'][\'url\']?>" alt="">
                                                    </div>
                                                    <div class="subtitle mt-3">
                                                            <p><?php echo $attributes[\'socio-texto-principal\']?></p>
                                                    </div>
                                                    <div class="btns-container text-center">
                                                            <button>
                                                                <a href="<?php echo $attributes[\'socio-link-boton\']?>">
                                                                <?php echo $attributes[\'socio-boton-texto\']?>
                                                                </a>
                                                            </button>
                                                    </div>
                                                    <div class="opt-details mt-3">
                                                            <button class="w-100" type="button" data-toggle="collapse" data-target="#benefitsSumate"
                                                                    aria-expanded="false" aria-controls="benefitsSumate">
                                                                    <div class="d-flex justify-content-center">
                                                                            <div class="dropdown-icon mr-2">
                                                                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/arrow.svg" alt="" />
                                                                            </div>
                                                                            <div>
                                                                                    <p>¿Qué trae este paquete?</p>
                                                                            </div>
                                                                    </div>
                                                            </button>
                                                            <div class="collapse" id="benefitsSumate">
                                                                    <div class="card-body">
                                                                            <div class="d-flex align-items-center mt-2">
                                                                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/marker-vermas.svg" alt="">
                                                                                    <h6><?php echo $attributes[\'socio-item-1\']?></h6>
                                                                            </div>
                                                                            <div class="d-flex align-items-center mt-2">
                                                                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/marker-vermas.svg" alt="">
                                                                                    <h6><?php echo $attributes[\'socio-item-2\']?></h6>
                                                                            </div>
                                                                            <div class="d-flex align-items-center mt-2">
                                                                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/marker-vermas.svg" alt="">
                                                                                    <h6><?php echo $attributes[\'socio-item-3\']?></h6>
                                                                            </div>
    
                                                                    </div>
                                                            </div>
                                                    </div>
                                                    <div class="info my-2">
                                                            <small><?php echo $attributes[\'cancelar-texto\']?></small>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                            <div class="opt donacion mt-4 mx-md-4">
                                    <div class="opt-border h-100">
                                            <div class="container py-md-3">
                                                    <div class="title mt-3">
                                                            <h4><?php echo $attributes[\'apoyanos-titulo\']?></h4>
                                                    </div>
                                                    <div class="img-container d-flex align-items-center justify-content-center mt-3 text-center">
                                                            <img src="<?php echo $attributes[\'apoyanos-imagen\'][\'url\']?>" alt="">
                                                    </div>
                                                    <div class="subtitle mt-3">
                                                            <p><?php echo $attributes[\'apoyanos-texto-principal\']?></p>
                                                    </div>
                                                    <div class="btns-container text-center">
                                                            <button>
                                                                <a href="<?php echo $attributes[\'apoyanos-link-boton\']?>">
                                                                <?php echo $attributes[\'apoyanos-texto-boton\']?>
                                                                </a>
                                                                </button>
                                                    </div>
                                                    <div class="opt-details mt-3">
                                                            <button class="w-100" type="button" data-toggle="collapse" data-target="#benefitsDonation"
                                                                    aria-expanded="false" aria-controls="benefitsDonation">
                                                                    <div class="d-flex justify-content-center">
                                                                            <div class="dropdown-icon mr-2">
                                                                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/arrow.svg" alt="" />
                                                                            </div>
                                                                            <div>
                                                                                    <p>¿Qué trae este paquete?</p>
                                                                            </div>
                                                                    </div>
                                                            </button>
                                                            <div class="collapse" id="benefitsDonation">
                                                                    <div class="card-body">
                                                                            <div class="d-flex align-items-center mt-2">
                                                                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/marker-vermas.svg" alt="">
                                                                                    <h6><?php echo $attributes[\'apoyanos-item-1\']?></h6>
                                                                            </div>
                                                                            <div class="d-flex align-items-center mt-2">
                                                                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/marker-vermas.svg" alt="">
                                                                                    <h6><?php echo $attributes[\'apoyanos-item-2\']?></h6>
                                                                            </div>
                                                                            <div class="d-flex align-items-center mt-2">
                                                                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/marker-vermas.svg" alt="">
                                                                                    <h6><?php echo $attributes[\'apoyanos-item-3\']?></h6>
                                                                            </div>
    
                                                                    </div>
                                                            </div>
                                                    </div>
                                                    <div class="info my-2">
                                                            <small><?php echo $attributes[\'cancelar-texto\']?></small>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    </div>
                    <div class="info text-center mt-3 mt-md-4">
                            <p><?php echo $attributes[\'texto-pie\']?> <a
                                            href="mailto:<?php echo $attributes[\'email-bloque\']?>"><?php echo $attributes[\'email-bloque\']?></a></p>
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