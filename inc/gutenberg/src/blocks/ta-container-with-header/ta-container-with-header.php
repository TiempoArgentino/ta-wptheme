<?php
/**
*	Bloque de contenedor con titulo.
*	Acepta contenido interno.
*	Attributes:
*	@param string title															Titulo del contenedor
*	@param string title_link													Link del titulo
*/
return array(
	'id'					=> 'ta/container-with-header',
	'attributes'			=> array(
		'title'	=> array(
			'type'		=> 'string',
			'default'	=> '',
		),
		'title_link'	=> array(
			'type'		=> 'string',
			'default'	=> '',
		),
		'header_type'	=> array(
			'type'		=> 'string',
			'default'	=> 'common',
		),
		'class'				=> array(
			'type'		=> 'string',
			'default'	=> '',
		),
		'break_container'	=> array(
			'type'		=> 'bool',
			'default'	=> true,
		),
		'footer'		=> array(
			'type'		=> 'string',
			'default'	=> '',
		),
		'header_right'		=> array(
			'type'		=> 'string',
			'default'	=> '',
		),
		'color_context'		=> array(
			'type'		=> 'string',
			'default'	=> '',
		),
	),
	'render_callback'	=> function($attributes, $content = ''){
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'block-template.php';
		return ob_get_clean();
	},
);
