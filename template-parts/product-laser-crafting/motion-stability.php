<?php
/**
 * Template Part: Stability & Motion Engineering
 *
 * Exact match to User Instruction 1 & Image 1:
 * - Green Eyebrow: Engineered for Stability
 * - Title: A Bed-Slinger As Stable As CoreXY
 * - Dynamic Upper Visual controlled by Tabs:
 *   - Tab 1 (Adaptive Vibration Compensation): 2-Column Visual (OFF vs ON) with images
 *   - Tab 2 (Granular Damper): Single Column Wide Visual with image
 * - Interactive Tabs (Adaptive Vibration Compensation | Granular Damper)
 * - Matching descriptions below tabs
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$section_data = woodmart_child_get_laser_crafting_section_data( 'motion_stability', $product_id );

$eyebrow = ! empty( $section_data['eyebrow'] ) ? $section_data['eyebrow'] : __( 'ENGINEERED FOR STABILITY', 'woodmart-child' );
$title   = ! empty( $section_data['title'] ) ? $section_data['title'] : __( 'A Bed–Slinger As Stable As CoreXY', 'woodmart-child' );

// Image URLs if provided in meta or defaults
$img_off    = ! empty( $section_data['img_off'] ) ? $section_data['img_off'] : '';
$img_on     = ! empty( $section_data['img_on'] ) ? $section_data['img_on'] : '';
$img_damper = ! empty( $section_data['img_damper'] ) ? $section_data['img_damper'] : '';
?>

<section class="lc-stability-section" id="lc-motion-stability">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-stability-header text-center">
			<span class="lc-green-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
		</div>

		<!-- UPPER VISUAL SHOWCASE (Controlled by Tabs) -->
		<div class="lc-stability-visual-box">

			<!-- View 1: Adaptive Vibration Compensation (Default Active - 2 Columns) -->
			<div class="lc-stab-view lc-stab-view-vibration is-active" id="lc-stab-view-vibration">
				<div class="lc-stability-split-stage">
					<!-- Left Column: OFF -->
					<div class="lc-tower-col lc-tower-off">
						<div class="lc-tower-model">
							<?php if ( ! empty( $img_off ) ) : ?>
								<img src="<?php echo esc_url( $img_off ); ?>" alt="<?php esc_attr_e( 'Compensation OFF', 'woodmart-child' ); ?>" class="lc-tower-img" />
							<?php else : ?>
								<div class="lc-faceted-tower tower-ripples">
									<div class="lc-tower-shading"></div>
								</div>
							<?php endif; ?>
						</div>
						<div class="lc-tower-pill-wrap">
							<span class="lc-tower-pill pill-off"><?php esc_html_e( 'OFF', 'woodmart-child' ); ?></span>
						</div>
					</div>

					<!-- Right Column: ON -->
					<div class="lc-tower-col lc-tower-on">
						<div class="lc-tower-model">
							<?php if ( ! empty( $img_on ) ) : ?>
								<img src="<?php echo esc_url( $img_on ); ?>" alt="<?php esc_attr_e( 'Compensation ON', 'woodmart-child' ); ?>" class="lc-tower-img" />
							<?php else : ?>
								<div class="lc-faceted-tower tower-crisp">
									<div class="lc-tower-shading"></div>
								</div>
							<?php endif; ?>
						</div>
						<div class="lc-tower-pill-wrap">
							<span class="lc-tower-pill pill-on"><?php esc_html_e( 'ON', 'woodmart-child' ); ?></span>
						</div>
					</div>
				</div>
			</div>

			<!-- View 2: Granular Damper (Single Column - Active on Tab 2) -->
			<div class="lc-stab-view lc-stab-view-damper" id="lc-stab-view-damper" style="display: none;">
				<div class="lc-damper-single-stage">
					<div class="lc-damper-model">
						<?php if ( ! empty( $img_damper ) ) : ?>
							<img src="<?php echo esc_url( $img_damper ); ?>" alt="<?php esc_attr_e( 'Granular Damper Assembly', 'woodmart-child' ); ?>" class="lc-damper-img" />
						<?php else : ?>
							<div class="lc-damper-graphic">
								<div class="lc-damper-housing">
									<div class="lc-damper-granules">
										<span class="granule-dot"></span>
										<span class="granule-dot"></span>
										<span class="granule-dot"></span>
										<span class="granule-dot"></span>
										<span class="granule-dot"></span>
									</div>
								</div>
								<span class="lc-damper-badge"><?php esc_html_e( 'Granular Mass Damper', 'woodmart-child' ); ?></span>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

		</div>

		<!-- TABS ROW -->
		<div class="lc-stability-tabs-nav" role="tablist">
			<button type="button" class="lc-stab-tab-btn is-active" data-tab="vibration" role="tab" aria-selected="true">
				<span><?php esc_html_e( 'Adaptive Vibration Compensation', 'woodmart-child' ); ?></span>
			</button>
			<button type="button" class="lc-stab-tab-btn" data-tab="damper" role="tab" aria-selected="false">
				<span><?php esc_html_e( 'Granular Damper', 'woodmart-child' ); ?></span>
			</button>
		</div>

		<!-- DESCRIPTIONS ROW -->
		<div class="lc-stability-panels text-center">
			<div class="lc-stab-panel is-active" id="lc-stab-panel-vibration" role="tabpanel">
				<p class="lc-stab-desc">
					<?php esc_html_e( 'A model gets taller. It gets heavier. The way the machine vibrates changes with it. Most printers run input shaping once at startup and call it done. The A2L runs Adaptive Vibration Compensation—a real-time calibration matrix that factors in both toolhead position and shifting bed load, retuning the resonance model layer by layer as the print grows. The last layer comes out as clean as the first.', 'woodmart-child' ); ?>
				</p>
			</div>
			<div class="lc-stab-panel" id="lc-stab-panel-damper" role="tabpanel" style="display: none;">
				<p class="lc-stab-desc">
					<?php esc_html_e( 'Tuned granular mass dampers embedded inside the frame dissipate high-frequency mechanical vibration and kinetic oscillations during rapid 500 mm/s direction changes. Zero resonance, zero ghosting, and clean sharp corners from the first layer to the last.', 'woodmart-child' ); ?>
				</p>
			</div>
		</div>

	</div>
</section>
