<div class="container my-3 my-md-5" id="cloud-tag-container">
    <div class="ta-context blue-border mx-2 mx-md-5">
        <div class="eleccion-contenido">
            <div id="searchBarMenu">
                <div class="px-3 pt-3 pb-4">
                    <div class="close d-flex justify-content-end">
                        <div>
                            <button class="btn btn-link d-flex" id="close-cloud-tag">
                                <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/close.svg" class="img-fluid" alt="">
                            </button>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="title">
                            <p><?php echo __('Queremos ofrecerte mejor contenido:','gen-base-theme')?></p>
                        </div>
                        <div>
                            <p><?php echo sprintf(__('Selecciona los %s y sobre los que querés informarte:','gen-base-theme'),'<span>'.__('temas que te interesan','gen-base-theme').'</span>')?>  </p>
                        </div>
                        <!-- tags -->

                        <div class="container">
                            <div class="article-tags d-flex flex-wrap mt-4" id="cloud-tag-topics">
                                <?php if(!is_user_logged_in()) : ?>
                                    <?php foreach(balancer_personalize()->get_topics(16) as $key => $val) : ?>
                                    <div class="tag d-flex justify-content-center my-2">
                                        <div class="content p-1">
                                            <!--<a href="#" class="cloud-link">-->
                                                <p class="m-0 cloud-item" data-id="<?php echo $key?>"><?php echo $val?></p>
                                            <!--</a>-->
                                        </div>
                                        <div class="triangle"></div>
                                    </div>
                                    <?php endforeach?>
                                    <div class="btns-container d-none d-md-flex align-items-center">
                                        <button type="button"  id="ver-mas-cloud" data-toggle="collapse" data-target="#seeAllTags" aria-expanded="false"
                                            aria-controls="seeAllTags" class="collapsed">ver más<img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/right-arrow.png" alt=""
                                                class="img-fluid" /></button>
                                    </div>                                   
                                <?php endif;?>
                            </div>
                            <div class="container-md mb-2 p-0 d-none">
                                <div class="separator"></div>
                            </div>
                        </div>
                        <!-- tags -->

                    </div>
                    <div class="ver-mas d-flex justify-content-center mt-4">
                        <button id="listo-cloud"><?php echo __('Listo','gen-base-theme')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>