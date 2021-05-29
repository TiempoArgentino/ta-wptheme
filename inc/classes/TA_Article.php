<?php

/**
*   Common article data
*/

class TA_Article extends TA_Article_Data{
    public $post = null;

    public function __construct($post){
        $this->post = $post;
    }

    protected function get_ID(){
        return $this->post->ID;
    }

    protected function get_content(){
        return get_the_content($this->post->ID);
    }

    protected function get_title(){
        return get_the_title($this->post);
    }

    protected function get_excerpt(){
        return $this->post->post_excerpt;
    }

    protected function get_excerpt_trimmed(){
        $excerpt_words = explode(' ', $this->excerpt);
        return count($excerpt_words) > 8 ? implode(' ', array_slice($excerpt_words, 0, 8)) . " " . '...' : $this->excerpt;
    }

    protected function get_section(){
        $sections = get_the_terms($this->post, 'ta_article_section');
        return $sections && !is_wp_error($sections) ? TA_Section_Factory::get_section( get_term($sections[0]->term_id) ) : null;
    }

    protected function get_micrositio(){
        $micrositios = get_the_terms($this->post, 'ta_article_micrositio');
        return $micrositios && !is_wp_error($micrositios) ? TA_Micrositio::get_micrositio( $micrositios[0]->slug ) : null;
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
        return !empty($tags) ? $tags : null;
    }

    /**
    *   @return LR_Author[]|null
    */
    #[Data_Manager_Array]
    protected function get_authors(){
        $authors_terms = get_the_terms($this->post, 'ta_article_author');
        $authors = null;
        if(is_array($authors_terms) && !empty($authors_terms)){
            $authors = [];
            foreach($authors_terms as $author_term){
                $authors[] = TA_Author_Factory::get_author($author_term);
            }
        }
        return !empty($authors) ? $authors : null;
    }

    /**
    *   @return WP_Term[]|null
    */
    protected function get_temas(){
        $temas_terms = get_the_terms($this->post, 'ta_article_tema');
        return $temas_terms && !is_wp_error($temas_terms) ? $temas_terms : null;
    }

    /**
    *   @return WP_Term[]|null
    */
    protected function get_lugares(){
        $lugares_terms = get_the_terms($this->post, 'ta_article_place');
        return $lugares_terms && !is_wp_error($lugares_terms) ? $lugares_terms : null;
    }

    /**
    *   @return LR_Author|null
    */
    protected function get_first_author(){
        return $this->authors ? $this->authors[0] : null;
    }

    protected function get_authors_roles(){
        $roles = get_post_meta($this->post->ID, 'ta_article_authors_rols', true);
        return $roles && is_array($roles) ? $roles : [];
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
            $alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
            $thumb_data = array(
                'attachment'    => $attachment,
                'url'           => wp_get_attachment_image_url($attachment->ID, $size, false),
                'caption'       => has_excerpt($attachment) ? get_the_excerpt($attachment) : '',
                'author'        => ta_get_attachment_photographer($attachment->ID),
                'position'      => ta_get_attachment_positions($attachment->ID),
                'alt'           => $alt ? $alt : '',
                'is_default'    => false,
            );
        }

        return $thumb_data;
    }

    protected function get_thumbnail_alt_common($variation = null, $size = 'full'){
        $thumbnail_id = get_post_meta($this->post->ID, 'ta_article_thumbnail_alt', true);
        $attachment = $thumbnail_id ? get_post( $thumbnail_id ) : null;
        $thumb_data = null;

        if( $attachment ){
            $alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
            $thumb_data = array(
                'attachment'    => $attachment,
                'url'           => wp_get_attachment_image_url($attachment->ID, $size, false),
                'caption'       => has_excerpt($attachment) ? get_the_excerpt($attachment) : '',
                'author'        => ta_get_attachment_photographer($attachment->ID),
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

    /**
    *   @return mixed[]
    */
    public function get_participation(){
        $participation_meta = get_post_meta($this->post->ID, 'ta_article_participation', true);
        $result = array(
            'use'                   => false,
            'use_live_date'         => false,
            'live_title'            => '',
            'live_link'             => '',
            'live_date'             => null,
        );

        if($participation_meta && is_array($participation_meta)){
            $result = array_merge($result, $participation_meta);
        }

        return $result;
    }

    /**
    *   @return bool
    */
    public function get_isopinion(){
        $author = $this->first_author;
        $meta_value = get_post_meta($this->post->ID, 'ta_article_isopinion', true);
        // Sanitize meta value. Some of the articles imported stored "true" and "false" instead
        // of boolean.
        if(!is_bool($meta_value)){
            if(is_string($meta_value)){
                $meta_value = strtolower(trim($meta_value));
                $meta_value = $meta_value == "true" || $meta_value == "1" ? true : false;
            }
            else{
                $meta_value = boolval($meta_value);
            }
        }

        return $author && $meta_value;
    }

    /**
    *   Returns the instance of the article stablished as related to this one
    *   @return TA_Article_Factory|null
    */
    public function get_sister_article(){
        $article_id = get_post_meta( $this->post->ID, 'ta_article_sister_article', true );
        return !$article_id ? null : TA_Article_Factory::get_article( get_post($article_id) );
    }
}
