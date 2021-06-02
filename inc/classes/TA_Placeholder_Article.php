<?php

/**
*   Article placeholder
*/

class TA_Placeholder_Article extends TA_Article_Data{
    public $post = null;

    public function __construct(){
    }

    protected function get_ID(){
        return -1;
    }

    protected function get_title(){
        return 'Cargando...';
    }

    protected function get_thumbnail_common($variation = null, $size = 'full'){
        $thumb_data = array(
            'attachment'    => null,
            'url'           => 'https://i.pinimg.com/originals/69/bc/42/69bc42f5f60a2c18e6bf9458e8080b82.gif',
            'caption'       => '',
            'author'        => null,
            'position'      => null,
            'alt'           => 'Cargando',
            'is_default'    => false,
        );

        return $thumb_data;
    }
}
