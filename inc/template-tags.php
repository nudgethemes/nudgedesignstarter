<?php
/**
 * Custom template tags for this theme.
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

/**
 * Table of Contents:
 * Logo & Description
 * Comments
 * Post Meta
 * Menus
 * Classes
 * Archives
 * Miscellaneous
 */

/**
 * Logo & Description
 */
/**
 * Displays the site logo, either text or image.
 *
 * @param array   $args Arguments for displaying the site logo either as an image or text.
 * @param boolean $echo Echo or return the HTML.
 *
 * @return string $html Compiled HTML based on our arguments.
 */
function nudgedesignstarter_site_logo( $args = array(), $echo = true ) {
	$logo       = get_custom_logo();
	$site_title = get_bloginfo( 'name' );
	$contents   = '';
	$classname  = '';

	$defaults = array(
		'logo'        => '%1$s<span class="screen-reader-text">%2$s</span>',
		'logo_class'  => 'site-logo',
		'title'       => '<a href="%1$s">%2$s</a>',
		'title_class' => 'site-title',
		'home_wrap'   => '<h1 class="%1$s">%2$s</h1>',
		'single_wrap' => '<div class="%1$s faux-heading">%2$s</div>',
		'condition'   => ( is_front_page() || is_home() ) && ! is_page(),
	);

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filters the arguments for `nudgedesignstarter_site_logo()`.
	 *
	 * @param array  $args     Parsed arguments.
	 * @param array  $defaults Function's default arguments.
	 */
	$args = apply_filters( 'nudgedesignstarter_site_logo_args', $args, $defaults );

	if ( has_custom_logo() ) {
		$contents  = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
		$classname = $args['logo_class'];
	} else {
		$contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
		$classname = $args['title_class'];
	}

	$wrap = $args['condition'] ? 'home_wrap' : 'single_wrap';

	$html = sprintf( $args[ $wrap ], $classname, $contents );

	/**
	 * Filters the arguments for `nudgedesignstarter_site_logo()`.
	 *
	 * @param string $html      Compiled html based on our arguments.
	 * @param array  $args      Parsed arguments.
	 * @param string $classname Class name based on current view, home or single.
	 * @param string $contents  HTML for site title or logo.
	 */
	$html = apply_filters( 'nudgedesignstarter_site_logo', $html, $args, $classname, $contents );

	if ( ! $echo ) {
		return $html;
	}

	echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

/**
 * Displays the site description.
 *
 * @param boolean $echo Echo or return the html.
 *
 * @return string|void $html The HTML to display.
 */
function nudgedesignstarter_site_description( $echo = true ) {
	$description = get_bloginfo( 'description' );

	if ( ! $description ) {
		return;
	}

	$wrapper = '<div class="site-description">%s</div><!-- .site-description -->';

	$html = sprintf( $wrapper, esc_html( $description ) );

	/**
	 * Filters the html for the site description.
	 *
	 * @since 1.0.0
	 *
	 * @param string $html         The HTML to display.
	 * @param string $description  Site description via `bloginfo()`.
	 * @param string $wrapper      The format used in case you want to reuse it in a `sprintf()`.
	 */
	$html = apply_filters( 'nudgedesignstarter_site_description', $html, $description, $wrapper );

	if ( ! $echo ) {
		return $html;
	}

	echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Returns whether current page title should be hidden
 * ( checks if page is front page and if customizer setting 'nudgedesignstarter_front_page_title_hidden' is actuveated )
 *
 * @return bool
 */
function nudgedesignstarter_is_front_page_title_hidden() {

	return is_front_page() && get_theme_mod( 'nudgedesignstarter_front_page_title_hidden', false );
}

/**
 * Comments
 */
/**
 * Check if the specified comment is written by the author of the post commented on.
 *
 * @param object $comment Comment data.
 *
 * @return bool
 */
function nudgedesignstarter_is_comment_by_post_author( $comment = null ) {

	if ( is_object( $comment ) && $comment->user_id > 0 ) {

		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );

		if ( ! empty( $user ) && ! empty( $post ) ) {

			return $comment->user_id === $post->post_author;

		}
	}
	return false;

}

/**
 * Filter comment reply link to not JS scroll.
 * Filter the comment reply link to add a class indicating it should not use JS slow-scroll, as it
 * makes it scroll to the wrong position on the page.
 *
 * @param string $link Link to the top of the page.
 *
 * @return string $link Link to the top of the page.
 */
function nudgedesignstarter_filter_comment_reply_link( $link ) {

	$link = str_replace( 'class=\'', 'class=\'do-not-scroll ', $link );
	return $link;

}

add_filter( 'comment_reply_link', 'nudgedesignstarter_filter_comment_reply_link' );

/**
 * Post Meta
 */
/**
 * Get and Output Post Meta.
 * If it's a single post, output the post meta values specified in the Customizer settings.
 *
 * @param int    $post_id The ID of the post for which the post meta should be output.
 * @param string $location Which post meta location to output – single or preview.
 */
function nudgedesignstarter_the_post_meta( $post_id = null, $location = 'single-top' ) {

	echo nudgedesignstarter_get_post_meta( $post_id, $location ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in nudgedesignstarter_get_post_meta().

}

/**
 * Filters the edit post link to add an icon and use the post meta structure.
 *
 * @param string $link    Anchor tag for the edit link.
 * @param int    $post_id Post ID.
 * @param string $text    Anchor text.
 */
function nudgedesignstarter_edit_post_link( $link, $post_id, $text ) {
	if ( is_admin() ) {
		return $link;
	}

	$edit_url = get_edit_post_link( $post_id );

	if ( ! $edit_url ) {
		return;
	}

	$text = sprintf(
		wp_kses(
			/* translators: %s: Post title. Only visible to screen readers. */
			__( 'Edit <span class="screen-reader-text">%s</span>', 'nudgedesignstarter' ),
			array(
				'span' => array(
					'class' => array(),
				),
			)
		),
		get_the_title( $post_id )
	);

	return '<div class="post-meta-wrapper post-meta-edit-link-wrapper"><ul class="post-meta"><li class="post-edit meta-wrapper"><span class="meta-icon">' . nudgedesignstarter_get_theme_svg( 'edit' ) . '</span><span class="meta-text"><a href="' . esc_url( $edit_url ) . '">' . $text . '</a></span></li></ul><!-- .post-meta --></div><!-- .post-meta-wrapper -->';

}

add_filter( 'edit_post_link', 'nudgedesignstarter_edit_post_link', 10, 3 );

/**
 * Get the post meta.
 *
 * @param int    $post_id The ID of the post.
 * @param string $location The location where the meta is shown.
 */
function nudgedesignstarter_get_post_meta( $post_id = null, $location = 'single-top' ) {

	// Require post ID.
	if ( ! $post_id ) {
		return;
	}

	/**
	 * Filters post types array
	 *
	 * This filter can be used to hide post meta information of post, page or custom post type registerd by child themes or plugins
	 *
	 * @since 1.0.0
	 *
	 * @param array Array of post types
	 */
	$disallowed_post_types = apply_filters( 'nudgedesignstarter_disallowed_post_types_for_meta_output', array( 'page' ) );
	// Check whether the post type is allowed to output post meta.
	if ( in_array( get_post_type( $post_id ), $disallowed_post_types, true ) ) {
		return;
	}

	$post_meta_wrapper_classes = '';
	$post_meta_classes         = '';

	// Get the post meta settings for the location specified.
	if ( 'single-header-top' === $location ) {

		/**
		 * Filters post tags visibility
		 *
		 * Use this filter to hide post meta information like Author
		 *
		 * @since 1.0.0
		 *
		 * @param array $args {
		 *   @type string 'author'
		 * }
		 */
		$post_meta                 = apply_filters(
			'nudgedesignstarter_post_meta_location_single_header_top',
			array(
				'author',
			)
		);
		$post_meta_wrapper_classes = ' post-meta-single post-meta-single-header-top';

	} elseif ( 'single-header-bottom' === $location ) {
		/**
		* Filters post meta info visibility
		*
		* Use this filter to hide post meta information like Post date, Comments, Is sticky status
		*
		* @since 1.0.0
		*
		* @param array $args {
		*  @type string 'post-date'
		*  @type string 'comments'
		*  @type string  'sticky'
		* }
		*/
		$post_meta                 = apply_filters(
			'nudgedesignstarter_post_meta_location_single_top',
			array(
				'post-date',
				'comments',
				'sticky',
			)
		);
		$post_meta_wrapper_classes = ' post-meta-single post-meta-single-header-bottom';

	} elseif ( 'single-bottom' === $location ) {

		/**
		* Filters post tags visibility
		*
		* Use this filter to hide post tags
		*
		* @since 1.0.0
		*
		* @param array $args {
		*   @type string 'tags'
		* }
		*/
		$post_meta                 = apply_filters(
			'nudgedesignstarter_post_meta_location_single_bottom',
			array(
				'tags',
			)
		);
		$post_meta_wrapper_classes = ' post-meta-single post-meta-single-bottom';

	}

	// If the post meta setting has the value 'empty', it's explicitly empty and the default post meta shouldn't be output.
	if ( $post_meta && ! in_array( 'empty', $post_meta, true ) ) {

		// Make sure we don't output an empty container.
		$has_meta = false;

		global $post;
		$the_post = get_post( $post_id );
		setup_postdata( $the_post );

		ob_start();

		?>

		<div class="post-meta-wrapper<?php echo esc_attr( $post_meta_wrapper_classes ); ?>">

			<ul class="post-meta<?php echo esc_attr( $post_meta_classes ); ?>">

				<?php

				/**
				 * Fires before post meta html display.
				 *
				 * Allow output of additional post meta info to be added by child themes and plugins.
				 *
				 * @since 1.0.0
				 *
				 * @param int   $post_ID Post ID.
				 */
				do_action( 'nudgedesignstarter_start_of_post_meta_list', $post_id );

				// Author.
				if ( in_array( 'author', $post_meta, true ) ) {

					$has_meta = true;
					?>
					<li class="post-author meta-wrapper">
						<span class="meta-text">
							<?php
							printf(
								/* translators: %s: Author name */
								esc_html__( 'By %s', 'nudgedesignstarter' ),
								'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a>'
							);
							?>
						</span>
					</li>
					<?php

				}

				// Post date.
				if ( in_array( 'post-date', $post_meta, true ) ) {

					$has_meta = true;
					?>
					<li class="post-date meta-wrapper">
						<span class="meta-text">
							<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
						</span>
					</li>
					<?php

				}

				// Tags.
				if ( in_array( 'tags', $post_meta, true ) && has_tag() ) {

					$has_meta = true;
					?>
					<li class="post-tags meta-wrapper">
						<span class="meta-icon">
							<span class="screen-reader-text"><?php esc_html_e( 'Tags', 'nudgedesignstarter' ); ?></span>
							<?php nudgedesignstarter_the_theme_svg( 'tag' ); ?>
						</span>
						<span class="meta-text">
							<?php the_tags( '', ', ', '' ); ?>
						</span>
					</li>
					<?php

				}

				// Comments link.
				if ( in_array( 'comments', $post_meta, true ) && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

					$has_meta = true;
					?>
					<li class="post-comment-link meta-wrapper">
						<span class="meta-text">
							<?php comments_popup_link(); ?>
						</span>
					</li>
					<?php

				}

				// Sticky.
				if ( in_array( 'sticky', $post_meta, true ) && is_sticky() ) {

					$has_meta = true;
					?>
					<li class="post-sticky meta-wrapper">
						<span class="meta-icon">
							<?php nudgedesignstarter_the_theme_svg( 'bookmark' ); ?>
						</span>
						<span class="meta-text">
							<?php esc_html_e( 'Sticky post', 'nudgedesignstarter' ); ?>
						</span>
					</li>
					<?php

				}

				/**
				 * Fires after post meta html display.
				 *
				 * Allow output of additional post meta info to be added by child themes and plugins.
				 *
				 * @since 1.0.0
				 *
				 * @param int   $post_ID Post ID.
				 */
				do_action( 'nudgedesignstarter_end_of_post_meta_list', $post_id );

				?>

			</ul><!-- .post-meta -->

		</div><!-- .post-meta-wrapper -->

		<?php

		wp_reset_postdata();

		$meta_output = ob_get_clean();

		// If there is meta to output, return it.
		if ( $has_meta && $meta_output ) {

			return $meta_output;

		}
	}

}

/**
 * Menus
 */
/**
 * Filter Classes of wp_list_pages items to match menu items.
 * Filter the class applied to wp_list_pages() items with children to match the menu class, to simplify.
 * styling of sub levels in the fallback. Only applied if the match_menu_classes argument is set.
 *
 * @param array  $css_class CSS Class names.
 * @param string $item Comment.
 * @param int    $depth Depth of the current comment.
 * @param array  $args An array of arguments.
 * @param string $current_page Whether or not the item is the current item.
 *
 * @return array $css_class CSS Class names.
 */
function nudgedesignstarter_filter_wp_list_pages_item_classes( $css_class, $item, $depth, $args, $current_page ) {

	// Only apply to wp_list_pages() calls with match_menu_classes set to true.
	$match_menu_classes = isset( $args['match_menu_classes'] );

	if ( ! $match_menu_classes ) {
		return $css_class;
	}

	// Add current menu item class.
	if ( in_array( 'current_page_item', $css_class, true ) ) {
		$css_class[] = 'current-menu-item';
	}

	// Add menu item has children class.
	if ( in_array( 'page_item_has_children', $css_class, true ) ) {
		$css_class[] = 'menu-item-has-children';
	}

	return $css_class;

}

add_filter( 'page_css_class', 'nudgedesignstarter_filter_wp_list_pages_item_classes', 10, 5 );

/**
 * Add a Sub Nav Toggle to the Expanded Menu and Mobile Menu.
 *
 * @param stdClass $args An array of arguments.
 * @param string   $item Menu item.
 * @param int      $depth Depth of the current menu item.
 *
 * @return stdClass $args An object of wp_nav_menu() arguments.
 */
function nudgedesignstarter_add_sub_toggles_to_main_menu( $args, $item, $depth ) {

	// Add sub menu toggles to the Expanded Menu with toggles.
	if ( isset( $args->show_toggles ) && $args->show_toggles ) {

		// Wrap the menu item link contents in a div, used for positioning.
		$args->before = '<div class="ancestor-wrapper">';
		$args->after  = '';

		// Add a toggle to items with children.
		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

			$toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' > .sub-menu';
			$toggle_duration      = nudgedesignstarter_toggle_duration();

			// Add the sub menu toggle.
			$args->after .= '<button class="toggle sub-menu-toggle fill-children-current-color" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="' . absint( $toggle_duration ) . '" aria-expanded="false"><span class="screen-reader-text">' . __( 'Show sub menu', 'nudgedesignstarter' ) . '</span>' . nudgedesignstarter_get_theme_svg( 'chevron-down' ) . '</button>';

		}

		// Close the wrapper.
		$args->after .= '</div><!-- .ancestor-wrapper -->';

		// Add sub menu icons to the primary menu without toggles.
	} elseif ( 'primary' === $args->theme_location ) {
		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
			$args->after = '<span class="icon"></span>';
		} else {
			$args->after = '';
		}
	}

	return $args;

}

add_filter( 'nav_menu_item_args', 'nudgedesignstarter_add_sub_toggles_to_main_menu', 10, 3 );

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function nudgedesignstarter_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		$svg = Nudgedesignstarter_SVG_Icons::get_social_link_svg( $item->url );
		if ( empty( $svg ) ) {
			$svg = nudgedesignstarter_get_theme_svg( 'link' );
		}
		$item_output = str_replace( $args->link_after, '</span>' . $svg, $item_output );
	}

	return $item_output;
}

add_filter( 'walker_nav_menu_start_el', 'nudgedesignstarter_nav_menu_social_icons', 10, 4 );

/**
 * Classes
 */
/**
 * Add No-JS Class.
 * If we're missing JavaScript support, the HTML element will have a no-js class.
 */
function nudgedesignstarter_no_js_class() {

	?>
	<script>document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );</script>
	<?php

}

add_action( 'wp_head', 'nudgedesignstarter_no_js_class' );

/**
 * Add conditional body classes.
 *
 * @param array $classes Classes added to the body tag.
 *
 * @return array $classes Classes added to the body tag.
 */
function nudgedesignstarter_body_classes( $classes ) {

	global $post;
	$post_type = isset( $post ) ? $post->post_type : false;

	// Check whether we're singular.
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	// Check for enabled search.
	if ( true === get_theme_mod( 'enable_header_search', true ) ) {
		$classes[] = 'enable-search-modal';
	}

	// Check for post thumbnail.
	if ( is_singular() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	} elseif ( is_singular() ) {
		$classes[] = 'missing-post-thumbnail';
	}

	// Check whether we're in the customizer preview.
	if ( is_customize_preview() ) {
		$classes[] = 'customizer-preview';
	}

	// Check if posts have single pagination.
	if ( is_single() && ( get_next_post() || get_previous_post() ) ) {
		$classes[] = 'has-single-pagination';
	} else {
		$classes[] = 'has-no-pagination';
	}

	// Check if we're showing comments.
	if ( $post && ( ( 'post' === $post_type || comments_open() || get_comments_number() ) && ! post_password_required() ) ) {
		$classes[] = 'showing-comments';
	} else {
		$classes[] = 'not-showing-comments';
	}

	// Check if avatars are visible.
	$classes[] = get_option( 'show_avatars' ) ? 'show-avatars' : 'hide-avatars';

	// Slim page template class names (class = name - file suffix).
	if ( is_page_template() ) {
		$classes[] = basename( get_page_template_slug(), '.php' );
	}

	// Check for the elements output in the top part of the footer.
	$has_sidebar_1 = is_active_sidebar( 'sidebar-1' );

	// Add a class indicating whether those elements are output.
	if ( $has_sidebar_1 ) {
		$classes[] = 'footer-top-visible';
	} else {
		$classes[] = 'footer-top-hidden';
	}

	return $classes;
}

add_filter( 'body_class', 'nudgedesignstarter_body_classes' );

/**
 * Archives
 */
/**
 * Filters the archive title and styles the word before the first colon.
 *
 * @param string $title Current archive title.
 *
 * @return string $title Current archive title.
 */
function nudgedesignstarter_get_the_archive_title( $title ) {

	$regex = apply_filters(
		'nudgedesignstarter_get_the_archive_title_regex',
		array(
			'pattern'     => '/(\A[^\:]+\:)/',
			'replacement' => '<span class="color-accent">$1</span>',
		)
	);

	if ( empty( $regex ) ) {

		return $title;

	}

	return preg_replace( $regex['pattern'], $regex['replacement'], $title );

}

add_filter( 'get_the_archive_title', 'nudgedesignstarter_get_the_archive_title' );

/**
 * Miscellaneous
 */
/**
 * Toggle animation duration in milliseconds.
 *
 * @return integer Duration in milliseconds
 */
function nudgedesignstarter_toggle_duration() {
	/**
	 * Filters the animation duration/speed used usually for submenu toggles.
	 *
	 * @since 1.0
	 *
	 * @param integer $duration Duration in milliseconds.
	 */
	$duration = apply_filters( 'nudgedesignstarter_toggle_duration', 250 );

	return $duration;
}

/**
 * Get unique ID.
 *
 * This is a PHP implementation of Underscore's uniqueId method. A static variable
 * contains an integer that is incremented with each call. This number is returned
 * with the optional prefix. As such the returned value is not universally unique,
 * but it is unique across the life of the PHP process.
 *
 * @see wp_unique_id() Themes requiring WordPress 5.0.3 and greater should use this instead.
 *
 * @staticvar int $id_counter
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
function nudgedesignstarter_unique_id( $prefix = '' ) {
	static $id_counter = 0;
	if ( function_exists( 'wp_unique_id' ) ) {
		return wp_unique_id( $prefix );
	}
	return $prefix . (string) ++$id_counter;
}

/**
 * @return string
 */
function nudgedesignstarter_get_default_footer_credit() {
	return '<a href="' . esc_url( __( 'https://wordpress.org/', 'nudgedesignstarter' ) ) . '">' .
			/* translators: %s: WordPress. */
			sprintf( esc_html__( 'Proudly powered by %s.', 'nudgedesignstarter' ), 'WordPress' ) .
		'</a>' .
		'<a href="' . esc_url( __( 'https://nudgethemes.com', 'nudgedesignstarter' ) ) . '">' .
			/* translators: %s: Pressable. */
			sprintf( esc_html__( 'Theme by %s.', 'nudgedesignstarter' ), 'Nudge Themes' ) .
		'</a>';
}
