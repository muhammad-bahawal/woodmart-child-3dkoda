<?php
/**
 * Template Part: Sticky Bottom Purchase Bar
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$core       = woodmart_child_get_core_product_data( $product_id );
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$title       = ! empty( $core['title'] ) ? $core['title'] : get_the_title( $product_id );
$main_image  = ! empty( $core['main_image_url'] ) ? $core['main_image_url'] : '';
$price_html  = ! empty( $core['price_html'] ) ? $core['price_html'] : '';
$packages       = ! empty( $settings['general']['packages'] ) ? $settings['general']['packages'] : array();
$first_pkg_item = is_array( $packages ) && ! empty( $packages ) ? reset( $packages ) : array();
$first_pkg      = ! empty( $first_pkg_item['title'] ) ? $first_pkg_item['title'] : __( 'A2L Standalone', 'woodmart-child' );
?>

<div class="lc-sticky-bar" id="lc-sticky-bar" aria-hidden="true">
	<div class="container lc-sticky-container">

		<!-- Left: Mini Product Info -->
		<div class="lc-sticky-info">
			<?php if ( ! empty( $main_image ) ) : ?>
				<div class="lc-sticky-thumb">
					<img src="<?php echo esc_url( $main_image ); ?>" alt="<?php echo esc_attr( $title ); ?>" id="lc-sticky-thumb-img" />
				</div>
			<?php endif; ?>
			<div class="lc-sticky-details">
				<span class="lc-sticky-title"><?php echo esc_html( $title ); ?></span>
				<span class="lc-sticky-config" id="lc-sticky-config"><?php echo esc_html( $first_pkg ); ?></span>
			</div>
		</div>

		<!-- Center: Live Dynamic Price -->
		<div class="lc-sticky-price-wrap">
			<span class="lc-sticky-price" id="lc-sticky-price"><?php echo wp_kses_post( $price_html ); ?></span>
			<span class="lc-sticky-vat"><?php esc_html_e( 'incl. 24% VAT', 'woodmart-child' ); ?></span>
		</div>

		<!-- Right: CTA Button -->
		<div class="lc-sticky-actions">
			<button type="button" class="lc-sticky-btn-add" id="lc-sticky-btn-add">
				<span><?php esc_html_e( 'Add to basket', 'woodmart-child' ); ?></span>
				<span class="lc-sticky-cart-icon" aria-hidden="true">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
				</span>
			</button>
		</div>

	</div>
</div>
