<?php

class TA_Photographer extends Data_Manager{
    static private $photographers = [];
    protected $defaults = array(
        'ID'                => null,
        'name'              => '',
        'is_from_ta'        => '',
    );

    public function __construct($term_id){
        $this->term = get_term($term_id, 'ta_photographer');
        self::$photographers[$this->term->term_id] = $this;
    }

    static public function get_photographer($term_id){
        return isset(self::$photographers[$term_id]) ? self::$photographers[$term_id] : new TA_Photographer($term_id);
    }

    protected function get_ID(){
        return $this->term->term_id;
    }

    protected function get_name(){
        return $this->term->name;
    }

    protected function get_is_from_ta(){
        return get_term_meta($this->ID, "is_from_ta", true );
    }

}
