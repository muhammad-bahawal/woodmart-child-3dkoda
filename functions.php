<?php
/**
 * Woodmart Child Theme Functions & Definitions
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

// 1. Include modular helper functions and backend meta boxes
require_once get_stylesheet_directory() . '/inc/helpers.php';
require_once get_stylesheet_directory() . '/inc/meta-boxes.php';

/**
 * 2. Enqueue Parent & Child Styles
 */
function woodmart_child_enqueue_styles() {
	$theme_version = function_exists( 'woodmart_get_theme_info' ) ? woodmart_get_theme_info( 'Version' ) : '1.0.0';

	wp_enqueue_style(
		'woodmart-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		$theme_version
	);

	wp_enqueue_style(
		'woodmart-child-style',
		get_stylesheet_uri(),
		array( 'woodmart-parent-style' ),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10 );

/**
 * 3. Enqueue Product Landing Page Assets
 */
function woodmart_child_enqueue_landing_assets() {
	if ( ! is_singular( 'product' ) || ( function_exists( 'woodmart_child_is_custom_landing' ) && ! woodmart_child_is_custom_landing() ) ) {
		return;
	}


	// Google Fonts
	wp_enqueue_style(
		'woodmart-child-landing-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Scoped Product Landing CSS
	wp_enqueue_style(
		'woodmart-child-landing-css',
		get_stylesheet_directory_uri() . '/assets/css/product-landing.css',
		array( 'woodmart-child-style' ),
		'1.0.0'
	);

	// Scoped Product Landing JS
	wp_enqueue_script(
		'woodmart-child-landing-js',
		get_stylesheet_directory_uri() . '/assets/js/product-landing.js',
		array(),
		'1.0.0',
		true
	);

	// Localize config for AJAX Add to Cart & Fragment Refresh
	wp_localize_script(
		'woodmart-child-landing-js',
		'woodmartLandingData',
		array(
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'wcAjaxUrl'      => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
			'nonce'          => wp_create_nonce( 'woodmart_child_cart_nonce' ),
			'cartUrl'        => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#',
			'checkoutUrl'    => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '#',
			'currencySymbol' => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '€',
			'i18n'           => array(
				'adding'    => __( 'Adding to sample basket...', 'woodmart-child' ),
				'added'     => __( 'Added to sample basket', 'woodmart-child' ),
				'error'     => __( 'Could not add to sample basket. Please try again.', 'woodmart-child' ),
				'view_cart' => __( 'View basket', 'woodmart-child' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_landing_assets', 99 );

/**
 * 4. Enqueue Admin Meta Box Assets (Product Edit Screen)
 *
 * @param string $hook Admin page hook.
 */
function woodmart_child_enqueue_admin_assets( $hook ) {
	global $post_type;

	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'product' !== $post_type ) {
		return;
	}

	// WordPress Media Uploader
	wp_enqueue_media();

	// Admin Meta Box Styles
	wp_enqueue_style(
		'woodmart-child-admin-meta-boxes',
		get_stylesheet_directory_uri() . '/assets/css/admin-meta-boxes.css',
		array(),
		'1.0.0'
	);

	// Admin Meta Box Scripts
	wp_enqueue_script(
		'woodmart-child-admin-meta-boxes',
		get_stylesheet_directory_uri() . '/assets/js/admin-meta-boxes.js',
		array(),
		'1.0.0',
		true
	);
}
add_action( 'admin_enqueue_scripts', 'woodmart_child_enqueue_admin_assets' );

/**
 * 5. Configure Woodmart Chrome for Custom Product Landing Page
 *
 * Keeps Woodmart's Native Header Builder and Native Footer Builder intact (main menu,
 * cart drawer, account dropdown, and mobile navigation remain fully operational),
 * while completely suppressing Woodmart's Single Product Layout Builder (Elementor layout)
 * and redundant breadcrumbs/page title blocks.
 */
function woodmart_child_configure_theme_chrome() {
	if ( ! is_singular( 'product' ) && ! ( function_exists( 'is_product' ) && is_product() ) ) {
		return;
	}

	if ( function_exists( 'woodmart_child_is_custom_landing' ) && ! woodmart_child_is_custom_landing() ) {
		return;
	}

	// 1. Suppress Woodmart Single Product Layout Builder completely
	// Woodmart's Single_Product layout attaches override_template to template_include at priority 20
	if ( class_exists( '\XTS\Modules\Layouts\Single_Product' ) ) {
		remove_filter( 'template_include', array( \XTS\Modules\Layouts\Single_Product::get_instance(), 'override_template' ), 20 );
	}

	// Filter Woodmart's layout ID resolution so has_custom_layout('single_product') evaluates to false
	add_filter( 'woodmart_layout_id', function( $layout_id ) {
		if ( is_singular( 'product' ) && function_exists( 'woodmart_child_is_custom_landing' ) && woodmart_child_is_custom_landing() ) {
			return 0;
		}
		return $layout_id;
	}, 999 );

	// Clear cached layout instance data if Woodmart XTS Layouts module is loaded
	if ( class_exists( '\XTS\Modules\Layouts\Global_Data' ) && method_exists( '\XTS\Modules\Layouts\Global_Data', 'get_instance' ) ) {
		$global_data = \XTS\Modules\Layouts\Global_Data::get_instance();
		if ( method_exists( $global_data, 'set_data' ) ) {
			$global_data->set_data( 'single_product', 0 );
		}
	}

	// 2. Suppress Woodmart default page title banner and breadcrumbs (custom layout has its own hero)
	add_filter( 'woodmart_page_title', '__return_false', 999 );
	add_filter( 'woodmart_sidebar_layout', function() { return 'none'; }, 999 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	// 3. Suppress Woodmart default sticky add to cart bar to avoid conflict with our custom sticky bar
	add_filter( 'woodmart_get_opt_sticky_add_to_cart', '__return_false', 999 );
	add_filter( 'woodmart_sticky_add_to_cart', '__return_false', 999 );
}
add_action( 'wp', 'woodmart_child_configure_theme_chrome', 1 );
add_action( 'template_redirect', 'woodmart_child_configure_theme_chrome', 1 );

/**
 * Early template_include safety net: detach Woodmart Single Product Layout
 * override before priority 20 fires, ensuring standard WooCommerce template resolution.
 *
 * @param string $template Template path.
 * @return string
 */
function woodmart_child_suppress_layout_builder_on_template_include( $template ) {
	if ( is_singular( 'product' ) && function_exists( 'woodmart_child_is_custom_landing' ) && woodmart_child_is_custom_landing() ) {
		if ( class_exists( '\XTS\Modules\Layouts\Single_Product' ) ) {
			remove_filter( 'template_include', array( \XTS\Modules\Layouts\Single_Product::get_instance(), 'override_template' ), 20 );
		}
	}
	return $template;
}
add_filter( 'template_include', 'woodmart_child_suppress_layout_builder_on_template_include', 19 );


/**
 * Ensure body classes on custom landing products include custom-landing-canvas
 *
 * @param array $classes Body classes.
 * @return array
 */
function woodmart_child_landing_body_classes( $classes ) {
	if ( is_singular( 'product' ) ) {
		if ( function_exists( 'woodmart_child_is_custom_landing' ) && ! woodmart_child_is_custom_landing() ) {
			return $classes;
		}
		$classes[] = 'custom-landing-canvas';
		$classes[] = 'custom-product-landing-body';
	}
	return array_unique( $classes );
}
add_filter( 'body_class', 'woodmart_child_landing_body_classes' );


/**
 * 7. Native WooCommerce AJAX Add-to-Cart Endpoint (Simple & Variable)
 */
function woodmart_child_ajax_add_to_cart() {
	check_ajax_referer( 'woodmart_child_cart_nonce', 'security' );

	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		wp_send_json_error( array( 'message' => __( 'WooCommerce cart session is not active.', 'woodmart-child' ) ) );
	}

	$product_id   = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : ( isset( $_POST['add-to-cart'] ) ? absint( $_POST['add-to-cart'] ) : 0 );
	$quantity     = isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : 1;
	$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => __( 'Invalid product ID.', 'woodmart-child' ) ) );
	}

	$product = wc_get_product( $product_id );
	if ( ! $product ) {
		wp_send_json_error( array( 'message' => __( 'Product not found.', 'woodmart-child' ) ) );
	}

	// Initialize customer session cookie if not yet active
	if ( WC()->session && ! WC()->session->has_session() ) {
		WC()->session->set_customer_session_cookie( true );
	}

	$cart_item_key = false;

	try {
		// Handle Variable Product
		if ( $product->is_type( 'variable' ) ) {
			if ( ! $variation_id ) {
				// Select first available variation
				$available = $product->get_available_variations();
				if ( ! empty( $available[0]['variation_id'] ) ) {
					$variation_id = $available[0]['variation_id'];
				}
			}

			$variation_obj = wc_get_product( $variation_id );
			if ( ! $variation_obj || ! $variation_obj->is_purchasable() || ! $variation_obj->is_in_stock() ) {
				wp_send_json_error( array( 'message' => __( 'This variation is currently unavailable or out of stock.', 'woodmart-child' ) ) );
			}

			$variation_attrs = $variation_obj->get_variation_attributes();
			$cart_item_key   = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation_attrs );
		} else {
			// Handle Simple Product
			if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
				wp_send_json_error( array( 'message' => __( 'This product is currently unavailable or out of stock.', 'woodmart-child' ) ) );
			}

			$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity );
		}
	} catch ( Exception $e ) {
		wp_send_json_error( array( 'message' => $e->getMessage() ) );
	}

	if ( $cart_item_key ) {
		// Calculate refreshed fragments
		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();

		$data = array(
			'cart_hash'  => WC()->cart->get_cart_hash(),
			'cart_count' => WC()->cart->get_cart_contents_count(),
			'fragments'  => apply_filters(
				'woocommerce_add_to_cart_fragments',
				array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
				)
			),
			'message'    => __( 'Product successfully added to basket.', 'woodmart-child' ),
		);

		wp_send_json_success( $data );
	} else {
		$notices   = wc_get_notices( 'error' );
		$error_msg = ! empty( $notices[0]['notice'] ) ? wp_strip_all_tags( $notices[0]['notice'] ) : __( 'Failed to add item to basket.', 'woodmart-child' );
		wc_clear_notices();

		wp_send_json_error( array( 'message' => $error_msg ) );
	}
}
add_action( 'wp_ajax_woodmart_child_add_to_cart', 'woodmart_child_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_woodmart_child_add_to_cart', 'woodmart_child_ajax_add_to_cart' );
