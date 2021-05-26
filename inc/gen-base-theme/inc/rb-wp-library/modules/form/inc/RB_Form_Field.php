<?php

if(!class_exists('RB_Form_Field')){
    class RB_Form_Field{
        /**
        *   The field's value
        *   @var string
        */
        private $name;

        /**
        *   The field's value
        *   @var mixed
        */
        private $value;

        /**
        *   Array with check functions. Should return a message when checks
        *   checks
        *   @var array
        *
        */
        private $error_check;

        /**
        *   Return the last error message produced when checking this field validity
        *   with is_valid
        *   @var string
        *
        */
        private $last_error;

        /**
        *   Constructor.
        *
        *   @param string $value Field value
        *   @param string $value Field value
        *   @param array $error_check
        */
        function __construct($name, $value, $error_check){
            $this->name = $name;
            $this->value = $value;
            $this->error_check = $error_check;
        }

        // =====================================================================
        // GETTERS
        // =====================================================================
        /**
        *   @return mixed   The field name
        */
        public function get_name(){
            return $this->name;
        }

        /**
        *   @return mixed   The field value
        */
        public function get_value(){
            return $this->value;
        }

        /**
        *   Get the last error message
        *   @return null|string
        */
        public function get_last_error(){
            return $this->last_error;
        }

        // =====================================================================
        // SETTERS
        // =====================================================================
        /**
        *   Store the last error message
        *   @param string $message
        */
        private function set_last_error($message){
            if(is_string($message))
                $this->last_error = $message;
        }

        // =====================================================================
        // METHODS
        // =====================================================================
        /**
        *   Checks all the fields error_check
        *   @return bool    wheter it is valid or not
        */
        public function is_valid(){
            if(is_callable($this->error_check)){
                $error_message = call_user_func($this->error_check, $this->get_value());
                if($error_message){//Fails
                    $this->set_last_error($error_message);
                    return false;
                }
            }
            //Validates
            $this->set_last_error('');//No errors

            return true;
        }
    }
}
