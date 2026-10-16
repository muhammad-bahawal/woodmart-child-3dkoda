<?php
/**
 * Template Part: AMS Floating Sticky Bottom Purchase Bar
 *
 * Persistent purchase bar that slides in when scrolling past the hero:
 * - Product thumbnail & title / variation name
 * - Dynamic live stock indicator (In Stock / Out of Stock)
 * - Dynamic price (EUR €)
 * - Quantity stepper synchronized with main hero
 * - Add to Basket button
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_ams_builder_settings( $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

$title       = ! empty( $core['title'] ) ? $core['title'] : get_the_title( $product_id );
$main_image  = ! empty( $core['main_image_url'] ) ? $core['main_image_url'] : '';
$price_html  = ! empty( $core['price_html'] ) ? $core['price_html'] : '';
$is_in_stock = ! empty( $core['is_in_stock'] );
$button_text = ! empty( $settings['faq']['sticky_bar']['button_text'] ) ? $settings['faq']['sticky_bar']['button_text'] : __( 'Add to basket', 'woodmart-child' );
?>

<div class="ams-sticky-bar" id="ams-sticky-bar" aria-label="<?php esc_attr_e( 'Quick purchase bar', 'woodmart-child' ); ?>">
	<div class="ams-sticky-bar__container container">
		<!-- Left: Product Snapshot -->
		<div class="ams-sticky-bar__product">
			<div class="ams-sticky-bar__thumb">
				<?php if ( ! empty( $main_image ) ) : ?>
					<img src="<?php echo esc_url( $main_image ); ?>" alt="<?php echo esc_attr( $title ); ?>" id="ams-sticky-thumb-img" loading="lazy">
				<?php endif; ?>
			</div>
			<div class="ams-sticky-bar__meta">
				<strong class="ams-sticky-bar__title"><?php echo esc_html( $title ); ?></strong>
				<div class="ams-sticky-bar__sub">
					<span class="ams-sticky-bar__config" id="ams-sticky-config"><?php esc_html_e( 'Standard Package', 'woodmart-child' ); ?></span>
					<span class="ams-sticky-bar__sep">·</span>
					<span class="ams-sticky-bar__stock <?php echo $is_in_stock ? 'is-instock' : 'is-outofstock'; ?>" id="ams-sticky-stock">
						● <?php echo $is_in_stock ? esc_html__( 'In Stock', 'woodmart-child' ) : esc_html__( 'Out of Stock', 'woodmart-child' ); ?>
					</span>
				</div>
			</div>
		</div>

		<!-- Right: Price, Quantity & CTA Button -->
		<div class="ams-sticky-bar__actions">
			<div class="ams-sticky-bar__price-wrap">
				<span class="ams-sticky-bar__price" id="ams-sticky-price" style="color: #111827 !important;">
					<?php echo wp_kses_post( $price_html ); ?>
				</span>
				<span class="ams-sticky-bar__vat-note"><?php esc_html_e( 'incl. 24% VAT', 'woodmart-child' ); ?></span>
			</div>

			<div class="ams-sticky-bar__qty">
				<button type="button" class="ams-sticky-qty-btn" data-dir="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woodmart-child' ); ?>">−</button>
				<input type="text" class="ams-sticky-qty-input" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>" readonly>
				<button type="button" class="ams-sticky-qty-btn" data-dir="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'woodmart-child' ); ?>">+</button>
			</div>

			<button type="button" class="btn btn-add-to-cart ams-sticky-btn-add" id="ams-sticky-btn-add">
				<span><?php echo esc_html( $button_text ); ?></span>
				<span class="cart-icon" aria-hidden="true">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
						<line x1="3" y1="6" x2="21" y2="6"></line>
						<path d="M16 10a4 4 0 0 1-8 0"></path>
					</svg>
				</span>
			</button>
		</div>
	</div>
</div>
