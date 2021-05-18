<?php get_header();
do_action('beneficios_post_header');
?>
<div class="articulo-especial beneficio text-right my-4">
    <div class="container">
        <div class="text-left mx-auto">
            <div class="categories d-flex">
                <h4 class="theme mr-2">BENEFICIOS</h4>
            </div>
            <?php
            while (have_posts()) : the_post();
            ?>
                <div class="art-column-w-xpadding">
                    <div class="title mt-2">
                        <h1><?php echo get_the_title() ?></h1>
                    </div>
                    <div class="subtitle">
                        <h3><?php echo get_the_excerpt(get_the_ID()) ?></h3>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="date mb-0"><?php echo get_the_date('d/m/Y', get_the_ID()) ?></p>
                    <div class="social-btns">
                        <a href="">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/compartir.svg" alt="" />
                        </a>
                    </div>
                </div>
                <div class="img-container mt-3">
                    <div class="img-wrapper">
                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>" alt="" class="img-fluid w-100" />
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row mt-5">
                    <div class="author d-flex align-items-center mx-2">
                        <div class="author-icon mr-2">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/tiempo-gift.svg" alt="" />
                        </div>
                        <div class="author-info">
                            <p>Por: <?php echo __('Beneficios Tiempo', 'beneficios') ?></p>
                            <?php
                            $terms = wp_get_post_terms(get_the_ID(), 'cat_beneficios');
                            foreach ($terms as $term) {
                                echo '<a href="' . get_term_link($term->term_id) . '">' . $term->name . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="article-body mt-3">
                    <div class="art-column-w-xpadding">
                        <?php the_content() ?>
                    </div>
                    <?php if (!beneficios_front()->get_beneficio_by_user(wp_get_current_user()->ID, get_the_ID())) : ?>

                        <?php if (is_user_logged_in()) : ?>
                            <!-- fcha -->
                            <?php if (!beneficios_front()->get_beneficio_by_user(wp_get_current_user()->ID, get_the_ID())) : ?>
                                <?php if (get_post_meta(get_the_ID(), '_beneficio_date', true)) : ?>
                                    <div id="fechas">
                                        <?php foreach (get_post_meta(get_the_ID(), '_beneficio_date', true) as $key => $val) : ?>
                                            <label><input type="radio" data-button="#solicitar-<?php echo get_the_ID() ?>" <?php echo $check ?> class="select-dates" name="gender" value="<?php echo date('Y-m-d H:i:s', strtotime($val)); ?>"> <?php echo date_i18n('d M H:i',  strtotime($val)); ?>hs</label><br />
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <p>Fecha elegida <?php echo beneficios_front()->get_beneficio_data(wp_get_current_user()->ID, get_the_ID())->{'date_hour'} ?></p>
                            <?php endif ?>
                            <!-- fecha -->
                        <?php endif ?>

                        <div class="btns-container text-center mt-5">
                        <?php if(is_user_logged_in()):?>
                            <button type="button" 
                            class="solicitar"
                             data-id="<?php echo get_the_ID() ?>"
                             data-user="<?php echo wp_get_current_user()->ID ?>"
                             <?php if (get_post_meta(get_the_ID(), '_beneficio_date', true)) {
                                     echo 'disabled';
                                    } ?> 
                            id="solicitar-<?php echo get_the_ID() ?>"> 
                            <?php echo __('Quiero Participar', 'beneficios') ?>
                            </button>

                            <div id="dni-<?php echo get_the_ID() ?>" class="dni-field" style="display: none;">
                                <?php echo __('Agrega tu DNI para solicitar el beneficio', 'beneficios') ?><br />
                                <p>
                                    <input type="number" name="dni-number" id="dni-number-<?php echo get_the_ID() ?>" data-id="<?php echo get_the_ID() ?>" data-user="<?php echo wp_get_current_user()->ID ?>" data-date="" value="" class="form-control" />
                                </p>
                                <button type="button" data-id="#dni-number-<?php echo get_the_ID() ?>" class="dni-button btn btn-primary"><?php echo __('Quiero Participar', 'beneficios') ?></button>
                            </div>
                          <?php else: ?>
                               <button><a href="<?php echo get_permalink( get_option('subscriptions_login_register_page') )?>"><?php echo __('Inicia sesión para solicitar el beneficio', 'beneficios') ?></a></button>
                          <?php endif; ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="social-btns text-right mt-5">
                    <a href="">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/compartir.svg" alt="" />
                    </a>
                </div>
            <?php
            endwhile;
            ?>
        </div>
        <!-- fin -->
    </div>
    <div class="container-md mb-2 p-0">
        <div class="separator"></div>
    </div>
</div>


<?php get_footer() ?>