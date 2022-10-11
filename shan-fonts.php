<?php
add_action( 'wp_enqueue_scripts', 'shan_fonts_scripts', 30);
add_action( 'enqueue_block_editor_assets', 'shan_fonts_scripts', 30);

function shan_fonts_scripts() {

	$admin_head_selectors = '';
	$admin_body_selectors = '';
	
	if( is_admin()) {
		$admin_head_selectors = ".editor-post-title__block .editor-post-title__input,";
		$admin_body_selectors = ".editor-styles-wrapper > *, .editor-styles-wrapper p, .editor-styles-wrapper ol, .editor-styles-wrapper ul, .editor-styles-wrapper cite, .editor-styles-wrapper figcaption, .editor-styles-wrapper .wp-caption-text,";
	}

	$fonts = shan_fonts_get_fonts();
	$is_enabled = ( get_option( 'shan_fonts_is_enabled' ) );
	$is_google_font = ( get_option( 'shan_fonts_is_google_fonts' ) );
	$weight = get_option( 'shan_fonts_weight' );
	$selectors = get_option( 'shan_fonts_selectors' );
	$is_important = ( get_option( 'shan_fonts_is_important' ) );
	$font_styles = '';

	if($is_google_font) {
		$font = preg_replace('!\s+!', ' ', get_option( 'shan_fonts_google_font_name' ));
	} else {
		$font = get_option( 'shan_fonts_font' );
	}

	if( $is_enabled && ( $font !== FALSE ) && ( $font != '' ) ) {

		if( $selectors != '' )
			$font_styles = $admin_head_selectors . $selectors;
			
		$other_font = ',sans-serif';
		if($font == 'noto-sans-thai')
			$other_font = ',noto-sans,sans-serif';
		if($font == 'noto-serif-thai')
			$other_font = ',noto-serif,sans-serif';

		$font_family = '"' . $font . '"' . $other_font . ( $is_important ? ' !important' : '' );
		$font_styles .= '{font-family: '. $font_family . ';';
		if( $weight != '' )
			$font_styles .= ' font-weight: '.$weight.( $is_important ? ' !important' : '' ).';';
		$font_styles .= ' }';

		// Add CSS Var
		$font_styles .= 'body {--s-heading:' . $font_family . '}';
		$font_styles .= 'body {--s-heading-weight:' . $weight . '}';

		if( $is_google_font ) {
			if( $weight != '' )				
				wp_enqueue_style( 'shan-fonts-all', 'https://fonts.googleapis.com/css?family='.$font.':'.$weight, false ); 
			else
				wp_enqueue_style( 'shan-fonts-all', 'https://fonts.googleapis.com/css?family='.$font, false ); 
		} else {
			$upload_dir = wp_upload_dir();
			if( file_exists( get_stylesheet_directory() . '/vendor/fonts/' . $font ) && is_dir( get_stylesheet_directory() . '/vendor/fonts/' . $font ) ) {
				wp_enqueue_style( 'shan-fonts-all', get_stylesheet_directory_uri() . '/vendor/fonts/' . $font . '/font.css' , array(  ) );
			} elseif( file_exists( $upload_dir['basedir'] . '/fonts/'  . $font ) && is_dir( $upload_dir['basedir'] . '/fonts/' . $font ) ) {
				wp_enqueue_style( 'shan-fonts-all', $upload_dir['baseurl'] . '/fonts/'  . $font . '/font.css' , array(  ) );
			} else {
				wp_enqueue_style( 'shan-fonts-all', plugin_dir_url( __FILE__ ) . 'fonts/' . $font . '/font.css' , array(  ) );
			}
		}

		wp_add_inline_style( 'shan-fonts-all', $font_styles );
	}

	$body_is_enabled = ( get_option( 'shan_fonts_body_is_enabled' ) );
	$body_is_google_font = ( get_option( 'shan_fonts_body_is_google_fonts' ) );
	$body_weight = get_option( 'shan_fonts_body_weight' );
	$body_size = get_option( 'shan_fonts_body_size' );
	$body_size_unit = get_option( 'shan_fonts_body_size_unit' );
	$body_lineheight = get_option( 'shan_fonts_body_lineheight' );
	$body_selectors = get_option( 'shan_fonts_body_selectors' );
	$body_is_important = ( get_option( 'shan_fonts_body_is_important' ) );
	$body_font_styles = '';

	if($body_is_google_font) {
		$body_font = preg_replace('!\s+!', ' ', get_option( 'shan_fonts_body_google_font_name' ));
	} else {
		$body_font = get_option( 'shan_fonts_body_font' );
	}

	if( $body_is_enabled && ( $body_font !== FALSE ) && ( $body_font != '' ) ) {

		if( $body_selectors != '' ) {
			$body_font_styles = $admin_body_selectors . $body_selectors;
		}
		$body_other_font = ',sans-serif';
		if($body_font == 'noto-sans-thai') {
			$body_other_font = ',noto-sans,sans-serif';
		}
		if($body_font == 'noto-serif-thai') {
			$body_other_font = ',noto-serif,sans-serif';
		}
		
		$body_font_family = '"' . $body_font . '"' . $body_other_font . ( $body_is_important ? ' !important' : '' );
		$body_font_styles .= '{font-family: '. $body_font_family . ';';
		if( $body_weight != '' ) {
			$body_font_styles .= ' font-weight: '.$body_weight.( $body_is_important ? ' !important' : '' ).';';
		}
		if( $body_size != '' ) {
			$body_font_styles .= ' font-size: '.$body_size.$body_size_unit.( $body_is_important ? ' !important' : '' ).';';
		}
		if( $body_lineheight != '' ) {
			$body_font_styles .= ' line-height: '.$body_lineheight.( $body_is_important ? ' !important' : '' ).';';
		}
		$body_font_styles .= ' }';

		// Add CSS Var
		$body_font_styles .= 'body {--s-body:' . $body_font_family . ';';
		$body_font_styles .= '--s-body-line-height:' . $body_lineheight . ';';
		$body_font_styles .= '}';

		if( $body_is_google_font ) {
			if( $body_weight != '' )				
				wp_enqueue_style( 'shan-fonts-body-all', 'https://fonts.googleapis.com/css?family='.$body_font.':'.$body_weight, false );
			else
				wp_enqueue_style( 'shan-fonts-body-all', 'https://fonts.googleapis.com/css?family='.$body_font, false );
		} else {
			$upload_dir = wp_upload_dir();
			if( file_exists( get_stylesheet_directory() . '/vendor/fonts/' . $body_font ) && is_dir( get_stylesheet_directory() . '/vendor/fonts/' . $body_font ) ) {
				wp_enqueue_style( 'shan-fonts-body-all', get_stylesheet_directory_uri() . '/vendor/fonts/' . $body_font . '/font.css' , array(  ) );
			} elseif( file_exists( $upload_dir['basedir'] . '/fonts/' . $body_font ) && is_dir( $upload_dir['basedir'] . '/fonts/' . $body_font ) ) {
				wp_enqueue_style( 'shan-fonts-body-all', $upload_dir['baseurl'] . '/fonts/' . $body_font . '/font.css' , array(  ) );
			} else {
				wp_enqueue_style( 'shan-fonts-body-all', plugin_dir_url( __FILE__ ) . 'fonts/' . $body_font . '/font.css' , array(  ) );
			}
		}
		wp_add_inline_style( 'shan-fonts-body-all', $body_font_styles );
	}
}

add_action( 'admin_menu', 'shan_fonts_setup_menu' );

function shan_fonts_setup_menu() {
	$shan_font_page = add_submenu_page ( 'themes.php', __( 'shan Fonts', 'shan-fonts' ), __( 'Fonts', 'shan-fonts' ), 'manage_options', 'shan-fonts', 'shan_fonts_init' );

	add_action( 'load-' . $shan_font_page, 'shan_fonts_admin_styles' );
}

function shan_fonts_admin_styles() {
	wp_enqueue_style( 'shan-fonts', plugin_dir_url( __FILE__ ) . 'shan-fonts-admin.css' , array(), '2018-1' );
	wp_enqueue_script( 'shan-fonts', plugin_dir_url( __FILE__ ) . 'shan-fonts-admin.js' , array( 'jquery', 'jquery-ui-tabs' ), '2018-1', true );
}

function shan_fonts_init() { ?>

<div class="wrap">
    <div class="icon32" id="icon-options-general"></div>
    <h2><?php esc_html_e( 'shan Fonts', 'shan-fonts' ); ?></h2>

    <?php
	if( isset( $_GET['settings-updated'] ) ) {
		?><div class="updated">
        <p><strong><?php esc_html_e( 'Settings updated successfully.', 'shan-fonts' ); ?></strong>
    </div><?php
	}
	?>
    <p>
        <?php printf( wp_kses( __( 'This plugin for easy using Shan\'s fonts in wordpress. For more information, please visit <a href="%1$s" target="_blank">shan Fonts by shanfont.com</a>', 'shan-fonts' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://shanfont.com/' ) ); ?>
    </p>
    <form action="<?php echo admin_url( 'options.php' ); ?>" method="post" id="shan-fonts-form">
        <div id="shan-fonts-tabs">
            <ul class="wp-clearfix">
                <li><a href="#shan-fonts-header"><?php esc_html_e( 'Heading', 'shan-fonts' ); ?></a></li>
                <li><a href="#shan-fonts-body"><?php esc_html_e( 'Body', 'shan-fonts' ); ?></a></li>
            </ul>

            <div class="dummy">
                <?php
				settings_fields( 'shan-fonts' );
				do_settings_sections( 'shan-fonts' );
				?>
            </div>

            <?php submit_button(); ?>

        </div>

        <?php shan_fonts_hidden_weight_options(); ?>
    </form>
</div>

<?php }

/**
 * Put font weight options
 *
 * @since 0.10.0
 */
function shan_fonts_hidden_weight_options() {


	$fonts = shan_fonts_get_fonts();

	foreach( $fonts as $_font => $_font_desc ) { 
		?>
<select id="shan-fonts-<?php esc_html_e( $_font, 'shan-fonts' ); ?>-weights" style="display:none">
    <option value=""></option><?php
			foreach( $_font_desc["weights"] as $_weight ) { ?>
    <option value="<?php esc_html_e( $_weight, 'shan-fonts' ); ?>"><?php esc_html_e( $_weight, 'shan-fonts' ); ?>
    </option><?php		
		} ?>
</select> <?php
	}

	echo '<select id="shan-fonts-all-weights" style="display:none">
	<option value=""></option>
	<option value="100">Thin 100</option>
	<option value="200">Extra Light 200</option>
	<option value="300" selected="selected">Light 300</option>
	<option value="400">Regular 400</option>
	<option value="500">Medium 500</option>
	<option value="600">Semi-Bold 600</option>
	<option value="700">Bold 700</option>
	<option value="800">Extra-Bold 800</option>
	<option value="900">Black 900</option>
	</select>';
}

/**
 * Get the list of bundled fonts
 *
 * @since 0.10.0
 * @return array
 */
function shan_fonts_get_fonts() {
	$loop = __(' (Thai Loop)', 'shan-fonts');

	$fonts = array(
		"Panglong" => array(
			"font"    => "panglong",
			"weights" => array( 400 )
		),
		"Shan" => array(
			"font" => "Shan",
			"weights" => array(400, 600, 900)
		),
		"NamKhone" => array(
			"font" => "NamKhone",
			"weights" => array(400)
		)
	);

	// This is where we add custom fonts
	if ( file_exists( get_stylesheet_directory() . '/vendor/fonts' ) && is_dir( get_stylesheet_directory() . '/vendor/fonts' ) ) {
		$d_handle = opendir( get_stylesheet_directory() . '/vendor/fonts' );
		while ( false !== ( $entry = readdir( $d_handle ) ) ) {
			if ( is_dir( get_stylesheet_directory() . '/vendor/fonts/' . $entry ) && ( file_exists( get_stylesheet_directory() . '/vendor/fonts/' . $entry . '/font.css' ) ) ) {
				$headers = get_file_data( get_stylesheet_directory() . '/vendor/fonts/' . $entry . '/font.css', array(
					'font'    => 'Font Name',
					'weights' => 'Weights'
				) );
				$_font = array(
					'font'    => empty( $headers['font'] ) ? $entry : $headers['font'],
					'weights' => empty( $headers['weights'] ) ? array() : array_map( 'trim', explode( ',', $headers['weights'] ) ),
				);
				$fonts[ $entry ] = $_font;
			}
		}
	}
	// add more custom fonts from /upload/fonts/
	$upload_dir = wp_upload_dir();
	if ( file_exists( $upload_dir['basedir'] . '/fonts/' ) && is_dir( $upload_dir['basedir'] . '/fonts/' ) ) {
		$d_handle = opendir( $upload_dir['basedir'] . '/fonts/'  );
		while ( false !== ( $entry = readdir( $d_handle ) ) ) {
			if ( is_dir( $upload_dir['basedir'] . '/fonts/'  . $entry ) && ( file_exists( $upload_dir['basedir'] . '/fonts/'  . $entry . '/font.css' ) ) ) {
				$headers = get_file_data( $upload_dir['basedir'] . '/fonts/'  . $entry . '/font.css', array(
					'font'    => 'Font Name',
					'weights' => 'Weights'
				) );
				$_font = array(
					'font'    => empty( $headers['font'] ) ? $entry : $headers['font'],
					'weights' => empty( $headers['weights'] ) ? array() : array_map( 'trim', explode( ',', $headers['weights'] ) ),
				);
				$fonts[ $entry ] = $_font;
			}
		}
	}

	return apply_filters( 'shan_fonts_fonts', $fonts );

}

/**
 * Get the list of fonts formatted for use in a dropdown
 *
 * @since 0.10.0
 * @return array
 */
function shan_fonts_get_fonts_option_list() {

	$list = array();

	foreach ( shan_fonts_get_fonts() as $id => $data ) {
		$list[ $id ] = $data['font'];
	}

	return $list;

}

/**
 * Get the list of font weights formatted for use in a dropdown
 *
 * @since 0.10.0
 *
 * @param string $font Name of the font
 *
 * @return array
 */
function shan_fonts_get_fonts_weights_option_list( $font , $is_google_fonts) {
	$font = shan_fonts_get_font( $font );
	if ( ($is_google_fonts) || (! isset( $font['weights'] )) || empty( $font['weights'] ) ) {
		return array(
			'' => '',
			100 => 'Thin 100',
			200 => 'Extra Light 200',
			300 => 'Light 300',
			400 => 'Regular 400',
			500 => 'Medium 500',
			600 => 'Semi-Bold 600',
			700 => 'Bold 700',
			800 => 'Extra-Bold 800',
			900 => 'Black 900',
		);
	}

	$list = array( "" => "" );

	foreach ( $font['weights'] as $weight ) {
		$list[ $weight ] = $weight;
	}

	return $list;

}

/**
 * Get font data
 *
 * @since 0.10.0
 *
 * @param string $font Name of the font to retrieve
 *
 * @return bool|array
 */
function shan_fonts_get_font( $font ) {

	if ( empty( $font ) ) {
		return false;
	}

	$fonts = shan_fonts_get_fonts();

	if ( array_key_exists( $font, $fonts ) ) {
		return $fonts[ $font ];
	}

	return false;

}

/**
 * Quick helper function that prefixes an option ID
 *
 * This makes it easier to maintain and makes it super easy to change the options prefix without breaking the options
 * registered with the Settings API.
 *
 * @since 0.10.0
 *
 * @param string $name Unprefixed name of the option
 *
 * @return string
 */
function shan_fonts_get_option_id( $name ) {
	return 'shan_fonts_' . $name;
}

/**
 * Get the plugin settings in header tab
 *
 * @since 0.10.0
 * @return array
 */
function shan_fonts_get_header_settings() {

	$settings = array(
		array(
			'id'      => 'shan-fonts-header',
			'title'   => __( 'Fonts Settings - Heading', 'shan-fonts' ),
			'options' => array(
				array(
					'id'      => shan_fonts_get_option_id( 'is_enabled' ),
					'title'   => esc_html__( 'Enable Heading Font?', 'shan-fonts' ),
					'type'    => 'checkbox',
					'options' => array( 'on' => esc_html__( 'Yes', 'shan-fonts' ) )
				),
				array(
					'id'      => shan_fonts_get_option_id( 'is_google_fonts' ),
					'title'   => esc_html__( 'Use Google Fonts?', 'shan-fonts' ),
					'type'    => 'checkbox',
					'options' => array( 'on' => esc_html__( 'Yes', 'shan-fonts' ) )
				),
				array(
					'id'      => shan_fonts_get_option_id( 'google_font_name' ),
					'title'   => esc_html__( 'Google Font Name', 'shan-fonts' ),
					'type'    => 'text',
					'desc'    => wp_kses( sprintf( __( 'Use font name from <a href="%1$s" target="_blank">fonts.google.com</a>, such as <b>Noto Sans Myanmar</b>, <b>Noto Serif Myanmar</b> (case-sensitive).', 'shan-fonts' ), esc_url( 'https://fonts.google.com/' ) ), array(
						'a' => array(
							'href'   => array(),
							'target' => array()
						),
						'b' => array()
					) ),
					'default' => esc_html__( 'Open Sans', 'shan-fonts' ),
				),
				array(
					'id'      => shan_fonts_get_option_id( 'font' ),
					'title'   => esc_html__( 'Bundled Font', 'shan-fonts' ),
					'type'    => 'dropdown',
					'options' => shan_fonts_get_fonts_option_list()
				),
				array(
					'id'      => shan_fonts_get_option_id( 'weight' ),
					'title'   => esc_html__( 'Weight', 'shan-fonts' ),
					'desc'    => esc_html__( 'Many fonts have only Regular (400) and Bold (700).', 'shan-fonts' ),
					'type'    => 'dropdown',
					'options' => shan_fonts_get_fonts_weights_option_list( get_option( 'shan_fonts_font' ) , get_option( 'shan_fonts_is_google_fonts' ))
				),
				array(
					'id'      => shan_fonts_get_option_id( 'selectors' ),
					'title'   => esc_html__( 'Selectors', 'shan-fonts' ),
					'type'    => 'text',
					'desc'    => wp_kses( __( 'Separate selectors with commas such as <b>h1, h2, .button</b>.', 'shan-fonts' ), array(
						'a' => array(
							'href'   => array(),
							'target' => array()
						),
						'b' => array()
					) ),
					'default' => 'h1, h2, h3, h4, h5, h6, nav, .nav, .menu, button, .button, .btn, .price, ._heading, .wp-block-pullquote blockquote, blockquote, label, legend'
				),
				array(
					'id'      => shan_fonts_get_option_id( 'is_important' ),
					'title'   => esc_html__( 'Force Using This Font?', 'shan-fonts' ),
					'type'    => 'checkbox',
					'options' => array( 'on' => esc_html__( 'Yes (!important added)', 'shan-fonts' ) )
				),
				array(
					'id'       => shan_fonts_get_option_id( 'css-generated' ),
					'title'    => esc_html__( 'Generated CSS', 'shan-fonts' ),
					'type'     => 'textarea_code'
				),
			),
		),
	);

	return $settings;

}

/**
 * Get the plugin settings in body tab
 *
 * @since 0.10.0
 * @return array
 */
function shan_fonts_get_body_settings() {

	$settings = array(
		array(
			'id'      => 'shan-fonts-body',
			'title'   => __( 'Fonts Settings - Body', 'shan-fonts' ),
			'options' => array(
				array(
					'id'      => shan_fonts_get_option_id( 'body_is_enabled' ),
					'title'   => esc_html__( 'Enable Body Font?', 'shan-fonts' ),
					'type'    => 'checkbox',
					'options' => array( 'on' => esc_html__( 'Yes', 'shan-fonts' ) )
				),
				array(
					'id'      => shan_fonts_get_option_id( 'body_is_google_fonts' ),
					'title'   => esc_html__( 'Use Google Fonts?', 'shan-fonts' ),
					'type'    => 'checkbox',
					'options' => array( 'on' => esc_html__( 'Yes', 'shan-fonts' ) )
				),
				array(
					'id'      => shan_fonts_get_option_id( 'body_google_font_name' ),
					'title'   => esc_html__( 'Google Font Name', 'shan-fonts' ),
					'type'    => 'text',
					'desc'    => wp_kses( sprintf( __( 'Use font name from <a href="%1$s" target="_blank">fonts.google.com</a>, such as <b>Roboto</b>, <b>Open Sans</b> (case-sensitive).', 'shan-fonts' ), esc_url( 'https://fonts.google.com/' ) ), array(
						'a' => array(
							'href'   => array(),
							'target' => array()
						),
						'b' => array()
					) ),
					'default' => esc_html__( 'Open Sans', 'shan-fonts' ),
				),
				array(
					'id'      => shan_fonts_get_option_id( 'body_font' ),
					'title'   => esc_html__( 'Bundled Font', 'shan-fonts' ),
					'type'    => 'dropdown',
					'options' => shan_fonts_get_fonts_option_list(),
				),
				array(
					'id'      => shan_fonts_get_option_id( 'body_weight' ),
					'title'   => esc_html__( 'Weight', 'shan-fonts' ),
					'desc'    => esc_html__( 'Many fonts have only Regular (400), not Light (300).', 'shan-fonts' ),
					'type'    => 'dropdown',
					'options' => array(
						'' => '',
						300 => 'Light 300',
						400 => 'Regular 400',
					)
				),
				array(
					'id'      => shan_fonts_get_option_id( 'body_size' ),
					'title'   => esc_html__( 'Size', 'shan-fonts' ),
					'type'    => 'text',
					'default' => '16'
				),
				array(
					'id'      => shan_fonts_get_option_id( 'body_size_unit' ),
					'title'   => esc_html__( 'Size Unit', 'shan-fonts' ),
					'type'    => 'dropdown',
					'options' => array( 'px' => esc_html__( 'px', 'shan-fonts' ), 'em' => esc_html__( 'em', 'shan-fonts' ), '%' => esc_html__( '%', 'shan-fonts' ) ),
					'default' => 'px'
				),
				
				array(
					'id'      => shan_fonts_get_option_id( 'body_lineheight' ),
					'title'   => esc_html__( 'Line Height', 'shan-fonts' ),
					'type'    => 'text',
					'desc'    => esc_html__( '1.5-1.8 is recommended.', 'shan-fonts' ),
					'default' => '1.6'
				),
				array(
					'id'      => shan_fonts_get_option_id( 'body_selectors' ),
					'title'   => esc_html__( 'Selectors', 'shan-fonts' ),
					'type'    => 'text',
					'desc'    => esc_html__( 'Separate selectors with commas', 'shan-fonts' ),
					'default' => 'body'
				),
				array(
					'id'      => shan_fonts_get_option_id( 'body_is_important' ),
					'title'   => esc_html__( 'Force Using This Font?', 'shan-fonts' ),
					'type'    => 'checkbox',
					'options' => array( 'on' => esc_html__( 'Yes (!important added)', 'shan-fonts' ) )
				),
				array(
					'id'       => shan_fonts_get_option_id( 'body-css-generated' ),
					'title'    => esc_html__( 'Generated CSS', 'shan-fonts' ),
					'type'     => 'textarea_code'
				),
			),
		),
	);

	return $settings;

}

add_action( 'admin_init', 'shan_fonts_register_plugin_settings' );

/**
 * Register plugin settings
 *
 * This function dynamically registers plugin settings.
 *
 * @since 0.10.0
 * @see   shan_fonts_get_settings
 * @return void
 */
function shan_fonts_register_plugin_settings() {

	$header_settings = shan_fonts_get_header_settings();

	foreach ( $header_settings as $key => $section ) {

		/* We add the sections and then loop through the corresponding options */
		add_settings_section( $section['id'], $section['title'], 'shan_fonts_section', 'shan-fonts' );

		/* Get the options now */
		foreach ( $section['options'] as $k => $option ) {

			$field_args = array(
				'name'    => $option['id'],
				'title'   => $option['title'],
				'type'    => $option['type'],
				'desc'    => isset( $option['desc'] ) ? $option['desc'] : '',
				'default' => isset( $option['default'] ) ? $option['default'] : '',
				'options' => isset( $option['options'] ) ? $option['options'] : array(),
				'group'   => 'shan-fonts'
			);

			register_setting( 'shan-fonts', $option['id'] );
			add_settings_field( $option['id'], $option['title'], 'shan_fonts_output_settings_field', 'shan-fonts', $section['id'], $field_args );

		}
	}

	$body_settings = shan_fonts_get_body_settings();

	foreach ( $body_settings as $key => $section ) {

		/* We add the sections and then loop through the corresponding options */
		add_settings_section( $section['id'], $section['title'], 'shan_fonts_section', 'shan-fonts' );

		/* Get the options now */
		foreach ( $section['options'] as $k => $option ) {

			$field_args = array(
				'name'    => $option['id'],
				'title'   => $option['title'],
				'type'    => $option['type'],
				'desc'    => isset( $option['desc'] ) ? $option['desc'] : '',
				'default' => isset( $option['default'] ) ? $option['default'] : '',
				'options' => isset( $option['options'] ) ? $option['options'] : array(),
				'group'   => 'shan-fonts'
			);

			register_setting( 'shan-fonts', $option['id'] );
			add_settings_field( $option['id'], $option['title'], 'shan_fonts_output_settings_field', 'shan-fonts', $section['id'], $field_args );

		}
	}

}

/**
 * Generate new section
 *
 * This callback function set div for a new section
 *
 * @since 0.10.0
 * @see   shan_fonts_register_plugin_settings
 * @return void
 */
function shan_fonts_section( $section ) {
	?>
</div>
<div id="<?php echo $section['id'] ?>">
    <?php
}

/**
 * Generate the option field output
 *
 * @since 0.10.0
 *
 * @param array $option The current option array
 *
 * @return void
 */
function shan_fonts_output_settings_field( $option ) {

	$current    = get_option( $option['name'], $option['default'] );
	$field_type = $option['type'];
	$id         = str_replace( '_', '-', $option['name'] );

	// Because disabling the options when "Enable" is unchecked saved empty values we need to make sure the default is taken into account
	if ( empty( $current ) && ! empty( $option['default'] ) ) {
		$current = $option['default'];
	}

	switch( $field_type ):

	case 'text': 
		?><input type="text" name="<?php echo $option['name']; ?>" id="<?php echo $id; ?>" value="<?php echo $current; ?>"
        class="regular-text" /><?php 
		break;

	case 'checkbox': 
		foreach( $option['options'] as $val => $choice ):

		if ( count( $option['options'] ) > 1 ) {
			$id = "{$id}_{$val}";
		}
		$selected = is_array( $current ) && in_array( $val, $current ) ? 'checked="checked"' : '';  
		?>
    <label for="<?php echo $id; ?>">
        <input type="checkbox" name="<?php echo $option['name']; ?>[]" value="<?php echo $val; ?>"
            id="<?php echo $id; ?>" <?php echo $selected; ?> />
        <?php echo $choice; ?>
    </label>
    <?php endforeach;
	break;

	case 'dropdown': 
	?>
    <label for="<?php echo $option['name']; ?>">
        <select name="<?php echo $option['name']; ?>" id="<?php echo $id; ?>">
            <?php foreach( $option['options'] as $val => $choice ):
			if( $val == $current )
				$selected = 'selected="selected"';
			else
				$selected = ''; ?>
            <option value="<?php echo $val; ?>" <?php echo $selected; ?>><?php echo $choice; ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <?php 
	break;

	case 'textarea':
		if( !$current && isset($option['std']) ) { $current = $option['std']; } 
		?><textarea name="<?php echo $option['name']; ?>" id="<?php echo $id; ?>" rows="8"
        cols="70"><?php echo $current; ?></textarea><?php 
		break;

	case 'textarea_code':
		if( !$current && isset($option['std']) ) { $current = $option['std']; } 
		?><textarea name="<?php echo $option['name']; ?>" id="<?php echo $id; ?>" rows="6" cols="60" class="code"
        readonly><?php echo $current; ?></textarea><?php 
		break;
	
	endswitch;

	// Add the field description
	if ( isset( $option['desc'] ) && $option['desc'] != '' ) {
		echo wp_kses_post( sprintf( '<p class="description">%1$s</p>', $option['desc'] ) );
	};
}

load_plugin_textdomain('shan-fonts', false, basename( dirname( __FILE__ ) ) . '/languages' );
