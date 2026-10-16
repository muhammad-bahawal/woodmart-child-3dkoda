<?php
/**
 * Template Part: AMS Drying & Intelligent Feeding
 *
 * Feature cards for:
 * 1. Airtight Rubber Seal & Desiccant Bay (< 20% RH Dry Chamber)
 * 2. RFID Auto-Filament Identification (Instant Parameter Sync)
 * 3. Automatic Runout & Spool Backup (Unattended Printing)
 * 4. Spring-Loaded Buffer & Odometer Sensor (Tangle-Free Feeding)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'drying_feeding', $product_id );

$eyebrow  = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'Intelligent Care & Feeding', 'woodmart-child' );
$title    = ! empty( $data['title'] ) ? $data['title'] : __( 'Keep Filament Dry & Feeds Flawlessly', 'woodmart-child' );
$subtitle = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( 'Moisture causes stringing, bubbling, and nozzle clogs. The AMS keeps your material hermetically sealed and conditions continuously monitored.', 'woodmart-child' );
$cards    = ! empty( $data['cards'] ) ? $data['cards'] : array();
?>

<section class="ams-drying-section container" id="ams-drying">
	<div class="ams-section-head text-center">
		<?php if ( ! empty( $eyebrow ) ) : ?>
			<span class="ams-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>
		<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
		<?php if ( ! empty( $subtitle ) ) : ?>
			<p class="ams-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>

	<div class="ams-feature-cards-grid">
		<?php foreach ( $cards as $idx => $card ) : 
			$is_even = ( $idx % 2 === 1 );
		?>
			<div class="ams-feature-row <?php echo $is_even ? 'is-reversed' : ''; ?>">
				<div class="ams-feature-info">
					<?php if ( ! empty( $card['tag'] ) ) : ?>
						<span class="ams-feature-tag"><?php echo esc_html( $card['tag'] ); ?></span>
					<?php endif; ?>

					<h3 class="ams-feature-heading"><?php echo esc_html( $card['title'] ); ?></h3>

					<?php if ( ! empty( $card['badge'] ) ) : ?>
						<div class="ams-feature-pill">
							<span class="dot">●</span>
							<span><?php echo esc_html( $card['badge'] ); ?></span>
						</div>
					<?php endif; ?>

					<p class="ams-feature-desc"><?php echo nl2br( esc_html( $card['desc'] ) ); ?></p>
				</div>

				<div class="ams-feature-media">
					<?php if ( ! empty( $card['image'] ) ) : ?>
						<img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" loading="lazy" class="ams-feature-img">
					<?php else : ?>
						<!-- Custom High-Tech Vector Render -->
						<div class="ams-feature-graphic card-scheme-<?php echo esc_attr( $idx + 1 ); ?>">
							<?php if ( 0 === $idx ) : ?>
								<!-- Airtight Seal & Chamber Iconography -->
								<div class="graphic-chamber-schematic">
									<div class="chamber-boundary">
										<span class="seal-glow"></span>
										<div class="desiccant-bay-left"><span class="bead"></span><span class="bead"></span><span class="bead"></span></div>
										<div class="spool-center-icon">
											<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="1.5">
												<circle cx="12" cy="12" r="10"></circle>
												<circle cx="12" cy="12" r="3"></circle>
												<line x1="12" y1="2" x2="12" y2="9"></line>
												<line x1="12" y1="15" x2="12" y2="22"></line>
											</svg>
										</div>
										<div class="desiccant-bay-right"><span class="bead"></span><span class="bead"></span><span class="bead"></span></div>
									</div>
									<div class="humidity-gauge">
										<span class="val">18%</span>
										<span class="label">Relative Humidity</span>
									</div>
								</div>
							<?php elseif ( 1 === $idx ) : ?>
								<!-- RFID Auto-Detect Graphic -->
								<div class="graphic-rfid-schematic">
									<div class="rfid-waves">
										<span class="wave w1"></span>
										<span class="wave w2"></span>
										<span class="wave w3"></span>
									</div>
									<div class="rfid-chip-card">
										<div class="chip-header">
											<span class="chip-logo">RFID</span>
											<span class="chip-status">SYNCED</span>
										</div>
										<div class="chip-data">
											<strong>PLA Basic · Bambu Green</strong>
											<span>Nozzle: 220°C · Bed: 55°C · Speed: 250mm/s</span>
										</div>
									</div>
								</div>
							<?php elseif ( 2 === $idx ) : ?>
								<!-- Auto Runout Backup Switching -->
								<div class="graphic-backup-schematic">
									<div class="spool-track primary is-empty">
										<span class="track-label">Slot 1: Empty (0m)</span>
										<span class="track-bar empty-bar"></span>
									</div>
									<div class="switch-arrow-pulse">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5">
											<polyline points="7 13 12 18 17 13"></polyline>
											<polyline points="7 6 12 11 17 6"></polyline>
										</svg>
										<span>Auto-Switched</span>
									</div>
									<div class="spool-track backup is-active">
										<span class="track-label">Slot 2: Backup Active (1000m)</span>
										<span class="track-bar active-bar"></span>
									</div>
								</div>
							<?php else : ?>
								<!-- Precision Tension Buffer & Odometer -->
								<div class="graphic-buffer-schematic">
									<div class="buffer-spring-module">
										<div class="spring-coil">
											<span></span><span></span><span></span><span></span>
										</div>
										<div class="hall-sensor-indicator">
											<span class="sensor-light pulse-green"></span>
											<span class="sensor-text">Tension Optimal · Zero Slippage</span>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
