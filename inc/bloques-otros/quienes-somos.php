<?php

if ( function_exists( 'lazyblocks' ) ) :

    lazyblocks()->add_block( array(
        'id' => 10452,
        'title' => 'QS - Apoyanos - Socios',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 1.07V9h7c0-4.08-3.05-7.44-7-7.93zM4 15c0 4.42 3.58 8 8 8s8-3.58 8-8v-4H4v4zm7-13.93C7.05 1.56 4 4.92 4 9h7V1.07z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/qs-apoyanos-socios',
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
            'control_0bcbc7417c' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => 'Sumate al nuevo Tiempo Argentino ¡Sumate a la autogestión!',
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
            'control_bbd8b440f3' => array(
                'type' => 'text',
                'name' => 'titulo-socio',
                'default' => 'Hacete Socio',
                'label' => 'Titulo Socio',
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
            'control_1dd82846a7' => array(
                'type' => 'text',
                'name' => 'link-socio-titutlo',
                'default' => '',
                'label' => 'Link Socio Titulo',
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
            'control_7bea1a4cba' => array(
                'type' => 'url',
                'name' => 'link-socio',
                'default' => '',
                'label' => 'Link Socio',
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
            'control_b26b694e75' => array(
                'type' => 'text',
                'name' => 'titulo-apoyanos',
                'default' => 'Hacete Socio',
                'label' => 'Titulo Apoyanos',
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
            'control_8798bb43e1' => array(
                'type' => 'text',
                'name' => 'link-apoyanos-titulo',
                'default' => '',
                'label' => 'Link Apoyanos Titulo',
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
            'control_c1a9fc4294' => array(
                'type' => 'url',
                'name' => 'link-apoyanos',
                'default' => '',
                'label' => 'Link Apoyanos',
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
            'control_1518014cc0' => array(
                'type' => 'text',
                'name' => 'texto-1-footer',
                'default' => 'Si tenés dudas llamanos al 47195655 o envianos un mail a',
                'label' => 'Texto Footer',
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
            'control_e14b3c44c4' => array(
                'type' => 'email',
                'name' => 'email-footer',
                'default' => 'suscripciones@tiempoargentino.com.ar',
                'label' => 'Email Footer',
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
                            <div class="line-height-0 text-center">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class="py-3">
                                    <div class="container">
                                            <div class="title">
                                                    <h3><?php echo $attributes[\'titulo\']?></h3>
                                            </div>
                                            <div class="sumate-opts d-block d-md-flex justify-content-center">
                                                    <div class="opt socio mt-4 mx-md-4">
                                                            <div class="opt-bg">
                                                                    <div class="container py-3 py-md-4">
                                                                            <div class="title">
                                                                                    <h4><?php echo $attributes[\'titulo-socio\']?></h4>
                                                                            </div>
                                                                            <div class="btns-container text-center">
                                                                                    <button><a href="<?php echo $attributes[\'link-socio\']?>">
                                                                                        <?php echo $attributes[\'link-socio-titutlo\']?>
                                                                                    </a></button>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                                    <div class="opt donacion mt-4 mx-md-4">
                                                            <div class="opt-bg">
                                                                    <div class="container py-3 py-md-4">
                                                                            <div class="title">
                                                                                    <h4><?php echo $attributes[\'titulo-apoyanos\']?></h4>
                                                                            </div>
                                                                            <div class="btns-container text-center">
                                                                                    <button>
                                                                                        <a href="<?php echo $attributes[\'link-apoyanos\']?>"><?php echo $attributes[\'link-apoyanos-titulo\']?></a>
                                                                                        </button>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    </div>
                    <div class="container">
                            <div class="info text-center mt-3 mt-md-4">
                                    <p><?php echo $attributes[\'texto-1-footer\']?>
                                    <a href="mailto:<?php echo $attributes[\'email-footer\']?>">
                                        <?php echo $attributes[\'email-footer\']?>
                                        </a>
                                 </p>
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
        'id' => 10424,
        'title' => 'Cooperativa',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 7h-6v13h-2v-6h-2v6H9V9H3V7h18v2z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/cooperativa',
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
        ),
        'code' => array(
            'output_method' => 'php',
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="ta-context user-tabs gray-border mt-2 my-lg-5">
            <div class="user-block-container">
                    <?php if (function_exists(\'cooperativa\')) : ?>
                            <div class="user-tabs">
    
                                    <ul class="nav nav-tabs justify-content-between justify-content-md-start" id="tab">
                                            <?php foreach (cooperativa()->parent_terms() as $p) : ?>
                                                    <li class="nav-item position-relative">
                                                            <a class="nav-link tab-cooperativa d-flex flex-row-reverse <?php echo $p->slug == \'todos\' ? \'active\' : \'\' ?>" id="<?php echo $p->slug ?>-tab" data-toggle="tab" href="#<?php echo $p->slug ?>">
                                                                    <div></div>
                                                                    <p><?php echo $p->name ?></p>
                                                            </a>
                                                    </li>
                                            <?php endforeach ?>
                                    </ul>
                                    <!-- contenido -->
                                    <div class="tab-content">
                                            <?php foreach (cooperativa()->parent_terms() as $p) : ?>
                                                    <div class="tab-pane my-md-4 <?php echo $p->slug == \'todos\' ? \'active\' : \'\' ?>" id="<?php echo $p->slug ?>">
                                                            <?php
                                                            $childs = cooperativa()->child_terms($p->term_id);
    
                                                            if (sizeof($childs) > 0):
                                                            ?>
                                                                    <div class="categories-filter mt-3">
                                                                            <div class="container">
                                                                                    <select class="form-select select-categorias" aria-label="Filtro Categorías">
                                                                                            <option value="">Seleccionar categoría</option>
                                                                                            <?php foreach($childs as $child):?>
                                                                                                    <option value="<?php echo $child->{\'slug\'}?>"><?php echo $child->{\'name\'}?></option>
                                                                                            <?php endforeach?>
                                                                                    </select>
                                                                            </div>
                                                                    </div>
                                                                    <div class="container-with-header">
                                                                            <div class="text-left">
                                                                                    <div class="separator mt-2"></div>
                                                                            </div>
                                                                            <div class="container mt-2">
                                                                                    <div class="section-title text-left">
                                                                                            <h4 class="categorias-titulo"></h4>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="content mt-3">
                                                                            <?php endif; ?>
                                                                            <!-- memberrs -->
                                                                            <div class="d-flex flex-column flex-md-row flex-wrap">
                                                                                    <?php foreach (cooperativa()->get_coop($p->slug) as $member) : ?>
                                                                                            <?php 
                                                                                                    $terms_post = get_the_terms($member->{\'ID\'},\'sector\'); 
                                                                                                    $classes = join(\' \',wp_list_pluck($terms_post,\'slug\'));
                                                                                            ?>
                                                                                            <div class="member d-flex flex-md-column align-items-center m-2 <?php echo $classes?>">
                                                                                                    <div class="profile-img mr-2">
                                                                                                            <div class="img-container">
                                                                                                                    <div class="img-wrapper" style="background-image:url(\'<?php echo get_the_post_thumbnail_url($member->{\'ID\'})?>\') !important"></div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <div class="content text-left text-md-center mt-3">
                                                                                                            <div class="name">
                                                                                                                    <p><?php echo $member->{\'post_title\'} ?></p>
                                                                                                            </div>
                                                                                                            <?php echo $member->{\'post_content\'} ?>
                                                                                                    </div>
                                                                                            </div>
    
                                                                                    <?php endforeach; ?>
                                                                            </div>
                                                                            <!-- members -->
                                                                            <?php if (sizeof($childs) > 0): ?>
                                                                            </div>
                                                                    </div>
                                                            <?php endif; ?>
                                                    </div>
                                            <?php endforeach ?>
                                    </div>
    
                            </div>
                    <?php endif; ?>
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
        'id' => 10416,
        'title' => 'QS - Nosotros',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 1.07V9h7c0-4.08-3.05-7.44-7-7.93zM4 15c0 4.42 3.58 8 8 8s8-3.58 8-8v-4H4v4zm7-13.93C7.05 1.56 4 4.92 4 9h7V1.07z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/qs-contenedor-con-titulo',
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
            'control_7e296d4360' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => '',
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
            'control_306aa9471c' => array(
                'type' => 'text',
                'name' => 'subtitulo',
                'default' => '',
                'label' => 'Subtitulo',
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
            'control_13581d47c5' => array(
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
            'control_443a694d3b' => array(
                'type' => 'inner_blocks',
                'name' => 'cooperativa',
                'default' => '',
                'label' => 'Cooperativa',
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
            'frontend_html' => '<div class="ta-context quienes-somos mt-3">
            <div class="container-with-header">
                    <div class="">
                            <div class="container line-height-0 px-0 px-md-2">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class="py-3">
                                    <div class="container">
                                            <a class="scrollTo" id="nosotrosFocus"></a>
                                            <div class="section-title">
                                                    <h4><?php echo $attributes[\'titulo\']?></h4>
                                            </div>
    
                                    </div>
                                    <div class="content mt-3">
                                            <div class="container">
                                                    <div class="subtitle">
                                                            <p><?php echo $attributes[\'subtitulo\']?></p>
                                                    </div>
    
                                                    <div class="ver-mas text-center">
                                                            <button class="d-md-none" type="button" data-toggle="collapse" data-target="#nosotros"
                                                                    aria-expanded="false" aria-controls="nosotros" id="verMasDropdown">
                                                                    ver más <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/gray-arrow.svg" alt="">
                                                            </button>
                                                            <div class="nosotros-quienes-somos dropdown mt-3" id="nosotros">
                                                                    <div class="img-container">
                                                                            <img src="<?php echo $attributes[\'imagen\'][\'url\']?>" class="img-fluid" alt="">
                                                                    </div>
                                                                    <div class="coop-grid">
                                                                            <?php echo $attributes[\'cooperativa\']?>
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
        'id' => 10410,
        'title' => 'QS - Texto Grande',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 1.07V9h7c0-4.08-3.05-7.44-7-7.93zM4 15c0 4.42 3.58 8 8 8s8-3.58 8-8v-4H4v4zm7-13.93C7.05 1.56 4 4.92 4 9h7V1.07z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/qs-texto-grande',
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
            'control_575a7146ef' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => '',
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
            'control_0a18cf4123' => array(
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
                'multiline' => 'false',
                'placeholder' => '',
                'characters_limit' => '',
            ),
        ),
        'code' => array(
            'output_method' => 'php',
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="ta-context sumate">
            <div class="context-bg">
                    <div class="container py-3">
                            <div class="ta-border-block">
                                    <div class="mx-md-4">
                                            <div class="opt-border">
                                                    <div class="container py-md-3">
                                                            <div class="title mt-3">
                                                                    <h3><?php echo $attributes[\'titulo\']?></h3>
                                                            </div>
                                                            <div class="subtitle">
                                                                <p><?php echo $attributes[\'texto\']?></p>
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
        'id' => 10400,
        'title' => 'QS - S - Ejes',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 1.07V9h7c0-4.08-3.05-7.44-7-7.93zM4 15c0 4.42 3.58 8 8 8s8-3.58 8-8v-4H4v4zm7-13.93C7.05 1.56 4 4.92 4 9h7V1.07z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/qs-s-ejes',
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
            'control_db9b724978' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => '¿Cuáles son los ejes del Nuevo Tiempo Argentino?',
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
            'control_03289f4f8f' => array(
                'type' => 'image',
                'name' => 'imagen-bloque-1',
                'default' => '',
                'label' => 'Imagen Bloque 1',
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
            'control_9ff8fd420d' => array(
                'type' => 'text',
                'name' => 'titulo-bloque-1',
                'default' => '',
                'label' => 'Titulo Bloque 1',
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
            'control_8a4b5947dc' => array(
                'type' => 'textarea',
                'name' => 'texto-bloque-1',
                'default' => '',
                'label' => 'Texto Bloque 1',
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
            'control_9f19f74484' => array(
                'type' => 'image',
                'name' => 'imagen-bloque-2',
                'default' => '',
                'label' => 'Imagen Bloque 2',
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
            'control_aa89534020' => array(
                'type' => 'text',
                'name' => 'titulo-bloque-2',
                'default' => '',
                'label' => 'Titulo Bloque 2',
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
            'control_8dea384e05' => array(
                'type' => 'textarea',
                'name' => 'texto-bloque-2',
                'default' => '',
                'label' => 'Texto Bloque 2',
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
            'control_4ccab84742' => array(
                'type' => 'image',
                'name' => 'imagen-bloque-3',
                'default' => '',
                'label' => 'Imagen Bloque 3',
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
            'control_88fa4a4129' => array(
                'type' => 'text',
                'name' => 'titulo-bloque-3',
                'default' => '',
                'label' => 'Titulo Bloque 3',
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
            'control_aed9d74234' => array(
                'type' => 'textarea',
                'name' => 'texto-bloque-3',
                'default' => '',
                'label' => 'Texto Bloque 3',
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
            'control_bcab234a83' => array(
                'type' => 'image',
                'name' => 'imagen-bloque-4',
                'default' => '',
                'label' => 'Imagen Bloque 4',
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
            'control_296b354777' => array(
                'type' => 'text',
                'name' => 'titulo-bloque-4',
                'default' => '',
                'label' => 'Titulo Bloque 4',
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
            'control_95a9f04c4f' => array(
                'type' => 'textarea',
                'name' => 'texto-bloque-4',
                'default' => '',
                'label' => 'Texto Bloque 4',
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
                            <div class="container line-height-0 text-center">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class="py-3">
                                    <div class="content mt-3">
                                            <div class="container">
                                                    <div class="subtitle">
                                                            <p><?php echo $attributes[\'titulo\']?></p>
                                                    </div>
                                                    <div class="ver-mas text-center">
                                                            <button class="d-md-none" type="button" data-toggle="collapse" data-target="#ejesSumate"
                                                                    aria-expanded="false" aria-controls="ejesSumate" id="verMasDropdown">
                                                                    ver más <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/gray-arrow.svg" alt="">
                                                            </button>
                                                            <div class="ejes-sumate dropdown d-lg-flex flex-lg-row justify-content-center collapse mt-3"
                                                                    id="ejesSumate">
                                                                    <div class="eje mt-4 mx-md-4">
                                                                            <div class="img-container">
                                                                                    <img src="<?php echo $attributes[\'imagen-bloque-1\'][\'url\']?>" alt="">
                                                                            </div>
                                                                            <div class="title mt-3">
                                                                                    <h3><?php echo $attributes[\'titulo-bloque-1\']?></h3>
                                                                            </div>
                                                                            <div class="subtitle">
                                                                                    <p><?php echo $attributes[\'texto-bloque-1\']?></p>
                                                                            </div>
                                                                    </div>
                                                                    <div class="eje mt-4 mx-md-4">
                                                                            <div class="img-container">
                                                                                    <img src="<?php echo $attributes[\'imagen-bloque-2\'][\'url\']?>" alt="">
                                                                            </div>
                                                                            <div class="title mt-3">
                                                                                    <h3><?php echo $attributes[\'titulo-bloque-2\']?></h3>
                                                                            </div>
                                                                            <div class="subtitle">
                                                                                    <p><?php echo $attributes[\'texto-bloque-2\']?></p>
                                                                            </div>
                                                                    </div>
                                                                    <div class="eje mt-4 mx-md-4">
                                                                            <a href="#nosotrosFocus">
                                                                                    <div class="img-container">
                                                                                            <img src="<?php echo $attributes[\'imagen-bloque-3\'][\'url\']?>" alt="">
                                                                                    </div>
                                                                                    <div class="title mt-3">
                                                                                            <h3><?php echo $attributes[\'titulo-bloque-3\']?></h3>
                                                                                    </div>
                                                                                    <div class="subtitle">
                                                                                            <p><?php echo $attributes[\'texto-bloque-3\']?></p>
                                                                                    </div>
                                                                            </a>
                                                                    </div>
                                                                    <div class="eje mt-4 mx-md-4">
                                                                            <div class="img-container">
                                                                                    <img src="<?php echo $attributes[\'imagen-bloque-4\'][\'url\']?>" alt="">
                                                                            </div>
                                                                            <div class="title mt-3">
                                                                                    <h3><?php echo $attributes[\'titulo-bloque-4\']?></h3>
                                                                            </div>
                                                                            <div class="subtitle">
                                                                                    <p><?php echo $attributes[\'texto-bloque-4\']?>
                                                                                    </p>
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
        'id' => 10377,
        'title' => 'QS - Contenedor Articulos',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 1.07V9h7c0-4.08-3.05-7.44-7-7.93zM4 15c0 4.42 3.58 8 8 8s8-3.58 8-8v-4H4v4zm7-13.93C7.05 1.56 4 4.92 4 9h7V1.07z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/qs-contenedor-titulo',
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
            'control_6db9ce4be4' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => 'NUESTRO COMPROMISO',
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
            'control_ff6a1549d6' => array(
                'type' => 'text',
                'name' => 'subtitulo',
                'default' => 'Investigaciones de Tiempo Argentino',
                'label' => 'Subtitulo',
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
            'control_47195647fd' => array(
                'type' => 'textarea',
                'name' => 'texto',
                'default' => '',
                'label' => 'Texto Principal',
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
            'control_7fb9124f42' => array(
                'type' => 'image',
                'name' => 'titulo-imagen-1',
                'default' => '',
                'label' => 'Titulo Imagen 1',
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
            'control_e1a8024362' => array(
                'type' => 'image',
                'name' => 'articulo-imagen-1',
                'default' => '',
                'label' => 'Articulo Imagen 1',
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
            'control_8dd8504eea' => array(
                'type' => 'text',
                'name' => 'titulo-articulo-1',
                'default' => '',
                'label' => 'Titulo Articulo 1',
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
            'control_e56a7e476d' => array(
                'type' => 'url',
                'name' => 'link-articulo-1',
                'default' => '',
                'label' => 'Link Articulo 1',
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
            'control_945ac8490f' => array(
                'type' => 'text',
                'name' => 'autor-articulo-1',
                'default' => '',
                'label' => 'Autor Articulo 1',
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
            'control_1279324503' => array(
                'type' => 'image',
                'name' => 'titulo-imagen-2',
                'default' => '',
                'label' => 'Titulo Imagen 2',
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
            'control_ae3a75436b' => array(
                'type' => 'image',
                'name' => 'articulo-imagen-2',
                'default' => '',
                'label' => 'Articulo Imagen 2',
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
            'control_d8dac64566' => array(
                'type' => 'text',
                'name' => 'titulo-articulo-2',
                'default' => '',
                'label' => 'Titulo Articulo 2',
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
            'control_8f49da4501' => array(
                'type' => 'url',
                'name' => 'link-articulo-2',
                'default' => '',
                'label' => 'Link Articulo 2',
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
            'control_3239214124' => array(
                'type' => 'text',
                'name' => 'autor-articulo-2',
                'default' => '',
                'label' => 'Autor Articulo 2',
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
            'control_b45be94efa' => array(
                'type' => 'image',
                'name' => 'titulo-imagen-3',
                'default' => '',
                'label' => 'Titulo Imagen 3',
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
            'control_aeca2843ee' => array(
                'type' => 'image',
                'name' => 'articulo-imagen-3',
                'default' => '',
                'label' => 'Articulo Imagen 3',
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
            'control_2c387a4226' => array(
                'type' => 'text',
                'name' => 'titulo-articulo-3',
                'default' => '',
                'label' => 'Titulo Articulo 3',
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
            'control_bd690f4bd5' => array(
                'type' => 'url',
                'name' => 'link-articulo-3',
                'default' => '',
                'label' => 'Link Articulo 3',
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
            'control_c4ba764a78' => array(
                'type' => 'text',
                'name' => 'autor-articulo-3',
                'default' => '',
                'label' => 'Autor Articulo 3',
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
            'frontend_html' => '<div class="ta-context quienes-somos mt-3">
            <div class="container-with-header">
                    <div class="">
                            <div class="container line-height-0 px-0 px-md-2">
                                    <div class="separator m-0"></div>
                            </div>
                            <div class=" py-3">
                                    <div class="container">
                                            <div class="section-title">
                                                    <h4><?php echo $attributes[\'titulo\']?></h4>
                                            </div>
                                    </div>
                                    <div class="content mt-3">
                                            <!-- CONTENIDO -->
                                            <div class="container">
                                                    <div class="subtitle">
                                                            <p><?php echo $attributes[\'subtitulo\']?></p>
                                                    </div>
                                                    <div class="ver-mas text-center">
                                                            <button class="d-md-none" type="button" data-toggle="collapse"
                                                                    data-target="#ntroCompromisoQuienesSomos" aria-expanded="false"
                                                                    aria-controls="ntroCompromisoQuienesSomos" id="verMasDropdown">
                                                                    ver más <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/gray-arrow.svg" alt="">
                                                            </button>
                                                            <div class="ntro-compromiso dropdown collapse mt-3 mt-md-5 show" id="ntroCompromisoQuienesSomos">
                                                                <?php echo $attributes[\'texto\']?>
    
                                                                    <div class="ta-article-block d-md-flex">
                                                                            <div class="article-preview ambiental text-left d-flex flex-column mb-3 mx-md-3">
                                                                                    <div class="">
                                                                                            <div class="section-flag">
                                                                                                    <img src="<?php echo $attributes[\'titulo-imagen-1\'][\'url\']?>" class="img-fluid" alt="">
                                                                                            </div>
                                                                                            <a href="">
                                                                                                    <div class="img-container position-relative">
                                                                                                            <div class="img-wrapper" style="background:url(\'<?php echo $attributes[\'articulo-imagen-1\'][\'url\']?>\') center no-repeat">
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </a>
                                                                                    </div>
                                                                                    <div class="content p-2 mt-md-2">
                                                                                            <div>
                                                                                                    <a href="<?php echo $attributes[\'link-articulo-1\']?>">
                                                                                                            <p><?php echo $attributes[\'titulo-articulo-1\']?></p>
                                                                                                    </a>
                                                                                            </div>
                                                                                            <div class="article-info-container">
                                                                                                    <div class="author">
                                                                                                            <p>Por: <?php echo $attributes[\'autor-articulo-1\']?></p>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="article-preview habitat text-left d-flex flex-column mb-3 mx-md-3">
                                                                                    <div class="">
                                                                                            <div class="section-flag">
                                                                                                    <img src="<?php echo $attributes[\'titulo-imagen-2\'][\'url\']?>" class="img-fluid" alt="">
                                                                                            </div>
                                                                                            <a href="">
                                                                                                    <div class="img-container position-relative">
                                                                                                            <div class="img-wrapper" style="background:url(\'<?php echo $attributes[\'articulo-imagen-2\'][\'url\']?>\') center no-repeat">    </div>
                                                                                                    </div>
                                                                                            </a>
                                                                                    </div>
                                                                                    <div class="content p-2 mt-md-2">
                                                                                            <div>
                                                                                            <a href="<?php echo $attributes[\'link-articulo-2\']?>">
                                                                                                            <p><?php echo $attributes[\'titulo-articulo-2\']?></p>
                                                                                                    </a>
                                                                                            </div>
                                                                                            <div class="article-info-container">
                                                                                                    <div class="author">
                                                                                                    <p>Por: <?php echo $attributes[\'autor-articulo-2\']?></p>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="article-preview medios text-left d-flex flex-column mb-3 mx-md-3">
                                                                                    <div class="">
                                                                                            <div class="section-flag">
                                                                                                    <img src="<?php echo $attributes[\'titulo-imagen-3\'][\'url\']?>" class="img-fluid" alt="">
                                                                                            </div>
                                                                                            <a href="">
                                                                                                    <div class="img-container position-relative">
                                                                                                            <div class="img-wrapper" style="background:url(\'<?php echo $attributes[\'articulo-imagen-3\'][\'url\']?>\') center no-repeat">
    
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </a>
                                                                                    </div>
                                                                                    <div class="content p-2 mt-md-2">
                                                                                            <div>
                                                                                            <a href="<?php echo $attributes[\'link-articulo-3\']?>">
                                                                                                            <p><?php echo $attributes[\'titulo-articulo-3\']?></p>
                                                                                                    </a>
                                                                                            </div>
                                                                                            <div class="article-info-container">
                                                                                                    <div class="author">
                                                                                                    <p>Por: <?php echo $attributes[\'autor-articulo-3\']?></p>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                            <!-- CONTENIDO -->
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
        'id' => 10365,
        'title' => 'QS - Historia',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 1.07V9h7c0-4.08-3.05-7.44-7-7.93zM4 15c0 4.42 3.58 8 8 8s8-3.58 8-8v-4H4v4zm7-13.93C7.05 1.56 4 4.92 4 9h7V1.07z" /></svg>',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/historia-qs-bloque',
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
            'control_959ad94c89' => array(
                'type' => 'text',
                'name' => 'pre-titulo',
                'default' => 'Conocé más sobre Tiempo Argentino',
                'label' => 'Pre titulo',
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
            'control_4989664fe6' => array(
                'type' => 'text',
                'name' => 'titulo',
                'default' => 'Nuestra Historia',
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
            'control_464b5f4470' => array(
                'type' => 'textarea',
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
                'placeholder' => '',
                'characters_limit' => '',
            ),
            'control_2358b14d76' => array(
                'type' => 'inner_blocks',
                'name' => 'video-imagen',
                'default' => '',
                'label' => 'Video / Imagen',
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
            'frontend_html' => '<div class="ta-context quienes-somos mt-3">
            <div class="container-with-header">
                    <div class="">
                            <div class=" py-3">
                                    <div class="content mt-3">
                                            <div class="container">
                                                    <div class="subtitle">
                                                            <p><?php echo $attributes[\'pre-titulo\']; ?></p>
                                                    </div>
                                                    <div class="title">
                                                            <h3><?php echo $attributes[\'titulo\']; ?></h3>
                                                    </div>
                                                    <div class="ntra-historia text-center dropdown mt-3 mt-md-5" id="ntroCompromiso">
                                                            <?php echo $attributes[\'texto\']; ?>
                                                            <div class="media">
                                                                    <div class="container p-2">
                                                                            <?php echo $attributes[\'video-imagen\']; ?>
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
    
endif;