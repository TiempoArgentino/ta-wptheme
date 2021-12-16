<?php do_action('before_newletter_page') ?>

<div class="tab-pane" id="news">
<?php if(mailtrain_api_user()->user_lists()) :?>
<div class="news-list mt-4 mb-3">
    <div class="container">
        <div class="title text-center">
            <h4><?php echo __('Recibes actualizaciones de estos temas:','gen-base-theme')?></h4>
        </div>
        <div class="news-themes-dropdowns">
        <?php do_action('newletter_extra_content') ?>
            <?php  foreach(mailtrain_api_user()->user_lists() as $key => $lists): ?>
            <div class="theme-dropdown py-3">
                <button class="dropdown-btn collapsed" type="button" data-toggle="collapse"
                    data-target="#themeDropdown-<?php echo $lists?>" aria-expanded="false" aria-controls="themeDropdown-<?php echo $lists?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="news-icon">
                            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/black-send.svg" alt="" />
                        </div>
                        <div class="title">
                            <p><?php echo get_the_title($lists)?></p>
                        </div>
                        <div class="dropdown-icon">
                            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/arrow.svg" alt="" />
                        </div>
                    </div>
                </button>
                <div class="collapse" id="themeDropdown-<?php echo $lists?>">
                    <div class="card card-body p-2">
                        <div class="freq">
                            <p><span>Frecuencia elegida:</span> <?php echo get_post_meta($lists,'_frecuency',true)?></p>
                        </div>
                        <div class="email-address">
                            <p><span>Recibir en:</span> <?php echo wp_get_current_user()->user_email?></p>
                        </div>
                       <!-- <div class="theme">
                            <p><span>Tema:</span> <?php //echo get_the_content($lists)?></p>
                        </div> -->
                        <div class="author">
                            <small>Por: <?php echo get_post_meta($lists,'_author_newsletter',true)?></small>
                        </div>
                        <div class="btns-container text-center mt-3">
                        <button class="gray-btn-black-text unsuscribe" data-lists="<?php echo $lists?>" data-email="<?php echo wp_get_current_user()->user_email?>">DESUSCRIBIRME</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
            
        </div>
        <div class="edit-themes">
            <div class="btns-container text-center py-3">
                <button><a href="<?php echo get_permalink( get_option('mailtrain_loop_page') )?>">Editar temas</a></button>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="news-nolist mt-4 mb-3">
    <div class="container">
        <div class="title text-center">
            <h4>¡Mantenete informada con la mirada de Tiempo!</h4>
        </div>
        <div class="subtitle text-center mt-4">
            <p>Actualmente no estás suscrito a ninguno de nuestros newsletters. En la sección “informate” podrás ver los
                temas disponibles que tenemos para vos. </p>
        </div>
        <div class="btns-container text-center py-3">
            <button><a href="<?php echo get_permalink( get_option('mailtrain_loop_page') )?>">ver temas</a></button>
        </div>
    </div>
</div>
<?php endif;?>
</div>
