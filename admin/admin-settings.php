<?php
/**
 * Create a settings page for different options.
 *
 * @package MoretymeForPayfast
 */

namespace MoreTymeForPayfast\Settings;

require_once 'admin-options.php';

/**
 * Create top level menu item
 */
function options() {

	// add top level menu page.
	add_menu_page(
		__( 'MoreTyme for Payfast Settings', 'moretyme-for-payfast' ),
		__( 'MoreTyme', 'moretyme-for-payfast' ),
		'manage_options',
		'moretyme-for-payfast',
		'options_page_content',
		plugin_dir_url( __FILE__ ) . ( '../assets/images/moretyme-icon.png' ),
		50
	);

}

/**
 * Create settings
 */
function settings() {
	register_setting(
		'moretyme_settings',
		'moretyme_options',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'validate_options',
		)
	);
	moretyme_settings();
}

/**
 * Logo Alignment settings
 */
function moretyme_settings() {
	add_settings_section(
		'moretyme_section',
		__( 'Widget styles', 'moretyme-for-payfast' ),
		'',
		'moretyme_settings'
	);

	$settings = array(
		'moretyme_colors'          => 'Colours',
		'moretyme_admin_only'      => 'Enabled for admins only',
		'moretyme_font'            => 'Font',
		'moretyme_logo_alignment'  => 'Logo Alignment',
		'moretyme_padding'         => 'Padding',
		'moretyme_payfast_logo'    => 'Payfast Logo Type',
		'moretyme_widget_position' => 'Widget Position',
		'moretyme_widget_size'     => 'Widget Size',
	);

	foreach ( $settings as $key => $value ) {
		add_settings_field(
			$key,
			$value,
			$key,
			'moretyme_settings',
			'moretyme_section'
		);
	}
}
