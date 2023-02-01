<?php
/**
 * Moretyme Widget.
 *
 * @package MoretymeForPayfast
 */

namespace MoreTymeForPayfast\MoretymeWidget;

use WC_Product_Variation;

$options = get_option( 'moretyme_options' );

add_action( $options['position'], 'MoreTymeForPayfast\MoretymeWidget\add_the_widget' );

/**
 * Functions to show the widget.
 */
function add_the_widget() {
	// gets the product object.
	global $product;
	if ( ! is_object( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	echo esc_html( moretyme_widget_generate( $product->get_price() ) );
}

/**
 * Generate teh widget html.
 *
 * @param string $amount String value for the price amount.
 * @return string $html
 */
function moretyme_widget_generate( string $amount = '0' ) {
	$url_options = get_option( 'moretyme_options' );

	if ( isset( $url_options['admin_only'] ) && ! current_user_can( 'administrator' ) ) {
		return;
	}

	// Ignore the next line to prevent an error for the script being inline, it needs to be inline to return the HTML for the widget.
	$script  = '<script async src="https://content.payfast.co.za/widgets/moretyme/widget.min.js?'; // phpcs:ignore
	$script .= 'amount=' . $amount;
	$script .= '&theme=dark';

	$custom_css      = '#moretyme_widget_wrapper{width:100%}#moretyme_widget_wrapper .moretyme__cont{';
	$custom_link_css = '';
	if ( isset( $url_options['font'] ) ) {
		$script .= '&font=' . $url_options['font'];
	}
	if ( isset( $url_options['widget_size'] ) ) {
		$script .= '&size=' . $url_options['widget_size'];
	}
	if ( isset( $url_options['logo_alignment'] ) ) {
		$script .= '&logo-align=' . $url_options['logo_alignment'];
	}
	if ( isset( $url_options['payfast_logo'] ) ) {
		$script .= '&logo-type=' . $url_options['payfast_logo'];
	}
	if ( isset( $url_options['colors']['font_color'] ) ) {
		$custom_css .= 'color:' . $url_options['colors']['font_color'] . '!important;';
		$script     .= '&font-color=' . $url_options['colors']['font_color'];
	}
	if ( isset( $url_options['colors']['link_color'] ) ) {
		$custom_link_css = '#moretyme_widget_wrapper .moretyme__cont a{color:' . $url_options['colors']['link_color'] . '!important;}';
		$script         .= '&link-color=' . $url_options['colors']['link_color'];
	}
	if ( isset( $url_options['colors']['background_color'] ) ) {
		$custom_css .= 'background-color:' . $url_options['colors']['background_color'] . ';';
	}
	if ( isset( $url_options['padding'] ) ) {
		$custom_css .= 'padding:' . $url_options['padding'] . 'px !important;';
	}

	$custom_css .= '}';
	$html        = '<div class="moretyme_widget_wrapper"><div id="moretyme_widget_wrapper" class="moretyme__cont">';
	$html       .= $script .= '" type="text/javascript"></script>';
	$html       .= '</div></div>';

	$custom_css .= $custom_link_css;

	wp_register_style( 'moretyme-inline-style', false, '', MORETYME_FOR_PAYFAST_VER );
	wp_enqueue_style( 'moretyme-inline-style' );
	wp_add_inline_style( 'moretyme-inline-style', $custom_css );
	wp_add_inline_script( 'moretyme-inline-script', $script );

	return $html;
}
