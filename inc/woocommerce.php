<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function nudgedesignstarter_woocommerce_theme_support() {
	// Woocommerce support
	add_theme_support( 'woocommerce' );

	// Add gallery features
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support(
		'woocommerce',
		array(
			'gallery_thumbnail_image_width' => 200,
		)
	);
}

add_action( 'after_setup_theme', 'nudgedesignstarter_woocommerce_theme_support' );

// Remove styles
function nudgedesignstarter_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );    // Remove the gloss
	return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'nudgedesignstarter_dequeue_styles' );


if ( ! function_exists( 'nudgedesignstarter_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function nudgedesignstarter_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		nudgedesignstarter_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'nudgedesignstarter_woocommerce_cart_link_fragment' );


/**
 * Cart Link.
 *
 * Displayed a link to the cart including the number of items present and the cart total.
 *
 * @return void
 */
function nudgedesignstarter_woocommerce_cart_link() {
	$cart_count = WC()->cart->get_cart_contents_count();
	?>
	<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'nudgedesignstarter' ); ?>" aria-label="<?php esc_attr_e( 'View your shopping cart', 'nudgedesignstarter' ); ?>">
	<?php
		nudgedesignstarter_the_theme_svg( 'cart' );
	if ( $cart_count > 0 ) {
		?>
		<span class="count" aria-label="<?php esc_attr_e( 'Number of items in your cart', 'nudgedesignstarter' ); ?>"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span> <?php } ?>
	</a>
			<?php
}

/**
 * Display Header Cart.
 *
 * @return void
 */
if ( class_exists( 'WooCommerce' ) ) {
	function nudgedesignstarter_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}

		$shop_page_object = get_post( wc_get_page_id( 'shop' ) );
		if ( empty( $shop_page_object ) ) {
			return;
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php nudgedesignstarter_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

function nudgedesignstarter_template_hooks() {

	/*
	 * Shop page
	 */
	//remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

	/**
	 * Cart page
	 */
	//remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	//add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 5 );

}
add_action( 'init', 'nudgedesignstarter_template_hooks' );

/**
 * Set amount of Cross Sells columns
 *
 * @param $columns
 * @return int
 */
function nudgedesignstarter_change_cross_sells_columns( $columns ) {
	return 4;
}
add_filter( 'woocommerce_cross_sells_columns', 'nudgedesignstarter_change_cross_sells_columns' );


/**
 * Display an 'Out of Stock' label on archive pages
 *
 */

function nudgedesignstarter_woocommerce_template_loop_stock() {
	global $product;
	if ( ! $product->managing_stock() && ! $product->is_in_stock() ) {
		echo '<p class="stock out-of-stock">' . esc_html__( 'Out of Stock', 'nudgedesignstarter' ) . '</p>';
	}
}


/**
 * Move store notice to top of page
 *
 */
function nudgedesignstarter_move_store_notice() {

	remove_action( 'wp_footer', 'woocommerce_demo_store' );
}

add_action( 'init', 'nudgedesignstarter_move_store_notice' );


/**
 * Check if WooCommerce is activated
 */

function nudgedesignstarter_wc_body_classes( $classes ) {

	if ( class_exists( 'woocommerce' ) ) {

		$classes[] = 'woocommerce-active';
	}

	return $classes;
}

add_filter( 'body_class', 'nudgedesignstarter_wc_body_classes' );

