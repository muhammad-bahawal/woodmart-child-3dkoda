<?php
/**
 * Template Part: Technical Specifications Table
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_laser_crafting_section_enabled( 'specs', $product_id ) ) {
	return;
}

$section_data = woodmart_child_get_laser_crafting_section_data( 'specs', $product_id );
$eyebrow      = ! empty( $section_data['eyebrow'] ) ? $section_data['eyebrow'] : __( 'TECHNICAL SPECIFICATIONS', 'woodmart-child' );
$title        = ! empty( $section_data['title'] ) ? $section_data['title'] : __( 'Engineered to Higher Standards', 'woodmart-child' );
$subtitle     = ! empty( $section_data['description'] ) ? $section_data['description'] : __( 'Verified benchmarks and factory tolerances for Bambu Lab A2L multi-tool platform.', 'woodmart-child' );
$pdf_url      = ! empty( $section_data['pdf_url'] ) ? $section_data['pdf_url'] : '#';
$specs        = ! empty( $section_data['items'] ) && is_array( $section_data['items'] ) ? $section_data['items'] : ( ! empty( $section_data['specs'] ) ? $section_data['specs'] : array() );
?>

<section class="lc-specs-section" id="lc-specifications">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-section-header text-center">
			<span class="lc-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
		</div>

		<!-- Specifications Table Card -->
		<div class="lc-specs-card">
			<div class="lc-specs-table-wrapper" id="lc-specs-table-wrapper">
				<table class="lc-specs-table">
					<tbody>
						<?php foreach ( $specs as $s_idx => $s ) : 
							$cat   = ! empty( $s['category'] ) ? $s['category'] : ( ! empty( $s['cat'] ) ? $s['cat'] : __( 'General', 'woodmart-child' ) );
							$label = ! empty( $s['label'] ) ? $s['label'] : '';
							$val   = ! empty( $s['value'] ) ? $s['value'] : '';
							$is_hidden = ( $s_idx >= 8 );
							if ( empty( $label ) && empty( $val ) ) continue;
						?>
							<tr class="lc-spec-row <?php echo $is_hidden ? 'lc-spec-row-collapsible' : ''; ?>">
								<td class="lc-spec-cat"><?php echo esc_html( $cat ); ?></td>
								<td class="lc-spec-label"><?php echo esc_html( $label ); ?></td>
								<td class="lc-spec-val"><?php echo esc_html( $val ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<!-- Bottom Actions Row -->
			<div class="lc-specs-actions">
				<?php if ( count( $specs ) > 8 ) : ?>
					<button type="button" class="lc-specs-toggle-btn" id="lc-specs-toggle-btn">
						<span class="lc-toggle-text"><?php esc_html_e( 'Show all specifications (', 'woodmart-child' ); echo esc_html( count( $specs ) ); esc_html_e( ' items)', 'woodmart-child' ); ?></span>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</button>
				<?php endif; ?>

				<?php if ( ! empty( $pdf_url ) && $pdf_url !== '#' ) : ?>
					<a href="<?php echo esc_url( $pdf_url ); ?>" class="lc-specs-pdf-btn" target="_blank" rel="noopener noreferrer">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
						<span><?php esc_html_e( 'Download Technical Datasheet (PDF)', 'woodmart-child' ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>
