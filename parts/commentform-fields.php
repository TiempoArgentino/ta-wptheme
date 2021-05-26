<?php
$user = wp_get_current_user();
$is_logged = $user->ID != 0;
?>
<div class="fields">

    <?php if(!$is_logged): ?>
    <div class="input-box d-flex justify-content-center mb-2">
        <div class="input-container position-relative w-100">
            <div class="input-wrapper">
                <span><input placeholder="Nombre" name="author" required="required" class></span>
            </div>
        </div>
    </div>
    <div class="input-box d-flex justify-content-center mb-2">
        <div class="input-container position-relative w-100">
            <div class="input-wrapper">
                <span><input placeholder="Email" type="email" name="email" required="required" class></span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="input-box d-flex justify-content-center mb-2">
        <div class="input-container position-relative w-100">
            <div class="input-wrapper">
                <span><input placeholder="Dejá tu comentario" name="comment" maxlength="65525" required="required" class></span>
            </div>
            <div class="input-icon">
                <button class="position-absolute">
                    <img src="<?php echo TA_THEME_URL; ?>/assets/img/emoji.svg" alt="Emojis" class="w-100" />
                </button>
            </div>
        </div>
        <div class="send-btn d-flex align-items-center">
            <button><img src="<?php echo TA_THEME_URL; ?>/assets/img/send.svg" alt="Enviar" /></button>
        </div>
    </div>

    <div class="general-error">
        <p class="error-message"></p>
    </div>
</div>
