<?php
/**
*	Cita de autor
*	Attributes:
*	@param string quote															El texto citado
*	@param string author													    Nombre del autor de la cita
*/
return array(
	'id'					=> 'ta/quote',
	'attributes'			=> array(
		'quote'	=> array(
			'type'		=> 'string',
			'default'	=> '',
		),
		'author'	=> array(
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
