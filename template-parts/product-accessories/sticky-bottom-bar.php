<?php
/**
 * Template Part: Accessories Sticky Bottom Purchase Bar
 *
 * Renders sticky purchase bar synchronized with accessories hero:
 * thumbnail, title, active variation badge, price, and AJAX Add to Basket button.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$core       = woodmart_child_get_core_product_data( $product_id );
$settings   = woodmart_child_get_accessories_builder_settings( $product_id );

$variations  = ! empty( $core['variations'] ) ? $core['variations'] : array();
$first_var   = ! empty( $variations[0] ) ? $variations[0] : array();
$thumb_img   = ! empty( $first_var['image_url'] ) ? $first_var['image_url'] : ( ! empty( $core['main_thumb_url'] ) ? $core['main_thumb_url'] : ( $core['main_image_url'] ?? '' ) );
$title       = $core['title'] ?? '';
$price_html  = $core['price_html'] ?? '';
$vat_note    = ! empty( $settings['general']['vat_note'] ) ? $settings['general']['vat_note'] : __( 'incl. 24% VAT · sample price', 'woodmart-child' );
?>

<div class="sticky-purchase-bar accessories-sticky-bar" id="accessories-sticky-bar">
	<div class="container sticky-bar__container">
		<div class="sticky-bar__left">
			<?php if ( ! empty( $thumb_img ) ) : ?>
				<div class="sticky-bar__thumb-wrap">
					<img class="sticky-bar__thumb" id="sticky-accessories-thumb" src="<?php echo esc_url( $thumb_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" width="44" height="44" loading="lazy">
				</div>
			<?php endif; ?>

			<div class="sticky-bar-info">
				<div class="sticky-bar-title-row">
					<b class="sticky-bar-title"><?php echo esc_html( $title ); ?></b>
					<span class="sticky-bar-var-badge" id="sticky-accessories-var-badge"><?php esc_html_e( 'Standard', 'woodmart-child' ); ?></span>
				</div>
				<span class="sticky-bar-price">
					<span class="sticky-price-val accessories-current-price"><?php echo wp_kses_post( $price_html ); ?></span>
					<small class="sticky-price-vat"><?php echo esc_html( $vat_note ); ?></small>
				</span>
			</div>
		</div>

		<div class="sticky-bar__right">
			<button type="button" class="btn sticky-bar-cta accessories-sticky-cta">
				<span><?php esc_html_e( 'Add to basket', 'woodmart-child' ); ?></span>
				<span class="sticky-bar-arrow" aria-hidden="true">→</span>
			</button>
		</div>
	</div>
</div>
