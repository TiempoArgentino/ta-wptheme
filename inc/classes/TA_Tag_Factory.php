<?php


class TA_Tag_Factory{
    static private $ta_tags = [];

    /**
    *
    *   @param WP_Term $data
    *   @return TA_Section|null                                                 Returns an instance of a class that respects the TA_Tag_Data format
    */
    static public function get_tag($data, $type = 'ta_article_tag'){
        if( !$data )
            return null;

        switch($type){
            case 'ta_article_tag':
                if( is_a($data, 'WP_Term') && $data->taxonomy == 'ta_article_tag' ){
                    if( array_key_exists($data->term_id, self::$ta_tags) )
                        return self::$ta_tags[$data->term_id];
                    self::$ta_tags[$data->term_id] = new TA_Tag($data);
                    return self::$ta_tags[$data->term_id];
                }
            break;
        }

        return null;
    }

}
