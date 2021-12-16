<?php
$defaults = array(
    'photographer'      => null,
);
extract(array_merge($defaults, $args));

if(!$photographer || !$photographer->name)
    return;
?>
<div class="credits text-right mt-2 d-flex justify-content-end align-items-center">
    <div class="credits-info d-flex flex-column mr-2">
        <p>Foto: <?php echo esc_html($photographer->name); ?></p>
        <?php if($photographer->main_red_social): ?>
        <a target="_blank" href="<?php echo esc_attr($photographer->main_red_social['url']); ?>">@<?php echo esc_html($photographer->main_red_social['username']); ?></a>
        <?php endif; ?>
    </div>
    <?php if($photographer->is_from_ta): ?>
    <div class="credits-icon">
        <img src="<?php echo TA_THEME_URL ?>/assets/img/camera-icon.svg" alt="" />
    </div>
    <?php endif; ?>
</div>
