<?php
/**
 * The template for displaying the 404 template in the Nudgedesignstarter theme.
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

get_header();
?>

<main id="site-content" role="main">

	<div class="section-inner thin error404-content">

		<h1 class="entry-title"><?php esc_html_e( 'Whoops!', 'nudgedesignstarter' ); ?></h1>
		<h2><?php esc_html_e( 'Something went wrong.', 'nudgedesignstarter' ); ?></h2>

		<div class="intro-text"><p><?php esc_html_e( 'The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.', 'nudgedesignstarter' ); ?></p></div>

		<?php
		get_search_form(
			array(
				'label' => __( '404 not found', 'nudgedesignstarter' ),
			)
		);
		?>

	</div><!-- .section-inner -->

</main><!-- #site-content -->

<?php
get_footer();
