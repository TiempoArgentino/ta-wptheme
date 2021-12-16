<?php

$rb_bootstrap_column_grid = new RB_Gutenberg_Block('rb-bootstrap/grid');
$rb_bootstrap_column_grid->register_attributes( array(
	'preview'	=> array(
		'type'		=>	'string',
		'default'	=>	'xs',
	),
	'columns'	=> array(
		'type'		=>	'int',
		'default'	=>	2,
	),
	'css_classes'	=> array(
		'type'		=>	'string',
		'default'	=>	'',
	),
	'use_container'	=> array(
		'type'		=> 'bool',
		'default'	=> false,
	),
));
$rb_bootstrap_column_grid->register_render_callback(function($attributes, $content = ''){
	extract($attributes);
	$class = $css_classes;
	if($use_container)
		$class = "container $css_classes";

	ob_start();
	?>
	<div class="<?php echo esc_attr($class); ?>">
		<div class="row">
			<?php echo $content; ?>
		</div>
	</div>
	<?php
	//rb_get_template_part('parts/blocks/edicion-impresa/block', '', ['block-attributes' => $attributes, 'content' => $content]);
	return ob_get_clean();
});
$rb_bootstrap_column_grid->complete();
