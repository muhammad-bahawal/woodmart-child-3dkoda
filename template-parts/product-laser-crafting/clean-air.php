<?php
/**
 * Template Part: UL Clean Air Certified
 *
 * Exact match to Image 5 (Bottom Section):
 * - Green Eyebrow: UL Clean Air Certified
 * - Title: Print with Confidence, Breathe with Peace of Mind
 * - Paragraph: The A2L is certified under the UL 2904 standard...
 * - Large Family & Living Room Lifestyle Visual
 * - UL GREENGUARD Certification Badge in Bottom Right Corner
 * - 100% Dynamic with fallback
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$ca            = ! empty( $settings['clean_air'] ) ? $settings['clean_air'] : array();
$eyebrow       = ! empty( $ca['eyebrow'] ) ? $ca['eyebrow'] : __( 'UL Clean Air Certified', 'woodmart-child' );
$title         = ! empty( $ca['title'] ) ? $ca['title'] : __( 'Print with Confidence, Breathe with Peace of Mind', 'woodmart-child' );
$desc          = ! empty( $ca['desc'] ) ? $ca['desc'] : __( 'The A2L is certified under the UL 2904 standard for 3D printing indoor air quality when used with official filaments. Testing with our core lineup—including Bambu PLA Basic, PLA Pure, and PETG Basic—confirms ultra-low emissions, making the A2L safe for indoor use.', 'woodmart-child' );
$lifestyle_img = ! empty( $ca['lifestyle_image'] ) ? $ca['lifestyle_image'] : '';
$badge_title   = ! empty( $ca['badge_title'] ) ? $ca['badge_title'] : 'GREENGUARD';
$badge_sub     = ! empty( $ca['badge_sub'] ) ? $ca['badge_sub'] : 'PRODUCT CERTIFIED FOR LOW CHEMICAL EMISSIONS';
?>

<section class="lc-clean-air-section" id="lc-clean-air">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-clean-air-header text-center">
			<span class="lc-green-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-desc"><?php echo esc_html( $desc ); ?></p>
		</div>

		<!-- Family & Living Room Lifestyle Visual Card -->
		<div class="lc-clean-air-card">
			<div class="lc-lifestyle-scene">
				<?php if ( ! empty( $lifestyle_img ) ) : ?>
					<img src="<?php echo esc_url( $lifestyle_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0;" />
				<?php else : ?>
					<!-- Living Room Environment Mockup -->
					<div class="lc-livingroom-backdrop">
						<div class="lc-window-light"></div>
						<div class="lc-family-silhouette-group">
							<div class="lc-person parent-father"></div>
							<div class="lc-person child-son"></div>
							<div class="lc-person parent-mother"></div>
							<div class="lc-dog-silhouette"></div>
						</div>
						<div class="lc-coffee-table">
							<div class="lc-printer-desktop-model"></div>
							<div class="lc-vivid-prints-cluster">
								<span class="lc-print-cone cone-green"></span>
								<span class="lc-print-disc disc-pink"></span>
								<span class="lc-print-spool spool-gold"></span>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<!-- UL GREENGUARD Certified Badge (Bottom Right) -->
				<div class="lc-greenguard-badge">
					<div class="lc-ul-logo-circle">
						<span class="lc-ul-text">UL</span>
					</div>
					<div class="lc-greenguard-label">
						<strong><?php echo esc_html( $badge_title ); ?></strong>
						<span class="lc-greenguard-sub"><?php echo esc_html( $badge_sub ); ?></span>
						<span class="lc-greenguard-std">UL.COM/GG · UL 2904</span>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>
