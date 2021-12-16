<?php
define('TA_ARTICLES_CELLS_COUNT_VARNAME', 'ta_article_preview_cell_count');

require_once plugin_dir_path( __FILE__ ) . 'functions.php';
require_once plugin_dir_path(__FILE__) . '/classes/TAArticlesBlockRow.php';
require_once plugin_dir_path(__FILE__) . '/classes/TAArticlesCommonRow.php';
require_once plugin_dir_path(__FILE__) . '/classes/TAArticlesMiscelaneaRow.php';
require_once plugin_dir_path(__FILE__) . '/classes/TAArticlesSliderRow.php';

add_theme_support( 'align-wide' );
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
			'micrositios'       => true,
			'sections'          => true,
			'tags'              => true,
			'authors'           => true,
		)),
		array(
			'rows'			=> array(
				'type'					=> 'array',
				'default'				=> [
					// [
					// 	'format'	=> 'miscelanea',
					// 	'cells'		=> null,
					// ],
				],
			),
			'container'			=> array(
				'type'					=> 'object',
				'default'				=> [
					'header_type'			=> 'common',
					'color_context'			=> 'common',
					'title'					=> '',
					'header_link'			=> '',
					'use_term_format'		=> false,
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
			'use_container'	=> array(
				'type'			=> 'boolean',
				'default'		=> false,
			),
			'most_recent'	=> array(
				'type'			=> 'boolean',
				'default'		=> true,
			),
			'footer'		=> array(
		        'type'		=> 'string',
		        'default'	=> '',
		    ),
		)
	),
	'render_callback'	=> function($attributes, $content = ''){
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'block-template.php';
		return ob_get_clean();
	},
);
