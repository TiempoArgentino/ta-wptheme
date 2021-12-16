<?php

/**
*   Author from balancer database
*/
class TA_Balancer_Author extends TA_Author_Data{
    protected $data = array(
        'authorId'              => null,
        'authorName'            => "",
        'authorUrl'             => "",
        'authorImg'             => "",
    );

    public function __construct(array $data){
        $this->data = array_merge($this->data, $data);
    }

    public function get_ID(){
        return $this->data['authorId'];
    }

    public function get_name(){
        return $this->data['authorName'];
    }

    public function get_published_photo_url(){
        return $this->data['authorImg'];
    }

    public function get_photo(){
        $attachment_url = $this->get_published_photo_url();
        return $attachment_url ? $attachment_url : TA_ASSETS_URL . '/img/no-author.jpg';
    }

    public function get_has_photo(){
        return $this->get_published_photo_url() !== '';
    }

    protected function get_archive_url(){
        return $this->data['authorUrl'];
    }
}
