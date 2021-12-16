<?php

class TA_Photographer extends Data_Manager{
    static private $photographers = [];
    protected $defaults = array(
        'ID'                => null,
        'name'              => '',
        'is_from_ta'        => '',
        'redes'             => null,
        'main_red_social'   => null,
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
        return get_term_meta($this->ID, "ta_photographer_is_from_tiempo_arg", true );
    }

    protected function get_redes(){
        $meta_value = get_term_meta($this->ID, "ta_photographer_networks", true );
        $socials = array();
        if($meta_value && is_array($meta_value)){
            if(isset($meta_value['twitter']) && $meta_value['twitter']['username']){
                $socials['twitter'] = array(
                    'username'          => $meta_value['twitter']['username'],
                    'url'               => "https://twitter.com/{$meta_value['twitter']['username']}",
                );
            }
            if(isset($meta_value['instagram']) && $meta_value['instagram']['username']){
                $socials['instagram'] = array(
                    'username'          => $meta_value['instagram']['username'],
                    'url'               => "https://instagram.com/{$meta_value['instagram']['username']}",
                );
            }
            if(isset($meta_value['email']) && $meta_value['email']['username']){
                $socials['email'] = array(
                    'username'          => $meta_value['email']['username'],
                    'url'               => "mailto: {$meta_value['email']['username']}",
                );
            }
        }

        return empty($socials) ? null : $socials;
    }

    protected function get_main_red_social(){
        $redes = $this->redes;
        $order = ['twitter', 'instagram'/*, 'email'*/];
        if($redes){
            foreach ($order as $network_slug) {
                if(isset($redes[$network_slug]))
                    return $redes[$network_slug];
            }
        }
        return null;
    }

}
