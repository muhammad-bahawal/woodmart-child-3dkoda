<?php
/**
 * Template Part: Oversized Build Volume Showcase
 *
 * Exact match to Image 5:
 * - Eyebrow: Oversized Build Volume (Green)
 * - Heading: Extra Large Volume for Extra Bold Ideas
 * - Description: 330 × 320 × 325 mm. That’s 105% more space than the 256 mm class...
 * - Top Visual: 3D bounding box cube graphic with 330 × 320 × 325 mm dimensions
 * - Bottom 2-Column Comparison: A1 (Sword cuts off in red) vs A2L (Sword fits completely in green)
 * - 100% Dynamic with fallback
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$bv          = ! empty( $settings['build_volume'] ) ? $settings['build_volume'] : array();
$eyebrow     = ! empty( $bv['eyebrow'] ) ? $bv['eyebrow'] : __( 'Oversized Build Volume', 'woodmart-child' );
$title       = ! empty( $bv['title'] ) ? $bv['title'] : __( 'Extra Large Volume for Extra Bold Ideas', 'woodmart-child' );
$desc        = ! empty( $bv['desc'] ) ? $bv['desc'] : __( "330 × 320 × 325 mm. That's 105% more space than the 256 mm class. A full-scale helmet, in one piece. A batch of 40 fidget toys, in one run. The kind of project that used to mean slicing your model into chunks—or starting over when the seams didn't line up—now just fits.", 'woodmart-child' );
$dim_w       = ! empty( $bv['dim_w'] ) ? $bv['dim_w'] : '330 mm';
$dim_d       = ! empty( $bv['dim_d'] ) ? $bv['dim_d'] : '320 mm';
$dim_h       = ! empty( $bv['dim_h'] ) ? $bv['dim_h'] : '325 mm';
$machine_tag = ! empty( $bv['machine_tag'] ) ? $bv['machine_tag'] : 'BAMBU LAB A2L 330×320×325 mm³ ENVELOPE';
$a1_sub      = ! empty( $bv['a1_sub'] ) ? $bv['a1_sub'] : __( '256 × 256 mm · Model must be sliced into parts', 'woodmart-child' );
$a2l_sub     = ! empty( $bv['a2l_sub'] ) ? $bv['a2l_sub'] : __( '330 × 320 mm · Single-piece continuous print', 'woodmart-child' );
$a1_img      = ! empty( $bv['a1_image'] ) ? $bv['a1_image'] : '';
$a2l_img     = ! empty( $bv['a2l_image'] ) ? $bv['a2l_image'] : '';
?>

<section class="lc-build-volume-section" id="lc-build-volume">
	<div class="container">
		<!-- Section Header -->
		<div class="lc-volume-header text-center">
			<span class="lc-volume-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-volume-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-volume-desc"><?php echo esc_html( $desc ); ?></p>
		</div>

		<!-- Top Visual: 3D Machine with Volume Cube Render -->
		<div class="lc-volume-hero-card">
			<div class="lc-cube-mockup">
				<div class="lc-cube-3d">
					<div class="lc-cube-face lc-cube-front">
						<span class="lc-cube-dim-w"><?php echo esc_html( $dim_w ); ?></span>
						<span class="lc-cube-dim-h"><?php echo esc_html( $dim_h ); ?></span>
					</div>
					<div class="lc-cube-face lc-cube-top">
						<span class="lc-cube-dim-d"><?php echo esc_html( $dim_d ); ?></span>
					</div>
				</div>
				<div class="lc-machine-base">
					<span class="lc-machine-tag"><?php echo esc_html( $machine_tag ); ?></span>
				</div>
			</div>
		</div>

		<!-- Bottom 2-Column Comparison: A1 vs A2L Bed Size (Sword Graphic) -->
		<div class="lc-bed-comparison-grid">
			<!-- Left: Standard A1 (256mm) with Red Exceeded Boundary -->
			<div class="lc-bed-card lc-bed-a1">
				<div class="lc-bed-viewport">
					<?php if ( ! empty( $a1_img ) ) : ?>
						<img src="<?php echo esc_url( $a1_img ); ?>" alt="A1 Bed" style="width:100%; height:100%; object-fit:contain;" />
					<?php else : ?>
						<div class="lc-bed-plate plate-a1">
							<!-- Pixel Sword Mockup -->
							<div class="lc-sword-model sword-overflow">
								<div class="lc-sword-handle"></div>
								<div class="lc-sword-guard"></div>
								<div class="lc-sword-blade"></div>
								<div class="lc-sword-tip tip-overflow" aria-label="<?php esc_attr_e( 'Exceeds printable area', 'woodmart-child' ); ?>">
									<span class="lc-overflow-warning">!</span>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="lc-bed-footer text-center">
					<span class="lc-bed-badge badge-grey">A1</span>
					<span class="lc-bed-sub"><?php echo esc_html( $a1_sub ); ?></span>
				</div>
			</div>

			<!-- Right: Bambu Lab A2L (330mm) with Full Green Fit -->
			<div class="lc-bed-card lc-bed-a2l">
				<div class="lc-bed-viewport">
					<?php if ( ! empty( $a2l_img ) ) : ?>
						<img src="<?php echo esc_url( $a2l_img ); ?>" alt="A2L Bed" style="width:100%; height:100%; object-fit:contain;" />
					<?php else : ?>
						<div class="lc-bed-plate plate-a2l">
							<!-- Pixel Sword Mockup -->
							<div class="lc-sword-model sword-fits">
								<div class="lc-sword-handle"></div>
								<div class="lc-sword-guard"></div>
								<div class="lc-sword-blade"></div>
								<div class="lc-sword-tip tip-fits"></div>
							</div>
							<div class="lc-safe-zone-indicators">
								<span class="lc-safe-arrow arrow-top">↑</span>
								<span class="lc-safe-arrow arrow-right">→</span>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="lc-bed-footer text-center">
					<span class="lc-bed-badge badge-green">A2L</span>
					<span class="lc-bed-sub"><?php echo esc_html( $a2l_sub ); ?></span>
				</div>
			</div>
		</div>

	</div>
</section>
