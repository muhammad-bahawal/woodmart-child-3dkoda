<?php
/**
 * Template Part: Accessories Visual Showcase & Performance Comparison
 *
 * Implements:
 * 1. 3-Vase layer height finish visual comparison (0.10mm, 0.20mm, 0.28mm)
 * 2. 4-Column Nozzle comparison matrix (0.2mm, 0.4mm, 0.6mm, 0.8mm)
 * 3. 4 3DBenchy blue hull quality cards
 * 4. Flow Rate & Layer Bond Strength progression chart (Yellow -> Green gradient)
 *
 * All matching the target screenshot.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_accessories_section_enabled( 'visual_showcase', $product_id ) ) {
	return;
}

$section = woodmart_child_get_accessories_section_data( 'visual_showcase', $product_id );
$vases   = ! empty( $section['vase_cards'] ) ? $section['vase_cards'] : array();
$nozzles = ! empty( $section['nozzle_columns'] ) ? $section['nozzle_columns'] : array();
$chart   = ! empty( $section['progression'] ) ? $section['progression'] : array();
?>

<section class="accessories-visuals-section" id="performance">
	<div class="container">
		<!-- Section Header -->
		<div class="accessories-section-header text-center">
			<span class="accessories-eyebrow"><?php echo esc_html( $section['eyebrow'] ); ?></span>
			<h2 class="accessories-title"><?php echo esc_html( $section['title'] ); ?></h2>
			<p class="accessories-desc"><?php echo esc_html( $section['description'] ); ?></p>
		</div>

		<!-- Part 1: Layer Height Surface Finish (3 Vases Showcase Matching Screenshot) -->
		<?php if ( ! empty( $vases ) ) : ?>
			<div class="layer-height-vases-block">
				<div class="block-subtitle-wrap text-center">
					<h3 class="block-title"><?php esc_html_e( 'Visual Print Quality Across Layer Resolutions', 'woodmart-child' ); ?></h3>
					<p class="block-caption"><?php esc_html_e( 'Compare surface smoothness and layer line visibility using identical Bambu Lab PLA filament.', 'woodmart-child' ); ?></p>
				</div>

				<div class="vases-grid">
					<?php foreach ( $vases as $idx => $v ) :
						$layer_num = preg_replace( '/[^0-9.]/', '', $v['layer'] );
						$wave_density = ( '0.10' === $layer_num || '0.1' === $layer_num ) ? 28 : ( ( '0.20' === $layer_num || '0.2' === $layer_num ) ? 16 : 9 );
					?>
						<div class="vase-card">
							<div class="vase-visual-wrapper">
								<!-- Realistic Emerald Green Spiral Vase Simulation matching Screenshot -->
								<div class="vase-printer-bed-mockup">
									<div class="printhead-indicator">
										<div class="extruder-block"></div>
									</div>
									<div class="emerald-vase-graphic" data-resolution="<?php echo esc_attr( $v['layer'] ); ?>">
										<svg class="vase-svg" viewBox="0 0 160 220" fill="none" xmlns="http://www.w3.org/2000/svg">
											<defs>
												<linearGradient id="vase-grad-<?php echo esc_attr( $idx ); ?>" x1="0%" y1="0%" x2="100%" y2="100%">
													<stop offset="0%" stop-color="#00e676"/>
													<stop offset="45%" stop-color="#00c853"/>
													<stop offset="85%" stop-color="#009624"/>
													<stop offset="100%" stop-color="#00600f"/>
												</linearGradient>
												<linearGradient id="highlight-grad-<?php echo esc_attr( $idx ); ?>" x1="0%" y1="0%" x2="100%" y2="0%">
													<stop offset="0%" stop-color="#ffffff" stop-opacity="0.6"/>
													<stop offset="50%" stop-color="#ffffff" stop-opacity="0"/>
												</linearGradient>
											</defs>
											<!-- Vase Body Silhouette with Elegant Swirl -->
											<path d="M48 20 C48 55, 18 85, 26 135 C32 175, 52 205, 80 205 C108 205, 128 175, 134 135 C142 85, 112 55, 112 20 Z" fill="url(#vase-grad-<?php echo esc_attr( $idx ); ?>)"/>
											<!-- Layer Lines Pattern -->
											<g class="vase-layer-lines" stroke="#004d1a" stroke-width="0.7" opacity="0.45">
												<?php for ( $y = 25; $y < 200; $y += max( 4, 180 / $wave_density ) ) : ?>
													<path d="M<?php echo 80 - 45 * sin( $y / 35 ); ?> <?php echo $y; ?> Q80 <?php echo $y + 3; ?> <?php echo 80 + 45 * sin( $y / 35 ); ?> <?php echo $y; ?>"/>
												<?php endfor; ?>
											</g>
											<!-- Highlight Sheen -->
											<path d="M60 25 C60 55, 35 85, 42 135 C46 160, 56 185, 75 195 C62 185, 52 155, 48 135 C42 85, 72 55, 72 25 Z" fill="url(#highlight-grad-<?php echo esc_attr( $idx ); ?>)"/>
										</svg>
									</div>
									<div class="printbed-base"></div>
								</div>
								<div class="vase-layer-pill"><?php echo esc_html( $v['layer'] ); ?></div>
							</div>

							<div class="vase-card-body">
								<div class="vase-header-row">
									<h4 class="vase-title"><?php echo esc_html( $v['name'] ); ?></h4>
									<?php if ( ! empty( $v['badge'] ) ) : ?>
										<span class="vase-badge"><?php echo esc_html( $v['badge'] ); ?></span>
									<?php endif; ?>
								</div>
								<p class="vase-desc"><?php echo esc_html( $v['desc'] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Part 2: Comparison of Different Nozzle Sizes (4 Columns Matching Screenshot) -->
		<?php if ( ! empty( $nozzles ) ) : ?>
			<div class="nozzle-comparison-table-block">
				<div class="block-subtitle-wrap text-center">
					<h3 class="block-title"><?php esc_html_e( 'Comparison of Different Nozzle Sizes', 'woodmart-child' ); ?></h3>
					<p class="block-caption"><?php esc_html_e( 'Select the ideal hotend aperture based on mechanical load, abrasive fibers, and build turnaround requirements.', 'woodmart-child' ); ?></p>
				</div>

				<div class="nozzle-columns-grid">
					<?php foreach ( $nozzles as $n ) : ?>
						<div class="nozzle-col-card">
							<div class="nozzle-col-header">
								<span class="nozzle-size-badge"><?php echo esc_html( $n['size'] ); ?></span>
								<h4 class="nozzle-size-title"><?php echo esc_html( $n['title'] ); ?></h4>
							</div>

							<div class="nozzle-specs-list">
								<div class="nozzle-spec-row">
									<span class="spec-label"><?php esc_html_e( 'Layer Height', 'woodmart-child' ); ?></span>
									<strong class="spec-val"><?php echo esc_html( $n['layer_range'] ); ?></strong>
								</div>
								<div class="nozzle-spec-row">
									<span class="spec-label"><?php esc_html_e( 'Max Volumetric Flow', 'woodmart-child' ); ?></span>
									<strong class="spec-val"><?php echo esc_html( $n['flow'] ); ?></strong>
								</div>
								<div class="nozzle-spec-row">
									<span class="spec-label"><?php esc_html_e( 'Abrasives (CF/GF)', 'woodmart-child' ); ?></span>
									<strong class="spec-val <?php echo false !== stripos( $n['abrasive'], 'not' ) ? 'val-warning' : 'val-good'; ?>"><?php echo esc_html( $n['abrasive'] ); ?></strong>
								</div>
								<div class="nozzle-spec-row">
									<span class="spec-label"><?php esc_html_e( 'Best For', 'woodmart-child' ); ?></span>
									<span class="spec-val val-desc"><?php echo esc_html( $n['best_for'] ); ?></span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Part 2b: 3DBenchy Visual Hull Cards Matching Screenshot -->
				<div class="benchy-hulls-showcase">
					<div class="benchy-grid">
						<?php foreach ( $nozzles as $n ) : ?>
							<div class="benchy-card">
								<div class="benchy-visual-wrap">
									<!-- Visual 3DBenchy Hull Simulation in Bambu Blue -->
									<div class="benchy-boat-mockup">
										<svg class="benchy-svg" viewBox="0 0 160 120" fill="none" xmlns="http://www.w3.org/2000/svg">
											<defs>
												<linearGradient id="benchy-blue-grad" x1="0%" y1="0%" x2="100%" y2="100%">
													<stop offset="0%" stop-color="#3b82f6"/>
													<stop offset="60%" stop-color="#1d4ed8"/>
													<stop offset="100%" stop-color="#1e3a8a"/>
												</linearGradient>
											</defs>
											<!-- Benchy Hull Contour -->
											<path d="M12 78 C25 98, 55 106, 110 106 C142 106, 152 88, 152 74 L148 68 L104 68 L104 52 L60 52 L60 68 L24 68 Z" fill="url(#benchy-blue-grad)"/>
											<!-- Cabin -->
											<rect x="64" y="32" width="36" height="34" rx="3" fill="#1d4ed8"/>
											<rect x="70" y="38" width="12" height="14" rx="2" fill="#0f172a"/>
											<rect x="86" y="38" width="10" height="14" rx="2" fill="#0f172a"/>
											<!-- Chimney -->
											<rect x="88" y="16" width="10" height="18" rx="2" fill="#2563eb"/>
											<!-- Layer Texture Lines -->
											<g stroke="#60a5fa" stroke-width="0.8" opacity="0.35">
												<line x1="20" y1="74" x2="148" y2="74"/>
												<line x1="26" y1="80" x2="142" y2="80"/>
												<line x1="34" y1="86" x2="134" y2="86"/>
												<line x1="44" y1="92" x2="124" y2="92"/>
												<line x1="56" y1="98" x2="114" y2="98"/>
											</g>
										</svg>
									</div>
									<div class="benchy-badge"><?php echo esc_html( $n['size'] ); ?> <?php esc_html_e( 'Nozzle', 'woodmart-child' ); ?></div>
								</div>
								<div class="benchy-caption-box">
									<strong class="benchy-caption-title"><?php echo esc_html( $n['size'] ); ?> <?php esc_html_e( 'Print Finish', 'woodmart-child' ); ?></strong>
									<span class="benchy-caption-text"><?php echo esc_html( $n['benchy_desc'] ); ?></span>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- Part 3: Volumetric Flow Rate vs Strength Progression Bar Chart (Yellow -> Green) -->
		<?php if ( ! empty( $chart['bars'] ) ) : ?>
			<div class="accessories-chart-card">
				<div class="chart-header-row">
					<div class="chart-header-left">
						<h3 class="chart-title"><?php echo esc_html( $chart['title'] ); ?></h3>
						<?php if ( ! empty( $chart['note'] ) ) : ?>
							<p class="chart-note"><?php echo esc_html( $chart['note'] ); ?></p>
						<?php endif; ?>
					</div>
					<div class="chart-legend">
						<span class="legend-item"><span class="legend-dot dot-flow"></span> <?php esc_html_e( 'Volumetric Flow Rate', 'woodmart-child' ); ?></span>
						<span class="legend-item"><span class="legend-dot dot-strength"></span> <?php esc_html_e( 'Layer Tensile Strength', 'woodmart-child' ); ?></span>
					</div>
				</div>

				<div class="chart-graph-wrapper">
					<div class="chart-y-axis-labels">
						<span class="y-top"><?php esc_html_e( 'Max Flow (32+ mm³/s)', 'woodmart-child' ); ?></span>
						<span class="y-mid"><?php esc_html_e( 'Standard (20 mm³/s)', 'woodmart-child' ); ?></span>
						<span class="y-low"><?php esc_html_e( 'Fine (8–10 mm³/s)', 'woodmart-child' ); ?></span>
					</div>

					<div class="chart-bars-track">
						<?php foreach ( $chart['bars'] as $b_idx => $b ) :
							$pct = intval( $b['strength_pct'] ?? ( 30 + $b_idx * 23 ) );
						?>
							<div class="chart-bar-column">
								<div class="bar-value-pill"><?php echo esc_html( $b['flow'] ); ?></div>
								<div class="bar-fill-container">
									<div class="bar-fill-gradient step-<?php echo esc_attr( $b_idx + 1 ); ?>" style="height: <?php echo esc_attr( $pct ); ?>%;">
										<div class="bar-glow"></div>
									</div>
								</div>
								<div class="bar-x-label">
									<strong class="nozzle-x-name"><?php echo esc_html( $b['size'] ); ?></strong>
									<span class="nozzle-x-sub"><?php echo esc_html( $b['label'] ); ?></span>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
