<?php

class GEN_Component{
    protected $view = null;
    protected $controller = null;
    protected $controller_invoked = false;

    /**
    *   @param callable|string $view                                            Required. The component view. Can be a callable function that
    *                                                                           receives arguments, or a string.
    *   @param callable|string $controller                                      Component controller. Can be a callable function that
    *                                                                           receives arguments, or a string.
    */
    public function __construct($settings = array()) {
        $this->view = $settings['view'];
        $this->controller = isset($settings['controller']) ? $settings['controller'] : null;
    }

    public function do_controller($controller_args = array()){
        if( is_callable($this->controller) && !$this->controller_invoked ){
            $this->controller_invoked = true;
            call_user_func($this->controller, $controller_args);
        }
    }

    public function do_view($view_args = array()){
        if(is_callable($this->view))
            call_user_func($this->view, $view_args);
        else if( is_string($this->view) )
            echo $this->view;
    }

    public function render($view_args = array(), $controller_args = array()){
        $this->do_controller($controller_args);
        $this->do_view($view_args);
    }
}
