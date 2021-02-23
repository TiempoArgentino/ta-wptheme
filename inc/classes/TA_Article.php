<?php

/**
*   Common article data
*/

class TA_Article extends TA_Article_Data{
    public $post = null;

    public function __construct($post){
        $this->post = $post;
    }

    protected function get_content(){
        return get_the_content($this->post);
    }

    protected function get_title(){
        return get_the_title($this->post);
    }

    protected function get_excerpt(){
        return get_the_excerpt($this->post);
    }

    protected function get_section(){
        $sections = get_the_terms($this->post, 'ta_article_section');
        return $sections && !is_wp_error($sections) ? TA_Section_Factory::get_section( get_term($sections[0]->term_id) ) : null;
    }

    protected function get_url(){
        return get_permalink($this->post);
    }

    protected function get_tags(){
        $tags_terms = get_the_terms($this->post, 'ta_article_tag');
        $tags = null;
        if(is_array($tags_terms) && !empty($tags_terms)){
            $tags = array();
            foreach($tags_terms as $tag_term){
                $tags[] = TA_Tag_Factory::get_tag($tag_term);
            }
        }
        return $tags;
    }

    /**
    *   @return LR_Author[]|null
    */
    protected function get_authors(){
        $authors_terms = get_the_terms($this->post, 'ta_article_author');
        $authors = null;
        if(is_array($authors_terms) && !empty($authors_terms)){
            $authors = array();
            foreach($authors_terms as $author_term){
                $authors[] = TA_Author_Factory::get_author($author_term);
            }
        }
        return $authors;
    }

    /**
    *   @return LR_Author|null
    */
    protected function get_first_author(){
        return $this->authors ? $this->authors[0] : null;
    }

    /**
    *   Publication details
    *   @return string[]
    */
    protected function get_publication_info(){
        return array(
            'day'           => $this->get_date_day(),
            'time'          => $this->get_date_time(),
        );
    }

    /**
    *   Publication day
    *   @param string $format                                                   Date format
    *   @return string
    */
    public function get_date_day($format = 'j \d\e F \d\e Y'){
        return get_the_date($format, $this->post);
    }

    /**
    *   Publication time
    *   @return string
    */
    public function get_date_time(){
        return get_the_date('H:i', $this->post);
    }

    protected function get_thumbnail_common($variation = null, $size = 'full'){
        $thumbnail_id = get_post_thumbnail_id($this->post);
        $attachment = $thumbnail_id ? get_post( $thumbnail_id ) : null;
        $thumb_data = null;

        if( !$attachment ){
            $thumb_data = array(
                'attachment'    => null,
                'url'           => TA_IMAGES_URL . '/article-no-image.jpg',
                'caption'       => '',
                'author'        => null,
                'position'      => null,
                'alt'           => __('No hay imagen', 'ta-genosha'),
                'is_default'    => true,
            );
        }
        else {
            $alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', TRUE );
            $thumb_data = array(
                'attachment'    => $attachment,
                'url'           => wp_get_attachment_image_url($attachment->ID, $size, false),
                'caption'       => has_excerpt($attachment) ? get_the_excerpt($attachment) : '',
                'author'        => get_post_meta( $attachment->ID, 'ta_attachment_author', true ),
                'position'      => ta_get_attachment_positions($attachment->ID),
                'alt'           => $alt ? $alt : '',
                'is_default'    => false,
            );
        }

        return $thumb_data;
    }

    /**
    *   @return string
    */
    public function get_cintillo(){
        return get_post_meta($this->post->ID, 'ta_article_cintillo', true);
    }

}
