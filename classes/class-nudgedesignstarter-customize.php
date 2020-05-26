<?php
/**
 * Customizer settings for this theme.
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

if ( ! class_exists( 'Nudgedesignstarter_Customize' ) ) {
	/**
	 * CUSTOMIZER SETTINGS
	 */
	class Nudgedesignstarter_Customize {

		/**
		 * Register customizer options.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public static function register( $wp_customize ) {

			/**
			 * Site Title & Description.
			 * */
			$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title a',
					'render_callback' => 'nudgedesignstarter_customize_partial_blogname',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => 'nudgedesignstarter_customize_partial_blogdescription',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'custom_logo',
				array(
					'selector'        => '.header-titles [class*=site-]:not(.site-description)',
					'render_callback' => 'nudgedesignstarter_customize_partial_site_logo',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'retina_logo',
				array(
					'selector'        => '.header-titles [class*=site-]:not(.site-description)',
					'render_callback' => 'nudgedesignstarter_customize_partial_site_logo',
				)
			);


			/**
			 * Site Identity
			 */

			/* 2X Header Logo ---------------- */
			$wp_customize->add_setting(
				'retina_logo',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'retina_logo',
				array(
					'type'        => 'checkbox',
					'section'     => 'title_tagline',
					'priority'    => 10,
					'label'       => __( 'Retina logo', 'nudgedesignstarter' ),
					'description' => __( 'Scales the logo to half its uploaded size, making it sharp on high-res screens.', 'nudgedesignstarter' ),
				)
			);

			/**
			 * Theme Options
			 */

			$wp_customize->add_section(
				'nudgedesignstarter_options',
				array(
					'title'      => __( 'Theme Options', 'nudgedesignstarter' ),
					'priority'   => 40,
					'capability' => 'edit_theme_options',
				)
			);

			/* Enable Menu User Login --------- */
			if ( class_exists( 'WooCommerce' ) ) {
				$wp_customize->add_setting(
					'enable_menu_user_login',
					array(
						'capability'        => 'edit_theme_options',
						'default'           => true,
						'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
					)
				);

				$wp_customize->add_control(
					'enable_menu_user_login',
					array(
						'type'     => 'checkbox',
						'section'  => 'nudgedesignstarter_options',
						'priority' => 10,
						'label'    => __( 'Show user login in menu', 'nudgedesignstarter' ),
					)
				);
			}

			/* Enable Header Search --------- */

			$wp_customize->add_setting(
				'enable_header_search',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'enable_header_search',
				array(
					'type'     => 'checkbox',
					'section'  => 'nudgedesignstarter_options',
					'priority' => 10,
					'label'    => __( 'Show search in header', 'nudgedesignstarter' ),
				)
			);

			/* Show author bio ---------------------------------------------------- */

			$wp_customize->add_setting(
				'show_author_bio',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'show_author_bio',
				array(
					'type'     => 'checkbox',
					'section'  => 'nudgedesignstarter_options',
					'priority' => 10,
					'label'    => __( 'Show author bio', 'nudgedesignstarter' ),
				)
			);

			/* Show or hide title on static frontpage --------- */

			$wp_customize->add_setting(
				'nudgedesignstarter_front_page_title_hidden',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => false,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'nudgedesignstarter_front_page_title_hidden',
				array(
					'type'     => 'checkbox',
					'section'  => 'nudgedesignstarter_options',
					'priority' => 10,
					'label'    => __( 'Hide page title when static Homepage is selected:', 'nudgedesignstarter' ),
				)
			);

			/* Show or hide excerpts on the blog and archives --------- */

			$wp_customize->add_setting(
				'nudgedesignstarter_blog_content',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => false,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'nudgedesignstarter_blog_content',
				array(
					'type'     => 'checkbox',
					'section'  => 'nudgedesignstarter_options',
					'priority' => 10,
					'label'    => __( 'Show the excerpt on posts and archive pages:', 'nudgedesignstarter' ),
				)
			);

		}

		/**
		 * Sanitize boolean for checkbox.
		 *
		 * @param bool $checked Whether or not a box is checked.
		 *
		 * @return bool
		 */
		public static function sanitize_checkbox( $checked ) {
			return ( ( isset( $checked ) && true === $checked ) ? true : false );
		}

		/**
		 * Sanitize select.
		 *
		 * @param string $input The input from the setting.
		 * @param object $setting The selected setting.
		 *
		 * @return string $input|$setting->default The input from the setting or the default setting.
		 */
		public static function sanitize_choices( $input, $setting ) {
			$input   = sanitize_key( $input );
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
		}

		/**
		 * Sanitize html text
		 *
		 * @param $input
		 * @return string
		 */
		public static function sanitize_html_text( $input ) {
			return wp_kses_post( force_balance_tags( $input ) );
		}
	}

	// Setup the Theme Customizer settings and controls.
	add_action( 'customize_register', array( 'Nudgedesignstarter_Customize', 'register' ) );

}

/**
 * PARTIAL REFRESH FUNCTIONS
 * */
if ( ! function_exists( 'nudgedesignstarter_customize_partial_blogname' ) ) {
	/**
	 * Render the site title for the selective refresh partial.
	 */
	function nudgedesignstarter_customize_partial_blogname() {
		bloginfo( 'name' );
	}
}

if ( ! function_exists( 'nudgedesignstarter_customize_partial_blogdescription' ) ) {
	/**
	 * Render the site description for the selective refresh partial.
	 */
	function nudgedesignstarter_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}

if ( ! function_exists( 'nudgedesignstarter_customize_partial_site_logo' ) ) {
	/**
	 * Render the site logo for the selective refresh partial.
	 *
	 * Doing it this way so we don't have issues with `render_callback`'s arguments.
	 */
	function nudgedesignstarter_customize_partial_site_logo() {
		nudgedesignstarter_site_logo();
	}
}
