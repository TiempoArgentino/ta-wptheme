<?php

/**
*
*/
class Data_Manager{
    protected $defaults = array();
    protected $values = array();

    public function __construct($defaults = null){
        if( is_array($defaults) )
            $this->defaults = $defaults;
    }

    public function __get($prop_name) {

        // Check if prop_name exists in defaults
        if ( array_key_exists($prop_name, $this->defaults) ) {

            // Already stored data
            if ( array_key_exists($prop_name, $this->values) )
                return $this->values[$prop_name];

            // Set data and return
            $method_name = "get_$prop_name";

            if ( method_exists($this, $method_name) )
                $this->defaults[$prop_name] = $this->$method_name();

            return $this->defaults[$prop_name];
        }

        return;
    }
}
