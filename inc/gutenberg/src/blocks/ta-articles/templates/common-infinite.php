<?php
$cells_count = 0;
$config = array(
    'cells_amount'      => 4,
    'cells_per_row'     => 4,
    'fill'              => false,
);
$config = array_merge($config, $row);
extract($config);

$col_lg = 0;
$col_lg_fill = 0;
$leftovers = 0;
$preview_class = '';
// if( $cells_per_row > 0  ){
//     if($cells_per_row <= 4)
//         $col_lg = 12 / $cells_per_row;
//     else if( $cells_per_row == 5 )
//         $col_lg = 2;
// }
if( $fill ){
    $leftovers = $cells_amount % $cells_per_row;
    $col_lg_fill = $leftovers ? 12 / $leftovers : 0;
}

if($cells_per_row <= 4)
    $col_lg = 12 / $cells_per_row;
else if( $cells_per_row == 5 )
    $col_lg = 2;

//ta-articles-block d-flex flex-column flex-lg-row overflow-hidden justify-content-lg-between
?>
<div class="ta-articles-block row">
        <?php
            if( $articles ){
                for ($i=0; $i < $cells_amount; $i++) {
                    $article_data = isset($articles[$i]) ? $articles[$i] : null;
                    $article = $articles_type ? TA_Article_Factory::get_article($article_data, $articles_type) : $article_data;

                    if(!$article)
                        break;

                    $col_lg_size = $i < $leftovers ? $col_lg_fill : $col_lg;
                    $col_class = "col-lg-$col_lg_size";
                    $size = $col_lg_size > 5 ? 'large' : 'common';
                    $class = "col-12 $col_class";

                    ?>
                    <div class="<?php echo esc_attr($class); ?>">
                        <?php
                        ta_render_article_preview($article, array(
                            'size'  => $size,
                            'class' => $preview_class,
                        ));
                        ?>
                    </div>
                    <?php
                    $cells_count++;
                }

                register_articles_block_cells_count($cells_count);
            }
        ?>
</div>
