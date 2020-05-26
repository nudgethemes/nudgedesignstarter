<?php
/**
 * Header file for the Nudgedesignstarter WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		wp_body_open();
		?>
		<header id="site-header" class="header-footer-group" role="banner">

			<div class="header-inner">

				<div class="header-titles-wrapper">

					<?php

					// Check whether the header search is activated in the customizer.
					$enable_header_search   = get_theme_mod( 'enable_header_search', true );
					$enable_menu_user_login = get_theme_mod( 'enable_menu_user_login', true );

					if ( true === $enable_header_search ) {

						?>

						<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
							<span class="toggle-inner">
								<span class="toggle-icon">
									<?php nudgedesignstarter_the_theme_svg( 'search' ); ?>
								</span>
								<span class="toggle-text"><?php esc_html_e( 'Search', 'nudgedesignstarter' ); ?></span>
							</span>
						</button><!-- .search-toggle -->

					<?php } ?>

					<div class="header-titles">

						<?php
							// Site title or logo.
							nudgedesignstarter_site_logo();

							// Site description.
							nudgedesignstarter_site_description();
						?>

					</div><!-- .header-titles -->

					<button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
						<span class="toggle-inner">
							<span class="toggle-icon">
								<?php nudgedesignstarter_the_theme_svg( 'menu' ); ?>
							</span>
							<span class="toggle-text"><?php esc_html_e( 'Menu', 'nudgedesignstarter' ); ?></span>
						</span>
					</button><!-- .nav-toggle -->

				</div><!-- .header-titles-wrapper -->

				<div class="header-navigation-wrapper">

					<?php
					if ( has_nav_menu( 'primary' ) ) {
						?>

						<nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'nudgedesignstarter' ); ?>" role="navigation">

							<ul class="primary-menu reset-list-style">

							<?php
							if ( has_nav_menu( 'primary' ) ) {

								wp_nav_menu(
									array(
										'container'      => '',
										'items_wrap'     => '%3$s',
										'theme_location' => 'primary',
									)
								);
							}
							?>
							</ul>
						</nav><!-- .primary-menu-wrapper -->

						<?php
					}

					?>
					<div class="menu-add-ons">
					<?php
					if ( true === $enable_menu_user_login && class_exists( 'WooCommerce' ) ) {
						?>
						<div class="menu-user-login-wrapper">
							<div class="menu-user-login">
								<?php

								$nudgedesignstarter_menu_user_link = wc_get_page_permalink( 'myaccount' );

								?>
								<a class="menu-user-login-toggle" href="<?php echo esc_url( $nudgedesignstarter_menu_user_link ); ?>" >
									<?php nudgedesignstarter_the_theme_svg( 'user' ); ?>
									<span class="screen-reader-text"><?php esc_html_e( 'User Login', 'nudgedesignstarter' ); ?></span>
								</a>
								<?php

								if ( ! is_user_logged_in() ) {

									?>
									<div class="menu-user-login-form">
										<h3 class="menu-user-login-title"><?php esc_html_e( 'Sign in', 'nudgedesignstarter' ); ?></h3>
									<?php
										woocommerce_login_form();
									?>
									</div>
									<?php
								}

								?>
							</div>
						</div>
						<?php
					}
					?>
					<div class="cart-wrapper">
						<?php
						if ( function_exists( 'nudgedesignstarter_woocommerce_header_cart' ) ) {
							nudgedesignstarter_woocommerce_header_cart();
						}
						?>
					</div>
					<?php
					if ( true === $enable_header_search ) {
						?>

					<div class="header-toggles hide-no-js">

						<div class="toggle-wrapper search-toggle-wrapper">

							<button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
									<span class="toggle-inner">
										<?php nudgedesignstarter_the_theme_svg( 'search' ); ?>
										<span class="toggle-text screen-reader-text"><?php esc_html_e( 'Search', 'nudgedesignstarter' ); ?></span>
									</span>
							</button><!-- .search-toggle -->

						</div>

					</div><!-- .header-toggles -->
						<?php
					}
					?>

					</div>

				</div><!-- .header-navigation-wrapper -->

			</div><!-- .header-inner -->

			<?php
			// Output the search modal (if it is activated in the customizer).
			if ( true === $enable_header_search ) {
				get_template_part( 'template-parts/modal-search' );
			}
			?>
		<?php
		if ( function_exists( 'woocommerce_demo_store' ) ) {
			woocommerce_demo_store();
		}
		?>
		</header><!-- #site-header -->

		<?php
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );
