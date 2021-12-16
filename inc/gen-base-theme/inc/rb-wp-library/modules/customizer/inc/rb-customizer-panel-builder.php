<?php
class RB_Customizer_API{
	public $wp_customize_manager;
	public $sections = array();
	public $configuration_function;

	public function __construct($wp_customize_manager, $configuration_function){
		$this->wp_customize_manager = $wp_customize_manager;
		$this->configuration_function = $configuration_function;
	}

	public function activate_selective_refresh(){

		foreach ( $this->sections as $section ) {
			$dependent_settings = $section->settings_without_selective_refresh();

			// ==========================================================================
			// Associating the section's selective refresh to any setting that doesn't have their own
			// ==========================================================================
			//Selective refresh activated, and there are settings without
			if ( $section->selective_refresh['activated'] && !empty($dependent_settings) ){
				//If it has multiple selectors
				if(is_array($section->selective_refresh['selector'])){
					foreach( $section->selective_refresh['selector'] as $selector => $render_callback){
						$args = $section->selective_refresh;
						$args['render_callback'] = $render_callback;
						$args['selector'] = $selector;

						$this->add_selective_refresh_partial(
							$section->id . md5($selector),
							$dependent_settings,
							$args
						);
					}
				}
				else{//If there is only one selector
					$this->add_selective_refresh_partial(
						$section->id,
						$dependent_settings,
						$section->selective_refresh
					);
				}
			}
			// =============================================================================
			// Creating the partial for every setting that has a selective refresh configuration
			// =============================================================================
			//echo __LINE__ . "\n"; print_r($section->settings_with_selective_refresh()); echo "\n";
			$independent_settings = $section->settings_with_selective_refresh();
			if(is_array($independent_settings)){
				foreach( $independent_settings as $setting ){
					$settings_selective_refresh = $setting->get_all_selective_refresh();
					//Add partial to every selector for wich this setting has a refresh configuration
					foreach( $settings_selective_refresh as $selector => $selective_refresh){
						$this->add_selective_refresh_partial(
							$setting->id . md5($selector),
							array($setting->id),
							$selective_refresh
						);
					}
				}
			}
		}
	}
	/*
	$selective_refresh = array(
		'activated' 		=> true/false,
		'selector'  		=> string,
		'render_callback'	=> function(),
	)
	*/
	public function add_section($name, $options, $selective_refresh = array()){
		if($this->wp_customize_manager)
			$this->wp_customize_manager->add_section($name,$options);
		$section = new RB_Customizer_Section($this->wp_customize_manager, $name, $options, $selective_refresh);
		$this->sections[] = $section;
		return $section;
	}

	public function add_panel($name, $options){
		if($this->wp_customize_manager)
			$this->wp_customize_manager->add_panel( $name, $options);
		return $this;
	}

	public function add_selective_refresh_partial($id, $settings, $args = array()){
		$args['settings'] = $settings;

		if($this->wp_customize_manager)
			$this->wp_customize_manager->selective_refresh->add_partial($id,$args);

		/*print_r($selector);echo "\n";
		print_r($settings);echo "\n";
		print_r($render_callback);echo "\n";*/
	}

	public function get_section( $id ){
		foreach( $this->sections as $section ){
			if ( $section->id == $id )
				return $section;
		}
		return null;
	}

	public function initialize(){
		$this->run_configuration( $this->configuration_function );
		$this->activate_selective_refresh();
	}

	public function run_configuration( $config ){
		$config( $this );
	}

}

class RB_Customizer_Section{
	static public $sections = array();
	public $wp_customize_manager;
	public $id;
	public $options = array();
	public $controls = array();
	public $selective_refresh = array(
		'activated' => false,
		'selector'	=> '',
	);

	public function __construct($wp_customize_manager, $id, $options, $selective_refresh = array()){
		$this->wp_customize_manager = $wp_customize_manager;
		$this->id = $id;
		$this->options = $options;
		$this->selective_refresh = array_merge($this->selective_refresh, $selective_refresh);
		array_push(self::$sections, $this);
	}

	public function add_control($id, $control_class, $settings, $options){
		$options['section'] = $this->id;
		$settings_objects = $this->add_settings( $settings );
		$settings_ids = array_keys( $settings );
		$option_settings = $settings_ids;
		if( count($settings_ids) == 1 ){
			$option_settings = $settings_ids[0];
		}
		$options['settings'] = $option_settings;

		if($this->wp_customize_manager)
			$this->wp_customize_manager->add_control( new $control_class($this->wp_customize_manager,$id,$options) );

		$this->controls[] = new RB_Customizer_Control($id, $control_class, $options, $settings_objects);
		return $this;
	}

	public function add_settings( $settings ){
		$settings_array = array();
		foreach ( $settings as $setting_id => $setting_data ){
			if($this->wp_customize_manager)
				$this->wp_customize_manager->add_setting($setting_id,$setting_data['options']);
			$settings_selective_refresh = isset($setting_data['selective_refresh']) && $setting_data['selective_refresh'] ? $setting_data['selective_refresh'] : array();
			$settings_array[] = new RB_Customizer_Setting($setting_id, $setting_data['options'], $settings_selective_refresh);
		}
		return $settings_array;
	}

	//For every control it has, returns the settings that doesnt have the selective refresh activated
	public function settings_without_selective_refresh(){
		$settings_final = array();
		foreach( $this->controls as $control ){
			$settings_final = array_merge( $settings_final, $control->settings_without_selective_refresh(true) );
		}
		return $settings_final;

	}

	//For every control it has, returns the settings that has the selective refresh activated
	public function settings_with_selective_refresh(){
		$settings_final = array();
		foreach( $this->controls as $control ){
			$settings_final = array_merge( $settings_final, $control->settings_with_selective_refresh() );
		}
		return $settings_final;
	}
}

class RB_Customizer_Control{
	static public $controls = array();
	public $id;
	public $control_class;
	public $options;
	public $settings = array();

	public function __construct($id, $control_class, $options, $settings){
		$this->id = $id;
		$this->settings = $settings;
		$this->control_class = $control_class;
		$this->options = $options;
		array_push(self::$controls, $this);
	}

	//Returns every setting the control is associoted to that doesnt have the selective refresh activated
	public function settings_without_selective_refresh( $id_only = false ){
		$result = array_filter($this->settings, function ($setting) { return !$setting->selective_refresh['activated']; });
		if ( $id_only )
			$result = array_map( function($setting){ return $setting->id;}, $result  );
		return $result;
	}

	//Returns every setting the control is associoted to that has the selective refresh activated
	public function settings_with_selective_refresh( $id_only = false ){
		$result = array_filter($this->settings, function ($setting) {
			return ($setting->selective_refresh['activated'] && !$setting->selective_refresh['prevent']);
		});
		if ( $id_only )
			$result = array_map( $result, function($setting){ return $setting->id;} );
		//print_r($result);
		return $result;
	}

}

class RB_Customizer_Setting{
	static public $settings = array();
	public $id;
	public $options = array();
	public $selective_refresh = array( 'activated' => false, 'prevent' => false );

	public function __construct($id, $options, $selective_refresh = array()){
		$this->id = $id;
		$this->options = $options;
		$this->sanitize_setting_selective_refresh($selective_refresh);
		array_push(self::$settings, $this);
	}

	public function sanitize_setting_selective_refresh($selective_refresh){
		$this->selective_refresh = array_merge($this->selective_refresh, $selective_refresh);
		if(!isset($this->selective_refresh['selector']))
			return false;
		// =============================================================================
		// MULTIPLE SELECTORS
		// =============================================================================
		if(is_array($this->selective_refresh['selector'])){
			foreach($this->selective_refresh['selector'] as $selector => $selector_selective_refresh){
				$this->sanitize_single_selector_resfresh($this->selective_refresh['selector'][$selector], $selector);
			}
		}
		// =============================================================================
		// SINGLE SELECTOR
		// =============================================================================
		else{
			$this->sanitize_single_selector_resfresh($this->selective_refresh, $this->selective_refresh['selector']);
		}
	}

	public function sanitize_single_selector_resfresh(&$selective_refresh, $selector = ''){
		if(!is_array($selective_refresh))
			return null;
		$default_callback = function(){ echo get_theme_mod( $this->id, ''); };
		//Selector
		if(is_string($selector))
			$selective_refresh['selector'] = $selector;
		//Callback. If non was given, a default one will be stored
		$selective_refresh['has_user_callback'] = self::refresh_has_callback($selective_refresh);
		if(!$selective_refresh['has_user_callback'])
			$selective_refresh['render_callback'] = $default_callback;

		return $selective_refresh;
	}

	public function get_all_selective_refresh(){
		if(!isset($this->selective_refresh['selector']))
			return array();

		return is_array($this->selective_refresh['selector']) ? $this->selective_refresh['selector'] :
																array($this->selective_refresh['selector'] => $this->selective_refresh);
	}

	static public function refresh_has_callback($selective_refresh){
		return isset($selective_refresh['render_callback']) && is_callable($selective_refresh['render_callback']) ? true : false;
	}
}
