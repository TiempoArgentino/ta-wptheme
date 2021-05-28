<?php

class DatosFooter {
	private $datos_footer_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'datos_footer_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'datos_footer_page_init' ) );
	}

	public function datos_footer_add_plugin_page() {
		add_theme_page(
			'Datos Footer', // page_title
			'Datos Footer', // menu_title
			'manage_options', // capability
			'datos-footer', // menu_slug
			array( $this, 'datos_footer_create_admin_page' ) // function
		);
	}

	public function datos_footer_create_admin_page() {
		$this->datos_footer_options = get_option( 'datos_footer_option_name' ); ?>

		<div class="wrap">
			<h2>Datos Footer</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'datos_footer_option_group' );
					do_settings_sections( 'datos-footer-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function datos_footer_page_init() {
		register_setting(
			'datos_footer_option_group', // option_group
			'datos_footer_option_name', // option_name
			array( $this, 'datos_footer_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'datos_footer_setting_section', // id
			'Datos', // title
			array( $this, 'datos_footer_section_info' ), // callback
			'datos-footer-admin' // page
		);

		add_settings_field(
			'direccin_0', // id
			'Dirección', // title
			array( $this, 'direccin_0_callback' ), // callback
			'datos-footer-admin', // page
			'datos_footer_setting_section' // section
		);

		add_settings_field(
			'editores_1', // id
			'Editores', // title
			array( $this, 'editores_1_callback' ), // callback
			'datos-footer-admin', // page
			'datos_footer_setting_section' // section
		);

		add_settings_field(
			'registro_n_o_texto_2', // id
			'Registro (nº o texto)', // title
			array( $this, 'registro_n_o_texto_2_callback' ), // callback
			'datos-footer-admin', // page
			'datos_footer_setting_section' // section
		);

		add_settings_field(
			'n_edicin_3', // id
			'Nº Edición', // title
			array( $this, 'n_edicin_3_callback' ), // callback
			'datos-footer-admin', // page
			'datos_footer_setting_section' // section
		);

		add_settings_field(
			'fecha_4', // id
			'Fecha', // title
			array( $this, 'fecha_4_callback' ), // callback
			'datos-footer-admin', // page
			'datos_footer_setting_section' // section
		);
	}

	public function datos_footer_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['direccin_0'] ) ) {
			$sanitary_values['direccin_0'] = sanitize_text_field( $input['direccin_0'] );
		}

		if ( isset( $input['editores_1'] ) ) {
			$sanitary_values['editores_1'] = sanitize_text_field( $input['editores_1'] );
		}

		if ( isset( $input['registro_n_o_texto_2'] ) ) {
			$sanitary_values['registro_n_o_texto_2'] = sanitize_text_field( $input['registro_n_o_texto_2'] );
		}

		if ( isset( $input['n_edicin_3'] ) ) {
			$sanitary_values['n_edicin_3'] = sanitize_text_field( $input['n_edicin_3'] );
		}

		if ( isset( $input['fecha_4'] ) ) {
			$sanitary_values['fecha_4'] = sanitize_text_field( $input['fecha_4'] );
		}

		return $sanitary_values;
	}

	public function datos_footer_section_info() {
		
	}

	public function direccin_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="datos_footer_option_name[direccin_0]" id="direccin_0" value="%s">',
			isset( $this->datos_footer_options['direccin_0'] ) ? esc_attr( $this->datos_footer_options['direccin_0']) : ''
		);
	}

	public function editores_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="datos_footer_option_name[editores_1]" id="editores_1" value="%s">',
			isset( $this->datos_footer_options['editores_1'] ) ? esc_attr( $this->datos_footer_options['editores_1']) : ''
		);
	}

	public function registro_n_o_texto_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="datos_footer_option_name[registro_n_o_texto_2]" id="registro_n_o_texto_2" value="%s">',
			isset( $this->datos_footer_options['registro_n_o_texto_2'] ) ? esc_attr( $this->datos_footer_options['registro_n_o_texto_2']) : ''
		);
	}

	public function n_edicin_3_callback() {
		printf(
			'<input class="regular-text" type="text" name="datos_footer_option_name[n_edicin_3]" id="n_edicin_3" value="%s">',
			isset( $this->datos_footer_options['n_edicin_3'] ) ? esc_attr( $this->datos_footer_options['n_edicin_3']) : ''
		);
	}

	public function fecha_4_callback() {
		printf(
			'<input class="regular-text" type="text" name="datos_footer_option_name[fecha_4]" id="fecha_4" value="%s">',
			isset( $this->datos_footer_options['fecha_4'] ) ? esc_attr( $this->datos_footer_options['fecha_4']) : ''
		);
	}

}
if ( is_admin() )
	$datos_footer = new DatosFooter();