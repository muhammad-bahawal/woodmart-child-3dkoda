<?php
/**
 * Native Custom Meta Box: Product Page Builder - Laser & Crafting (Bambu Lab A2L)
 *
 * Dedicated tabbed admin panel for the Laser & Crafting product landing page builder.
 * 100% synchronized with the frontend layout: every section is fully editable.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Product Page Builder Meta Box (Laser & Crafting)
 */
function woodmart_child_register_laser_crafting_builder_meta_box() {
	add_meta_box(
		'woodmart_child_laser_crafting_builder',
		__( 'Product Page Builder - Laser & Crafting', 'woodmart-child' ),
		'woodmart_child_render_laser_crafting_builder_meta_box',
		'product',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'woodmart_child_register_laser_crafting_builder_meta_box' );

/**
 * Render Product Page Builder Meta Box (Laser & Crafting)
 *
 * @param WP_Post $post Current post object.
 */
function woodmart_child_render_laser_crafting_builder_meta_box( $post ) {
	wp_nonce_field( 'woodmart_child_save_laser_crafting_builder_meta', 'woodmart_child_laser_crafting_builder_nonce' );

	$settings        = woodmart_child_get_laser_crafting_builder_settings( $post->ID );
	$enabled_landing = get_post_meta( $post->ID, '_woodmart_child_laser_crafting_landing_enabled', true );
	if ( '' === $enabled_landing ) {
		$enabled_landing = isset( $settings['general']['enable_landing'] ) ? $settings['general']['enable_landing'] : '0';
	}
	?>
	<div class="wc-builder-wrap">
		<!-- Master Switch Header -->
		<div class="wc-builder-master-bar">
			<label class="wc-builder-master-toggle">
				<input type="checkbox" name="laser_crafting_builder[general][enable_landing]" value="1" <?php checked( $enabled_landing, '1' ); ?>>
				<span class="wc-toggle-slider"></span>
				<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Laser & Crafting Landing Page', 'woodmart-child' ); ?></strong> (<?php esc_html_e( 'Replaces default WooCommerce layout with custom Laser & Crafting canvas while preserving the global Woodmart header and footer', 'woodmart-child' ); ?>)</span>
			</label>
		</div>

		<div class="wc-builder-body">
			<!-- Tab Navigation -->
			<nav class="wc-builder-tabs-nav" role="tablist">
				<button type="button" class="wc-tab-btn active" data-tab="tab-lc-general"><span class="dashicons dashicons-admin-settings"></span> <?php esc_html_e( 'Hero & General', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-overview"><span class="dashicons dashicons-format-image"></span> <?php esc_html_e( 'Overview & Video', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-why-choose"><span class="dashicons dashicons-grid-view"></span> <?php esc_html_e( 'Why Choose A2L', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-community"><span class="dashicons dashicons-images-alt2"></span> <?php esc_html_e( 'Community Showcase', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-build-volume"><span class="dashicons dashicons-screenoptions"></span> <?php esc_html_e( 'Build Volume', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-modular"><span class="dashicons dashicons-art"></span> <?php esc_html_e( 'Multi-Tool & 2D', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-stability"><span class="dashicons dashicons-dashboard"></span> <?php esc_html_e( 'Stability & Motion', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-ams"><span class="dashicons dashicons-image-filter"></span> <?php esc_html_e( 'Multi-Color & AMS', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-autopilot"><span class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'Print Autopilot', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-calibration-air"><span class="dashicons dashicons-heart"></span> <?php esc_html_e( 'Calibration, Air & Silence', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-connectivity-video"><span class="dashicons dashicons-video-alt3"></span> <?php esc_html_e( 'Connectivity & Video', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-box"><span class="dashicons dashicons-archive"></span> <?php esc_html_e( "What's in the Box", 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-specs"><span class="dashicons dashicons-clipboard"></span> <?php esc_html_e( 'Technical Specs', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-lc-faq"><span class="dashicons dashicons-format-chat"></span> <?php esc_html_e( 'FAQ & Sticky Bar', 'woodmart-child' ); ?></button>
			</nav>

			<!-- Tab Panels -->
			<div class="wc-builder-tabs-content">

				<!-- 1. HERO & GENERAL SETTINGS -->
				<section class="wc-tab-panel active" id="tab-lc-general">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Hero & General Settings', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Configure brand title, stock labels, warranty badges, packages (Standalone vs Combo vs Full Combo), and bundle upsell cards.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Hero Eyebrow Text', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][eyebrow]" value="<?php echo esc_attr( $settings['general']['eyebrow'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Brand Name', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][brand_name]" value="<?php echo esc_attr( $settings['general']['brand_name'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Reseller / Authorized Badge', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][badge_text]" value="<?php echo esc_attr( $settings['general']['badge_text'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Rating & Reviews Tagline', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][rating_text]" value="<?php echo esc_attr( $settings['general']['rating_text'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-3">
						<div class="wc-field">
							<label><?php esc_html_e( 'Stock Status Heading', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][stock_text]" value="<?php echo esc_attr( $settings['general']['stock_text'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Stock Dispatch Note', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][stock_note]" value="<?php echo esc_attr( $settings['general']['stock_note'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Warranty Badge Text', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][warranty_text]" value="<?php echo esc_attr( $settings['general']['warranty_text'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'VAT Notice', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][vat_note]" value="<?php echo esc_attr( $settings['general']['vat_note'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Ex. VAT Link Label', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[general][ex_vat_text]" value="<?php echo esc_attr( $settings['general']['ex_vat_text'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Team / Bulk Quote Link Text', 'woodmart-child' ); ?></label>
						<input type="text" name="laser_crafting_builder[general][team_quote_text]" value="<?php echo esc_attr( $settings['general']['team_quote_text'] ?? '' ); ?>" class="widefat">
					</div>

					<!-- Trust Guarantees -->
					<h4 class="wc-subhead"><?php esc_html_e( 'Service Guarantees (Hero 4-Grid Strip)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="lc-guarantees-repeater">
						<?php
						$guarantees = ! empty( $settings['general']['guarantees'] ) ? $settings['general']['guarantees'] : array();
						foreach ( $guarantees as $idx => $g ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Icon (truck, shield, refresh, award)', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[general][guarantees][<?php echo esc_attr( $idx ); ?>][icon]" value="<?php echo esc_attr( $g['icon'] ?? 'shield' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Guarantee Title', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[general][guarantees][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $g['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[general][guarantees][<?php echo esc_attr( $idx ); ?>][subtitle]" value="<?php echo esc_attr( $g['subtitle'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="lc-guarantees-repeater" data-template="tmpl-lc-guarantee-row"><?php esc_html_e( '+ Add Guarantee', 'woodmart-child' ); ?></button>

					<!-- Packages Configuration -->
					<h4 class="wc-subhead"><?php esc_html_e( 'Package Selector Options (Hero 3-Card Options)', 'woodmart-child' ); ?></h4>
					<?php
					$pkgs = ! empty( $settings['general']['packages'] ) ? $settings['general']['packages'] : array();
					$pkg_keys = array(
						'standalone' => __( 'Package 1: Standalone A2L', 'woodmart-child' ),
						'combo'      => __( 'Package 2: A2L Combo (with AMS lite)', 'woodmart-child' ),
						'full_combo' => __( 'Package 3: A2L Cutting Full Combo (with Blade & Pens)', 'woodmart-child' ),
					);
					foreach ( $pkg_keys as $pkey => $plabel ) :
						$pdata = $pkgs[ $pkey ] ?? array();
					?>
						<div class="wc-box-card" style="background: #fdfdfd; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
							<h5 style="margin: 0 0 10px; font-weight: 700; color: #1e293b;"><?php echo esc_html( $plabel ); ?></h5>
							<div class="wc-field-row grid-3">
								<div class="wc-field">
									<label><?php esc_html_e( 'Display Title', 'woodmart-child' ); ?></label>
									<input type="text" name="laser_crafting_builder[general][packages][<?php echo esc_attr( $pkey ); ?>][title]" value="<?php echo esc_attr( $pdata['title'] ?? '' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Price Display (e.g. €469.00)', 'woodmart-child' ); ?></label>
									<input type="text" name="laser_crafting_builder[general][packages][<?php echo esc_attr( $pkey ); ?>][price]" value="<?php echo esc_attr( $pdata['price'] ?? '' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Badge Tag (Optional, e.g. MOST POPULAR)', 'woodmart-child' ); ?></label>
									<input type="text" name="laser_crafting_builder[general][packages][<?php echo esc_attr( $pkey ); ?>][badge]" value="<?php echo esc_attr( $pdata['badge'] ?? '' ); ?>" class="widefat">
								</div>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
								<input type="text" name="laser_crafting_builder[general][packages][<?php echo esc_attr( $pkey ); ?>][description]" value="<?php echo esc_attr( $pdata['description'] ?? '' ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Included Features Bullets (1 per line)', 'woodmart-child' ); ?></label>
								<textarea name="laser_crafting_builder[general][packages][<?php echo esc_attr( $pkey ); ?>][bullets]" rows="3" class="widefat"><?php echo esc_textarea( $pdata['bullets'] ?? '' ); ?></textarea>
							</div>
						</div>
					<?php endforeach; ?>

					<!-- Bundle Add-ons (Upsells) -->
					<h4 class="wc-subhead"><?php esc_html_e( 'Must-Have Bundle Add-Ons (Hero Upsell Cards)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="lc-addons-repeater">
						<?php
						$addons = ! empty( $settings['general']['bundle_addons'] ) ? $settings['general']['bundle_addons'] : array();
						foreach ( $addons as $idx => $addon ) :
							$opt_val = '';
							if ( ! empty( $addon['options'] ) ) {
								$opt_val = is_array( $addon['options'] ) ? implode( ', ', $addon['options'] ) : (string) $addon['options'];
							}
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-addon-repeater-fields">
									<!-- Row 1: Pricing & Title -->
									<div class="wc-field-row grid-4">
										<div class="wc-field">
											<label><strong><?php esc_html_e( 'Item Title', 'woodmart-child' ); ?></strong></label>
											<input type="text" name="laser_crafting_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $addon['title'] ?? '' ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Print Finishing Kit', 'woodmart-child' ); ?>">
										</div>
										<div class="wc-field">
											<label><?php esc_html_e( 'Discount Badge', 'woodmart-child' ); ?></label>
											<input type="text" name="laser_crafting_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][badge]" value="<?php echo esc_attr( $addon['badge'] ?? '' ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. 15% off', 'woodmart-child' ); ?>">
										</div>
										<div class="wc-field">
											<label><?php esc_html_e( 'Bundle Price', 'woodmart-child' ); ?></label>
											<input type="text" name="laser_crafting_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][price]" value="<?php echo esc_attr( $addon['price'] ?? '' ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. €45.00', 'woodmart-child' ); ?>">
										</div>
										<div class="wc-field">
											<label><?php esc_html_e( 'Regular Price', 'woodmart-child' ); ?></label>
											<input type="text" name="laser_crafting_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][regular_price]" value="<?php echo esc_attr( $addon['regular_price'] ?? '' ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. €52.95', 'woodmart-child' ); ?>">
										</div>
									</div>

									<!-- Row 2: Product ID & Options & Description -->
									<div class="wc-field-row grid-3-addon">
										<div class="wc-field">
											<label><strong><?php esc_html_e( 'Product ID', 'woodmart-child' ); ?></strong></label>
											<input type="number" name="laser_crafting_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][product_id]" value="<?php echo esc_attr( $addon['product_id'] ?? '' ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. 1234', 'woodmart-child' ); ?>">
										</div>
										<div class="wc-field">
											<label><strong><?php esc_html_e( 'Dropdown Options (Comma-separated)', 'woodmart-child' ); ?></strong></label>
											<input type="text" name="laser_crafting_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][options]" value="<?php echo esc_attr( $opt_val ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Standard Toolset (Complete), Pro Kit', 'woodmart-child' ); ?>">
										</div>
										<div class="wc-field">
											<label><?php esc_html_e( 'Short Description', 'woodmart-child' ); ?></label>
											<input type="text" name="laser_crafting_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][description]" value="<?php echo esc_attr( $addon['description'] ?? '' ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Description...', 'woodmart-child' ); ?>">
										</div>
									</div>

									<!-- Row 3: Thumbnail Image -->
									<div class="wc-field-row">
										<div class="wc-field">
											<label><?php esc_html_e( 'Thumbnail Image', 'woodmart-child' ); ?></label>
											<div class="wc-image-picker">
												<input type="hidden" name="laser_crafting_builder[general][bundle_addons][<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $addon['image'] ?? '' ); ?>" class="wc-image-url">
												<div class="wc-image-preview"><?php if ( ! empty( $addon['image'] ) ) : ?><img src="<?php echo esc_url( $addon['image'] ); ?>"><?php endif; ?></div>
												<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
												<button type="button" class="button wc-btn-remove-image <?php echo empty( $addon['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
											</div>
										</div>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="lc-addons-repeater" data-template="tmpl-lc-addon-row"><?php esc_html_e( '+ Add Upsell Kit', 'woodmart-child' ); ?></button>
				</section>

				<!-- 2. OVERVIEW BANNER & VIDEO -->
				<section class="wc-tab-panel" id="tab-lc-overview">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Overview Banner & Video Popup', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 2 on frontend: High-impact brand headline, background/product image, and video popup modal.', 'woodmart-child' ); ?></p>
					</div>

					<?php 
					$ov = ! empty( $settings['overview'] ) ? $settings['overview'] : ( ! empty( $settings['highlights'] ) ? $settings['highlights'] : array() );
					?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Brand Eyebrow (e.g. Bambu Lab A2L)', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[overview][brand_title]" value="<?php echo esc_attr( $ov['brand_title'] ?? 'Bambu Lab A2L' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Main Headline', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[overview][title]" value="<?php echo esc_attr( $ov['title'] ?? "Creative Playground.\nExtra Large." ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Video URL (YouTube or MP4 - Opens in in-page popup modal)', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[overview][video_url]" value="<?php echo esc_attr( $ov['video_url'] ?? 'https://www.youtube.com/watch?v=0h9Vp5a8n2Y' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Watch Video Button Text', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[overview][video_btn_text]" value="<?php echo esc_attr( $ov['video_btn_text'] ?? 'Watch Video' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field" style="margin-top:16px;">
						<label><?php esc_html_e( 'Overview Banner Image (Fallback uses product featured image)', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="laser_crafting_builder[overview][banner_image]" value="<?php echo esc_attr( $ov['banner_image'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $ov['banner_image'] ) ) : ?><img src="<?php echo esc_url( $ov['banner_image'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $ov['banner_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>
				</section>

				<!-- 3. WHY CHOOSE BAMBU LAB A2L -->
				<section class="wc-tab-panel" id="tab-lc-why-choose">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Why Choose Bambu Lab A2L (6 Feature Cards)', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 3 on frontend: 6-card grid with feature titles, badges, and photo uploads.', 'woodmart-child' ); ?></p>
					</div>

					<?php 
					$wc_data = ! empty( $settings['why_choose'] ) ? $settings['why_choose'] : array();
					$wc_items = ! empty( $wc_data['items'] ) ? $wc_data['items'] : ( ! empty( $settings['highlights']['items'] ) ? $settings['highlights']['items'] : array() );
					?>
					<div class="wc-field">
						<label><?php esc_html_e( 'Section Heading Title', 'woodmart-child' ); ?></label>
						<input type="text" name="laser_crafting_builder[why_choose][title]" value="<?php echo esc_attr( $wc_data['title'] ?? 'Why choose Bambu Lab A2L' ); ?>" class="widefat">
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Feature Cards Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="lc-why-repeater">
						<?php foreach ( $wc_items as $idx => $wi ) : ?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[why_choose][items][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $wi['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Subtitle / Tagline', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[why_choose][items][<?php echo esc_attr( $idx ); ?>][sub]" value="<?php echo esc_attr( $wi['sub'] ?? ( $wi['desc'] ?? '' ) ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Badge Tag (e.g. 330×320×325 mm³)', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[why_choose][items][<?php echo esc_attr( $idx ); ?>][badge]" value="<?php echo esc_attr( $wi['badge'] ?? ( $wi['value'] ?? '' ) ); ?>" class="widefat">
									</div>
								</div>
								<div class="wc-field" style="margin-top: 8px;">
									<label><?php esc_html_e( 'Card Photo Upload (Fallback renders custom 3D vector illustration)', 'woodmart-child' ); ?></label>
									<div class="wc-image-picker">
										<input type="hidden" name="laser_crafting_builder[why_choose][items][<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $wi['image'] ?? '' ); ?>" class="wc-image-url">
										<div class="wc-image-preview"><?php if ( ! empty( $wi['image'] ) ) : ?><img src="<?php echo esc_url( $wi['image'] ); ?>"><?php endif; ?></div>
										<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
										<button type="button" class="button wc-btn-remove-image <?php echo empty( $wi['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="lc-why-repeater" data-template="tmpl-lc-why-row"><?php esc_html_e( '+ Add Feature Card', 'woodmart-child' ); ?></button>
				</section>

				<!-- 4. COMMUNITY SHOWCASE SLIDER -->
				<section class="wc-tab-panel" id="tab-lc-community">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Community Creations Slider', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 4 on frontend: Interactive carousel showing creations printed with A2L.', 'woodmart-child' ); ?></p>
					</div>

					<?php 
					$cs_data = ! empty( $settings['community_slider'] ) ? $settings['community_slider'] : array();
					$cs_items = ! empty( $cs_data['items'] ) ? $cs_data['items'] : ( ! empty( $settings['highlights']['community_items'] ) ? $settings['highlights']['community_items'] : array() );
					?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[community_slider][eyebrow]" value="<?php echo esc_attr( $cs_data['eyebrow'] ?? ( $settings['highlights']['community_sub'] ?? 'Top Creators | 2M+ Models | One Click Away' ) ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[community_slider][title]" value="<?php echo esc_attr( $cs_data['title'] ?? ( $settings['highlights']['community_title'] ?? "Printing Is a Blast When There's Always Something New on the Menu" ) ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Slider Slides Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="lc-slides-repeater">
						<?php foreach ( $cs_items as $idx => $si ) : ?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Project / Model Title', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[community_slider][items][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $si['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Category Badge (e.g. Interactive Kit)', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[community_slider][items][<?php echo esc_attr( $idx ); ?>][badge]" value="<?php echo esc_attr( $si['badge'] ?? ( $si['tag'] ?? '' ) ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Slide Description', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[community_slider][items][<?php echo esc_attr( $idx ); ?>][desc]" value="<?php echo esc_attr( $si['desc'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<div class="wc-field" style="margin-top: 8px;">
									<label><?php esc_html_e( 'Slide Image Upload', 'woodmart-child' ); ?></label>
									<div class="wc-image-picker">
										<input type="hidden" name="laser_crafting_builder[community_slider][items][<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $si['image'] ?? '' ); ?>" class="wc-image-url">
										<div class="wc-image-preview"><?php if ( ! empty( $si['image'] ) ) : ?><img src="<?php echo esc_url( $si['image'] ); ?>"><?php endif; ?></div>
										<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
										<button type="button" class="button wc-btn-remove-image <?php echo empty( $si['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="lc-slides-repeater" data-template="tmpl-lc-slide-row"><?php esc_html_e( '+ Add Slide', 'woodmart-child' ); ?></button>
				</section>

				<!-- 5. OVERSIZED BUILD VOLUME -->
				<section class="wc-tab-panel" id="tab-lc-build-volume">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Oversized Build Volume Showcase', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 5 on frontend: 330×320×325 mm volume cube render and A1 (256mm) vs A2L (330mm) comparison.', 'woodmart-child' ); ?></p>
					</div>

					<?php $bv = ! empty( $settings['build_volume'] ) ? $settings['build_volume'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[build_volume][eyebrow]" value="<?php echo esc_attr( $bv['eyebrow'] ?? 'Oversized Build Volume' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[build_volume][title]" value="<?php echo esc_attr( $bv['title'] ?? 'Extra Large Volume for Extra Bold Ideas' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Detailed Description', 'woodmart-child' ); ?></label>
						<textarea name="laser_crafting_builder[build_volume][desc]" rows="3" class="widefat"><?php echo esc_textarea( $bv['desc'] ?? "330 × 320 × 325 mm. That's 105% more space than the 256 mm class. A full-scale helmet, in one piece. A batch of 40 fidget toys, in one run. The kind of project that used to mean slicing your model into chunks—or starting over when the seams didn't line up—now just fits." ); ?></textarea>
					</div>

					<div class="wc-field-row grid-4">
						<div class="wc-field">
							<label><?php esc_html_e( 'Width (X)', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[build_volume][dim_w]" value="<?php echo esc_attr( $bv['dim_w'] ?? '330 mm' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Depth (Y)', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[build_volume][dim_d]" value="<?php echo esc_attr( $bv['dim_d'] ?? '320 mm' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Height (Z)', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[build_volume][dim_h]" value="<?php echo esc_attr( $bv['dim_h'] ?? '325 mm' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Machine Tag', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[build_volume][machine_tag]" value="<?php echo esc_attr( $bv['machine_tag'] ?? 'BAMBU LAB A2L 330×320×325 mm³ ENVELOPE' ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Comparison Cards (A1 vs A2L)', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-box-card" style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
							<h5 style="margin:0 0 8px;"><?php esc_html_e( 'Left Card: Standard A1 (256mm)', 'woodmart-child' ); ?></h5>
							<div class="wc-field">
								<label><?php esc_html_e( 'Subtitle / Warning Note', 'woodmart-child' ); ?></label>
								<input type="text" name="laser_crafting_builder[build_volume][a1_sub]" value="<?php echo esc_attr( $bv['a1_sub'] ?? '256 × 256 mm · Model must be sliced into parts' ); ?>" class="widefat">
							</div>
							<div class="wc-field" style="margin-top:8px;">
								<label><?php esc_html_e( 'Optional Custom Graphic Image', 'woodmart-child' ); ?></label>
								<div class="wc-image-picker">
									<input type="hidden" name="laser_crafting_builder[build_volume][a1_image]" value="<?php echo esc_attr( $bv['a1_image'] ?? '' ); ?>" class="wc-image-url">
									<div class="wc-image-preview"><?php if ( ! empty( $bv['a1_image'] ) ) : ?><img src="<?php echo esc_url( $bv['a1_image'] ); ?>"><?php endif; ?></div>
									<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
									<button type="button" class="button wc-btn-remove-image <?php echo empty( $bv['a1_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
								</div>
							</div>
						</div>

						<div class="wc-box-card" style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
							<h5 style="margin:0 0 8px;"><?php esc_html_e( 'Right Card: A2L (330mm Full Fit)', 'woodmart-child' ); ?></h5>
							<div class="wc-field">
								<label><?php esc_html_e( 'Subtitle / Success Note', 'woodmart-child' ); ?></label>
								<input type="text" name="laser_crafting_builder[build_volume][a2l_sub]" value="<?php echo esc_attr( $bv['a2l_sub'] ?? '330 × 320 mm · Single-piece continuous print' ); ?>" class="widefat">
							</div>
							<div class="wc-field" style="margin-top:8px;">
								<label><?php esc_html_e( 'Optional Custom Graphic Image', 'woodmart-child' ); ?></label>
								<div class="wc-image-picker">
									<input type="hidden" name="laser_crafting_builder[build_volume][a2l_image]" value="<?php echo esc_attr( $bv['a2l_image'] ?? '' ); ?>" class="wc-image-url">
									<div class="wc-image-preview"><?php if ( ! empty( $bv['a2l_image'] ) ) : ?><img src="<?php echo esc_url( $bv['a2l_image'] ); ?>"><?php endif; ?></div>
									<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
									<button type="button" class="button wc-btn-remove-image <?php echo empty( $bv['a2l_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
								</div>
							</div>
						</div>
					</div>
				</section>

				<!-- 6. MULTI-TOOL & 2D PROCESSING -->
				<section class="wc-tab-panel" id="tab-lc-modular">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Multi-Tool & 2D Processing', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 6 on frontend: 3-column hover-expanding cards (Smartphone Vision, Blade Cutting, Pen Drawing).', 'woodmart-child' ); ?></p>
					</div>

					<?php $mod = ! empty( $settings['modular_addons'] ) ? $settings['modular_addons'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[modular_addons][eyebrow]" value="<?php echo esc_attr( $mod['eyebrow'] ?? 'Modular Add-ons' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[modular_addons][title]" value="<?php echo esc_attr( $mod['title'] ?? 'Add a New Dimension with Blade Cutting' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
						<textarea name="laser_crafting_builder[modular_addons][description]" rows="2" class="widefat"><?php echo esc_textarea( $mod['description'] ?? "Swap the toolhead cover for the cutting module, and the A2L isn't just a printer anymore—it cuts. Stickers, leather, fabric, paper. Custom livery for your model plane? Done. A leather wrap for the handle of your Excalibur? Done." ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Modular Tools Cards (3 Cards)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="lc-tools-repeater">
						<?php
						$tools = ! empty( $mod['tools'] ) ? $mod['tools'] : array();
						foreach ( $tools as $idx => $t ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Tool Title', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[modular_addons][tools][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $t['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[modular_addons][tools][<?php echo esc_attr( $idx ); ?>][subtitle]" value="<?php echo esc_attr( $t['subtitle'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Feature Tag (e.g. Vision Alignment)', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[modular_addons][tools][<?php echo esc_attr( $idx ); ?>][tag]" value="<?php echo esc_attr( $t['tag'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<div class="wc-field" style="margin-top: 8px;">
									<label><?php esc_html_e( 'Card Background Photo (Fallback renders custom toolhead animation)', 'woodmart-child' ); ?></label>
									<div class="wc-image-picker">
										<input type="hidden" name="laser_crafting_builder[modular_addons][tools][<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $t['image'] ?? '' ); ?>" class="wc-image-url">
										<div class="wc-image-preview"><?php if ( ! empty( $t['image'] ) ) : ?><img src="<?php echo esc_url( $t['image'] ); ?>"><?php endif; ?></div>
										<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
										<button type="button" class="button wc-btn-remove-image <?php echo empty( $t['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="lc-tools-repeater" data-template="tmpl-lc-tool-row"><?php esc_html_e( '+ Add Tool Card', 'woodmart-child' ); ?></button>
				</section>

				<!-- 7. STABILITY & MOTION -->
				<section class="wc-tab-panel" id="tab-lc-stability">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Stability & Motion Engineering', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 7 on frontend: Adaptive Vibration Compensation (OFF vs ON) & Granular Mass Damper.', 'woodmart-child' ); ?></p>
					</div>

					<?php $ms = ! empty( $settings['motion_stability'] ) ? $settings['motion_stability'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[motion_stability][eyebrow]" value="<?php echo esc_attr( $ms['eyebrow'] ?? 'ENGINEERED FOR STABILITY' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[motion_stability][title]" value="<?php echo esc_attr( $ms['title'] ?? 'A Bed–Slinger As Stable As CoreXY' ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Tab 1: Adaptive Vibration Compensation', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Tab 1 Button Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[motion_stability][tab1_title]" value="<?php echo esc_attr( $ms['tab1_title'] ?? 'Adaptive Vibration Compensation' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Tab 1 Description Text', 'woodmart-child' ); ?></label>
							<textarea name="laser_crafting_builder[motion_stability][tab1_desc]" rows="2" class="widefat"><?php echo esc_textarea( $ms['tab1_desc'] ?? 'Most printers run input shaping once at startup. The A2L runs a real-time calibration matrix that accounts for toolhead position AND shifting bed weight as the model grows.' ); ?></textarea>
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Compensation OFF Image (Left column)', 'woodmart-child' ); ?></label>
							<div class="wc-image-picker">
								<input type="hidden" name="laser_crafting_builder[motion_stability][img_off]" value="<?php echo esc_attr( $ms['img_off'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $ms['img_off'] ) ) : ?><img src="<?php echo esc_url( $ms['img_off'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $ms['img_off'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Compensation ON Image (Right column)', 'woodmart-child' ); ?></label>
							<div class="wc-image-picker">
								<input type="hidden" name="laser_crafting_builder[motion_stability][img_on]" value="<?php echo esc_attr( $ms['img_on'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $ms['img_on'] ) ) : ?><img src="<?php echo esc_url( $ms['img_on'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $ms['img_on'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Tab 2: Granular Mass Damper', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Tab 2 Button Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[motion_stability][tab2_title]" value="<?php echo esc_attr( $ms['tab2_title'] ?? 'Granular Damper' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Tab 2 Description Text', 'woodmart-child' ); ?></label>
							<textarea name="laser_crafting_builder[motion_stability][tab2_desc]" rows="2" class="widefat"><?php echo esc_textarea( $ms['tab2_desc'] ?? 'Internal tuned dampers dissipate gantry resonance and harmonic vibration, enabling high-acceleration movement without ringing.' ); ?></textarea>
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Damper Assembly Image (Single wide visual)', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="laser_crafting_builder[motion_stability][img_damper]" value="<?php echo esc_attr( $ms['img_damper'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $ms['img_damper'] ) ) : ?><img src="<?php echo esc_url( $ms['img_damper'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $ms['img_damper'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>
				</section>

				<!-- 8. MULTI-COLOR & AMS SUPPORT -->
				<section class="wc-tab-panel" id="tab-lc-ams">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Multi-Color & AMS Support', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Sections 8 & 9 on frontend: Cockatiel hero card, sub-cards, and 2nd-Gen AMS diagram.', 'woodmart-child' ); ?></p>
					</div>

					<?php $ams = ! empty( $settings['ams_multicolor'] ) ? $settings['ams_multicolor'] : array(); ?>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[ams_multicolor][eyebrow]" value="<?php echo esc_attr( $ams['eyebrow'] ?? 'Automatic Material System' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[ams_multicolor][title]" value="<?php echo esc_attr( $ams['title'] ?? 'Multi-Color Made Easy' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
						<textarea name="laser_crafting_builder[ams_multicolor][description]" rows="2" class="widefat"><?php echo esc_textarea( $ams['description'] ?? "Multi-color printing isn't new. Doing it thousands of times in a row, without a single jam, is. That's the bar AMS lite is built to clear. Over a million users worldwide have put it through long, color-heavy prints—the kind where one bad swap ruins twelve hours of work—and it keeps swapping." ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Top Hero Card (Cockatiel Bird Scene)', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Hero Card Badge', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[ams_multicolor][hero_badge]" value="<?php echo esc_attr( $ams['hero_badge'] ?? '4-Color Single-Extruder Swap' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Hero Model Photo Upload', 'woodmart-child' ); ?></label>
							<div class="wc-image-picker">
								<input type="hidden" name="laser_crafting_builder[ams_multicolor][hero_img]" value="<?php echo esc_attr( $ams['hero_img'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $ams['hero_img'] ) ) : ?><img src="<?php echo esc_url( $ams['hero_img'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $ams['hero_img'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Bottom Sub-Cards (Track & Boardgame)', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-box-card" style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
							<div class="wc-field">
								<label><?php esc_html_e( 'Card 1 Title', 'woodmart-child' ); ?></label>
								<input type="text" name="laser_crafting_builder[ams_multicolor][sub1_title]" value="<?php echo esc_attr( $ams['sub1_title'] ?? 'Nordschleife 3D Miniature' ); ?>" class="widefat">
							</div>
							<div class="wc-field" style="margin-top:8px;">
								<label><?php esc_html_e( 'Card 1 Image Upload', 'woodmart-child' ); ?></label>
								<div class="wc-image-picker">
									<input type="hidden" name="laser_crafting_builder[ams_multicolor][sub1_img]" value="<?php echo esc_attr( $ams['sub1_img'] ?? '' ); ?>" class="wc-image-url">
									<div class="wc-image-preview"><?php if ( ! empty( $ams['sub1_img'] ) ) : ?><img src="<?php echo esc_url( $ams['sub1_img'] ); ?>"><?php endif; ?></div>
									<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
									<button type="button" class="button wc-btn-remove-image <?php echo empty( $ams['sub1_img'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
								</div>
							</div>
						</div>

						<div class="wc-box-card" style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
							<div class="wc-field">
								<label><?php esc_html_e( 'Card 2 Title', 'woodmart-child' ); ?></label>
								<input type="text" name="laser_crafting_builder[ams_multicolor][sub2_title]" value="<?php echo esc_attr( $ams['sub2_title'] ?? 'Relic Rush Board Game' ); ?>" class="widefat">
							</div>
							<div class="wc-field" style="margin-top:8px;">
								<label><?php esc_html_e( 'Card 2 Image Upload', 'woodmart-child' ); ?></label>
								<div class="wc-image-picker">
									<input type="hidden" name="laser_crafting_builder[ams_multicolor][sub2_img]" value="<?php echo esc_attr( $ams['sub2_img'] ?? '' ); ?>" class="wc-image-url">
									<div class="wc-image-preview"><?php if ( ! empty( $ams['sub2_img'] ) ) : ?><img src="<?php echo esc_url( $ams['sub2_img'] ); ?>"><?php endif; ?></div>
									<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
									<button type="button" class="button wc-btn-remove-image <?php echo empty( $ams['sub2_img'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
								</div>
							</div>
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Support 2nd-Gen AMS Architecture Section', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Heading Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[ams_multicolor][ams_diagram_title]" value="<?php echo esc_attr( $ams['ams_diagram_title'] ?? 'Support 2nd–Gen AMS' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Highlight Pills (Separated by |)', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[ams_multicolor][ams_diagram_pills]" value="<?php echo esc_attr( $ams['ams_diagram_pills'] ?? '19-Color Printing | Filament Drying | Enclosed Storage' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Paragraph Description', 'woodmart-child' ); ?></label>
						<textarea name="laser_crafting_builder[ams_multicolor][ams_diagram_desc]" rows="2" class="widefat"><?php echo esc_textarea( $ams['ams_diagram_desc'] ?? 'Pair the A2L with the 2nd-Gen AMS, and your filament gets a sealed, climate-controlled home—dried on demand before each print, kept airtight between them. Need more colors? Need different material types running side by side? AMS lite and the 2nd-Gen AMS share the same embedded buffer system, so you can stack and mix them: four spools, eight spools, sixteen spools—whatever your project asks for, fed cleanly through one queue.' ); ?></textarea>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'AMS Architecture Diagram Image Upload', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="laser_crafting_builder[ams_multicolor][ams_diagram_img]" value="<?php echo esc_attr( $ams['ams_diagram_img'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $ams['ams_diagram_img'] ) ) : ?><img src="<?php echo esc_url( $ams['ams_diagram_img'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $ams['ams_diagram_img'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>
				</section>

				<!-- 9. PRINT AUTOPILOT -->
				<section class="wc-tab-panel" id="tab-lc-autopilot">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Print Autopilot: No Print Left Behind', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Section 10 on frontend: 3-card hover-expanding monitoring cards for nozzle clumping, filament grinding, and air printing.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[ams_multicolor][autopilot_eyebrow]" value="<?php echo esc_attr( $ams['autopilot_eyebrow'] ?? 'INTELLIGENT PRINT MONITORING' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[ams_multicolor][autopilot_title]" value="<?php echo esc_attr( $ams['autopilot_title'] ?? 'Put Your Printing on Autopilot' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
						<textarea name="laser_crafting_builder[ams_multicolor][autopilot_desc]" rows="2" class="widefat"><?php echo esc_textarea( $ams['autopilot_desc'] ?? 'Most print failures happen quietly—the nozzle keeps moving, but the part stopped forming hours ago. Sensors along the extrusion path, paired with the PMSM extruder as a feedback node, feed a Bambu-trained algorithm that catches filament tangle, runout, nozzle clumping, and air printing—then pauses A2L and guides you through the fix on Bambu Handy.' ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( '3 Monitoring Cards Images', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-3">
						<div class="wc-box-card" style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
							<h5 style="margin:0 0 6px;"><?php esc_html_e( 'Card 1: Nozzle Clumping', 'woodmart-child' ); ?></h5>
							<div class="wc-image-picker">
								<input type="hidden" name="laser_crafting_builder[ams_multicolor][img_clumping]" value="<?php echo esc_attr( $ams['img_clumping'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $ams['img_clumping'] ) ) : ?><img src="<?php echo esc_url( $ams['img_clumping'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $ams['img_clumping'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>

						<div class="wc-box-card" style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
							<h5 style="margin:0 0 6px;"><?php esc_html_e( 'Card 2: Filament Grinding', 'woodmart-child' ); ?></h5>
							<div class="wc-image-picker">
								<input type="hidden" name="laser_crafting_builder[ams_multicolor][img_grinding]" value="<?php echo esc_attr( $ams['img_grinding'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $ams['img_grinding'] ) ) : ?><img src="<?php echo esc_url( $ams['img_grinding'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $ams['img_grinding'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>

						<div class="wc-box-card" style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
							<h5 style="margin:0 0 6px;"><?php esc_html_e( 'Card 3: Air Printing', 'woodmart-child' ); ?></h5>
							<div class="wc-image-picker">
								<input type="hidden" name="laser_crafting_builder[ams_multicolor][img_airprint]" value="<?php echo esc_attr( $ams['img_airprint'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $ams['img_airprint'] ) ) : ?><img src="<?php echo esc_url( $ams['img_airprint'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $ams['img_airprint'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
					</div>
				</section>

				<!-- 10. CALIBRATION, AIR & SILENCE -->
				<section class="wc-tab-panel" id="tab-lc-calibration-air">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Calibration, Air Quality & Silence', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Sections 11, 12, 13 on frontend: Auto Flow Dynamics, UL GREENGUARD Clean Air, and 49dB Silent Mode.', 'woodmart-child' ); ?></p>
					</div>

					<!-- Flow Dynamics -->
					<?php $fc = ! empty( $settings['flow_calibration'] ) ? $settings['flow_calibration'] : array(); ?>
					<h4 class="wc-subhead"><?php esc_html_e( '1. Auto Flow Dynamics Calibration', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[flow_calibration][eyebrow]" value="<?php echo esc_attr( $fc['eyebrow'] ?? 'Auto Flow Dynamics Calibration' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[flow_calibration][title]" value="<?php echo esc_attr( $fc['title'] ?? 'Repeatable Sharp Print Details' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Status Highlights (Comma separated)', 'woodmart-child' ); ?></label>
						<input type="text" name="laser_crafting_builder[flow_calibration][status_text]" value="<?php echo esc_attr( $fc['status_text'] ?? 'Worn nozzle (20% out-spec) , Damp filament , Nozzle residue' ); ?>" class="widefat">
					</div>
					<div class="wc-field-row grid-2" style="margin-top:8px;">
						<div class="wc-field">
							<label><?php esc_html_e( 'A2L Sharp Details Image', 'woodmart-child' ); ?></label>
							<div class="wc-image-picker">
								<input type="hidden" name="laser_crafting_builder[flow_calibration][a2l_image]" value="<?php echo esc_attr( $fc['a2l_image'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $fc['a2l_image'] ) ) : ?><img src="<?php echo esc_url( $fc['a2l_image'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $fc['a2l_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Other Printers Blurred Image', 'woodmart-child' ); ?></label>
							<div class="wc-image-picker">
								<input type="hidden" name="laser_crafting_builder[flow_calibration][other_image]" value="<?php echo esc_attr( $fc['other_image'] ?? '' ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $fc['other_image'] ) ) : ?><img src="<?php echo esc_url( $fc['other_image'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $fc['other_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
					</div>

					<!-- Clean Air -->
					<?php $ca = ! empty( $settings['clean_air'] ) ? $settings['clean_air'] : array(); ?>
					<h4 class="wc-subhead" style="margin-top:24px;"><?php esc_html_e( '2. UL Clean Air Certified', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[clean_air][eyebrow]" value="<?php echo esc_attr( $ca['eyebrow'] ?? 'UL Clean Air Certified' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[clean_air][title]" value="<?php echo esc_attr( $ca['title'] ?? 'Print with Confidence, Breathe with Peace of Mind' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Lifestyle Family Photo Upload', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="laser_crafting_builder[clean_air][lifestyle_image]" value="<?php echo esc_attr( $ca['lifestyle_image'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $ca['lifestyle_image'] ) ) : ?><img src="<?php echo esc_url( $ca['lifestyle_image'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $ca['lifestyle_image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>

					<!-- Engineered for Silence -->
					<?php $si = ! empty( $settings['silence'] ) ? $settings['silence'] : array(); ?>
					<h4 class="wc-subhead" style="margin-top:24px;"><?php esc_html_e( '3. Engineered for Silence (49dB)', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-3">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[silence][eyebrow]" value="<?php echo esc_attr( $si['eyebrow'] ?? 'Engineered for Silence' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[silence][title]" value="<?php echo esc_attr( $si['title'] ?? 'Print Quietly. Work Comfortably.' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Metric Badge (e.g. 49 dB · Silent Mode)', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[silence][metric]" value="<?php echo esc_attr( $si['metric'] ?? '49 dB · Silent Mode' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Silence Graphic / Photo Upload', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="laser_crafting_builder[silence][image]" value="<?php echo esc_attr( $si['image'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $si['image'] ) ) : ?><img src="<?php echo esc_url( $si['image'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $si['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>
				</section>

				<!-- 11. CONNECTIVITY & UNBOXING VIDEO -->
				<section class="wc-tab-panel" id="tab-lc-connectivity-video">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Connectivity & Unboxing Video', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Sections 14 & 15 on frontend: Connect Your Way architecture diagram and full-width Unboxing Video player.', 'woodmart-child' ); ?></p>
					</div>

					<!-- Connect Your Way -->
					<?php $co = ! empty( $settings['connectivity'] ) ? $settings['connectivity'] : array(); ?>
					<h4 class="wc-subhead"><?php esc_html_e( '1. Connectivity & Privacy Architecture', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[connectivity][eyebrow]" value="<?php echo esc_attr( $co['eyebrow'] ?? 'Connectivity & Privacy' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[connectivity][title]" value="<?php echo esc_attr( $co['title'] ?? 'Connect Your Way' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Architecture Diagram Graphic Upload', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="laser_crafting_builder[connectivity][image]" value="<?php echo esc_attr( $co['image'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $co['image'] ) ) : ?><img src="<?php echo esc_url( $co['image'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $co['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>

					<!-- Unboxing Video -->
					<?php $uv = ! empty( $settings['unboxing_video'] ) ? $settings['unboxing_video'] : array(); ?>
					<h4 class="wc-subhead" style="margin-top:24px;"><?php esc_html_e( '2. Unboxing Video Player Section', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[unboxing_video][title]" value="<?php echo esc_attr( $uv['title'] ?? 'Unboxing Video' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Video URL (YouTube or MP4)', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[unboxing_video][video_url]" value="<?php echo esc_attr( $uv['video_url'] ?? 'https://www.youtube.com/watch?v=0h9Vp5a8n2Y' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Video Poster / Cover Image Upload', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="laser_crafting_builder[unboxing_video][video_poster]" value="<?php echo esc_attr( $uv['video_poster'] ?? '' ); ?>" class="wc-image-url">
							<div class="wc-image-preview"><?php if ( ! empty( $uv['video_poster'] ) ) : ?><img src="<?php echo esc_url( $uv['video_poster'] ); ?>"><?php endif; ?></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image <?php echo empty( $uv['video_poster'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>
				</section>

				<!-- 12. WHAT'S IN THE BOX -->
				<section class="wc-tab-panel" id="tab-lc-box">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( "What's in the Box (Matrix Table)", 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Multi-package comparison table checking off items for A2L, A2L Combo, and Cutting Full Combo.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[box_contents][eyebrow]" value="<?php echo esc_attr( $settings['box_contents']['eyebrow'] ?? 'Package Comparison Matrix' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[box_contents][title]" value="<?php echo esc_attr( $settings['box_contents']['title'] ?? "What's in the Box" ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Package Items Comparison Rows', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="lc-box-repeater">
						<?php
						$b_items = ! empty( $settings['box_contents']['items'] ) ? $settings['box_contents']['items'] : array();
						foreach ( $b_items as $idx => $bi ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-4">
									<div class="wc-field" style="grid-column: span 2;">
										<label><?php esc_html_e( 'Item Description', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[box_contents][items][<?php echo esc_attr( $idx ); ?>][name]" value="<?php echo esc_attr( $bi['name'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field" style="display:flex; align-items:center; gap:8px; margin-top:20px;">
										<label>
											<input type="checkbox" name="laser_crafting_builder[box_contents][items][<?php echo esc_attr( $idx ); ?>][standalone]" value="1" <?php checked( ! empty( $bi['standalone'] ) ); ?>>
											<?php esc_html_e( 'A2L', 'woodmart-child' ); ?>
										</label>
										<label>
											<input type="checkbox" name="laser_crafting_builder[box_contents][items][<?php echo esc_attr( $idx ); ?>][combo]" value="1" <?php checked( ! empty( $bi['combo'] ) ); ?>>
											<?php esc_html_e( 'Combo', 'woodmart-child' ); ?>
										</label>
										<label>
											<input type="checkbox" name="laser_crafting_builder[box_contents][items][<?php echo esc_attr( $idx ); ?>][full_combo]" value="1" <?php checked( ! empty( $bi['full_combo'] ) ); ?>>
											<?php esc_html_e( 'Full Combo', 'woodmart-child' ); ?>
										</label>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="lc-box-repeater" data-template="tmpl-lc-box-row"><?php esc_html_e( '+ Add Item Row', 'woodmart-child' ); ?></button>
				</section>

				<!-- 13. TECHNICAL SPECIFICATIONS -->
				<section class="wc-tab-panel" id="tab-lc-specs">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Technical Specifications', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Dynamic repeater for categories, specification parameters, and values.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[specs][eyebrow]" value="<?php echo esc_attr( $settings['specs']['eyebrow'] ?? 'Verified Engineering Metrics' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[specs][title]" value="<?php echo esc_attr( $settings['specs']['title'] ?? 'Technical Specifications' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-repeater-container" id="lc-specs-repeater">
						<?php
						$sp_items = ! empty( $settings['specs']['items'] ) ? $settings['specs']['items'] : array();
						foreach ( $sp_items as $idx => $sp ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field">
										<label><?php esc_html_e( 'Category', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[specs][items][<?php echo esc_attr( $idx ); ?>][category]" value="<?php echo esc_attr( $sp['category'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Spec Label', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[specs][items][<?php echo esc_attr( $idx ); ?>][label]" value="<?php echo esc_attr( $sp['label'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Spec Value', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[specs][items][<?php echo esc_attr( $idx ); ?>][value]" value="<?php echo esc_attr( $sp['value'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="lc-specs-repeater" data-template="tmpl-lc-spec-row"><?php esc_html_e( '+ Add Specification Row', 'woodmart-child' ); ?></button>
				</section>

				<!-- 14. FAQ & STICKY PURCHASE BAR -->
				<section class="wc-tab-panel" id="tab-lc-faq">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'FAQ & Sticky Purchase Bar', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Manage collapsible FAQ items, high-impact CTA banner, and persistent floating purchase bar.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[faq][eyebrow]" value="<?php echo esc_attr( $settings['faq']['eyebrow'] ?? 'Questions & Answers' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[faq][title]" value="<?php echo esc_attr( $settings['faq']['title'] ?? 'Frequently Asked Questions' ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Questions & Answers Repeater', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="lc-faq-repeater">
						<?php
						$f_items = ! empty( $settings['faq']['items'] ) ? $settings['faq']['items'] : array();
						foreach ( $f_items as $idx => $fi ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields" style="width: 100%;">
									<div class="wc-field">
										<label><?php esc_html_e( 'Question', 'woodmart-child' ); ?></label>
										<input type="text" name="laser_crafting_builder[faq][items][<?php echo esc_attr( $idx ); ?>][question]" value="<?php echo esc_attr( $fi['question'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field" style="margin-top: 6px;">
										<label><?php esc_html_e( 'Answer', 'woodmart-child' ); ?></label>
										<textarea name="laser_crafting_builder[faq][items][<?php echo esc_attr( $idx ); ?>][answer]" rows="2" class="widefat"><?php echo esc_textarea( $fi['answer'] ?? '' ); ?></textarea>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="lc-faq-repeater" data-template="tmpl-lc-faq-row"><?php esc_html_e( '+ Add FAQ Item', 'woodmart-child' ); ?></button>

					<h4 class="wc-subhead"><?php esc_html_e( 'Bottom Call To Action Banner', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Banner Badge Tag', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[faq][cta][badge]" value="<?php echo esc_attr( $settings['faq']['cta']['badge'] ?? 'READY TO CREATE?' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Banner Title', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[faq][cta][title]" value="<?php echo esc_attr( $settings['faq']['cta']['title'] ?? 'Transform your workflow from 3D printing to full-spectrum crafting.' ); ?>" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Banner Subtitle', 'woodmart-child' ); ?></label>
						<input type="text" name="laser_crafting_builder[faq][cta][subtitle]" value="<?php echo esc_attr( $settings['faq']['cta']['subtitle'] ?? 'Dispatched from our Tallinn warehouse with fast 1–2 day Baltic delivery and official local warranty.' ); ?>" class="widefat">
					</div>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'CTA Button Text', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[faq][cta][btn_text]" value="<?php echo esc_attr( $settings['faq']['cta']['btn_text'] ?? 'Choose Your A2L Package' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'CTA Button Target URL', 'woodmart-child' ); ?></label>
							<input type="text" name="laser_crafting_builder[faq][cta][btn_url]" value="<?php echo esc_attr( $settings['faq']['cta']['btn_url'] ?? '#laser-crafting-hero' ); ?>" class="widefat">
						</div>
					</div>
				</section>

			</div>
		</div>
	</div>

	<!-- Underscore JS / Dynamic Templates -->
	<script type="text/template" id="tmpl-lc-guarantee-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Icon (truck, shield, refresh, award)', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[general][guarantees][{{INDEX}}][icon]" value="shield" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Guarantee Title', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[general][guarantees][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[general][guarantees][{{INDEX}}][subtitle]" value="" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/template" id="tmpl-lc-addon-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-addon-repeater-fields">
				<!-- Row 1: Pricing & Title -->
				<div class="wc-field-row grid-4">
					<div class="wc-field">
						<label><strong><?php esc_html_e( 'Item Title', 'woodmart-child' ); ?></strong></label>
						<input type="text" name="laser_crafting_builder[general][bundle_addons][{{INDEX}}][title]" value="" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Print Finishing Kit', 'woodmart-child' ); ?>">
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Discount Badge', 'woodmart-child' ); ?></label>
						<input type="text" name="laser_crafting_builder[general][bundle_addons][{{INDEX}}][badge]" value="15% off" class="widefat" placeholder="<?php esc_attr_e( 'e.g. 15% off', 'woodmart-child' ); ?>">
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Bundle Price', 'woodmart-child' ); ?></label>
						<input type="text" name="laser_crafting_builder[general][bundle_addons][{{INDEX}}][price]" value="€45.00" class="widefat" placeholder="<?php esc_attr_e( 'e.g. €45.00', 'woodmart-child' ); ?>">
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Regular Price', 'woodmart-child' ); ?></label>
						<input type="text" name="laser_crafting_builder[general][bundle_addons][{{INDEX}}][regular_price]" value="€52.95" class="widefat" placeholder="<?php esc_attr_e( 'e.g. €52.95', 'woodmart-child' ); ?>">
					</div>
				</div>

				<!-- Row 2: Product ID & Options & Description -->
				<div class="wc-field-row grid-3-addon">
					<div class="wc-field">
						<label><strong><?php esc_html_e( 'Product ID', 'woodmart-child' ); ?></strong></label>
						<input type="number" name="laser_crafting_builder[general][bundle_addons][{{INDEX}}][product_id]" value="" class="widefat" placeholder="<?php esc_attr_e( 'e.g. 1234', 'woodmart-child' ); ?>">
					</div>
					<div class="wc-field">
						<label><strong><?php esc_html_e( 'Dropdown Options (Comma-separated)', 'woodmart-child' ); ?></strong></label>
						<input type="text" name="laser_crafting_builder[general][bundle_addons][{{INDEX}}][options]" value="" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Standard Toolset (Complete), Pro Kit', 'woodmart-child' ); ?>">
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Short Description', 'woodmart-child' ); ?></label>
						<input type="text" name="laser_crafting_builder[general][bundle_addons][{{INDEX}}][description]" value="" class="widefat" placeholder="<?php esc_attr_e( 'Description...', 'woodmart-child' ); ?>">
					</div>
				</div>

				<!-- Row 3: Thumbnail Image -->
				<div class="wc-field-row">
					<div class="wc-field">
						<label><?php esc_html_e( 'Thumbnail Image', 'woodmart-child' ); ?></label>
						<div class="wc-image-picker">
							<input type="hidden" name="laser_crafting_builder[general][bundle_addons][{{INDEX}}][image]" value="" class="wc-image-url">
							<div class="wc-image-preview"></div>
							<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
							<button type="button" class="button wc-btn-remove-image hidden"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
						</div>
					</div>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/template" id="tmpl-lc-why-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[why_choose][items][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[why_choose][items][{{INDEX}}][sub]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Badge Tag', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[why_choose][items][{{INDEX}}][badge]" value="" class="widefat">
				</div>
			</div>
			<div class="wc-field" style="margin-top: 8px;">
				<label><?php esc_html_e( 'Card Photo Upload', 'woodmart-child' ); ?></label>
				<div class="wc-image-picker">
					<input type="hidden" name="laser_crafting_builder[why_choose][items][{{INDEX}}][image]" value="" class="wc-image-url">
					<div class="wc-image-preview"></div>
					<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
					<button type="button" class="button wc-btn-remove-image hidden"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/template" id="tmpl-lc-slide-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Project / Model Title', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[community_slider][items][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Category Badge', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[community_slider][items][{{INDEX}}][badge]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[community_slider][items][{{INDEX}}][desc]" value="" class="widefat">
				</div>
			</div>
			<div class="wc-field" style="margin-top: 8px;">
				<label><?php esc_html_e( 'Slide Image Upload', 'woodmart-child' ); ?></label>
				<div class="wc-image-picker">
					<input type="hidden" name="laser_crafting_builder[community_slider][items][{{INDEX}}][image]" value="" class="wc-image-url">
					<div class="wc-image-preview"></div>
					<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
					<button type="button" class="button wc-btn-remove-image hidden"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/template" id="tmpl-lc-tool-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Tool Title', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[modular_addons][tools][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[modular_addons][tools][{{INDEX}}][subtitle]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Feature Tag', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[modular_addons][tools][{{INDEX}}][tag]" value="" class="widefat">
				</div>
			</div>
			<div class="wc-field" style="margin-top: 8px;">
				<label><?php esc_html_e( 'Card Background Photo', 'woodmart-child' ); ?></label>
				<div class="wc-image-picker">
					<input type="hidden" name="laser_crafting_builder[modular_addons][tools][{{INDEX}}][image]" value="" class="wc-image-url">
					<div class="wc-image-preview"></div>
					<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
					<button type="button" class="button wc-btn-remove-image hidden"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/template" id="tmpl-lc-box-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-4">
				<div class="wc-field" style="grid-column: span 2;">
					<label><?php esc_html_e( 'Item Description', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[box_contents][items][{{INDEX}}][name]" value="" class="widefat">
				</div>
				<div class="wc-field" style="display:flex; align-items:center; gap:8px; margin-top:20px;">
					<label><input type="checkbox" name="laser_crafting_builder[box_contents][items][{{INDEX}}][standalone]" value="1"> A2L</label>
					<label><input type="checkbox" name="laser_crafting_builder[box_contents][items][{{INDEX}}][combo]" value="1"> Combo</label>
					<label><input type="checkbox" name="laser_crafting_builder[box_contents][items][{{INDEX}}][full_combo]" value="1"> Full Combo</label>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/template" id="tmpl-lc-spec-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field">
					<label><?php esc_html_e( 'Category', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[specs][items][{{INDEX}}][category]" value="General" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Spec Label', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[specs][items][{{INDEX}}][label]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Spec Value', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[specs][items][{{INDEX}}][value]" value="" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>

	<script type="text/template" id="tmpl-lc-faq-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields" style="width: 100%;">
				<div class="wc-field">
					<label><?php esc_html_e( 'Question', 'woodmart-child' ); ?></label>
					<input type="text" name="laser_crafting_builder[faq][items][{{INDEX}}][question]" value="" class="widefat">
				</div>
				<div class="wc-field" style="margin-top: 6px;">
					<label><?php esc_html_e( 'Answer', 'woodmart-child' ); ?></label>
					<textarea name="laser_crafting_builder[faq][items][{{INDEX}}][answer]" rows="2" class="widefat"></textarea>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</script>
	<?php
}

/**
 * Save Product Page Builder Meta (Laser & Crafting)
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function woodmart_child_save_laser_crafting_builder_meta( $post_id, $post ) {
	// Verify nonce
	if ( ! isset( $_POST['woodmart_child_laser_crafting_builder_nonce'] ) || ! wp_verify_nonce( $_POST['woodmart_child_laser_crafting_builder_nonce'], 'woodmart_child_save_laser_crafting_builder_meta' ) ) {
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

	$raw_data = isset( $_POST['laser_crafting_builder'] ) && is_array( $_POST['laser_crafting_builder'] ) ? $_POST['laser_crafting_builder'] : array();

	// Master Landing Page Toggle
	$enable_landing = ! empty( $raw_data['general']['enable_landing'] ) ? '1' : '0';
	update_post_meta( $post_id, '_woodmart_child_laser_crafting_landing_enabled', $enable_landing );

	// Build clean data array
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
		'vat_note'        => sanitize_text_field( $raw_data['general']['vat_note'] ?? '' ),
		'ex_vat_text'     => sanitize_text_field( $raw_data['general']['ex_vat_text'] ?? '' ),
		'warranty_text'   => sanitize_text_field( $raw_data['general']['warranty_text'] ?? '' ),
		'team_quote_text' => sanitize_text_field( $raw_data['general']['team_quote_text'] ?? '' ),
		'guarantees'      => array(),
		'packages'        => array(),
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

	if ( ! empty( $raw_data['general']['packages'] ) && is_array( $raw_data['general']['packages'] ) ) {
		foreach ( $raw_data['general']['packages'] as $pkey => $pdata ) {
			$clean['general']['packages'][ sanitize_key( $pkey ) ] = array(
				'title'       => sanitize_text_field( $pdata['title'] ?? '' ),
				'price'       => sanitize_text_field( $pdata['price'] ?? '' ),
				'badge'       => sanitize_text_field( $pdata['badge'] ?? '' ),
				'description' => sanitize_text_field( $pdata['description'] ?? '' ),
				'bullets'     => sanitize_textarea_field( $pdata['bullets'] ?? '' ),
			);
		}
	}

	if ( ! empty( $raw_data['general']['bundle_addons'] ) && is_array( $raw_data['general']['bundle_addons'] ) ) {
		foreach ( $raw_data['general']['bundle_addons'] as $addon ) {
			if ( ! empty( $addon['title'] ) ) {
				$options_raw = $addon['options'] ?? '';
				$options_arr = array();
				if ( is_array( $options_raw ) ) {
					$options_arr = array_values( array_filter( array_map( 'sanitize_text_field', $options_raw ) ) );
				} elseif ( is_string( $options_raw ) && '' !== trim( $options_raw ) ) {
					$parts       = explode( ',', $options_raw );
					$options_arr = array_values( array_filter( array_map( 'sanitize_text_field', array_map( 'trim', $parts ) ) ) );
				}

				$clean['general']['bundle_addons'][] = array(
					'id'            => sanitize_title( $addon['title'] ),
					'title'         => sanitize_text_field( $addon['title'] ?? '' ),
					'badge'         => sanitize_text_field( $addon['badge'] ?? '' ),
					'price'         => sanitize_text_field( $addon['price'] ?? '' ),
					'regular_price' => sanitize_text_field( $addon['regular_price'] ?? '' ),
					'description'   => sanitize_text_field( $addon['description'] ?? '' ),
					'product_id'    => ! empty( $addon['product_id'] ) ? absint( $addon['product_id'] ) : 0,
					'options'       => $options_arr,
					'image'         => esc_url_raw( $addon['image'] ?? '' ),
				);
			}
		}
	}

	// 2. Overview Banner & Video
	$clean['overview'] = array(
		'brand_title'    => sanitize_text_field( $raw_data['overview']['brand_title'] ?? '' ),
		'title'          => sanitize_text_field( $raw_data['overview']['title'] ?? '' ),
		'banner_image'   => esc_url_raw( $raw_data['overview']['banner_image'] ?? '' ),
		'video_url'      => esc_url_raw( $raw_data['overview']['video_url'] ?? '' ),
		'video_btn_text' => sanitize_text_field( $raw_data['overview']['video_btn_text'] ?? '' ),
	);

	// Backward compatibility with 'highlights'
	$clean['highlights'] = array(
		'enabled'        => '1',
		'eyebrow'        => sanitize_text_field( $raw_data['overview']['brand_title'] ?? '' ),
		'title'          => sanitize_text_field( $raw_data['overview']['title'] ?? '' ),
		'banner_image'   => esc_url_raw( $raw_data['overview']['banner_image'] ?? '' ),
		'video_url'      => esc_url_raw( $raw_data['overview']['video_url'] ?? '' ),
		'video_btn_text' => sanitize_text_field( $raw_data['overview']['video_btn_text'] ?? '' ),
	);

	// 3. Why Choose A2L
	$clean['why_choose'] = array(
		'title' => sanitize_text_field( $raw_data['why_choose']['title'] ?? '' ),
		'items' => array(),
	);
	if ( ! empty( $raw_data['why_choose']['items'] ) && is_array( $raw_data['why_choose']['items'] ) ) {
		foreach ( $raw_data['why_choose']['items'] as $wi ) {
			if ( ! empty( $wi['title'] ) ) {
				$clean['why_choose']['items'][] = array(
					'title' => sanitize_text_field( $wi['title'] ?? '' ),
					'sub'   => sanitize_text_field( $wi['sub'] ?? '' ),
					'badge' => sanitize_text_field( $wi['badge'] ?? '' ),
					'image' => esc_url_raw( $wi['image'] ?? '' ),
				);
			}
		}
	}

	// 4. Community Slider
	$clean['community_slider'] = array(
		'eyebrow' => sanitize_text_field( $raw_data['community_slider']['eyebrow'] ?? '' ),
		'title'   => sanitize_text_field( $raw_data['community_slider']['title'] ?? '' ),
		'items'   => array(),
	);
	if ( ! empty( $raw_data['community_slider']['items'] ) && is_array( $raw_data['community_slider']['items'] ) ) {
		foreach ( $raw_data['community_slider']['items'] as $si ) {
			if ( ! empty( $si['title'] ) ) {
				$clean['community_slider']['items'][] = array(
					'title' => sanitize_text_field( $si['title'] ?? '' ),
					'badge' => sanitize_text_field( $si['badge'] ?? '' ),
					'desc'  => sanitize_text_field( $si['desc'] ?? '' ),
					'image' => esc_url_raw( $si['image'] ?? '' ),
				);
			}
		}
	}

	// 5. Oversized Build Volume
	$clean['build_volume'] = array(
		'eyebrow'     => sanitize_text_field( $raw_data['build_volume']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['build_volume']['title'] ?? '' ),
		'desc'        => sanitize_textarea_field( $raw_data['build_volume']['desc'] ?? '' ),
		'dim_w'       => sanitize_text_field( $raw_data['build_volume']['dim_w'] ?? '' ),
		'dim_d'       => sanitize_text_field( $raw_data['build_volume']['dim_d'] ?? '' ),
		'dim_h'       => sanitize_text_field( $raw_data['build_volume']['dim_h'] ?? '' ),
		'machine_tag' => sanitize_text_field( $raw_data['build_volume']['machine_tag'] ?? '' ),
		'a1_sub'      => sanitize_text_field( $raw_data['build_volume']['a1_sub'] ?? '' ),
		'a1_image'    => esc_url_raw( $raw_data['build_volume']['a1_image'] ?? '' ),
		'a2l_sub'     => sanitize_text_field( $raw_data['build_volume']['a2l_sub'] ?? '' ),
		'a2l_image'   => esc_url_raw( $raw_data['build_volume']['a2l_image'] ?? '' ),
	);

	// 6. Modular Add-ons
	$clean['modular_addons'] = array(
		'enabled'     => '1',
		'eyebrow'     => sanitize_text_field( $raw_data['modular_addons']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['modular_addons']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['modular_addons']['description'] ?? '' ),
		'tools'       => array(),
	);
	if ( ! empty( $raw_data['modular_addons']['tools'] ) && is_array( $raw_data['modular_addons']['tools'] ) ) {
		foreach ( $raw_data['modular_addons']['tools'] as $t ) {
			if ( ! empty( $t['title'] ) ) {
				$clean['modular_addons']['tools'][] = array(
					'title'    => sanitize_text_field( $t['title'] ?? '' ),
					'subtitle' => sanitize_text_field( $t['subtitle'] ?? '' ),
					'tag'      => sanitize_text_field( $t['tag'] ?? '' ),
					'image'    => esc_url_raw( $t['image'] ?? '' ),
				);
			}
		}
	}

	// 7. Motion Stability
	$clean['motion_stability'] = array(
		'enabled'        => '1',
		'eyebrow'        => sanitize_text_field( $raw_data['motion_stability']['eyebrow'] ?? '' ),
		'title'          => sanitize_text_field( $raw_data['motion_stability']['title'] ?? '' ),
		'tab1_title'     => sanitize_text_field( $raw_data['motion_stability']['tab1_title'] ?? '' ),
		'tab1_desc'      => sanitize_textarea_field( $raw_data['motion_stability']['tab1_desc'] ?? '' ),
		'img_off'        => esc_url_raw( $raw_data['motion_stability']['img_off'] ?? '' ),
		'img_on'         => esc_url_raw( $raw_data['motion_stability']['img_on'] ?? '' ),
		'tab2_title'     => sanitize_text_field( $raw_data['motion_stability']['tab2_title'] ?? '' ),
		'tab2_desc'      => sanitize_textarea_field( $raw_data['motion_stability']['tab2_desc'] ?? '' ),
		'img_damper'     => esc_url_raw( $raw_data['motion_stability']['img_damper'] ?? '' ),
	);

	// 8. Multi-Color & AMS
	$clean['ams_multicolor'] = array(
		'enabled'           => '1',
		'eyebrow'           => sanitize_text_field( $raw_data['ams_multicolor']['eyebrow'] ?? '' ),
		'title'             => sanitize_text_field( $raw_data['ams_multicolor']['title'] ?? '' ),
		'description'       => sanitize_textarea_field( $raw_data['ams_multicolor']['description'] ?? '' ),
		'hero_badge'        => sanitize_text_field( $raw_data['ams_multicolor']['hero_badge'] ?? '' ),
		'hero_img'          => esc_url_raw( $raw_data['ams_multicolor']['hero_img'] ?? '' ),
		'sub1_title'        => sanitize_text_field( $raw_data['ams_multicolor']['sub1_title'] ?? '' ),
		'sub1_img'          => esc_url_raw( $raw_data['ams_multicolor']['sub1_img'] ?? '' ),
		'sub2_title'        => sanitize_text_field( $raw_data['ams_multicolor']['sub2_title'] ?? '' ),
		'sub2_img'          => esc_url_raw( $raw_data['ams_multicolor']['sub2_img'] ?? '' ),
		'ams_diagram_title' => sanitize_text_field( $raw_data['ams_multicolor']['ams_diagram_title'] ?? '' ),
		'ams_diagram_desc'  => sanitize_textarea_field( $raw_data['ams_multicolor']['ams_diagram_desc'] ?? '' ),
		'ams_diagram_pills' => sanitize_text_field( $raw_data['ams_multicolor']['ams_diagram_pills'] ?? '' ),
		'ams_diagram_img'   => esc_url_raw( $raw_data['ams_multicolor']['ams_diagram_img'] ?? '' ),
		'autopilot_eyebrow' => sanitize_text_field( $raw_data['ams_multicolor']['autopilot_eyebrow'] ?? '' ),
		'autopilot_title'   => sanitize_text_field( $raw_data['ams_multicolor']['autopilot_title'] ?? '' ),
		'autopilot_desc'    => sanitize_textarea_field( $raw_data['ams_multicolor']['autopilot_desc'] ?? '' ),
		'img_clumping'      => esc_url_raw( $raw_data['ams_multicolor']['img_clumping'] ?? '' ),
		'img_grinding'      => esc_url_raw( $raw_data['ams_multicolor']['img_grinding'] ?? '' ),
		'img_airprint'      => esc_url_raw( $raw_data['ams_multicolor']['img_airprint'] ?? '' ),
	);

	// 9. Flow Dynamics Calibration
	$clean['flow_calibration'] = array(
		'eyebrow'     => sanitize_text_field( $raw_data['flow_calibration']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['flow_calibration']['title'] ?? '' ),
		'status_text' => sanitize_text_field( $raw_data['flow_calibration']['status_text'] ?? '' ),
		'a2l_image'   => esc_url_raw( $raw_data['flow_calibration']['a2l_image'] ?? '' ),
		'other_image' => esc_url_raw( $raw_data['flow_calibration']['other_image'] ?? '' ),
	);

	// 10. Clean Air
	$clean['clean_air'] = array(
		'eyebrow'         => sanitize_text_field( $raw_data['clean_air']['eyebrow'] ?? '' ),
		'title'           => sanitize_text_field( $raw_data['clean_air']['title'] ?? '' ),
		'lifestyle_image' => esc_url_raw( $raw_data['clean_air']['lifestyle_image'] ?? '' ),
	);

	// 11. Silence
	$clean['silence'] = array(
		'eyebrow' => sanitize_text_field( $raw_data['silence']['eyebrow'] ?? '' ),
		'title'   => sanitize_text_field( $raw_data['silence']['title'] ?? '' ),
		'metric'  => sanitize_text_field( $raw_data['silence']['metric'] ?? '' ),
		'image'   => esc_url_raw( $raw_data['silence']['image'] ?? '' ),
	);

	// 12. Connectivity
	$clean['connectivity'] = array(
		'eyebrow' => sanitize_text_field( $raw_data['connectivity']['eyebrow'] ?? '' ),
		'title'   => sanitize_text_field( $raw_data['connectivity']['title'] ?? '' ),
		'image'   => esc_url_raw( $raw_data['connectivity']['image'] ?? '' ),
	);

	// 13. Unboxing Video
	$clean['unboxing_video'] = array(
		'title'        => sanitize_text_field( $raw_data['unboxing_video']['title'] ?? '' ),
		'video_url'    => esc_url_raw( $raw_data['unboxing_video']['video_url'] ?? '' ),
		'video_poster' => esc_url_raw( $raw_data['unboxing_video']['video_poster'] ?? '' ),
	);

	// 14. Box Contents Matrix
	$clean['box_contents'] = array(
		'enabled'  => '1',
		'eyebrow'  => sanitize_text_field( $raw_data['box_contents']['eyebrow'] ?? '' ),
		'title'    => sanitize_text_field( $raw_data['box_contents']['title'] ?? '' ),
		'packages' => array( 'A2L', 'A2L Combo', 'A2L Cutting Full Combo' ),
		'items'    => array(),
	);
	if ( ! empty( $raw_data['box_contents']['items'] ) && is_array( $raw_data['box_contents']['items'] ) ) {
		foreach ( $raw_data['box_contents']['items'] as $bi ) {
			if ( ! empty( $bi['name'] ) ) {
				$clean['box_contents']['items'][] = array(
					'name'       => sanitize_text_field( $bi['name'] ?? '' ),
					'standalone' => ! empty( $bi['standalone'] ) ? '1' : '0',
					'combo'      => ! empty( $bi['combo'] ) ? '1' : '0',
					'full_combo' => ! empty( $bi['full_combo'] ) ? '1' : '0',
				);
			}
		}
	}

	// 15. Specs
	$clean['specs'] = array(
		'enabled' => '1',
		'eyebrow' => sanitize_text_field( $raw_data['specs']['eyebrow'] ?? '' ),
		'title'   => sanitize_text_field( $raw_data['specs']['title'] ?? '' ),
		'items'   => array(),
	);
	if ( ! empty( $raw_data['specs']['items'] ) && is_array( $raw_data['specs']['items'] ) ) {
		foreach ( $raw_data['specs']['items'] as $sp ) {
			if ( ! empty( $sp['label'] ) || ! empty( $sp['value'] ) ) {
				$clean['specs']['items'][] = array(
					'category' => sanitize_text_field( $sp['category'] ?? 'General' ),
					'label'    => sanitize_text_field( $sp['label'] ?? '' ),
					'value'    => sanitize_text_field( $sp['value'] ?? '' ),
				);
			}
		}
	}

	// 16. FAQ & CTA
	$clean['faq'] = array(
		'enabled' => '1',
		'eyebrow' => sanitize_text_field( $raw_data['faq']['eyebrow'] ?? '' ),
		'title'   => sanitize_text_field( $raw_data['faq']['title'] ?? '' ),
		'items'   => array(),
		'cta'     => array(
			'enabled'  => '1',
			'badge'    => sanitize_text_field( $raw_data['faq']['cta']['badge'] ?? '' ),
			'title'    => sanitize_text_field( $raw_data['faq']['cta']['title'] ?? '' ),
			'subtitle' => sanitize_textarea_field( $raw_data['faq']['cta']['subtitle'] ?? '' ),
			'btn_text' => sanitize_text_field( $raw_data['faq']['cta']['btn_text'] ?? '' ),
			'btn_url'  => esc_url_raw( $raw_data['faq']['cta']['btn_url'] ?? '#laser-crafting-hero' ),
		),
	);
	if ( ! empty( $raw_data['faq']['items'] ) && is_array( $raw_data['faq']['items'] ) ) {
		foreach ( $raw_data['faq']['items'] as $fi ) {
			if ( ! empty( $fi['question'] ) || ! empty( $fi['answer'] ) ) {
				$clean['faq']['items'][] = array(
					'question' => sanitize_text_field( $fi['question'] ?? '' ),
					'answer'   => sanitize_textarea_field( $fi['answer'] ?? '' ),
				);
			}
		}
	}

	// Save main Laser & Crafting settings
	update_post_meta( $post_id, '_woodmart_child_laser_crafting_builder', $clean );
}
add_action( 'save_post_product', 'woodmart_child_save_laser_crafting_builder_meta', 10, 2 );
