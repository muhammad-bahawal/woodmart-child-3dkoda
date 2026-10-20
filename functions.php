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
require_once get_stylesheet_directory() . '/inc/laser-crafting-meta-boxes.php';
require_once get_stylesheet_directory() . '/inc/ams-meta-boxes.php';

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

	// Dynamic versioning to bust browser cache on updates
	$css_file = get_stylesheet_directory() . '/assets/css/product-landing.css';
	$js_file  = get_stylesheet_directory() . '/assets/js/product-landing.js';
	$css_ver  = file_exists( $css_file ) ? (string) filemtime( $css_file ) : '1.0.5';
	$js_ver   = file_exists( $js_file ) ? (string) filemtime( $js_file ) : '1.0.5';

	// Scoped Product Landing CSS
	wp_enqueue_style(
		'woodmart-child-landing-css',
		get_stylesheet_directory_uri() . '/assets/css/product-landing.css',
		array( 'woodmart-child-style' ),
		$css_ver
	);

	// Scoped Accessories Landing CSS (Only on Accessories Landing Pages)
	if ( function_exists( 'woodmart_child_is_accessories_landing' ) && woodmart_child_is_accessories_landing() ) {
		$acc_css_file = get_stylesheet_directory() . '/assets/css/accessories-landing.css';
		$acc_css_ver  = file_exists( $acc_css_file ) ? (string) filemtime( $acc_css_file ) : '1.0.0';
		wp_enqueue_style(
			'woodmart-child-accessories-landing-css',
			get_stylesheet_directory_uri() . '/assets/css/accessories-landing.css',
			array( 'woodmart-child-landing-css' ),
			$acc_css_ver
		);
	}

	// Scoped Laser & Crafting Landing CSS (Only on Laser & Crafting Landing Pages)
	if ( function_exists( 'woodmart_child_is_laser_crafting_landing' ) && woodmart_child_is_laser_crafting_landing() ) {
		$lc_css_file = get_stylesheet_directory() . '/assets/css/laser-crafting-landing.css';
		$lc_css_ver  = file_exists( $lc_css_file ) ? (string) filemtime( $lc_css_file ) : '1.0.0';
		wp_enqueue_style(
			'woodmart-child-laser-crafting-landing-css',
			get_stylesheet_directory_uri() . '/assets/css/laser-crafting-landing.css',
			array( 'woodmart-child-landing-css' ),
			$lc_css_ver
		);
	}

	// Scoped AMS Landing CSS (Only on AMS Landing Pages)
	if ( function_exists( 'woodmart_child_is_ams_landing' ) && woodmart_child_is_ams_landing() ) {
		$ams_css_file = get_stylesheet_directory() . '/assets/css/ams-landing.css';
		$ams_css_ver  = file_exists( $ams_css_file ) ? (string) filemtime( $ams_css_file ) : '1.0.0';
		wp_enqueue_style(
			'woodmart-child-ams-landing-css',
			get_stylesheet_directory_uri() . '/assets/css/ams-landing.css',
			array( 'woodmart-child-landing-css' ),
			$ams_css_ver
		);
	}

	// Scoped Product Landing JS
	wp_enqueue_script(
		'woodmart-child-landing-js',
		get_stylesheet_directory_uri() . '/assets/js/product-landing.js',
		array(),
		$js_ver,
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
			'currencySymbol' => '€',
			'i18n'           => array(
				'adding'    => __( 'Adding to basket...', 'woodmart-child' ),
				'added'     => __( 'Added to basket', 'woodmart-child' ),
				'error'     => __( 'Could not add to basket. Please try again.', 'woodmart-child' ),
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

	$admin_css = get_stylesheet_directory() . '/assets/css/admin-meta-boxes.css';
	$admin_js  = get_stylesheet_directory() . '/assets/js/admin-meta-boxes.js';
	$admin_css_ver = file_exists( $admin_css ) ? (string) filemtime( $admin_css ) : '1.1.0';
	$admin_js_ver  = file_exists( $admin_js ) ? (string) filemtime( $admin_js ) : '1.1.0';

	// Admin Meta Box Styles
	wp_enqueue_style(
		'woodmart-child-admin-meta-boxes',
		get_stylesheet_directory_uri() . '/assets/css/admin-meta-boxes.css',
		array(),
		$admin_css_ver
	);

	// Admin Meta Box Scripts
	wp_enqueue_script(
		'woodmart-child-admin-meta-boxes',
		get_stylesheet_directory_uri() . '/assets/js/admin-meta-boxes.js',
		array(),
		$admin_js_ver,
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
		if ( function_exists( 'woodmart_child_is_laser_crafting_landing' ) && woodmart_child_is_laser_crafting_landing() ) {
			$classes[] = 'laser-crafting-landing-canvas';
			$classes[] = 'laser-crafting-product-page';
		}
		if ( function_exists( 'woodmart_child_is_ams_landing' ) && woodmart_child_is_ams_landing() ) {
			$classes[] = 'ams-landing-canvas';
			$classes[] = 'ams-product-page';
		}
	}
	return array_unique( $classes );
}
add_filter( 'body_class', 'woodmart_child_landing_body_classes' );


/**
 * 7. Native WooCommerce AJAX Add-to-Cart Endpoint (Simple & Variable)
 */
function woodmart_child_ajax_add_to_cart() {
	// Start output buffering to prevent accidental PHP notices from corrupting the JSON response
	ob_start();

	check_ajax_referer( 'woodmart_child_cart_nonce', 'security' );

	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		while ( ob_get_level() > 0 ) {
			ob_end_clean();
		}
		wp_send_json_error( array( 'message' => __( 'WooCommerce cart session is not active.', 'woodmart-child' ) ) );
	}

	$product_id   = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : ( isset( $_POST['add-to-cart'] ) ? absint( $_POST['add-to-cart'] ) : 0 );
	$quantity     = isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : 1;
	$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;

	if ( ! $product_id ) {
		while ( ob_get_level() > 0 ) {
			ob_end_clean();
		}
		wp_send_json_error( array( 'message' => __( 'Invalid product ID.', 'woodmart-child' ) ) );
	}

	$product = wc_get_product( $product_id );
	if ( ! $product ) {
		while ( ob_get_level() > 0 ) {
			ob_end_clean();
		}
		wp_send_json_error( array( 'message' => __( 'Product not found.', 'woodmart-child' ) ) );
	}

	// Initialize customer session cookie if not yet active
	if ( WC()->session && ! WC()->session->has_session() ) {
		WC()->session->set_customer_session_cookie( true );
	}

	$cart_item_data = array();
	if ( ! empty( $_POST['addition_option'] ) ) {
		$cart_item_data['addition_option'] = sanitize_text_field( wp_unslash( $_POST['addition_option'] ) );
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
				while ( ob_get_level() > 0 ) {
					ob_end_clean();
				}
				wp_send_json_error( array( 'message' => __( 'This variation is currently unavailable or out of stock.', 'woodmart-child' ) ) );
			}

			$variation_attrs = $variation_obj->get_variation_attributes();
			$cart_item_key   = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation_attrs, $cart_item_data );
		} else {
			// Handle Simple Product
			if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
				while ( ob_get_level() > 0 ) {
					ob_end_clean();
				}
				wp_send_json_error( array( 'message' => __( 'This product is currently unavailable or out of stock.', 'woodmart-child' ) ) );
			}

			$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, 0, array(), $cart_item_data );
		}
	} catch ( Exception $e ) {
		while ( ob_get_level() > 0 ) {
			ob_end_clean();
		}
		wp_send_json_error( array( 'message' => $e->getMessage() ) );
	}

	if ( $cart_item_key ) {
		// Calculate refreshed fragments safely
		$mini_cart = '';
		try {
			if ( function_exists( 'woocommerce_mini_cart' ) ) {
				ob_start();
				woocommerce_mini_cart();
				$mini_cart = ob_get_clean();
			}
		} catch ( Throwable $t ) {
			$mini_cart = '';
		}

		$fragments = array();
		if ( ! empty( $mini_cart ) ) {
			$fragments['div.widget_shopping_cart_content'] = '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>';
		}

		try {
			if ( function_exists( 'apply_filters' ) ) {
				$fragments = apply_filters( 'woocommerce_add_to_cart_fragments', $fragments );
			}
		} catch ( Throwable $t ) {
			// fallback without extra fragments
		}

		$data = array(
			'cart_hash'  => WC()->cart ? WC()->cart->get_cart_hash() : '',
			'cart_count' => WC()->cart ? WC()->cart->get_cart_contents_count() : 1,
			'fragments'  => $fragments,
			'message'    => __( 'Product successfully added to basket.', 'woodmart-child' ),
		);

		// Discard any buffered notices/warnings prior to sending pure JSON
		while ( ob_get_level() > 0 ) {
			ob_end_clean();
		}

		wp_send_json_success( $data );
	} else {
		$notices   = wc_get_notices( 'error' );
		$error_msg = ! empty( $notices[0]['notice'] ) ? wp_strip_all_tags( $notices[0]['notice'] ) : __( 'Failed to add item to basket.', 'woodmart-child' );
		wc_clear_notices();

		while ( ob_get_level() > 0 ) {
			ob_end_clean();
		}

		wp_send_json_error( array( 'message' => $error_msg ) );
	}
}
add_action( 'wp_ajax_woodmart_child_add_to_cart', 'woodmart_child_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_woodmart_child_add_to_cart', 'woodmart_child_ajax_add_to_cart' );

/**
 * Display Custom Essential Addition Option in Cart & Mini Cart
 */
function woodmart_child_display_addition_option_cart( $item_data, $cart_item ) {
	if ( ! empty( $cart_item['addition_option'] ) ) {
		$item_data[] = array(
			'key'   => __( 'Option', 'woodmart-child' ),
			'value' => wc_clean( $cart_item['addition_option'] ),
		);
	}
	return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'woodmart_child_display_addition_option_cart', 10, 2 );

/**
 * Save Custom Essential Addition Option to WooCommerce Order Item Meta
 */
function woodmart_child_add_addition_option_to_order_items( $item, $cart_item_key, $values, $order ) {
	if ( ! empty( $values['addition_option'] ) ) {
		$item->add_meta_data( __( 'Option', 'woodmart-child' ), $values['addition_option'], true );
	}
}
add_action( 'woocommerce_checkout_create_order_line_item', 'woodmart_child_add_addition_option_to_order_items', 10, 4 );

/**
 * ============================================================================
 * 8. CUSTOM WOOCOMMERCE LOGIN & REGISTER AUTH SPLIT-SCREEN HANDLERS
 * ============================================================================
 */

/**
 * Enqueue dedicated styling & interactivity for guest users on My Account page
 */
function woodmart_child_enqueue_auth_assets() {
	if ( ! function_exists( 'is_account_page' ) || ! is_account_page() || is_user_logged_in() ) {
		return;
	}

	// Google Fonts
	wp_enqueue_style(
		'woodmart-child-auth-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap',
		array(),
		null
	);

	$css_file = get_stylesheet_directory() . '/assets/css/myaccount-auth.css';
	$js_file  = get_stylesheet_directory() . '/assets/js/myaccount-auth.js';
	$css_ver  = file_exists( $css_file ) ? (string) filemtime( $css_file ) : '1.0.0';
	$js_ver   = file_exists( $js_file ) ? (string) filemtime( $js_file ) : '1.0.0';

	// Dedicated Auth Split-Screen CSS
	wp_enqueue_style(
		'woodmart-child-auth-css',
		get_stylesheet_directory_uri() . '/assets/css/myaccount-auth.css',
		array(),
		$css_ver
	);

	// Dedicated Auth Split-Screen JS
	wp_enqueue_script(
		'woodmart-child-auth-js',
		get_stylesheet_directory_uri() . '/assets/js/myaccount-auth.js',
		array(),
		$js_ver,
		true
	);

	// Dequeue theme header builder script to prevent sticky header offset injection
	wp_dequeue_script( 'wd-header-builder' );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_auth_assets', 100 );

/**
 * Append unique scoped body class for unauthenticated My Account view
 *
 * @param array $classes Body classes.
 * @return array
 */
function woodmart_child_auth_body_classes( $classes ) {
	if ( function_exists( 'is_account_page' ) && is_account_page() && ! is_user_logged_in() ) {
		$classes[] = 'koda-auth-page';
	}
	return array_unique( $classes );
}
add_filter( 'body_class', 'woodmart_child_auth_body_classes' );

/**
 * Suppress WoodMart theme chrome (Page Title, Breadcrumbs, Sidebar, Footer) on Auth screen
 */
function woodmart_child_configure_auth_chrome() {
	if ( ! function_exists( 'is_account_page' ) || ! is_account_page() || is_user_logged_in() ) {
		return;
	}

	add_filter( 'woodmart_page_title', '__return_false', 999 );
	add_filter( 'woodmart_sidebar_layout', function() { return 'none'; }, 999 );
	add_filter( 'woodmart_get_opt_footer', '__return_false', 999 );
	add_filter( 'woodmart_footer_builder', '__return_false', 999 );
	add_filter( 'woodmart_get_opt_sticky_header', '__return_false', 999 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	// Remove default WooCommerce registration privacy policy text (handled by custom agreement checkbox)
	remove_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );
	add_filter( 'woocommerce_get_privacy_policy_text', function( $text, $type ) {
		if ( 'registration' === $type ) {
			return '';
		}
		return $text;
	}, 999, 2 );
}
add_action( 'wp', 'woodmart_child_configure_auth_chrome', 1 );
add_action( 'template_redirect', 'woodmart_child_configure_auth_chrome', 1 );

/**
 * Ensure native WooCommerce registration is permitted on My Account page
 */
add_filter( 'pre_option_woocommerce_enable_myaccount_registration', function() {
	return 'yes';
} );

/**
 * Ensure user defines their own password upon registration (matches UI password field)
 */
add_filter( 'pre_option_woocommerce_registration_generate_password', function() {
	return 'no';
} );

/**
 * Generate username automatically from email address
 */
add_filter( 'pre_option_woocommerce_registration_generate_username', function() {
	return 'yes';
} );

/**
 * Validate Custom Registration Fields (Full Name, Terms agreement, and Password length)
 *
 * @param WP_Error $errors Validation errors.
 * @param string   $username Username.
 * @param string   $email Email.
 * @return WP_Error
 */
function woodmart_child_validate_auth_registration( $errors, $username, $email ) {
	if ( isset( $_POST['register'] ) ) {
		if ( empty( $_POST['account_full_name'] ) || '' === trim( (string) $_POST['account_full_name'] ) ) {
			$errors->add( 'full_name_error', __( 'Please enter your full name.', 'woodmart-child' ) );
		}

		if ( empty( $_POST['terms_privacy_agreed'] ) ) {
			$errors->add( 'terms_error', __( 'Please agree to the Terms of Service and Privacy Policy.', 'woodmart-child' ) );
		}

		if ( isset( $_POST['password'] ) && strlen( (string) $_POST['password'] ) < 8 ) {
			$errors->add( 'password_length_error', __( 'Password must be at least 8 characters long.', 'woodmart-child' ) );
		}
	}
	return $errors;
}
add_filter( 'woocommerce_registration_errors', 'woodmart_child_validate_auth_registration', 10, 3 );

/**
 * Save Customer Full Name and Marketing Opt-in on successful registration
 *
 * @param int $customer_id Customer user ID.
 */
function woodmart_child_save_auth_registration_fields( $customer_id ) {
	if ( ! empty( $_POST['account_full_name'] ) ) {
		$full_name  = sanitize_text_field( wp_unslash( $_POST['account_full_name'] ) );
		$parts      = explode( ' ', $full_name, 2 );
		$first_name = trim( $parts[0] );
		$last_name  = isset( $parts[1] ) ? trim( $parts[1] ) : '';

		wp_update_user(
			array(
				'ID'           => $customer_id,
				'first_name'   => $first_name,
				'last_name'    => $last_name,
				'display_name' => $full_name,
			)
		);

		update_user_meta( $customer_id, 'first_name', $first_name );
		update_user_meta( $customer_id, 'last_name', $last_name );
		update_user_meta( $customer_id, 'billing_first_name', $first_name );
		update_user_meta( $customer_id, 'billing_last_name', $last_name );
	}

	if ( ! empty( $_POST['newsletter_optin'] ) ) {
		update_user_meta( $customer_id, 'marketing_optin', 1 );
	}
}
add_action( 'woocommerce_created_customer', 'woodmart_child_save_auth_registration_fields', 10, 1 );

/**
 * Direct Redirect to My Account Page on Header "Login / Register" Click
 *
 * Prevents WoodMart from opening the off-canvas side login drawer for guest users,
 * redirecting them directly to the custom split-screen My Account login/register page.
 */
function woodmart_child_direct_header_login_redirect() {
	if ( is_user_logged_in() ) {
		return;
	}

	$myaccount_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' );
	?>
	<style id="koda-disable-side-login-css">
		/* Suppress off-canvas login drawer for guest users in favor of direct page redirect */
		.login-form-side,
		.wd-side-hidden.login-form-side {
			display: none !important;
		}
	</style>
	<script id="koda-direct-header-login-js">
		(function() {
			'use strict';
			var targetUrl = <?php echo wp_json_encode( esc_url_raw( $myaccount_url ) ); ?>;

			// 1. Remove .login-side-opener class from header account elements to neutralize theme drawer trigger
			function removeOpenerClasses() {
				var openers = document.querySelectorAll('.wd-header-my-account.login-side-opener, .login-side-opener');
				for (var i = 0; i < openers.length; i++) {
					openers[i].classList.remove('login-side-opener');
				}
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', removeOpenerClasses);
			} else {
				removeOpenerClasses();
			}

			// 2. Intercept clicks in the CAPTURING phase before WoodMart's jQuery listeners execute
			document.addEventListener('click', function(e) {
				if (document.body.classList.contains('logged-in')) {
					return;
				}

				var trigger = e.target.closest('.wd-header-my-account, .login-side-opener, .menu-item-my-account');
				if (!trigger) {
					return;
				}

				var link = trigger.tagName === 'A' ? trigger : trigger.querySelector('a');
				var destination = (link && link.href && link.href !== '#' && !link.href.startsWith('javascript:')) ? link.href : targetUrl;

				// Prevent WoodMart off-canvas sidebar from triggering
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();

				// Navigate directly to the My Account login/register page
				window.location.href = destination;
			}, true); // Event capturing: runs at the earliest possible stage
		})();
	</script>
	<?php
}
add_action( 'wp_footer', 'woodmart_child_direct_header_login_redirect', 5 );

/**
 * 15. Strict Storewide Currency Consistency: Baltic Store EUR (€)
 *
 * Ensures all WooCommerce price methods, cart blocks, and landing builders
 * render strictly with the Euro symbol (€) and EUR currency.
 */
add_filter( 'woocommerce_currency', function( $currency ) {
	return 'EUR';
}, 999 );

add_filter( 'woocommerce_currency_symbol', function( $currency_symbol, $currency ) {
	return '€';
}, 999, 2 );

add_filter( 'woocommerce_price_format', function( $format, $currency_pos ) {
	return '€%2$s';
}, 999, 2 );





// 1. Smart Loop Button URL Shortcode
add_shortcode('loop_smart_cart_url', function() {
    global $product;
    if ( ! $product && function_exists('wc_get_product') ) {
        $product = wc_get_product( get_the_ID() );
    }
    
    if ( ! $product ) {
        return esc_url( get_permalink() );
    }
    
    if ( $product->is_type( 'variable' ) || $product->is_type( 'grouped' ) ) {
        return esc_url( $product->get_permalink() );
    }
    
    return esc_url( $product->add_to_cart_url() );
});

// 2. Reliable AJAX Handler for Elementor Button & Woodmart Drawer
add_action('wp_footer', function() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Parent container ya direct link dono par click capture karega
        $(document).on('click', 'a[href*="add-to-cart="], .ajax_add_to_cart a, a.ajax_add_to_cart', function(e) {
            var $link = $(this);
            var href = $link.attr('href');
            
            if (!href || href.indexOf('add-to-cart=') === -1) {
                return; // Variable products ke normal permalink par kuch na kare
            }
            
            // Default page navigation aur reload rok diya
            e.preventDefault();
            e.stopPropagation();
            
            var match = href.match(/add-to-cart=([0-9]+)/);
            if (!match) return;
            var productId = match[1];
            
            $link.addClass('loading');
            
            // Direct WooCommerce AJAX call
            $.ajax({
                type: 'POST',
                url: '?wc-ajax=add_to_cart',
                data: {
                    product_id: productId,
                    quantity: 1
                },
                dataType: 'json',
                success: function(response) {
                    $link.removeClass('loading');
                    
                    if (response.error && response.product_url) {
                        window.location.href = response.product_url;
                        return;
                    }
                    
                    // WooCommerce & Woodmart cart fragments update trigger
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $link]);
                    
                    // Woodmart Side Mini-Cart Drawer Open
                    setTimeout(function() {
                        if ($('.cart-widget-opener').length) {
                            $('.cart-widget-opener').trigger('click');
                        } else if ($('.woodmart-cart-icon').length) {
                            $('.woodmart-cart-icon').trigger('click');
                        } else {
                            $('body').addClass('woodmart-cart-opened');
                            $('.woodmart-close-side').addClass('woodmart-close-side-opened');
                        }
                    }, 100);
                },
                error: function() {
                    $link.removeClass('loading');
                    window.location.href = href;
                }
            });
        });
    });
    </script>
    <?php
}, 999);