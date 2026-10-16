<?php
/**
 * Template Part: Engineered for Silence
 *
 * Exact match to User Instruction 4 & Image 4 (Top):
 * - Green Eyebrow: Engineered for Silence
 * - Title: Print Quietly. Work Comfortably.
 * - Paragraph: The A2L uses active motor noise cancellation...
 * - Large Image Card with 49dB Silent Mode Visual
 * - 100% Dynamic with fallback
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$si          = ! empty( $settings['silence'] ) ? $settings['silence'] : array();
$eyebrow     = ! empty( $si['eyebrow'] ) ? $si['eyebrow'] : __( 'Engineered for Silence', 'woodmart-child' );
$title       = ! empty( $si['title'] ) ? $si['title'] : __( 'Print Quietly. Work Comfortably.', 'woodmart-child' );
$desc        = ! empty( $si['desc'] ) ? $si['desc'] : __( 'The A2L uses active motor noise cancellation, precision linear rails, and intelligent fan scaling to deliver a seamless experience. In Silent Mode, it operates at just 49dB—as peaceful as a quiet library.', 'woodmart-child' );
$metric      = ! empty( $si['metric'] ) ? $si['metric'] : '49 dB · Silent Mode';
$silence_img = ! empty( $si['image'] ) ? $si['image'] : ( ! empty( $settings['motion_stability']['img_silence'] ) ? $settings['motion_stability']['img_silence'] : '' );
?>

<section class="lc-silence-section" id="lc-print-quietly">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-silence-header text-center">
			<span class="lc-green-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-desc"><?php echo esc_html( $desc ); ?></p>
		</div>

		<!-- Silence Image Card -->
		<div class="lc-silence-card">
			<div class="lc-silence-img-wrap">
				<?php if ( ! empty( $silence_img ) ) : ?>
					<img src="<?php echo esc_url( $silence_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="lc-silence-img" />
				<?php else : ?>
					<div class="lc-silence-mockup-scene">
						<div class="lc-cozy-sunlight"></div>
						<div class="lc-silence-table">
							<div class="lc-printer-silence-unit">
								<div class="lc-vase-print-mesh"></div>
							</div>
							<div class="lc-sleeping-cat-graphic"></div>
						</div>
						<div class="lc-silence-badge-overlay">
							<span class="lc-decibel-badge"><?php echo esc_html( $metric ); ?></span>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>
