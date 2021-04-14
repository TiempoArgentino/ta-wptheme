<?php get_header() ?>
<?php do_action('beneficios_loop_header') ?>

<!-- banner -->
<div class="mt-3">
    <div class="container-with-header">
        <div class="container">
            <div class="section-title">
                <h4><?php echo __('Beneficios', 'gen-theme-base') ?></h4>
            </div>
        </div>
        <div class="container mt-2 px-0 px-md-3">
            <div class="banner-beneficios">
                <div class="container">
                    <div class="banner-header d-flex align-items-center pt-3">
                        <div class="beneficios-icon mr-2 mr-md-3">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/white-gift.svg" alt="">
                        </div>
                        <div class="title">
                            <h2><?php echo __('Participá de los sorteos semanales', 'gen-theme-base') ?></h2>
                        </div>
                    </div>
                    <div class="subtitle mt-3 mt-md-1">
                        <p><?php echo __('¿Cómo hago para obtener beneficios?', 'gen-theme-base') ?></p>
                    </div>
                    <div class="beneficios-steps">
                        <div class="step d-flex align-items-start">
                            <div class="step-icon d-flex mr-2 mx-md-2">
                                <div class="mr-1"><?php echo __('1', 'gen-theme-base') ?></div>
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/vector-steps.svg" alt="">
                            </div>
                            <div class="content">
                                <p><span><?php echo __('Elegí hasta 3 beneficios.', 'gen-theme-base') ?> </span><?php echo __('El orden en que los elijas se tomará cómo el orden de prioridad.', 'gen-theme-base') ?>
                                </p>
                            </div>
                        </div>
                        <div class="step d-flex align-items-start">
                            <div class="step-icon d-flex mr-2 mx-md-2">
                                <div class="mr-1"><?php echo __('2', 'gen-theme-base') ?></div>
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/vector-steps.svg" alt="">
                            </div>
                            <div class="content">
                                <p><?php echo sprintf(__('Haremos un %s para distribuirlos.', 'gen-theme-base'), '<span>' . __('sorteo', 'gen-theme-base') . '</span>') ?></p>
                            </div>
                        </div>
                        <div class="step d-flex align-items-start">
                            <div class="step-icon d-flex mr-2 mx-md-2">
                                <div class="mr-1"><?php echo __('3', 'gen-theme-base') ?></div>
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/vector-steps.svg" alt="">
                            </div>
                            <div class="content">
                                <p><?php echo sprintf(__('Te enviaremos un %s si fuiste favorecido. Te sugerimos solicitar más de uno para no quedarte sin nada.', 'gen-theme-base'), '<span>' . __('email', 'gen-theme-base') . '</span>') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- banner -->

<!-- buscador -->

<div class="container mt-3">
    <div id="benefitsSearchBar" class="show mb-4" aria-labelledby="benefitsSearchBar" data-parent="#search-btn2">
        <div class="search-bar-container px-3 pt-3 pb-4">
            <div class="close d-flex d-lg-none justify-content-end">
                <div>
                    <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#benefitsSearchBar" aria-expanded="true" aria-controls="benefitsSearchBar">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/close.svg" class="img-fluid" alt="">
                    </button>
                </div>
            </div>
            <div class="input-container d-flex justify-content-center mt-3">
                <div class="search-icon mr-2">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/search-icon-blue.svg" class="img-fluid" alt="">
                </div>
                <div class="input-wrapper flex-fill">
                    <input type="text" placeholder="Busca por ubicación o palabra clave" />
                </div>
                <div class="search d-none d-lg-flex justify-content-center ml-3">
                    <button><?php echo __('BUSCAR', 'gen-theme-base') ?></button>
                </div>
                <div class="close d-none d-lg-flex justify-content-end align-items-center ml-3">
                    <div>
                        <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#benefitsSearchBar" aria-expanded="true" aria-controls="benefitsSearchBar">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/close.svg" class="img-fluid" alt="">
                        </button>
                    </div>
                </div>
            </div>
            <div class="search d-flex d-lg-none justify-content-center mt-4">
                <button><?php echo __('BUSCAR', 'gen-theme-base') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- buscador --->
<!-- filtros -->

<div class="mt-3">
    <div class="container-with-header">
        <div class="container">
            <div class="section-title">
                <h4><?php echo __('FILTRAR POR:', 'gen-theme-base') ?></h4>
            </div>
        </div>
        <div class="container mt-2">
            <div class="container">
                <div class="article-tags d-flex flex-wrap mt-4">
                <div class="tag d-flex justify-content-center my-2">
                        <div class="content p-1">
                            <a href="">
                                <p class="m-0"><?php echo __('Todos','gen-theme-base')?></p>
                            </a>
                        </div>
                        <div class="triangle"></div>
                    </div>
                    <?php foreach (beneficios_front()->show_terms() as $t) :?>
                    <div class="tag d-flex justify-content-center my-2">
                        <div class="content p-1">
                            <a href="<?php echo get_term_link($t->{'term_id'})?>">
                                <p class="m-0"><?php echo $t->{'name'}?></p>
                            </a>
                        </div>
                        <div class="triangle"></div>
                    </div>
                    <?php endforeach?>
   
                    <div class="btns-container d-none d-md-flex align-items-center">
                        <button type="button" data-toggle="collapse" data-target="#seeAllTags" aria-expanded="false" aria-controls="seeAllTags" class="collapsed">ver más<img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/right-arrow.png" alt="" class="img-fluid" /></button>
                    </div>
                   <!--   <div class="all-tags collapse" id="seeAllTags">
                        <div class="d-flex flex-wrap">
                            <div class="tag d-flex justify-content-center my-2">
                                <div class="content p-1">
                                    <a href="">
                                        <p class="m-0">COVID-19</p>
                                    </a>
                                </div>
                                <div class="triangle"></div>
                            </div>
                            <div class="tag d-flex justify-content-center my-2">
                                <div class="content p-1">
                                    <a href="">
                                        <p class="m-0">Medidas Covid Argentina</p>
                                    </a>
                                </div>
                                <div class="triangle"></div>
                            </div>
                            <div class="tag d-flex justify-content-center my-2">
                                <div class="content p-1">
                                    <a href="">
                                        <p class="m-0">Género</p>
                                    </a>
                                </div>
                                <div class="triangle"></div>
                            </div>
                        </div>

                    </div> -->

                    <div class="btns-container d-flex d-md-none align-items-center mt-4">
                        <button type="button" data-toggle="collapse" data-target="#seeAllTags" aria-expanded="false" aria-controls="seeAllTags" class="collapsed">ver más<img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/right-arrow.png" alt="" class="img-fluid" /></button>
                    </div>
                </div>
                <div class="container-md mb-2 p-0 d-none">
                    <div class="separator"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- filtros -->

<!-- beneficios --> 
<div class="mt-3">
    <div class="container">
        <div class="line-height-0">
            <div class="separator"></div>
        </div>
    </div>
    <div class="container-with-header py-3">
        <div class="container">
            <div class="section-title">
                <h4>RESULTADOS POR FILTRO Y/O BÚSQUEDA</h4>
            </div>
        </div>
        <div class="sub-blocks py-3">
            <div class="container">
                <div class="ta-articles-block d-flex flex-column flex-lg-row overflow-hidden justify-content-lg-between">
                <?php
                    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                     $args = [
                        'post_type' => 'beneficios',
                        'posts_per_page' => 12,
                        'paged' => $paged,
                        'meta_query' => [
                            'relation' => 'AND',
                            [
                                'key' => '_active',
                                'value' => '1',
                                'compare' => 'LIKE'
                            ],
                            [
                                'key' => '_finish',
                                'value' => date('Y-m-d'),
                                'compare' => '>=',
                                'type' => 'DATE'
                            ]
                        ]
                    ];
                    $beneficios = new WP_Query( $args );

                ?>
                <?php if($beneficios->have_posts()):?>
                    <?php while($beneficios->have_posts()): $beneficios->the_post();?>
                    <div class="article-preview vertical-article benefits d-flex flex-column mb-3 col-12 col-md-4 px-0 px-md-2">
                        <div class="container p-2">
                            <div class="">
                                <a href="">
                                    <div class="img-container position-relative">
                                        <div class="img-wrapper"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="content mt-2">
                                <div class="title">
                                    <a href="">
                                        <p>“Lo de Néstor” bar cooperativo </p>
                                        <p class="discount">10% de DTO</p>
                                    </a>
                                </div>
                                <div class="options mt-4">
                                    <div class="btns-container d-flex justify-content-between align-items-center">
                                        <div class="request">
                                            <button>Solicitar</button>
                                        </div>
                                        <div class="see-description">
                                            <button type="button" class="collapsed" data-toggle="collapse"
                                                data-target="#benefitDescription" aria-expanded="false"
                                                aria-controls="benefitDescription">
                                                ver más <img src="/assets/images/right-arrow.png" alt=""
                                                    class="img-fluid" />
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="benefit-description collapse mt-4" id="benefitDescription">
                                    <div class="benefit-description-header d-flex align-items-end">
                                        <div class="benefit-icon mr-2">
                                            <img src="/assets/images/tiempo-gift.svg" alt="">
                                        </div>
                                        <div>
                                            <div class="title">
                                                <p>Beneficios tiempo</p>
                                            </div>
                                            <div class="category">
                                                <p>Gastronomía y delivery</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="description mt-3">
                                        <p>Lo de Néstor bar cooperativo, <span>ofrece descuentos del 10% en sus
                                                productos que se pueden retirar por el lugar o envíos a
                                                domicilio.</span> Esta semana: plato de cordero. Lo de Néstor se
                                            ubica
                                            en Bolívar 548, San Telmo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile;?>
                    <div class="col-12 pagination">
                       <button type="button" class="btn btn-block btn-text"><?php next_posts_link( __( 'ver más', 'beneficios' ), $beneficios->max_num_pages ); ?></button>         
                    </div>
                    
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- beneficios -->

<?php do_action('beneficios_loop_footer') ?>
<?php get_footer() ?>