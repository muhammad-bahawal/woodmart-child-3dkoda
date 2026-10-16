<?php
/**
 * Template Part: Support 2nd-Gen AMS
 *
 * Exact match to User Instruction 2 & Image 2:
 * - Title: Support 2nd-Gen AMS
 * - Paragraph: Pair the A2L with the 2nd-Gen AMS...
 * - Green Highlight Badges: 19-Color Printing | Filament Drying | Enclosed Storage
 * - Clean Image Card container where the AMS architecture diagram image is added
 * - 100% Dynamic with fallback
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$section_data = woodmart_child_get_laser_crafting_section_data( 'ams_multicolor', $product_id );

$title       = ! empty( $section_data['ams_diagram_title'] ) ? $section_data['ams_diagram_title'] : __( 'Support 2nd–Gen AMS', 'woodmart-child' );
$desc        = ! empty( $section_data['ams_diagram_desc'] ) ? $section_data['ams_diagram_desc'] : __( 'Pair the A2L with the 2nd-Gen AMS, and your filament gets a sealed, climate-controlled home—dried on demand before each print, kept airtight between them. Need more colors? Need different material types running side by side? AMS lite and the 2nd-Gen AMS share the same embedded buffer system, so you can stack and mix them: four spools, eight spools, sixteen spools—whatever your project asks for, fed cleanly through one queue.', 'woodmart-child' );
$pills_text  = ! empty( $section_data['ams_diagram_pills'] ) ? $section_data['ams_diagram_pills'] : __( '19-Color Printing | Filament Drying | Enclosed Storage', 'woodmart-child' );
$diagram_img = ! empty( $section_data['ams_diagram_img'] ) ? $section_data['ams_diagram_img'] : '';

$pills = array_map( 'trim', explode( '|', $pills_text ) );
?>

<section class="lc-support-ams-section" id="lc-support-ams">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-support-ams-header text-center">
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-desc"><?php echo esc_html( $desc ); ?></p>
			<?php if ( ! empty( $pills ) ) : ?>
				<div class="lc-ams-highlight-pills">
					<?php foreach ( $pills as $p_idx => $pill ) : ?>
						<?php if ( $p_idx > 0 ) : ?><span class="lc-pill-sep">|</span><?php endif; ?>
						<span class="lc-green-pill-text"><?php echo esc_html( $pill ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- AMS Architecture Diagram Image Card -->
		<div class="lc-ams-diagram-card">
			<div class="lc-ams-diagram-img-wrap">
				<?php if ( ! empty( $diagram_img ) ) : ?>
					<img src="<?php echo esc_url( $diagram_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="lc-ams-diagram-image" />
				<?php else : ?>
					<!-- Responsive Illustrated Diagram Graphic (A2L -> Filament x 3 / Filament x 16) -->
					<div class="lc-diagram-grid">
						<div class="lc-diagram-printer">
							<div class="lc-printer-mockup">
								<div class="lc-printer-screen-tag"><?php esc_html_e( 'Bambu Lab A2L', 'woodmart-child' ); ?></div>
							</div>
						</div>

						<div class="lc-diagram-connector">
							<svg class="lc-connector-arrow" viewBox="0 0 100 80" fill="none" stroke="#9ca3af" stroke-width="2.5" stroke-linecap="round">
								<path d="M10 40 L50 40 M50 40 L50 20 L85 20 M50 40 L50 60 L85 60"></path>
								<polyline points="80 15 85 20 80 25"></polyline>
								<polyline points="80 55 85 60 80 65"></polyline>
							</svg>
						</div>

						<div class="lc-diagram-modules">
							<div class="lc-ams-unit ams-lite">
								<span class="lc-unit-label"><?php esc_html_e( 'External Spools (Up to 3)', 'woodmart-child' ); ?></span>
								<div class="lc-spool-stack">
									<span class="lc-spool s1"></span>
									<span class="lc-spool s2"></span>
									<span class="lc-spool s3"></span>
								</div>
							</div>

							<div class="lc-ams-unit ams-gen2">
								<span class="lc-unit-label"><?php esc_html_e( '2nd-Gen AMS (Up to 16 Spools)', 'woodmart-child' ); ?></span>
								<div class="lc-ams-box-visual">
									<div class="lc-ams-lid"></div>
									<div class="lc-ams-slots">
										<span></span><span></span><span></span><span></span>
									</div>
									<span class="lc-ams-badge"><?php esc_html_e( 'Heated Chamber', 'woodmart-child' ); ?></span>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>
