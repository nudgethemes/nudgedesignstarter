<?php
/**
 * Displays widgets at the end of the main element.
 * Visually, this output is presented as part of the footer element.
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

$has_sidebar_1 = is_active_sidebar( 'sidebar-1' );

// Only output the container if there are elements to display.
if ( $has_sidebar_1 ) {
	?>

	<div class="footer-nav-widgets-wrapper header-footer-group">

		<div class="footer-inner section-inner">

			<aside class="footer-widgets-outer-wrapper" role="complementary">

				<div class="footer-widgets grid-item">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</div>

			</aside><!-- .footer-widgets-outer-wrapper -->

		</div><!-- .footer-inner -->

	</div><!-- .footer-nav-widgets-wrapper -->

<?php } ?>
