<?php

class TA_Section extends TA_Section_Data{
    public $term = null;

    public function __construct($term){
        $this->term = $term;
    }

    public function get_ID(){
        return $this->term ? $this->term->term_id : null;
    }

    public function get_name(){
        return $this->term ? $this->term->name : '';
    }

    public function get_slug(){
        return $this->term ? $this->term->slug : '';
    }

    public function get_archive_url(){
        return get_term_link( $this->term, 'ta_article_tag' );
    }
}
