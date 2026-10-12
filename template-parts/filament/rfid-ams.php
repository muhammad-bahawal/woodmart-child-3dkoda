<?php
/**
 * Template Part: Filament Smart Material Detection (RFID & AMS Compatibility)
 *
 * Feature block matching Figma Image 2:
 * - Eyebrow: "SMART MATERIAL DETECTION"
 * - Title: "Built for RFID & AMS Compatibility"
 * - Description: "All printing parameters are embedded in RFID and read automatically through the Bambu Lab AMS. Load and print, with no tedious setup steps"
 * - 4 Checkmarked bullet points
 * - Bottom link: "See AMS-compatible printers →"
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'rfid_ams', $product_id ) ) {
	return;
}

$data        = woodmart_child_get_filament_section_data( 'rfid_ams', $product_id );
$eyebrow     = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'SMART MATERIAL DETECTION', 'woodmart-child' );
$title       = ! empty( $data['title'] ) ? $data['title'] : __( 'Built for RFID & AMS Compatibility', 'woodmart-child' );
$description = ! empty( $data['description'] ) ? $data['description'] : __( 'All printing parameters are embedded in RFID and read automatically through the Bambu Lab AMS. Load and print, with no tedious setup steps', 'woodmart-child' );
$bullets     = ! empty( $data['bullets'] ) ? $data['bullets'] : array(
	__( 'Automatic material recognition', 'woodmart-child' ),
	__( 'Real-time remaining-filament tracking', 'woodmart-child' ),
	__( 'Seamless multi-color workflow with AMS', 'woodmart-child' ),
	__( 'Reduces print failures from wrong settings', 'woodmart-child' ),
);
$link_text   = ! empty( $data['link_text'] ) ? $data['link_text'] : __( 'See AMS-compatible printers →', 'woodmart-child' );
$link_url    = ! empty( $data['link_url'] ) ? $data['link_url'] : '#';
?>

<section class="filament-rfid-section" id="rfid-ams">
	<div class="container">
		<div class="filament-rfid-card">
			<div class="filament-rfid-content">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<span class="filament-eyebrow-orange"><?php echo esc_html( $eyebrow ); ?></span>
				<?php endif; ?>

				<h2 class="filament-rfid-title"><?php echo esc_html( $title ); ?></h2>

				<?php if ( ! empty( $description ) ) : ?>
					<p class="filament-rfid-desc"><?php echo nl2br( esc_html( $description ) ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $bullets ) ) : ?>
					<ul class="filament-rfid-checklist">
						<?php foreach ( $bullets as $bullet ) : ?>
							<li class="filament-rfid-checkitem">
								<span class="check-icon" aria-hidden="true">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
										<polyline points="20 6 9 17 4 12"></polyline>
									</svg>
								</span>
								<span class="check-text"><?php echo esc_html( $bullet ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( ! empty( $link_text ) ) : ?>
					<div class="filament-rfid-link-wrap">
						<a href="<?php echo esc_url( $link_url ); ?>" class="filament-rfid-action-link">
							<span><?php echo esc_html( $link_text ); ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
