<?php
/**
 * Template Part: Accessories What's in the Box
 *
 * Displays package contents comparison:
 * Complete Hotend Assembly vs Hotend with Nozzle (Core Unit).
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_accessories_section_enabled( 'box_contents', $product_id ) ) {
	return;
}

$section = woodmart_child_get_accessories_section_data( 'box_contents', $product_id );
$asm_items = ! empty( $section['assembly_items'] ) ? $section['assembly_items'] : array();
$noz_items = ! empty( $section['nozzle_items'] ) ? $section['nozzle_items'] : array();
?>

<section class="accessories-box-section" id="box-contents">
	<div class="container">
		<div class="accessories-section-header text-center">
			<span class="accessories-eyebrow"><?php echo esc_html( $section['eyebrow'] ); ?></span>
			<h2 class="accessories-title"><?php echo esc_html( $section['title'] ); ?></h2>
			<?php if ( ! empty( $section['note'] ) ) : ?>
				<p class="accessories-desc"><?php echo esc_html( $section['note'] ); ?></p>
			<?php endif; ?>
		</div>

		<div class="accessories-box-cards-grid">
			<!-- Package 1: Complete Assembly -->
			<div class="box-card assembly-card">
				<div class="box-card-header">
					<?php if ( ! empty( $section['assembly_badge'] ) ) : ?>
						<span class="box-badge-pill"><?php echo esc_html( $section['assembly_badge'] ); ?></span>
					<?php endif; ?>
					<h3 class="box-package-title"><?php echo esc_html( $section['assembly_title'] ); ?></h3>
					<span class="box-package-sub"><?php esc_html_e( 'Pre-wired with heater, thermistor & fan', 'woodmart-child' ); ?></span>
				</div>

				<ul class="box-items-list">
					<?php foreach ( $asm_items as $item ) : ?>
						<li class="box-item">
							<span class="item-check" aria-hidden="true">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="20 6 9 17 4 12"></polyline>
								</svg>
							</span>
							<span class="item-name"><?php echo esc_html( $item ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Package 2: Core Nozzle Unit -->
			<div class="box-card nozzle-only-card">
				<div class="box-card-header">
					<?php if ( ! empty( $section['nozzle_badge'] ) ) : ?>
						<span class="box-badge-pill badge-secondary"><?php echo esc_html( $section['nozzle_badge'] ); ?></span>
					<?php endif; ?>
					<h3 class="box-package-title"><?php echo esc_html( $section['nozzle_title'] ); ?></h3>
					<span class="box-package-sub"><?php esc_html_e( 'Requires transferring existing heater & fan', 'woodmart-child' ); ?></span>
				</div>

				<ul class="box-items-list">
					<?php foreach ( $noz_items as $item ) : ?>
						<li class="box-item">
							<span class="item-check" aria-hidden="true">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="20 6 9 17 4 12"></polyline>
								</svg>
							</span>
							<span class="item-name"><?php echo esc_html( $item ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
