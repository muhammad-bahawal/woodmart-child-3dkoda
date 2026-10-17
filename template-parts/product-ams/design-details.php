<?php
/**
 * Template Part: AMS Evolved, Polished Design Details
 *
 * Exact match to Image 4:
 * Title: "Evolved, Polished Design Details"
 * 2 Alternating Zig-Zag Rows:
 * 1. Image Left | Text Right: "Tool-Free Filament Tubes Access"
 * 2. Text Left | Image Right: "Ceramic Inlet"
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'design_details', $product_id );

$eyebrow  = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : '';
$title    = ! empty( $data['title'] ) ? $data['title'] : __( 'Evolved, Polished Design Details', 'woodmart-child' );
$subtitle = ! empty( $data['subtitle'] ) ? $data['subtitle'] : '';

$cards = ! empty( $data['cards'] ) ? $data['cards'] : array(
	array(
		'title' => __( 'Tool-Free Filament Tubes Access', 'woodmart-child' ),
		'desc'  => __( 'Removing snapped filament from the first-gen AMS requires extracting all spools and disassembling the shell with two screws, taking 3-5 minutes. In contrast, the AMS 2 Pro offers direct, tool-free access to filament tubes from the top.', 'woodmart-child' ),
		'image' => '',
	),
	array(
		'title' => __( 'Ceramic Inlet', 'woodmart-child' ),
		'desc'  => __( 'Ceramic filament inlets with Vickers hardness of 1200 significantly enhance durability.', 'woodmart-child' ),
		'image' => '',
	),
);
?>

<section class="ams-design-details-section" id="ams-design-details">
	<div class="ams-design-container container">
		<!-- Section Header -->
		<div class="ams-section-head text-center is-dark">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="ams-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="ams-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- 2 Zig-Zag Feature Rows (Image 4) -->
		<div class="ams-zigzag-grid ams-design-zigzag">
			<?php foreach ( $cards as $idx => $card ) : 
				// Row 0: Image Left, Text Right (is_reversed: false)
				// Row 1: Text Left, Image Right (is_reversed: true)
				$is_reversed = ( 1 === ( $idx % 2 ) );
			?>
				<div class="ams-zigzag-row <?php echo $is_reversed ? 'is-reversed' : ''; ?>">
					<!-- Media Column -->
					<div class="ams-zigzag-media">
						<?php if ( ! empty( $card['image'] ) ) : ?>
							<img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" loading="lazy" class="ams-zigzag-img">
						<?php else : ?>
							<!-- Stylized Glowing Dark Graphic Render -->
							<div class="ams-zigzag-graphic design-graphic-<?php echo esc_attr( $idx + 1 ); ?>">
								<?php if ( 0 === $idx ) : ?>
									<!-- Tool-Free Filament Tubes Manifold Glow -->
									<div class="graphic-tubes-manifold">
										<svg viewBox="0 0 360 260" fill="none" class="manifold-svg">
											<path d="M180 50 L180 90" stroke="#ff7a00" stroke-width="8" stroke-linecap="round"/>
											<!-- 4 converging curved golden paths -->
											<path d="M60 210 Q 120 140 170 100" stroke="#ff9900" stroke-width="6" stroke-linecap="round"/>
											<path d="M120 220 Q 150 150 176 100" stroke="#ffaa00" stroke-width="6" stroke-linecap="round"/>
											<path d="M240 220 Q 210 150 184 100" stroke="#ffaa00" stroke-width="6" stroke-linecap="round"/>
											<path d="M300 210 Q 240 140 190 100" stroke="#ff9900" stroke-width="6" stroke-linecap="round"/>
											<!-- Manifold Core Block -->
											<rect x="155" y="70" width="50" height="36" rx="8" fill="#1f2937" stroke="#ff7a00" stroke-width="2"/>
											<circle cx="180" cy="88" r="6" fill="#ff7a00"/>
										</svg>
									</div>
								<?php else : ?>
									<!-- Ceramic Funnel Inlet Graphic -->
									<div class="graphic-ceramic-inlet">
										<div class="ceramic-funnel-render">
											<div class="funnel-lip"></div>
											<div class="funnel-throat"></div>
											<div class="lever-latch"></div>
										</div>
										<span class="vickers-hardness-badge">HV 1200</span>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Text Column -->
					<div class="ams-zigzag-content">
						<h3 class="ams-zigzag-heading"><?php echo esc_html( $card['title'] ); ?></h3>
						<p class="ams-zigzag-desc"><?php echo nl2br( esc_html( $card['desc'] ?? '' ) ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
