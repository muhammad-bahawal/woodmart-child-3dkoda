<?php
/**
 * Template Part: AMS Product Hero Section
 *
 * Strict unified 2-Column Hero Layout:
 * - Breadcrumb navigation
 * - Left Column: Sticky Gallery with vertical thumbnails locked to the left of the main image
 * - Right Column: Reseller tag, title, rating, strictly dynamic In Stock / Out of Stock status,
 *   price with VAT toggle (strictly € EUR), native WooCommerce variations,
 *   quantity stepper, orange Add to Basket CTA, team quote link, service guarantees,
 *   and essential add-ons bundle cards.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_ams_builder_settings( $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

// Core product data
$title         = ! empty( $core['title'] ) ? $core['title'] : get_the_title( $product_id );
$subtitle      = ! empty( $core['short_desc'] ) ? $core['short_desc'] : '';
$price_display = ! empty( $core['price_html'] ) ? $core['price_html'] : '';
$price_raw     = ! empty( $core['price'] ) ? $core['price'] : 0;
$gallery_imgs  = ! empty( $core['gallery_images'] ) ? $core['gallery_images'] : array();
$main_image    = ! empty( $core['main_image_url'] ) ? $core['main_image_url'] : '';
$sku           = ! empty( $core['sku'] ) ? $core['sku'] : '';
$badge_text    = ! empty( $settings['general']['badge_text'] ) ? $settings['general']['badge_text'] : __( 'Authorized Bambu Lab Reseller', 'woodmart-child' );
$rating_text   = ! empty( $settings['general']['rating_text'] ) ? $settings['general']['rating_text'] : __( 'Multi-Color & Filament Drying System', 'woodmart-child' );

// Stock Status: Strictly dynamic "In Stock" / "Out of Stock" (No location/demo labels)
$product_obj  = $core['product'] ?? wc_get_product( $product_id );
$is_in_stock  = $product_obj ? $product_obj->is_in_stock() : true;
$stock_status = $product_obj ? $product_obj->get_stock_status() : 'instock';
$is_backorder = ( 'onbackorder' === $stock_status ) || ( $product_obj && $product_obj->is_on_backorder() );

if ( $is_backorder ) {
	$stock_text  = __( 'Available on Backorder', 'woodmart-child' );
	$stock_class = 'is-backorder';
} elseif ( $is_in_stock && 'outofstock' !== $stock_status ) {
	$stock_text  = __( 'In Stock', 'woodmart-child' );
	$stock_class = 'is-instock';
} else {
	$stock_text  = __( 'Out of Stock', 'woodmart-child' );
	$stock_class = 'is-outofstock';
}

$stock_note      = ! empty( $sku ) ? ( __( 'SKU: ', 'woodmart-child' ) . $sku ) : ( ! empty( $settings['general']['stock_note'] ) ? $settings['general']['stock_note'] : '' );
$vat_note        = ! empty( $settings['general']['vat_note'] ) ? $settings['general']['vat_note'] : __( 'Incl. 24% VAT · sample price', 'woodmart-child' );
$ex_vat_text     = ! empty( $settings['general']['ex_vat_text'] ) ? $settings['general']['ex_vat_text'] : __( 'Show ex. VAT', 'woodmart-child' );
$team_quote_text = ! empty( $settings['general']['team_quote_text'] ) ? $settings['general']['team_quote_text'] : __( 'Buying for a team or print farm? Request a tailored quote →', 'woodmart-child' );

// Check if product is variable
$variations  = ! empty( $core['variations'] ) ? $core['variations'] : array();
$is_variable = ! empty( $core['is_variable'] ) && count( $variations ) > 1;

// Essential additions
$addons = ! empty( $settings['general']['bundle_addons'] ) ? $settings['general']['bundle_addons'] : array();
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
			<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>"><?php esc_html_e( 'Accessories', 'woodmart-child' ); ?></a>
			<span class="sep">/</span>
		<?php endif; ?>
		<span class="current"><?php echo esc_html( $title ); ?></span>
	</nav>
</div>

<!-- Hero 2-Column Section -->
<section class="product-hero container ams-product-hero" id="ams-hero">
	<!-- Left Column: Sticky Gallery -->
	<div class="product-gallery ams-product-gallery">
		<div class="product-gallery__thumbs-wrap">
			<button type="button" class="gallery-nav-btn gallery-nav-prev" aria-label="<?php esc_attr_e( 'Previous thumbnail', 'woodmart-child' ); ?>">
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<polyline points="18 15 12 9 6 15"></polyline>
				</svg>
			</button>

			<ul class="product-gallery__thumbs">
				<?php if ( ! empty( $main_image ) ) : ?>
					<li class="is-active" data-full-url="<?php echo esc_url( $main_image ); ?>" data-alt="<?php echo esc_attr( $title ); ?>">
						<img src="<?php echo esc_url( $main_image ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="eager">
					</li>
				<?php endif; ?>

				<?php if ( ! empty( $gallery_imgs ) && is_array( $gallery_imgs ) ) : ?>
					<?php foreach ( $gallery_imgs as $g_idx => $img_item ) : 
						$full_url  = is_array( $img_item ) ? ( $img_item['url'] ?? '' ) : (string) $img_item;
						$thumb_url = is_array( $img_item ) ? ( $img_item['thumb'] ?? $full_url ) : (string) $img_item;
						$img_alt   = is_array( $img_item ) ? ( $img_item['alt'] ?? $title ) : $title;
						if ( empty( $full_url ) || ( $full_url === $main_image && $g_idx === 0 ) ) {
							continue;
						}
					?>
						<li data-full-url="<?php echo esc_url( $full_url ); ?>" data-alt="<?php echo esc_attr( $img_alt ); ?>">
							<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy">
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>

			<button type="button" class="gallery-nav-btn gallery-nav-next" aria-label="<?php esc_attr_e( 'Next thumbnail', 'woodmart-child' ); ?>">
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<polyline points="6 9 12 15 18 9"></polyline>
				</svg>
			</button>
		</div>

		<!-- Main Image Viewport -->
		<div class="product-gallery__main">
			<span class="hero-badge-corner hero-rfid-badge" aria-label="<?php esc_attr_e( 'Airtight & RFID Multi-Material', 'woodmart-child' ); ?>">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
					<line x1="8" y1="21" x2="16" y2="21"></line>
					<line x1="12" y1="17" x2="12" y2="21"></line>
				</svg>
			</span>

			<?php if ( ! empty( $main_image ) ) : ?>
				<img src="<?php echo esc_url( $main_image ); ?>" alt="<?php echo esc_attr( $title ); ?>" id="product-main-image" class="ams-main-image">
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

	<!-- Right Column: Product Summary & Add-to-Cart -->
	<div class="product-summary ams-product-summary">
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

		<!-- 4. Dynamic Stock Status Banner: Strictly Dynamic In Stock / Out of Stock -->
		<div class="product-stock-row <?php echo esc_attr( $stock_class ); ?>" id="ams-stock-row">
			<span class="stock-icon" aria-hidden="true">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
					<polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
					<line x1="12" y1="22.08" x2="12" y2="12"></line>
				</svg>
			</span>
			<span class="stock-text" id="ams-stock-text"><?php echo esc_html( $stock_text ); ?></span>
			<?php if ( ! empty( $stock_note ) ) : ?>
				<span class="stock-sep">·</span>
				<span class="stock-note" id="ams-stock-note"><?php echo esc_html( $stock_note ); ?></span>
			<?php endif; ?>
		</div>

		<!-- 5. Price Display Row -->
		<div class="product-price-row ams-price-row" data-price-raw="<?php echo esc_attr( $price_raw ); ?>">
			<div class="product-price-main">
				<span class="product-price ams-current-price" style="color: #111827 !important;"><?php echo wp_kses_post( $price_display ); ?></span>
			</div>
			<div class="product-price-meta">
				<span class="product-price-note"><?php echo esc_html( $vat_note ); ?></span>
				<div class="product-vat-toggle">
					<a href="#ams-box-contents" class="vat-link"><?php echo esc_html( $ex_vat_text ); ?></a>
				</div>
			</div>
		</div>

		<!-- 6. Purchase Form -->
		<form class="product-add-to-cart-form ams-purchase-form" id="ams-purchase-form" method="post" action="">
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="variation_id" id="selected-variation-id" value="<?php echo ! $is_variable ? esc_attr( $core['id'] ) : ''; ?>">

			<!-- DYNAMIC VARIATIONS: Rendered ONLY if the product is variable in WooCommerce -->
			<?php if ( $is_variable ) : ?>
				<fieldset class="product-configuration ams-variations-fieldset">
					<div class="product-configuration__head">
						<legend class="product-configuration__label"><?php esc_html_e( 'CHOOSE YOUR CONFIGURATION', 'woodmart-child' ); ?></legend>
						<a href="#ams-compatibility" class="compare-packages-link"><?php esc_html_e( 'Check compatibility', 'woodmart-child' ); ?></a>
					</div>
					<div class="product-configuration__options">
						<?php foreach ( $variations as $idx => $var ) : 
							$var_in_stock = ! empty( $var['in_stock'] );
						?>
							<label class="option <?php echo ( $idx === 0 ) ? 'is-selected' : ''; ?>" data-var-id="<?php echo esc_attr( $var['id'] ); ?>">
								<input type="radio" name="ams_variation_choice" value="<?php echo esc_attr( $var['id'] ); ?>"
									<?php checked( $idx, 0 ); ?>
									data-title="<?php echo esc_attr( $var['title'] ); ?>"
									data-price-raw="<?php echo esc_attr( $var['price_raw'] ?? 0 ); ?>"
									data-price-html="<?php echo esc_attr( $var['price_html'] ); ?>"
									data-sku="<?php echo esc_attr( $var['sku'] ); ?>"
									data-stock="<?php echo $var_in_stock ? 'instock' : 'outofstock'; ?>"
									data-image="<?php echo esc_url( $var['image_url'] ?? '' ); ?>">
								<div class="option-header">
									<span class="option-title"><?php echo esc_html( $var['title'] ); ?></span>
									<span class="option-check-icon" aria-hidden="true">
										<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
											<polyline points="20 6 9 17 4 12"></polyline>
										</svg>
									</span>
								</div>
								<?php if ( ! empty( $var['subtitle'] ) ) : ?>
									<span class="option-desc"><?php echo esc_html( $var['subtitle'] ); ?></span>
								<?php endif; ?>
								<span class="option-price" style="color: #111827 !important;"><?php echo wp_kses_post( $var['price_html'] ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
					<p class="note"><?php esc_html_e( 'Selected article:', 'woodmart-child' ); ?> <span class="product-sku" id="ams-selected-sku"><?php echo esc_html( $sku ?: '—' ); ?></span></p>
				</fieldset>
			<?php endif; ?>

			<!-- Quantity & Add to Basket Button -->
			<div class="product-add-to-cart">
				<div class="product-quantity">
					<button type="button" data-step="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woodmart-child' ); ?>">−</button>
					<input type="text" name="quantity" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>">
					<button type="button" data-step="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'woodmart-child' ); ?>">+</button>
				</div>
				<button class="btn btn-add-to-cart ams-add-btn" type="submit" id="ams-main-add-btn">
					<span><?php esc_html_e( 'Add to basket', 'woodmart-child' ); ?></span>
					<span class="cart-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
							<line x1="3" y1="6" x2="21" y2="6"></line>
							<path d="M16 10a4 4 0 0 1-8 0"></path>
						</svg>
					</span>
				</button>
			</div>
		</form>

		<!-- 7. Buying for a Team Bar -->
		<div class="product-team-quote">
			<a href="#ams-faq" class="quote-link">
				<span><?php echo esc_html( $team_quote_text ); ?></span>
			</a>
		</div>

		<!-- 8. Service Highlights (3 Icons) -->
		<div class="filament-service-highlights ams-service-highlights">
			<?php 
			$guarantees = ! empty( $settings['general']['guarantees'] ) ? $settings['general']['guarantees'] : array();
			foreach ( $guarantees as $g ) :
				$icon = $g['icon'] ?? 'shield';
			?>
				<div class="service-item">
					<span class="service-icon" aria-hidden="true">
						<?php if ( 'truck' === $icon ) : ?>
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<rect x="1" y="3" width="15" height="13"></rect>
								<polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
								<circle cx="5.5" cy="18.5" r="2.5"></circle>
								<circle cx="18.5" cy="18.5" r="2.5"></circle>
							</svg>
						<?php elseif ( 'user' === $icon ) : ?>
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
								<circle cx="12" cy="7" r="4"></circle>
							</svg>
						<?php else : ?>
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
							</svg>
						<?php endif; ?>
					</span>
					<div class="service-text">
						<strong><?php echo esc_html( $g['title'] ?? '' ); ?></strong>
						<span><?php echo esc_html( $g['subtitle'] ?? '' ); ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Essential Additions Section (Directly under Hero) -->
<?php if ( ! empty( $addons ) ) : ?>
<section class="filament-additions container ams-additions-section" id="ams-essential-additions">
	<div class="filament-additions__header">
		<h2 class="title"><?php esc_html_e( 'Essential Additions & Accessories', 'woodmart-child' ); ?></h2>
		<p class="subtitle"><?php esc_html_e( 'High-compatibility hardware selected by our engineers to expand your AMS setup.', 'woodmart-child' ); ?></p>
	</div>

	<div class="filament-additions__grid">
		<?php foreach ( $addons as $a_idx => $addon ) : ?>
			<div class="addition-card" data-addon-id="<?php echo esc_attr( $addon['id'] ?? ( 'addon-' . $a_idx ) ); ?>">
				<div class="addition-card__img-wrap">
					<?php if ( ! empty( $addon['badge'] ) ) : ?>
						<span class="badge"><?php echo esc_html( $addon['badge'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $addon['image'] ) ) : ?>
						<img src="<?php echo esc_url( $addon['image'] ); ?>" alt="<?php echo esc_attr( $addon['title'] ); ?>" loading="lazy">
					<?php else : ?>
						<div class="addition-card__placeholder">
							<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5">
								<rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
								<line x1="8" y1="21" x2="16" y2="21"></line>
								<line x1="12" y1="17" x2="12" y2="21"></line>
							</svg>
						</div>
					<?php endif; ?>
				</div>

				<div class="addition-card__body">
					<h3 class="addition-card__title"><?php echo esc_html( $addon['title'] ); ?></h3>
					<?php if ( ! empty( $addon['description'] ) ) : ?>
						<p class="addition-card__desc"><?php echo esc_html( $addon['description'] ); ?></p>
					<?php endif; ?>

					<div class="addition-card__price-row">
						<span class="current-price" style="color: #111827 !important;">€<?php echo esc_html( number_format( (float) ( $addon['price'] ?? 0 ), 2 ) ); ?></span>
						<?php if ( ! empty( $addon['regular_price'] ) && (float) $addon['regular_price'] > (float) ( $addon['price'] ?? 0 ) ) : ?>
							<span class="regular-price">€<?php echo esc_html( number_format( (float) $addon['regular_price'], 2 ) ); ?></span>
						<?php endif; ?>
					</div>

					<div class="addition-card__actions">
						<div class="addition-card__qty">
							<button type="button" data-step="-1" aria-label="<?php esc_attr_e( 'Decrease', 'woodmart-child' ); ?>">−</button>
							<input type="text" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>">
							<button type="button" data-step="1" aria-label="<?php esc_attr_e( 'Increase', 'woodmart-child' ); ?>">+</button>
						</div>
						<button type="button" class="btn addition-card__btn-add" data-title="<?php echo esc_attr( $addon['title'] ); ?>">
							<span><?php esc_html_e( 'Add', 'woodmart-child' ); ?></span>
						</button>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- Baltic Trust & Payment Strip -->
	<div class="filament-trust-strip">
		<div class="trust-pill">
			<span class="dot">●</span>
			<span><?php esc_html_e( 'Free Baltic shipping over 99 €', 'woodmart-child' ); ?></span>
		</div>
		<div class="trust-pill">
			<span class="dot">●</span>
			<span><?php esc_html_e( 'Omniva · DPD · SmartPost lockers', 'woodmart-child' ); ?></span>
		</div>
		<div class="trust-pill">
			<span class="dot">●</span>
			<span><?php esc_html_e( 'Same-day dispatch from Tallinn', 'woodmart-child' ); ?></span>
		</div>
		<div class="trust-pill">
			<span class="dot">●</span>
			<span><?php esc_html_e( '14-day hassle-free return window', 'woodmart-child' ); ?></span>
		</div>
	</div>
</section>
<?php endif; ?>
