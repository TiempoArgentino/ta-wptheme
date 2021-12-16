<?php

/**
*   Article from balancer database
*/

class TA_Balancer_Article extends TA_Article_Data{
    protected $data = array(
        'postId'            => null,    //done
        'title'             => "",      //done
        'url'               => "",      //done
        'headband'          => "",      //done
        'imgURL'            => "",      //done
        'isOpinion'         => false,   //done
        'section'           => null,    //done
        'authors'           => [],      //done
        'tags'              => [],      //done
        'themes'            => [],      //done
        'places'            => [],      //done
    );
    public $post = null;

    public function __construct(array $data){
        $this->data = array_merge($this->data, $data);
    }

    protected function get_ID(){
        return $this->data['postId'];
    }

    protected function get_title(){
        return $this->data['title'];
    }

    protected function get_url(){
        return $this->data['url'];
    }

    /**
    *   @return LR_Author[]|null
    */
    #[Data_Manager_Array]
    protected function get_authors(){
        $authors = null;
        if($this->data['authors'] && !empty($this->data['authors'])){
            $authors = [];
            foreach($this->data['authors'] as $author_data){
                $author = new TA_Balancer_Author($author_data);
                if($author)
                    $authors[] = $author;
            }
        }
        return $authors;
    }

    /**
    *   @return LR_Author|null
    */
    protected function get_first_author(){
        return $this->authors ? $this->authors[0] : null;
    }

    protected function get_thumbnail_common($variation = null, $size = 'full'){
        if( !$this->data['imgURL'] ){
            $thumb_data = array(
                'attachment'    => null,
                'url'           => TA_IMAGES_URL . '/article-no-image.jpg',
                'caption'       => '',
                'author'        => null,
                'position'      => null,
                'alt'           => __('No hay imagen', 'ta-genosha'),
                'is_default'    => true,
            );
        }
        else {
            $alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
            $thumb_data = array(
                'attachment'    => null,
                'url'           => $this->data['imgURL'],
                'caption'       => '',
                'author'        => null,
                'position'      => null,
                'alt'           => '',
                'is_default'    => false,
            );
        }

        return $thumb_data;
    }

    /**
    *   @return string
    */
    public function get_cintillo(){
        return $this->data['headband'];
    }

    /**
    *   @return bool
    */
    public function get_isopinion(){
        return $this->first_author && $this->data['isOpinion'];
    }
}
