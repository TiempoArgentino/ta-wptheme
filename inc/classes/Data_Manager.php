<?php

/**
*
*/
class Data_Manager{
    protected $defaults = array();
    protected $values = array();
    /**
    *   @property mixed[] $populated_values                                     An accesible copy of the values
    */
    public $populated_values = array();

    private $populated = false;

    public function __construct($defaults = null){
        $this->populated_values = $this->defaults;
    }

    public function __get($prop_name) {

        // Check if prop_name exists in defaults
        if ( array_key_exists($prop_name, $this->defaults) ) {

            // Already stored data
            if ( array_key_exists($prop_name, $this->values) )
                return $this->values[$prop_name];

            // Set data and return
            $method_name = "get_$prop_name";

            if ( method_exists($this, $method_name) ){
                $this->values[$prop_name] = $this->$method_name();
                $this->populated_values[$prop_name] = $this->values[$prop_name];
                return $this->values[$prop_name];
            }

            return $this->defaults[$prop_name];
        }

        return;
    }

    public function __isset($key){
    	if(null===$this->__get($key)){
    		return false;
    	}
    	return true;
    }

    /**
    *   Sets the value of every property in the default array
    *   @param bool $recursive                                                  Indicates if properties of type Data_Manager should be
    *                                                                           populated as well
    */
    public function populate($recursive = false){
        if($this->populated)
            return false;
        $this->populated = true;
        $reflection = new ReflectionObject($this);

        foreach ($this->defaults as $prop_name => $default_value) {
            // $this->$prop_name; //generates the new value
            $prop_val = $this->$prop_name; //stores the new value
            $this->$prop_name = $this->$prop_name;

            if($recursive){
                // Property is instance of Data_Manager
                if(is_a($prop_val, 'Data_Manager')) {
                    $prop_val->populate($recursive);
                }
                // Property is array of Data_Manager ( Data_Manager[] )
                else if( is_array($prop_val) && !empty($prop_val) ) {
                    $method_name = "get_$prop_name";
                    $method = $reflection->getMethod($method_name);
                    $attributes = $method ? $method->getAttributes() : [];

                    foreach( $attributes as $method_attr ){
                        if( $method_attr->getName() == "Data_Manager_Array" ){
                            foreach ($prop_val as $data_manager_instance) {
                                $data_manager_instance->populate();
                            }
                            break;
                        }
                    }
                }
            }
        }


    }

    public function get_all_values(){
        return $this->values;
    }
}

class Data_Manager_Array extends \ArrayObject {
    public function offsetSet($key, $val) {
        if ($val instanceof Data_Manager) {
            return parent::offsetSet($key, $val);
        }
        throw new \InvalidArgumentException('Value must be an instance of Data_Manager');
    }
}

#[Attribute]
class ListensTo
{
    public string $event;

    public function __construct(string $event)
    {
        $this->event = $event;
    }
}
