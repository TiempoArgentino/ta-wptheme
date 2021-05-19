<?php

/**
*   Common article data
*/

class TA_Edicion_Impresa extends TA_Article_Data{
    public $post = null;

    public function __construct($post){
        $this->defaults = array_merge($this->defaults, array(
            'issue_pdf'    => null,
        ));
        $this->post = $post;
    }

    protected function get_ID(){
        return $this->post->ID;
    }

    /**
    *   Returns the pdf attachment if any
    *   @return WP_Post|null
    */
    protected function get_issue_pdf(){
        $attachment_id = get_post_meta($this->post->ID, 'issuefile_attachment_id', true);
        $attachment = $attachment_id ? get_post( $attachment_id ) : null;
        return $attachment ? array(
            'url'   => wp_get_attachment_url($attachment->ID),
        ) : null;
    }

    protected function get_content(){
        $content = get_the_content($this->post->ID);
        ob_start();
        $articles_query = new WP_Query(array(
            'post_type'         => 'ta_article',
            'meta_key'          => 'ta_article_edicion_impresa',
            'meta_value'        => $this->post->ID,
            'posts_per_page'    => -1,
        ));
        $articles = [];

        if( $articles_query->have_posts() ){
            $articles = array_map(function($post){
                return TA_Article_Factory::get_article($post);
            }, $articles_query->posts);
        }

        if(!empty($articles)){
            $articles_block = RB_Gutenberg_Block::get_block('ta/articles');
            $articles_block->render(array(
                'articles'          => $articles,
                'container'         => array(
                    'title'             => 'Artículos',
                ),
                'rows'              => array(
                    array(
                        'format'            => 'common',
                        'cells_amount'      => -1,
                        'cells_per_row'     => 2,
                    ),
                ),
            ));
        }

        $content .= ob_get_clean();
        return $content;
    }

    protected function get_title(){
        return get_the_date('d/m/o', $this->post);
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
        return $tags;
    }
    // DATE DATE IS REMOVED SINCE THE TITLE ALREADY SHOWS IT
    // /**
    // *   Publication details
    // *   @return string[]
    // */
    // protected function get_publication_info(){
    //     return array(
    //         'day'           => $this->get_date_day(),
    //         'time'          => $this->get_date_time(),
    //     );
    // }
    //
    // /**
    // *   Publication day
    // *   @param string $format                                                   Date format
    // *   @return string
    // */
    // public function get_date_day($format = 'j \d\e F \d\e Y'){
    //     return get_the_date($format, $this->post);
    // }
    //
    // /**
    // *   Publication time
    // *   @return string
    // */
    // public function get_date_time(){
    //     return get_the_date('H:i', $this->post);
    // }

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

}
