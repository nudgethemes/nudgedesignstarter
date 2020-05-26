<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php
	get_template_part( 'template-parts/featured-image' );

	get_template_part( 'template-parts/entry-header' );

	if ( ! is_singular() && true === get_theme_mod( 'nudgedesignstarter_blog_content', false ) ) {
		?>
		<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

			<div class="entry-content">

				<?php the_excerpt(); ?>

			</div><!-- .entry-content -->

		</div><!-- .post-inner -->
		<?php
	}
	?>
	<div class="section-inner">
		<?php

		edit_post_link();

		?>
	</div><!-- .section-inner -->

</article><!-- .post -->
