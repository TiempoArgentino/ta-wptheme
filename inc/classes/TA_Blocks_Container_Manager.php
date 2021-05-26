<?php
/**
*   Manages the container of blocks in any template. It's mostly used to take out
*   of containers the blocks that need to be full width   
*/
class TA_Blocks_Container_Manager{
    static private $open_containers = [];
    static private $closed_containers = [];

    static public function is_inside_container(){
        return isset(self::$open_containers[0]);
    }

    /**
    *   Opens a new container element
    *   @param string $container_class                                          The element class
    */
    static public function open_new($container_class = ''){
        $container = new TA_Blocks_Container($container_class);
        if($container->open()){
            array_push(self::$open_containers, $container);
            return true;
        }
        return false;
    }

    /**
    *   Closes the last opened conainer
    */
    static public function close(){
        $container = end(self::$open_containers);
        if($container && $container->close()){
            $container = array_pop(self::$open_containers);
            array_push(self::$closed_containers, $container);
            return true;
        }
        return false;
    }

    /**
    *   Reopens the last closed container
    */
    static public function reopen(){
        $container = end(self::$closed_containers);
        if($container && $container->open()){
            $container = array_pop(self::$closed_containers);
            array_push(self::$open_containers, $container);
            return true;
        }
        return false;
    }
}
