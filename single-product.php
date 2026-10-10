<?php
/**
 * Single Product Template for Woodmart Child Theme
 *
 * Forwards to woocommerce/single-product.php to maintain standard
 * WooCommerce template override hierarchy.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$wc_template = get_stylesheet_directory() . '/woocommerce/single-product.php';
if ( file_exists( $wc_template ) ) {
	include $wc_template;
	return;
}

$parent_wc = get_template_directory() . '/woocommerce/single-product.php';
if ( file_exists( $parent_wc ) ) {
	include $parent_wc;
	return;
}

$parent_template = get_template_directory() . '/single-product.php';
if ( file_exists( $parent_template ) ) {
	include $parent_template;
	return;
}

wc_get_template( 'single-product.php' );

