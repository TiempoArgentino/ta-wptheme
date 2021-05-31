<?php get_header(); do_action( 'personalize_before');?>
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="localization">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('PERSONALIZAR','gen-base-theme')?><span class="ml-2"><?php echo __('LOCALIZACIÓN','gen-base-theme')?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4 class="italic m-0"><?php echo __('Hola','gen-base-theme')?></h4>
                            <h4 class="italic m-0"><?php echo wp_get_current_user()->first_name. ' ' .wp_get_current_user()->last_name?></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="img-container text-center mt-3">
                                <img src="<?php echo get_template_directory_uri()?>/assets/img/localizacion.svg" alt="" class="img-fluid w-75">
                            </div>
                            <div class="subtitle text-center mt-4">
                                <p><?php echo __('Queremos ofrecerte contenido acorde a tu localización. Por ello, indicanos desde dónde nos leés:','gen-base-theme')?>
                                </p>
                            </div>
                            <div class="form-container mt-4 mb-5">
                                <div class="input-container">
                                    <input type="text" placeholder="Buenos Aires_" id="personalize-city" autocomplete="off" class="with-icon" value="<?php echo get_user_meta(wp_get_current_user()->ID,'_personalizer_location',true)?>">
                                    <div class="input-icon">
                                        <img src="<?php echo get_template_directory_uri()?>/assets/img/localization-icon.svg" alt="">
                                    </div>
                                    <div id="autocompletar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="btns-container d-flex justify-content-between mt-3">
            <button class="gray-btn-black-text w-50" id="skip-1"><?php echo __('omitir','gen-base-theme')?></button>
            <button class="w-50" id="next-1" data-user="<?php echo wp_get_current_user()->ID?>"><?php echo __('siguiente','gen-base-theme')?></button>
        </div>
    </div>
</div>
<!-- temas -->
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="categories">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('PERSONALIZAR','gen-base-theme')?><span class="ml-2"><?php echo __('temas','gen-base-theme')?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="asociate-wrapper">
                            <div class="subtitle text-center mt-4">
                                <p><?php echo __('Seleccioná los temas que más te interesan','gen-base-theme')?>
                                </p>
                            </div>
                            <div class="temas d-flex flex-column flex-md-row flex-wrap align-items-center justify-content-left">
                            <?php if(!empty(Posts_Balancer_Personalize::get_topics())):?>

                                <?php foreach(Posts_Balancer_Personalize::get_topics() as $key => $val):?>
                                    <div class="tema col-12 col-md-4 px-1 <?php echo is_array(get_user_meta(wp_get_current_user()->ID,'_personalizer_topics',true)) && in_array($key,get_user_meta(wp_get_current_user()->ID,'_personalizer_topics',true)) ? 'theme-selected' : ''?>" id="<?php echo $val?>">
                                    <label>
                                        <input type="checkbox" name="categorie[]" class="topic categorie" id="<?php echo $key?>" <?php echo is_array(get_user_meta(wp_get_current_user()->ID,'_personalizer_topics',true)) && in_array($key,get_user_meta(wp_get_current_user()->ID,'_personalizer_topics',true)) ? 'checked="checked"' : ''?> value="<?php echo $key?>">
                                        <?php echo $val?>
                                    </label>
                                </div>
                                        <?php endforeach;?>
                                <?php endif;?>
                            </div>
                            <!--<div class="subtitle text-center mt-4 d-none d-md-block">
                                <a href="">
                                    <p><?php //echo __('click aquí para cargar todos','gen-base-theme')?></p>
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="btns-container d-flex justify-content-between mt-3">
            <button class="gray-btn-black-text w-50" id="skip-2"><?php echo __('omitir','gen-base-theme')?></button>
            <button class="w-50" id="next-2" data-user="<?php echo wp_get_current_user()->ID?>"><?php echo __('siguiente','gen-base-theme')?></button>
        </div>
    </div>
</div>
<!-- temas -->
<!-- periodismo -->
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="posts-personalize">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('PERSONALIZAR','gen-base-theme')?><span class="ml-2"><?php echo __('PERIODISMO','gen-base-theme')?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="asociate-wrapper">
                            <div class="subtitle text-center mt-4">
                                <p><?php echo __('Estos son algunos artículos de Tiempo Argentino publicados recientemente.','gen-base-theme')?>
                                </p>
                            </div>
                            <div class="title text-center mt-4">
                                <h4><?php echo __('Eligí los que más te interesen:','gen-base-theme')?>
                                </h4>
                            </div>
                            <div class="periodismo articulos d-flex flex-column flex-md-row flex-wrap align-items-center align-items-md-start justify-content-left my-3">
                                <?php if(!empty(Posts_Balancer_Personalize::get_taxonomies())):?>
                                    <?php foreach(Posts_Balancer_Personalize::get_taxonomies() as $key => $val): ?>
                                        <?php
                                            $args = [
                                                'post_type' => get_option('balancer_editorial_post_type'),
                                                'numberposts' => 1,
                                                'post_status' => 'publish',
                                                'orderby' => 'rand',
                                                'tax_query' => [
                                                    'taxonomy' => get_option('balancer_editorial_taxonomy'),
                                                    'field' => 'term_id',
                                                    'terms' => $key
                                                ]
                                            ];
                                            $query = get_posts($args);
                                            foreach($query as $t):
                                                $authors = get_the_terms($t->{'ID'},get_option('balancer_editorial_autor'));
                                                $post_author = [];
                                                if($authors || $authors != null) {
                                                    foreach($authors as $a){
                                                        $post_author[] = $a->{'term_id'};
                                                    }
                                                }
                                        ?>
                                <div class="articulo col-12 col-md-4 <?php echo is_array(get_user_meta(wp_get_current_user()->ID,'_personalizer_taxonomy',true)) && in_array($key,get_user_meta(wp_get_current_user()->ID,'_personalizer_taxonomy',true)) ? 'art-selected' : ''?>" id="art-<?php echo $key?>">
                                    <label>
                                        <input type="checkbox" name="ost-item[]" <?php echo is_array(get_user_meta(wp_get_current_user()->ID,'_personalizer_taxonomy',true)) && in_array($key,get_user_meta(wp_get_current_user()->ID,'_personalizer_taxonomy',true)) ? 'checked="checked"' : ''?> class="post-item" value="<?php echo $key?>" id="<?php echo $key?>">
                                        <div class="line-height-0">
                                            <div class="separator m-0"></div>
                                        </div>
                                        <div class="articulo-content">
                                            <div class="topic text-uppercase">
                                                <p><?php echo $val;?></p>
                                            </div>
                                            <div class="description mt-2">
                                                <p><?php echo $t->{'post_title'}?></p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <?php
                                    endforeach;
                                endforeach?>
                                <?php endif?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="btns-container d-flex justify-content-between mt-3">
            <button class="gray-btn-black-text w-50" id="skip-3"><?php echo __('omitir','gen-base-theme')?></button>
            <button class="w-50" id="next-3" data-user="<?php echo wp_get_current_user()->ID?>"><?php echo __('siguiente','gen-base-theme')?></button>
        </div>
    </div>

</div>
<!-- periodismo -->
<!-- emociiones -->
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="emotions">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('PERSONALIZAR','gen-base-theme')?><span class="ml-2"><?php echo __('emociones','gen-base-theme')?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mt-3 mt-md-5">
                        <div class="asociate-wrapper">
                            <div class="title text-center mt-4">
                                <h4><?php echo __('¿Cuáles de estas fotos te emocionan?','gen-base-theme')?>
                                </h4>
                            </div>
                            <div class="fotos my-3">
                                <div class="row flex-wrap">
                                <?php if(!empty(Posts_Balancer_Personalize::get_authors())):?>
                                    <?php foreach(Posts_Balancer_Personalize::get_authors() as $key => $val):?>
                                        <?php
                                            $args = [
                                                'post_type' => get_option('balancer_editorial_post_type'),
                                                'numberposts' => 1,
                                                'post_status' => 'publish',
                                                'orderby' => 'rand',
                                                'tax_query' => [
                                                    'taxonomy' => get_option('balancer_editorial_autor'),
                                                    'field' => 'term_id',
                                                    'terms' => $key
                                                ]
                                            ];
                                            $query = get_posts($args);
                                            foreach($query as $t):
                                                $taxos = get_the_terms($t->{'ID'},get_option('balancer_editorial_taxonomy'));
                                                $post_tax = [];
                                                if($taxos || $taxos != null) {
                                                    foreach($taxos as $ta){
                                                        $post_tax[] = $ta->{'term_id'};
                                                    }
                                                }

                                        ?>
                                    <div
                                        class="foto col-6 col-md-3 position-relative d-flex justify-content-center align-items-center mt-3 mt-md-4 ">
                                        <div class="foto-block-container" id="photo-1">
                                            <label>
                                                <div class="img-container">
                                                    <img src="<?php echo get_the_post_thumbnail_url($t->{'ID'}) ? get_the_post_thumbnail_url($t->{'ID'}) : get_stylesheet_directory_uri().'/assets/img/sin-imagen.jpg'?>" alt="<?php echo $val?>"
                                                        class="img-fluid">
                                                </div>
                                                <div class="checkbox-container">
                                                    <input type="checkbox"
                                                    data-taxo="<?php echo json_encode($post_tax) ?>"
                                                    class="photo foto-checkbox position-absolute"
                                                    name="photo-item[]"
                                                    <?php echo is_array(get_user_meta(wp_get_current_user()->ID,'_personalizer_authors',true)) && in_array($key,get_user_meta(wp_get_current_user()->ID,'_personalizer_authors',true)) ? 'checked="checked"' : ''?>
                                                    value="<?php echo $key?>">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endforeach;endforeach?>
                    <?php endif;?>
                                </div>

                            </div>
                           <!-- <div class="subtitle text-center mt-4 d-none d-md-block">
                                <a href="">
                                    <p><?php //echo __('click aquí para cargar todos','gen-base-theme')?></p>
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="btns-container d-flex justify-content-between mt-3">
            <button class="gray-btn-black-text w-50" id="skip-4">omitir</button>
            <button class="w-50" id="next-4" data-user="<?php echo wp_get_current_user()->ID?>">siguiente</button>
        </div>
    </div>

</div>
<!-- emociones -->
<!-- gracias -->
<div class="container ta-context asociate gray-border mt-2 my-lg-5" id="thankyou">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="asociate-block-container">
        <div class="section-title p-2">
            <h4><?php echo __('PERSONALIZAR','gen-base-theme')?><span class="ml-2"><?php echo __('Finalizar','gen-base-theme')?></span></h4>
        </div>
        <div class="container">
            <div class="container-with-header">
                <div class="py-2">
                    <div class="subs-opt mw-md-60 mx-auto mt-3 mt-md-5">
                        <div class="title text-center">
                            <h4 class="italic m-0"><span class="ml-2"><?php echo __('Gracias','gen-base-theme')?> </h4>
                            <h4 class="italic m-0"><?php echo wp_get_current_user()->first_name. ' ' .wp_get_current_user()->last_name?></h4>
                        </div>
                        <div class="asociate-wrapper">
                            <div class="subtitle text-center mt-4">
                                <p><?php echo __('Estamos trabajando para que disfrutes de una experiencia informativa única','gen-base-theme')?>
                                </p>
                            </div>
                            <div class="btns-container text-center mt-4">
                                <button><a href="<?php echo home_url()?>"><?php echo __('ir al sitio','gen-base-theme')?></a></button>
                            </div>
                            <div class="text-center my-5">
                                <p><?php echo __('Podés editar tus preferencias, desde tu perfil de usuario, cuando quieras.','gen-theme-base')?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- gracias -->
<?php do_action( 'personalize_after'); get_footer()?>
