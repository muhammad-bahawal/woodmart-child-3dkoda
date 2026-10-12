<?php
/**
 * Template Part: Filament Choose Your Format (Complete Spool or Refill?)
 *
 * Side-by-side format comparison cards matching Figma:
 * - Card 1 (Complete Spool): Orange border, "RECOMMENDED FOR FIRST PURCHASE", €24.90, full spool specs, orange Add button
 * - Card 2 (Refill): Subtle border, "BEST IF YOU ALREADY OWN A SPOOL", €21.90, eco refill specs, outline Add button
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'choose_format', $product_id ) ) {
	return;
}

$data     = woodmart_child_get_filament_section_data( 'choose_format', $product_id );
$eyebrow  = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'CHOOSE YOUR FORMAT', 'woodmart-child' );
$title    = ! empty( $data['title'] ) ? $data['title'] : __( 'Complete Spool or Refill?', 'woodmart-child' );
$subtitle = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( "The filament is the same. What changes is what's included", 'woodmart-child' );

// Spool card data
$sp_badge    = ! empty( $data['spool_badge'] ) ? $data['spool_badge'] : __( 'RECOMMENDED FOR FIRST PURCHASE', 'woodmart-child' );
$sp_title    = ! empty( $data['spool_title'] ) ? $data['spool_title'] : __( 'Complete Spool', 'woodmart-child' );
$sp_price    = ! empty( $data['spool_price'] ) ? $data['spool_price'] : '€24.90';
$sp_vat      = ! empty( $data['spool_vat'] ) ? $data['spool_vat'] : '€24.90 incl. 24% VAT · sample price';
$sp_desc     = ! empty( $data['spool_desc'] ) ? $data['spool_desc'] : __( "Ready-to-print 1 kg spool for everyday PLA work. Best choice if this is your first time buying Bambu filament or you don't yet own a reusable spool", 'woodmart-child' );
$sp_bullets  = ! empty( $data['spool_bullets'] ) ? $data['spool_bullets'] : array(
	__( 'Includes reusable spool', 'woodmart-child' ),
	__( 'Ready to load and print immediately', 'woodmart-child' ),
	__( "Best if you don't already own a spool", 'woodmart-child' ),
);
$sp_btn_text = ! empty( $data['spool_btn_text'] ) ? $data['spool_btn_text'] : __( 'Add Complete Spool →', 'woodmart-child' );

// Refill card data
$rf_badge    = ! empty( $data['refill_badge'] ) ? $data['refill_badge'] : __( 'BEST IF YOU ALREADY OWN A SPOOL', 'woodmart-child' );
$rf_title    = ! empty( $data['refill_title'] ) ? $data['refill_title'] : __( 'Refill', 'woodmart-child' );
$rf_price    = ! empty( $data['refill_price'] ) ? $data['refill_price'] : '€21.90';
$rf_vat      = ! empty( $data['refill_vat'] ) ? $data['refill_vat'] : '€21.90 incl. 24% VAT · sample price';
$rf_desc     = ! empty( $data['refill_desc'] ) ? $data['refill_desc'] : __( 'Fits the Bambu Reusable Spool. See official assembly guide', 'woodmart-child' );
$rf_bullets  = ! empty( $data['refill_bullets'] ) ? $data['refill_bullets'] : array(
	__( 'No spool included', 'woodmart-child' ),
	__( 'Less packaging waste, more eco-friendly', 'woodmart-child' ),
	__( 'Requires an existing compatible spool', 'woodmart-child' ),
);
$rf_btn_text = ! empty( $data['refill_btn_text'] ) ? $data['refill_btn_text'] : __( 'Add Refill', 'woodmart-child' );
?>

<section class="filament-format-section" id="choose-format">
	<div class="container">
		<div class="filament-section-head text-center">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="filament-eyebrow-orange"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<h2 class="filament-section-title"><?php echo esc_html( $title ); ?></h2>

			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="filament-section-desc"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- 2 Side-by-Side Comparison Cards -->
		<div class="filament-format-cards-grid" id="filament-choose-format-grid">
			<!-- 1. Complete Spool -->
			<div class="filament-format-card" data-format-type="complete-spool" tabindex="0" role="button" aria-label="<?php echo esc_attr( $sp_title ); ?>">
				<span class="format-card-badge"><?php echo esc_html( $sp_badge ); ?></span>
				
				<h3 class="format-card-title"><?php echo esc_html( $sp_title ); ?></h3>
				
				<div class="format-card-price-wrap">
					<span class="format-card-price"><?php echo esc_html( $sp_price ); ?></span>
					<span class="format-card-vat"><?php echo esc_html( $sp_vat ); ?></span>
				</div>

				<p class="format-card-desc"><?php echo esc_html( $sp_desc ); ?></p>

				<ul class="format-card-checklist">
					<?php foreach ( $sp_bullets as $bullet ) : ?>
						<li>
							<span class="check-icon" aria-hidden="true">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="20 6 9 17 4 12"></polyline>
								</svg>
							</span>
							<span class="check-text"><?php echo esc_html( $bullet ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>

				<button type="button" class="btn-format-action btn-format-spool" data-format="complete-spool" aria-label="<?php echo esc_attr( $sp_btn_text ); ?>">
					<span><?php echo esc_html( $sp_btn_text ); ?></span>
				</button>
			</div>

			<!-- 2. Refill -->
			<div class="filament-format-card" data-format-type="refill" tabindex="0" role="button" aria-label="<?php echo esc_attr( $rf_title ); ?>">
				<span class="format-card-badge"><?php echo esc_html( $rf_badge ); ?></span>
				
				<h3 class="format-card-title"><?php echo esc_html( $rf_title ); ?></h3>
				
				<div class="format-card-price-wrap">
					<span class="format-card-price"><?php echo esc_html( $rf_price ); ?></span>
					<span class="format-card-vat"><?php echo esc_html( $rf_vat ); ?></span>
				</div>

				<p class="format-card-desc"><?php echo esc_html( $rf_desc ); ?></p>

				<ul class="format-card-checklist">
					<?php foreach ( $rf_bullets as $bullet ) : ?>
						<li>
							<span class="check-icon" aria-hidden="true">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="20 6 9 17 4 12"></polyline>
								</svg>
							</span>
							<span class="check-text"><?php echo esc_html( $bullet ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>

				<button type="button" class="btn-format-action btn-format-refill" data-format="refill" aria-label="<?php echo esc_attr( $rf_btn_text ); ?>">
					<span><?php echo esc_html( $rf_btn_text ); ?></span>
				</button>
			</div>
		</div>
	</div>
</section>
