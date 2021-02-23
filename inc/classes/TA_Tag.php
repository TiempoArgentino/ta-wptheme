<?php

class TA_Tag extends TA_Tag_Data {
    public $term = null;

    public function __construct($term){
        $this->term = $term;
    }

    protected function get_name(){
        return $this->term ? $this->term->name : '';
    }

    protected function get_archive_url(){
        return get_term_link( $this->term, 'ta_article_tag' );
    }

    protected function get_image_url(){
        $url = wp_get_attachment_url( get_term_meta( $this->term->term_id, 'ta_article_tag_image', true) );
        return $url ? $url : '';
    }

    protected function get_description(){
        $description = get_term_meta($this->term->term_id, 'ta_article_tag_description', true);
        return $description ? $description : '';
    }
}
