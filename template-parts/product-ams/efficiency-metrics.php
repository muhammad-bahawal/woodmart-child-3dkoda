<?php
/**
 * Template Part: AMS Speed & Efficiency Metrics
 *
 * High-Contrast Metric Cards:
 * - Card 1: +50% Feeding Speed
 * - Card 2: -10min Changeover Overhead
 * - Wide Showcase Graphic Card: Smart Purge Calibration in Bambu Studio
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'efficiency_metrics', $product_id );

$eyebrow      = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'Speed & Waste Reduction', 'woodmart-child' );
$title        = ! empty( $data['title'] ) ? $data['title'] : __( 'Engineered for Blazing Speed & Minimal Waste', 'woodmart-child' );
$subtitle     = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( 'Optimized feed kinematics and purge reduction algorithms maximize printer uptime.', 'woodmart-child' );
$card_speed   = ! empty( $data['card_speed'] ) ? $data['card_speed'] : array();
$card_waste   = ! empty( $data['card_waste'] ) ? $data['card_waste'] : array();
$banner_title = ! empty( $data['banner_title'] ) ? $data['banner_title'] : __( 'Smart Purge Calibration in Bambu Studio', 'woodmart-child' );
$banner_desc  = ! empty( $data['banner_desc'] ) ? $data['banner_desc'] : __( 'Adaptive color transition matrix calculates the precise flush volume required between light and dark shades, reducing purge tower size and filament waste.', 'woodmart-child' );
$banner_image = ! empty( $data['banner_image'] ) ? $data['banner_image'] : '';
?>

<section class="ams-efficiency-section" id="ams-efficiency">
	<div class="ams-efficiency-container container">
		<div class="ams-section-head text-center is-dark">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="ams-section-eyebrow is-amber"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="ams-section-title is-light"><?php echo esc_html( $title ); ?></h2>
			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="ams-section-subtitle is-muted"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- 2-Column Metric Cards Strip -->
		<div class="ams-speed-metrics-grid">
			<!-- Speed Metric Card -->
			<div class="ams-speed-card">
				<div class="speed-card-metric is-green">
					<?php echo esc_html( $card_speed['metric'] ?? '+50%' ); ?>
				</div>
				<h3 class="speed-card-label">
					<?php echo esc_html( $card_speed['label'] ?? __( 'Feeding & Retraction Velocity', 'woodmart-child' ) ); ?>
				</h3>
				<p class="speed-card-desc">
					<?php echo esc_html( $card_speed['desc'] ?? __( 'High-torque brushless feed motors and ultra-low friction PTFE routing propel filament at rapid velocity to drastically slash color transition latency.', 'woodmart-child' ) ); ?>
				</p>
			</div>

			<!-- Waste Metric Card -->
			<div class="ams-speed-card">
				<div class="speed-card-metric is-green">
					<?php echo esc_html( $card_waste['metric'] ?? '-10min' ); ?>
				</div>
				<h3 class="speed-card-label">
					<?php echo esc_html( $card_waste['label'] ?? __( 'Per Multi-Color Layer Overhead', 'woodmart-child' ) ); ?>
				</h3>
				<p class="speed-card-desc">
					<?php echo esc_html( $card_waste['desc'] ?? __( 'Synchronized filament cutting and adaptive purge volume calculation save up to 60% transition waste and cut hours off complex prints.', 'woodmart-child' ) ); ?>
				</p>
			</div>
		</div>

		<!-- Wide Graphic Banner Card (Underneath Metrics) -->
		<div class="ams-speed-banner-card">
			<div class="speed-banner-content">
				<span class="speed-banner-tag"><?php esc_html_e( 'Intelligent Slicing Algorithm', 'woodmart-child' ); ?></span>
				<h3 class="speed-banner-title"><?php echo esc_html( $banner_title ); ?></h3>
				<p class="speed-banner-desc"><?php echo esc_html( $banner_desc ); ?></p>
			</div>

			<div class="speed-banner-media">
				<?php if ( ! empty( $banner_image ) ) : ?>
					<img src="<?php echo esc_url( $banner_image ); ?>" alt="<?php echo esc_attr( $banner_title ); ?>" loading="lazy" class="speed-banner-img">
				<?php else : ?>
					<!-- High-Tech Purge Matrix & Velocity Graphic -->
					<div class="speed-banner-vector">
						<div class="purge-matrix-visual">
							<div class="matrix-head">
								<span>Flush Volume Matrix (mm³)</span>
								<span class="badge-saving">-60% Waste</span>
							</div>
							<div class="matrix-rows">
								<div class="matrix-row">
									<span class="color-swatch c-white"></span>
									<span class="arrow-sep">→</span>
									<span class="color-swatch c-black"></span>
									<span class="val-bar"><span style="width: 75%;"></span></span>
									<span class="val-num">240mm³</span>
								</div>
								<div class="matrix-row">
									<span class="color-swatch c-black"></span>
									<span class="arrow-sep">→</span>
									<span class="color-swatch c-white"></span>
									<span class="val-bar"><span style="width: 95%;"></span></span>
									<span class="val-num">320mm³</span>
								</div>
								<div class="matrix-row">
									<span class="color-swatch c-red"></span>
									<span class="arrow-sep">→</span>
									<span class="color-swatch c-orange"></span>
									<span class="val-bar"><span style="width: 30%;"></span></span>
									<span class="val-num">80mm³</span>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
