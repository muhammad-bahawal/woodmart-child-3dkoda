<?php
/**
 * Template Part: Filament Recommended Print Settings
 *
 * Displays recommended print starting settings inside an ice-blue container,
 * official print profile link, right-side mini buy box card for Complete Spool,
 * and 6-parameter print settings table matching Figma Image 2.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'recommended_settings', $product_id ) ) {
	return;
}

$setup_data = woodmart_child_get_filament_section_data( 'recommended_settings', $product_id );

$eyebrow      = ! empty( $setup_data['eyebrow'] ) ? $setup_data['eyebrow'] : __( 'SETUP WITHOUT THE UNCERTAINTY', 'woodmart-child' );
$title        = ! empty( $setup_data['title'] ) ? $setup_data['title'] : __( 'Recommended print settings', 'woodmart-child' );
$description  = ! empty( $setup_data['description'] ) ? $setup_data['description'] : __( 'Getting clean results starts with the right profile. Use these starting settings, then fine-tune based on your printer and nozzle', 'woodmart-child' );
$profile_text = ! empty( $setup_data['profile_text'] ) ? $setup_data['profile_text'] : __( 'Open official Bambu PLA print profile', 'woodmart-child' );
$profile_url  = ! empty( $setup_data['profile_url'] ) ? $setup_data['profile_url'] : '#';

// Mini Buy Box Card data
$spool_badge = ! empty( $setup_data['spool_badge'] ) ? $setup_data['spool_badge'] : __( 'RECOMMENDED FOR FIRST PURCHASE', 'woodmart-child' );
$spool_title = ! empty( $setup_data['spool_title'] ) ? $setup_data['spool_title'] : __( 'Complete Spool', 'woodmart-child' );
$spool_price = ! empty( $setup_data['spool_price'] ) ? $setup_data['spool_price'] : '€24.90';
$spool_vat   = ! empty( $setup_data['spool_vat'] ) ? $setup_data['spool_vat'] : '€24.90 incl. 24% VAT sample price';
$spool_btn   = ! empty( $setup_data['spool_btn'] ) ? $setup_data['spool_btn'] : __( 'Add Complete Spool →', 'woodmart-child' );

$items = ! empty( $setup_data['items'] ) && is_array( $setup_data['items'] ) ? $setup_data['items'] : array();
?>

<section class="filament-setup-section" id="recommended-settings" aria-label="<?php esc_attr_e( 'Recommended Print Settings', 'woodmart-child' ); ?>">
	<div class="container filament-setup-container">
		<div class="filament-setup-wrapper">
			<!-- Top Header: Narrative Left & Mini Buy Box Right -->
			<div class="filament-setup-top">
				<div class="filament-setup-info">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<span class="filament-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $title ) ) : ?>
						<h2 class="filament-setup-title"><?php echo esc_html( $title ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $description ) ) : ?>
						<p class="filament-setup-desc"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $profile_text ) ) : ?>
						<div class="filament-setup-profile-link-wrap">
							<a href="<?php echo esc_url( $profile_url ); ?>" class="filament-setup-profile-link" target="_blank" rel="noopener noreferrer">
								<span><?php echo esc_html( $profile_text ); ?></span>
								<svg class="external-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
									<polyline points="15 3 21 3 21 9"></polyline>
									<line x1="10" y1="14" x2="21" y2="3"></line>
								</svg>
							</a>
						</div>
					<?php endif; ?>
				</div>

				<!-- Right Mini Buy Box Card -->
				<div class="filament-setup-mini-buybox">
					<div class="mini-buybox-card">
						<?php if ( ! empty( $spool_badge ) ) : ?>
							<span class="mini-buybox-badge"><?php echo esc_html( $spool_badge ); ?></span>
						<?php endif; ?>

						<h3 class="mini-buybox-title"><?php echo esc_html( $spool_title ); ?></h3>

						<div class="mini-buybox-price-wrap">
							<span class="mini-buybox-price"><?php echo esc_html( $spool_price ); ?></span>
							<?php if ( ! empty( $spool_vat ) ) : ?>
								<span class="mini-buybox-vat"><?php echo esc_html( $spool_vat ); ?></span>
							<?php endif; ?>
						</div>

						<button type="button" class="btn-setup-buybox btn-format-action" data-format="complete-spool" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'woodmart-child' ), $spool_title ) ); ?>">
							<?php echo esc_html( $spool_btn ); ?>
						</button>
					</div>
				</div>
			</div>

			<!-- Bottom Settings Table Card -->
			<?php if ( ! empty( $items ) ) : ?>
				<div class="filament-setup-table-wrap">
					<div class="filament-setup-table" role="table" aria-label="<?php esc_attr_e( 'Starting Print Settings Table', 'woodmart-child' ); ?>">
						<?php foreach ( $items as $s_idx => $s_item ) : 
							$label = ! empty( $s_item['label'] ) ? $s_item['label'] : '';
							$val   = ! empty( $s_item['value'] ) ? $s_item['value'] : '';
							if ( empty( $label ) && empty( $val ) ) {
								continue;
							}
							$is_even = ( 0 === $s_idx % 2 );
						?>
							<div class="filament-setup-row <?php echo $is_even ? 'row-even' : 'row-odd'; ?>" role="row">
								<div class="filament-setup-cell setup-cell-label" role="rowheader">
									<?php echo esc_html( $label ); ?>
								</div>
								<div class="filament-setup-cell setup-cell-value" role="cell">
									<?php echo esc_html( $val ); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
