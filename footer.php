<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

?>
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

						<p class="powered-by-wordpress">
							<a href="<?php echo esc_url( __( 'https://wordpress.com/', 'nudgedesignstarter' ) ); ?>" class="imprint">
								<?php
								/* translators: %s: WordPress. */
								printf( esc_html__( 'Proudly powered by %s.', 'nudgedesignstarter' ), 'WordPress' );
								?>
							</a>
							<a href="<?php echo esc_url( __( 'https://pressable.com/?utm_source=Automattic&utm_medium=rpc&utm_campaign=Concierge%20Referral&utm_term=concierge', 'rivington' ) ); ?>" class="imprint">
								<?php
								/* translators: %s: Pressable. */
								printf( esc_html__( 'Hosted by %s.', 'nudgedesignstarter' ), 'Pressable' );
								?>
							</a>

						</p><!-- .powered-by-wordpress -->

					</div><!-- .footer-credits -->

					<a class="to-the-top" href="#site-header">
						<span class="to-the-top-long">
							<?php
							/* translators: %s: HTML character for up arrow */
							printf( esc_html__( 'To the top %s', 'nudgedesignstarter' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
							?>
						</span><!-- .to-the-top-long -->
						<span class="to-the-top-short">
							<?php
							/* translators: %s: HTML character for up arrow */
							printf( esc_html__( 'Up %s', 'nudgedesignstarter' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
							?>
						</span><!-- .to-the-top-short -->
					</a><!-- .to-the-top -->

				</div><!-- .section-inner -->

			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>
