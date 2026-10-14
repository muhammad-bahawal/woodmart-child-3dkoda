<?php
/**
 * Template Part: Accessories Technical Specifications
 *
 * Clean 2-column grid displaying all hardware specs, thermal limits,
 * nozzle materials, and printer compatibility.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_accessories_section_enabled( 'specifications', $product_id ) ) {
	return;
}

$section = woodmart_child_get_accessories_section_data( 'specifications', $product_id );
$items   = ! empty( $section['items'] ) ? $section['items'] : array();
?>

<section class="accessories-specs-section" id="specifications">
	<div class="container">
		<div class="accessories-section-header text-center">
			<span class="accessories-eyebrow"><?php echo esc_html( $section['eyebrow'] ); ?></span>
			<h2 class="accessories-title"><?php echo esc_html( $section['title'] ); ?></h2>
			<p class="accessories-desc"><?php echo esc_html( $section['description'] ); ?></p>
		</div>

		<div class="accessories-specs-card">
			<div class="specs-grid-container">
				<?php foreach ( $items as $idx => $item ) : ?>
					<div class="spec-cell">
						<span class="spec-label"><?php echo esc_html( $item['label'] ); ?></span>
						<strong class="spec-value"><?php echo esc_html( $item['value'] ); ?></strong>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( ! empty( $section['note'] ) ) : ?>
				<div class="specs-footer-note">
					<span class="note-icon" aria-hidden="true">ℹ</span>
					<span class="note-text"><?php echo esc_html( $section['note'] ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
