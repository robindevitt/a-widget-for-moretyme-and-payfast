<?php
/**
 * Moretyme Optionns Call Back.
 *
 * @package MoretymeForPayfast
 */

use MoreTymeForPayfast\MoretymeWidget as MoretymeWidget;

/**
 * Top level menu item callback functions
 */
function options_page_content() {
	// check user capabilities.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated".
		add_settings_error( 'moretyme_message', 'moretyme_message', __( 'Settings Saved', 'rbd' ), 'updated' );
	}

	// show error/update messages.
	settings_errors( 'moretyme_message' );

	echo '<div class="wrap">';
		echo '<h1>' . esc_html( get_admin_page_title() ) . '</h1>';

		echo '<form class="row" action="options.php" method="post">';
			settings_fields( 'moretyme_settings' );
			register_setting(
				__FILE__,
				'moretyme_options',
				array(
					'string',
					'validate_options',
				)
			); // option group, option name, sanitize cb.

			do_settings_sections( 'moretyme_settings' );

			submit_button( 'Save Settings' );
		echo '</form>';

		echo '<div class="moretyme-preview">';
			echo '<p class="row"><strong>' . esc_html__( 'Save your settings will update the preview. You can use the option, enabled for admins only, to preview the widget before making is public.', 'moretyme-for-payfast' ) . '</strong></p>';
			echo MoretymeWidget\moretyme_widget_generate( '1500.00' );
		echo '</div>'; // preview ends.
	echo '</div>'; // Wrap ends.
}

/**
 * Get Moretyme Options
 *
 * @param string $option define the option to return.
 *
 * @return array
 */
function moretyme_options( $option = '' ) {
	$options = get_option( 'moretyme_options' );
	if ( ! empty( $option ) ) {
		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		} else {
			return false;
		}
	}
	return $options;
}

/**
 * Moretyme colors
 *
 * @uses moretyme_options
 */
function moretyme_colors() {
	$options = moretyme_options( 'colors' );

	$color_options = array(
		array(
			'label'   => __( 'Font colour', 'moretyme-for-payfast' ),
			'key'     => 'font_color',
			'default' => '#022d2d',
		),
		array(
			'label'   => __( 'Link colour', 'moretyme-for-payfast' ),
			'key'     => 'link_color',
			'default' => '#022d2d',
		),
		array(
			'label'   => __( 'Background colour', 'moretyme-for-payfast' ),
			'key'     => 'background_color',
			'default' => '',
		),
	);

	foreach ( $color_options as $key => $value ) {
		echo '<p id="setting-' . esc_attr( $value['key'] ) . '" class="row">';
		echo '<input 
                class="cpa-color-picker"
                id="' . esc_attr( $value['key'] ) . '"
                name="moretyme_options[colors][' . esc_attr( $value['key'] ) . ']" 
                type="text"
                value="' . esc_attr( isset( $options[ $value['key'] ] ) ? $options[ $value['key'] ] : $value['default'] ) . '"
            >';
			echo '<label for="' . esc_attr( $value['key'] ) . '">';
				echo esc_html( $value['label'] );
			echo '</label>';
		echo '</p>';
	}
}

/**
 * Moretyme Widget for Admin Only
 *
 * @uses moretyme_options
 */
function moretyme_admin_only() {
	$options = moretyme_options( 'admin_only' );
	$checked = ( $options ? 'checked' : '' );
	echo '<input type="checkbox" ' . esc_attr( $checked ) . ' name="moretyme_options[admin_only]" id="admin_only">';
}

/**
 * Moretyme Font
 *
 * @uses moretyme_options
 */
function moretyme_font() {
	$options = moretyme_options( 'font' );
	$fonts   = array(
		'Arial'             => __( 'Arial', 'moretyme-for-payfast' ),
		'Garamond'          => __( 'Garamond', 'moretyme-for-payfast' ),
		'Helvetica'         => __( 'Helvetica', 'moretyme-for-payfast' ),
		'Lato'              => __( 'Lato', 'moretyme-for-payfast' ),
		'Merriweather'      => __( 'Merriweather', 'moretyme-for-payfast' ),
		'Merriweather+Sans' => __( 'Merriweather Sans', 'moretyme-for-payfast' ),
		'Montserrat'        => __( 'Montserrat', 'moretyme-for-payfast' ),
		'Open-Sans'         => __( 'Open Sans', 'moretyme-for-payfast' ),
		'Oswald'            => __( 'Oswald', 'moretyme-for-payfast' ),
		'PT-Sanes'          => __( 'PT Sans', 'moretyme-for-payfast' ),
		'Raleway'           => __( 'Raleway', 'moretyme-for-payfast' ),
		'Roboto'            => __( 'Roboto', 'moretyme-for-payfast' ),
		'Source-Sans-Pro'   => __( 'Source Sans Pro', 'moretyme-for-payfast' ),
		'Times-New-Roman'   => __( 'Times-New-Roman', 'moretyme-for-payfast' ),
		'Verdana'           => __( 'Verdana', 'moretyme-for-payfast' ),
	);

	echo '<select id="moretyme_font" name="moretyme_options[font]">';
	foreach ( $fonts as $key => $value ) {
		$select = ( isset( $options ) && $key === $options ? 'selected' : '' );
		echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $select ) . '>';
			echo esc_html( $value );
		echo '</option>';
	}
	echo '</select>';
}

/**
 * Logo Alignment
 *
 * @uses moretyme_options
 */
function moretyme_logo_alignment() {
	$options      = moretyme_options( 'logo_alignment' );
	$logo_options = array(
		''      => __( 'Default', 'moretyme-for-payfast' ),
		'above' => __( 'Above', 'moretyme-for-payfast' ),
		'below' => __( 'Below', 'moretyme-for-payfast' ),
		'right' => __( 'Right', 'moretyme-for-payfast' ),
	);

	echo '<select id="logo_alignment" name="moretyme_options[logo_alignment]">';
	foreach ( $logo_options as $key => $value ) {
		$select = ( $options && $key === $options ? 'selected' : '' );
		echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $select ) . '>';
			echo esc_html( $value );
		echo '</option>';
	}
	echo '</select>';
}

/**
 * Moretyme Mode
 *
 * @uses moretyme_options
 */
function moretyme_mode() {
	$options = moretyme_options( 'mode' );
	$modes   = array(
		'light' => __( 'Light', 'moretyme-for-payfast' ),
		'dark'  => __( 'Dark', 'moretyme-for-payfast' ),
	);

	echo '<select id="moretyme_mode" name="moretyme_options[mode]">';
	foreach ( $modes as $key => $value ) {
		$select = ( $options && $key === $options ? 'selected' : '' );
		echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $select ) . '>';
			echo esc_html( $value );
		echo '</option>';
	}
	echo '</select>';
}

/**
 * Moretyme Widget Padding
 *
 * @uses moretyme_options
 */
function moretyme_padding() {
	$options = moretyme_options( 'padding' );

	$value = ( ! empty( $options ) ? $options : '0' );

	echo '<div class="slidecontainer">';
		echo '<input type="range" name="moretyme_options[padding]" min="0" max="30" value="' . esc_attr( $value ) . '" class="slider" id="moretymePadding"><div id="demo"></div>';
	echo '</div>';
}

/**
 * Moretyme Payfast Logo
 *
 * @uses moretyme_options
 */
function moretyme_payfast_logo() {
	$options              = moretyme_options( 'payfast_logo' );
	$payfast_logo_options = array(
		'red'   => __( 'Red', 'moretyme-for-payfast' ),
		'white' => __( 'White', 'moretyme-for-payfast' ),
	);
	echo '<select id="payfast_logo" name="moretyme_options[payfast_logo]">';
	foreach ( $payfast_logo_options as $key => $value ) {
		$select = ( isset( $options ) && $options === $key ? 'selected' : '' );
		echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $select ) . '>';
			echo esc_html( $value );
		echo '</option>';
	}
	echo '</select>';
}

/**
 *
 * Moretyme Widget Position
 *
 * @uses moretyme_options
 */
function moretyme_widget_position() {
	$options   = moretyme_options( 'position' );
	$positions = array(
		'woocommerce_single_product_summary'       => __( 'Before Single Product Summary', 'moretyme-for-payfast' ),
		'woocommerce_before_add_to_cart_form'      => __( 'Before Add to Cart Form', 'moretyme-for-payfast' ),
		'woocommerce_before_add_to_cart_button'    => __( 'Before Add to Cart Button', 'moretyme-for-payfast' ),
		'woocommerce_after_add_to_cart_button'     => __( 'After Add to Cart Button', 'moretyme-for-payfast' ),
		'woocommerce_after_add_to_cart_form'       => __( 'After Add to Cart Form', 'moretyme-for-payfast' ),
		'woocommerce_after_single_product_summary' => __( 'After Single Product Summary', 'moretyme-for-payfast' ),
	);

	$positions = apply_filters( 'moretyme_add_widget_positions', $positions );

	if ( ! empty( $positions ) || is_array( $positions ) ) {
		echo '<select id="moretyme_position" name="moretyme_options[position]">';
		foreach ( $positions as $key => $value ) {
			$select = ( isset( $options ) && $key === $options ? 'selected' : '' );
			echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $select ) . '>';
				echo esc_html( $value );
			echo '</option>';
		}
		echo '</select>';
	}
}

/**
 * Moretyme Widget Size
 *
 * @uses moretyme_options
 */
function moretyme_widget_size() {
	$options = moretyme_options( 'widget_size' );
	$sizes   = array(
		''      => __( 'Standard', 'moretyme-for-payfast' ),
		'small' => __( 'Small', 'moretyme-for-payfast' ),
	);

	echo '<select id="moretyme_widget_size" name="moretyme_options[widget_size]">';
	foreach ( $sizes as $key => $value ) {
		$select = ( $options && $key === $options ? 'selected' : '' );
		echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $select ) . '>';
			echo esc_html( $value );
		echo '</option>';
	}
	echo '</select>';
}

/**
 * Validate options
 *
 * @param array $fields Validate teh fields.
 *
 * @return aaray
 **/
function validate_options( $fields ) {
	$options = moretyme_options( 'colors' );

	$valid_fields = array();
	// Validate Colours.
	foreach ( $fields['colors'] as $key => $value ) {
		// Check if is a valid hex color.
		if ( false === validate_colour( $value ) ) {
			$setting = str_replace( '_', ' ', $key );
			/* translators: %s: setting label */
			add_settings_error( 'moretyme_message', 'moretyme_message', sprintf( __( 'Please select a valid colour for - %s!', 'moretyme-for-payfast' ), $setting ), 'error' );
			// Get the previous valid value.
			$valid_fields[ $key ] = $options[ $key ];
		} else {
			$valid_fields[ $key ] = $value;
		}
	}
	return apply_filters( 'validate_options', $fields );
}

/**
 * Validate HEX color.
 *
 * @param string $value Hex code vlaue.
 *
 * @return bool
 */
function validate_colour( $value ) {
	if ( empty( $value ) ) {
		return true;
	}
	if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) {
		return true;
	}
	return false;
}
