/**
 * Style Variations
 *
 * @since 1.0.0
 */
/* global wp */
wp.domReady( function() {

	//Remove squared button style
	wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );


	//add class on .editor-styles-wrapper to indicate selected page template ( .has-template-default, .has-template-template-cover for template-cover.php )
	var lastPostTemplate = null;
	var lastPostTemplateCssClass = null;
	var editorStylesWrapper = document.querySelector('.editor-styles-wrapper');

	if( editorStylesWrapper ) {

		wp.data.subscribe(function () {

			currentTemplate = wp.data.select('core/editor').getEditedPostAttribute('template')

			if (lastPostTemplate === currentTemplate) {
				return;
			}

			editorStylesWrapper.classList.remove('has-template-' + lastPostTemplateCssClass );

			lastPostTemplate = currentTemplate;

			lastPostTemplateCssClass = currentTemplate ? getTemplateCssClass( currentTemplate ) : 'default' ;
			editorStylesWrapper.classList.add('has-template-' + lastPostTemplateCssClass );

		})
	}

	function getTemplateCssClass( template ) {

		return template.replace('.php', '').replace(/[^a-zA-Z0-9]/gi, '');
	}

} );
