<?php


// Facilitates the creation of blocks using create-gutenber-blocks
class RB_Gutenberg_Block{

	/**
	*	@property string The prefix that is used to associate the block with the
	*	create-gutenberg-block scripts
	*/
	private $prefix = '';

	/**
	*	@property mixed[] $register_args										Array of arguments to be used when registering the block
	*/
	public $register_args = array();

	/**
	*	@property string $name													The Block's identifier
	*/
	private $name;

	/**
	*	@property mixed[] $render_args
	*	Argumentes for the current render of the block.
	*		@property mixed[] $attributes										Block attributes
	*		@property string $saved_content										The Block's inner content
	*/
	private $render_args = array(
		'attributes'			=> array(),
		'saved_content'			=> '',
	);

	/**
	*	@property callable $render_callback 									The function used to render the block content from the backend
	*/
	private $render_callback = null;

	/**
	*	@property RB_Gutenberg_Block[] $blocks 									Array of blocks created with this class
	*/
	static private $blocks = array();

	public function __construct($name, $prefix = ''){
		if(!is_string($name))
			return false;

		$this->prefix = $prefix;
		$this->name = $name;
		self::$blocks[$name] = $this;
	}

	static public function get_block($name){
		return isset(self::$blocks[$name]) ? self::$blocks[$name] : null;
	}

	public function complete(){
		add_action( 'init', array($this, 'register_block') );
	}

	public function register_block(){
		register_block_type( $this->name, $this->register_args);
	}

	/**
	*	Stores the attributes for the block
	*/
	public function register_attributes($attributes){
		if(!is_array($attributes))
			return false;

		$this->register_args['attributes'] = $attributes;
		return $this;
	}

	/**
	*	Store a function to be used as a rendered for the block
	*/
	public function register_render_callback($callback){
		if(!is_callable($callback))
			return false;

		$this->render_callback = $callback;
		$this->register_args['render_callback'] = array($this, 'call_render_callback');
		return $this;
	}

	/**
	*	Calls the render callback
	*/
	public function call_render_callback($attributes = array(), $saved_content = ''){
		$this->render_args['attributes'] = rb_get_value($attributes, $this->get_default_attributes());
		$this->render_args['saved_content'] = $saved_content;
		if(is_callable($this->render_callback))
			return call_user_func($this->render_callback, $attributes, $saved_content);
		return '';
	}

	/**
	*	Callback to be used when rendering the block through php, storing attributes and content in the current render_args
	*/
	public function get_content($attributes = array(), $saved_content = null){
		//Calling the render callback function directly because of a bug with gutenberg sanitation.
		return $this->call_render_callback($attributes, $saved_content);
		/*
		*	This is actually how it should be done, but there is a bug with the sanitization of attributes of type object.
		*	An issue has been submited on the gutenberg repo, https://github.com/WordPress/gutenberg/issues/19889
		*	Without this, it is imposible to render regular blocks (only dynamic can be rendered)
		*/
		// return render_block(array(
	    //     'blockName'            => $this->name,
	    //     'attrs'                => rb_get_value($attributes, $this->get_default_attributes()),
	    //     'innerContent'         => $saved_content ? [$saved_content] : [],
		// ));
	}

	public function render($attributes = array(), $saved_content = ''){
		echo $this->get_content($attributes, $saved_content);
	}

	/**
	*	Renders a block if it exists.
	*/
	static public function render_block($name, $attributes = array(), $saved_content = ''){
		$block = self::get_block($name);
		if($block)
			$block->render($attributes, $saved_content);
	}

	public function get_render_attributes(){
		return $this->render_args['attributes'];
	}

	public function get_render_inner_content(){
		return $this->render_args['saved_content'];
	}

	public function get_render_args(){
		return $this->render_args;
	}

	/**
	*	@return array										Attributes array (attrKey => defaultValue). Empty array if there are
	*														no attributes. Default value = null if not setted
	*/
	public function get_default_attributes(){
		$attributes = isset($this->register_args['attributes']) ? $this->register_args['attributes'] : null;
		if(is_array($attributes) && !empty($attributes)){
			return array_map(function($attr){
				return isset($attr['default']) ? $attr['default'] : null;
			}, $attributes);
		}
		return [];
	}

	public function set_front_style($script_name){
		// Enqueue blocks.style.build.css on both frontend & backend.
		$this->register_args['style'] = $script_name;
	}

	public function set_editor_style($script_name){
		// Enqueue blocks.editor.build.css in the editor only.
		$this->register_args['editor_style'] = $script_name;
	}

	public function set_editor_script($script_name){
		// Enqueue blocks.build.js in the editor only.
		$this->register_args['editor_script'] = $script_name;
	}
}
