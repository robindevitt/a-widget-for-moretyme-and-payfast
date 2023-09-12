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
		'moretyme_mode'            => __( 'Mode /Colours', 'moretyme-for-payfast' ),
		'moretyme_colors'          => '',
		'moretyme_admin_only'      => __( 'Enabled for admins only', 'moretyme-for-payfast' ),
		'moretyme_font'            => __( 'Font', 'moretyme-for-payfast' ),
		'moretyme_logo_alignment'  => __( 'Logo Alignment', 'moretyme-for-payfast' ),
		'moretyme_padding'         => __( 'Padding', 'moretyme-for-payfast' ),
		'moretyme_payfast_logo'    => __( 'Payfast Logo Type', 'moretyme-for-payfast' ),
		'moretyme_widget_position' => __( 'Widget Position', 'moretyme-for-payfast' ),
		'moretyme_widget_size'     => __( 'Widget Size', 'moretyme-for-payfast' ),
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
