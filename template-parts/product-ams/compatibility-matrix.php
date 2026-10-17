<?php
/**
 * Template Part: AMS Printer Compatibility Matrix & Lineup Showcase
 *
 * Section: Compatible With All Bambu Lab Printers (Exact match to Image 1)
 * - Centered title: "Compatible With All Bambu Lab Printers"
 * - Subtitle: "The AMS 2 Pro will be compatible with all Bambu Lab products."
 * - Full-width high-impact Bambu Lab printer lineup showcase stage
 * - Dynamic compatibility matrix for Bambu Lab 3D printers:
 *   - X1 Series (X1-Carbon & X1E)
 *   - P1 Series (P1S & P1P)
 *   - A1 Series (A1 & A1 Mini)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'compatibility_matrix', $product_id );

$eyebrow      = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : '';
$title        = ! empty( $data['title'] ) ? $data['title'] : __( 'Compatible With All Bambu Lab Printers', 'woodmart-child' );
$subtitle     = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( 'The AMS 2 Pro will be compatible with all Bambu Lab products.', 'woodmart-child' );
$lineup_image = ! empty( $data['lineup_image'] ) ? $data['lineup_image'] : get_stylesheet_directory_uri() . '/assets/images/bambu-printer-lineup.png';
$note         = ! empty( $data['note'] ) ? $data['note'] : __( 'Note: Daisy-chaining 2 to 4 AMS units requires the Bambu Lab AMS Hub and additional bus cables.', 'woodmart-child' );
$printers     = ! empty( $data['printers'] ) ? $data['printers'] : array();
?>

<section class="ams-compatibility-section" id="ams-compatibility">
	<div class="ams-compatibility-container container">
		<div class="ams-section-head text-center is-dark">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="ams-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="ams-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Printer Lineup Showcase (Image 1) -->
		<div class="ams-lineup-showcase">
			<div class="ams-lineup-stage">
				<div class="ams-lineup-glow" aria-hidden="true"></div>
				<img src="<?php echo esc_url( $lineup_image ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="ams-lineup-img" loading="lazy">
			</div>
		</div>

		<!-- Compatibility Matrix Table / Card View (Dark Theme) -->
		<?php if ( ! empty( $printers ) ) : ?>
			<div class="ams-compat-card">
				<div class="ams-compat-table-wrap">
					<table class="ams-compat-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Printer Series', 'woodmart-child' ); ?></th>
								<th><?php esc_html_e( 'Compatibility Status', 'woodmart-child' ); ?></th>
								<th><?php esc_html_e( 'Multi-AMS Support', 'woodmart-child' ); ?></th>
								<th><?php esc_html_e( 'Buffer / Hub Required', 'woodmart-child' ); ?></th>
								<th><?php esc_html_e( 'Integration Details', 'woodmart-child' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $printers as $p ) : ?>
								<tr>
									<td class="col-model">
										<strong><?php echo esc_html( $p['model'] ?? '' ); ?></strong>
									</td>
									<td class="col-status">
										<span class="status-badge <?php echo ( false !== stripos( $p['status_badge'] ?? '', 'native' ) ) ? 'is-native' : 'is-compat'; ?>">
											● <?php echo esc_html( $p['status'] ?? '' ); ?>
										</span>
									</td>
									<td class="col-multi">
										<span class="multi-val"><?php echo esc_html( $p['multi_ams'] ?? '' ); ?></span>
									</td>
									<td class="col-buffer">
										<?php echo esc_html( $p['buffer_req'] ?? '' ); ?>
									</td>
									<td class="col-notes">
										<?php echo esc_html( $p['notes'] ?? '' ); ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<!-- Mobile Card View (renders on screens < 768px) -->
				<div class="ams-compat-mobile-cards">
					<?php foreach ( $printers as $p ) : ?>
						<div class="compat-mobile-item">
							<div class="compat-mobile-head">
								<h3 class="model-name"><?php echo esc_html( $p['model'] ?? '' ); ?></h3>
								<span class="status-badge <?php echo ( false !== stripos( $p['status_badge'] ?? '', 'native' ) ) ? 'is-native' : 'is-compat'; ?>">
									● <?php echo esc_html( $p['status'] ?? '' ); ?>
								</span>
							</div>
							<div class="compat-mobile-details">
								<div class="detail-row">
									<span class="label"><?php esc_html_e( 'Multi-AMS:', 'woodmart-child' ); ?></span>
									<span class="val"><?php echo esc_html( $p['multi_ams'] ?? '' ); ?></span>
								</div>
								<div class="detail-row">
									<span class="label"><?php esc_html_e( 'Buffer/Hub:', 'woodmart-child' ); ?></span>
									<span class="val"><?php echo esc_html( $p['buffer_req'] ?? '' ); ?></span>
								</div>
								<div class="detail-row">
									<span class="label"><?php esc_html_e( 'Notes:', 'woodmart-child' ); ?></span>
									<span class="val"><?php echo esc_html( $p['notes'] ?? '' ); ?></span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( ! empty( $note ) ) : ?>
					<div class="ams-compat-footer-note">
						<span class="info-icon" aria-hidden="true">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2">
								<circle cx="12" cy="12" r="10"></circle>
								<line x1="12" y1="16" x2="12" y2="12"></line>
								<line x1="12" y1="8" x2="12.01" y2="8"></line>
							</svg>
						</span>
						<span><?php echo esc_html( $note ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
