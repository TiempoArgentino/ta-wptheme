<?php

if(!class_exists('RB_Form')){
    class RB_Form{
        /**
        *   String that identifies this form
        *   @var string
        */
        private $id;

        /**
        *   Array of RB_Form_Field instances. Contains the information of every field
        *   @var array
        *   @param RB_Form_Field
        *
        */
        private $fields;

        /**
        *  Field that failed the validation callback
        *   @var RB_Form_Field
        *
        */
        private $unvalidated_field;

        /**
        *   Constructor.
        *   @param string $id Form identifier
        */
        function __construct($id){
            if(is_string($id))
                $this->id = trim($id);
        }

        // =====================================================================
        // GETTERS
        // =====================================================================

        /**
        *   Get the field that failed the validation
        *   @return null|RB_Form_Field
        */
        public function get_unvalidated_field(){
            return $this->unvalidated_field;
        }

        /**
        *   Get the name of the field that failed the validation
        *   @return string
        */
        public function get_unvalidated_field_name(){
            $field = $this->get_unvalidated_field();
            return $field ? $field->get_name() : '';
        }

        /**
        *   Gets the error from the unvalidated field
        *   @return null|string
        */
        public function get_error_message(){
            if($this->unvalidated_field)
                return $this->unvalidated_field->get_last_error();
        }

        /**
        *   Gets field by name
        *   @return null|RB_Form_Field
        */
        public function get_field($name){
            return is_string($name) && isset($this->fields[$name]) ? $this->fields[$name] : null;
        }

        /**
        *   Gets field value
        *   @return mixed
        */
        public function get_field_value($name){
            $field = $this->get_field($name);
            return $field ? $field->get_value() : null;
        }

        // =====================================================================
        // METHODS
        // =====================================================================
        /**
        *   Adds a RB_Form_Field to the $fields array
        *   @param RB_Form_Field $field     Instance of RB_Form_Field
        *   @return RB_Form $this
        *
        */
        public function add_field($field){
            if($field instanceof RB_Form_Field)
                $this->fields[$field->get_name()] = $field;
            return $this;
        }

        /**
        *   Returns wheter the form fields have a valid value. If any of them fails,
        *   returns false.
        *   @return bool
        *
        */
        public function is_valid(){
            if(is_array($this->fields)){
                foreach($this->fields as $field){
                    if(!$field->is_valid()){//Fails
                        $this->unvalidated_field = $field;
                        return false;
                    }
                }
            }
            //Validated
            return true;
        }
    }
}
