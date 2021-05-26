<?php


class TA_Section_Factory{
    static private $ta_sections = [];

    /**
    *
    *   @param WP_Term $data
    *   @return TA_Section|null                                                 Returns an instance of a class that respects the TA_Section_Data format
    */
    static public function get_section($data, $type = 'ta_article_section'){
        switch($type){
            case 'ta_article_section':
                if( $data && is_a($data, 'WP_Term') && $data->taxonomy == 'ta_article_section' ){
                    if( array_key_exists($data->term_id, self::$ta_sections) )
                        return self::$ta_sections[$data->term_id];
                    self::$ta_sections[$data->term_id] = new TA_Section($data);
                    return self::$ta_sections[$data->term_id];     
                }
            break;
        }


        return null;
    }

}
