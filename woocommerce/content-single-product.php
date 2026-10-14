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

if ( function_exists( 'woodmart_child_is_accessories_landing' ) && woodmart_child_is_accessories_landing() ) {
	/**
	 * Hook: woocommerce_before_single_product.
	 */
	do_action( 'woocommerce_before_single_product' );

	if ( post_password_required() ) {
		echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}
	?>
	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'custom-product-landing-root accessories-landing-root landing-page-root', $product ); ?>>
		<?php
		// 1. Accessories Hero Section (2-column layout, left vertical thumbnails, variable attributes, live price, AJAX Add to Cart)
		get_template_part( 'template-parts/product-accessories/hero-section' );

		// 2. Overview / Key Selling Points (Split feature highlights & high-impact visual)
		get_template_part( 'template-parts/product-accessories/overview-features' );

		// 3. Feature Visuals / Performance Comparison (Layer height finish, 4-column nozzle table, Benchy hull cards, Speed/Strength chart)
		get_template_part( 'template-parts/product-accessories/visual-showcase' );

		// 4. Filament & Material Compatibility Matrix
		get_template_part( 'template-parts/product-accessories/compatibility-matrix' );

		// 5. Technical Specifications (Label & Value grid)
		get_template_part( 'template-parts/product-accessories/specifications' );

		// 6. What's in the Box (Complete Assembly vs Nozzle Only)
		get_template_part( 'template-parts/product-accessories/box-contents' );

		// 7. FAQ & High-Conversion CTA Banner
		get_template_part( 'template-parts/product-accessories/faq' );

		// 8. Sticky Bottom Purchase Bar
		get_template_part( 'template-parts/product-accessories/sticky-bottom-bar' );
		?>
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_single_product.
	 */
	do_action( 'woocommerce_after_single_product' );
	return;
} elseif ( function_exists( 'woodmart_child_is_printer_landing' ) && woodmart_child_is_printer_landing() ) {
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
} elseif ( function_exists( 'woodmart_child_is_filament_landing' ) && woodmart_child_is_filament_landing() ) {
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

		// 3. In-Page Sticky Navigation
		get_template_part( 'template-parts/filament/sub-nav' );

		// 4. Flagship Formulation Showcase Banner (Dark)
		get_template_part( 'template-parts/filament/formulation' );

		// 5. Find the Perfect Color Showcase
		get_template_part( 'template-parts/filament/colors-showcase' );

		// 6. Material Overview (4 Cards: PLA, PETG, ABS/ASA, CF)
		get_template_part( 'template-parts/filament/materials' );

		// 7. Smart Material Detection (Built for RFID & AMS Compatibility)
		get_template_part( 'template-parts/filament/rfid-ams' );

		// 8. Where It Earns Its Place (Dark Use Cases Grid)
		get_template_part( 'template-parts/filament/use-cases' );

		// 9. Choose Your Format (Complete Spool vs Refill?)
		get_template_part( 'template-parts/filament/choose-format' );

		// 10. The 3DKoda Difference (Local Team Behind It - Dark)
		get_template_part( 'template-parts/filament/brand-difference' );

		// 11. Technical Specifications (PLA Parameters Table)
		get_template_part( 'template-parts/filament/specifications' );

		// 12. Recommended Print Settings (Ice-blue box with Starting Settings & Mini Buy Box)
		get_template_part( 'template-parts/filament/recommended-settings' );

		// 13. Downloads & Technical Documents (5x2 Grid of PDF Cards)
		get_template_part( 'template-parts/filament/downloads' );

		// 14. Printing Tips Accordion
		get_template_part( 'template-parts/filament/printing-tips' );

		// 15. What's in the Box (Complete Spool vs Refill)
		get_template_part( 'template-parts/filament/box-contents' );

		// 16. Questions Answered (FAQ) & Bottom Orange CTA Banner
		get_template_part( 'template-parts/filament/faq' );

		// 17. Sticky Bottom Purchase Bar
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

