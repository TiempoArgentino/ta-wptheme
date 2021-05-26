<?php
$default_args = array(
    'search_query'  => '',
    'post_type'     => 'ta_article',
    'close_button'  => false,
);
extract(array_merge($default_args, $args));
?>
<form id="searchform" method="get" action="<?php echo home_url('/'); ?>">
    <div class="search-bar-container px-3 pt-3 pb-4">
        <?php if($close_button): ?>
        <div class="close d-flex d-lg-none justify-content-end">
            <div>
                <button class="btn btn-link d-flex" data-toggle="collapse" data-target="#searchBar" aria-expanded="true" aria-controls="searchBar">
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/close.svg" class="img-fluid" alt="">
                </button>
            </div>
        </div>
        <?php endif; ?>
        <div class="input-container d-flex justify-content-center mt-3">
            <div class="search-icon mr-2">
                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/search-icon-blue.svg" class="img-fluid" alt="">
            </div>
            <div class="input-wrapper flex-fill">
                <input type="text" name="s" placeholder="Buscar en Tiempo Argentino..." value="<?php echo esc_attr($search_query); ?>"/>
                <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
            </div>
            <div class="search d-none d-lg-flex justify-content-center ml-3">
                <button type="submit">BUSCAR</button>
            </div>
            <?php if($close_button): ?>
            <div class="close d-flex justify-content-end align-items-center ml-3">
                <div>
                    <button class="btn btn-link d-none d-lg-flex" data-toggle="collapse" data-target="#searchBar" aria-expanded="true" aria-controls="searchBar">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/close.svg" class="img-fluid" alt="">
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="search d-flex d-lg-none justify-content-center mt-4">
            <button type="submit">BUSCAR</button>
        </div>
    </div>
</form>
