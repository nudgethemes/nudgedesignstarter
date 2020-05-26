<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

?>
			<?php get_sidebar(); ?>

			<footer id="site-footer" role="contentinfo" class="header-footer-group">

				<div class="section-inner">

					<div class="footer-credits">

						<p class="footer-copyright">&copy;
							<?php
							echo esc_html(
								date_i18n(
									/* translators: Copyright date format, see https://secure.php.net/date */
									esc_html_x( 'Y', 'copyright date format', 'nudgedesignstarter' )
								)
							);
							?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo bloginfo( 'name' ); ?></a>
						</p><!-- .footer-copyright -->

							<?php

							$nudgedesignstarter_footer_credit = get_theme_mod( 'nudgedesignstarter_footer_credit', nudgedesignstarter_get_default_footer_credit() );

							if ( '' !== $nudgedesignstarter_footer_credit ) {
								?>
								<p class="powered-by-wordpress">
								<?php
									echo wp_kses_post( $nudgedesignstarter_footer_credit );
								?>
								</p><!-- .powered-by-wordpress -->
								<?php
							}
							?>

					</div><!-- .footer-credits -->

					<?php
					$has_social_menu = has_nav_menu( 'social' );

					if ( $has_social_menu ) {
						?>
						<div class="footer-social-section">

							<nav aria-label="<?php esc_attr_e( 'Social links', 'nudgedesignstarter' ); ?>" class="footer-social-wrapper">

								<ul class="social-menu footer-social reset-list-style social-icons fill-children-current-color">

									<?php
									wp_nav_menu(
										array(
											'theme_location' => 'social',
											'container'   => '',
											'container_class' => '',
											'items_wrap'  => '%3$s',
											'menu_id'     => '',
											'menu_class'  => '',
											'depth'       => 1,
											'link_before' => '<span class="screen-reader-text">',
											'link_after'  => '</span>',
											'fallback_cb' => '',
										)
									);
									?>

								</ul><!-- .footer-social -->

							</nav><!-- .footer-social-wrapper -->

						</div><!-- .footer-top -->

					<?php } ?>

				</div><!-- .section-inner -->

			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>
