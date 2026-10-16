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

if ( function_exists( 'woodmart_child_is_laser_crafting_landing' ) && woodmart_child_is_laser_crafting_landing() ) {
	/**
	 * Hook: woocommerce_before_single_product.
	 */
	do_action( 'woocommerce_before_single_product' );

	if ( post_password_required() ) {
		echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}
	?>
	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'custom-product-landing-root laser-crafting-landing-root laser-crafting-canvas landing-page-root', $product ); ?>>
		<?php
		// 1. Hero Section (Image 1: 2-Column Hero + Dynamic Variations + Essential Additions)
		get_template_part( 'template-parts/product-laser-crafting/hero-section' );

		// 2. Sticky In-Page Navigation Bar (Image 2: Overview | Dive in | Specs | FAQ)
		get_template_part( 'template-parts/product-laser-crafting/sub-nav' );

		// 3. Overview Banner (Image 2: "Bambu Lab A2L - Creative Playground. Extra Large." + Watch Video)
		get_template_part( 'template-parts/product-laser-crafting/overview-banner' );

		// 4. Why Choose Bambu Lab A2L (Image 3: 6-Card Grid Feature Showcase)
		get_template_part( 'template-parts/product-laser-crafting/why-choose' );

		// 5. Community Showcase Slider (Image 4: "Printing Is a Blast When There's Always Something New on the Menu")
		get_template_part( 'template-parts/product-laser-crafting/community-slider' );

		// 6. Oversized Build Volume Deep-Dive (Image 5: 330x320x325mm Volume Cube + A1 vs A2L Sword Comparison)
		get_template_part( 'template-parts/product-laser-crafting/build-volume' );

		// 7. Multi-Tool & Blade Cutting Accordion (Image 2 Top: Alignment, Decal Cutting, Pen Drawing)
		get_template_part( 'template-parts/product-laser-crafting/modular-addons' );

		// 8. Stability & Motion Engineering (Image 2 Bottom: Bed-Slinger As Stable As CoreXY, OFF/ON towers, tabs)
		get_template_part( 'template-parts/product-laser-crafting/motion-stability' );

		// 9. Multi-Color Made Easy (Image 3: Cockatiel Hero, Nordschleife miniature, Relic Rush)
		get_template_part( 'template-parts/product-laser-crafting/ams-multicolor' );

		// 10. Support 2nd-Gen AMS (Image 4 Top: 19 colors, drying, storage, filament diagram)
		get_template_part( 'template-parts/product-laser-crafting/support-2nd-gen-ams' );

		// 11. Intelligent Print Monitoring (Image 4 Bottom: Nozzle Clumping, Filament Grinding, Air Printing)
		get_template_part( 'template-parts/product-laser-crafting/print-autopilot' );

		// 12. Auto Flow Dynamics Calibration (Image 5 Top: Repeatable Sharp Details, A2L vs Other Printers)
		get_template_part( 'template-parts/product-laser-crafting/flow-calibration' );

		// 13. UL Clean Air Certified (Image 5 Bottom: Family lifestyle photo + UL GREENGUARD badge)
		get_template_part( 'template-parts/product-laser-crafting/clean-air' );

		// 14. Engineered for Silence (Print Quietly. Work Comfortably. 49dB Silent Mode)
		get_template_part( 'template-parts/product-laser-crafting/print-quietly' );

		// 15. Connectivity & Privacy (Connect Your Way - Cloud, LAN, Studio, SD Card)
		get_template_part( 'template-parts/product-laser-crafting/connect-your-way' );

		// 16. Unboxing Video (Interactive Video Player Card)
		get_template_part( 'template-parts/product-laser-crafting/unboxing-video' );

		// 17. What's in the Box (Matrix comparison across Standalone, Combo, Full Combo)
		get_template_part( 'template-parts/product-laser-crafting/box-contents' );

		// 18. Technical Specifications (Expandable Category/Label/Value matrix + PDF download)
		get_template_part( 'template-parts/product-laser-crafting/specifications' );

		// 19. FAQ & Call-To-Action Banner
		get_template_part( 'template-parts/product-laser-crafting/faq' );

		// 20. Sticky Bottom Purchase Bar
		get_template_part( 'template-parts/product-laser-crafting/sticky-bottom-bar' );
		?>
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_single_product.
	 */
	do_action( 'woocommerce_after_single_product' );
	return;
} elseif ( function_exists( 'woodmart_child_is_accessories_landing' ) && woodmart_child_is_accessories_landing() ) {
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
}

// Fall back to parent theme content-single-product.php if custom landing is disabled
$parent_template = get_template_directory() . '/woocommerce/content-single-product.php';
if ( file_exists( $parent_template ) ) {
	include $parent_template;
}

