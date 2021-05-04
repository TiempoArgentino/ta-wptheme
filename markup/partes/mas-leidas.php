<?php
$articles = [];


if($wp_query->have_posts()){
    $articles = array_map(function($post){
        return TA_Article_Factory::get_article($post);
    },$wp_query->posts);
}
$articles_block = RB_Gutenberg_Block::get_block('ta/articles');

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
                                    <!-- <div class="article-preview d-flex mb-3">
                                        <div class="col-5 p-0">
                                            <a href="">
                                                <div class="img-container position-relative">
                                                    <div class="img-wrapper">

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="content col-7">
                                            <div class="description">
                                                <a href="">
                                                    <p>El grupo "infectadura" reapareció.
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div> -->
                                    <?php 
                                        $articles_block->render(array(
                                            'articles'          => $articles,
                                            'articles_type'     => 'article_post',
                                            'rows'              => array(
                                                array(
                                                    'format'            => 'common',
                                                    'cells_amount'      => -1,
                                                    'cells_per_row'     => 1,
                                                ),
                                            ),
                                        ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active pt-3" id="most-read">
                        <div class="container">
                            <div
                                class="ta-articles-block fullwidth-row d-flex flex-column flex-lg-row overflow-hidden justify-content-lg-between">
                                <div class="w-100">

                                    <!-- <div class="article-preview d-flex mb-3">
                                        <div class="col-5 p-0">
                                            <a href="">
                                                <div class="img-container position-relative">
                                                    <div class="img-wrapper">

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="content col-7">
                                            <div class="description">
                                                <a href="">
                                                    <p>El grupo "infectadura" reapareció.
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div> -->
                                    <?php 
                                        $articles_block->render(array(
                                            'articles'          => $articles,
                                            'articles_type'     => 'article_post',
                                            'rows'              => array(
                                                array(
                                                    'format'            => 'common',
                                                    'cells_amount'      => -1,
                                                    'cells_per_row'     => 1,
                                                ),
                                            ),
                                        ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>