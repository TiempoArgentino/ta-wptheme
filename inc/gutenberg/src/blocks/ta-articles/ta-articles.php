<?php
/**
*	Articles block
*	@param TA_Article_Data|mixed[] articles									    Array of articles instances. Mixed if articles_type is set
*	@param mixed[] articles_data									            Articles data used to generate articles using the factory method
*                                                                               if articles are not provided directly. Each one has a `data` and `type` keys
*	@param string articles_type													Generalizes all articles in the articles attr array as of this type.
*/
return array(
	'id'					=> 'ta/articles',
	'attributes'			=> array(
		'articles'	    => array(
			'type'                => 'array',
			'default'             => null,
		),
	    'articles_data' => array(
	        'type'                => 'array',
	        'default'             => null,
	    ),
	    'articles_type'	=> array(
			'type'				=> 'string',
			'default'			=> null,
		),
	    'container_title'   => array(
	        'type'				=> 'string',
	        'default'			=> '',
	    ),
	    'header_right'		=> array(
			'type'		        => 'string',
			'default'	        => '',
		),
	    'color_context'		=> array(
			'type'		=> 'string',
			'default'	=> '',
		),
	    'footer'		=> array(
	        'type'		=> 'string',
	        'default'	=> '',
	    ),
	    'layout'		=> array(
	        'type'		=> 'string',
	        'default'	=> '',
	    ),
		'cells_per_row'	=> array(
			'type'			=> 'int',
			'default'		=> 4,
		),
		'use_container'	=> array(
			'type'			=> 'bool',
			'default'		=> false,
		),
		'show_authors'	=> array(
			'type'			=> 'bool',
			'default'		=> true,
		)
	),
	'render_callback'	=> function($attributes, $content = ''){
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'block-template.php';
		return ob_get_clean();
	},
);
