<?php
if(!class_exists('WP_Customize_Control'))
	return;
	
class RB_Extended_Control extends WP_Customize_Control {
	public $li_classes = "";
	public $label_classes = "";
	public $separator_content = "";
	public $dependents_controls = array(
		'controls'	=> [],//array of strings, with the names of the controls to hidde/show
		'hide_all'	=> false,//if true, it hides all the controls from his section, except self
		'reverse'	=> false,//if true, it hides the dependencies when the input value is true
	);

	public function __construct($manager, $id, $args = array())
	{
		parent::__construct($manager, $id, $args);


		if ( !empty($args["dependents_controls"]) )
			$this->dependents_controls = array_merge($this->dependents_controls, $args["dependents_controls"]);
	}

	public function pre_render(){}

	protected function input_id(){
		return '_customize-input-' . $this->id;
	}

	protected function dependencies_activated(){
		foreach( $this->dependents_controls as $dependencies_option ){
			if( !empty($dependencies_option) )
				return true;
		}
		return false;
	}

	protected function add_control_classes( $classes ){
		$this->li_classes .= ' ' . $classes;
	}

	protected function render_control_panel($title, $content, $options = array()){
		$defaults = array(
			'class'	=> '',
		);
		$settings = array_merge($defaults, $options);
	?>
		<div class="rb-control-panel <?php echo $settings['class']; ?>">
			<div class="panel-overlay"></div>
			<div class="rb-control-panel-title-container">
				<i class="fas fa-chevron-circle-left rb-control-panel-close-button"></i>
				<h5 class="rb-control-panel-title"><?php echo $title; ?></h5>
			</div>
			<?php echo $content; ?>
		</div>
	<?php
	}

	protected function render() {
		$this->pre_render();

		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-' . $this->type . " " . $this->li_classes;

		?>
		<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php if (!empty($this->separator_content)) : ?>
			<div class="controls-separator"><?php echo $this->separator_content; ?></div>
			<?php endif; ?>
			<?php $this->render_content(); ?>
		</li><?php

		if( $this->dependencies_activated() ):
			?>
			<script>
			$(document).ready(function(){
				var dependencies = JSON.parse('<?php echo json_encode($this->dependents_controls); ?>');
				wp.customize('<?php echo $this->id; ?>', function( value ) {
					value.bind( function ( value ) {
						toggle_dependencies('<?php echo $this->id; ?>', '<?php echo $this->input_id(); ?>', dependencies);
					});
				});
				toggle_dependencies('<?php echo $this->id; ?>', '<?php echo $this->input_id(); ?>', dependencies);
			});
			</script>
			<?php
		endif;
	}
}
