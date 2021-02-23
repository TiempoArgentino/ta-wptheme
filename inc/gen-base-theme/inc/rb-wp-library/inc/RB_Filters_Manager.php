<?php

/*
*   It helps managing filters hooks, storing information about them in order to
*   allow third parties to remove them and other functionalities
*/
class RB_Filters_Manager{
    static private $stored_filters = array();

    /**
    *   Stores an filter data
    *   @param string $filter_id                        Filters identifier.
    */
    static private function store_filter_data($filter_id, $filter_data){
        self::$stored_filters[$filter_id] = $filter_data;
    }

    /**
    *   Adds a filter and stores its data for easier filters manipulation
    *   @param string $filter_id                        Filters identifier. Used by the RB_Filters_Manager to facilitate
    *                                                   operations with existing filters, like removing.
    *   @param string $tag                              The name of the filter to which the $function_to_add is hooked.
    *   @param callable $function_to_add                The callable of the function to be runned on this filter.
    *   @param mixed[] (optional) $args
    *   Optional argumentes array
    *       @property int $priority                     Filter priority. Used by the manager to add filters before of after
    *                                                   this one. Might be overriden if passed any $dependencies.
    *       @param int $accepted_args                   The number of arguments the function accepts.
    *       @param string[] $dependencies               Filters ids of those this one depends on. The priority of this
    *                                                   filter will be setted inmediatly higher than the latest filter passed, so that
    *                                                   the callback may be called after all of them had been already invoked.
    *       @param bool $await_dependencies             ****TO BE IMPLEMENTED****
    *                                                   Indicates wheter the filter hook must be put on hold if dependencies where not found.
    *                                                   The filter will be hooked once the dependencies gets hooked or if the filter hook is
    *                                                   reached.
    *       @property bool $is_action                   Indicates if this is an action type filter.
    */
    static public function add_filter($filter_id, $tag, $function_to_add, $args = array()){
        // VALIDATION
        if(!is_string($filter_id) || !is_string($tag))
            return false;
        if(self::get_stored_filter($filter_id))// If and filter with that id already exists
            throw new Exception("Trying to store a filter with an ID that already exists: '$filter_id'");

        // ARGS SETUP
        $default_args = array(
            'priority'              => 10,
            'accepted_args'         => 1,
            'dependencies'          => null,
            'await_dependencies'    => true,
            'is_action'             => false,
        );
        $args = array_merge($default_args, $args);
        extract($args);

        // ACTION DATA CONSTRUCTION
        // Set priority based on dependencies passed
        if(is_array($dependencies) && !empty($dependencies))
            $priority = self::generate_filter_priority($tag, $dependencies, $priority);

        // Add filter/action
        if($is_action)
            add_action( $tag, $function_to_add, $priority, $accepted_args );
        else
            add_filter( $tag, $function_to_add, $priority, $accepted_args );

        // Store the filter data
        $filter_data = array(
            'tag'           => $tag,
            'callback'      => $function_to_add,
            'priority'      => $priority,
            'accepted_args' => $accepted_args,
            'is_action'     => $is_action,
        );
        self::store_filter_data($filter_id, $filter_data);
    }


    /**
    *   Returns an filter stored data
    *   @param string $filter_id                        Filter identifier
    *   @return mixed[]|null                            The filter if found, null otherwise
    */
    static private function get_stored_filter($filter_id){
        if(!is_string($filter_id))
            return null;
        return isset(self::$stored_filters[$filter_id]) ? self::$stored_filters[$filter_id] : null;
    }

    /**
    *   Removes a filter, preventing the callback from being called
    *   @param string $filter_id                        Filters identifier
    *   @param mixed[] (optional) $args
    *   Optional argumentes array
    *       @property int $priority                     Filter priority. Used by the manager to add filters before or after
    *                                                   this one. Might be overriden if passed any $dependencies.
    *       @property bool $is_action                   Indicates if this is an action type filter.
    */
    static public function remove_filter($filter_id, $args = array()){
        if(!is_string($filter_id))
            return false;
        $filter = self::get_stored_filter($filter_id);
        if(!$filter)
            return false;

        // ARGS SETUP
        $default_args = array(
            'priority'              => 10,
            'is_action'             => false,
        );
        $args = array_merge($default_args, $args);
        extract($args);

        if($is_action)
            remove_action($filter['tag'], $filter['callback'], $priority);
        else
            remove_filter($filter['tag'], $filter['callback'], $priority);

        unset(self::$stored_filters[$filter_id]);
    }

    /**
    *   Removes an action, preventing the callback from being called
    *   @param string $action_id                        Action identifier
    *   @param mixed[] (optional) $args                 Optional argumentes array. See 'remove_filter'
    */
    static public function remove_action($action_id, $args = array()){
        $args = array_merge($args, array(
            'is_action' => true,
        ));
        self::remove_filter($action_id, $args);
    }

    /**
    *   Adds an action and stores its data for easier actions manipulation
    *   @param string $action_id                        Action identifier. Used by the RB_Filters_Manager to facilitate
    *                                                   operations with existing actions, like removing.
    *   @param string $tag                              The name of the action to which the $function_to_add is hooked.
    *   @param callable $function_to_add                The callable of the function to be runned on this action.
    *   @param mixed[] (optional) $args                 Optional argumentes array. See 'add_filter'
    */
    static public function add_action($action_id, $tag, $function_to_add, $args = array()){
        $args = array_merge($args, array(
            'is_action' => true,
        ));
        self::add_filter($action_id, $tag, $function_to_add, $args);
    }

    /**
    *   Returns the latest filter to be called, being the one with the biggest priority
    *   @param string[] $tag                            Filter hook tag of the hook we want the latest filter from.
    *   @param string[] (optional)$filters_ids          A set of filters to which reduce the search of the latest.
    *   @return mixed[]|null                            The latest filter, or null if not found.
    */
    static public function get_latest_filter($tag, $filters_ids = null){
        $latest_filter = null;
        $check_and_replace = function($current_filter) use (&$latest_filter, $tag){
            if($current_filter['tag'] != $tag)//Check if the filter is hooked to the filter hook we want
                return;
            if(!$latest_filter)//First filter data found
                $latest_filter = $current_filter;
            else //if this filter is runned after the current latest filter found
                $latest_filter = $current_filter['priority'] >= $current_filter['priority'] ? $filter_data : $latest_filter;
        };

        if(is_array($filters_ids) && !empty($filters_ids)){
            foreach($filters_ids as $filter_id){
                if(!isset(self::$stored_filters[$filter_id])) //filter not found
                    continue;
                $check_and_replace(self::$stored_filters[$filter_id]);
            }
        }
        else {
            foreach(self::$stored_filters as $stored_filter_data){
                $check_and_replace($stored_filter_data);
            }
        }

        return $latest_filter;
    }

    /**
    *   Generates a filter priority based on the dependencies passed, and the filter hook.
    *   @param string[] $tag                                Filter hook tag of the hook we want the latest filter from.
    *   @param string[] $dependencies                       Array of dependencies filters ids.
    *   @param int $default                                 Default priority.
    */
    static public function generate_filter_priority($tag, $dependencies, $default = 10){
        $latest_dependency = self::get_latest_filter($tag, $dependencies);
        return $latest_dependency ? $latest_dependency['priority'] : $default;
    }

}
