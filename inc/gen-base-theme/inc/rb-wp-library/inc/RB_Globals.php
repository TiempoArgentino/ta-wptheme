<?php
/*
*   Used to manage globals in a more controlled way.
*/
class RB_Globals{
    private static $globals = array();

    /**
    *   Sets a global
    *   @param string|array $name                           Global identifier. Can be an array of [identifier => default_value]
    *   @param string $default                              A default value, in case the global doesn't exists.
    */
    static public function get($name, $default = null){
        if( !$name && !is_string($name) && ( !is_array($name) || empty($name) ) )
            return null;

        if(is_string($name))
            return isset(self::$globals[$name]) ? rb_get_value(self::$globals[$name], $default) : $default;
        //no string then array
        $globals = $name;
        $result_globals = array();
        foreach($globals as $global_name => $global_default)
            $result_globals[$global_name] = isset(self::$globals[$global_name]) ? rb_get_value(self::$globals[$global_name], $global_default) : $global_default;
        return $result_globals;
    }

    /**
    *   Gets a global
    *   @param string $name                                 Global identifier.
    *   @param string $val                                  The global value.
    */
    static public function set($name, $val){
        return self::$globals[$name] = $val;
    }

    /**
    *   Sets a group of global variables. After calling the callback, the globals values go back to their previous one.
    *   been called
    *   @param mixed[] $globals                             Array of globals ( id => value ).
    *   @param callable $callback                           The function to call before the globals return to their original value.
    *   @return mixed The value returned by the callback, if any
    */
    static public function set_temporary($globals, $callback){
        $previous_values = array();//backup
        foreach($globals as $global_name => $global_new_val){
            //Backup the old value
            $previous_values[$global_name] = self::get($global_name);
            //Set the temporary value
            self::set($global_name, $global_new_val);
        }
        //Call the function with access to the temporary values
        $callback_result = call_user_func($callback);
        //Set back the previous values
        foreach($previous_values as $global_name => $global_prev_val)
            self::set($global_name, $global_prev_val);

        return $callback_result;
    }

    /**
    *   Require a file and sets some temporary values for a set of globals
    *   @param string $path                                 The required file path.
    *   @param mixed[] $globals                             Array of globals ( id => value ).
    *   @param mixed[] $required                            Indicates if the file should be required or included
    */
    static public function require_with_temp($path, $globals, $required = true){
        self::set_temporary($globals, function() use ($path, $required){
            if($required)
                require $path;
            else
                include $path;
        });
    }
}
