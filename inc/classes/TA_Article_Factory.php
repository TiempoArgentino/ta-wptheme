<?php

/**
*   Article data factory
*/

class TA_Article_Factory{
    static private $ta_articles = [];

    /**
    *
    *   @param WP_Post $data
    *   @param string $type                                                     Type of article object
    *   @return TA_Article_Data|null                                            Returns an instance of a class that respects the TA_Article_Data format
    */
    static public function get_article($data, $type = 'article_post'){
        if( $data ){
            switch($type){
                case 'article_post':
                    $post = get_post($data);
                    if( $post->post_type == 'ta_article' ){
                        if( array_key_exists($data->ID, self::$ta_articles) )
                            return self::$ta_articles[$data->ID];
                        return new TA_Article($data);
                    }
                break;
            }
        }

        return null;
    }

}
