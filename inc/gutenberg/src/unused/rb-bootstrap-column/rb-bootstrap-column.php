<?php
$breakcodes = ['xs', 'sm', 'md', 'lg', 'xl'];
$rb_bootstrap_column_block = new RB_Gutenberg_Block('rb-bootstrap/column');
$rb_bootstrap_column_block->register_attributes( array(
	'xs-size'		=> array(
		'type'		=> 'int',
		'default'	=> 6,
	),
	'sm-size'		=> array(
		'type'		=> 'int',
		'default'	=> 0,
	),
	'md-size'		=> array(
		'type'		=> 'int',
		'default'	=> 0,
	),
	'lg-size'		=> array(
		'type'		=> 'int',
		'default'	=> 0,
	),
	'xl-size'		=> array(
		'type'		=> 'int',
		'default'	=> 0,
	),
));
$rb_bootstrap_column_block->register_render_callback(function($attributes, $content = '') use ($breakcodes){
	ob_start();
	//extract($attributes);
	$col_class = "";
	foreach($breakcodes as $break_code){
		$col_size = $attributes["$break_code-size"] ? $attributes["$break_code-size"] : 0;
		if($col_size != 0){
			$break_sufix = "-$break_code";
			$size_sufix = "-" . $col_size;
			if($break_code == 'xs')
				$break_sufix = '';
			$col_class .= "col$break_sufix$size_sufix ";
		}
	}
	?>
	<div class="<?php echo $col_class; ?> d-flex flex-column">
		<?php echo $content; ?>
	</div>
	<?php
	//rb_get_template_part('parts/blocks/edicion-impresa/block', '', ['block-attributes' => $attributes, 'content' => $content]);
	return ob_get_clean();
});
$rb_bootstrap_column_block->complete();
