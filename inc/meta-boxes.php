<?php
/**
 * Native Custom Meta Box: Product Page Builder
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Product Page Builder Meta Box
 */
function woodmart_child_register_product_builder_meta_box() {
	add_meta_box(
		'woodmart_child_product_builder',
		__( 'Product Page Builder (Apple / Bambu Lab Style)', 'woodmart-child' ),
		'woodmart_child_render_product_builder_meta_box',
		'product',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'woodmart_child_register_product_builder_meta_box' );

/**
 * Render Product Page Builder Meta Box
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
				<span class="wc-toggle-text"><strong><?php esc_html_e( 'Enable Custom Apple/Bambu Lab Landing Page', 'woodmart-child' ); ?></strong> (<?php esc_html_e( 'Replaces default WooCommerce single product layout with custom high-performance canvas while preserving the global site header and footer', 'woodmart-child' ); ?>)</span>

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
