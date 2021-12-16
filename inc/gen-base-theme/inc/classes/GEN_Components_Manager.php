<?php

/*
*	Keeps track of the theme components used and facilitates components creation and reutilization
*/
class GEN_Components_Manager{
	static private $components = [];

    /**
    *   Devuelve el componente si existe o si se pudo crear
    *   @return GEN_Component|null                                              El componente si existe o si se pudo crear, sino null
    */
	static public function get_component($name){
		$component = self::enqueue_component($name);
        return $component ? $component : null;
	}

    /**
    *   Guarda el componente en $components si esta correctamente creada su estructura
    *   en la carpeta de componentes
    *   @return GEN_Component|false                                             Instancia del componente si existe o si se encolo correctamente
    *                                                                           false si no se pude crear
    */
	static public function enqueue_component($name){
        if( isset(self::$components[$name]) )
            return self::$components[$name];

        return self::$components[$name] = new GEN_Theme_Component(array(
            'name'		=> $name,
        ));
	}
}
