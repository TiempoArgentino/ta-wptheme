<?php
define('TA_ARTICLES_CELLS_COUNT_VARNAME', 'ta_article_preview_cell_count');
/**
*	Articles block
*	@param TA_Article_Data|mixed[] articles									    Array of articles instances. Mixed if articles_type is set
*	@param mixed[] articles_data									            Articles data used to generate articles using the factory method
*                                                                               if articles are not provided directly. Each one has a `data` and `type` keys
*	@param string articles_type													Generalizes all articles in the articles attr array as of this type.
*/
return array(
	'id'					=> 'ta/articles',
	'attributes'			=> array_merge(
		lr_get_article_filters_attributes(array(
			'amount'            => true,
			'most_recent'		=> true,
			'suplements'        => true,
			'sections'          => true,
			'tags'              => true,
			'authors'           => true,
		)),
		array(
			'rows'			=> array(
				'type'					=> 'array',
				'default'				=> [
					[
						'format'	=> 'miscelanea',
						'cells'		=> null,
					],
				],
			),
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
			'cells_per_row'	=> array(
				'type'			=> 'integer',
				'default'		=> 4,
			),
			'use_container'	=> array(
				'type'			=> 'boolean',
				'default'		=> false,
			),
			'show_authors'	=> array(
				'type'			=> 'boolean',
				'default'		=> true,
			),
			'most_recent'	=> array(
				'type'			=> 'boolean',
				'default'		=> true,
			),
		)
	),
	'render_callback'	=> function($attributes, $content = ''){
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'block-template.php';
		return ob_get_clean();
	},
);
