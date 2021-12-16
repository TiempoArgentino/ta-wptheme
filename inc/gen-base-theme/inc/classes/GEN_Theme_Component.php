<?php

/**
*   Extension of GEN_Component that links the view and controller to the files
*   of a theme component, if it exists.
*/
class GEN_Theme_Component extends GEN_Component{
    /**
    *   @property string[] $dependencies
    *   The name of the components required to use this one
    */
    protected $dependencies = [];
    /**
    *   @property mixed[] $defaults
    *   Array of default parameters to use in the view.php $args variable
    */
    protected $defaults = [];

    /**
    *   @param string $name                                                     Required. Theme component folder name
    *   @throws Exception when required arguments are missing
    *   @throws Exception when the template file view.php doesn't exists in the component folder
    */
    public function __construct($settings = array()) {
        if( !isset($settings['name']) )
            throw new Exception('Missing argument "(string) name" for GEN_Theme_Component. Component folder name must be specified through this parameter.');

        $settings['view'] = array($this, 'theme_component_view');
        $settings['controller'] = array($this, 'theme_component_controller');
        parent::__construct($settings);

        $this->component_name = $settings['name'];
        if( !$this->get_component_file_path("view.php") )
            throw new Exception("Missing \"view.php\" for theme component \"$this->component_name\".");

        $options = $this->get_component_options();
        $this->dependencies = is_array($options['dependencies']) ? $options['dependencies'] : [];
        $this->defaults = is_array($options['defaults']) ? $options['defaults'] : [];
    }

    /**
	*	Returns the path to a component file. It first checks if the file exists
	*	in the child theme. If it doesn't, then returns the path to the parent theme
	*	if it exists
	*	@param string $file_name
	*	@param bool $force_parent												If true, the component file is not searched for in the child theme
	*	@return string path to the file if it exists. Empty string otherwise
	*/
	public function get_component_file_path($file_name, $force_parent = false){
		$file_path = '';
		if(!$force_parent)
			$file_path = GEN_CHILD_COMPONENTS . "/$this->component_name/$file_name";
		if(!file_exists($file_path))
			$file_path = GEN_THEME_COMPONENTS . "/$this->component_name/$file_name";
		return file_exists($file_path) ? $file_path : '';
	}

    /**
    *   @return mixed[] Component options from the options.php file.
    */
    protected function get_component_options(){
        $options_file = self::get_component_file_path("options.php");
        $default_options = array(
            'defaults'				=> [],
            'dependencies'			=> [],
        );
        if( file_exists($options_file) ){
            $options = include $options_file;
            if( is_array($options) ){
                $options = rb_get_value($options, $default_options);
            }
        }
        return apply_filters("gen_component_{$this->component_name}_options", $options);
    }

    /**
    *   Requires the scripts from the components marked as depedencies
    *   @throws Exception if any of the dependencies doesn't exists
    */
    protected function require_dependencies(){
        foreach( $this->dependencies as $dependency_name ){
            $component = GEN_Components_Manager::get_component($dependency_name);
            if(!$component){
                throw new Exception("Component Error: dependency <b>\"$dependency_name\"</b> of component <b>\"$this->component_name\"</b> not found.");
            }
            $component->do_controller();
        }
    }

    /**
    *   Includes the component controller file once
    *   @param mixed[] $args                                                    Array of mixed content accessible from controller.php
    */
    protected function theme_component_controller($args = array()){
        $this->require_dependencies();

        $component_name = $this->component_name;
        $controller_file = $this->get_component_file_path("controller.php");
        if( !file_exists($controller_file) )
            return;

        $include_parent_controller; // for some reason if I dont declare the variable before assigning the function, it is left undefined
        $include_parent_controller = function() use ($component_name, $args){
            $parent_controller = $this->get_component_file_path("controller.php", true);
            if( file_exists( $parent_controller ) )
                include_once $parent_controller;
        };

        include_once $controller_file;
    }

    /**
    *   Includes the component view file
    *   @param mixed[] $args                                                    Array of mixed content accessible from view.php
    */
    protected function theme_component_view($args = array()){
        $component_name = $this->component_name;
        $view_file = $this->get_component_file_path("view.php");
		$args = is_array($args) && !empty($args) ? rb_get_value($args, $this->defaults) : $this->defaults;

        $include_parent_view = function() use ($component_name, $args){
            $parent_view = $this->get_component_file_path("view.php", true);
            if( file_exists( $parent_view ) )
                include $parent_view;
        };

        ob_start();
        require $view_file;
        $view_content = ob_get_clean();
        echo apply_filters("gen_component_{$component_name}_view", $view_content);
    }

}
