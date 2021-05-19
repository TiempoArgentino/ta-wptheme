<?php

class TAArticlesMiscelaneaRow extends TAArticlesBlockRow{

    protected $default_args = array(
        'slides_amount'             => 4,
        'deactivate_opinion_layout' => false,
    );

    public function get_cells_count_if_balanced(){
        return 4;
    }

    public function render(){
        extract($this->args);
        $articles = $this->get_articles();
        $featured = isset($articles[0]) ? $articles[0] : null;
        $regular_1 = isset($articles[1]) ? $articles[1] : null;
        $regular_2 = isset($articles[2]) ? $articles[2] : null;
        $regular_3 =isset($articles[3]) ? $articles[3] : null;

        $regular_config = array(
            'size'                      => 'common',
            'class'                     => '',
            'desktop_horizontal'        => true,
            'deactivate_opinion_layout' => $deactivate_opinion_layout,
        );

        ?>

        <div class="ta-articles-block d-flex flex-column flex-md-row mt-3 row">
            <div class="col-12 col-md-6">
                <?php
                ta_render_article_preview($featured, array(
                    'size'                      => 'large',
                    'class'                     => '',
                    'deactivate_opinion_layout' => $deactivate_opinion_layout,
                ));
                ?>
            </div>
            <div class="col-12 col-md-6">
                <?php $regular_1 ? ta_render_article_preview($regular_1, $regular_config) : null; ?>
                <?php $regular_2 ? ta_render_article_preview($regular_2, $regular_config) : null; ?>
                <?php $regular_3 ? ta_render_article_preview($regular_3, $regular_config) : null; ?>
            </div>
        </div>

        <?php

        return 4;

    }

}
