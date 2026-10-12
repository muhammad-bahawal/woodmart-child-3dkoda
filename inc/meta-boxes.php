<?php
/**
 * Native Custom Meta Box: Product Page Builder
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Product Page Builder Meta Box (3D Printer)
 */
function woodmart_child_register_product_builder_meta_box() {
	add_meta_box(
		'woodmart_child_product_builder',
		__( 'Product Page Builder - 3D Printer (Apple / Bambu Lab Style)', 'woodmart-child' ),
		'woodmart_child_render_product_builder_meta_box',
		'product',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'woodmart_child_register_product_builder_meta_box' );

/**
 * Render Product Page Builder Meta Box (3D Printer)
 *
 * @param WP_Post $post Current post object.
 */
function woodmart_child_render_product_builder_meta_box( $post ) {
	wp_nonce_field( 'woodmart_child_save_builder_meta', 'woodmart_child_builder_nonce' );

	$settings = woodmart_child_get_builder_settings( $post->ID );
	$enabled_landing = get_post_meta( $post->ID, '_woodmart_child_custom_landing_enabled', true );
	if ( '' === $enabled_landing ) {
		$enabled_landing = isset( $settings['general']['enable_landing'] ) ? $settings['general']['enable_landing'] : '1';
	}
	?>
	<div class="wc-builder-wrap">
		<!-- Master Switch Header -->
		<div class="wc-builder-master-bar">
			<label class="wc-builder-master-toggle">
				<input type="checkbox" name="builder[general][enable_landing]" value="1" <?php checked( $enabled_landing, '1' ); ?>>
				<span class="wc-toggle-slider"></span>
				<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable 3D Printer Landing Page', 'woodmart-child' ); ?></strong> (<?php esc_html_e( 'Replaces default WooCommerce single product layout with custom 3D printer canvas while preserving the global site header and footer', 'woodmart-child' ); ?>)</span>

			</label>
		</div>

		<div class="wc-builder-body">
			<!-- Tab Navigation -->
			<nav class="wc-builder-tabs-nav" role="tablist">
				<button type="button" class="wc-tab-btn active" data-tab="tab-general"><span class="dashicons dashicons-admin-settings"></span> <?php esc_html_e( 'General & Nav', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-highlights"><span class="dashicons dashicons-chart-bar"></span> <?php esc_html_e( 'Highlights', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-features"><span class="dashicons dashicons-star-filled"></span> <?php esc_html_e( 'Features', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-materials"><span class="dashicons dashicons-art"></span> <?php esc_html_e( 'Materials', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-use-cases"><span class="dashicons dashicons-grid-view"></span> <?php esc_html_e( 'Use Cases', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-packages"><span class="dashicons dashicons-columns"></span> <?php esc_html_e( 'Packages & Brand', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-specs"><span class="dashicons dashicons-clipboard"></span> <?php esc_html_e( 'Technical Specs', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-box-contents"><span class="dashicons dashicons-archive"></span> <?php esc_html_e( "What's in the Box", 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-faq"><span class="dashicons dashicons-format-chat"></span> <?php esc_html_e( 'FAQ & CTA', 'woodmart-child' ); ?></button>
			</nav>

			<!-- Tab Panels -->
			<div class="wc-builder-tabs-content">

				<!-- 1. GENERAL & NAV -->
				<section class="wc-tab-panel active" id="tab-general">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'General & Navigation Settings', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Manage brand labels, top announcement bar, reseller authentication strip, and team quote link.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Hero Eyebrow Text', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[general][eyebrow]" value="<?php echo esc_attr( $settings['general']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Brand Name', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[general][brand_name]" value="<?php echo esc_attr( $settings['general']['brand_name'] ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Reseller / Authentication Badge', 'woodmart-child' ); ?></label>
						<input type="text" name="builder[general][badge_text]" value="<?php echo esc_attr( $settings['general']['badge_text'] ); ?>" class="widefat">
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Reseller Banner Strip Text (HTML Allowed)', 'woodmart-child' ); ?></label>
						<textarea name="builder[general][reseller_strip]" rows="2" class="widefat"><?php echo esc_textarea( $settings['general']['reseller_strip'] ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Announcement Bar (Top Strip)', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-3">
						<div class="wc-field">
							<label><?php esc_html_e( 'Left Notification', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[general][announcement_left]" value="<?php echo esc_attr( $settings['general']['announcement_left'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Center / Region Info', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[general][announcement_mid]" value="<?php echo esc_attr( $settings['general']['announcement_mid'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Right / Tax Info', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[general][announcement_right]" value="<?php echo esc_attr( $settings['general']['announcement_right'] ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Service Benefits Highlights (Hero Strip)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="benefits-repeater">
						<?php
						$benefits = ! empty( $settings['general']['benefits'] ) ? $settings['general']['benefits'] : array();
						foreach ( $benefits as $idx => $b ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-2">
									<div class="wc-field">
										<label><?php esc_html_e( 'Highlight Title', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[general][benefits][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $b['title'] ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[general][benefits][<?php echo esc_attr( $idx ); ?>][subtitle]" value="<?php echo esc_attr( $b['subtitle'] ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="benefits-repeater" data-template="tmpl-benefit-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Service Highlight', 'woodmart-child' ); ?>
					</button>

					<div class="wc-field" style="margin-top:16px;">
						<label><?php esc_html_e( 'Team Quote Prompt (Under Hero Add to Cart)', 'woodmart-child' ); ?></label>
						<textarea name="builder[general][team_quote_text]" rows="2" class="widefat"><?php echo esc_textarea( $settings['general']['team_quote_text'] ); ?></textarea>
					</div>
				</section>

				<!-- 2. HIGHLIGHTS / STATS -->
				<section class="wc-tab-panel" id="tab-highlights">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="builder[highlights][enabled]" value="1" <?php checked( ! empty( $settings['highlights']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Highlights / Big Stats Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[highlights][eyebrow]" value="<?php echo esc_attr( $settings['highlights']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<textarea name="builder[highlights][title]" rows="2" class="widefat"><?php echo esc_textarea( $settings['highlights']['title'] ); ?></textarea>
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Description', 'woodmart-child' ); ?></label>
						<textarea name="builder[highlights][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['highlights']['description'] ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Stats Highlights (Repeater)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="highlights-repeater">
						<?php
						$h_items = ! empty( $settings['highlights']['items'] ) ? $settings['highlights']['items'] : array();
						foreach ( $h_items as $idx => $item ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-2">
									<div class="wc-field">
										<label><?php esc_html_e( 'Big Stat / Value (e.g. 256³ mm)', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[highlights][items][<?php echo esc_attr( $idx ); ?>][value]" value="<?php echo esc_attr( $item['value'] ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Label (e.g. build volume)', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[highlights][items][<?php echo esc_attr( $idx ); ?>][label]" value="<?php echo esc_attr( $item['label'] ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="highlights-repeater" data-template="tmpl-highlight-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Stat Row', 'woodmart-child' ); ?>
					</button>
				</section>

				<!-- 3. FEATURES -->
				<section class="wc-tab-panel" id="tab-features">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="builder[features][enabled]" value="1" <?php checked( ! empty( $settings['features']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Features Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[features][eyebrow]" value="<?php echo esc_attr( $settings['features']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<textarea name="builder[features][title]" rows="2" class="widefat"><?php echo esc_textarea( $settings['features']['title'] ); ?></textarea>
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Description', 'woodmart-child' ); ?></label>
						<textarea name="builder[features][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['features']['description'] ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Main Hero Feature (01)', 'woodmart-child' ); ?></h4>
					<div class="wc-card-box">
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Feature Number / Eyebrow', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[features][main][num]" value="<?php echo esc_attr( $settings['features']['main']['num'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Main Feature Title', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[features][main][title]" value="<?php echo esc_attr( $settings['features']['main']['title'] ); ?>" class="widefat">
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
							<textarea name="builder[features][main][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['features']['main']['description'] ); ?></textarea>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Bullet Points (One per line)', 'woodmart-child' ); ?></label>
							<textarea name="builder[features][main][bullets]" rows="3" class="widefat"><?php echo esc_textarea( $settings['features']['main']['bullets'] ); ?></textarea>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Feature Image Upload', 'woodmart-child' ); ?></label>
							<div class="wc-image-picker">
								<input type="hidden" name="builder[features][main][image]" value="<?php echo esc_attr( $settings['features']['main']['image'] ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $settings['features']['main']['image'] ) ) : ?><img src="<?php echo esc_url( $settings['features']['main']['image'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $settings['features']['main']['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Feature Grid Cards (Repeater)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="features-grid-repeater">
						<?php
						$f_grid = ! empty( $settings['features']['grid'] ) ? $settings['features']['grid'] : array();
						foreach ( $f_grid as $idx => $fg ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field" style="max-width:90px;">
										<label><?php esc_html_e( 'Num / Tag', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[features][grid][<?php echo esc_attr( $idx ); ?>][num]" value="<?php echo esc_attr( $fg['num'] ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[features][grid][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $fg['title'] ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
										<textarea name="builder[features][grid][<?php echo esc_attr( $idx ); ?>][description]" rows="2" class="widefat"><?php echo esc_textarea( $fg['description'] ); ?></textarea>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="features-grid-repeater" data-template="tmpl-feature-grid-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Feature Card', 'woodmart-child' ); ?>
					</button>
				</section>

				<!-- 4. MATERIALS -->
				<section class="wc-tab-panel" id="tab-materials">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="builder[materials][enabled]" value="1" <?php checked( ! empty( $settings['materials']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Materials Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[materials][eyebrow]" value="<?php echo esc_attr( $settings['materials']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<textarea name="builder[materials][title]" rows="2" class="widefat"><?php echo esc_textarea( $settings['materials']['title'] ); ?></textarea>
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Description', 'woodmart-child' ); ?></label>
						<textarea name="builder[materials][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['materials']['description'] ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Supported Materials (Repeater with Color Dot & wp.media)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="materials-repeater">
						<?php
						$m_items = ! empty( $settings['materials']['items'] ) ? $settings['materials']['items'] : array();
						foreach ( $m_items as $idx => $m ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields">
									<div class="wc-field-row grid-3">
										<div class="wc-field">
											<label><?php esc_html_e( 'Color Indicator (Hex)', 'woodmart-child' ); ?></label>
											<div class="wc-color-field-wrap">
												<input type="color" class="wc-color-picker-input" value="<?php echo esc_attr( $m['color'] ?: '#ff6b57' ); ?>" onchange="this.nextElementSibling.value=this.value;">
												<input type="text" name="builder[materials][items][<?php echo esc_attr( $idx ); ?>][color]" value="<?php echo esc_attr( $m['color'] ); ?>" class="widefat">
											</div>
										</div>
										<div class="wc-field">
											<label><?php esc_html_e( 'Material Name (e.g. PLA)', 'woodmart-child' ); ?></label>
											<input type="text" name="builder[materials][items][<?php echo esc_attr( $idx ); ?>][name]" value="<?php echo esc_attr( $m['name'] ); ?>" class="widefat">
										</div>
										<div class="wc-field">
											<label><?php esc_html_e( 'Subtitle (e.g. Fast concepts)', 'woodmart-child' ); ?></label>
											<input type="text" name="builder[materials][items][<?php echo esc_attr( $idx ); ?>][subtitle]" value="<?php echo esc_attr( $m['subtitle'] ); ?>" class="widefat">
										</div>
									</div>
									<div class="wc-field" style="margin-top:8px;">
										<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
										<textarea name="builder[materials][items][<?php echo esc_attr( $idx ); ?>][description]" rows="2" class="widefat"><?php echo esc_textarea( $m['description'] ); ?></textarea>
									</div>
									<div class="wc-field" style="margin-top:8px;">
										<label><?php esc_html_e( 'Optional Image (wp.media)', 'woodmart-child' ); ?></label>
										<div class="wc-image-picker">
											<input type="hidden" name="builder[materials][items][<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( isset( $m['image'] ) ? $m['image'] : '' ); ?>" class="wc-image-url">
											<div class="wc-image-preview"><?php if ( ! empty( $m['image'] ) ) : ?><img src="<?php echo esc_url( $m['image'] ); ?>"><?php endif; ?></div>
											<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
											<button type="button" class="button wc-btn-remove-image <?php echo empty( $m['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
										</div>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="materials-repeater" data-template="tmpl-material-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Material Card', 'woodmart-child' ); ?>
					</button>

					<h4 class="wc-subhead"><?php esc_html_e( 'Combo Multi-Material Promo Banner (Under Materials)', 'woodmart-child' ); ?></h4>
					<div class="wc-card-box">
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Banner Eyebrow', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[materials][combo][eyebrow]" value="<?php echo esc_attr( $settings['materials']['combo']['eyebrow'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Banner Title', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[materials][combo][title]" value="<?php echo esc_attr( $settings['materials']['combo']['title'] ); ?>" class="widefat">
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
							<textarea name="builder[materials][combo][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['materials']['combo']['description'] ); ?></textarea>
						</div>
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Link Text', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[materials][combo][link_text]" value="<?php echo esc_attr( $settings['materials']['combo']['link_text'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Link URL', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[materials][combo][link_url]" value="<?php echo esc_attr( $settings['materials']['combo']['link_url'] ); ?>" class="widefat">
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Combo Banner Image (wp.media)', 'woodmart-child' ); ?></label>
							<div class="wc-image-picker">
								<input type="hidden" name="builder[materials][combo][image]" value="<?php echo esc_attr( $settings['materials']['combo']['image'] ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $settings['materials']['combo']['image'] ) ) : ?><img src="<?php echo esc_url( $settings['materials']['combo']['image'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $settings['materials']['combo']['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
					</div>
				</section>

				<!-- 5. USE CASES -->
				<section class="wc-tab-panel" id="tab-use-cases">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="builder[use_cases][enabled]" value="1" <?php checked( ! empty( $settings['use_cases']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Use Cases Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[use_cases][eyebrow]" value="<?php echo esc_attr( $settings['use_cases']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<textarea name="builder[use_cases][title]" rows="2" class="widefat"><?php echo esc_textarea( $settings['use_cases']['title'] ); ?></textarea>
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Use Case Cards (Repeater)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="use-cases-repeater">
						<?php
						$uc_items = ! empty( $settings['use_cases']['items'] ) ? $settings['use_cases']['items'] : array();
						foreach ( $uc_items as $idx => $uc ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-3">
									<div class="wc-field" style="max-width:80px;">
										<label><?php esc_html_e( 'Num / ID', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[use_cases][items][<?php echo esc_attr( $idx ); ?>][num]" value="<?php echo esc_attr( $uc['num'] ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[use_cases][items][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $uc['title'] ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
										<textarea name="builder[use_cases][items][<?php echo esc_attr( $idx ); ?>][description]" rows="2" class="widefat"><?php echo esc_textarea( $uc['description'] ); ?></textarea>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="use-cases-repeater" data-template="tmpl-use-case-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Use Case Card', 'woodmart-child' ); ?>
					</button>
				</section>

				<!-- 6. PACKAGES & BRAND -->
				<section class="wc-tab-panel" id="tab-packages">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="builder[packages][enabled]" value="1" <?php checked( ! empty( $settings['packages']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Comparison Packages & Brand Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[packages][eyebrow]" value="<?php echo esc_attr( $settings['packages']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[packages][title]" value="<?php echo esc_attr( $settings['packages']['title'] ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Subtitle / Description', 'woodmart-child' ); ?></label>
						<input type="text" name="builder[packages][description]" value="<?php echo esc_attr( $settings['packages']['description'] ); ?>" class="widefat">
					</div>

					<div class="wc-field-row grid-2">
						<!-- Standalone Card -->
						<div class="wc-card-box">
							<h4><?php esc_html_e( '1. Standalone Package Card', 'woodmart-child' ); ?></h4>
							<div class="wc-field">
								<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][standalone][eyebrow]" value="<?php echo esc_attr( $settings['packages']['standalone']['eyebrow'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][standalone][title]" value="<?php echo esc_attr( $settings['packages']['standalone']['title'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Price Note', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][standalone][price_note]" value="<?php echo esc_attr( $settings['packages']['standalone']['price_note'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Short Description', 'woodmart-child' ); ?></label>
								<textarea name="builder[packages][standalone][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['packages']['standalone']['description'] ); ?></textarea>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Bullets (One per line)', 'woodmart-child' ); ?></label>
								<textarea name="builder[packages][standalone][bullets]" rows="4" class="widefat"><?php echo esc_textarea( $settings['packages']['standalone']['bullets'] ); ?></textarea>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Button Text', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][standalone][btn_text]" value="<?php echo esc_attr( $settings['packages']['standalone']['btn_text'] ); ?>" class="widefat">
							</div>
						</div>

						<!-- Combo Card -->
						<div class="wc-card-box">
							<h4><?php esc_html_e( '2. Combo Package Card (Recommended)', 'woodmart-child' ); ?></h4>
							<div class="wc-field">
								<label><?php esc_html_e( 'Badge Tag', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][combo][badge]" value="<?php echo esc_attr( $settings['packages']['combo']['badge'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][combo][eyebrow]" value="<?php echo esc_attr( $settings['packages']['combo']['eyebrow'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][combo][title]" value="<?php echo esc_attr( $settings['packages']['combo']['title'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Price Note', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][combo][price_note]" value="<?php echo esc_attr( $settings['packages']['combo']['price_note'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Short Description', 'woodmart-child' ); ?></label>
								<textarea name="builder[packages][combo][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['packages']['combo']['description'] ); ?></textarea>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Bullets (One per line)', 'woodmart-child' ); ?></label>
								<textarea name="builder[packages][combo][bullets]" rows="4" class="widefat"><?php echo esc_textarea( $settings['packages']['combo']['bullets'] ); ?></textarea>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Button Text', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][combo][btn_text]" value="<?php echo esc_attr( $settings['packages']['combo']['btn_text'] ); ?>" class="widefat">
							</div>
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Local Reseller Brand Difference Section', 'woodmart-child' ); ?></h4>
					<div class="wc-card-box">
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Brand Eyebrow', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][brand][eyebrow]" value="<?php echo esc_attr( $settings['packages']['brand']['eyebrow'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Brand Title', 'woodmart-child' ); ?></label>
								<textarea name="builder[packages][brand][title]" rows="2" class="widefat"><?php echo esc_textarea( $settings['packages']['brand']['title'] ); ?></textarea>
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Brand Description', 'woodmart-child' ); ?></label>
							<textarea name="builder[packages][brand][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['packages']['brand']['description'] ); ?></textarea>
						</div>
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Button Text', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][brand][btn_text]" value="<?php echo esc_attr( $settings['packages']['brand']['btn_text'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Button Link', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[packages][brand][btn_url]" value="<?php echo esc_attr( $settings['packages']['brand']['btn_url'] ); ?>" class="widefat">
							</div>
						</div>

						<h5 style="margin:16px 0 8px;"><?php esc_html_e( '4 Pillar Benefit Cards', 'woodmart-child' ); ?></h5>
						<div class="wc-repeater-container" id="brand-cards-repeater">
							<?php
							$b_cards = ! empty( $settings['packages']['brand']['cards'] ) ? $settings['packages']['brand']['cards'] : array();
							foreach ( $b_cards as $idx => $bc ) :
							?>
								<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
									<span class="wc-row-drag">☰</span>
									<div class="wc-repeater-fields grid-2">
										<div class="wc-field">
											<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
											<input type="text" name="builder[packages][brand][cards][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $bc['title'] ); ?>" class="widefat">
										</div>
										<div class="wc-field">
											<label><?php esc_html_e( 'Card Description', 'woodmart-child' ); ?></label>
											<input type="text" name="builder[packages][brand][cards][<?php echo esc_attr( $idx ); ?>][description]" value="<?php echo esc_attr( $bc['description'] ); ?>" class="widefat">
										</div>
									</div>
									<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
								</div>
							<?php endforeach; ?>
						</div>
						<button type="button" class="button button-secondary wc-btn-add-row" data-target="brand-cards-repeater" data-template="tmpl-brand-card-row">
							<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Pillar Card', 'woodmart-child' ); ?>
						</button>
					</div>
				</section>

				<!-- 7. TECHNICAL SPECIFICATIONS -->
				<section class="wc-tab-panel" id="tab-specs">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="builder[specs][enabled]" value="1" <?php checked( ! empty( $settings['specs']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Technical Specifications Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[specs][eyebrow]" value="<?php echo esc_attr( $settings['specs']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[specs][title]" value="<?php echo esc_attr( $settings['specs']['title'] ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Description', 'woodmart-child' ); ?></label>
						<textarea name="builder[specs][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['specs']['description'] ); ?></textarea>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Footer Note / Disclaimer', 'woodmart-child' ); ?></label>
						<input type="text" name="builder[specs][note]" value="<?php echo esc_attr( $settings['specs']['note'] ); ?>" class="widefat">
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Specifications List (Repeater: Label & Value)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="specs-repeater">
						<?php
						$s_items = ! empty( $settings['specs']['items'] ) ? $settings['specs']['items'] : array();
						foreach ( $s_items as $idx => $s ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-2">
									<div class="wc-field">
										<label><?php esc_html_e( 'Spec Name / Label (e.g. Build volume)', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[specs][items][<?php echo esc_attr( $idx ); ?>][label]" value="<?php echo esc_attr( $s['label'] ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Spec Value (e.g. 256 × 256 × 256 mm)', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[specs][items][<?php echo esc_attr( $idx ); ?>][value]" value="<?php echo esc_attr( $s['value'] ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="specs-repeater" data-template="tmpl-spec-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Spec Row', 'woodmart-child' ); ?>
					</button>

					<h4 class="wc-subhead"><?php esc_html_e( 'Setup Guide Callout Box (Under Specs)', 'woodmart-child' ); ?></h4>
					<div class="wc-card-box">
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Callout Eyebrow', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[specs][setup][eyebrow]" value="<?php echo esc_attr( $settings['specs']['setup']['eyebrow'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Callout Title', 'woodmart-child' ); ?></label>
								<textarea name="builder[specs][setup][title]" rows="2" class="widefat"><?php echo esc_textarea( $settings['specs']['setup']['title'] ); ?></textarea>
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
							<textarea name="builder[specs][setup][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['specs']['setup']['description'] ); ?></textarea>
						</div>
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Guide Link Text', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[specs][setup][link_text]" value="<?php echo esc_attr( $settings['specs']['setup']['link_text'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Guide Link URL', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[specs][setup][link_url]" value="<?php echo esc_attr( $settings['specs']['setup']['link_url'] ); ?>" class="widefat">
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Callout Video / Poster Image (wp.media)', 'woodmart-child' ); ?></label>
							<div class="wc-image-picker">
								<input type="hidden" name="builder[specs][setup][image]" value="<?php echo esc_attr( $settings['specs']['setup']['image'] ); ?>" class="wc-image-url">
								<div class="wc-image-preview"><?php if ( ! empty( $settings['specs']['setup']['image'] ) ) : ?><img src="<?php echo esc_url( $settings['specs']['setup']['image'] ); ?>"><?php endif; ?></div>
								<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
								<button type="button" class="button wc-btn-remove-image <?php echo empty( $settings['specs']['setup']['image'] ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
							</div>
						</div>
					</div>
				</section>

				<!-- 8. WHAT'S IN THE BOX -->
				<section class="wc-tab-panel" id="tab-box-contents">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="builder[box_contents][enabled]" value="1" <?php checked( ! empty( $settings['box_contents']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( "Enable What's in the Box Section", 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[box_contents][eyebrow]" value="<?php echo esc_attr( $settings['box_contents']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[box_contents][title]" value="<?php echo esc_attr( $settings['box_contents']['title'] ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Footer Note', 'woodmart-child' ); ?></label>
						<input type="text" name="builder[box_contents][note]" value="<?php echo esc_attr( $settings['box_contents']['note'] ); ?>" class="widefat">
					</div>

					<div class="wc-field-row grid-2">
						<!-- Standalone Items List -->
						<div class="wc-card-box">
							<h4><?php esc_html_e( '1. Standalone Package Box Items', 'woodmart-child' ); ?></h4>
							<div class="wc-field" style="margin-bottom:12px;">
								<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[box_contents][standalone_title]" value="<?php echo esc_attr( $settings['box_contents']['standalone_title'] ); ?>" class="widefat">
							</div>
							<div class="wc-repeater-container" id="box-standalone-repeater">
								<?php
								$sa_items = ! empty( $settings['box_contents']['standalone_items'] ) ? $settings['box_contents']['standalone_items'] : array();
								foreach ( $sa_items as $idx => $item ) :
								?>
									<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
										<span class="wc-row-drag">☰</span>
										<div class="wc-repeater-fields">
											<input type="text" name="builder[box_contents][standalone_items][]" value="<?php echo esc_attr( $item ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Item name e.g. 0.4 mm hardened steel hotend', 'woodmart-child' ); ?>">
										</div>
										<button type="button" class="button wc-btn-remove-row">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-secondary wc-btn-add-row" data-target="box-standalone-repeater" data-template="tmpl-box-standalone-row">
								<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Standalone Item', 'woodmart-child' ); ?>
							</button>
						</div>

						<!-- Combo Items List -->
						<div class="wc-card-box">
							<h4><?php esc_html_e( '2. Combo Package Box Items', 'woodmart-child' ); ?></h4>
							<div class="wc-field-row grid-2" style="margin-bottom:12px;">
								<div class="wc-field">
									<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
									<input type="text" name="builder[box_contents][combo_title]" value="<?php echo esc_attr( $settings['box_contents']['combo_title'] ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Badge Tag', 'woodmart-child' ); ?></label>
									<input type="text" name="builder[box_contents][combo_badge]" value="<?php echo esc_attr( $settings['box_contents']['combo_badge'] ); ?>" class="widefat">
								</div>
							</div>
							<div class="wc-repeater-container" id="box-combo-repeater">
								<?php
								$cb_items = ! empty( $settings['box_contents']['combo_items'] ) ? $settings['box_contents']['combo_items'] : array();
								foreach ( $cb_items as $idx => $item ) :
								?>
									<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
										<span class="wc-row-drag">☰</span>
										<div class="wc-repeater-fields">
											<input type="text" name="builder[box_contents][combo_items][]" value="<?php echo esc_attr( $item ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Item name e.g. Automatic Material System (AMS)', 'woodmart-child' ); ?>">
										</div>
										<button type="button" class="button wc-btn-remove-row">&times;</button>
									</div>
								<?php endforeach; ?>
							</div>
							<button type="button" class="button button-secondary wc-btn-add-row" data-target="box-combo-repeater" data-template="tmpl-box-combo-row">
								<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Combo Item', 'woodmart-child' ); ?>
							</button>
						</div>
					</div>
				</section>

				<!-- 9. FAQ & CALL TO ACTION -->
				<section class="wc-tab-panel" id="tab-faq">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="builder[faq][enabled]" value="1" <?php checked( ! empty( $settings['faq']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable FAQ & Bottom CTA Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'FAQ Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[faq][eyebrow]" value="<?php echo esc_attr( $settings['faq']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'FAQ Title', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[faq][title]" value="<?php echo esc_attr( $settings['faq']['title'] ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-3">
						<div class="wc-field">
							<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[faq][description]" value="<?php echo esc_attr( $settings['faq']['description'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Sidebar Button Text', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[faq][btn_text]" value="<?php echo esc_attr( $settings['faq']['btn_text'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Sidebar Button Link', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[faq][btn_url]" value="<?php echo esc_attr( $settings['faq']['btn_url'] ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'FAQ Accordion Items (Repeater: Question & Answer)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="faq-repeater">
						<?php
						$faq_items = ! empty( $settings['faq']['items'] ) ? $settings['faq']['items'] : array();
						foreach ( $faq_items as $idx => $f ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields">
									<div class="wc-field" style="margin-bottom:8px;">
										<label><?php esc_html_e( 'Question', 'woodmart-child' ); ?></label>
										<input type="text" name="builder[faq][items][<?php echo esc_attr( $idx ); ?>][question]" value="<?php echo esc_attr( $f['question'] ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Answer', 'woodmart-child' ); ?></label>
										<textarea name="builder[faq][items][<?php echo esc_attr( $idx ); ?>][answer]" rows="2" class="widefat"><?php echo esc_textarea( $f['answer'] ); ?></textarea>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Question', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="faq-repeater" data-template="tmpl-faq-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add FAQ Item', 'woodmart-child' ); ?>
					</button>

					<h4 class="wc-subhead"><?php esc_html_e( 'Bottom Orange Call to Action Banner', 'woodmart-child' ); ?></h4>
					<div class="wc-card-box">
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'CTA Eyebrow', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[faq][cta][eyebrow]" value="<?php echo esc_attr( $settings['faq']['cta']['eyebrow'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'CTA Title (HTML allowed)', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[faq][cta][title]" value="<?php echo esc_attr( $settings['faq']['cta']['title'] ); ?>" class="widefat">
							</div>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'CTA Description', 'woodmart-child' ); ?></label>
							<input type="text" name="builder[faq][cta][description]" value="<?php echo esc_attr( $settings['faq']['cta']['description'] ); ?>" class="widefat">
						</div>
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Primary Button 1 Text', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[faq][cta][btn1_text]" value="<?php echo esc_attr( $settings['faq']['cta']['btn1_text'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Primary Button 1 URL', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[faq][cta][btn1_url]" value="<?php echo esc_attr( $settings['faq']['cta']['btn1_url'] ); ?>" class="widefat">
							</div>
						</div>
						<div class="wc-field-row grid-2">
							<div class="wc-field">
								<label><?php esc_html_e( 'Secondary Button 2 Text', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[faq][cta][btn2_text]" value="<?php echo esc_attr( $settings['faq']['cta']['btn2_text'] ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Secondary Button 2 URL', 'woodmart-child' ); ?></label>
								<input type="text" name="builder[faq][cta][btn2_url]" value="<?php echo esc_attr( $settings['faq']['cta']['btn2_url'] ); ?>" class="widefat">
							</div>
						</div>
					</div>
				</section>

			</div><!-- .wc-builder-tabs-content -->
		</div><!-- .wc-builder-body -->
	</div><!-- .wc-builder-wrap -->

	<!-- JavaScript Row Templates -->
	<template id="tmpl-highlight-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-2">
				<div class="wc-field">
					<label><?php esc_html_e( 'Big Stat / Value', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[highlights][items][{{INDEX}}][value]" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Label', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[highlights][items][{{INDEX}}][label]" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-feature-grid-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field" style="max-width:90px;">
					<label><?php esc_html_e( 'Num / Tag', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[features][grid][{{INDEX}}][num]" class="widefat" placeholder="02">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[features][grid][{{INDEX}}][title]" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
					<textarea name="builder[features][grid][{{INDEX}}][description]" rows="2" class="widefat"></textarea>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-material-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields">
				<div class="wc-field-row grid-3">
					<div class="wc-field">
						<label><?php esc_html_e( 'Color Indicator (Hex)', 'woodmart-child' ); ?></label>
						<div class="wc-color-field-wrap">
							<input type="color" class="wc-color-picker-input" value="#ff6b57" onchange="this.nextElementSibling.value=this.value;">
							<input type="text" name="builder[materials][items][{{INDEX}}][color]" value="#ff6b57" class="widefat">
						</div>
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Material Name', 'woodmart-child' ); ?></label>
						<input type="text" name="builder[materials][items][{{INDEX}}][name]" class="widefat">
					</div>
					<div class="wc-field">
						<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
						<input type="text" name="builder[materials][items][{{INDEX}}][subtitle]" class="widefat">
					</div>
				</div>
				<div class="wc-field" style="margin-top:8px;">
					<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
					<textarea name="builder[materials][items][{{INDEX}}][description]" rows="2" class="widefat"></textarea>
				</div>
				<div class="wc-field" style="margin-top:8px;">
					<label><?php esc_html_e( 'Optional Image (wp.media)', 'woodmart-child' ); ?></label>
					<div class="wc-image-picker">
						<input type="hidden" name="builder[materials][items][{{INDEX}}][image]" value="" class="wc-image-url">
						<div class="wc-image-preview"></div>
						<button type="button" class="button wc-btn-upload-image"><?php esc_html_e( 'Select Image', 'woodmart-child' ); ?></button>
						<button type="button" class="button wc-btn-remove-image hidden"><?php esc_html_e( 'Remove', 'woodmart-child' ); ?></button>
					</div>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-use-case-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-3">
				<div class="wc-field" style="max-width:80px;">
					<label><?php esc_html_e( 'Num / ID', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[use_cases][items][{{INDEX}}][num]" class="widefat" placeholder="01">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[use_cases][items][{{INDEX}}][title]" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
					<textarea name="builder[use_cases][items][{{INDEX}}][description]" rows="2" class="widefat"></textarea>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-spec-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-2">
				<div class="wc-field">
					<label><?php esc_html_e( 'Spec Name / Label', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[specs][items][{{INDEX}}][label]" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Spec Value', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[specs][items][{{INDEX}}][value]" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-box-standalone-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields">
				<input type="text" name="builder[box_contents][standalone_items][]" class="widefat" placeholder="<?php esc_attr_e( 'Item name', 'woodmart-child' ); ?>">
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-box-combo-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields">
				<input type="text" name="builder[box_contents][combo_items][]" class="widefat" placeholder="<?php esc_attr_e( 'Item name', 'woodmart-child' ); ?>">
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-faq-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields">
				<div class="wc-field" style="margin-bottom:8px;">
					<label><?php esc_html_e( 'Question', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[faq][items][{{INDEX}}][question]" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Answer', 'woodmart-child' ); ?></label>
					<textarea name="builder[faq][items][{{INDEX}}][answer]" rows="2" class="widefat"></textarea>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-benefit-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-2">
				<div class="wc-field">
					<label><?php esc_html_e( 'Highlight Title', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[general][benefits][{{INDEX}}][title]" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[general][benefits][{{INDEX}}][subtitle]" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>

	<template id="tmpl-brand-card-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-2">
				<div class="wc-field">
					<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[packages][brand][cards][{{INDEX}}][title]" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Card Description', 'woodmart-child' ); ?></label>
					<input type="text" name="builder[packages][brand][cards][{{INDEX}}][description]" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row">&times;</button>
		</div>
	</template>
	<?php
}

/**
 * Save Product Page Builder Meta Data
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function woodmart_child_save_product_builder_meta( $post_id, $post ) {
	// Verify nonce
	if ( ! isset( $_POST['woodmart_child_builder_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['woodmart_child_builder_nonce'] ), 'woodmart_child_save_builder_meta' ) ) {
		return;
	}

	// Avoid autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Avoid revisions
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	// Check capability
	if ( ! current_user_can( 'edit_product', $post_id ) && ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Check if builder data was submitted
	if ( ! isset( $_POST['builder'] ) || ! is_array( $_POST['builder'] ) ) {
		return;
	}

	$raw_data = $_POST['builder']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$clean    = array();

	// Master Landing Page Toggle
	$enable_landing = isset( $raw_data['general']['enable_landing'] ) ? '1' : '0';
	update_post_meta( $post_id, '_woodmart_child_custom_landing_enabled', $enable_landing );

	// 1. General
	$clean['general'] = array(
		'enable_landing'     => $enable_landing,
		'eyebrow'            => sanitize_text_field( $raw_data['general']['eyebrow'] ?? '' ),
		'badge_text'         => sanitize_text_field( $raw_data['general']['badge_text'] ?? '' ),
		'brand_name'         => sanitize_text_field( $raw_data['general']['brand_name'] ?? '' ),
		'announcement_left'  => sanitize_text_field( $raw_data['general']['announcement_left'] ?? '' ),
		'announcement_mid'   => sanitize_text_field( $raw_data['general']['announcement_mid'] ?? '' ),
		'announcement_right' => sanitize_text_field( $raw_data['general']['announcement_right'] ?? '' ),
		'reseller_strip'     => wp_kses_post( $raw_data['general']['reseller_strip'] ?? '' ),
		'benefits'           => array(),
		'team_quote_text'    => wp_kses_post( $raw_data['general']['team_quote_text'] ?? '' ),
	);

	if ( ! empty( $raw_data['general']['benefits'] ) && is_array( $raw_data['general']['benefits'] ) ) {
		foreach ( $raw_data['general']['benefits'] as $b ) {
			if ( ! empty( $b['title'] ) ) {
				$clean['general']['benefits'][] = array(
					'title'    => sanitize_text_field( $b['title'] ),
					'subtitle' => sanitize_text_field( $b['subtitle'] ?? '' ),
				);
			}
		}
	}

	// 2. Highlights
	$clean['highlights'] = array(
		'enabled'     => isset( $raw_data['highlights']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['highlights']['eyebrow'] ?? '' ),
		'title'       => sanitize_textarea_field( $raw_data['highlights']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['highlights']['description'] ?? '' ),
		'items'       => array(),
	);

	if ( ! empty( $raw_data['highlights']['items'] ) && is_array( $raw_data['highlights']['items'] ) ) {
		foreach ( $raw_data['highlights']['items'] as $item ) {
			if ( ! empty( $item['value'] ) || ! empty( $item['label'] ) ) {
				$clean['highlights']['items'][] = array(
					'value' => sanitize_text_field( $item['value'] ?? '' ),
					'label' => sanitize_text_field( $item['label'] ?? '' ),
				);
			}
		}
	}

	// 3. Features
	$clean['features'] = array(
		'enabled'     => isset( $raw_data['features']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['features']['eyebrow'] ?? '' ),
		'title'       => sanitize_textarea_field( $raw_data['features']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['features']['description'] ?? '' ),
		'main'        => array(
			'num'         => sanitize_text_field( $raw_data['features']['main']['num'] ?? '01' ),
			'title'       => sanitize_text_field( $raw_data['features']['main']['title'] ?? '' ),
			'description' => sanitize_textarea_field( $raw_data['features']['main']['description'] ?? '' ),
			'bullets'     => sanitize_textarea_field( $raw_data['features']['main']['bullets'] ?? '' ),
			'image'       => esc_url_raw( $raw_data['features']['main']['image'] ?? '' ),
		),
		'grid'        => array(),
	);

	if ( ! empty( $raw_data['features']['grid'] ) && is_array( $raw_data['features']['grid'] ) ) {
		foreach ( $raw_data['features']['grid'] as $fg ) {
			if ( ! empty( $fg['title'] ) ) {
				$clean['features']['grid'][] = array(
					'num'         => sanitize_text_field( $fg['num'] ?? '' ),
					'title'       => sanitize_text_field( $fg['title'] ),
					'description' => sanitize_textarea_field( $fg['description'] ?? '' ),
				);
			}
		}
	}

	// 4. Materials
	$clean['materials'] = array(
		'enabled'     => isset( $raw_data['materials']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['materials']['eyebrow'] ?? '' ),
		'title'       => sanitize_textarea_field( $raw_data['materials']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['materials']['description'] ?? '' ),
		'items'       => array(),
		'combo'       => array(
			'eyebrow'     => sanitize_text_field( $raw_data['materials']['combo']['eyebrow'] ?? '' ),
			'title'       => sanitize_text_field( $raw_data['materials']['combo']['title'] ?? '' ),
			'description' => sanitize_textarea_field( $raw_data['materials']['combo']['description'] ?? '' ),
			'link_text'   => sanitize_text_field( $raw_data['materials']['combo']['link_text'] ?? '' ),
			'link_url'    => esc_url_raw( $raw_data['materials']['combo']['link_url'] ?? '' ),
			'image'       => esc_url_raw( $raw_data['materials']['combo']['image'] ?? '' ),
		),
	);

	if ( ! empty( $raw_data['materials']['items'] ) && is_array( $raw_data['materials']['items'] ) ) {
		foreach ( $raw_data['materials']['items'] as $m ) {
			if ( ! empty( $m['name'] ) ) {
				$clean['materials']['items'][] = array(
					'color'       => sanitize_hex_color( $m['color'] ?? '#ff6b57' ) ?: '#ff6b57',
					'name'        => sanitize_text_field( $m['name'] ),
					'subtitle'    => sanitize_text_field( $m['subtitle'] ?? '' ),
					'description' => sanitize_textarea_field( $m['description'] ?? '' ),
					'image'       => esc_url_raw( $m['image'] ?? '' ),
				);
			}
		}
	}

	// 5. Use Cases
	$clean['use_cases'] = array(
		'enabled' => isset( $raw_data['use_cases']['enabled'] ) ? '1' : '0',
		'eyebrow' => sanitize_text_field( $raw_data['use_cases']['eyebrow'] ?? '' ),
		'title'   => sanitize_textarea_field( $raw_data['use_cases']['title'] ?? '' ),
		'items'   => array(),
	);

	if ( ! empty( $raw_data['use_cases']['items'] ) && is_array( $raw_data['use_cases']['items'] ) ) {
		foreach ( $raw_data['use_cases']['items'] as $uc ) {
			if ( ! empty( $uc['title'] ) ) {
				$clean['use_cases']['items'][] = array(
					'num'         => sanitize_text_field( $uc['num'] ?? '' ),
					'title'       => sanitize_text_field( $uc['title'] ),
					'description' => sanitize_textarea_field( $uc['description'] ?? '' ),
				);
			}
		}
	}

	// 6. Packages & Brand
	$clean['packages'] = array(
		'enabled'     => isset( $raw_data['packages']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['packages']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['packages']['title'] ?? '' ),
		'description' => sanitize_text_field( $raw_data['packages']['description'] ?? '' ),
		'standalone'  => array(
			'eyebrow'     => sanitize_text_field( $raw_data['packages']['standalone']['eyebrow'] ?? '' ),
			'title'       => sanitize_text_field( $raw_data['packages']['standalone']['title'] ?? '' ),
			'price_note'  => sanitize_text_field( $raw_data['packages']['standalone']['price_note'] ?? '' ),
			'description' => sanitize_textarea_field( $raw_data['packages']['standalone']['description'] ?? '' ),
			'bullets'     => sanitize_textarea_field( $raw_data['packages']['standalone']['bullets'] ?? '' ),
			'btn_text'    => sanitize_text_field( $raw_data['packages']['standalone']['btn_text'] ?? '' ),
		),
		'combo'       => array(
			'badge'       => sanitize_text_field( $raw_data['packages']['combo']['badge'] ?? '' ),
			'eyebrow'     => sanitize_text_field( $raw_data['packages']['combo']['eyebrow'] ?? '' ),
			'title'       => sanitize_text_field( $raw_data['packages']['combo']['title'] ?? '' ),
			'price_note'  => sanitize_text_field( $raw_data['packages']['combo']['price_note'] ?? '' ),
			'description' => sanitize_textarea_field( $raw_data['packages']['combo']['description'] ?? '' ),
			'bullets'     => sanitize_textarea_field( $raw_data['packages']['combo']['bullets'] ?? '' ),
			'btn_text'    => sanitize_text_field( $raw_data['packages']['combo']['btn_text'] ?? '' ),
		),
		'brand'       => array(
			'eyebrow'     => sanitize_text_field( $raw_data['packages']['brand']['eyebrow'] ?? '' ),
			'title'       => sanitize_textarea_field( $raw_data['packages']['brand']['title'] ?? '' ),
			'description' => sanitize_textarea_field( $raw_data['packages']['brand']['description'] ?? '' ),
			'btn_text'    => sanitize_text_field( $raw_data['packages']['brand']['btn_text'] ?? '' ),
			'btn_url'     => esc_url_raw( $raw_data['packages']['brand']['btn_url'] ?? '#' ),
			'cards'       => array(),
		),
	);

	if ( ! empty( $raw_data['packages']['brand']['cards'] ) && is_array( $raw_data['packages']['brand']['cards'] ) ) {
		foreach ( $raw_data['packages']['brand']['cards'] as $bc ) {
			if ( ! empty( $bc['title'] ) ) {
				$clean['packages']['brand']['cards'][] = array(
					'title'       => sanitize_text_field( $bc['title'] ),
					'description' => sanitize_text_field( $bc['description'] ?? '' ),
				);
			}
		}
	}

	// 7. Specs
	$clean['specs'] = array(
		'enabled'     => isset( $raw_data['specs']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['specs']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['specs']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['specs']['description'] ?? '' ),
		'note'        => sanitize_text_field( $raw_data['specs']['note'] ?? '' ),
		'items'       => array(),
		'setup'       => array(
			'eyebrow'     => sanitize_text_field( $raw_data['specs']['setup']['eyebrow'] ?? '' ),
			'title'       => sanitize_textarea_field( $raw_data['specs']['setup']['title'] ?? '' ),
			'description' => sanitize_textarea_field( $raw_data['specs']['setup']['description'] ?? '' ),
			'link_text'   => sanitize_text_field( $raw_data['specs']['setup']['link_text'] ?? '' ),
			'link_url'    => esc_url_raw( $raw_data['specs']['setup']['link_url'] ?? '#' ),
			'image'       => esc_url_raw( $raw_data['specs']['setup']['image'] ?? '' ),
		),
	);

	if ( ! empty( $raw_data['specs']['items'] ) && is_array( $raw_data['specs']['items'] ) ) {
		foreach ( $raw_data['specs']['items'] as $s ) {
			if ( ! empty( $s['label'] ) || ! empty( $s['value'] ) ) {
				$clean['specs']['items'][] = array(
					'label' => sanitize_text_field( $s['label'] ?? '' ),
					'value' => sanitize_text_field( $s['value'] ?? '' ),
				);
			}
		}
	}

	// 8. Box Contents
	$clean['box_contents'] = array(
		'enabled'          => isset( $raw_data['box_contents']['enabled'] ) ? '1' : '0',
		'eyebrow'          => sanitize_text_field( $raw_data['box_contents']['eyebrow'] ?? '' ),
		'title'            => sanitize_text_field( $raw_data['box_contents']['title'] ?? '' ),
		'note'             => sanitize_text_field( $raw_data['box_contents']['note'] ?? '' ),
		'standalone_title' => sanitize_text_field( $raw_data['box_contents']['standalone_title'] ?? 'X1–Carbon' ),
		'standalone_items' => array(),
		'combo_title'      => sanitize_text_field( $raw_data['box_contents']['combo_title'] ?? 'X1–Carbon Combo' ),
		'combo_badge'      => sanitize_text_field( $raw_data['box_contents']['combo_badge'] ?? 'RECOMMENDED' ),
		'combo_items'      => array(),
	);

	if ( ! empty( $raw_data['box_contents']['standalone_items'] ) && is_array( $raw_data['box_contents']['standalone_items'] ) ) {
		foreach ( $raw_data['box_contents']['standalone_items'] as $item ) {
			$item_text = sanitize_text_field( $item );
			if ( ! empty( $item_text ) ) {
				$clean['box_contents']['standalone_items'][] = $item_text;
			}
		}
	}

	if ( ! empty( $raw_data['box_contents']['combo_items'] ) && is_array( $raw_data['box_contents']['combo_items'] ) ) {
		foreach ( $raw_data['box_contents']['combo_items'] as $item ) {
			$item_text = sanitize_text_field( $item );
			if ( ! empty( $item_text ) ) {
				$clean['box_contents']['combo_items'][] = $item_text;
			}
		}
	}

	// 9. FAQ & CTA
	$clean['faq'] = array(
		'enabled'     => isset( $raw_data['faq']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['faq']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['faq']['title'] ?? '' ),
		'description' => sanitize_text_field( $raw_data['faq']['description'] ?? '' ),
		'btn_text'    => sanitize_text_field( $raw_data['faq']['btn_text'] ?? '' ),
		'btn_url'     => esc_url_raw( $raw_data['faq']['btn_url'] ?? '#' ),
		'items'       => array(),
		'cta'         => array(
			'eyebrow'     => sanitize_text_field( $raw_data['faq']['cta']['eyebrow'] ?? '' ),
			'title'       => wp_kses_post( $raw_data['faq']['cta']['title'] ?? '' ),
			'description' => sanitize_text_field( $raw_data['faq']['cta']['description'] ?? '' ),
			'btn1_text'   => sanitize_text_field( $raw_data['faq']['cta']['btn1_text'] ?? '' ),
			'btn1_url'    => esc_url_raw( $raw_data['faq']['cta']['btn1_url'] ?? '#' ),
			'btn2_text'   => sanitize_text_field( $raw_data['faq']['cta']['btn2_text'] ?? '' ),
			'btn2_url'    => esc_url_raw( $raw_data['faq']['cta']['btn2_url'] ?? '#' ),
		),
	);

	if ( ! empty( $raw_data['faq']['items'] ) && is_array( $raw_data['faq']['items'] ) ) {
		foreach ( $raw_data['faq']['items'] as $f ) {
			if ( ! empty( $f['question'] ) ) {
				$clean['faq']['items'][] = array(
					'question' => sanitize_text_field( $f['question'] ),
					'answer'   => wp_kses_post( $f['answer'] ?? '' ),
				);
			}
		}
	}

	// Save main array
	update_post_meta( $post_id, '_woodmart_child_product_builder', $clean );
}
add_action( 'save_post_product', 'woodmart_child_save_product_builder_meta', 10, 2 );

/* ==========================================================================
   FILAMENT PRODUCT PAGE BUILDER META BOX
   ========================================================================== */

/**
 * Register Product Page Builder Meta Box (Filament)
 */
function woodmart_child_register_filament_builder_meta_box() {
	add_meta_box(
		'woodmart_child_filament_builder',
		__( 'Product Page Builder - Filament', 'woodmart-child' ),
		'woodmart_child_render_filament_builder_meta_box',
		'product',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'woodmart_child_register_filament_builder_meta_box' );

/**
 * Render Product Page Builder Meta Box (Filament)
 *
 * @param WP_Post $post Current post object.
 */
function woodmart_child_render_filament_builder_meta_box( $post ) {
	wp_nonce_field( 'woodmart_child_save_filament_builder_meta', 'woodmart_child_filament_builder_nonce' );

	$settings = woodmart_child_get_filament_builder_settings( $post->ID );
	$enabled_landing = get_post_meta( $post->ID, '_woodmart_child_filament_landing_enabled', true );
	if ( '' === $enabled_landing ) {
		$enabled_landing = isset( $settings['general']['enable_landing'] ) ? $settings['general']['enable_landing'] : '0';
	}
	?>
	<div class="wc-builder-wrap">
		<!-- Master Switch Header -->
		<div class="wc-builder-master-bar">
			<label class="wc-builder-master-toggle">
				<input type="checkbox" name="filament_builder[general][enable_landing]" value="1" <?php checked( $enabled_landing, '1' ); ?>>
				<span class="wc-toggle-slider"></span>
				<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Filament Landing Page', 'woodmart-child' ); ?></strong> (<?php esc_html_e( 'Replaces default WooCommerce single product layout with custom Filament canvas while preserving the global site header and footer', 'woodmart-child' ); ?>)</span>
			</label>
		</div>

		<div class="wc-builder-body">
			<!-- Tab Navigation -->
			<nav class="wc-builder-tabs-nav" role="tablist">
				<button type="button" class="wc-tab-btn active" data-tab="tab-filament-hero"><span class="dashicons dashicons-art"></span> <?php esc_html_e( 'Hero & Colors', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-additions"><span class="dashicons dashicons-plus-alt"></span> <?php esc_html_e( 'Essential Additions', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-nav"><span class="dashicons dashicons-menu"></span> <?php esc_html_e( 'Sticky Subnav', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-formulation"><span class="dashicons dashicons-format-image"></span> <?php esc_html_e( 'Formulation Banner', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-colors-showcase"><span class="dashicons dashicons-color-picker"></span> <?php esc_html_e( 'Color Showcase', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-materials"><span class="dashicons dashicons-screenoptions"></span> <?php esc_html_e( 'Material Overview', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-rfid-ams"><span class="dashicons dashicons-rss"></span> <?php esc_html_e( 'RFID & AMS', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-use-cases"><span class="dashicons dashicons-grid-view"></span> <?php esc_html_e( 'Use Cases', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-format"><span class="dashicons dashicons-columns"></span> <?php esc_html_e( 'Spool vs Refill', 'woodmart-child' ); ?></button>
				<button type="button" class="wc-tab-btn" data-tab="tab-filament-brand"><span class="dashicons dashicons-awards"></span> <?php esc_html_e( '3DKoda Difference', 'woodmart-child' ); ?></button>
			</nav>

			<!-- Tab Panels -->
			<div class="wc-builder-tabs-content">

				<!-- 1. HERO & COLORS -->
				<section class="wc-tab-panel active" id="tab-filament-hero">
					<div class="wc-panel-head">
						<h3><?php esc_html_e( 'Filament Hero & Settings', 'woodmart-child' ); ?></h3>
						<p class="description"><?php esc_html_e( 'Product title, description, and base pricing are automatically loaded from WooCommerce default fields above (just like the 3D Printer product).', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Reseller / Brand Badge Text', 'woodmart-child' ); ?></label>
						<input type="text" name="filament_builder[general][badge_text]" value="<?php echo esc_attr( $settings['general']['badge_text'] ); ?>" class="widefat">
					</div>

					<div class="wc-field-row grid-3">
						<div class="wc-field">
							<label><?php esc_html_e( 'Rating Tagline', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[general][rating_text]" value="<?php echo esc_attr( $settings['general']['rating_text'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Stock Location Label', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[general][stock_text]" value="<?php echo esc_attr( $settings['general']['stock_text'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Stock Note', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[general][stock_note]" value="<?php echo esc_attr( $settings['general']['stock_note'] ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'VAT Note', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[general][vat_note]" value="<?php echo esc_attr( $settings['general']['vat_note'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Show ex. VAT Link Text', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[general][ex_vat_text]" value="<?php echo esc_attr( $settings['general']['ex_vat_text'] ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field" style="margin-top:16px;">
						<label><?php esc_html_e( 'Selected Article / SKU Note Template', 'woodmart-child' ); ?></label>
						<input type="text" name="filament_builder[general][selected_sku_note]" value="<?php echo esc_attr( $settings['general']['selected_sku_note'] ?? 'Selected variation: BLACK · COMPLETE SPOOL · SAMPLE SKU' ); ?>" class="widefat">
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Color Swatches Palette (Shown if product is Variable with colors)', 'woodmart-child' ); ?></h4>
					<p class="description"><?php esc_html_e( 'Color swatches & variation formats only display when the product is a Variable Product in WooCommerce. If Simple Product, standard clean pricing is shown.', 'woodmart-child' ); ?></p>
					
					<div class="wc-repeater-container" id="filament-colors-repeater">
						<?php
						$colors = ! empty( $settings['general']['colors'] ) ? $settings['general']['colors'] : array();
						foreach ( $colors as $idx => $c ) :
							$hex = $c['hex'] ?? '#000000';
							$name = $c['name'] ?? 'BLACK #000000';
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-2">
									<div class="wc-field">
										<label><?php esc_html_e( 'Color Name & Code', 'woodmart-child' ); ?></label>
										<input type="text" name="filament_builder[general][colors][<?php echo esc_attr( $idx ); ?>][name]" value="<?php echo esc_attr( $name ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Hex Color', 'woodmart-child' ); ?></label>
										<div class="wc-color-field-wrap" style="display:flex; gap:8px; align-items:center;">
											<input type="color" class="wc-color-picker-input" value="<?php echo esc_attr( $hex ); ?>" style="width:36px; height:32px; padding:0; border:none; cursor:pointer;">
											<input type="text" name="filament_builder[general][colors][<?php echo esc_attr( $idx ); ?>][hex]" value="<?php echo esc_attr( $hex ); ?>" class="widefat" style="flex:1;">
										</div>
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Color', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="filament-colors-repeater" data-template="tmpl-filament-color-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Color Swatch', 'woodmart-child' ); ?>
					</button>

					<div class="wc-field" style="margin-top:20px;">
						<label><?php esc_html_e( 'Team Quote Prompt Link Text', 'woodmart-child' ); ?></label>
						<input type="text" name="filament_builder[general][team_quote_text]" value="<?php echo esc_attr( $settings['general']['team_quote_text'] ); ?>" class="widefat">
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Service Benefits Highlights (3 Strip Items)', 'woodmart-child' ); ?></h4>
					<div class="wc-repeater-container" id="filament-benefits-repeater">
						<?php
						$benefits = ! empty( $settings['general']['benefits'] ) ? $settings['general']['benefits'] : array();
						foreach ( $benefits as $b_idx => $b ) :
						?>
							<div class="wc-repeater-row" data-index="<?php echo esc_attr( $b_idx ); ?>">
								<span class="wc-row-drag">☰</span>
								<div class="wc-repeater-fields grid-2">
									<div class="wc-field">
										<label><?php esc_html_e( 'Benefit Title', 'woodmart-child' ); ?></label>
										<input type="text" name="filament_builder[general][benefits][<?php echo esc_attr( $b_idx ); ?>][title]" value="<?php echo esc_attr( $b['title'] ?? '' ); ?>" class="widefat">
									</div>
									<div class="wc-field">
										<label><?php esc_html_e( 'Benefit Subtitle', 'woodmart-child' ); ?></label>
										<input type="text" name="filament_builder[general][benefits][<?php echo esc_attr( $b_idx ); ?>][subtitle]" value="<?php echo esc_attr( $b['subtitle'] ?? '' ); ?>" class="widefat">
									</div>
								</div>
								<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="button button-secondary wc-btn-add-row" data-target="filament-benefits-repeater" data-template="tmpl-filament-benefit-row">
						<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Service Highlight', 'woodmart-child' ); ?>
					</button>
				</section>

				<!-- 2. ESSENTIAL ADDITIONS -->
				<section class="wc-tab-panel" id="tab-filament-additions">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[essential_additions][enabled]" value="1" <?php checked( ! empty( $settings['essential_additions']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Essential Additions Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[essential_additions][eyebrow]" value="<?php echo esc_attr( $settings['essential_additions']['eyebrow'] ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[essential_additions][title]" value="<?php echo esc_attr( $settings['essential_additions']['title'] ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Cross-Sell Products (3 Cards)', 'woodmart-child' ); ?></h4>
					
					<?php
					$cards = ! empty( $settings['essential_additions']['cards'] ) ? $settings['essential_additions']['cards'] : array();
					for ( $i = 0; $i < 3; $i++ ) :
						$c = $cards[ $i ] ?? array();
						$opt_string = is_array( $c['options'] ?? '' ) ? implode( ', ', $c['options'] ) : ( $c['options'] ?? '' );
					?>
						<div class="wc-box-group" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:16px;">
							<h5 style="margin:0 0 12px; font-size:14px; color:#0f172a;"><?php printf( esc_html__( 'Card %d', 'woodmart-child' ), $i + 1 ); ?></h5>
							
							<div class="wc-field-row grid-3">
								<div class="wc-field">
									<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[essential_additions][cards][<?php echo esc_attr( $i ); ?>][title]" value="<?php echo esc_attr( $c['title'] ?? '' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Current Price', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[essential_additions][cards][<?php echo esc_attr( $i ); ?>][price]" value="<?php echo esc_attr( $c['price'] ?? '' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Original / Old Price', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[essential_additions][cards][<?php echo esc_attr( $i ); ?>][old_price]" value="<?php echo esc_attr( $c['old_price'] ?? '' ); ?>" class="widefat">
								</div>
							</div>

							<div class="wc-field-row grid-3">
								<div class="wc-field">
									<label><?php esc_html_e( 'Icon Type', 'woodmart-child' ); ?></label>
									<select name="filament_builder[essential_additions][cards][<?php echo esc_attr( $i ); ?>][icon]" class="widefat">
										<option value="spool" <?php selected( ( $c['icon'] ?? '' ), 'spool' ); ?>><?php esc_html_e( 'Spool Icon', 'woodmart-child' ); ?></option>
										<option value="support" <?php selected( ( $c['icon'] ?? '' ), 'support' ); ?>><?php esc_html_e( 'Support 3D Blocks Icon', 'woodmart-child' ); ?></option>
										<option value="plate" <?php selected( ( $c['icon'] ?? '' ), 'plate' ); ?>><?php esc_html_e( 'Build Plate Icon', 'woodmart-child' ); ?></option>
									</select>
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Badge Tag (Optional, e.g. With Spool)', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[essential_additions][cards][<?php echo esc_attr( $i ); ?>][badge]" value="<?php echo esc_attr( $c['badge'] ?? '' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Short Description / Subtitle', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[essential_additions][cards][<?php echo esc_attr( $i ); ?>][desc]" value="<?php echo esc_attr( $c['desc'] ?? '' ); ?>" class="widefat">
								</div>
							</div>

							<div class="wc-field-row grid-2">
								<div class="wc-field">
									<label><?php esc_html_e( 'Select Dropdown Options (Comma-separated)', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[essential_additions][cards][<?php echo esc_attr( $i ); ?>][options_csv]" value="<?php echo esc_attr( $opt_string ); ?>" class="widefat" placeholder="Option 1, Option 2, Option 3">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Linked WooCommerce Product ID (Optional - Real Cart/Order sync)', 'woodmart-child' ); ?></label>
									<input type="number" name="filament_builder[essential_additions][cards][<?php echo esc_attr( $i ); ?>][product_id]" value="<?php echo esc_attr( $c['product_id'] ?? '' ); ?>" class="widefat" placeholder="e.g. 1234">
								</div>
							</div>
						</div>
					<?php endfor; ?>

					<h4 class="wc-subhead"><?php esc_html_e( 'Bottom Trust Strip & Payment Methods', 'woodmart-child' ); ?></h4>
					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Shipping Bullet 1', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[essential_additions][shipping_bullet_1]" value="<?php echo esc_attr( $settings['essential_additions']['shipping_bullet_1'] ?? '' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Shipping Bullet 2', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[essential_additions][shipping_bullet_2]" value="<?php echo esc_attr( $settings['essential_additions']['shipping_bullet_2'] ?? '' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Payment Methods Pills (Comma-separated)', 'woodmart-child' ); ?></label>
						<?php
						$pm = ! empty( $settings['essential_additions']['payment_methods'] ) ? implode( ', ', $settings['essential_additions']['payment_methods'] ) : 'Montonio, Bank Payments, Card Payments, Digital Wallets';
						?>
						<input type="text" name="filament_builder[essential_additions][payment_methods_csv]" value="<?php echo esc_attr( $pm ); ?>" class="widefat">
					</div>
				</section>

				<!-- 3. STICKY SUBNAV -->
				<section class="wc-tab-panel" id="tab-filament-nav">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[nav][enabled]" value="1" <?php checked( ! empty( $settings['nav']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable In-Page Sticky Navigation', 'woodmart-child' ); ?></strong></span>
						</label>
						<p class="description"><?php esc_html_e( 'Anchor links strip that stays sticky on scroll (OVERVIEW, FIND COLORS, PERFORMANCE, RFID & AMS, etc.).', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Right Action Button Text', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[nav][b2b_text]" value="<?php echo esc_attr( $settings['nav']['b2b_text'] ?? 'b2b order →' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Right Action Button URL / Anchor', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[nav][b2b_url]" value="<?php echo esc_attr( $settings['nav']['b2b_url'] ?? '#' ); ?>" class="widefat">
						</div>
					</div>
				</section>

				<!-- 4. FORMULATION SHOWCASE BANNER -->
				<section class="wc-tab-panel" id="tab-filament-formulation">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[formulation][enabled]" value="1" <?php checked( ! empty( $settings['formulation']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Formulation Showcase Banner', 'woodmart-child' ); ?></strong></span>
						</label>
						<p class="description"><?php esc_html_e( 'Dark banner showcasing filament spools, 3D prints, and polymer consistency statement.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[formulation][eyebrow]" value="<?php echo esc_attr( $settings['formulation']['eyebrow'] ?? 'FLAGSHIP FILAMENT FORMULATION' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Main Title', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[formulation][title]" value="<?php echo esc_attr( $settings['formulation']['title'] ?? 'PLA Basic' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Subtitle / Tagline', 'woodmart-child' ); ?></label>
						<input type="text" name="filament_builder[formulation][subtitle]" value="<?php echo esc_attr( $settings['formulation']['subtitle'] ?? 'Stand Out, Never Dull' ); ?>" class="widefat">
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
						<textarea name="filament_builder[formulation][description]" rows="3" class="widefat"><?php echo esc_textarea( $settings['formulation']['description'] ?? '' ); ?></textarea>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Custom Banner Image URL (Leave blank to use theme default render)', 'woodmart-child' ); ?></label>
						<div style="display:flex; gap:8px;">
							<input type="text" name="filament_builder[formulation][image]" value="<?php echo esc_attr( $settings['formulation']['image'] ?? '' ); ?>" class="widefat wc-media-url">
							<button type="button" class="button button-secondary wc-upload-media-btn"><?php esc_html_e( 'Choose Image', 'woodmart-child' ); ?></button>
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Creator Credits Strip (Displayed along bottom of banner card)', 'woodmart-child' ); ?></label>
						<textarea name="filament_builder[formulation][credits]" rows="2" class="widefat"><?php echo esc_textarea( $settings['formulation']['credits'] ?? '' ); ?></textarea>
					</div>
				</section>

				<!-- 5. COLORS SHOWCASE -->
				<section class="wc-tab-panel" id="tab-filament-colors-showcase">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[colors_showcase][enabled]" value="1" <?php checked( ! empty( $settings['colors_showcase']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Colors Showcase Section', 'woodmart-child' ); ?></strong></span>
						</label>
						<p class="description"><?php esc_html_e( 'Section displaying the 30+ color shade palette grouped vertically in 10 columns matching Figma.', 'woodmart-child' ); ?></p>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[colors_showcase][eyebrow]" value="<?php echo esc_attr( $settings['colors_showcase']['eyebrow'] ?? 'ONE FILAMENT FAMILY. MANY USE CASES' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[colors_showcase][title]" value="<?php echo esc_attr( $settings['colors_showcase']['title'] ?? 'Find the Perfect Color' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Description', 'woodmart-child' ); ?></label>
						<textarea name="filament_builder[colors_showcase][description]" rows="3" class="widefat"><?php echo esc_textarea( $settings['colors_showcase']['description'] ?? '' ); ?></textarea>
					</div>
				</section>

				<!-- 6. MATERIAL OVERVIEW -->
				<section class="wc-tab-panel" id="tab-filament-materials">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[materials][enabled]" value="1" <?php checked( ! empty( $settings['materials']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Material Overview Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[materials][eyebrow]" value="<?php echo esc_attr( $settings['materials']['eyebrow'] ?? 'MATERIAL OVERVIEW' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[materials][title]" value="<?php echo esc_attr( $settings['materials']['title'] ?? 'Choose the right material' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Section Description', 'woodmart-child' ); ?></label>
						<textarea name="filament_builder[materials][description]" rows="2" class="widefat"><?php echo esc_textarea( $settings['materials']['description'] ?? '' ); ?></textarea>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Material Cards (4 Cards)', 'woodmart-child' ); ?></h4>
					<?php
					$mat_items = ! empty( $settings['materials']['items'] ) ? $settings['materials']['items'] : array();
					$default_tags = array( 'PLA', 'PETG', 'ABS / ASA', 'CF MATERIALS' );
					for ( $m_i = 0; $m_i < 4; $m_i++ ) :
						$mi = $mat_items[ $m_i ] ?? array();
					?>
						<div class="wc-box-group" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:12px;">
							<h5 style="margin:0 0 10px; font-size:13px; color:#0f172a;"><?php printf( esc_html__( 'Card %d: %s', 'woodmart-child' ), $m_i + 1, esc_html( $mi['tag'] ?? $default_tags[ $m_i ] ) ); ?></h5>
							<div class="wc-field-row grid-3">
								<div class="wc-field">
									<label><?php esc_html_e( 'Tag / Category', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[materials][items][<?php echo esc_attr( $m_i ); ?>][tag]" value="<?php echo esc_attr( $mi['tag'] ?? $default_tags[ $m_i ] ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[materials][items][<?php echo esc_attr( $m_i ); ?>][title]" value="<?php echo esc_attr( $mi['title'] ?? '' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[materials][items][<?php echo esc_attr( $m_i ); ?>][description]" value="<?php echo esc_attr( $mi['description'] ?? '' ); ?>" class="widefat">
								</div>
							</div>
						</div>
					<?php endfor; ?>
				</section>

				<!-- 7. SMART MATERIAL DETECTION (RFID & AMS) -->
				<section class="wc-tab-panel" id="tab-filament-rfid-ams">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[rfid_ams][enabled]" value="1" <?php checked( ! empty( $settings['rfid_ams']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable RFID & AMS Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[rfid_ams][eyebrow]" value="<?php echo esc_attr( $settings['rfid_ams']['eyebrow'] ?? 'SMART MATERIAL DETECTION' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[rfid_ams][title]" value="<?php echo esc_attr( $settings['rfid_ams']['title'] ?? 'Built for RFID & AMS Compatibility' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
						<textarea name="filament_builder[rfid_ams][description]" rows="3" class="widefat"><?php echo esc_textarea( $settings['rfid_ams']['description'] ?? '' ); ?></textarea>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Feature Bullets (One per line)', 'woodmart-child' ); ?></label>
						<?php
						$rfid_bullets = ! empty( $settings['rfid_ams']['bullets'] ) ? implode( "\n", $settings['rfid_ams']['bullets'] ) : "Automatic material recognition\nReal-time remaining-filament tracking\nSeamless multi-color workflow with AMS\nReduces print failures from wrong settings";
						?>
						<textarea name="filament_builder[rfid_ams][bullets_text]" rows="4" class="widefat"><?php echo esc_textarea( $rfid_bullets ); ?></textarea>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Bottom Link Text', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[rfid_ams][link_text]" value="<?php echo esc_attr( $settings['rfid_ams']['link_text'] ?? 'See AMS-compatible printers →' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Bottom Link URL', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[rfid_ams][link_url]" value="<?php echo esc_attr( $settings['rfid_ams']['link_url'] ?? '#' ); ?>" class="widefat">
						</div>
					</div>
				</section>

				<!-- 8. WHERE IT EARNS ITS PLACE (USE CASES) -->
				<section class="wc-tab-panel" id="tab-filament-use-cases">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[use_cases][enabled]" value="1" <?php checked( ! empty( $settings['use_cases']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Use Cases Section (Dark)', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[use_cases][eyebrow]" value="<?php echo esc_attr( $settings['use_cases']['eyebrow'] ?? 'WHERE IT EARNS ITS PLACE' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
							<textarea name="filament_builder[use_cases][title]" rows="2" class="widefat"><?php echo esc_textarea( $settings['use_cases']['title'] ?? "Made for ideas\nthat have somewhere to go." ); ?></textarea>
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Use Case Items (4 Numbered Columns)', 'woodmart-child' ); ?></h4>
					<?php
					$uc_items = ! empty( $settings['use_cases']['items'] ) ? $settings['use_cases']['items'] : array();
					$default_nums = array( '01', '02', '03', '04' );
					for ( $u = 0; $u < 4; $u++ ) :
						$u_item = $uc_items[ $u ] ?? array();
					?>
						<div class="wc-box-group" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:12px;">
							<div class="wc-field-row grid-3">
								<div class="wc-field">
									<label><?php esc_html_e( 'Number', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[use_cases][items][<?php echo esc_attr( $u ); ?>][num]" value="<?php echo esc_attr( $u_item['num'] ?? $default_nums[ $u ] ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[use_cases][items][<?php echo esc_attr( $u ); ?>][title]" value="<?php echo esc_attr( $u_item['title'] ?? '' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[use_cases][items][<?php echo esc_attr( $u ); ?>][description]" value="<?php echo esc_attr( $u_item['description'] ?? '' ); ?>" class="widefat">
								</div>
							</div>
						</div>
					<?php endfor; ?>
				</section>

				<!-- 9. CHOOSE YOUR FORMAT (SPOOL VS REFILL) -->
				<section class="wc-tab-panel" id="tab-filament-format">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[choose_format][enabled]" value="1" <?php checked( ! empty( $settings['choose_format']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Spool or Refill Format Section', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[choose_format][eyebrow]" value="<?php echo esc_attr( $settings['choose_format']['eyebrow'] ?? 'CHOOSE YOUR FORMAT' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Section Title', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[choose_format][title]" value="<?php echo esc_attr( $settings['choose_format']['title'] ?? 'Complete Spool or Refill?' ); ?>" class="widefat">
						</div>
					</div>

					<div class="wc-field">
						<label><?php esc_html_e( 'Subtitle', 'woodmart-child' ); ?></label>
						<input type="text" name="filament_builder[choose_format][subtitle]" value="<?php echo esc_attr( $settings['choose_format']['subtitle'] ?? "The filament is the same. What changes is what's included" ); ?>" class="widefat">
					</div>

					<div class="wc-field-row grid-2" style="margin-top:20px;">
						<!-- Card 1: Complete Spool -->
						<div class="wc-box-group" style="background:#fff; border:2px solid #f97316; border-radius:12px; padding:18px;">
							<h4 style="margin:0 0 12px; color:#ea580c;"><?php esc_html_e( 'Card 1: Complete Spool', 'woodmart-child' ); ?></h4>
							<div class="wc-field">
								<label><?php esc_html_e( 'Badge Tag', 'woodmart-child' ); ?></label>
								<input type="text" name="filament_builder[choose_format][spool_badge]" value="<?php echo esc_attr( $settings['choose_format']['spool_badge'] ?? 'RECOMMENDED FOR FIRST PURCHASE' ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
								<input type="text" name="filament_builder[choose_format][spool_title]" value="<?php echo esc_attr( $settings['choose_format']['spool_title'] ?? 'Complete Spool' ); ?>" class="widefat">
							</div>
							<div class="wc-field-row grid-2">
								<div class="wc-field">
									<label><?php esc_html_e( 'Price Text', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[choose_format][spool_price]" value="<?php echo esc_attr( $settings['choose_format']['spool_price'] ?? '€24.90' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'VAT Note', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[choose_format][spool_vat]" value="<?php echo esc_attr( $settings['choose_format']['spool_vat'] ?? '€24.90 incl. 24% VAT · sample price' ); ?>" class="widefat">
								</div>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
								<textarea name="filament_builder[choose_format][spool_desc]" rows="2" class="widefat"><?php echo esc_textarea( $settings['choose_format']['spool_desc'] ?? '' ); ?></textarea>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Bullets (One per line)', 'woodmart-child' ); ?></label>
								<?php
								$sp_bullets = ! empty( $settings['choose_format']['spool_bullets'] ) ? implode( "\n", $settings['choose_format']['spool_bullets'] ) : "Includes reusable spool\nReady to load and print immediately\nBest if you don't already own a spool";
								?>
								<textarea name="filament_builder[choose_format][spool_bullets_text]" rows="3" class="widefat"><?php echo esc_textarea( $sp_bullets ); ?></textarea>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Button Text', 'woodmart-child' ); ?></label>
								<input type="text" name="filament_builder[choose_format][spool_btn_text]" value="<?php echo esc_attr( $settings['choose_format']['spool_btn_text'] ?? 'Add Complete Spool →' ); ?>" class="widefat">
							</div>
						</div>

						<!-- Card 2: Refill -->
						<div class="wc-box-group" style="background:#fff; border:1px solid #cbd5e1; border-radius:12px; padding:18px;">
							<h4 style="margin:0 0 12px; color:#334155;"><?php esc_html_e( 'Card 2: Refill', 'woodmart-child' ); ?></h4>
							<div class="wc-field">
								<label><?php esc_html_e( 'Badge Tag', 'woodmart-child' ); ?></label>
								<input type="text" name="filament_builder[choose_format][refill_badge]" value="<?php echo esc_attr( $settings['choose_format']['refill_badge'] ?? 'BEST IF YOU ALREADY OWN A SPOOL' ); ?>" class="widefat">
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Card Title', 'woodmart-child' ); ?></label>
								<input type="text" name="filament_builder[choose_format][refill_title]" value="<?php echo esc_attr( $settings['choose_format']['refill_title'] ?? 'Refill' ); ?>" class="widefat">
							</div>
							<div class="wc-field-row grid-2">
								<div class="wc-field">
									<label><?php esc_html_e( 'Price Text', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[choose_format][refill_price]" value="<?php echo esc_attr( $settings['choose_format']['refill_price'] ?? '€21.90' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'VAT Note', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[choose_format][refill_vat]" value="<?php echo esc_attr( $settings['choose_format']['refill_vat'] ?? '€21.90 incl. 24% VAT · sample price' ); ?>" class="widefat">
								</div>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
								<textarea name="filament_builder[choose_format][refill_desc]" rows="2" class="widefat"><?php echo esc_textarea( $settings['choose_format']['refill_desc'] ?? '' ); ?></textarea>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Bullets (One per line)', 'woodmart-child' ); ?></label>
								<?php
								$rf_bullets = ! empty( $settings['choose_format']['refill_bullets'] ) ? implode( "\n", $settings['choose_format']['refill_bullets'] ) : "No spool included\nLess packaging waste, more eco-friendly\nRequires an existing compatible spool";
								?>
								<textarea name="filament_builder[choose_format][refill_bullets_text]" rows="3" class="widefat"><?php echo esc_textarea( $rf_bullets ); ?></textarea>
							</div>
							<div class="wc-field">
								<label><?php esc_html_e( 'Button Text', 'woodmart-child' ); ?></label>
								<input type="text" name="filament_builder[choose_format][refill_btn_text]" value="<?php echo esc_attr( $settings['choose_format']['refill_btn_text'] ?? 'Add Refill' ); ?>" class="widefat">
							</div>
						</div>
					</div>
				</section>

				<!-- 10. THE 3DKODA DIFFERENCE -->
				<section class="wc-tab-panel" id="tab-filament-brand">
					<div class="wc-panel-head">
						<label class="wc-section-toggle">
							<input type="checkbox" name="filament_builder[brand_difference][enabled]" value="1" <?php checked( ! empty( $settings['brand_difference']['enabled'] ) ); ?>>
							<span class="wc-toggle-slider"></span>
							<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable 3DKoda Difference Section (Dark)', 'woodmart-child' ); ?></strong></span>
						</label>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Eyebrow', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[brand_difference][eyebrow]" value="<?php echo esc_attr( $settings['brand_difference']['eyebrow'] ?? 'THE 3DKODA DIFFERENCE' ); ?>" class="widefat">
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
							<textarea name="filament_builder[brand_difference][title]" rows="2" class="widefat"><?php echo esc_textarea( $settings['brand_difference']['title'] ?? "Quality filament.\nA local team behind it." ); ?></textarea>
						</div>
					</div>

					<div class="wc-field-row grid-2">
						<div class="wc-field">
							<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
							<textarea name="filament_builder[brand_difference][description]" rows="3" class="widefat"><?php echo esc_textarea( $settings['brand_difference']['description'] ?? '' ); ?></textarea>
						</div>
						<div class="wc-field">
							<label><?php esc_html_e( 'Action Link Text', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[brand_difference][btn_text]" value="<?php echo esc_attr( $settings['brand_difference']['btn_text'] ?? 'Talk to a local expert →' ); ?>" class="widefat">
							<label style="margin-top:8px;"><?php esc_html_e( 'Action Link URL', 'woodmart-child' ); ?></label>
							<input type="text" name="filament_builder[brand_difference][btn_url]" value="<?php echo esc_attr( $settings['brand_difference']['btn_url'] ?? '#' ); ?>" class="widefat">
						</div>
					</div>

					<h4 class="wc-subhead"><?php esc_html_e( 'Value Propositions (4 Items)', 'woodmart-child' ); ?></h4>
					<?php
					$bd_items = ! empty( $settings['brand_difference']['items'] ) ? $settings['brand_difference']['items'] : array();
					$default_icons = array( 'location', 'storage', 'support', 'business' );
					for ( $b_i = 0; $b_i < 4; $b_i++ ) :
						$bi = $bd_items[ $b_i ] ?? array();
					?>
						<div class="wc-box-group" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:12px;">
							<div class="wc-field-row grid-3">
								<div class="wc-field">
									<label><?php esc_html_e( 'Icon Type', 'woodmart-child' ); ?></label>
									<select name="filament_builder[brand_difference][items][<?php echo esc_attr( $b_i ); ?>][icon]" class="widefat">
										<option value="location" <?php selected( ( $bi['icon'] ?? $default_icons[ $b_i ] ), 'location' ); ?>><?php esc_html_e( 'Location / Pin', 'woodmart-child' ); ?></option>
										<option value="storage" <?php selected( ( $bi['icon'] ?? $default_icons[ $b_i ] ), 'storage' ); ?>><?php esc_html_e( 'Storage / Climate', 'woodmart-child' ); ?></option>
										<option value="support" <?php selected( ( $bi['icon'] ?? $default_icons[ $b_i ] ), 'support' ); ?>><?php esc_html_e( 'Support / Shield', 'woodmart-child' ); ?></option>
										<option value="business" <?php selected( ( $bi['icon'] ?? $default_icons[ $b_i ] ), 'business' ); ?>><?php esc_html_e( 'Business / Invoice', 'woodmart-child' ); ?></option>
									</select>
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Title', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[brand_difference][items][<?php echo esc_attr( $b_i ); ?>][title]" value="<?php echo esc_attr( $bi['title'] ?? '' ); ?>" class="widefat">
								</div>
								<div class="wc-field">
									<label><?php esc_html_e( 'Description', 'woodmart-child' ); ?></label>
									<input type="text" name="filament_builder[brand_difference][items][<?php echo esc_attr( $b_i ); ?>][description]" value="<?php echo esc_attr( $bi['description'] ?? '' ); ?>" class="widefat">
								</div>
							</div>
						</div>
					<?php endfor; ?>
				</section>
			</div>
		</div>
	</div>

	<!-- Underscore / JS Templates for Filament Repeaters -->
	<script type="text/template" id="tmpl-filament-color-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-2">
				<div class="wc-field">
					<label><?php esc_html_e( 'Color Name & Code', 'woodmart-child' ); ?></label>
					<input type="text" name="filament_builder[general][colors][{{INDEX}}][name]" value="NEW COLOR #000000" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Hex Color', 'woodmart-child' ); ?></label>
					<div class="wc-color-field-wrap" style="display:flex; gap:8px; align-items:center;">
						<input type="color" class="wc-color-picker-input" value="#000000" style="width:36px; height:32px; padding:0; border:none; cursor:pointer;">
						<input type="text" name="filament_builder[general][colors][{{INDEX}}][hex]" value="#000000" class="widefat" style="flex:1;">
					</div>
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Color', 'woodmart-child' ); ?>">&times;</button>
		</div>
	</script>

	<script type="text/template" id="tmpl-filament-benefit-row">
		<div class="wc-repeater-row" data-index="{{INDEX}}">
			<span class="wc-row-drag">☰</span>
			<div class="wc-repeater-fields grid-2">
				<div class="wc-field">
					<label><?php esc_html_e( 'Benefit Title', 'woodmart-child' ); ?></label>
					<input type="text" name="filament_builder[general][benefits][{{INDEX}}][title]" value="" class="widefat">
				</div>
				<div class="wc-field">
					<label><?php esc_html_e( 'Benefit Subtitle', 'woodmart-child' ); ?></label>
					<input type="text" name="filament_builder[general][benefits][{{INDEX}}][subtitle]" value="" class="widefat">
				</div>
			</div>
			<button type="button" class="button wc-btn-remove-row" title="<?php esc_attr_e( 'Remove Row', 'woodmart-child' ); ?>">&times;</button>
		</div>
	</script>
	<?php
}

/**
 * Save Filament Product Page Builder Meta Data
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function woodmart_child_save_filament_builder_meta( $post_id, $post ) {
	if ( ! isset( $_POST['woodmart_child_filament_builder_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['woodmart_child_filament_builder_nonce'] ) ), 'woodmart_child_save_filament_builder_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( 'product' !== $post->post_type ) {
		return;
	}

	$raw_data = isset( $_POST['filament_builder'] ) && is_array( $_POST['filament_builder'] ) ? wp_unslash( $_POST['filament_builder'] ) : array();

	// Master switch
	$is_enabled = ! empty( $raw_data['general']['enable_landing'] ) ? '1' : '0';
	update_post_meta( $post_id, '_woodmart_child_filament_landing_enabled', $is_enabled );

	$clean = array();

	// 1. General & Hero
	$clean['general'] = array(
		'enable_landing'    => $is_enabled,
		'badge_text'        => sanitize_text_field( $raw_data['general']['badge_text'] ?? '' ),
		'rating_text'       => sanitize_text_field( $raw_data['general']['rating_text'] ?? '' ),
		'stock_text'        => sanitize_text_field( $raw_data['general']['stock_text'] ?? '' ),
		'stock_note'        => sanitize_text_field( $raw_data['general']['stock_note'] ?? '' ),
		'vat_note'          => sanitize_text_field( $raw_data['general']['vat_note'] ?? '' ),
		'ex_vat_text'       => sanitize_text_field( $raw_data['general']['ex_vat_text'] ?? '' ),
		'selected_sku_note' => sanitize_text_field( $raw_data['general']['selected_sku_note'] ?? '' ),
		'team_quote_text'   => sanitize_text_field( $raw_data['general']['team_quote_text'] ?? '' ),
		'colors'            => array(),
		'benefits'          => array(),
	);

	// Colors
	if ( ! empty( $raw_data['general']['colors'] ) && is_array( $raw_data['general']['colors'] ) ) {
		foreach ( $raw_data['general']['colors'] as $c ) {
			$c_name = sanitize_text_field( $c['name'] ?? '' );
			$c_hex  = sanitize_text_field( $c['hex'] ?? '#000000' );
			if ( ! empty( $c_name ) || ! empty( $c_hex ) ) {
				$clean['general']['colors'][] = array(
					'name' => $c_name,
					'hex'  => $c_hex,
				);
			}
		}
	}

	// Benefits
	if ( ! empty( $raw_data['general']['benefits'] ) && is_array( $raw_data['general']['benefits'] ) ) {
		foreach ( $raw_data['general']['benefits'] as $b ) {
			if ( ! empty( $b['title'] ) ) {
				$clean['general']['benefits'][] = array(
					'title'    => sanitize_text_field( $b['title'] ),
					'subtitle' => sanitize_text_field( $b['subtitle'] ?? '' ),
				);
			}
		}
	}

	// 2. Essential Additions
	$clean['essential_additions'] = array(
		'enabled'           => ! empty( $raw_data['essential_additions']['enabled'] ) ? '1' : '0',
		'eyebrow'           => sanitize_text_field( $raw_data['essential_additions']['eyebrow'] ?? '' ),
		'title'             => sanitize_text_field( $raw_data['essential_additions']['title'] ?? '' ),
		'cards'             => array(),
		'shipping_bullet_1' => sanitize_text_field( $raw_data['essential_additions']['shipping_bullet_1'] ?? '' ),
		'shipping_bullet_2' => sanitize_text_field( $raw_data['essential_additions']['shipping_bullet_2'] ?? '' ),
		'payment_methods'   => array(),
	);

	if ( ! empty( $raw_data['essential_additions']['cards'] ) && is_array( $raw_data['essential_additions']['cards'] ) ) {
		foreach ( $raw_data['essential_additions']['cards'] as $card ) {
			$opts_raw = sanitize_text_field( $card['options_csv'] ?? '' );
			$opts_arr = array_filter( array_map( 'trim', explode( ',', $opts_raw ) ) );

			$clean['essential_additions']['cards'][] = array(
				'title'      => sanitize_text_field( $card['title'] ?? '' ),
				'price'      => sanitize_text_field( $card['price'] ?? '' ),
				'old_price'  => sanitize_text_field( $card['old_price'] ?? '' ),
				'icon'       => sanitize_key( $card['icon'] ?? 'spool' ),
				'badge'      => sanitize_text_field( $card['badge'] ?? '' ),
				'desc'       => sanitize_text_field( $card['desc'] ?? '' ),
				'options'    => array_values( $opts_arr ),
				'product_id' => absint( $card['product_id'] ?? 0 ),
			);
		}
	}

	if ( ! empty( $raw_data['essential_additions']['payment_methods_csv'] ) ) {
		$pm_raw = sanitize_text_field( $raw_data['essential_additions']['payment_methods_csv'] );
		$clean['essential_additions']['payment_methods'] = array_values( array_filter( array_map( 'trim', explode( ',', $pm_raw ) ) ) );
	}

	// 3. In-page Subnav
	$clean['nav'] = array(
		'enabled'  => ! empty( $raw_data['nav']['enabled'] ) ? '1' : '0',
		'b2b_text' => sanitize_text_field( $raw_data['nav']['b2b_text'] ?? 'b2b order →' ),
		'b2b_url'  => esc_url_raw( $raw_data['nav']['b2b_url'] ?? '#' ),
		'items'    => array(
			array( 'label' => 'OVERVIEW', 'target' => '#overview' ),
			array( 'label' => 'FIND COLORS', 'target' => '#find-colors' ),
			array( 'label' => 'PERFORMANCE', 'target' => '#materials' ),
			array( 'label' => 'RFID & AMS', 'target' => '#rfid-ams' ),
			array( 'label' => 'DOWNLOAD', 'target' => '#downloads' ),
			array( 'label' => 'PRINTING TIPS', 'target' => '#printing-tips' ),
		),
	);

	// 4. Formulation Banner
	$clean['formulation'] = array(
		'enabled'     => ! empty( $raw_data['formulation']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['formulation']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['formulation']['title'] ?? '' ),
		'subtitle'    => sanitize_text_field( $raw_data['formulation']['subtitle'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['formulation']['description'] ?? '' ),
		'image'       => esc_url_raw( $raw_data['formulation']['image'] ?? '' ),
		'credits'     => sanitize_textarea_field( $raw_data['formulation']['credits'] ?? '' ),
	);

	// 5. Colors Showcase
	$clean['colors_showcase'] = array(
		'enabled'     => ! empty( $raw_data['colors_showcase']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['colors_showcase']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['colors_showcase']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['colors_showcase']['description'] ?? '' ),
	);

	// 6. Materials
	$clean['materials'] = array(
		'enabled'     => ! empty( $raw_data['materials']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['materials']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['materials']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['materials']['description'] ?? '' ),
		'items'       => array(),
	);

	if ( ! empty( $raw_data['materials']['items'] ) && is_array( $raw_data['materials']['items'] ) ) {
		foreach ( $raw_data['materials']['items'] as $m_item ) {
			$clean['materials']['items'][] = array(
				'tag'         => sanitize_text_field( $m_item['tag'] ?? '' ),
				'title'       => sanitize_text_field( $m_item['title'] ?? '' ),
				'description' => sanitize_text_field( $m_item['description'] ?? '' ),
			);
		}
	}

	// 7. RFID & AMS
	$rfid_b_raw = sanitize_textarea_field( $raw_data['rfid_ams']['bullets_text'] ?? '' );
	$rfid_b_arr = array_filter( array_map( 'trim', explode( "\n", $rfid_b_raw ) ) );

	$clean['rfid_ams'] = array(
		'enabled'     => ! empty( $raw_data['rfid_ams']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['rfid_ams']['eyebrow'] ?? '' ),
		'title'       => sanitize_text_field( $raw_data['rfid_ams']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['rfid_ams']['description'] ?? '' ),
		'bullets'     => array_values( $rfid_b_arr ),
		'link_text'   => sanitize_text_field( $raw_data['rfid_ams']['link_text'] ?? '' ),
		'link_url'    => esc_url_raw( $raw_data['rfid_ams']['link_url'] ?? '#' ),
	);

	// 8. Use Cases
	$clean['use_cases'] = array(
		'enabled' => ! empty( $raw_data['use_cases']['enabled'] ) ? '1' : '0',
		'eyebrow' => sanitize_text_field( $raw_data['use_cases']['eyebrow'] ?? '' ),
		'title'   => sanitize_textarea_field( $raw_data['use_cases']['title'] ?? '' ),
		'items'   => array(),
	);
	if ( ! empty( $raw_data['use_cases']['items'] ) && is_array( $raw_data['use_cases']['items'] ) ) {
		foreach ( $raw_data['use_cases']['items'] as $u_item ) {
			$clean['use_cases']['items'][] = array(
				'num'         => sanitize_text_field( $u_item['num'] ?? '' ),
				'title'       => sanitize_text_field( $u_item['title'] ?? '' ),
				'description' => sanitize_text_field( $u_item['description'] ?? '' ),
			);
		}
	}

	// 9. Choose Format
	$sp_bullets_arr = array_filter( array_map( 'trim', explode( "\n", sanitize_textarea_field( $raw_data['choose_format']['spool_bullets_text'] ?? '' ) ) ) );
	$rf_bullets_arr = array_filter( array_map( 'trim', explode( "\n", sanitize_textarea_field( $raw_data['choose_format']['refill_bullets_text'] ?? '' ) ) ) );

	$clean['choose_format'] = array(
		'enabled'        => ! empty( $raw_data['choose_format']['enabled'] ) ? '1' : '0',
		'eyebrow'        => sanitize_text_field( $raw_data['choose_format']['eyebrow'] ?? '' ),
		'title'          => sanitize_text_field( $raw_data['choose_format']['title'] ?? '' ),
		'subtitle'       => sanitize_text_field( $raw_data['choose_format']['subtitle'] ?? '' ),
		'spool_badge'    => sanitize_text_field( $raw_data['choose_format']['spool_badge'] ?? '' ),
		'spool_title'    => sanitize_text_field( $raw_data['choose_format']['spool_title'] ?? '' ),
		'spool_price'    => sanitize_text_field( $raw_data['choose_format']['spool_price'] ?? '' ),
		'spool_vat'      => sanitize_text_field( $raw_data['choose_format']['spool_vat'] ?? '' ),
		'spool_desc'     => sanitize_textarea_field( $raw_data['choose_format']['spool_desc'] ?? '' ),
		'spool_bullets'  => array_values( $sp_bullets_arr ),
		'spool_btn_text' => sanitize_text_field( $raw_data['choose_format']['spool_btn_text'] ?? '' ),
		'refill_badge'   => sanitize_text_field( $raw_data['choose_format']['refill_badge'] ?? '' ),
		'refill_title'   => sanitize_text_field( $raw_data['choose_format']['refill_title'] ?? '' ),
		'refill_price'   => sanitize_text_field( $raw_data['choose_format']['refill_price'] ?? '' ),
		'refill_vat'     => sanitize_text_field( $raw_data['choose_format']['refill_vat'] ?? '' ),
		'refill_desc'    => sanitize_textarea_field( $raw_data['choose_format']['refill_desc'] ?? '' ),
		'refill_bullets' => array_values( $rf_bullets_arr ),
		'refill_btn_text' => sanitize_text_field( $raw_data['choose_format']['refill_btn_text'] ?? '' ),
	);

	// 10. 3DKoda Difference
	$clean['brand_difference'] = array(
		'enabled'     => ! empty( $raw_data['brand_difference']['enabled'] ) ? '1' : '0',
		'eyebrow'     => sanitize_text_field( $raw_data['brand_difference']['eyebrow'] ?? '' ),
		'title'       => sanitize_textarea_field( $raw_data['brand_difference']['title'] ?? '' ),
		'description' => sanitize_textarea_field( $raw_data['brand_difference']['description'] ?? '' ),
		'btn_text'    => sanitize_text_field( $raw_data['brand_difference']['btn_text'] ?? '' ),
		'btn_url'     => esc_url_raw( $raw_data['brand_difference']['btn_url'] ?? '#' ),
		'items'       => array(),
	);
	if ( ! empty( $raw_data['brand_difference']['items'] ) && is_array( $raw_data['brand_difference']['items'] ) ) {
		foreach ( $raw_data['brand_difference']['items'] as $bd_item ) {
			$clean['brand_difference']['items'][] = array(
				'icon'        => sanitize_key( $bd_item['icon'] ?? 'location' ),
				'title'       => sanitize_text_field( $bd_item['title'] ?? '' ),
				'description' => sanitize_text_field( $bd_item['description'] ?? '' ),
			);
		}
	}

	// Save main filament settings array
	update_post_meta( $post_id, '_woodmart_child_filament_builder', $clean );
}
add_action( 'save_post_product', 'woodmart_child_save_filament_builder_meta', 10, 2 );

