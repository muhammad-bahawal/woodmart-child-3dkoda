<?php
/**
 * Template Part: Intelligent Print Monitoring (Autopilot)
 *
 * Exact match to User Instruction 3 & Image 3:
 * - Green Eyebrow: Intelligent Print Monitoring
 * - Title: Put Your Printing on Autopilot
 * - Paragraph: Most print failures happen quietly...
 * - 3 Hover-Expanding Image Cards (like the modular add-ons accordion):
 *   1. Nozzle Clumping Detector
 *   2. Filament Grinding (Dark background, gears)
 *   3. Air Printing
 * - Hover on any card expands it larger, contracting siblings
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$section_data = woodmart_child_get_laser_crafting_section_data( 'ams_multicolor', $product_id );

$eyebrow = ! empty( $section_data['autopilot_eyebrow'] ) ? $section_data['autopilot_eyebrow'] : __( 'INTELLIGENT PRINT MONITORING', 'woodmart-child' );
$title   = ! empty( $section_data['autopilot_title'] ) ? $section_data['autopilot_title'] : __( 'Put Your Printing on Autopilot', 'woodmart-child' );
$desc    = ! empty( $section_data['autopilot_desc'] ) ? $section_data['autopilot_desc'] : __( 'Most print failures happen quietly—the nozzle keeps moving, but the part stopped forming hours ago. Sensors along the extrusion path, paired with the PMSM extruder as a feedback node, feed a Bambu-trained algorithm that catches filament tangle, runout, nozzle clumping, and air printing—then pauses A2L and guides you through the fix on Bambu Handy.', 'woodmart-child' );

$cards = array(
	array(
		'id'     => 'nozzle-clump',
		'title'  => __( 'Nozzle Clumping Detector', 'woodmart-child' ),
		'brand'  => 'Bambu Lab',
		'notice' => '♨ CAUTION HOT',
		'class'  => 'card-clumping',
		'img'    => ! empty( $section_data['img_clumping'] ) ? $section_data['img_clumping'] : '',
	),
	array(
		'id'     => 'filament-grind',
		'title'  => __( 'Filament Grinding', 'woodmart-child' ),
		'brand'  => '',
		'notice' => '',
		'class'  => 'card-grinding is-expanded',
		'img'    => ! empty( $section_data['img_grinding'] ) ? $section_data['img_grinding'] : '',
	),
	array(
		'id'     => 'air-print',
		'title'  => __( 'Air Printing', 'woodmart-child' ),
		'brand'  => 'Bambu Lab',
		'notice' => '♨ CAUTION HOT',
		'class'  => 'card-airprint',
		'img'    => ! empty( $section_data['img_airprint'] ) ? $section_data['img_airprint'] : '',
	),
);
?>

<section class="lc-autopilot-section" id="lc-print-autopilot">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-autopilot-header text-center">
			<span class="lc-green-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-desc"><?php echo esc_html( $desc ); ?></p>
		</div>

		<!-- 3 Hover-Expanding Cards Accordion (Hover Expands Larger) -->
		<div class="lc-accordion-cards-wrap lc-autopilot-accordion" id="lc-autopilot-accordion">
			<?php foreach ( $cards as $c_idx => $card ) : ?>
				<div class="lc-expand-card lc-auto-card <?php echo esc_attr( $card['class'] ); ?>" data-card-id="<?php echo esc_attr( $card['id'] ); ?>" tabindex="0">
					<div class="lc-expand-card-bg">
						<?php if ( ! empty( $card['img'] ) ) : ?>
							<img src="<?php echo esc_url( $card['img'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" class="lc-auto-card-img" />
						<?php else : ?>
							<div class="lc-card-visual-layer visual-<?php echo esc_attr( $card['id'] ); ?>">
								<?php if ( 'nozzle-clump' === $card['id'] ) : ?>
									<div class="lc-clumping-visual">
										<span class="lc-bambu-brand"><?php echo esc_html( $card['brand'] ); ?></span>
										<div class="lc-hotend-graphic">
											<span class="lc-hotend-heat-icon"><?php echo esc_html( $card['notice'] ); ?></span>
											<div class="lc-clumping-sock"></div>
										</div>
									</div>
								<?php elseif ( 'filament-grind' === $card['id'] ) : ?>
									<div class="lc-grinding-visual">
										<div class="lc-extruder-chassis">
											<div class="lc-motor-gear"></div>
											<div class="lc-filament-path-highlight">
												<div class="lc-filament-strand"></div>
											</div>
										</div>
									</div>
								<?php elseif ( 'air-print' === $card['id'] ) : ?>
									<div class="lc-airprint-visual">
										<span class="lc-bambu-brand"><?php echo esc_html( $card['brand'] ); ?></span>
										<div class="lc-hotend-graphic">
											<span class="lc-hotend-heat-icon"><?php echo esc_html( $card['notice'] ); ?></span>
											<div class="lc-nozzle-tip"></div>
										</div>
										<div class="lc-air-infill-block"></div>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<div class="lc-expand-card-gradient"></div>
					</div>
					<div class="lc-expand-card-caption">
						<h3 class="lc-expand-title"><?php echo esc_html( $card['title'] ); ?></h3>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
