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
            'url'           => TA_IMAGES_URL . '/article-preview-spinner.gif',
            'caption'       => '',
            'author'        => null,
            'position'      => null,
            'alt'           => 'Cargando',
            'is_default'    => false,
        );

        return $thumb_data;
    }
}
