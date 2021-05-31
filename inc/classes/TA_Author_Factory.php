<?php


class TA_Author_Factory{
    static private $ta_authors = [];

    /**
    *
    *   @param WP_Term $data
    *   @return TA_Author|null                                                  Returns an instance of a class that respects the TA_Author_Data format
    */
    static public function get_author($data){
        $term = get_term($data);
        if( $term && !is_wp_error($term) && $term->taxonomy == 'ta_article_author' ){
            if( array_key_exists($term->term_id, self::$ta_authors) )
                return self::$ta_authors[$term->term_id];
            self::$ta_authors[$term->term_id] = new TA_Author($term);
            return self::$ta_authors[$term->term_id];
        }

        return null;
    }

}
