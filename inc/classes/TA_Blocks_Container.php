<?php

/**
*   Manages a container element render
*/
class TA_Blocks_Container{
    private $container_class = '';
    private $is_open = false;

    /**
    *   @param string $container_class                                          The html element class
    */
    public function __construct($container_class = ''){
        $this->container_class = $container_class;
    }

    public function open(){
        if($this->is_open)
            return false;
        $this->is_open = true;
        ?><div class="container <?php echo esc_attr($this->container_class); ?>"><?php
        return true;
    }

    public function close(){
        if(!$this->is_open)
            return false;
        $this->is_open = false;
        ?></div><?php
        return true;
    }
}
