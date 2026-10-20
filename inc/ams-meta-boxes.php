<?php
/**
 * Native Custom Meta Box: Product Page Builder - AMS
 * Automatic Material System (Filament Drying & Multi-Color Feeding Units)
 *
 * Dedicated tabbed admin panel for the AMS product landing page builder.
 * 100% synchronized with the frontend layout: every section is fully editable.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Product Page Builder Meta Box (AMS)
 */
function woodmart_child_register_ams_builder_meta_box() {
	add_meta_box(
		'woodmart_child_ams_builder',
		__( 'Product Page Builder - AMS', 'woodmart-child' ),
		'woodmart_child_render_ams_builder_meta_box',
		'product',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'woodmart_child_register_ams_builder_meta_box' );

/**
 * Render Product Page Builder Meta Box (AMS)
 *
 * @param WP_Post $post Current post object.
 */
function woodmart_child_render_ams_builder_meta_box( $post ) {
	wp_nonce_field( 'woodmart_child_save_ams_builder_meta', 'woodmart_child_ams_builder_nonce' );

	$settings        = woodmart_child_get_ams_builder_settings( $post->ID );
	$enabled_landing = get_post_meta( $post->ID, '_woodmart_child_ams_landing_enabled', true );
	if ( '' === $enabled_landing ) {
		$enabled_landing = '0';
	}
	?>
	<div class="wc-builder-wrap">
		<!-- Master Switch Header -->
		<div class="wc-builder-master-bar">
			<label class="wc-builder-master-toggle">
				<input type="checkbox" name="ams_builder[general][enable_landing]" value="1" <?php checked( $enabled_landing, '1' ); ?>>
				<span class="wc-toggle-slider"></span>
				<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable AMS Landing Page', 'woodmart-child' ); ?></strong> (<?php esc_html_e( 'Replaces default WooCommerce layout with custom AMS canvas while preserving global Woodmart header and footer', 'woodmart-child' ); ?>)</span>
			</label>
		</div>

		<div class="wc-builder-body">
			<!-- Tab Navigation -->
			<nav class="wc-builder-tabs-nav" role="tablist">
				<button type="button" class="wc-tab-btn active" data-tab="tab-ams-general"><span class="dashicons dashicons-admin-settings"></span> <?php esc_html_e( 'Hero & General', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-ams-overview"><span class="dashicons dashicons-format-image"></span> <?php esc_html_e( 'Overview & Banner', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-ams-drying"><span class="dashicons dashicons-shield"></span> <?php esc_html_e( 'Drying & Feeding', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-ams-efficiency"><span class="dashicons dashicons-dashboard"></span> <?php esc_html_e( 'Speed & Metrics', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-ams-design"><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Design Details', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-ams-compatibility"><span class="dashicons dashicons-grid-view"></span> <?php esc_html_e( 'Compatibility Matrix', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-ams-box"><span class="dashicons dashicons-archive"></span> <?php esc_html_e( "What's in the Box", 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-ams-specs"><span class="dashicons dashicons-clipboard"></span> <?php esc_html_e( 'Technical Specs', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-ams-faq"><span class="dashicons dashicons-format-chat"></span> <?php esc_html_e( 'FAQ & Sticky Bar', 'woodmart-child' ); ?></button>
			</nav>

			<!-- Tab Panels -->
			<div class="wc-builder-tabs-content">

				<!-- 1. HERO & GENERAL SETTINGS -->
				<section class="wc-tab-panel active" id="tab-ams-general">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Hero & General Settings', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Configure brand title, stock labels, warranty badges, service guarantees, and bundle add-on cards.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Hero Eyebrow Text', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][eyebrow]" value="<?php echo esc_attr( $settings['general']['eyebrow'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Brand Name', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][brand_name]" value="<?php echo esc_attr( $settings['general']['brand_name'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Reseller / Authorized Badge', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][badge_text]" value="<?php echo esc_attr( $settings['general']['badge_text'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Rating & Reviews Tagline', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][rating_text]" value="<?php echo esc_attr( $settings['general']['rating_text'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-3">
						<div class="wc-field">
							<label><?php esc_html_e( 'Stock Status Heading', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][stock_text]" value="<?php echo esc_attr( $settings['general']['stock_text'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Stock Dispatch Note', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][stock_note]" value="<?php echo esc_attr( $settings['general']['stock_note'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Warranty Badge Text', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][warranty_text]" value="<?php echo esc_attr( $settings['general']['warranty_text'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'VAT Notice', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][vat_note]" value="<?php echo esc_attr( $settings['general']['vat_note'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Ex. VAT Link Label', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[general][ex_vat_text]" value="<?php echo esc_attr( $settings['general']['ex_vat_text'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Team / Bulk Quote Link Text', 'woodmart-child' ); ?></label>
						<input type="text" name="ams_builder[general][team_quote_text]" value="<?php echo esc_attr( $settings['general']['team_quote_text'] ?? '' ); ?>" class="widefat">
					</div>

					<!-- Trust Guarantees -->
					<h4 class="wc-subhead"><?php esc_html_e( 'Service Guarantees (Hero 3-Grid Strip)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-guarantees-repeater">
						<?php
						$guarantees = ! empty( $settings['general']['guarantees'] ) ? $settings['general']['guarantees'] : array();
						foreach ( $guarantees as $idx => $g ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Icon (truck, shield, user, award, refresh)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[general][guarantees][<?php echo esc_attr( $idx ); ?>][icon]" value="<?php echo esc_attr( $g['icon'] ?? 'shield' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Guarantee Title', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[general][guarantees][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $g['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[general][guarantees][<?php echo esc_attr( $idx ); ?>][subtitle]" value="<?php echo esc_attr( $g['subtitle'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-guarantees-repeater" data-template="tmpl-ams-guarantee-row"><?php esc_html_e( '+ Add Guarantee', 'woodmart-child' ); ?></button>

					<!-- Add-on Bundles (Upsell Cards) -->
					<h4 class="wc-subhead"><?php esc_html_e( 'Essential Add-on Bundle Cards', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-addons-repeater">
						<?php
						$addons = ! empty( $settings['general']['bundle_addons'] ) ? $settings['general']['bundle_addons'] : array();
						foreach ( $addons as $idx => $addon ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-4">
									<div class="wc-field">
										<label><?php esc_html_e( 'Add-on Title', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $addon['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Badge (e.g. 16 Colors)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][badge]" value="<?php echo esc_attr( $addon['badge'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Price (€)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][price]" value="<?php echo esc_attr( $addon['price'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Regular Price (€)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][regular_price]" value="<?php echo esc_attr( $addon['regular_price'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<div class="wc-field-row grid-2" style="margin-top: 8px;">
									<div class="wc-field">
										<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][description]" value="<?php echo esc_attr( $addon['description'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Image URL', 'woodmart-child' ); ?></label>
										<div class="wc-image-picker">
											<input type="hidden" name="ams_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $addon['image'] ?? '' ); ?>" class="wc-image-url">
											<div class="wc-image-preview"><?php if ( ! empty( $addon['image'] ) ) : ?><img src="<?php echo esc_url( $addon['image'] ); ?>"><?php endif; ?></div>
											<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
											<button type="button" class="button wc-btn-remove-image <?php echo empty( $addon['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
										</div>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-addons-repeater" data-template="tmpl-ams-addon-row"><?php esc_html_e( '+ Add Add-on Card', 'woodmart-child' ); ?></button>
				</section>

				<!-- 2. OVERVIEW & HIGH-IMPACT HERO BANNER -->
				<section class="wc-tab-panel" id="tab-ams-overview">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Overview & High-Impact Hero Banner', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 2 on frontend: Dark aesthetic banner, main feature hero image, intro video popup, and high-impact metric cards.', 'woodmart-child' ); ?></p>
					</div>

					<?php $ov = ! empty( $settings['overview'] ) ? $settings['overview'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow Text', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[overview][eyebrow]" value="<?php echo esc_attr( $ov['eyebrow'] ?? 'Bambu Lab AMS 2 Pro' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Main Headline', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[overview][title]" value="<?php echo esc_attr( $ov['title'] ?? 'AMS, Evolved.' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Subtitle Description', 'woodmart-child' ); ?></label>
						<textarea name="ams_builder[overview][subtitle]" rows="2" class="widefat"><?php echo esc_textarea( $ov['subtitle'] ?? '' ); ?></textarea>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Video URL (YouTube or MP4 - Opens in in-page popup modal)', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[overview][video_url]" value="<?php echo esc_attr( $ov['video_url'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Watch Video Button Text', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[overview][video_btn_text]" value="<?php echo esc_attr( $ov['video_btn_text'] ?? 'Watch AMS in Action' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field" style="margin-top:16px;">
						<label><?php esc_html_e( 'Overview Banner Image (Fallback uses product featured image)', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="ams_builder[overview][banner_image]" value="<?php echo esc_attr( $ov['banner_image'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $ov['banner_image'] ) ) : ?><img src="<?php echo esc_url( $ov['banner_image'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $ov['banner_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'High-Impact Metric Cards (4 Cards)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-metrics-repeater">
						<?php
						$metrics = ! empty( $ov['metrics'] ) ? $ov['metrics'] : array();
						foreach ( $metrics as $idx => $m ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Metric Value (optional)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[overview][metrics][<?php echo esc_attr( $idx ); ?>][value]" value="<?php echo esc_attr( $m['value'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Metric Label / Title', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[overview][metrics][<?php echo esc_attr( $idx ); ?>][label]" value="<?php echo esc_attr( $m['label'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Description / Note', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[overview][metrics][<?php echo esc_attr( $idx ); ?>][desc]" value="<?php echo esc_attr( $m['desc'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-metrics-repeater" data-template="tmpl-ams-metric-row"><?php esc_html_e( '+ Add Metric Card', 'woodmart-child' ); ?></button>
				</section>

				<!-- 3. DRYING & INTELLIGENT FEEDING -->
				<section class="wc-tab-panel" id="tab-ams-drying">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Drying & Intelligent Feeding', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 3 on frontend: Feature cards for active heating/drying, RFID auto-recognition, airtight sealing, and filament buffer mechanism.', 'woodmart-child' ); ?></p>
					</div>

					<?php $df = ! empty( $settings['drying_feeding'] ) ? $settings['drying_feeding'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[drying_feeding][eyebrow]" value="<?php echo esc_attr( $df['eyebrow'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[drying_feeding][title]" value="<?php echo esc_attr( $df['title'] ?? 'Dry Filament Quickly and Intelligently' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Subtitle Description', 'woodmart-child' ); ?></label>
						<textarea name="ams_builder[drying_feeding][subtitle]" rows="2" class="widefat"><?php echo esc_textarea( $df['subtitle'] ?? '' ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Feature Cards Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-drying-repeater">
						<?php
						$df_cards = ! empty( $df['cards'] ) ? $df['cards'] : array();
						foreach ( $df_cards as $idx => $card ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Tag / Category', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[drying_feeding][cards][<?php echo esc_attr( $idx ); ?>][tag]" value="<?php echo esc_attr( $card['tag'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[drying_feeding][cards][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $card['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Badge Pill (e.g. < 20% RH Dry Chamber)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[drying_feeding][cards][<?php echo esc_attr( $idx ); ?>][badge]" value="<?php echo esc_attr( $card['badge'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<div class="wc-field" style="margin-top: 8px;">
									<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
									<textarea name="ams_builder[drying_feeding][cards][<?php echo esc_attr( $idx ); ?>][desc]" rows="2" class="widefat"><?php echo esc_textarea( $card['desc'] ?? '' ); ?></textarea>
								</div>
								<div class="wc-field" style="margin-top: 8px;">
									<label><?php esc_html_e( 'Card Image Upload (Fallback renders custom visual diagram)', 'woodmart-child' ); ?></label>
									<div class="wc-image-picker">
										<input type="hidden" name="ams_builder[drying_feeding][cards][<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $card['image'] ?? '' ); ?>" class="wc-image-url">
										<div class="wc-image-preview"><?php if ( ! empty( $card['image'] ) ) : ?><img src="<?php echo esc_url( $card['image'] ); ?>"><?php endif; ?></div>
										<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
										<button type="button" class="button wc-btn-remove-image <?php echo empty( $card['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-drying-repeater" data-template="tmpl-ams-drying-row"><?php esc_html_e( '+ Add Feature Card', 'woodmart-child' ); ?></button>
				</section>

				<!-- 4. SPEED & EFFICIENCY METRICS (IMAGE 3) -->
				<section class="wc-tab-panel" id="tab-ams-efficiency">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Quality Comparison & Speed Metrics', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 4 on frontend (Image 3): Honeycomb print comparison (Dry vs Moist) + Speed metrics (+60%, -10min) + Showcase Car Banner.', 'woodmart-child' ); ?></p>
					</div>

					<?php $eff = ! empty( $settings['efficiency_metrics'] ) ? $settings['efficiency_metrics'] : array(); ?>

					<!-- Part 1: Honeycomb Print Quality Comparison -->
					<h4 class="wc-subhead"><?php esc_html_e( '1. Honeycomb Print Quality Comparison (Image 3 Top)', 'woodmart-child' ); ?></h4>
					<div class="wc-field">
						<label><?php esc_html_e( 'Comparison Caption (Centered below images)', 'woodmart-child' ); ?></label>
						<input type="text" name="ams_builder[efficiency_metrics][comparison_caption]" value="<?php echo esc_attr( $eff['comparison_caption'] ?? 'Bambu PETG Basic' ); ?>" class="widefat">
					</div>

					<div class="wc-field-row grid-2" style="margin-top: 12px;">
						<div class="wc-field">
							<label><?php esc_html_e( 'Dry Side Badge Label', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[efficiency_metrics][dry_label]" value="<?php echo esc_attr( $eff['dry_label'] ?? 'Dry' ); ?>" class="widefat">
							<div class="wc-image-picker" style="margin-top: 8px;">
								<input type="hidden" name="ams_builder[efficiency_metrics][dry_image]" value="<?php echo esc_attr( $eff['dry_image'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $eff['dry_image'] ) ) : ?><img src="<?php echo esc_url( $eff['dry_image'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Upload Dry Print Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $eff['dry_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Moist Side Badge Label', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[efficiency_metrics][moist_label]" value="<?php echo esc_attr( $eff['moist_label'] ?? 'Moist' ); ?>" class="widefat">
							<div class="wc-image-picker" style="margin-top: 8px;">
								<input type="hidden" name="ams_builder[efficiency_metrics][moist_image]" value="<?php echo esc_attr( $eff['moist_image'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $eff['moist_image'] ) ) : ?><img src="<?php echo esc_url( $eff['moist_image'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Upload Moist Print Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $eff['moist_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
					</div>

					<div class="wc-field" style="margin-top: 12px;">
						<label><?php esc_html_e( 'Or Single Combined Comparison Image (Optional - overrides separate Dry/Moist images)', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="ams_builder[efficiency_metrics][comparison_image]" value="<?php echo esc_attr( $eff['comparison_image'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $eff['comparison_image'] ) ) : ?><img src="<?php echo esc_url( $eff['comparison_image'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Combined Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $eff['comparison_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>

					<!-- Part 2: Speed Up! Faster Multi-material Printing! -->
					<h4 class="wc-subhead" style="margin-top: 24px;"><?php esc_html_e( '2. Speed Up & Multi-Material Printing (Image 3 Bottom)', 'woodmart-child' ); ?></h4>
					<div class="wc-field">
						<label><?php esc_html_e( 'Section Headline', 'woodmart-child' ); ?></label>
						<input type="text" name="ams_builder[efficiency_metrics][title]" value="<?php echo esc_attr( $eff['title'] ?? 'Speed Up! Faster Multi-material Printing!' ); ?>" class="widefat">
					</div>

					<!-- Metric Cards -->
					<div class="wc-field-row grid-2" style="margin-top: 12px;">
						<!-- Card 1 -->
						<div class="wc-field">
							<label><?php esc_html_e( 'Metric 1 Highlight (e.g. +60%)', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[efficiency_metrics][card_speed][metric]" value="<?php echo esc_attr( $eff['card_speed']['metric'] ?? '+60%' ); ?>" class="widefat">
							<label style="margin-top: 8px;"><?php esc_html_e( 'Metric 1 Description', 'woodmart-child' ); ?></label>
							<textarea name="ams_builder[efficiency_metrics][card_speed][desc]" rows="3" class="widefat"><?php echo esc_textarea( $eff['card_speed']['desc'] ?? 'The powerful Bambu permanent magnet synchronous servo motor accelerates filament feeding by 60% for enhanced efficiency.' ); ?></textarea>
						</div>

						<!-- Card 2 -->
						<div class="wc-field">
							<label><?php esc_html_e( 'Metric 2 Highlight (e.g. -10min)', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[efficiency_metrics][card_waste][metric]" value="<?php echo esc_attr( $eff['card_waste']['metric'] ?? '-10min' ); ?>" class="widefat">
							<label style="margin-top: 8px;"><?php esc_html_e( 'Metric 2 Description', 'woodmart-child' ); ?></label>
							<textarea name="ams_builder[efficiency_metrics][card_waste][desc]" rows="3" class="widefat"><?php echo esc_textarea( $eff['card_waste']['desc'] ?? 'Saves an average of 10 minutes per 100 filament changes.' ); ?></textarea>
						</div>
					</div>

					<!-- Showcase Car Banner -->
					<h4 class="wc-subhead" style="margin-top: 20px;"><?php esc_html_e( '3. Full-Width Showcase Car Banner', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Banner Overlay Title', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[efficiency_metrics][banner_title]" value="<?php echo esc_attr( $eff['banner_title'] ?? 'Faster multi-color printing' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Banner Attribution / Credit Text', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[efficiency_metrics][banner_credit]" value="<?php echo esc_attr( $eff['banner_credit'] ?? 'Xiaomi SU7 Ultra Prototype by @大匠' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field" style="margin-top: 8px;">
						<label><?php esc_html_e( 'Showcase Banner Image Upload', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="ams_builder[efficiency_metrics][banner_image]" value="<?php echo esc_attr( $eff['banner_image'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $eff['banner_image'] ) ) : ?><img src="<?php echo esc_url( $eff['banner_image'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $eff['banner_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>
				</section>

				<!-- 5. EVOLVED, POLISHED DESIGN DETAILS (IMAGE 4) -->
				<section class="wc-tab-panel" id="tab-ams-design">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Evolved, Polished Design Details', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 5 on frontend (Image 4): Zig-zag feature cards for Tool-Free Filament Tubes Access, Ceramic Inlet, etc.', 'woodmart-child' ); ?></p>
					</div>

					<?php $dd = ! empty( $settings['design_details'] ) ? $settings['design_details'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[design_details][eyebrow]" value="<?php echo esc_attr( $dd['eyebrow'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[design_details][title]" value="<?php echo esc_attr( $dd['title'] ?? 'Evolved, Polished Design Details' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Subtitle Description', 'woodmart-child' ); ?></label>
						<textarea name="ams_builder[design_details][subtitle]" rows="2" class="widefat"><?php echo esc_textarea( $dd['subtitle'] ?? '' ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Design Detail Cards Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-design-repeater">
						<?php
						$dd_cards = ! empty( $dd['cards'] ) ? $dd['cards'] : array();
						foreach ( $dd_cards as $idx => $card ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-2">
									<div class="wc-field">
										<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[design_details][cards][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $card['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Image Upload', 'woodmart-child' ); ?></label>
										<div class="wc-image-picker">
											<input type="hidden" name="ams_builder[design_details][cards][<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $card['image'] ?? '' ); ?>" class="wc-image-url">
											<div class="wc-image-preview"><?php if ( ! empty( $card['image'] ) ) : ?><img src="<?php echo esc_url( $card['image'] ); ?>"><?php endif; ?></div>
											<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
											<button type="button" class="button wc-btn-remove-image <?php echo empty( $card['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
										</div>
									</div>
								</div>
								<div class="wc-field" style="margin-top: 8px;">
									<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
									<textarea name="ams_builder[design_details][cards][<?php echo esc_attr( $idx ); ?>][desc]" rows="2" class="widefat"><?php echo esc_textarea( $card['desc'] ?? '' ); ?></textarea>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-design-repeater" data-template="tmpl-ams-design-row"><?php esc_html_e( '+ Add Design Card', 'woodmart-child' ); ?></button>
				</section>

				<!-- 6. PRINTER COMPATIBILITY MATRIX -->
				<section class="wc-tab-panel" id="tab-ams-compatibility">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Printer Compatibility Matrix', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 6 on frontend: Dynamic repeater matrix for printer models (X1, P1, A1 Series) with Hub/Buffer requirements.', 'woodmart-child' ); ?></p>
					</div>

					<?php $cm = ! empty( $settings['compatibility_matrix'] ) ? $settings['compatibility_matrix'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[compatibility_matrix][eyebrow]" value="<?php echo esc_attr( $cm['eyebrow'] ?? 'Ecosystem Integration' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[compatibility_matrix][title]" value="<?php echo esc_attr( $cm['title'] ?? 'Printer Compatibility Matrix' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[compatibility_matrix][subtitle]" value="<?php echo esc_attr( $cm['subtitle'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Footer Note / Requirement Tip', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[compatibility_matrix][note]" value="<?php echo esc_attr( $cm['note'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field" style="margin-top: 8px; margin-bottom: 16px;">
						<label><?php esc_html_e( 'Printer Lineup Showcase Image (Hero Image for Compatible Printers)', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="ams_builder[compatibility_matrix][lineup_image]" value="<?php echo esc_attr( $cm['lineup_image'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $cm['lineup_image'] ) ) : ?><img src="<?php echo esc_url( $cm['lineup_image'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $cm['lineup_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
						<p class="description"><?php esc_html_e( 'Upload the wide lineup showcase image showing all Bambu Lab printers. If empty, default theme image is displayed.', 'woodmart-child' ); ?></p>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Printer Models Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-printers-repeater">
						<?php
						$printers = ! empty( $cm['printers'] ) ? $cm['printers'] : array();
						foreach ( $printers as $idx => $p ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Printer Model', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[compatibility_matrix][printers][<?php echo esc_attr( $idx ); ?>][model]" value="<?php echo esc_attr( $p['model'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Status (e.g. Full Plug & Play)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[compatibility_matrix][printers][<?php echo esc_attr( $idx ); ?>][status]" value="<?php echo esc_attr( $p['status'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Status Badge (e.g. Native Ready)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[compatibility_matrix][printers][<?php echo esc_attr( $idx ); ?>][status_badge]" value="<?php echo esc_attr( $p['status_badge'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<div class="wc-repeater-fields grid-3" style="margin-top: 8px;">
									<div class="wc-field">
										<label><?php esc_html_e( 'Multi-AMS Support (e.g. Up to 4 AMS / 16 Colors)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[compatibility_matrix][printers][<?php echo esc_attr( $idx ); ?>][multi_ams]" value="<?php echo esc_attr( $p['multi_ams'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Buffer / Hub Requirement', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[compatibility_matrix][printers][<?php echo esc_attr( $idx ); ?>][buffer_req]" value="<?php echo esc_attr( $p['buffer_req'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Notes / Description', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[compatibility_matrix][printers][<?php echo esc_attr( $idx ); ?>][notes]" value="<?php echo esc_attr( $p['notes'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-printers-repeater" data-template="tmpl-ams-printer-row"><?php esc_html_e( '+ Add Printer Model', 'woodmart-child' ); ?></button>
				</section>

				<!-- 7. WHAT'S IN THE BOX -->
				<section class="wc-tab-panel" id="tab-ams-box">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( "What's in the Box", 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 7 on frontend: Dynamic repeater grid of included components (AMS Unit, PTFE Tubes, Bus Cables, Spool Hub, Desiccant).', 'woodmart-child' ); ?></p>
					</div>

					<?php $bx = ! empty( $settings['box_contents'] ) ? $settings['box_contents'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[box_contents][eyebrow]" value="<?php echo esc_attr( $bx['eyebrow'] ?? 'Unboxing Experience' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[box_contents][title]" value="<?php echo esc_attr( $bx['title'] ?? "What's in the Box" ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Subtitle', 'woodmart-child' ); ?></label>
						<input type="text" name="ams_builder[box_contents][subtitle]" value="<?php echo esc_attr( $bx['subtitle'] ?? '' ); ?>" class="widefat">
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Included Components Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-box-repeater">
						<?php
						$box_items = ! empty( $bx['items'] ) ? $bx['items'] : array();
						foreach ( $box_items as $idx => $bi ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Component Name', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[box_contents][items][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $bi['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Description / Quantity', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[box_contents][items][<?php echo esc_attr( $idx ); ?>][desc]" value="<?php echo esc_attr( $bi['desc'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Icon (box, disc, buffer, cable, tube, droplet, tool, book)', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[box_contents][items][<?php echo esc_attr( $idx ); ?>][icon]" value="<?php echo esc_attr( $bi['icon'] ?? 'box' ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-box-repeater" data-template="tmpl-ams-box-row"><?php esc_html_e( '+ Add Component', 'woodmart-child' ); ?></button>
				</section>

				<!-- 8. TECHNICAL SPECIFICATIONS -->
				<section class="wc-tab-panel" id="tab-ams-specs">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Technical Specifications', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 8 on frontend: Dynamic 2-column repeater (Category, Spec Label, Spec Value).', 'woodmart-child' ); ?></p>
					</div>

					<?php $sp = ! empty( $settings['specifications'] ) ? $settings['specifications'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[specifications][eyebrow]" value="<?php echo esc_attr( $sp['eyebrow'] ?? 'Engineering Data' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[specifications][title]" value="<?php echo esc_attr( $sp['title'] ?? 'Technical Specifications' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Subtitle', 'woodmart-child' ); ?></label>
						<input type="text" name="ams_builder[specifications][subtitle]" value="<?php echo esc_attr( $sp['subtitle'] ?? '' ); ?>" class="widefat">
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Specifications Matrix Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-specs-repeater">
						<?php
						$spec_items = ! empty( $sp['items'] ) ? $sp['items'] : array();
						foreach ( $spec_items as $idx => $si ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Category', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[specifications][items][<?php echo esc_attr( $idx ); ?>][category]" value="<?php echo esc_attr( $si['category'] ?? 'General' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Spec Label', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[specifications][items][<?php echo esc_attr( $idx ); ?>][label]" value="<?php echo esc_attr( $si['label'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Spec Value', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[specifications][items][<?php echo esc_attr( $idx ); ?>][value]" value="<?php echo esc_attr( $si['value'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-specs-repeater" data-template="tmpl-ams-spec-row"><?php esc_html_e( '+ Add Specification', 'woodmart-child' ); ?></button>
				</section>

				<!-- 9. FAQ & STICKY PURCHASE BAR -->
				<section class="wc-tab-panel" id="tab-ams-faq">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'FAQ & Sticky Purchase Bar', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 9 on frontend: Accordion questions/answers, high-conversion bottom CTA banner, and floating sticky bar settings.', 'woodmart-child' ); ?></p>
					</div>

					<?php $fq = ! empty( $settings['faq'] ) ? $settings['faq'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'FAQ Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[faq][eyebrow]" value="<?php echo esc_attr( $fq['eyebrow'] ?? 'Got Questions?' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'FAQ Title', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[faq][title]" value="<?php echo esc_attr( $fq['title'] ?? 'Frequently Asked Questions' ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Accordion Questions & Answers Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="ams-faq-repeater">
						<?php
						$faq_items = ! empty( $fq['items'] ) ? $fq['items'] : array();
						foreach ( $faq_items as $idx => $fi ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields">
									<div class="wc-field">
										<label><?php esc_html_e( 'Question', 'woodmart-child' ); ?></label>
										<input type="text" name="ams_builder[faq][items][<?php echo esc_attr( $idx ); ?>][question]" value="<?php echo esc_attr( $fi['question'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field" style="margin-top: 8px;">
										<label><?php esc_html_e( 'Answer (HTML Allowed)', 'woodmart-child' ); ?></label>
										<textarea name="ams_builder[faq][items][<?php echo esc_attr( $idx ); ?>][answer]" rows="3" class="widefat"><?php echo esc_textarea( $fi['answer'] ?? '' ); ?></textarea>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="ams-faq-repeater" data-template="tmpl-ams-faq-row"><?php esc_html_e( '+ Add FAQ Item', 'woodmart-child' ); ?></button>

					<!-- Bottom Orange CTA Banner -->
					<h4 class="wc-subhead"><?php esc_html_e( 'Bottom Call-to-Action Banner', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'CTA Badge Tagline', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[faq][cta][badge]" value="<?php echo esc_attr( $fq['cta']['badge'] ?? 'Fast Baltic Delivery · Dispatched from Tallinn' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'CTA Headline', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[faq][cta][title]" value="<?php echo esc_attr( $fq['cta']['title'] ?? 'Ready to Print in Full Color?' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'CTA Subtitle', 'woodmart-child' ); ?></label>
						<textarea name="ams_builder[faq][cta][subtitle]" rows="2" class="widefat"><?php echo esc_textarea( $fq['cta']['subtitle'] ?? '' ); ?></textarea>
					</div>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Button Text', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[faq][cta][btn_text]" value="<?php echo esc_attr( $fq['cta']['btn_text'] ?? 'Order Bambu Lab AMS Now' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Button Scroll Link', 'woodmart-child' ); ?></label>
							<input type="text" name="ams_builder[faq][cta][btn_url]" value="<?php echo esc_attr( $fq['cta']['btn_url'] ?? '#ams-hero' ); ?>" class="widefat">
						</div>
					</div>

					<!-- Floating Persistent Sticky Bottom Purchase Bar -->
					<h4 class="wc-subhead"><?php esc_html_e( 'Floating Sticky Purchase Bar', 'woodmart-child' ); ?></h4>
					<div class="wc-field">
						<label class="wc-section-toggle">
							<input type="checkbox" name="ams_builder[faq][sticky_bar][enabled]" value="1" <?php checked( ! empty( $fq['sticky_bar']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Persistent Floating Sticky Bottom Purchase Bar', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>
				</section>

			</div><!-- .wc-builder-tabs-content -->
		</div><!-- .wc-builder-body -->
	</div><!-- .wc-builder-wrap -->

	<!-- Underscore / HTML Templates for Dynamic Repeaters -->
	<script type="text/html" id="tmpl-ams-guarantee-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Icon', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[general][guarantees][{{INDEX}}][icon]" value="shield" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Guarantee Title', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[general][guarantees][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[general][guarantees][{{INDEX}}][subtitle]" value="" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/html" id="tmpl-ams-addon-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-4">
				<div class="wc-field">
					<label><?php esc_html_e( 'Add-on Title', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[general][bundle_addons][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Badge', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[general][bundle_addons][{{INDEX}}][badge]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Price (€)', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[general][bundle_addons][{{INDEX}}][price]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Regular Price (€)', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[general][bundle_addons][{{INDEX}}][regular_price]" value="" class="widefat">
				</div>
			</div>
			<div class="wc-field-row grid-2" style="margin-top: 8px;">
				<div class="wc-field">
					<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[general][bundle_addons][{{INDEX}}][description]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Image URL', 'woodmart-child' ); ?></label>
					<div class="wc-image-picker">
						<input type="hidden" name="ams_builder[general][bundle_addons][{{INDEX}}][image]" value="" class="wc-image-url">
						<div class="wc-image-preview"></div>
						<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
						<button type="button" class="button wc-btn-remove-image hidden"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
					</div>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/html" id="tmpl-ams-metric-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Metric Value', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[overview][metrics][{{INDEX}}][value]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Metric Label', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[overview][metrics][{{INDEX}}][label]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[overview][metrics][{{INDEX}}][desc]" value="" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/html" id="tmpl-ams-drying-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Tag', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[drying_feeding][cards][{{INDEX}}][tag]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[drying_feeding][cards][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Badge Pill', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[drying_feeding][cards][{{INDEX}}][badge]" value="" class="widefat">
				</div>
			</div>
			<div class="wc-field" style="margin-top: 8px;">
				<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
				<textarea name="ams_builder[drying_feeding][cards][{{INDEX}}][desc]" rows="2" class="widefat"></textarea>
			</div>
			<div class="wc-field" style="margin-top: 8px;">
				<label><?php esc_html_e( 'Image Upload', 'woodmart-child' ); ?></label>
				<div class="wc-image-picker">
					<input type="hidden" name="ams_builder[drying_feeding][cards][{{INDEX}}][image]" value="" class="wc-image-url">
					<div class="wc-image-preview"></div>
					<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
					<button type="button" class="button wc-btn-remove-image hidden"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/html" id="tmpl-ams-design-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-2">
				<div class="wc-field">
					<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[design_details][cards][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Image Upload', 'woodmart-child' ); ?></label>
					<div class="wc-image-picker">
						<input type="hidden" name="ams_builder[design_details][cards][{{INDEX}}][image]" value="" class="wc-image-url">
						<div class="wc-image-preview"></div>
						<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
						<button type="button" class="button wc-btn-remove-image hidden"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
					</div>
				</div>
			</div>
			<div class="wc-field" style="margin-top: 8px;">
				<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
				<textarea name="ams_builder[design_details][cards][{{INDEX}}][desc]" rows="2" class="widefat"></textarea>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/html" id="tmpl-ams-printer-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Printer Model', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[compatibility_matrix][printers][{{INDEX}}][model]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Status', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[compatibility_matrix][printers][{{INDEX}}][status]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Status Badge', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[compatibility_matrix][printers][{{INDEX}}][status_badge]" value="" class="widefat">
				</div>
			</div>
			<div class="wc-repeater-fields grid-3" style="margin-top: 8px;">
				<div class="wc-field">
					<label><?php esc_html_e( 'Multi-AMS Support', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[compatibility_matrix][printers][{{INDEX}}][multi_ams]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Buffer / Hub Requirement', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[compatibility_matrix][printers][{{INDEX}}][buffer_req]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Notes', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[compatibility_matrix][printers][{{INDEX}}][notes]" value="" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/html" id="tmpl-ams-box-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Component Name', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[box_contents][items][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Description / Quantity', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[box_contents][items][{{INDEX}}][desc]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Icon', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[box_contents][items][{{INDEX}}][icon]" value="box" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/html" id="tmpl-ams-spec-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Category', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[specifications][items][{{INDEX}}][category]" value="General" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Spec Label', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[specifications][items][{{INDEX}}][label]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Spec Value', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[specifications][items][{{INDEX}}][value]" value="" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/html" id="tmpl-ams-faq-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields">
				<div class="wc-field">
					<label><?php esc_html_e( 'Question', 'woodmart-child' ); ?></label>
					<input type="text" name="ams_builder[faq][items][{{INDEX}}][question]" value="" class="widefat">
				</div>
				<div class="wc-field" style="margin-top: 8px;">
					<label><?php esc_html_e( 'Answer', 'woodmart-child' ); ?></label>
					<textarea name="ams_builder[faq][items][{{INDEX}}][answer]" rows="3" class="widefat"></textarea>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>
	<?php
}

/**
 * Save AMS Builder Meta Data
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post Post object.
 */
function woodmart_child_save_ams_builder_meta( $post_id, $post ) {
	// Nonce verification
	if ( ! isset( $_POST['woodmart_child_ams_builder_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['woodmart_child_ams_builder_nonce'] ), 'woodmart_child_save_ams_builder_meta' ) ) {
		return;
	}

	// Autosave check
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Permissions
	if ( ! current_user_can( 'edit_product', $post_id ) ) {
		return;
	}

	$raw_data = isset( $_POST['ams_builder'] ) && is_array( $_POST['ams_builder'] ) ? $_POST['ams_builder'] : array();

	// Master Landing Page Toggle
	$enable_landing = ! empty( $raw_data['general']['enable_landing'] ) ? '1' : '0';
	update_post_meta( $post_id, '_woodmart_child_ams_landing_enabled', $enable_landing );

	// Build clean sanitized data array
	$clean = array();

	// 1. General & Hero
	$clean['general'] = array(
		'enable_landing'  => $enable_landing,
		'eyebrow'         => sanitize_text_field( $raw_data['general']['eyebrow'] ?? '' ),
		'brand_name'      => sanitize_text_field( $raw_data['general']['brand_name'] ?? '' ),
		'badge_text'      => sanitize_text_field( $raw_data['general']['badge_text'] ?? '' ),
		'rating_text'     => sanitize_text_field( $raw_data['general']['rating_text'] ?? '' ),
		'stock_text'      => sanitize_text_field( $raw_data['general']['stock_text'] ?? '' ),
		'stock_note'      => sanitize_text_field( $raw_data['general']['stock_note'] ?? '' ),
		'warranty_text'   => sanitize_text_field( $raw_data['general']['warranty_text'] ?? '' ),
		'vat_note'        => sanitize_text_field( $raw_data['general']['vat_note'] ?? '' ),
		'ex_vat_text'     => sanitize_text_field( $raw_data['general']['ex_vat_text'] ?? '' ),
		'team_quote_text' => sanitize_text_field( $raw_data['general']['team_quote_text'] ?? '' ),
		'guarantees'      => array(),
		'bundle_addons'   => array(),
	);

	if ( ! empty( $raw_data['general']['guarantees'] ) && is_array( $raw_data['general']['guarantees'] ) ) {
		foreach ( $raw_data['general']['guarantees'] as $g ) {
			if ( ! empty( $g['title'] ) ) {
				$clean['general']['guarantees'][] = array(
					'icon'     => sanitize_text_field( $g['icon'] ?? 'shield' ),
					'title'    => sanitize_text_field( $g['title'] ?? '' ),
					'subtitle' => sanitize_text_field( $g['subtitle'] ?? '' ),
				);
			}
		}
	}

	if ( ! empty( $raw_data['general']['bundle_addons'] ) && is_array( $raw_data['general']['bundle_addons'] ) ) {
		foreach ( $raw_data['general']['bundle_addons'] as $addon ) {
			if ( ! empty( $addon['title'] ) ) {
				$clean['general']['bundle_addons'][] = array(
					'id'            => sanitize_title( $addon['title'] ),
					'title'         => sanitize_text_field( $addon['title'] ?? '' ),
					'badge'         => sanitize_text_field( $addon['badge'] ?? '' ),
					'price'         => sanitize_text_field( $addon['price'] ?? '' ),
					'regular_price' => sanitize_text_field( $addon['regular_price'] ?? '' ),
					'description'   => sanitize_text_field( $addon['description'] ?? '' ),
					'image'         => esc_url_raw( $addon['image'] ?? '' ),
				);
			}
		}
	}

	// 2. Overview & High-Impact Hero Banner
	$clean['overview'] = array(
		'eyebrow'        => sanitize_text_field( $raw_data['overview']['eyebrow'] ?? '' ),
		'title'          => sanitize_text_field( $raw_data['overview']['title'] ?? '' ),
		'subtitle'       => sanitize_textarea_field( $raw_data['overview']['subtitle'] ?? '' ),
		'banner_image'   => esc_url_raw( $raw_data['overview']['banner_image'] ?? '' ),
		'video_url'      => esc_url_raw( $raw_data['overview']['video_url'] ?? '' ),
		'video_btn_text' => sanitize_text_field( $raw_data['overview']['video_btn_text'] ?? '' ),
		'metrics'        => array(),
	);

	if ( ! empty( $raw_data['overview']['metrics'] ) && is_array( $raw_data['overview']['metrics'] ) ) {
		foreach ( $raw_data['overview']['metrics'] as $m ) {
			if ( ! empty( $m['value'] ) || ! empty( $m['label'] ) ) {
				$clean['overview']['metrics'][] = array(
					'value' => sanitize_text_field( $m['value'] ?? '' ),
					'label' => sanitize_text_field( $m['label'] ?? '' ),
					'desc'  => sanitize_text_field( $m['desc'] ?? '' ),
				);
			}
		}
	}

	// 3. Drying & Intelligent Feeding
	$clean['drying_feeding'] = array(
		'eyebrow'  => sanitize_text_field( $raw_data['drying_feeding']['eyebrow'] ?? '' ),
		'title'    => sanitize_text_field( $raw_data['drying_feeding']['title'] ?? '' ),
		'subtitle' => sanitize_textarea_field( $raw_data['drying_feeding']['subtitle'] ?? '' ),
		'cards'    => array(),
	);

	if ( ! empty( $raw_data['drying_feeding']['cards'] ) && is_array( $raw_data['drying_feeding']['cards'] ) ) {
		foreach ( $raw_data['drying_feeding']['cards'] as $card ) {
			if ( ! empty( $card['title'] ) ) {
				$clean['drying_feeding']['cards'][] = array(
					'tag'   => sanitize_text_field( $card['tag'] ?? '' ),
					'title' => sanitize_text_field( $card['title'] ?? '' ),
					'badge' => sanitize_text_field( $card['badge'] ?? '' ),
					'desc'  => sanitize_textarea_field( $card['desc'] ?? '' ),
					'image' => esc_url_raw( $card['image'] ?? '' ),
				);
			}
		}
	}

	// 4. Speed & Efficiency Metrics (Image 3)
	$clean['efficiency_metrics'] = array(
		'comparison_caption' => sanitize_text_field( $raw_data['efficiency_metrics']['comparison_caption'] ?? 'Bambu PETG Basic' ),
		'dry_label'          => sanitize_text_field( $raw_data['efficiency_metrics']['dry_label'] ?? 'Dry' ),
		'moist_label'        => sanitize_text_field( $raw_data['efficiency_metrics']['moist_label'] ?? 'Moist' ),
		'dry_image'          => esc_url_raw( $raw_data['efficiency_metrics']['dry_image'] ?? '' ),
		'moist_image'        => esc_url_raw( $raw_data['efficiency_metrics']['moist_image'] ?? '' ),
		'comparison_image'   => esc_url_raw( $raw_data['efficiency_metrics']['comparison_image'] ?? '' ),
		'eyebrow'            => sanitize_text_field( $raw_data['efficiency_metrics']['eyebrow'] ?? '' ),
		'title'              => sanitize_text_field( $raw_data['efficiency_metrics']['title'] ?? '' ),
		'subtitle'           => sanitize_textarea_field( $raw_data['efficiency_metrics']['subtitle'] ?? '' ),
		'card_speed'         => array(
			'metric' => sanitize_text_field( $raw_data['efficiency_metrics']['card_speed']['metric'] ?? '' ),
			'label'  => sanitize_text_field( $raw_data['efficiency_metrics']['card_speed']['label'] ?? '' ),
			'desc'   => sanitize_textarea_field( $raw_data['efficiency_metrics']['card_speed']['desc'] ?? '' ),
		),
		'card_waste'         => array(
			'metric' => sanitize_text_field( $raw_data['efficiency_metrics']['card_waste']['metric'] ?? '' ),
			'label'  => sanitize_text_field( $raw_data['efficiency_metrics']['card_waste']['label'] ?? '' ),
			'desc'   => sanitize_textarea_field( $raw_data['efficiency_metrics']['card_waste']['desc'] ?? '' ),
		),
		'banner_title'       => sanitize_text_field( $raw_data['efficiency_metrics']['banner_title'] ?? '' ),
		'banner_credit'      => sanitize_text_field( $raw_data['efficiency_metrics']['banner_credit'] ?? '' ),
		'banner_desc'        => sanitize_text_field( $raw_data['efficiency_metrics']['banner_desc'] ?? '' ),
		'banner_image'       => esc_url_raw( $raw_data['efficiency_metrics']['banner_image'] ?? '' ),
	);

	// 5. Evolved, Polished Design Details (Image 4)
	$clean['design_details'] = array(
		'eyebrow'  => sanitize_text_field( $raw_data['design_details']['eyebrow'] ?? '' ),
		'title'    => sanitize_text_field( $raw_data['design_details']['title'] ?? '' ),
		'subtitle' => sanitize_textarea_field( $raw_data['design_details']['subtitle'] ?? '' ),
		'cards'    => array(),
	);

	if ( ! empty( $raw_data['design_details']['cards'] ) && is_array( $raw_data['design_details']['cards'] ) ) {
		foreach ( $raw_data['design_details']['cards'] as $card ) {
			if ( ! empty( $card['title'] ) || ! empty( $card['desc'] ) ) {
				$clean['design_details']['cards'][] = array(
					'title' => sanitize_text_field( $card['title'] ?? '' ),
					'desc'  => sanitize_textarea_field( $card['desc'] ?? '' ),
					'image' => esc_url_raw( $card['image'] ?? '' ),
				);
			}
		}
	}

	// 6. Printer Compatibility Matrix
	$clean['compatibility_matrix'] = array(
		'eyebrow'      => sanitize_text_field( $raw_data['compatibility_matrix']['eyebrow'] ?? '' ),
		'title'        => sanitize_text_field( $raw_data['compatibility_matrix']['title'] ?? '' ),
		'subtitle'     => sanitize_text_field( $raw_data['compatibility_matrix']['subtitle'] ?? '' ),
		'lineup_image' => esc_url_raw( $raw_data['compatibility_matrix']['lineup_image'] ?? '' ),
		'note'         => sanitize_text_field( $raw_data['compatibility_matrix']['note'] ?? '' ),
		'printers'     => array(),
	);

	if ( ! empty( $raw_data['compatibility_matrix']['printers'] ) && is_array( $raw_data['compatibility_matrix']['printers'] ) ) {
		foreach ( $raw_data['compatibility_matrix']['printers'] as $p ) {
			if ( ! empty( $p['model'] ) ) {
				$clean['compatibility_matrix']['printers'][] = array(
					'model'        => sanitize_text_field( $p['model'] ?? '' ),
					'status'       => sanitize_text_field( $p['status'] ?? '' ),
					'status_badge' => sanitize_text_field( $p['status_badge'] ?? '' ),
					'multi_ams'    => sanitize_text_field( $p['multi_ams'] ?? '' ),
					'buffer_req'   => sanitize_text_field( $p['buffer_req'] ?? '' ),
					'notes'        => sanitize_text_field( $p['notes'] ?? '' ),
				);
			}
		}
	}

	// 7. What's in the Box
	$clean['box_contents'] = array(
		'eyebrow'  => sanitize_text_field( $raw_data['box_contents']['eyebrow'] ?? '' ),
		'title'    => sanitize_text_field( $raw_data['box_contents']['title'] ?? '' ),
		'subtitle' => sanitize_text_field( $raw_data['box_contents']['subtitle'] ?? '' ),
		'items'    => array(),
	);

	if ( ! empty( $raw_data['box_contents']['items'] ) && is_array( $raw_data['box_contents']['items'] ) ) {
		foreach ( $raw_data['box_contents']['items'] as $bi ) {
			if ( ! empty( $bi['title'] ) ) {
				$clean['box_contents']['items'][] = array(
					'title' => sanitize_text_field( $bi['title'] ?? '' ),
					'desc'  => sanitize_text_field( $bi['desc'] ?? '' ),
					'icon'  => sanitize_text_field( $bi['icon'] ?? 'box' ),
				);
			}
		}
	}

	// 8. Technical Specifications
	$clean['specifications'] = array(
		'eyebrow'  => sanitize_text_field( $raw_data['specifications']['eyebrow'] ?? '' ),
		'title'    => sanitize_text_field( $raw_data['specifications']['title'] ?? '' ),
		'subtitle' => sanitize_text_field( $raw_data['specifications']['subtitle'] ?? '' ),
		'items'    => array(),
	);

	if ( ! empty( $raw_data['specifications']['items'] ) && is_array( $raw_data['specifications']['items'] ) ) {
		foreach ( $raw_data['specifications']['items'] as $si ) {
			if ( ! empty( $si['label'] ) || ! empty( $si['value'] ) ) {
				$clean['specifications']['items'][] = array(
					'category' => sanitize_text_field( $si['category'] ?? 'General' ),
					'label'    => sanitize_text_field( $si['label'] ?? '' ),
					'value'    => sanitize_text_field( $si['value'] ?? '' ),
				);
			}
		}
	}

	// 9. FAQ & CTA & Sticky Bar
	$clean['faq'] = array(
		'eyebrow'    => sanitize_text_field( $raw_data['faq']['eyebrow'] ?? '' ),
		'title'      => sanitize_text_field( $raw_data['faq']['title'] ?? '' ),
		'items'      => array(),
		'cta'        => array(
			'badge'    => sanitize_text_field( $raw_data['faq']['cta']['badge'] ?? '' ),
			'title'    => sanitize_text_field( $raw_data['faq']['cta']['title'] ?? '' ),
			'subtitle' => sanitize_textarea_field( $raw_data['faq']['cta']['subtitle'] ?? '' ),
			'btn_text' => sanitize_text_field( $raw_data['faq']['cta']['btn_text'] ?? '' ),
			'btn_url'  => esc_url_raw( $raw_data['faq']['cta']['btn_url'] ?? '#ams-hero' ),
		),
		'sticky_bar' => array(
			'enabled'     => ! empty( $raw_data['faq']['sticky_bar']['enabled'] ) ? '1' : '0',
			'button_text' => sanitize_text_field( $raw_data['faq']['sticky_bar']['button_text'] ?? 'Add to basket' ),
		),
	);

	if ( ! empty( $raw_data['faq']['items'] ) && is_array( $raw_data['faq']['items'] ) ) {
		foreach ( $raw_data['faq']['items'] as $fi ) {
			if ( ! empty( $fi['question'] ) || ! empty( $fi['answer'] ) ) {
				$clean['faq']['items'][] = array(
					'question' => sanitize_text_field( $fi['question'] ?? '' ),
					'answer'   => wp_kses_post( $fi['answer'] ?? '' ),
				);
			}
		}
	}

	// Save AMS settings
	update_post_meta( $post_id, '_woodmart_child_ams_builder', $clean );
}
add_action( 'save_post_product', 'woodmart_child_save_ams_builder_meta', 10, 2 );
