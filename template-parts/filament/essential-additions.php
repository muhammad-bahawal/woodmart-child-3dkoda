<?php
/**
 * Template Part: Filament Essential Additions Section
 *
 * Section right after Hero in Filament product layout:
 * - Eyebrow: "DISCOVER MORE HERE!"
 * - Title: "Essential additions specifically tested with Bambu PLA Basic"
 * - 3 Cross-sell Product Cards in grid:
 *     1. Bambu Reusable Spool
 *     2. Support for PLA/PETG (with "With Spool" pill badge)
 *     3. Bambu Cool Plate SuperTack Series
 *   Each card has:
 *     - Distinctive icon box
 *     - Current price (orange bold) + Old price (strikethrough)
 *     - Description / subtitle
 *     - Option dropdown selector
 *     - Stepper + Green "Add" button
 * - Bottom Trust Strip:
 *     - Baltic shipping & delivery bullet points
 *     - Payment method badges (Montonio, Bank Payments, Card Payments, Digital Wallets)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_filament_builder_settings( $product_id );

if ( ! woodmart_child_is_filament_section_enabled( 'essential_additions', $product_id ) ) {
	return;
}

$additions_data = $settings['essential_additions'];
$eyebrow        = ! empty( $additions_data['eyebrow'] ) ? $additions_data['eyebrow'] : __( 'DISCOVER MORE HERE!', 'woodmart-child' );
$title          = ! empty( $additions_data['title'] ) ? $additions_data['title'] : __( 'Essential additions specifically tested with Bambu PLA Basic', 'woodmart-child' );
$cards          = ! empty( $additions_data['cards'] ) ? $additions_data['cards'] : array();
?>

<section class="filament-additions container" id="essential-additions">
	<div class="filament-additions__header">
		<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
		<h2 class="filament-additions__title"><?php echo esc_html( $title ); ?></h2>
	</div>

	<div class="filament-additions__grid">
		<?php
		foreach ( $cards as $idx => $card ) :
			$c_title     = $card['title'] ?? '';
			$c_price     = $card['price'] ?? '';
			$c_old_price = $card['old_price'] ?? '';
			$c_desc      = $card['desc'] ?? '';
			$c_badge      = $card['badge'] ?? '';
			$c_icon       = $card['icon'] ?? 'spool';
			$c_product_id = ! empty( $card['product_id'] ) ? absint( $card['product_id'] ) : 0;
			$c_options    = ! empty( $card['options'] ) && is_array( $card['options'] ) ? $card['options'] : array();
		?>
			<div class="filament-addition-card" data-card-index="<?php echo esc_attr( $idx ); ?>" data-product-id="<?php echo esc_attr( $c_product_id ); ?>">
				<div class="addition-card-header">
					<!-- Icon Box -->
					<div class="addition-card-icon" aria-hidden="true">
						<?php if ( 'support' === $c_icon ) : ?>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<rect x="3" y="3" width="7" height="7" rx="1"></rect>
								<rect x="14" y="3" width="7" height="7" rx="1"></rect>
								<rect x="8.5" y="14" width="7" height="7" rx="1"></rect>
							</svg>
						<?php elseif ( 'plate' === $c_icon ) : ?>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<rect x="4" y="4" width="16" height="16" rx="2"></rect>
								<line x1="4" y1="9" x2="20" y2="9"></line>
							</svg>
						<?php else : // Spool icon ?>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<circle cx="12" cy="12" r="9"></circle>
								<circle cx="12" cy="12" r="3.5"></circle>
								<line x1="12" y1="3" x2="12" y2="8.5"></line>
								<line x1="12" y1="15.5" x2="12" y2="21"></line>
								<line x1="3" y1="12" x2="8.5" y2="12"></line>
								<line x1="15.5" y1="12" x2="21" y2="12"></line>
							</svg>
						<?php endif; ?>
					</div>

					<h3 class="addition-card-title"><?php echo esc_html( $c_title ); ?></h3>

					<div class="addition-card-price-row">
						<span class="addition-price-current"><?php echo esc_html( $c_price ); ?></span>
						<?php if ( ! empty( $c_old_price ) ) : ?>
							<span class="addition-price-old"><?php echo esc_html( $c_old_price ); ?></span>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $c_desc ) ) : ?>
						<p class="addition-card-desc"><?php echo esc_html( $c_desc ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $c_badge ) ) : ?>
						<div class="addition-card-badge-wrap">
							<span class="addition-badge"><?php echo esc_html( $c_badge ); ?></span>
						</div>
					<?php endif; ?>
				</div>

				<div class="addition-card-footer">
					<?php if ( ! empty( $c_options ) ) : ?>
						<div class="addition-select-wrap">
							<select class="addition-select" aria-label="<?php echo esc_attr( sprintf( __( 'Select %s option', 'woodmart-child' ), $c_title ) ); ?>">
								<?php foreach ( $c_options as $opt ) : ?>
									<option value="<?php echo esc_attr( $opt ); ?>"><?php echo esc_html( $opt ); ?></option>
								<?php endforeach; ?>
							</select>
							<span class="select-arrow" aria-hidden="true">
								<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="6 9 12 15 18 9"></polyline>
								</svg>
							</span>
						</div>
					<?php endif; ?>

					<div class="addition-action-row">
						<div class="product-quantity addition-quantity">
							<button type="button" data-step="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woodmart-child' ); ?>">−</button>
							<input type="text" name="addition_qty" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>">
							<button type="button" data-step="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'woodmart-child' ); ?>">+</button>
						</div>
						<button type="button" class="btn btn-addition-add" data-product-id="<?php echo esc_attr( $c_product_id ); ?>" data-title="<?php echo esc_attr( $c_title ); ?>">
							<?php esc_html_e( 'Add', 'woodmart-child' ); ?>
						</button>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
