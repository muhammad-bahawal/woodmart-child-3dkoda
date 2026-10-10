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
?>

<div class="sticky-purchase-bar">
	<div class="container">
		<div class="sticky-bar-info">
			<b class="sticky-bar-title"><?php echo esc_html( $default_var['title'] ?? $core['title'] ); ?></b>
			<span class="sticky-bar-price">
				<?php echo wp_kses_post( ! empty( $default_var['price_html'] ) ? $default_var['price_html'] : $core['price_html'] ); ?>
				<small><?php esc_html_e( 'incl. 24% VAT · sample price', 'woodmart-child' ); ?></small>
			</span>
		</div>

		<?php if ( ! empty( $core['is_variable'] ) && ! empty( $variations ) && count( $variations ) > 1 ) : ?>
			<div class="sticky-variation-toggle" role="group" aria-label="<?php esc_attr_e( 'Choose setup', 'woodmart-child' ); ?>">
				<?php foreach ( $variations as $idx => $var ) :
					$is_checked = ( $idx === $default_idx );
				?>
					<button type="button" class="sticky-var-btn <?php echo $is_checked ? 'is-active' : ''; ?>"
						data-variation-id="<?php echo esc_attr( $var['id'] ); ?>"
						data-combo="<?php echo ! empty( $var['is_combo'] ) ? '1' : '0'; ?>">
						<?php echo esc_html( $var['title'] ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<button type="button" class="btn sticky-bar-cta">
			<?php esc_html_e( 'Add to basket', 'woodmart-child' ); ?>
		</button>
	</div>
</div>
