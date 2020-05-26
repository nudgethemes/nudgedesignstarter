/**
 * Style Variations
 *
 * @since 1.0.0
 */
/* global wp */
wp.domReady( function() {

	//Remove squared button style
	wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );

	// New Spacer
	wp.blocks.registerBlockStyle("core/spacer", {
		name: "spacer-vertical-line",
		label: "Vertical Line Spacer"
	});

	// Separator short
	wp.blocks.registerBlockStyle("core/separator", {
		name: "separator-vertical",
		label: "Vertical Separator"
	});

} );
