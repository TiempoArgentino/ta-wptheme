<?php get_header()?>
<?php do_action('before_newletter_page') ?>

<div class="tab-pane" id="newsletter">
<div class="news-list mt-4 mb-3">
    <div class="container">
        <div class="title text-center">
            <h4><?php echo __('Recibes actualizaciones de estos temas:','gen-theme-base')?></h4>
        </div>
        <div class="news-themes-dropdowns">
        <?php do_action('newletter_extra_content') ?>
            <?php 

            if(mailtrain_api_user()->user_lists()) :
                foreach(mailtrain_api_user()->user_lists() as $key => $lists): 
            ?>
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
                            <button class="gray-btn-black-text">DESUSCRIBIRME</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
                //endforeach;
            endforeach;

        endif;
        ?>
            
        </div>
        <div class="edit-themes">
            <div class="btns-container text-center py-3">
                <button><a href="<?php echo get_permalink( get_option('mailtrain_loop_page') )?>">editar temas</a></button>
            </div>
        </div>
    </div>
</div>

</div>
<div class="content-panel" id="newsletter">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center"><?php echo __('Newsletter','user-panel')?></h3>
        </div>
    </div>
    <div class="row">
        <?php do_action('newletter_extra_content') ?>
        <?php 
        foreach(json_decode(mailtrain_api()->get_lists_user(wp_get_current_user()->user_email)) as $ll){
            var_dump($ll);
            }
        ?>
    </div>
</div>
<?php get_footer()?>