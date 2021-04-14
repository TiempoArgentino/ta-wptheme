<?php

class TA_Author extends TA_Author_Data{
    public $term = null;

    public function __construct($term){
        $this->term = $term;
    }

    public function get_ID(){
        return $this->term->term_id;
    }

    public function get_name(){
        return $this->term->name;
    }

    public function get_position(){
        $position = get_term_meta($this->term->term_id, "ta_author_position", true );
        return $position ? $position : '';
    }

    public function get_social(){
        $socials_meta = $this->socials;
        $social = array(
            'user'  => '',
            'url'   => '',
        );

        if( $socials_meta ){
            if( isset($socials_meta['twitter']) && isset($socials_meta['twitter']['username']) && $socials_meta['twitter']['username'] ){
                $social['user'] = $socials_meta['twitter']['username'];
                $social['url'] = 'https://twitter.com/' . $socials_meta['twitter']['username'];
            }
            else if( isset($socials_meta['instagram']) && isset($socials_meta['instagram']['username']) && $socials_meta['instagram']['username'] ){
                $social['user'] = $socials_meta['instagram']['username'];
                $social['url'] = 'https://instagram.com/' . $socials_meta['instagram']['username'];
            }
        }

        return $social['user'] ? $social : null;
    }

    public function get_socials(){
        $socials_meta = get_term_meta($this->term->term_id, "ta_author_networks", true);
        return $socials_meta;
    }

    public function get_published_photo_url(){
        $attachment_id = get_term_meta($this->term->term_id, "ta_author_photo", true);
        $attachment_url = wp_get_attachment_image_url($attachment_id, 'full', false);
        return $attachment_url ? $attachment_url : '';
    }

    public function get_photo(){
        $attachment_url = $this->get_published_photo_url();
        return $attachment_url ? $attachment_url : TA_ASSETS_URL . '/img/no-author.jpg';
    }

    public function get_has_photo(){
        return $this->get_published_photo_url() !== '';
    }

    protected function get_archive_url(){
        return get_term_link( $this->term, 'ta_article_author' );
    }

    public function get_subject(){
        $subject = get_term_meta($this->term->term_id, "ta_author_subject", true);
        return $subject ? $subject : '';
    }

    public function get_quote(){
        $quote = get_term_meta($this->term->term_id, "ta_author_quote", true);
        return $quote ? $quote : '';
    }

    public function get_bio(){
        $bio = get_term_meta($this->term->term_id, "ta_author_bio", true);
        return $bio ? $bio : '';
    }

    public function get_networks(){
        $networks = get_term_meta($this->term->term_id, "ta_author_networks", true);
        return $networks ? $networks : null;
    }
}
