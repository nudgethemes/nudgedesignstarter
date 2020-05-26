<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

$entry_header_classes = '';

if ( is_singular() ) {
	$entry_header_classes .= ' header-footer-group';
}

?>

<header class="entry-header <?php echo esc_attr( $entry_header_classes ); ?>">

	<div class="entry-header-inner">

		<div class="entry-header-inner-top">

		<?php
			/**
			 * Allow child themes and plugins to filter the display of the categories in the entry header.
			 *
			 * @since 1.0.0
			 *
			 * @param bool   Whether to show the categories in header, Default true.
			 */
			$show_categories = apply_filters( 'nudgedesignstarter_show_categories_in_entry_header', true );

		if ( true === $show_categories && has_category() ) {
			?>

				<div class="entry-categories">
					<span class="screen-reader-text"><?php esc_html_e( 'Categories', 'nudgedesignstarter' ); ?></span>
					<div class="entry-categories-inner">
					<?php the_category( ' ' ); ?>
					</div><!-- .entry-categories-inner -->
				</div><!-- .entry-categories -->

				<?php
		}

			nudgedesignstarter_the_post_meta( get_the_ID(), 'single-header-top' );
		?>
		</div>

		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title heading-size-3"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
		}


		if ( has_excerpt() && is_singular() ) {
			?>

			<div class="intro-text">
				<?php the_excerpt(); ?>
			</div>

			<?php
		}

		// Default to displaying the post meta.
		nudgedesignstarter_the_post_meta( get_the_ID(), 'single-header-bottom' );
		?>

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->
