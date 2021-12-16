<?php

$terms = get_the_terms($args['post_id'],'ta_article_tag');

$term = [];

foreach($terms as $t) {
    $term[] = $t->{'slug'};
}

$query = get_posts([
    'post_type' => 'ta_article',
    'posts_per_page' => 12,
    'tax_query' => [
        [
            'taxonomy' => 'ta_article_tag',
            'field'    => 'slug',
            'terms' => $term
        ]
    ]
]);

?>
<div class="mt-3">
    <div class="container">
        <div class="line-height-0">
            <div class="separator"></div>
        </div>
    </div>
    <div class="container-with-header light-blue-bg py-3">
        <div class="container">
            <div class="section-title">
                <h4>TAMBIÉN PODÉS LEER</h4>
            </div>
        </div>
        <div class="sub-blocks py-3">
            <div class="container">
                <div
                    class="ta-articles-block fullwidth-row d-flex flex-column flex-lg-row overflow-hidden justify-content-lg-between">
                    <div class="row">
                    <?php foreach($query as $art) : ?>
                        <div class="article-preview d-flex flex-md-column mb-3 col-md-3">
                            <div class="col-5 col-md-12 p-0">
                                <a href="">
                                    <div class="img-container position-relative">
                                        <div class="img-wrapper" style="background: url('<?php echo get_the_post_thumbnail_url($art->{'ID'})?>') center no-repeat !important; background-size:cover">

                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="content col-7 col-md-12">
                                <div class="description">
                                    <a href="<?php echo get_permalink( $art->{'ID'} )?>">
                                        <p><?php echo $art->{'post_title'}?></p>
                                    </a>
                                </div>
                                <div class="article-info-container">

                                    <div>
                                        <div class="author">
                                        <?php 
                                            $authors = get_the_terms(get_the_ID(),'ta_article_author');

                                            $author = join(' y ', wp_list_pluck($terms, 'name'));
                                        ?>
                                            <p>Por: <?php echo $author?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>