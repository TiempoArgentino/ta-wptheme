<?php
$article = TA_Article_Factory::get_article($post);
$sister_article = $article->sister_article;
if(!$sister_article)
    return;
?>

<div class="container-with-header">
    <div class="container-md mb-2 p-0">
        <div class="separator"></div>
    </div>
    <div class="container">
        <div class="section-title">
            <h4>MIRÁ TAMBIÉN</h4>
        </div>
    </div>
    <div class="sub-blocks mt-3 mt-md-0">
        <div class="container">
            <div class="ta-articles-block fullwidth-row nota-hermana">
                <?php
                ta_render_article_preview($sister_article, array(
                    'layout'                => 'common-tiny',
                    'size'                  => 'common',
                    'class'                 => 'col-12 p-0 d-flex mt-3',
                    'desktop_horizontal'    => true,
                ));
                ?>
                <!-- <div class="article-preview col-12 p-0 d-flex mt-3">
                    <div class="content mt-0 mt-lg-3 col-12 p-0">
                        <div class="section-title">
                            <h4>TEMA O SECCIÓN</h4>
                        </div>
                        <div class="description">
                            <a href="">
                                <p>El grupo "infectadura" reapareció con una nueva carta inesperada. </p>
                            </a>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<div class="container-md mb-2 p-0 d-none">
    <div class="separator"></div>
</div>
