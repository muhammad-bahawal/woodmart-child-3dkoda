<?php
/**
 * Template Part: Auto Flow Dynamics Calibration
 *
 * Exact match to Image 5 (Top Section):
 * - Green Eyebrow: Auto Flow Dynamics Calibration
 * - Title: Repeatable Sharp Print Details
 * - Paragraph: Most printers calibrate flow once...
 * - Side-by-side Comparison Visual:
 *   - Left: A2L (Green Pill Badge) - Crisp flower detail
 *   - Right: Other Printers (Gray Pill Badge) - Stringy/blurred detail
 * - 100% Dynamic with fallback
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$fc          = ! empty( $settings['flow_calibration'] ) ? $settings['flow_calibration'] : array();
$eyebrow     = ! empty( $fc['eyebrow'] ) ? $fc['eyebrow'] : __( 'Auto Flow Dynamics Calibration', 'woodmart-child' );
$title       = ! empty( $fc['title'] ) ? $fc['title'] : __( 'Repeatable Sharp Print Details', 'woodmart-child' );
$desc        = ! empty( $fc['desc'] ) ? $fc['desc'] : __( 'Most printers calibrate flow once and trust it for every print after. A2L recalibrates every time. Before each job, Flow Dynamics Calibration measures how filament actually flows through this nozzle, with this spool, today—and builds a nonlinear model of the entire extrusion path. Nozzle wear, filament moisture, a fresh roll—all factored in before the first layer goes down. Sharp corners. Clean details. Print after print.', 'woodmart-child' );
$a2l_img     = ! empty( $fc['a2l_image'] ) ? $fc['a2l_image'] : '';
$other_img   = ! empty( $fc['other_image'] ) ? $fc['other_image'] : '';
$status_text = ! empty( $fc['status_text'] ) ? $fc['status_text'] : __( 'Worn nozzle (20% out-spec) , Damp filament , Nozzle residue', 'woodmart-child' );
?>

<section class="lc-flow-section" id="lc-flow-calibration">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-flow-header text-center">
			<span class="lc-green-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-desc"><?php echo esc_html( $desc ); ?></p>
		</div>

		<!-- Comparison Images Card -->
		<div class="lc-flow-comparison-box">
			<div class="lc-flow-images-grid">
				<!-- Left Card: A2L Sharp Details -->
				<div class="lc-flow-card flow-card-a2l">
					<div class="lc-flow-media">
						<span class="lc-flow-badge badge-green-pill"><?php esc_html_e( 'A2L', 'woodmart-child' ); ?></span>
						<?php if ( ! empty( $a2l_img ) ) : ?>
							<img src="<?php echo esc_url( $a2l_img ); ?>" alt="A2L Sharp Details" style="width:100%; height:100%; object-fit:contain;" />
						<?php else : ?>
							<div class="lc-sculpture-mockup a2l-sharp">
								<div class="lc-embossed-flower-detail detail-sharp"></div>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<!-- Right Card: Other Printers (Degraded) -->
				<div class="lc-flow-card flow-card-other">
					<div class="lc-flow-media">
						<span class="lc-flow-badge badge-gray-pill"><?php esc_html_e( 'Other Printers', 'woodmart-child' ); ?></span>
						<?php if ( ! empty( $other_img ) ) : ?>
							<img src="<?php echo esc_url( $other_img ); ?>" alt="Other Printers Degraded" style="width:100%; height:100%; object-fit:contain;" />
						<?php else : ?>
							<div class="lc-sculpture-mockup other-blurred">
								<div class="lc-embossed-flower-detail detail-rough"></div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Bottom Highlight Status Strip -->
			<div class="lc-flow-status-strip text-center">
				<p class="lc-flow-bullets">
					<?php 
					$bullets = array_map( 'trim', explode( ',', $status_text ) );
					foreach ( $bullets as $b_idx => $bullet ) : 
					?>
						<?php if ( $b_idx > 0 ) : ?>, <?php endif; ?>
						<span class="lc-highlight-green"><?php echo esc_html( $bullet ); ?></span>
					<?php endforeach; ?>
				</p>
				<p class="lc-flow-sublabel"><?php esc_html_e( 'A2L VS. Printer without Auto Flow Dynamics Calibration', 'woodmart-child' ); ?></p>
			</div>
		</div>

	</div>
</section>
