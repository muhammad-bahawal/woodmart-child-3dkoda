<?php
/**
 * Template Part: Accessories Product Hero Section
 *
 * Pixel-perfect alignment with 3DKoda Design System & Target Reference:
 * - Breadcrumb strip (Home / Accessories & Spare Parts / Product Title)
 * - 2-Column responsive hero grid
 * - Left vertical thumbnail column (with scroll up/down arrows when >4 thumbs)
 * - Main image preview card with corner badge & "Change view" button
 * - Gallery attribute badges strip under gallery (Original Part, Up to 300°C, Wear Resistant, Quick Swap)
 * - Green verified shield Reseller badge
 * - Large product title & short description (from default WooCommerce core data)
 * - 5-star rating with tagline
 * - "In Stock — Tallinn" pill with package icon
 * - Price row with VAT notice & Show ex. VAT link
 * - Dynamic variations handling: pills for Nozzle Diameter, Material, or Hotend Type
 * - Quantity stepper + Orange "Add to basket" button
 * - Farm / B2B bulk volume pricing strip
 * - 3 Service highlights with orange outline icons
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_accessories_builder_settings( $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

// Core product data takes authority
$title           = $core['title'];
$subtitle        = $core['short_desc'];
$price_display   = $core['price_html'];
$badge_text      = ! empty( $settings['general']['badge_text'] ) ? $settings['general']['badge_text'] : __( '● Authorized Bambu Lab Reseller', 'woodmart-child' );
$eyebrow         = ! empty( $settings['general']['eyebrow'] ) ? $settings['general']['eyebrow'] : __( 'GENUINE ACCESSORIES & SPARE PARTS', 'woodmart-child' );
$rating_text     = ! empty( $settings['general']['rating_text'] ) ? $settings['general']['rating_text'] : __( '4.9 / 5 (128 reviews) · Trusted Baltic Stock', 'woodmart-child' );
$stock_text      = ! empty( $settings['general']['stock_text'] ) ? $settings['general']['stock_text'] : __( 'In Stock', 'woodmart-child' );
$stock_text      = trim( preg_replace( '/[\s·—\-_]*Tallinn/i', '', $stock_text ) );
$stock_note      = ! empty( $settings['general']['stock_note'] ) ? $settings['general']['stock_note'] : ( ! empty( $core['sku'] ) ? ( __( 'SKU: ', 'woodmart-child' ) . $core['sku'] ) : '' );
$vat_note        = ! empty( $settings['general']['vat_note'] ) ? $settings['general']['vat_note'] : __( 'incl. 24% VAT', 'woodmart-child' );
$ex_vat_text     = ! empty( $settings['general']['ex_vat_text'] ) ? $settings['general']['ex_vat_text'] : __( 'Show ex. VAT', 'woodmart-child' );
$team_quote_text = ! empty( $settings['general']['team_quote_text'] ) ? $settings['general']['team_quote_text'] : __( 'Buying spare parts in bulk for your print farm? Request business volume pricing →', 'woodmart-child' );
$gallery_badges  = ! empty( $settings['general']['compatibility_badges'] ) ? $settings['general']['compatibility_badges'] : array();
$benefits        = ! empty( $settings['general']['benefits'] ) ? $settings['general']['benefits'] : array();

// Variations detection
$variations  = ! empty( $core['variations'] ) ? $core['variations'] : array();
$is_variable = ! empty( $core['is_variable'] ) && count( $variations ) > 1;
?>

<!-- Breadcrumb Strip -->
<div class="product-breadcrumb-wrap container">
	<nav class="product-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'woodmart-child' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'woodmart-child' ); ?></a>
		<span class="sep">/</span>
		<?php if ( ! empty( $core['primary_cat'] ) ) : ?>
			<a href="<?php echo esc_url( get_term_link( $core['primary_cat'] ) ); ?>"><?php echo esc_html( $core['primary_cat']->name ); ?></a>
			<span class="sep">/</span>
		<?php else : ?>
			<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>"><?php esc_html_e( 'Accessories & Spare Parts', 'woodmart-child' ); ?></a>
			<span class="sep">/</span>
		<?php endif; ?>
		<span class="current"><?php echo esc_html( $title ); ?></span>
	</nav>
</div>

<section class="product-hero container accessories-hero" id="accessories-hero">
	<!-- Left Column: Gallery with Left Vertical Thumbnails (Sticky Grid Child) -->
	<div class="product-gallery">
		<div class="product-gallery__thumbs-wrap">
			<button type="button" class="gallery-nav-btn gallery-nav-prev" aria-label="<?php esc_attr_e( 'Previous thumbnail', 'woodmart-child' ); ?>">
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<polyline points="18 15 12 9 6 15"></polyline>
				</svg>
			</button>

			<ul class="product-gallery__thumbs" data-default-gallery="<?php echo esc_attr( wp_json_encode( $core['gallery_images'] ?? array() ) ); ?>">
				<?php if ( ! empty( $core['gallery_images'] ) ) : ?>
					<?php foreach ( $core['gallery_images'] as $idx => $img ) : ?>
						<li class="<?php echo 0 === $idx ? 'is-active' : ''; ?>" data-full-url="<?php echo esc_url( $img['url'] ); ?>" data-alt="<?php echo esc_attr( $img['alt'] ); ?>">
							<img src="<?php echo esc_url( $img['thumb'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" loading="lazy">
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<li class="is-active"><div class="thumb-ph">1</div></li>
					<li><div class="thumb-ph">2</div></li>
					<li><div class="thumb-ph">3</div></li>
					<li><div class="thumb-ph">4</div></li>
				<?php endif; ?>
			</ul>

			<button type="button" class="gallery-nav-btn gallery-nav-next" aria-label="<?php esc_attr_e( 'Next thumbnail', 'woodmart-child' ); ?>">
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<polyline points="6 9 12 15 18 9"></polyline>
				</svg>
			</button>
		</div>

		<div class="product-gallery__main">
			<span class="hero-badge-corner"><?php echo esc_html( $eyebrow ); ?></span>

			<?php if ( ! empty( $core['main_image_url'] ) ) : ?>
				<img src="<?php echo esc_url( $core['main_image_url'] ); ?>" alt="<?php echo esc_attr( $title ); ?>" id="product-main-image">
			<?php else : ?>
				<div class="placeholder" role="img" aria-label="<?php echo esc_attr( 'Product image: ' . $title ); ?>">
					[<?php echo esc_html( $title ); ?>]
				</div>
			<?php endif; ?>

			<button type="button" class="btn-change-view" id="hero-change-view" aria-label="<?php esc_attr_e( 'Change gallery view', 'woodmart-child' ); ?>">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/>
				</svg>
				<span><?php esc_html_e( 'Change view', 'woodmart-child' ); ?></span>
			</button>
		</div>
	</div>

	<!-- Right Column: Summary & Add-to-Cart -->
	<div class="product-summary accessories-summary-column">
		<!-- 1. Reseller Badge with Green Shield -->
		<div class="product-reseller-tag">
			<span class="reseller-icon" aria-hidden="true">
				<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
					<polyline points="9 12 11 14 15 10"></polyline>
				</svg>
			</span>
			<span class="reseller-text"><?php echo esc_html( $badge_text ); ?></span>
		</div>

		<!-- 2. Product Title & Short Description -->
		<h1 class="product-title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( ! empty( $subtitle ) ) : ?>
			<div class="product-subtitle"><?php echo apply_filters( 'woocommerce_short_description', $subtitle ); ?></div>
		<?php endif; ?>

		<!-- 3. Star Rating & Tagline -->
		<div class="product-rating-line">
			<span class="stars" aria-label="5 out of 5 stars">★★★★★</span>
			<span class="rating-quote"><?php echo esc_html( $rating_text ); ?></span>
		</div>

		<!-- 4. Stock Banner Card -->
		<?php
		$acc_stock_cls = ! empty( $core['is_in_stock'] ) ? 'is-instock' : 'is-outofstock';
		?>
		<div class="product-stock-row accessories-stock-row <?php echo esc_attr( $acc_stock_cls ); ?>">
			<span class="stock-icon" aria-hidden="true">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
					<polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
					<line x1="12" y1="22.08" x2="12" y2="12"></line>
				</svg>
			</span>
			<span class="stock-text" id="acc-stock-status-text"><?php echo esc_html( $stock_text ); ?></span>
			<span class="stock-sep">·</span>
			<span class="stock-note" id="acc-stock-note-text"><?php echo esc_html( $stock_note ); ?></span>
		</div>

		<!-- Hardware Highlights / Feature Badges Strip (Clean Summary Grid - Zero Image Overlap) -->
		<?php if ( ! empty( $gallery_badges ) ) : ?>
			<div class="accessories-gallery-badges" aria-label="<?php esc_attr_e( 'Hardware highlights', 'woodmart-child' ); ?>">
				<?php foreach ( $gallery_badges as $gb ) :
					$g_icon = strtolower( trim( $gb['icon'] ?? 'shield' ) );
				?>
					<div class="accessories-gallery-badge-item">
						<div class="acc-badge-icon" aria-hidden="true">
							<?php if ( false !== strpos( $g_icon, 'temp' ) || false !== strpos( $g_icon, 'fire' ) ) : ?>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path></svg>
							<?php elseif ( false !== strpos( $g_icon, 'diamond' ) || false !== strpos( $g_icon, 'steel' ) ) : ?>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 12L2 9z"></path></svg>
							<?php elseif ( false !== strpos( $g_icon, 'zap' ) || false !== strpos( $g_icon, 'quick' ) || false !== strpos( $g_icon, 'tool' ) ) : ?>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
							<?php else : ?>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
							<?php endif; ?>
						</div>
						<div class="acc-badge-text">
							<strong class="acc-badge-title"><?php echo esc_html( $gb['title'] ); ?></strong>
							<?php if ( ! empty( $gb['subtitle'] ) ) : ?>
								<span class="acc-badge-sub"><?php echo esc_html( $gb['subtitle'] ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- 5. Price Display Row -->
		<div class="product-price-row accessories-price-row" data-price-raw="<?php echo esc_attr( $core['price'] ?? 0 ); ?>">
			<div class="product-price-main">
				<span class="product-price accessories-current-price" style="color: #111827 !important;"><?php echo wp_kses_post( $price_display ); ?></span>
			</div>
			<div class="product-price-meta">
				<span class="product-price-note"><?php echo esc_html( $vat_note ); ?></span>
				<div class="product-vat-toggle">
					<a href="#specifications" class="vat-link"><?php echo esc_html( $ex_vat_text ); ?></a>
				</div>
			</div>
		</div>

		<!-- 6. Purchase Form & Variation Attribute Selectors -->
		<form class="product-add-to-cart-form accessories-purchase-form" method="post" action="">
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="variation_id" id="selected-accessories-variation-id" value="<?php echo ! $is_variable ? esc_attr( $core['id'] ) : ''; ?>">

			<?php if ( $is_variable ) : ?>
				<?php
				$product_obj = $core['product'];
				$attributes  = ( $product_obj instanceof WC_Product ) ? $product_obj->get_attributes() : array();
				$available_variations = ( $product_obj instanceof WC_Product_Variable ) ? $product_obj->get_available_variations() : array();

				// Build client-side matrix
				$matrix = array();
				foreach ( $available_variations as $av ) {
					$v_price_html = $av['price_html'] ?: wc_price( $av['display_price'] );
					$matrix[] = array(
						'id'           => $av['variation_id'],
						'attributes'   => $av['attributes'],
						'price_raw'    => $av['display_price'],
						'price_html'   => $v_price_html,
						'sku'          => $av['sku'] ?: $core['sku'],
						'image'        => ! empty( $av['image']['url'] ) ? $av['image']['url'] : '',
						'gallery'      => woodmart_child_get_variation_gallery_images( $av['variation_id'], $core['id'], $av ),
						'in_stock'     => $av['is_in_stock'],
						'stock_text'   => $av['is_in_stock'] ? __( 'In Stock', 'woodmart-child' ) : __( 'Out of stock', 'woodmart-child' ),
						'availability' => $av['availability_html'] ?? '',
					);
				}
				?>

				<!-- Dynamic Variation Attribute Groups -->
				<div class="accessories-attributes-container">
					<?php
					$attr_index = 0;
					foreach ( $attributes as $attr_slug => $attr_obj ) :
						if ( ! $attr_obj->get_variation() ) {
							continue;
						}
						$attr_index++;
						$taxonomy_name = $attr_obj->get_name();
						$attr_label    = wc_attribute_label( $taxonomy_name, $product_obj );
						$attr_key_field = 'attribute_' . sanitize_title( $taxonomy_name );

						// Get terms or custom options
						$options = array();
						if ( $attr_obj->is_taxonomy() ) {
							$terms = wc_get_product_terms( $core['id'], $taxonomy_name, array( 'fields' => 'all' ) );
							if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
								foreach ( $terms as $t ) {
									$options[] = array(
										'slug' => $t->slug,
										'name' => $t->name,
									);
								}
							}
						} else {
							$raw_opts = $attr_obj->get_options();
							foreach ( $raw_opts as $ro ) {
								$options[] = array(
									'slug' => sanitize_title( $ro ),
									'name' => trim( $ro ),
								);
							}
						}

						if ( empty( $options ) ) {
							continue;
						}
					?>
						<div class="accessories-attr-group" data-attr-key="<?php echo esc_attr( $attr_key_field ); ?>">
							<div class="accessories-attr-header">
								<span class="accessories-attr-label"><?php echo esc_html( strtoupper( $attr_label ) ); ?>:</span>
								<span class="accessories-attr-selected-value" id="val-<?php echo esc_attr( sanitize_title( $attr_label ) ); ?>"></span>
							</div>

							<div class="accessories-pills-grid" role="radiogroup" aria-label="<?php echo esc_attr( $attr_label ); ?>">
								<?php foreach ( $options as $opt_idx => $opt ) : ?>
									<button type="button" 
											class="accessories-pill-btn"
											data-attr-key="<?php echo esc_attr( $attr_key_field ); ?>"
											data-attr-val="<?php echo esc_attr( $opt['slug'] ); ?>"
											data-attr-name="<?php echo esc_attr( $opt['name'] ); ?>">
										<span class="pill-check-indicator" aria-hidden="true">✓</span>
										<span class="pill-text"><?php echo esc_html( $opt['name'] ); ?></span>
									</button>
								<?php endforeach; ?>
							</div>
							<input type="hidden" name="<?php echo esc_attr( $attr_key_field ); ?>" value="" class="accessories-hidden-attr">
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Selected Variation Summary Line -->
				<div class="accessories-selected-summary-bar">
					<span class="summary-label"><?php esc_html_e( 'Selected:', 'woodmart-child' ); ?></span>
					<span class="summary-details" id="accessories-variation-summary">—</span>
				</div>

				<script type="application/json" id="accessories-variation-matrix">
					<?php echo wp_json_encode( $matrix ); ?>
				</script>
			<?php endif; ?>

			<!-- Quantity Stepper + Add to Basket Button -->
			<div class="product-add-to-cart accessories-add-row">
				<div class="product-quantity">
					<button type="button" data-step="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woodmart-child' ); ?>">−</button>
					<input type="text" name="quantity" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>">
					<button type="button" data-step="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'woodmart-child' ); ?>">+</button>
				</div>
				<button class="btn btn-add-to-cart accessories-btn-add-to-cart" type="submit">
					<span><?php esc_html_e( 'Add to basket', 'woodmart-child' ); ?></span>
					<span class="cart-icon" aria-hidden="true">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
							<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
						</svg>
					</span>
				</button>
			</div>
		</form>

		<!-- 7. Team / Print Farm Volume Quote Bar -->
		<div class="product-team-quote accessories-quote-bar">
			<a href="#specifications" class="quote-link">
				<span><?php echo esc_html( $team_quote_text ); ?></span>
			</a>
		</div>

		<!-- 8. Service Highlights Strip -->
		<?php if ( ! empty( $benefits ) ) : ?>
			<div class="hero-service-features" aria-label="<?php esc_attr_e( 'Service highlights', 'woodmart-child' ); ?>">
				<?php
				$benefit_svgs = array(
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>',
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>',
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>',
				);
				foreach ( $benefits as $b_idx => $b ) :
					$icon_svg = $benefit_svgs[ $b_idx % count( $benefit_svgs ) ];
				?>
					<div class="hero-service-feature-item">
						<div class="hero-service-feature-icon"><?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<div class="hero-service-feature-text">
							<b class="hero-service-feature-title"><?php echo esc_html( $b['title'] ?? '' ); ?></b>
							<span class="hero-service-feature-desc"><?php echo esc_html( $b['subtitle'] ?? '' ); ?></span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
