<?php
/**
 * Template Part: AMS Multi-Color Architecture
 *
 * Showcase for 4-spool up to 16-spool feeding chains and multi-material versatility.
 * - 4-to-1 Funnel and rotary gear mechanism
 * - AMS Hub Daisy-Chain Expansion for 16 colors
 * - Multi-material versatility (Soluble supports, PVA/BVOH, ABS+PETG)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'multicolor_architecture', $product_id );

$eyebrow       = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'Multi-Color Architecture', 'woodmart-child' );
$title         = ! empty( $data['title'] ) ? $data['title'] : __( 'Seamless Multi-Color & Multi-Material Capabilities', 'woodmart-child' );
$subtitle      = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( 'A 4-in-1 multi-channel funnel integrates 4 independent feed motors with optical sensors.', 'woodmart-child' );
$chain_title   = ! empty( $data['chain_title'] ) ? $data['chain_title'] : __( 'Scale from 4 to 16 Colors', 'woodmart-child' );
$chain_badge   = ! empty( $data['chain_badge'] ) ? $data['chain_badge'] : __( '16-Color Daisy Chain', 'woodmart-child' );
$chain_desc    = ! empty( $data['chain_desc'] ) ? $data['chain_desc'] : __( 'Connect up to 4 AMS units simultaneously using the Bambu Lab AMS Hub to unlock 16-color capability for rich sculptures, multi-material functional assemblies, and water-soluble supports (PVA/BVOH).', 'woodmart-child' );
$diagram_image = ! empty( $data['diagram_image'] ) ? $data['diagram_image'] : '';
$features      = ! empty( $data['features'] ) ? $data['features'] : array();
?>

<section class="ams-multicolor-section container" id="ams-multicolor">
	<div class="ams-section-head text-center">
		<?php if ( ! empty( $eyebrow ) ) : ?>
			<span class="ams-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>
		<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
		<?php if ( ! empty( $subtitle ) ) : ?>
			<p class="ams-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>

	<!-- Funnel Architecture & Daisy-Chain Hub Card -->
	<div class="ams-multicolor-card">
		<div class="ams-mc-header">
			<div class="ams-mc-header-text">
				<?php if ( ! empty( $chain_badge ) ) : ?>
					<span class="ams-mc-badge"><?php echo esc_html( $chain_badge ); ?></span>
				<?php endif; ?>
				<h3 class="ams-mc-heading"><?php echo esc_html( $chain_title ); ?></h3>
				<p class="ams-mc-desc"><?php echo esc_html( $chain_desc ); ?></p>
			</div>

			<!-- Visual Spool Counters -->
			<div class="ams-spool-counter-strip">
				<div class="counter-box is-active">
					<span class="num">1</span>
					<span class="sub">AMS (4 Col)</span>
				</div>
				<div class="counter-sep">+</div>
				<div class="counter-box">
					<span class="num">2</span>
					<span class="sub">AMS (8 Col)</span>
				</div>
				<div class="counter-sep">+</div>
				<div class="counter-box">
					<span class="num">3</span>
					<span class="sub">AMS (12 Col)</span>
				</div>
				<div class="counter-sep">+</div>
				<div class="counter-box is-highlight">
					<span class="num">4</span>
					<span class="sub">AMS (16 Col)</span>
				</div>
			</div>
		</div>

		<!-- Central Graphic / Diagram -->
		<div class="ams-mc-diagram">
			<?php if ( ! empty( $diagram_image ) ) : ?>
				<img src="<?php echo esc_url( $diagram_image ); ?>" alt="<?php echo esc_attr( $chain_title ); ?>" loading="lazy" class="ams-diagram-img">
			<?php else : ?>
				<!-- High-Fidelity 4-in-1 Funnel Drive Schematic -->
				<div class="ams-funnel-schematic">
					<div class="funnel-channels">
						<div class="channel-line ch-1"><span class="ch-filament c-cyan"></span><span class="ch-label">Bay 1</span></div>
						<div class="channel-line ch-2"><span class="ch-filament c-green"></span><span class="ch-label">Bay 2</span></div>
						<div class="channel-line ch-3"><span class="ch-filament c-orange"></span><span class="ch-label">Bay 3</span></div>
						<div class="channel-line ch-4"><span class="ch-filament c-purple"></span><span class="ch-label">Bay 4</span></div>
					</div>
					<div class="funnel-junction">
						<div class="hub-funnel-core">
							<span class="core-icon">4-in-1 Hub</span>
						</div>
					</div>
					<div class="funnel-output">
						<div class="output-ptfe-tube">
							<span class="pulse-flow"></span>
							<span class="out-label">To Toolhead & Cutter →</span>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- Architecture Feature Points -->
		<?php if ( ! empty( $features ) && is_array( $features ) ) : ?>
			<div class="ams-mc-features-grid">
				<?php foreach ( $features as $feat ) : ?>
					<div class="mc-feature-item">
						<div class="mc-feature-icon" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
								<polyline points="20 6 9 17 4 12"></polyline>
							</svg>
						</div>
						<div class="mc-feature-content">
							<h4 class="mc-feature-title"><?php echo esc_html( $feat['title'] ?? '' ); ?></h4>
							<p class="mc-feature-desc"><?php echo esc_html( $feat['desc'] ?? '' ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
