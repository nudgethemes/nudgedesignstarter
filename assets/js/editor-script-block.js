/**
 * Style Variations
 *
 * @since 1.0.0
 */
/* global wp */
wp.domReady( function() {

	//Remove squared button style
	wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );

} );
