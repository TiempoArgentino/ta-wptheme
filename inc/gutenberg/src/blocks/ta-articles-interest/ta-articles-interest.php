<?php
/**
*	Articles block based on user intereset from content balancer
*	@param string title                                                         Containers title
*/
return array(
	'id'					=> 'ta/articles-interest',
	'attributes'			=> array(
		'title'	    => array(
			'type'                => 'string',
			'default'             => 'Según tus intereses',
		),
	    'color_context'		=> array(
	        'type'		=> 'string',
	        'default'	=> '',
	    ),
		'use_container'	=> array(
			'type'			=> 'bool',
			'default'		=> false,
		),
	),
	'render_callback'	=> function($attributes, $content = ''){
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'block-template.php';
		return ob_get_clean();
	},
);
