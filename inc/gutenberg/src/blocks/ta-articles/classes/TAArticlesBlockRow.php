<?php

abstract class TAArticlesBlockRow{
    protected $default_args = array();
    protected $articles = [];

    /**
    *   @param mixed[] $args
    */
    public function __construct($args){
        $this->args = array_merge(array(
            'use_balacer_articles'      => false,
            'balancer_allow_fallback'   => false,
        ), $this->default_args, $args);
    }

    /**
    *   @return int Must return the amount of cells that the row will show based
    *   on the arguments if the articles come from the balancer.
    */
    abstract public function get_cells_count_if_balanced();

    /**
    *   Renders the row
    *   @return int The amount of articles that were shown
    */
    abstract public function render();

    /**
    *   @return bool Indicates if the row will be showing articles from the balancer
    */
    public function is_balanced(){
        return $this->args['use_balacer_articles'];
    }

    /**
    *   Stablishes the articles
    *   @param TA_Article_Data[] $articles                                      The articles to store
    */
    public function set_articles($articles){
        $this->articles = $articles;
    }

    /**
    *   @return TA_Article_Data[] The articles to use in the row
    */
    public function get_articles(){
        // if($this->is_balanced()){
        //     $articles_ids = balancer_front()->balancer( $this->get_cells_count() );
        //     return get_ta_articles_from_query(array(
        //         'post_type'         => array('ta_article','ta_fotogaleria','ta_audiovisual'),
        //         'posts_per_page'    => 6,
        //         'post__in'          => $articles_ids,
        //     ));
        // }

        return $this->articles;
    }

}
