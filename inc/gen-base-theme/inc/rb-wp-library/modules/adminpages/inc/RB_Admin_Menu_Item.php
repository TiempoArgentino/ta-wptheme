<?php
/*The RB_Admin_Menu_Item is an abstract class that contains properties and methods
used in both a submenu item and a submenu page*/
abstract class RB_Admin_Menu_Item{
    protected $hook;
    protected $on_page_callbacks = array();

    // =============================================================================
    // ON HOOK CREATED
    // =============================================================================
    //Functions to run when the hook is available.
    protected function on_hook_created(){
        RB_Admin_Panel_Manager::call_on_page($this->hook, array($this, 'on_page'));
    }

    // =========================================================================
    // ON PAGE LOAD
    // =========================================================================
    //Add a function to be run when this page gets load
    public function add_on_page_callback($callback){
        if(is_callable($callback))
            array_push($this->on_page_callbacks, $callback);
    }

    public function on_page(){
        foreach($this->on_page_callbacks as $callback)
            $callback();
    }

    // =========================================================================
    // GETTERS
    // =========================================================================
    public function get_hook(){
        return $this->hook;
    }
}
