<?php
$defaults = array(
    'class'   => '',
);
extract(array_merge($defaults, $args));

?>
<div class="social-btns <?php echo esc_attr($class); ?>">
    <a href="">
        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/comentar.svg" alt="" />
    </a>
    <a href="">
        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/compartir.svg" alt="" />
    </a>
    <?php do_action('favorite_button_action')?>
</div>
