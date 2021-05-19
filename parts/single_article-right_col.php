<div class="col-12 col-lg-4 p-0">
    <div class="d-flex flex-column flex-lg-column-reverse">
        <div class="container-md p-0 line-height-0 mt-3 d-block d-md-none">
            <div class="separator"></div>
        </div>
       <!-- <div class="ta-context light-blue-bg">
            <?php // include_once(TA_THEME_PATH . '/markup/partes/newsletter.php');  ?>
        </div>-->
        <?php if (is_active_sidebar('note_mob_4')) { ?>
            <div class="d-block d-sm-none d-md-none d-lg-none text-center mx-auto mt-3">
                <?php dynamic_sidebar('note_mob_4'); ?>
            </div>
        <?php } ?>
        <div class="container-md mb-2 p-0 d-block d-md-none">
            <div class="separator"></div>
        </div>

        <?php include_once(TA_THEME_PATH . '/markup/partes/mas-leidas.php');
        ?>
    </div>
    <div class="container-md mb-2 p-0 d-none d-md-block">
        <div class="separator"></div>
    </div>
    <div class="d-none d-md-block">
        <?php //include(TA_THEME_PATH . '/markup/partes/taller-relacionado.php');
        ?>
    </div>
    <?php if (is_active_sidebar('side-single-note')) { ?>
        <div class="d-none d-sm-none d-md-block anuncio-side-single">
            <?php dynamic_sidebar('side-single-note'); ?>
        </div>
    <?php } ?>
</div>
