<?php
/**
 * Template Part: Sticky Bottom Purchase Bar
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$core       = woodmart_child_get_core_product_data( $product_id );

$variations  = ! empty( $core['variations'] ) ? $core['variations'] : array();
$default_idx = ( count( $variations ) > 1 ) ? 1 : 0;
$default_var = isset( $variations[ $default_idx ] ) ? $variations[ $default_idx ] : ( $variations[0] ?? array() );
$thumb_img   = ! empty( $default_var['image_url'] ) ? $default_var['image_url'] : ( ! empty( $core['main_thumb_url'] ) ? $core['main_thumb_url'] : ( $core['main_image_url'] ?? '' ) );
$title       = ! empty( $default_var['title'] ) ? $default_var['title'] : ( $core['title'] ?? '' );
if ( false !== strpos( $title, ' - ' ) ) {
	$parts = explode( ' - ', $title );
	$title = trim( end( $parts ) );
}
$price_html  = ! empty( $default_var['price_html'] ) ? $default_var['price_html'] : ( $core['price_html'] ?? '' );
?>

<div class="sticky-purchase-bar">
	<div class="container sticky-bar__container">
		<div class="sticky-bar__left">
			<?php if ( ! empty( $thumb_img ) ) : ?>
				<div class="sticky-bar__thumb-wrap">
					<img class="sticky-bar__thumb" src="<?php echo esc_url( $thumb_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" width="40" height="40" loading="lazy">
				</div>
			<?php endif; ?>

			<div class="sticky-bar-info">
				<b class="sticky-bar-title"><?php echo esc_html( $title ); ?></b>
				<span class="sticky-bar-price">
					<?php echo wp_kses_post( $price_html ); ?>
					<small><?php esc_html_e( 'incl. 24% VAT', 'woodmart-child' ); ?></small>
				</span>
			</div>
		</div>

		<div class="sticky-bar__right">
			<button type="button" class="btn sticky-bar-cta">
				<span><?php esc_html_e( 'Add to basket', 'woodmart-child' ); ?></span>
				<span class="sticky-bar-arrow" aria-hidden="true">→</span>
			</button>
		</div>
	</div>
</div>
