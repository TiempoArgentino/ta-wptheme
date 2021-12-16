<!-- widget sobre la nota -->
<?php if (is_active_sidebar('over-single-note')) { ?>
    <div class="container d-none d-sm-none d-md-block mt-md-3 mb-md-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('over-single-note'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (is_active_sidebar('note_mob_1')) { ?>
    <div class="container d-block d-sm-none d-md-none d-lg-none mt-md-3 mb-md-3 mt-3">
        <div class="row d-flex">
            <div class="col-9 mx-auto">
                <?php dynamic_sidebar('note_mob_1'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<!-- widget sobre la nota -->
