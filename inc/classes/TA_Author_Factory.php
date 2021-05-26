<?php


class TA_Author_Factory{
    static private $ta_authors = [];

    /**
    *
    *   @param WP_Term $data
    *   @return TA_Author|null                                                  Returns an instance of a class that respects the TA_Author_Data format
    */
    static public function get_author($data){
        if( $data && is_a($data, 'WP_Term') && $data->taxonomy == 'ta_article_author' ){
            if( array_key_exists($data->term_id, self::$ta_authors) )
                return self::$ta_authors[$data->term_id];
            self::$ta_authors[$data->term_id] = new TA_Author($data);
            return self::$ta_authors[$data->term_id];
        }

        return null;
    }

}
