<?php
/**
 * Plugin Name: Moretyme for Payfast
 * Description: Moretyme for Payfast creates a personalised widget for your product pages and increases sales on your site. The widget informs your customers how much they need to pay upfront and for the next two payments with MoreTyme.
 * Version: 1.0.0
 * Author: Robin Devitt
 * Author URI : https://github.com/robindevitt/
 * License: GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: moretyme-for-payfast
 * Tags: payfast, moretyme
 * Tested up to: 6.1.1
 * Stable tag: 5.0
 *
 * Moretyme for Payfast creates a personalised widget for your product pages and increases sales on your site. The widget informs your customers how much they need to pay upfront and for the next two payments with MoreTyme.
 *
 * You should have received a copy of the GNU General Public License
 * along with Moretyme for Payfast. If not, see
 * https://www.gnu.org/licenses/gpl-3.0.html.
 *
 * @package MoretymeForPayfast
 */

namespace MoreTymeForPayfast;

require_once 'admin/admin-settings.php';
require_once 'includes/moretyme-widget.php';

add_action( 'admin_enqueue_scripts', 'MoreTymeForPayfast\moretyme_style_scripts' );
add_action( 'wp_footer', 'MoretymeForPayfast\moretyme_product_script' );
add_action( 'plugins_loaded', 'MoreTymeForPayfast\init' );
add_action( 'upgrader_process_complete', 'MoreTymeForPayfast\init' );

add_action( 'plugins_loaded', 'MoreTymeForPayfast\admin_notices' );

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'MoreTymeForPayfast\add_action_links' );

/**
 * Initialise the plugin.
 */
function init() {
	define( 'MORETYME_FOR_PAYFAST_VER', '1.0.0' );
	define( 'MORETYME_FOR_PAYFAST_DIR', plugin_dir_path( __FILE__ ) );
	define( 'MORETYME_FOR_PAYFAST_URL', plugin_dir_url( __FILE__ ) );

	add_action( 'admin_init', 'MoreTymeForPayfast\Settings\Settings' );
	add_action( 'admin_menu', 'MoreTymeForPayfast\Settings\options' );
}

/**
 * Add admin notices for when WooCommerce and/or Payfast are deactivated.
 */
function admin_notices() {
	if ( ! class_exists( 'Woocommerce' ) ) {
		printf(
			'<div class="%s"><p><strong>%s</strong>%s<strong>%s</strong>.</p></div>',
			'notice notice-error',
			esc_html__( 'WooCommerce ', 'moretyme-for-payfast' ),
			esc_html__( ' needs to be installed for', 'moretyme-for-payfast' ),
			esc_html__( 'Moretyme for Payfast', 'moretyme-for-payfast' ),
		);
	}

	if ( ! class_exists( 'WC_Gateway_PayFast' ) ) {
		printf(
			'<div class="%s"><p><strong>%s</strong>%s<strong>%s</strong>.</p></div>',
			'notice notice-error',
			esc_html__( 'Payfast ', 'moretyme-for-payfast' ),
			esc_html__( ' needs to be installed for', 'moretyme-for-payfast' ),
			esc_html__( 'Moretyme for Payfast', 'moretyme-for-payfast' ),
		);
	}

	if ( 'ZAR' !== get_woocommerce_currency() ){
		printf(
			'<div class="%s"><p><strong>%s</strong>%s<strong>%s</strong>%s</p></div>',
			'notice notice-error',
			esc_html__( 'MoreTyme for PayFast', 'moretyme-for-payfast' ),
			esc_html__( ' only supports the currency of', 'moretyme-for-payfast' ),
			esc_html__( ' R ( South African Rand )', 'moretyme-for-payfast' ),
			esc_html__( '.', 'moretyme-for-payfast' ),
		);
	}
}

/**
 * Add Plugin action links.
 *
 * @param array $actions Actions for the widget.
 * @return array $actions
 */
function add_action_links( $actions ) {
	$settings_link = array(
		'<a href="' . admin_url( 'admin.php?page=moretyme-for-payfast' ) . '">' . __( 'Settings', 'moretyme-for-payfast' ) . '</a>',
	);
	$actions       = array_merge( $actions, $settings_link );
	return $actions;
}

/**
 * Script and Styles
 **/
function moretyme_style_scripts() {
	$current_page = get_current_screen()->base;
	if ( 'toplevel_page_moretyme-for-payfast' === $current_page && is_admin() ) {
		// Add the color picker css file.
		wp_enqueue_style( 'wp-color-picker' );
		// Include our custom jQuery file with WordPress Color Picker dependency.
		wp_enqueue_script( 'wp-admin-script', plugins_url( '/assets/js/admin.min.js', __FILE__ ), array( 'wp-color-picker' ), MORETYME_FOR_PAYFAST_VER, true );
	} else {
		wp_dequeue_script( 'wp-admin-script' );
		wp_dequeue_style( 'wp-color-picker' );
	}
}

/**
 * Add scripts for the products.
 */
function moretyme_product_script() {
	wp_enqueue_script( 'moretyme-product-script', plugins_url( '/assets/js/product-update.min.js', __FILE__ ), MORETYME_FOR_PAYFAST_VER, true, true );
	wp_localize_script( 
		'moretyme-product-script', 
		'moretyme_ajax_object', 
		array( 
			'sym' => get_woocommerce_currency(),
			'currency' => get_woocommerce_currency_symbol(),
			'position' => get_option( 'woocommerce_currency_pos' )
		)
	);
}
