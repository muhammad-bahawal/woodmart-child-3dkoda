<?php
/**
 * Template Part: AMS Technical Specifications
 *
 * Dynamic 2-column repeater grouped by category:
 * - Physical & Dimensions
 * - Spool Compatibility
 * - Electrical & Electronics
 * - Material Compatibility
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'specifications', $product_id );

$eyebrow  = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'Engineering Data', 'woodmart-child' );
$title    = ! empty( $data['title'] ) ? $data['title'] : __( 'Technical Specifications', 'woodmart-child' );
$subtitle = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( 'Full mechanical, electrical, and material specifications for Bambu Lab AMS.', 'woodmart-child' );
$items    = ! empty( $data['items'] ) ? $data['items'] : array();

// Group specs by category
$grouped_specs = array();
foreach ( $items as $si ) {
	$cat = ! empty( $si['category'] ) ? $si['category'] : __( 'General', 'woodmart-child' );
	if ( ! isset( $grouped_specs[ $cat ] ) ) {
		$grouped_specs[ $cat ] = array();
	}
	$grouped_specs[ $cat ][] = $si;
}
?>

<section class="ams-specs-section" id="ams-specifications">
	<div class="ams-specs-container container">
		<div class="ams-section-head text-center is-dark">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="ams-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="ams-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<div class="ams-specs-card">
			<div class="ams-specs-categories">
				<?php foreach ( $grouped_specs as $cat_name => $specs_list ) : ?>
					<div class="ams-specs-cat-group">
						<h3 class="ams-specs-cat-title"><?php echo esc_html( $cat_name ); ?></h3>
						<div class="ams-specs-rows">
							<?php foreach ( $specs_list as $spec ) : ?>
								<div class="ams-spec-row">
									<span class="spec-label"><?php echo esc_html( $spec['label'] ?? '' ); ?></span>
									<span class="spec-value"><?php echo esc_html( $spec['value'] ?? '' ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Expand / Collapse Button -->
			<div class="ams-specs-toggle-wrap">
				<button type="button" class="btn ams-specs-toggle-btn" id="ams-specs-toggle-btn">
					<span class="ams-toggle-text"><?php esc_html_e( 'Show all specifications', 'woodmart-child' ); ?></span>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<polyline points="6 9 12 15 18 9"></polyline>
					</svg>
				</button>
			</div>
		</div>
	</div>
</section>
