<?php
/**
*	Articles block
*	@param TA_Article_Data|mixed[] articles									    Array of articles instances. Mixed if articles_type is set
*	@param mixed[] articles_data									            Articles data used to generate articles using the factory method
*                                                                               if articles are not provided directly. Each one has a `data` and `type` keys
*	@param string articles_type													Generalizes all articles in the articles attr array as of this type.
*/
return array(
	'id'					=> 'ta/mow',
	'attributes'			=> array_merge(
		array(
			'mow_code'			=> array(
				'type'					=> 'string',
				'default'				=> '',
			),
			'use_container'	=> array(
				'type'			=> 'boolean',
				'default'		=> true,
			),
			'container'			=> array(
				'type'					=> 'object',
				'default'				=> [
					'header_type'			=> 'common',
					'color_context'			=> 'dark-blue',
					'title'					=> 'Tiempo Audiovisual',
					'header_link'			=> '',
					'use_term_format'		=> false,
				],
			),
		)
	),
	'render_callback'	=> function($attributes, $content = ''){
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'block-template.php';
		return ob_get_clean();
	},
);
