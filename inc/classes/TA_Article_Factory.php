<?php

/**
*   Article data factory
*/

class TA_Article_Factory{
    static private $ta_articles = [];
    static private $post_types = ['article_post'];
    static public $use_cache = true;

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
                        if( self::$use_cache && array_key_exists($post->ID, self::$ta_articles) )
                            return self::$ta_articles[$post->ID];
                        self::$ta_articles[$post->ID] = new TA_Article($post);
                        return self::$ta_articles[$post->ID];
                    }
                    else if( $post->post_type == 'ta_ed_impresa' ){
                        if( self::$use_cache && array_key_exists($post->ID, self::$ta_articles) )
                            return self::$ta_articles[$post->ID];
                        self::$ta_articles[$post->ID] = new TA_Edicion_Impresa($post);
                        return self::$ta_articles[$post->ID];
                    }
                break;
            }
        }

        return null;
    }

}
