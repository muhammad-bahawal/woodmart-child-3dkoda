<?php
/**
 * Template Part: AMS Drying & Intelligent Feeding
 *
 * Exact match to Image 2:
 * Title: "Dry Filament Quickly and Intelligently"
 * 3 Alternating Zig-Zag Feature Rows:
 * 1. Image Left | Text Right: "Electro-Magnetic Air Vent"
 * 2. Text Left | Image Right: "Auto-rotate Drying"
 * 3. Image Left | Text Right: "RFID Sync"
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'drying_feeding', $product_id );

$eyebrow  = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : '';
$title    = ! empty( $data['title'] ) ? $data['title'] : __( 'Dry Filament Quickly and Intelligently', 'woodmart-child' );
$subtitle = ! empty( $data['subtitle'] ) ? $data['subtitle'] : '';
$cards    = ! empty( $data['cards'] ) ? $data['cards'] : array(
	array(
		'title' => __( 'Electro-Magnetic Air Vent', 'woodmart-child' ),
		'desc'  => __( 'Automated venting facilitates dehumidification during drying and ensures airtight sealing for weeks of high-quality printing.', 'woodmart-child' ),
		'image' => '',
	),
	array(
		'title' => __( 'Auto-rotate Drying', 'woodmart-child' ),
		'desc'  => __( 'During the drying process, the filament spools rotate automatically to ensure more even drying.', 'woodmart-child' ),
		'image' => '',
	),
	array(
		'title' => __( 'RFID Sync', 'woodmart-child' ),
		'desc'  => __( 'AMS 2 Pro uses RFID to auto-match drying settings for Bambu official filaments, no manual input needed.', 'woodmart-child' ),
		'image' => '',
	),
);
?>

<section class="ams-drying-section" id="ams-drying">
	<div class="ams-drying-container container">
		<!-- Section Header -->
		<div class="ams-section-head text-center">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="ams-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="ams-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- 3 Zig-Zag Alternating Feature Rows (Image 2) -->
		<div class="ams-zigzag-grid">
			<?php foreach ( $cards as $idx => $card ) : 
				// Pattern in Image 2:
				// Row 0: Image Left, Text Right (is-reversed: false)
				// Row 1: Text Left, Image Right (is-reversed: true)
				// Row 2: Image Left, Text Right (is-reversed: false)
				$is_reversed = ( 1 === ( $idx % 2 ) );
			?>
				<div class="ams-zigzag-row <?php echo $is_reversed ? 'is-reversed' : ''; ?>">
					<!-- Media Column -->
					<div class="ams-zigzag-media">
						<?php if ( ! empty( $card['image'] ) ) : ?>
							<img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" loading="lazy" class="ams-zigzag-img">
						<?php else : ?>
							<!-- Stylized Glowing Dark Graphic Render -->
							<div class="ams-zigzag-graphic graphic-type-<?php echo esc_attr( $idx + 1 ); ?>">
								<?php if ( 0 === $idx ) : ?>
									<!-- Electro-Magnetic Air Vent Glow -->
									<div class="graphic-airvent-chamber">
										<div class="chamber-heat-glow"></div>
										<div class="chamber-body-silhouette">
											<div class="spool-warm-render"></div>
											<div class="vent-actuator">
												<span class="valve-indicator active"></span>
												<span class="valve-label">DEHUMIDIFY ACTIVE</span>
											</div>
										</div>
									</div>
								<?php elseif ( 1 === $idx ) : ?>
									<!-- Auto-rotate Drying Graphic -->
									<div class="graphic-rotate-chamber">
										<div class="spool-glow-circle">
											<div class="rotate-arrow-cw"></div>
										</div>
										<div class="thermal-convection-waves">
											<span class="heat-wave hw1"></span>
											<span class="heat-wave hw2"></span>
											<span class="heat-wave hw3"></span>
										</div>
									</div>
								<?php else : ?>
									<!-- RFID Sync Graphic -->
									<div class="graphic-rfid-spool">
										<div class="rfid-callout-pill">
											<span class="badge-mat">PETG HF</span>
											<span class="badge-temp">65°C 12h</span>
										</div>
										<div class="rfid-spool-hub">
											<span class="rfid-sensor-dot"></span>
											<span class="pulse-ring"></span>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Text Column -->
					<div class="ams-zigzag-content">
						<h3 class="ams-zigzag-heading"><?php echo esc_html( $card['title'] ); ?></h3>
						<p class="ams-zigzag-desc"><?php echo nl2br( esc_html( $card['desc'] ?? '' ) ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
