<?php
// $query = get_posts([
//     'post_type' => 'ta_article',
//     'posts_per_page' => 5,
//     'orderby' => 'ta_article_count',
//     'order' => 'DESC',
//     'meta_query' => [
//         [
//             'key' => 'ta_article_count',
//             'compare' => 'LIKE',
//             'type'      => 'NUMERIC',
//             'compare'   => 'EXISTS'
//         ]
//     ],
//     'date_query' => [
//         [
//             'column' => 'post_date_gmt',
//             'after'  => get_option('balancer_editorial_days') . ' days ago',
//         ]
//     ]
// ]);

$query = TA_Theme::$latest_most_viewed;
$amount = count($query) >= 5 ? 5 : count($query);
?>

<div class="ta-context user-tabs gray-border mas-leidas mt-2 my-lg-5">
    <div class="user-block-container">
        <div class="container p-md-0">
            <div class="user-tabs  mas-leidas">
                <ul class="nav nav-tabs" id="tab">
                    <li class="nav-item position-relative">
                        <a class="nav-link active d-flex flex-row-reverse" id="most-read-tab" data-toggle="tab"
                            href="#most-read">
                            <div></div>
                            <p>Más leídas</p>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane pt-3" id="related">
                        <div class="container">
                            <div
                                class="ta-articles-block fullwidth-row d-flex flex-column flex-lg-row overflow-hidden justify-content-lg-between">
                                <div class="w-100">
                                <?php for ($i=0; $i < $amount; $i++): $art = $query[$i]?>
                                    <div class="article-preview d-flex mb-3">
                                        <div class="col-5 p-0">
                                            <a href="<?php echo get_permalink( $art->{'ID'} )?>">
                                                <div class="img-container position-relative">
                                                    <div class="img-wrapper" style="background-image:url('<?php echo get_the_post_thumbnail_url($art->{'ID'}) ?>');">

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="content col-7">
                                            <div class="description">
                                                <a href="<?php echo get_permalink( $art->{'ID'} )?>">
                                                    <p><?php echo $art->{'post_title'}?></p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active pt-3" id="most-read">
                        <div class="container">
                            <div
                                class="ta-articles-block fullwidth-row d-flex flex-column flex-lg-row overflow-hidden justify-content-lg-between">
                                <div class="w-100">
                                <?php for ($i=0; $i < $amount; $i++): $art = $query[$i]?>
                                   <div class="article-preview d-flex mb-3">
                                        <div class="col-5 p-0">
                                            <a href="<?php echo get_permalink( $art->{'ID'} )?>">
                                                <div class="img-container position-relative">
                                                    <div class="img-wrapper" style="background-image:url('<?php echo get_the_post_thumbnail_url($art->{'ID'}) ?>');">

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="content col-7">
                                            <div class="description">
                                                <a href="<?php echo get_permalink( $art->{'ID'} )?>">
                                                    <p><?php echo $art->{'post_title'}?> </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
