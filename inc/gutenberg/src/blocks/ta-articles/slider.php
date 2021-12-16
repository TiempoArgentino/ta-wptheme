<div class="ta-articles-block d-flex">
    <?php
        if( $articles ){
            foreach( $articles as $article ){
                $data = $article;
                $type = $articles_type;
                $article_preview_block->render( array(
                    'article'       => $articles_type ? null : $article,
                    'article_data'  => $article,
                    'article_type'  => $articles_type,
                    'class'         => 'col-12 col-lg-3',
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
                    'class'         => 'col-12 col-lg-3',
                    'show_authors'  => $show_authors,
                ) );
            }
        }
    ?>
</div>
