<?php
/**
 * Template Part: Accessories Filament & Hardware Compatibility Matrix
 *
 * Implements the comprehensive compatibility table matching the target screenshot:
 * - Columns: Filament Type, 0.2mm, 0.4mm, 0.6mm, 0.8mm
 * - Status pills: Recommended (✓), Hardened Steel Required (▲), Not Recommended (✕)
 * - Category groupings & responsive table wrapper
 * - Footnote advisory note
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_accessories_section_enabled( 'compatibility_matrix', $product_id ) ) {
	return;
}

$section = woodmart_child_get_accessories_section_data( 'compatibility_matrix', $product_id );
$rows    = ! empty( $section['rows'] ) ? $section['rows'] : array();

// Group rows by category
$grouped = array();
foreach ( $rows as $r ) {
	$cat = ! empty( $r['category'] ) ? $r['category'] : __( 'General Filaments', 'woodmart-child' );
	if ( ! isset( $grouped[ $cat ] ) ) {
		$grouped[ $cat ] = array();
	}
	$grouped[ $cat ][] = $r;
}

function render_status_badge( $status ) {
	$status = strtolower( trim( $status ) );
	if ( 'hardened' === $status ) {
		return '<span class="compat-status-badge badge-hardened" title="' . esc_attr__( 'Hardened Steel Required', 'woodmart-child' ) . '"><span class="badge-icon">▲</span> ' . esc_html__( 'Hardened Steel', 'woodmart-child' ) . '</span>';
	} elseif ( 'no' === $status || 'false' === $status || '0' === $status ) {
		return '<span class="compat-status-badge badge-no" title="' . esc_attr__( 'Not Recommended / Clog Risk', 'woodmart-child' ) . '"><span class="badge-icon">✕</span> ' . esc_html__( 'Not Recommended', 'woodmart-child' ) . '</span>';
	} else {
		return '<span class="compat-status-badge badge-yes" title="' . esc_attr__( 'Recommended & Fully Tested', 'woodmart-child' ) . '"><span class="badge-icon">✓</span> ' . esc_html__( 'Recommended', 'woodmart-child' ) . '</span>';
	}
}
?>

<section class="accessories-compatibility-section" id="compatibility">
	<div class="container">
		<div class="accessories-section-header text-center">
			<span class="accessories-eyebrow"><?php echo esc_html( $section['eyebrow'] ); ?></span>
			<h2 class="accessories-title"><?php echo esc_html( $section['title'] ); ?></h2>
			<p class="accessories-desc"><?php echo esc_html( $section['description'] ); ?></p>
		</div>

		<div class="accessories-compat-table-card">
			<div class="table-responsive-wrapper">
				<table class="accessories-compat-table">
					<thead>
						<tr>
							<th class="col-filament"><?php esc_html_e( 'Filament Material', 'woodmart-child' ); ?></th>
							<th class="col-nozzle col-02">
								<span class="th-size">0.2 mm</span>
								<span class="th-sub"><?php esc_html_e( 'Stainless / Hardened', 'woodmart-child' ); ?></span>
							</th>
							<th class="col-nozzle col-04">
								<span class="th-size">0.4 mm</span>
								<span class="th-sub"><?php esc_html_e( 'Hardened Steel', 'woodmart-child' ); ?></span>
							</th>
							<th class="col-nozzle col-06">
								<span class="th-size">0.6 mm</span>
								<span class="th-sub"><?php esc_html_e( 'Hardened Steel', 'woodmart-child' ); ?></span>
							</th>
							<th class="col-nozzle col-08">
								<span class="th-size">0.8 mm</span>
								<span class="th-sub"><?php esc_html_e( 'Hardened Steel', 'woodmart-child' ); ?></span>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $grouped as $category_name => $cat_rows ) : ?>
							<tr class="compat-category-row">
								<td colspan="5">
									<div class="category-header-pill">
										<span class="pill-dot"></span>
										<strong class="pill-name"><?php echo esc_html( $category_name ); ?></strong>
									</div>
								</td>
							</tr>
							<?php foreach ( $cat_rows as $row ) : ?>
								<tr class="compat-item-row">
									<td class="col-filament-cell">
										<strong class="filament-name"><?php echo esc_html( $row['filament'] ); ?></strong>
										<?php if ( ! empty( $row['notes'] ) ) : ?>
											<span class="filament-note"><?php echo esc_html( $row['notes'] ); ?></span>
										<?php endif; ?>
									</td>
									<td class="col-status-cell col-02"><?php echo render_status_badge( $row['nozzle_02'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
									<td class="col-status-cell col-04"><?php echo render_status_badge( $row['nozzle_04'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
									<td class="col-status-cell col-06"><?php echo render_status_badge( $row['nozzle_06'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
									<td class="col-status-cell col-08"><?php echo render_status_badge( $row['nozzle_08'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<!-- Bottom Advisory Legend & Note -->
			<div class="compat-table-footer">
				<div class="compat-legend">
					<span class="legend-badge"><span class="compat-status-badge badge-yes">✓</span> <?php esc_html_e( 'Recommended for continuous printing', 'woodmart-child' ); ?></span>
					<span class="legend-badge"><span class="compat-status-badge badge-hardened">▲</span> <?php esc_html_e( 'Hardened Steel nozzle strictly required', 'woodmart-child' ); ?></span>
					<span class="legend-badge"><span class="compat-status-badge badge-no">✕</span> <?php esc_html_e( 'Not recommended (high clog risk)', 'woodmart-child' ); ?></span>
				</div>
				<?php if ( ! empty( $section['note'] ) ) : ?>
					<p class="compat-footer-notice"><?php echo esc_html( $section['note'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
