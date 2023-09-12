/**
 * WooCommerce Event hook for changing the prices.
 *
 * @package MoretymeForPayfast
 */

jQuery( ".single_variation_wrap" ).on(
	"show_variation",
	function (event, variation) {
		var amount = parseFloat( variation.display_price ) / parseFloat( 3 );
		jQuery( "#moretyme_widget_wrapper .moretyme__amount" ).text(
			moretyme_ajax_object.currency + amount.toFixed( 2 )
		);
	}
);
