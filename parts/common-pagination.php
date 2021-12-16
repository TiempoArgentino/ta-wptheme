<?php
/*
     *   Barra de paginacion
     */
$defaults = array(
    /**
     *   @param int $total                           Requerido. Cantidad total de paginas
    */
    'total'                     => null,
    /**
    *   @param int $current                         Requerido. Pagina actual.
    */
    'current'                   => null,
    /**
    *   @param int $base
    */
    'base'                      => null,
    /**
    *   @param int $format
    */
    'format'                    => null,
    /**
    *   @param int $custom_search
    */
    'custom_search'                    => false
);
extract( array_merge( $defaults, $args ) );
// if (!$custom_search) {
//     $base = get_pagenum_link(1) . '%_%';
// }

if ($total <= 1)
    return;

?>
<div class="pagination-articles pb-3">
    <?php
    $settings = array(
        'current'       => $current,
        'total'         => $total,
        'mid_size'      => 3,
        'prev_text'     => __('<i class="fas fa-angle-double-left"></i>'),
        'next_text'     => __('<i class="fas fa-angle-double-right"></i>'),
    );

    if ($format !== null)
        $settings['format'] = $format;
    if ($base !== null)
        $settings['base'] = $base;

    echo paginate_links($settings);
    ?>
</div>


<!-- <div class="btns-container">
    <div class="pagination d-none d-lg-flex justify-content-center">
        <button class="active">1</button>
        <button>2</button>
        <button>3</button>
    </div>
</div> -->
