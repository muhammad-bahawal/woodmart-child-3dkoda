<?php
/**
 * Template Part: Accessories Overview & Key Selling Points
 *
 * Implements high-impact graphic and split resolution comparison (0.2mm vs 0.4mm)
 * exactly matching the target screenshot.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_accessories_section_enabled( 'overview', $product_id ) ) {
	return;
}

$section = woodmart_child_get_accessories_section_data( 'overview', $product_id );
?>

<section class="accessories-overview-section" id="overview">
	<div class="container">
		<div class="accessories-section-header text-center">
			<span class="accessories-eyebrow"><?php echo esc_html( $section['eyebrow'] ); ?></span>
			<h2 class="accessories-title"><?php echo esc_html( $section['title'] ); ?></h2>
			<p class="accessories-desc"><?php echo esc_html( $section['description'] ); ?></p>
		</div>

		<?php if ( ! empty( $section['image'] ) ) : ?>
			<div class="accessories-hero-graphic-wrap">
				<img src="<?php echo esc_url( $section['image'] ); ?>" alt="<?php echo esc_attr( $section['title'] ); ?>" class="accessories-hero-graphic" loading="lazy">
			</div>
		<?php endif; ?>

		<!-- Dark High-Impact Resolution Comparison Showcase (Matching Screenshot) -->
		<div class="accessories-resolution-showcase-card">
			<div class="resolution-showcase-header text-center">
				<span class="showcase-badge"><?php echo esc_html( $section['showcase_eyebrow'] ); ?></span>
				<h3 class="showcase-title"><?php echo esc_html( $section['showcase_title'] ); ?></h3>
				<?php if ( ! empty( $section['showcase_desc'] ) ) : ?>
					<p class="showcase-desc"><?php echo esc_html( $section['showcase_desc'] ); ?></p>
				<?php endif; ?>
			</div>

			<div class="resolution-cards-grid">
				<!-- Card 1: 0.2mm Nozzle -->
				<div class="resolution-card card-02">
					<div class="resolution-badge-pill"><?php echo esc_html( $section['card_02']['badge'] ); ?></div>
					<div class="resolution-visual-wrap">
						<div class="resolution-magnifier-mockup">
							<div class="magnifier-circle">
								<div class="magnifier-lens">
									<div class="micro-text-simulation fine-text">
										<span class="brand-logo-text">Bambu Lab</span>
										<span class="sub-micro-line">0.2mm high-precision micro-text</span>
										<span class="sub-micro-details">Automated first layer • Ultra-clean edges</span>
									</div>
								</div>
								<div class="magnifier-rim"></div>
							</div>
							<div class="sample-tag-plate">
								<div class="tag-header">Bambu Lab</div>
								<div class="tag-body-lines fine">
									<span></span><span></span><span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="resolution-card-content">
						<div class="resolution-tag"><?php echo esc_html( $section['card_02']['tag'] ); ?></div>
						<h4 class="resolution-name"><?php echo esc_html( $section['card_02']['title'] ); ?></h4>
						<p class="resolution-info"><?php echo esc_html( $section['card_02']['description'] ); ?></p>
					</div>
				</div>

				<!-- Card 2: 0.4mm Nozzle -->
				<div class="resolution-card card-04">
					<div class="resolution-badge-pill"><?php echo esc_html( $section['card_04']['badge'] ); ?></div>
					<div class="resolution-visual-wrap">
						<div class="resolution-magnifier-mockup">
							<div class="magnifier-circle">
								<div class="magnifier-lens">
									<div class="micro-text-simulation standard-text">
										<span class="brand-logo-text">Bambu Lab</span>
										<span class="sub-micro-line">0.4mm standard production text</span>
										<span class="sub-micro-details">Balanced speed & strength</span>
									</div>
								</div>
								<div class="magnifier-rim"></div>
							</div>
							<div class="sample-tag-plate">
								<div class="tag-header">Bambu Lab</div>
								<div class="tag-body-lines standard">
									<span></span><span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="resolution-card-content">
						<div class="resolution-tag"><?php echo esc_html( $section['card_04']['tag'] ); ?></div>
						<h4 class="resolution-name"><?php echo esc_html( $section['card_04']['title'] ); ?></h4>
						<p class="resolution-info"><?php echo esc_html( $section['card_04']['description'] ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
