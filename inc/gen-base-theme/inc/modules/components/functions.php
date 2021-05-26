<?php

function gen_get_component($name){
	return GEN_Components_Manager::get_component($name);
}

function gen_render_component($name, $view_args = array(), $controller_args = array()){
	$component = gen_get_component($name);
	$component ? $component->render($view_args, $controller_args) : false;
}
