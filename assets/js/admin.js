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

/**
 * Toggle field
 */
jQuery(document).ready(function () {
	// Get a reference to the "moretyme_mode" input element
	const jQuerymoretymeModeInput = jQuery('#moretyme_mode');

	// Function to toggle other fields based on the input value
	function toggleFields() {
		const inputValue = jQuerymoretymeModeInput.val();

		if (inputValue === 'custom') {
			jQuery('#setting-font_color').show();
			jQuery('#setting-link_color').show();
			jQuery('#setting-background_color').show();
		} else {
			jQuery('#setting-font_color').hide();
			jQuery('#setting-link_color').hide();
			jQuery('#setting-background_color').hide();
		}
	}

	// Attach an event listener to the input to trigger the function when its value changes
	jQuerymoretymeModeInput.on('input', toggleFields);

	// Optionally, you can call the function once to initialize the field visibility based on the initial input value
	toggleFields();
});
