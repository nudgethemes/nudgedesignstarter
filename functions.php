<?php
/**
 * Nudgedesignstarter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function nudgedesignstarter_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 680;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'nudgedesignstarter-fullscreen', 1980, 9999 );
	add_image_size( 'nudgedesignstarter-post-archive', 800, 600, true );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Nudgedesignstarter, use a find and replace
	 * to change 'nudgedesignstarter' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'nudgedesignstarter' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'style-editor.css' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	//Add Content Options
	add_theme_support(
		'jetpack-content-options',
		array(
			'author-bio'   => true, // display or not the author bio: true or false
			'post-details' => array(
				'stylesheet' => 'ulteriorepicure-style', // name of the theme's stylesheet
				'date'       => '.post-date', // a CSS selector matching the elements that display the post date.
				'categories' => '.entry-categories', // a CSS selector matching the elements that display the post categories.
				'tags'       => '.post-tags', // a CSS selector matching the elements that display the post tags.
				'author'     => '.post-author', // a CSS selector matching the elements that display the post author.
				'comment'    => '.post-comment-link', // a CSS selector matching the elements that display the comment link.
			),
		)
	);

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new Nudgedesignstarter_Script_Loader();
	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );
}

add_action( 'after_setup_theme', 'nudgedesignstarter_theme_support' );

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-nudgedesignstarter-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-nudgedesignstarter-customize.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-nudgedesignstarter-walker-comment.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-nudgedesignstarter-script-loader.php';

// WooCommerce support
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Register and Enqueue Styles.
 */
function nudgedesignstarter_register_styles() {

	$style_version = filemtime( get_stylesheet_directory() . '/style.css' );

	wp_enqueue_style( 'nudgedesignstarter-style', get_stylesheet_uri(), array(), $style_version );
	wp_style_add_data( 'nudgedesignstarter-style', 'rtl', 'replace' );

	// Add print CSS.
	wp_enqueue_style( 'nudgedesignstarter-print-style', get_template_directory_uri() . '/print.css', null, $style_version, 'print' );

}
add_action( 'wp_enqueue_scripts', 'nudgedesignstarter_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function nudgedesignstarter_register_scripts() {

	$style_version = filemtime( get_stylesheet_directory() . '/style.css' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'nudgedesignstarter-js', get_template_directory_uri() . '/assets/js/index.js', array(), $style_version, false );
	wp_script_add_data( 'nudgedesignstarter-js', 'async', true );
}

add_action( 'wp_enqueue_scripts', 'nudgedesignstarter_register_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function nudgedesignstarter_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'nudgedesignstarter_skip_link_focus_fix' );

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function nudgedesignstarter_menus() {

	$locations = array(
		'primary' => __( 'Desktop Horizontal Menu', 'nudgedesignstarter' ),
		'mobile'  => __( 'Mobile Menu', 'nudgedesignstarter' ),
		'social'  => __( 'Social Menu', 'nudgedesignstarter' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'nudgedesignstarter_menus' );

/**
 * Get the information about the logo.
 *
 * @param string $html The HTML output from get_custom_logo (core function).
 *
 * @return string $html
 */
function nudgedesignstarter_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) {
		return $html;
	}

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace( $search, $replace, $html );
		}
	}

	return $html;
}

add_filter( 'get_custom_logo', 'nudgedesignstarter_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function nudgedesignstarter_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . esc_html__( 'Skip to the content', 'nudgedesignstarter' ) . '</a>';
}

add_action( 'wp_body_open', 'nudgedesignstarter_skip_link', 5 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function nudgedesignstarter_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #1', 'nudgedesignstarter' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'nudgedesignstarter' ),
			)
		)
	);
}

add_action( 'widgets_init', 'nudgedesignstarter_sidebar_registration' );

/**
 * Enqueue supplemental block editor styles.
 */
function nudgedesignstarter_enqueue_block_editor_assets() {

	$style_version = filemtime( get_theme_file_path( '/style-editor.css' ) );

	// Enqueue the editor script.
	wp_enqueue_script( 'nudgedesignstarter-block-editor-script', get_theme_file_uri( '/assets/js/editor-script-block.js' ), array( 'wp-blocks', 'wp-dom' ), $style_version, true );
}

add_action( 'enqueue_block_editor_assets', 'nudgedesignstarter_enqueue_block_editor_assets', 1, 1 );


/**
 * Block Editor Settings.
 * Add custom colors and font sizes to the block editor.
 */
function nudgedesignstarter_block_editor_settings() {

	$color__primary           = '#009FDB';
	$color__secondary         = '#BDBFC1';
	$color__accent            = '#FFC300';
	$color__background        = '#FFFFFF';
	$color__subtle_background = '#EEEFF0';
	$color__body_copy         = '#021A23';

	// Block Editor Palette.
	$editor_color_palette = array(
		array(
			'name'  => __( 'Accent Color', 'nudgedesignstarter' ),
			'slug'  => 'accent',
			'color' => $color__accent,
		),
		array(
			'name'  => __( 'Primary', 'nudgedesignstarter' ),
			'slug'  => 'primary',
			'color' => $color__primary,
		),
		array(
			'name'  => __( 'Secondary', 'nudgedesignstarter' ),
			'slug'  => 'secondary',
			'color' => $color__secondary,
		),
		array(
			'name'  => __( 'Subtle Background', 'nudgedesignstarter' ),
			'slug'  => 'subtle-background',
			'color' => $color__subtle_background,
		),
		array(
			'name'  => __( 'Body Text', 'nudgedesignstarter' ),
			'slug'  => 'bodytext',
			'color' => $color__body_copy,
		),
		array(
			'name'  => __( 'Background', 'nudgedesignstarter' ),
			'slug'  => 'background',
			'color' => $color__background,
		),
	);

	// Block Editor Font Sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'nudgedesignstarter' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'nudgedesignstarter' ),
				'size'      => 16,
				'slug'      => 'small',
			),
			array(
				'name'      => _x( 'Regular', 'Name of the regular font size in the block editor', 'nudgedesignstarter' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the block editor.', 'nudgedesignstarter' ),
				'size'      => 18,
				'slug'      => 'normal',
			),
			array(
				'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'nudgedesignstarter' ),
				'shortName' => _x( 'XL', 'Short name of the large font size in the block editor.', 'nudgedesignstarter' ),
				'size'      => 36,
				'slug'      => 'large',
			),
			array(
				'name'      => _x( 'Huge', 'Name of the larger font size in the block editor', 'nudgedesignstarter' ),
				'shortName' => _x( 'XXL', 'Short name of the larger font size in the block editor.', 'nudgedesignstarter' ),
				'size'      => 64,
				'slug'      => 'huge',
			),
		)
	);

}

add_action( 'after_setup_theme', 'nudgedesignstarter_block_editor_settings' );

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 *
 * @return string $html
 */
function nudgedesignstarter_read_more_tag( $html ) {
	return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

add_filter( 'the_content_more_link', 'nudgedesignstarter_read_more_tag' );

/**
 *
 * Modify default [...] on the excerpt
 *
 */
function nudgedesignstarter_excerpt_more( $more ) {
	return ' <a class="read-more" href="' . get_the_permalink() . '" rel="nofollow">' . esc_html__( 'Read more', 'nudgedesignstarter' ) .
		'<span class="read-more-icon">' . nudgedesignstarter_get_theme_svg( 'chevron-right' ) .
		'</span></a>';
}
add_filter( 'excerpt_more', 'nudgedesignstarter_excerpt_more' );
