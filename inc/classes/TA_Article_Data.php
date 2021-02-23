<?php

/**
*   The init_{$property} should be set by a child class for every property that
*   used in that data set
*/
class TA_Article_Data extends Data_Manager{
    protected $defaults = array(
        'title'             => '',
        'excerpt'           => '',
        'date'              => '',
        'section'           => null,
        'tags'              => null,
        'author'            => '',
        'publication_info'  => '',
        'content'           => '',
        'authors'           => null,
        'first_author'      => null,
        'thumbnail_common'  => null,
        'thumbnail_square'  => null,
        'thumbnail_16_9'    => null,
        'url'               => '',
        'cintillo'          => '',
    );

    public function get_thumbnail($variation = 'common', $size = 'full'){
        $thumbnail_prop = 'thumbnail';

        if(is_string($variation))
            $thumbnail_prop = "{$thumbnail_prop}_$variation";
        return $this->$thumbnail_prop;
    }

    public function get_date_day($format = 'j \d\e F \d\e Y'){
        return '';
    }

    public function get_date_time(){
        return '';
    }
}
