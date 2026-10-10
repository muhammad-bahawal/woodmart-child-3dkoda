<?php
/**
 * Single Product Landing Template for Woodmart Child Theme
 *
 * Forwards to canonical woocommerce/single-product.php override.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$wc_template = get_stylesheet_directory() . '/woocommerce/single-product.php';
if ( file_exists( $wc_template ) ) {
	include $wc_template;
	return;
}

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );

while ( have_posts() ) :
	the_post();
	wc_get_template_part( 'content', 'single-product' );
endwhile;

do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );

