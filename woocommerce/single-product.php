<?php
/**
 * Single Product Template Override for Woodmart Child Theme
 *
 * Preserves the active Woodmart theme's global header, footer, and wrapper architecture
 * while rendering the custom Apple / Bambu Lab style single product landing page.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

// Fall back to parent theme standard single product if landing is disabled
if ( function_exists( 'woodmart_child_is_custom_landing' ) && ! woodmart_child_is_custom_landing() ) {
	$parent_template = get_template_directory() . '/woocommerce/single-product.php';
	if ( file_exists( $parent_template ) ) {
		include $parent_template;
		return;
	}
	$parent_root = get_template_directory() . '/single-product.php';
	if ( file_exists( $parent_root ) ) {
		include $parent_root;
		return;
	}
	wc_get_template( 'single-product.php' );
	return;
}

/**
 * Standard WooCommerce Theme Template Lifecycle:
 * 1. Theme Header (Woodmart Header Builder + opens .main-page-wrapper)
 * 2. Hook: woocommerce_before_main_content (wrapper & breadcrumb hooks)
 * 3. Product Loop delegating to content-single-product.php
 * 4. Hook: woocommerce_after_main_content (closing wrapper hooks)
 * 5. Theme Footer (closes .main-page-wrapper + Woodmart Footer Builder)
 */
get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );

while ( have_posts() ) :
	the_post();
	wc_get_template_part( 'content', 'single-product' );
endwhile;

do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );

