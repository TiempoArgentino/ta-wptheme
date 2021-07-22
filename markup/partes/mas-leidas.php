<?php
// $query = TA_Theme::$latest_most_viewed;
$amount = 5;
$placeholders_articles = [];
$placeholder_article = new TA_Placeholder_Article();
$thumbnail = $placeholder_article->thumbnail_alt_common ? $placeholder_article->thumbnail_alt_common : $placeholder_article->thumbnail_common;
$thumbnail_url = $thumbnail['url'] ?? '';
?>

<div class="ta-user-tabs-block ta-context user-tabs gray-border mas-leidas mt-2 my-lg-5">
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
                    <div class="tab-pane active pt-3 ta-most-read-articles" id="most-read">
                        <div class="container">
                            <div class="ta-articles-block fullwidth-row d-flex flex-column flex-lg-row overflow-hidden justify-content-lg-between">
                                <div class="w-100">
                                <?php for ($i=0; $i < $amount; $i++): $art = $query->posts[$i]?>
                                    <div class="article-preview d-flex mb-3">
                                        <div class="col-5 p-0">
                                            <a data-link href="">
                                                <div class="img-container position-relative">
                                                    <div class="img-wrapper" data-thumbnail style="background-image:url('<?php echo $thumbnail_url ?>');"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="content col-7">
                                            <div class="description">
                                                <a data-link href="">
                                                    <p data-title><?php echo $placeholder_article->title; ?></p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
