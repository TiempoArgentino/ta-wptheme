<?php
global $ta_articles_previews_shown;
$ta_articles_previews_shown = [];

require_once plugin_dir_path( __FILE__ ) . 'functions.php';

/**
*	Article preview block
*	@param TA_Article_Data article												The article intance. If passed, is used instead of article_data and article_type
*	@param string article_data													The article data used to generate the instnace
*	@param string article_type													Type of article. Used by the factory method to identify article class to use
*/
return array(
	'id'					=> 'ta/article-preview',
	'attributes'			=> array(
		'article'	=> array(
			'type'				=> 'object',
			'default'			=> null,
		),
		'article_data'	=> array(
			'type'				=> 'string',
			'default'			=> null,
		),
		'article_type'	=> array(
			'type'				=> 'string',
			'default'			=> 'article_post',
		),
		'layout'	=> array(
			'type'			=> 'string',
			'default'		=> 'common',
		),
		'desktop_horizontal' => array(
			'type'				=> 'bool',
			'default'			=> false,
		),
		'class'				=> array(
			'type'				=> 'string',
			'default'			=> '',
		),
		'show_authors'	=> array(
			'type'			=> 'bool',
			'default'		=> true,
		),
		'deactivate_opinion_layout'	=> array(
			'type'				=> 'boolean',
			'default'			=> false,
		),
	),
	'render_callback'	=> function($attributes, $content = ''){
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'block-template.php';
		return ob_get_clean();
	},
);
