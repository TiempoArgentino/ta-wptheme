<?php
$defaults = array(
    'class'   => '',
);
extract(array_merge($defaults, $args));

?>
<div class="social-btns">
                    <a href="" class="ml-2">
                        <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/comentar.svg" alt="" />
                    </a>
                    <a class="ml-2" tabindex="0" id="share-popover" data-bs-toggle="popover" data-bs-trigger="focus">
                        <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/compartir.svg" alt="" />
                    </a>
                    <a class="ml-2" href="">
                        <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/guardar.svg" alt="" />
                    </a>
                </div>
<!-- <div class="social-btns <?php //echo esc_attr($class); ?>">
    <a href="">
        <img src="<?php //echo TA_THEME_URL; ?>/markup/assets/images/comentar.svg" alt="" />
    </a>
    <a href="">
        <img src="<?php //echo TA_THEME_URL; ?>/markup/assets/images/compartir.svg" alt="" />
    </a>
    <?php //do_action('favorite_button_action')?>
</div> -->
