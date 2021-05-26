<?php
class RB_Roles_Module{

    /**
    *   Stablishes a set of capabilities for a given role
    *   Must be runned before the 'wp_roles_init' action takes place. It doesn't affect the database
    *   directly, so every change made will perdure only if the aaction hook is not removed
    *   @param string $action_id                    Action identifier to store the action
    *   @param string $role                         Role name
    *   @param bool[] $capabilities                 Array of $capability_name => $value
    *   @param int $priority                        Action hook priority
    */
    static public function stablish_capabilities($action_id, $role, $capabilities, $priority = 10){
        $hook_callback = function($wp_roles) use ($role, $capabilities, $action_id){
            if( !is_string($action_id) || !is_string($role) || (!is_array($capabilities) && !empty($capabilities)) )
                return false;
            $role_object = $wp_roles->get_role($role);
            if($role_object){
                foreach($capabilities as $capability_name => $capability_value){
                    $role_object->capabilities[$capability_name] = $capability_value;
                }
                return true;
            }
            return false;
        };

        RB_Filters_Manager::add_action($action_id, 'wp_roles_init', $hook_callback, array(
            'priority'      => $priority,
        ));
    }
}
