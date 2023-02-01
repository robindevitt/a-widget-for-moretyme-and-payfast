/**
 * Colour Picker Js.
 *
 * @package MoretymeForPayfast
 */

( function ( jQuery ) {
	jQuery(
		function() {
			// Add Color Picker to all inputs that have 'color-field' class.
			jQuery( '.cpa-color-picker' ).wpColorPicker();
		}
	);
})( jQuery );

var slider = document.getElementById( "moretymePadding" );
var output = document.getElementById( "demo" );

output.innerHTML = slider.value + 'px'; // Display the default slider value.

// Update the current slider value (each time you drag the slider handle).
slider.oninput = function() {
	output.innerHTML = this.value + 'px';
}
