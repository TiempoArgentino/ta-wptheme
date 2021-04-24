<div class="container my-3 my-md-5">
    <div class="ta-context blue-border mx-2 mx-md-5">
        <div class="eleccion-contenido">
            <div id="searchBarMenu" class="collapse show" aria-labelledby="searchBarMenu">
                <div class="px-3 pt-3 pb-4">
                    <div class="close d-flex justify-content-end">
                        <div>
                            <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#searchBarMenu" aria-expanded="true" aria-controls="searchBarMenu">
                                <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/close.svg" class="img-fluid" alt="">
                            </button>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="title">
                            <p><?php echo __('Queremos ofrecerte mejor contenido:','gen-theme-base')?></p>
                        </div>
                        <div>
                            <p><?php echo sprintf(__('Selecciona los %s y sobre los que querés informarte:','gen-theme-base'),'<span>'.__('temas que te interesan','gen-theme-base').'</span>')?>  </p>
                        </div>
                        <!-- tags -->

                        <div class="container">
                            <div class="article-tags d-flex flex-wrap mt-4" id="cloud-tag-topics">
                                <?php if(is_user_logged_in()) : ?>
                                    <?php foreach(balancer_personalize()->get_topics() as $key => $val) : ?>
                                    <div class="tag d-flex justify-content-center my-2">
                                        <div class="content p-1">
                                            <a href="#" data-key="<?php echo $key?>">
                                                <p class="m-0"><?php echo $val?></p>
                                            </a>
                                        </div>
                                        <div class="triangle"></div>
                                    </div>
                                    <?php endforeach?>
                                <?php else: ?>
                                    <?php foreach(balancer_personalize()->get_tags() as $key => $val) : ?>
                                    <div class="tag d-flex justify-content-center my-2">
                                        <div class="content p-1">
                                            <a href="#" data-key="<?php echo $key?>">
                                                <p class="m-0"><?php echo $val?></p>
                                            </a>
                                        </div>
                                        <div class="triangle"></div>
                                    </div>
                                    <?php endforeach?>
                                <?php endif;?>
                            </div>
                            <div class="container-md mb-2 p-0 d-none">
                                <div class="separator"></div>
                            </div>
                        </div>
                        <!-- tags -->

                    </div>
                    <div class="ver-mas d-flex justify-content-center mt-4">
                        <button id="ver-mas-cloud"><?php echo __('VER MÁS','gen-theme-base')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>