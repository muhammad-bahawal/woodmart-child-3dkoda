<?php
/**
 * Single Product Content Template Override
 *
 * Renders the custom Apple / Bambu Lab single product landing page
 * in place of the default WooCommerce summary and gallery layout.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( function_exists( 'woodmart_child_is_filament_landing' ) && woodmart_child_is_filament_landing() ) {
	/**
	 * Hook: woocommerce_before_single_product.
	 */
	do_action( 'woocommerce_before_single_product' );

	if ( post_password_required() ) {
		echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}
	?>
	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'custom-product-landing-root filament-landing-root landing-page-root', $product ); ?>>
		<?php
		// 1. Filament Hero Section (Gallery with RFID badge, Swatches, Format cards, Summary)
		get_template_part( 'template-parts/filament/hero-section' );

		// 2. Essential Additions (3 Cross-sell cards & Baltic shipping / payment trust strip)
		get_template_part( 'template-parts/filament/essential-additions' );

		// 3. Sticky Bottom Purchase Bar
		get_template_part( 'template-parts/product/sticky-bottom-bar' );
		?>
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_single_product.
	 */
	do_action( 'woocommerce_after_single_product' );
	return;
} elseif ( function_exists( 'woodmart_child_is_custom_landing' ) && woodmart_child_is_custom_landing() ) {
	/**
	 * Hook: woocommerce_before_single_product.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 */
	do_action( 'woocommerce_before_single_product' );

	if ( post_password_required() ) {
		echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}
	?>
	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'custom-product-landing-root landing-page-root', $product ); ?>>
		<?php
		// 1. Hero Section (Gallery + Product Summary + Purchase Options + Service Benefits + Sticky Section Nav)
		get_template_part( 'template-parts/product/hero-section' );

		// 2. Highlights & Big Numbers
		get_template_part( 'template-parts/product/highlights' );

		// 3. Features (Main Hero Feature + 4-Grid Cards)
		get_template_part( 'template-parts/product/features' );

		// 4. Materials (Materials Grid + Combo Promo Banner)
		get_template_part( 'template-parts/product/materials' );

		// 5. Use Cases (4-Grid Numbered Cards)
		get_template_part( 'template-parts/product/use-cases' );

		// 6. Packages Comparison (Standalone vs Combo) & Brand Difference
		get_template_part( 'template-parts/product/pricing-variants' );

		// 7. Technical Specifications & Setup Guide Banner
		get_template_part( 'template-parts/product/specifications' );

		// 8. What's in the Box (Standalone vs Combo Package Lists)
		get_template_part( 'template-parts/product/box-contents' );

		// 9. FAQ Accordion & Bottom Orange Call To Action Banner
		get_template_part( 'template-parts/product/faq' );

		// 10. Sticky Bottom Purchase Bar
		get_template_part( 'template-parts/product/sticky-bottom-bar' );
		?>
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_single_product.
	 */
	do_action( 'woocommerce_after_single_product' );
	return;
}

// Fall back to parent theme content-single-product.php if custom landing is disabled
$parent_template = get_template_directory() . '/woocommerce/content-single-product.php';
if ( file_exists( $parent_template ) ) {
	include $parent_template;
}

