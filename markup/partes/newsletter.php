<div class="container-with-header newsletter">
    <div class="py-4">
        <div class="container">
            <div class="envelope-icon">
                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/envelope.svg" alt="" />
            </div>
            <div class="section-title">
                <h4><?php echo __('Sumate a nuestro NEWSLETTER', 'gen-base-theme') ?></h4>
            </div>
            <div class="subtitle">
                <p><?php echo __('Podés ajustar tus preferencias y garantizar un contenido adecuado para tus intereses:', 'gen-base-theme') ?></p>
            </div>
            <div class="newsletter-form d-flex flex-column justify-content-center">
                <p><span>></span> <?php echo __('Para recibir newsletters relacionados a este tema, dejanos tu e-mail acá:', 'gen-base-theme'); ?></p>
                <div class="input-container position-relative">
                    <?php if (is_active_sidebar('sidebar-1')) { ?>
                        <?php dynamic_sidebar('sidebar-1'); ?>
                    <?php } ?>
                    <!--<input type="email" placeholder="completá con tu mail_">-->
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/envelope.svg" alt="" class="input-icon envelope position-absolute" id="sobre" />
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/send.svg" alt="" class="input-icon send position-absolute" id="icono-newsletter" />
                </div>
                <!--<button class="mt-3">ENVIAR</button>-->
            </div>
            <div class="newsletter-options mt-4">
                <p><span>></span> <?php echo __('Para ver más opciones ingresá acá:', 'gen-base-theme') ?></p>
                <button class="uppercase"><a href="<?php echo get_permalink(get_option('mailtrain_loop_page')) ?>"><?php echo __('Explorar Newsletters', 'gen-base-theme') ?></a></button>
            </div>
        </div>
    </div>
</div>