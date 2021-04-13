<?php
function show_interest_front($query)
{
    foreach ($query as $art) {
?>
        <div class="article-preview m-2 col-12 col-lg-3 d-flex flex-column p-0">
            <div>
                <a href="">
                    <div class="img-container position-relative">
                        <div class="img-wrapper">
                            <img src="<?php echo get_the_post_thumbnail_url($art->{'ID'}) ?>" alt="" style="width:100%" />
                        </div>
                        <div class="icons-container">
                            <div class="article-icons d-flex flex-column position-absolute">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-1.svg" alt="" />
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-2.svg" alt="" />
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-3.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="content mt-0 mt-lg-3">
                <div class="description">
                    <a href="<?php echo get_permalink($art->{'ID'}) ?>">
                        <p><?php echo get_the_title($art->{'ID'}) ?></p>
                    </a>
                </div>
                <div class="article-info-container">
                    <div>
                        <div class="author">
                            <?php $terms = get_the_terms($art->{'ID'}, get_option('balancer_editorial_autor')) ?>
                            <p>Por: <?php echo join(' y ', wp_list_pluck($terms, 'name')) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>