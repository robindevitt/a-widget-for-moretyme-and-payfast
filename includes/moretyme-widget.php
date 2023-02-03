<?php
/**
 * Moretyme Widget.
 *
 * @package MoretymeForPayfast
 */

namespace MoreTymeForPayfast\MoretymeWidget;

use WC_Product_Variation;

$options         = get_option( 'moretyme_options' );
$widget_position = ( $options && isset( $options['position'] ) ? $options['position'] : 'woocommerce_single_product_summary' );

add_action( $widget_position, 'MoreTymeForPayfast\MoretymeWidget\add_the_widget' );

/**
 * Functions to show the widget.
 */
function add_the_widget() {
	// gets the product object.
	global $product;
	if ( ! is_object( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	echo moretyme_widget_generate( $product->get_price() );
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

	// Set the default font.
	$font    = ( isset( $url_options['font'] ) ? $url_options['font'] : 'Arial' );
	$script .= '&font=' . $font;

	if ( isset( $url_options['widget_size'] ) ) {
		$script .= '&size=' . $url_options['widget_size'];
	}
	if ( isset( $url_options['logo_alignment'] ) ) {
		$script .= '&logo-align=' . $url_options['logo_alignment'];
	}
	if ( isset( $url_options['payfast_logo'] ) ) {
		$script .= '&logo-type=' . $url_options['payfast_logo'];
	}

	// Set the font colour, if the option isn't set use the default.
	$font_color  = ( isset( $url_options['colors']['font_color'] ) ? $url_options['colors']['font_color'] : '#fffff' );
	$custom_css .= 'color:' . $font_color . '!important;';
	$script     .= '&font-color=' . $font_color;

	// Set the link colour, if the option isn't set use the default.
	$link_color      = ( isset( $url_options['colors']['link_color'] ) ? $url_options['colors']['link_color'] : '#e8f278' );
	$custom_link_css = '#moretyme_widget_wrapper .moretyme__cont a{color:' . $link_color . '!important;}';
	$script         .= '&link-color=' . $link_color;

	// Set the background colour, if the option isn't set use the default.
	$background_color = ( isset( $url_options['colors']['background_color'] ) ? $url_options['colors']['background_color'] : '#022d2d' );
	$custom_css      .= 'background-color:' . $background_color . ';';

	$padding     = ( isset( $url_options['padding'] ) ? $url_options['padding'] : '10' );
	$custom_css .= 'padding:' . $padding . 'px !important;';

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
