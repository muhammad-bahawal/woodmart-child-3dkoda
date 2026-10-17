<?php
/**
 * Template Part: AMS Print Quality Comparison & Speed Metrics
 *
 * Exact match to Image 3:
 * 1. Top Section: Honeycomb Print Quality Comparison
 *    - Left: Dry (green badge) pristine honeycomb
 *    - Right: Moist (white/gray badge) stringy flawed honeycomb
 *    - Caption: "Bambu PETG Basic"
 * 2. Bottom Section: Speed Up! Faster Multi-material Printing!
 *    - Card 1: "+60%" | The powerful Bambu permanent magnet synchronous servo motor accelerates filament feeding by 60% for enhanced efficiency.
 *    - Card 2: "-10min" | Saves an average of 10 minutes per 100 filament changes.
 *    - Bottom Showcase Banner: Sports car render + "Faster multi-color printing" overlay
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'efficiency_metrics', $product_id );

// Top: Comparison Settings
$comparison_caption = ! empty( $data['comparison_caption'] ) ? $data['comparison_caption'] : __( 'Bambu PETG Basic', 'woodmart-child' );
$dry_label          = ! empty( $data['dry_label'] ) ? $data['dry_label'] : __( 'Dry', 'woodmart-child' );
$moist_label        = ! empty( $data['moist_label'] ) ? $data['moist_label'] : __( 'Moist', 'woodmart-child' );
$dry_image          = ! empty( $data['dry_image'] ) ? $data['dry_image'] : '';
$moist_image        = ! empty( $data['moist_image'] ) ? $data['moist_image'] : '';
$comparison_image   = ! empty( $data['comparison_image'] ) ? $data['comparison_image'] : '';

// Bottom: Speed Section Settings
$title         = ! empty( $data['title'] ) ? $data['title'] : __( 'Speed Up! Faster Multi-material Printing!', 'woodmart-child' );
$card_speed    = ! empty( $data['card_speed'] ) ? $data['card_speed'] : array();
$card_waste    = ! empty( $data['card_waste'] ) ? $data['card_waste'] : array();
$banner_title  = ! empty( $data['banner_title'] ) ? $data['banner_title'] : __( 'Faster multi-color printing', 'woodmart-child' );
$banner_credit = ! empty( $data['banner_credit'] ) ? $data['banner_credit'] : __( 'Xiaomi SU7 Ultra Prototype by @大匠', 'woodmart-child' );
$banner_image  = ! empty( $data['banner_image'] ) ? $data['banner_image'] : '';

$speed_metric = ! empty( $card_speed['metric'] ) ? $card_speed['metric'] : '+60%';
$speed_desc   = ! empty( $card_speed['desc'] ) ? $card_speed['desc'] : __( 'The powerful Bambu permanent magnet synchronous servo motor accelerates filament feeding by 60% for enhanced efficiency.', 'woodmart-child' );

$waste_metric = ! empty( $card_waste['metric'] ) ? $card_waste['metric'] : '-10min';
$waste_desc   = ! empty( $card_waste['desc'] ) ? $card_waste['desc'] : __( 'Saves an average of 10 minutes per 100 filament changes.', 'woodmart-child' );
?>

<section class="ams-efficiency-section" id="ams-efficiency">
	<div class="ams-efficiency-container container">

		<!-- 1. HONEYCOMB PRINT QUALITY COMPARISON (IMAGE 3 TOP) -->
		<div class="ams-print-comparison-block">
			<div class="comparison-visual-frame">
				<?php if ( ! empty( $comparison_image ) ) : ?>
					<img src="<?php echo esc_url( $comparison_image ); ?>" alt="<?php echo esc_attr( $comparison_caption ); ?>" class="comparison-full-img" loading="lazy">
				<?php else : ?>
					<div class="comparison-split-grid">
						<!-- Left: Dry Side -->
						<div class="comparison-side is-dry">
							<?php if ( ! empty( $dry_image ) ) : ?>
								<img src="<?php echo esc_url( $dry_image ); ?>" alt="<?php echo esc_attr( $dry_label ); ?>" class="comparison-side-img" loading="lazy">
							<?php else : ?>
								<!-- Pristine Crisp Honeycomb SVG Graphic -->
								<div class="honeycomb-render is-dry-graphic">
									<svg class="honeycomb-mesh" viewBox="0 0 500 280" fill="none">
										<pattern id="hexDry" width="40" height="69.282" patternUnits="userSpaceOnUse" patternTransform="scale(1)">
											<path d="M40 0 L20 11.547 L0 0 L0 23.094 L20 34.641 L40 23.094 Z M0 34.641 L20 46.188 L0 57.735 L0 69.282 L40 69.282 L40 57.735 L20 46.188 L40 34.641 Z" fill="none" stroke="#ff7a00" stroke-width="4.5" stroke-linejoin="round" stroke-linecap="round"/>
										</pattern>
										<rect width="100%" height="100%" fill="#d35400"/>
										<rect width="100%" height="100%" fill="url(#hexDry)"/>
									</svg>
								</div>
							<?php endif; ?>
							<span class="comparison-pill pill-dry"><?php echo esc_html( $dry_label ); ?></span>
						</div>

						<!-- Right: Moist Side -->
						<div class="comparison-side is-moist">
							<?php if ( ! empty( $moist_image ) ) : ?>
								<img src="<?php echo esc_url( $moist_image ); ?>" alt="<?php echo esc_attr( $moist_label ); ?>" class="comparison-side-img" loading="lazy">
							<?php else : ?>
								<!-- Flawed Stringy Honeycomb SVG Graphic -->
								<div class="honeycomb-render is-moist-graphic">
									<svg class="honeycomb-mesh" viewBox="0 0 500 280" fill="none">
										<pattern id="hexMoist" width="40" height="69.282" patternUnits="userSpaceOnUse" patternTransform="scale(1)">
											<path d="M40 0 L20 11.547 L0 0 L0 23.094 L20 34.641 L40 23.094 Z M0 34.641 L20 46.188 L0 57.735 L0 69.282 L40 69.282 L40 57.735 L20 46.188 L40 34.641 Z" fill="none" stroke="#d35400" stroke-width="3" stroke-dasharray="2,3"/>
										</pattern>
										<rect width="100%" height="100%" fill="#a04000"/>
										<rect width="100%" height="100%" fill="url(#hexMoist)"/>
										<!-- Stringing hairs overlay -->
										<g stroke="rgba(255,255,255,0.4)" stroke-width="0.8">
											<line x1="20" y1="30" x2="180" y2="40"/>
											<line x1="50" y1="80" x2="220" y2="70"/>
											<line x1="90" y1="120" x2="290" y2="135"/>
											<line x1="140" y1="160" x2="350" y2="155"/>
											<line x1="200" y1="200" x2="420" y2="210"/>
											<line x1="40" y1="220" x2="260" y2="230"/>
										</g>
									</svg>
								</div>
							<?php endif; ?>
							<span class="comparison-pill pill-moist"><?php echo esc_html( $moist_label ); ?></span>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $comparison_caption ) ) : ?>
				<div class="comparison-caption text-center">
					<span><?php echo esc_html( $comparison_caption ); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<!-- 2. SPEED UP! SECTION (IMAGE 3 BOTTOM) -->
		<div class="ams-speed-up-block">
			<!-- Title -->
			<div class="ams-section-head text-center is-dark">
				<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
			</div>

			<!-- 2-Column Metric Cards -->
			<div class="ams-speed-metrics-grid">
				<!-- Card 1: +60% -->
				<div class="ams-speed-card">
					<div class="speed-card-metric txt-accent-gradient">
						<?php echo esc_html( $speed_metric ); ?>
					</div>
					<p class="speed-card-desc">
						<?php echo esc_html( $speed_desc ); ?>
					</p>
				</div>

				<!-- Card 2: -10min -->
				<div class="ams-speed-card">
					<div class="speed-card-metric txt-accent-gradient">
						<?php echo esc_html( $waste_metric ); ?>
					</div>
					<p class="speed-card-desc">
						<?php echo esc_html( $waste_desc ); ?>
					</p>
				</div>
			</div>

			<!-- Full-Width Showcase Banner Card (Car Banner) -->
			<div class="ams-speed-showcase-banner">
				<?php if ( ! empty( $banner_image ) ) : ?>
					<img src="<?php echo esc_url( $banner_image ); ?>" alt="<?php echo esc_attr( $banner_title ); ?>" loading="lazy" class="showcase-banner-img">
				<?php else : ?>
					<!-- Stylized High-Speed Sports Car Silhouette Fallback -->
					<div class="showcase-banner-vector">
						<div class="car-silhouette-stage">
							<svg viewBox="0 0 800 240" fill="none" class="car-svg">
								<defs>
									<linearGradient id="carBodyGrad" x1="0%" y1="0%" x2="100%" y2="0%">
										<stop offset="0%" stop-color="#ffd000"/>
										<stop offset="50%" stop-color="#ffb700"/>
										<stop offset="100%" stop-color="#ff9900"/>
									</linearGradient>
								</defs>
								<!-- Ground reflection line -->
								<line x1="50" y1="210" x2="750" y2="210" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
								<!-- Aerodynamic GT Car Outline -->
								<path d="M120 180 L160 160 L240 135 L380 120 L520 125 L630 155 L700 170 L720 190 L680 195 L630 195 C625 170 595 155 570 170 C550 185 555 195 550 195 L270 195 C265 170 235 155 210 170 C190 185 195 195 190 195 L130 195 Z" fill="url(#carBodyGrad)" opacity="0.95"/>
								<!-- Rear Wing Spoiler -->
								<path d="M680 155 L730 135 L740 145 L700 165 Z" fill="#222222"/>
								<!-- Cabin Glass -->
								<path d="M300 135 L375 125 L490 128 L540 155 L320 155 Z" fill="#111827"/>
								<!-- Wheels -->
								<circle cx="235" cy="188" r="28" fill="#111827" stroke="#ffb700" stroke-width="4"/>
								<circle cx="585" cy="188" r="28" fill="#111827" stroke="#ffb700" stroke-width="4"/>
							</svg>
						</div>
					</div>
				<?php endif; ?>

				<!-- Overlay Texts -->
				<div class="showcase-banner-overlay">
					<div class="showcase-banner-title"><?php echo esc_html( $banner_title ); ?></div>
					<?php if ( ! empty( $banner_credit ) ) : ?>
						<div class="showcase-banner-credit"><?php echo esc_html( $banner_credit ); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>

	</div>
</section>
