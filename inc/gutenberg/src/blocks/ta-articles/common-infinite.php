<?php

$preview_class = 'col-12';
$col_lg = 0;
if( $cells_per_row > 0  ){
    if($cells_per_row <= 4)
        $col_lg = 12 / $cells_per_row;
    else if( $cells_per_row == 5 )
        $col_lg = 2;
}
if($col_lg)
    $preview_class .= " col-lg-{$col_lg}";
?>
<div class="ta-articles-block d-flex flex-column flex-lg-row overflow-hidden justify-content-lg-between">
    <div class="row">
        <?php
            if( $articles ){
                foreach( $articles as $article ){
                    $data = $article;
                    $type = $articles_type;
                    $article_preview_block->render( array(
                        'article'       => $articles_type ? null : $article,
                        'article_data'  => $article,
                        'article_type'  => $articles_type,
                        'class'         => $preview_class,
                        'show_authors'  => $show_authors,
                    ) );
                }
            }
            else {
                foreach( $articles_data as $article_data ){
                    if( !is_array($article_data) || !isset($article_data['data']) || !isset($article_data['type']) )
                        continue;
                    $data = $article_data['data'];
                    $type = $article_data['data'];
                    $article_preview_block->render( array(
                        'article_data'  => $data,
                        'article_type'  => $type,
                        'class'         => $preview_class,
                        'show_authors'  => $show_authors,
                    ) );
                }
            }
        ?>
    </div>
</div>
