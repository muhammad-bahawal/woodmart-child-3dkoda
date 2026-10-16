<?php
/**
 * Template Part: What's in the Box (Matrix Comparison)
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_laser_crafting_section_enabled( 'box_contents', $product_id ) ) {
	return;
}

$section_data = woodmart_child_get_laser_crafting_section_data( 'box_contents', $product_id );
$eyebrow      = ! empty( $section_data['eyebrow'] ) ? $section_data['eyebrow'] : __( 'Package Comparison Matrix', 'woodmart-child' );
$title        = ! empty( $section_data['title'] ) ? $section_data['title'] : __( "What's in the Box", 'woodmart-child' );
$subtitle     = ! empty( $section_data['description'] ) ? $section_data['description'] : __( 'Choose the configuration that matches your creative workflow — from standalone 3D printing to the full multi-tool crafting ecosystem.', 'woodmart-child' );
$items        = ! empty( $section_data['items'] ) && is_array( $section_data['items'] ) ? $section_data['items'] : array();

// Package headers mapping
$settings = woodmart_child_get_laser_crafting_builder_settings( $product_id );
$packages = ! empty( $settings['general']['packages'] ) ? $settings['general']['packages'] : array();
?>

<section class="lc-box-section" id="lc-box-contents">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-section-header text-center">
			<span class="lc-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
		</div>

		<!-- Package Comparison Matrix Cards / Table -->
		<div class="lc-matrix-wrapper">
			<div class="lc-matrix-table-responsive">
				<table class="lc-matrix-table">
					<thead>
						<tr>
							<th class="lc-th-item">
								<span class="lc-th-title"><?php esc_html_e( 'Included Components', 'woodmart-child' ); ?></span>
								<span class="lc-th-sub"><?php esc_html_e( 'Genuine Bambu Lab items & accessories', 'woodmart-child' ); ?></span>
							</th>

							<!-- Packages Column Headers -->
							<?php 
							$col_keys = array( 'standalone', 'combo', 'full_combo' );
							$fallback_titles = array(
								'standalone' => 'A2L',
								'combo'      => 'A2L Combo',
								'full_combo' => 'A2L Full Combo',
							);
							$fallback_prices = array(
								'standalone' => '€469.00',
								'combo'      => '€569.00',
								'full_combo' => '€629.00',
							);
							foreach ( $col_keys as $c_idx => $ckey ) : 
								$pkg_info  = ! empty( $packages[ $ckey ] ) ? $packages[ $ckey ] : array();
								$pkg_title = ! empty( $pkg_info['title'] ) ? $pkg_info['title'] : $fallback_titles[ $ckey ];
								$pkg_badge = ! empty( $pkg_info['badge'] ) ? $pkg_info['badge'] : '';
								$pkg_price = ! empty( $pkg_info['price'] ) ? $pkg_info['price'] : $fallback_prices[ $ckey ];
							?>
								<th class="lc-th-package <?php echo ( $c_idx === 2 ) ? 'is-highlighted' : ''; ?>">
									<?php if ( ! empty( $pkg_badge ) ) : ?>
										<span class="lc-th-badge"><?php echo esc_html( $pkg_badge ); ?></span>
									<?php endif; ?>
									<span class="lc-pkg-col-title"><?php echo esc_html( $pkg_title ); ?></span>
									<span class="lc-pkg-col-price"><?php echo esc_html( $pkg_price ); ?></span>
									<button type="button" class="lc-matrix-select-btn" data-target-pkg="<?php echo esc_attr( $ckey ); ?>">
										<?php esc_html_e( 'Select Package', 'woodmart-child' ); ?>
									</button>
								</th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $items as $row ) : 
							$item_name = ! empty( $row['name'] ) ? $row['name'] : '';
							$in_std    = ! empty( $row['standalone'] );
							$in_combo  = ! empty( $row['combo'] );
							$in_full   = ! empty( $row['full_combo'] );
						?>
							<tr>
								<td class="lc-td-name">
									<strong><?php echo esc_html( $item_name ); ?></strong>
								</td>

								<!-- Standalone Check -->
								<td class="lc-td-val">
									<?php if ( $in_std ) : ?>
										<span class="lc-icon-check" aria-label="<?php esc_attr_e( 'Included', 'woodmart-child' ); ?>">
											<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
										</span>
									<?php else : ?>
										<span class="lc-icon-dash" aria-label="<?php esc_attr_e( 'Not included', 'woodmart-child' ); ?>">—</span>
									<?php endif; ?>
								</td>

								<!-- Combo Check -->
								<td class="lc-td-val">
									<?php if ( $in_combo ) : ?>
										<span class="lc-icon-check" aria-label="<?php esc_attr_e( 'Included', 'woodmart-child' ); ?>">
											<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
										</span>
									<?php else : ?>
										<span class="lc-icon-dash" aria-label="<?php esc_attr_e( 'Not included', 'woodmart-child' ); ?>">—</span>
									<?php endif; ?>
								</td>

								<!-- Full Combo Check -->
								<td class="lc-td-val is-highlighted">
									<?php if ( $in_full ) : ?>
										<span class="lc-icon-check" aria-label="<?php esc_attr_e( 'Included', 'woodmart-child' ); ?>">
											<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
										</span>
									<?php else : ?>
										<span class="lc-icon-dash" aria-label="<?php esc_attr_e( 'Not included', 'woodmart-child' ); ?>">—</span>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</section>
