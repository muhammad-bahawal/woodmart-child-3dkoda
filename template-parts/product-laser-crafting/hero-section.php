<?php
/**
 * Template Part: Laser & Crafting Product Hero Section
 *
 * Exact match to 3DKoda Design System (Filament Reference Image 1):
 * - Breadcrumb bar (Home / Crafting / Product Name)
 * - 2-Column responsive layout
 * - Vertical thumbnails strip + Main image preview with "Change view" overlay
 * - Green Authorized Bambu Lab Reseller tag
 * - Large product title & dynamic short description
 * - 5-star rating with tagline
 * - In Stock — Tallinn pill/card with package icon
 * - Price row with VAT note & Show ex. VAT link
 * - 100% Dynamic Variations: Only rendered when product has backend variations in WooCommerce
 * - Quantity stepper + Orange "Add to basket" button
 * - "Buying for a team? Request a tailored quote →" link
 * - 3 Service highlights (Fast Baltic delivery, Local warranty, Human support)
 * - Essential additions cross-sell cards + Baltic shipping & payment trust strip
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

// Core product data takes authority
$title         = ! empty( $core['title'] ) ? $core['title'] : get_the_title( $product_id );
$subtitle      = ! empty( $core['short_desc'] ) ? $core['short_desc'] : '';
$price_display = ! empty( $core['price_html'] ) ? $core['price_html'] : '';
$price_raw     = ! empty( $core['price'] ) ? $core['price'] : 0;
$gallery_imgs  = ! empty( $core['gallery_images'] ) ? $core['gallery_images'] : array();
$main_image    = ! empty( $core['main_image_url'] ) ? $core['main_image_url'] : '';
$sku           = ! empty( $core['sku'] ) ? $core['sku'] : '';
$badge_text    = ! empty( $settings['general']['badge_text'] ) ? $settings['general']['badge_text'] : __( 'Authorized Bambu Lab Reseller', 'woodmart-child' );
$rating_text   = ! empty( $settings['general']['rating_text'] ) ? $settings['general']['rating_text'] : __( 'Built for everyday making', 'woodmart-child' );

// Stock Status via WooCommerce Native Methods
$product_obj  = $core['product'] ?? wc_get_product( $product_id );
$is_in_stock  = $product_obj ? $product_obj->is_in_stock() : true;
$stock_status = $product_obj ? $product_obj->get_stock_status() : 'instock';
$is_backorder = ( 'onbackorder' === $stock_status ) || ( $product_obj && $product_obj->is_on_backorder() );

if ( $is_backorder ) {
	$stock_text  = __( 'Available on Backorder', 'woodmart-child' );
	$stock_class = 'is-backorder';
} elseif ( $is_in_stock && 'outofstock' !== $stock_status ) {
	$stock_text  = ! empty( $settings['general']['stock_text'] ) ? $settings['general']['stock_text'] : __( 'In Stock', 'woodmart-child' );
	$stock_class = 'is-instock';
} else {
	$stock_text  = __( 'Out of Stock', 'woodmart-child' );
	$stock_class = 'is-outofstock';
}
$stock_text = trim( preg_replace( '/[\s·—\-_]*Tallinn/i', '', $stock_text ) );

$stock_note      = ! empty( $settings['general']['stock_note'] ) ? $settings['general']['stock_note'] : ( ! empty( $sku ) ? ( __( 'SKU: ', 'woodmart-child' ) . $sku ) : '' );
$vat_note        = ! empty( $settings['general']['vat_note'] ) ? $settings['general']['vat_note'] : __( 'incl. 24% VAT', 'woodmart-child' );
$ex_vat_text     = ! empty( $settings['general']['ex_vat_text'] ) ? $settings['general']['ex_vat_text'] : __( 'Show ex. VAT', 'woodmart-child' );
$team_quote_text = ! empty( $settings['general']['team_quote_text'] ) ? $settings['general']['team_quote_text'] : __( 'Buying for a team? Request a tailored quote →', 'woodmart-child' );

// Check if product is variable
$variations  = ! empty( $core['variations'] ) ? $core['variations'] : array();
$is_variable = ! empty( $core['is_variable'] ) && count( $variations ) > 1;

// Essential additions (from general settings bundle addons or defaults)
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
			<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>"><?php esc_html_e( 'Crafting', 'woodmart-child' ); ?></a>
			<span class="sep">/</span>
		<?php endif; ?>
		<span class="current"><?php echo esc_html( $title ); ?></span>
	</nav>
</div>

<!-- Hero 2-Column Section -->
<section class="product-hero container lc-product-hero" id="lc-hero">
	<!-- Left Column: Sticky Gallery -->
	<div class="product-gallery lc-product-gallery">
		<div class="product-gallery__thumbs-wrap">
			<button type="button" class="gallery-nav-btn gallery-nav-prev" aria-label="<?php esc_attr_e( 'Previous thumbnail', 'woodmart-child' ); ?>">
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<polyline points="18 15 12 9 6 15"></polyline>
				</svg>
			</button>

			<ul class="product-gallery__thumbs" data-default-gallery="<?php echo esc_attr( wp_json_encode( $core['gallery_images'] ?? array() ) ); ?>">
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
			<span class="hero-badge-corner hero-rfid-badge" aria-label="<?php esc_attr_e( 'Smart Crafting & Multi-Tool Ready', 'woodmart-child' ); ?>">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
					<polyline points="2 17 12 22 22 17"></polyline>
					<polyline points="2 12 12 17 22 12"></polyline>
				</svg>
			</span>

			<?php if ( ! empty( $main_image ) ) : ?>
				<img src="<?php echo esc_url( $main_image ); ?>" alt="<?php echo esc_attr( $title ); ?>" id="product-main-image" class="lc-main-image">
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
	<div class="product-summary lc-product-summary">
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

		<!-- 4. Dynamic Stock Status Banner -->
		<div class="product-stock-row <?php echo esc_attr( $stock_class ); ?>" id="lc-stock-row">
			<span class="stock-icon" aria-hidden="true">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
					<polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
					<line x1="12" y1="22.08" x2="12" y2="12"></line>
				</svg>
			</span>
			<span class="stock-text" id="lc-stock-text"><?php echo esc_html( $stock_text ); ?></span>
			<span class="stock-sep">·</span>
			<span class="stock-note" id="lc-stock-note"><?php echo esc_html( $stock_note ); ?></span>
		</div>

		<!-- 5. Price Display Row -->
		<div class="product-price-row lc-price-row" data-price-raw="<?php echo esc_attr( $price_raw ); ?>">
			<div class="product-price-main">
				<span class="product-price lc-current-price" style="color: #111827 !important;"><?php echo wp_kses_post( $price_display ); ?></span>
			</div>
			<div class="product-price-meta">
				<span class="product-price-note"><?php echo esc_html( $vat_note ); ?></span>
				<div class="product-vat-toggle">
					<a href="#lc-box-contents" class="vat-link"><?php echo esc_html( $ex_vat_text ); ?></a>
				</div>
			</div>
		</div>

		<!-- 6. Purchase Form -->
		<form class="product-add-to-cart-form lc-purchase-form" id="lc-purchase-form" method="post" action="">
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="variation_id" id="selected-variation-id" value="<?php echo ! $is_variable ? esc_attr( $core['id'] ) : ''; ?>">

			<!-- DYNAMIC VARIATIONS: Rendered ONLY if the product is variable in WooCommerce -->
			<?php if ( $is_variable ) : ?>
				<fieldset class="product-configuration lc-variations-fieldset">
					<div class="product-configuration__head">
						<legend class="product-configuration__label"><?php esc_html_e( 'CHOOSE YOUR CONFIGURATION', 'woodmart-child' ); ?></legend>
						<a href="#lc-box-contents" class="compare-packages-link"><?php esc_html_e( 'Compare packages', 'woodmart-child' ); ?></a>
					</div>
					<div class="product-configuration__options">
						<?php foreach ( $variations as $idx => $var ) : ?>
							<label class="option" data-var-id="<?php echo esc_attr( $var['id'] ); ?>">
								<input type="radio" name="lc_variation_choice" value="<?php echo esc_attr( $var['id'] ); ?>"
									data-title="<?php echo esc_attr( $var['title'] ); ?>"
									data-price-raw="<?php echo esc_attr( $var['price_raw'] ?? 0 ); ?>"
									data-price-html="<?php echo esc_attr( $var['price_html'] ); ?>"
									data-sku="<?php echo esc_attr( $var['sku'] ); ?>"
									data-image="<?php echo esc_url( $var['image_url'] ?? '' ); ?>"
									data-in-stock="<?php echo ! empty( $var['in_stock'] ) ? '1' : '0'; ?>"
									data-stock-status="<?php echo esc_attr( $var['stock_status'] ?? '' ); ?>"
									data-stock-text="<?php echo esc_attr( $var['stock_text'] ?? '' ); ?>"
									data-gallery="<?php echo esc_attr( wp_json_encode( $var['gallery'] ?? array() ) ); ?>">
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
					<p class="note"><?php esc_html_e( 'Selected article:', 'woodmart-child' ); ?> <span class="product-sku" id="lc-selected-sku"><?php echo esc_html( $sku ?: '—' ); ?></span></p>

					<script type="application/json" id="lc-variation-matrix">
						<?php echo wp_json_encode( $variations ); ?>
					</script>
				</fieldset>
			<?php endif; ?>

			<!-- Quantity & Add to Basket Button -->
			<div class="product-add-to-cart">
				<div class="product-quantity">
					<button type="button" data-step="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woodmart-child' ); ?>">−</button>
					<input type="text" name="quantity" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>">
					<button type="button" data-step="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'woodmart-child' ); ?>">+</button>
				</div>
				<button class="btn btn-add-to-cart lc-add-btn" type="submit" id="lc-main-add-btn">
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
			<a href="#lc-faq" class="quote-link">
				<span><?php echo esc_html( $team_quote_text ); ?></span>
			</a>
		</div>

		<!-- 8. Service Highlights (3 Icons) -->
		<div class="filament-service-highlights lc-service-highlights">
			<div class="service-item">
				<span class="service-icon" aria-hidden="true">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<rect x="1" y="3" width="15" height="13"></rect>
						<polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
						<circle cx="5.5" cy="18.5" r="2.5"></circle>
						<circle cx="18.5" cy="18.5" r="2.5"></circle>
					</svg>
				</span>
				<div class="service-text">
					<strong><?php esc_html_e( 'Fast Baltic delivery', 'woodmart-child' ); ?></strong>
					<span><?php esc_html_e( 'Dispatched from Tallinn', 'woodmart-child' ); ?></span>
				</div>
			</div>

			<div class="service-item">
				<span class="service-icon" aria-hidden="true">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
					</svg>
				</span>
				<div class="service-text">
					<strong><?php esc_html_e( 'Local warranty', 'woodmart-child' ); ?></strong>
					<span><?php esc_html_e( 'Guidance from our team', 'woodmart-child' ); ?></span>
				</div>
			</div>

			<div class="service-item">
				<span class="service-icon" aria-hidden="true">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
					</svg>
				</span>
				<div class="service-text">
					<strong><?php esc_html_e( 'Human support', 'woodmart-child' ); ?></strong>
					<span><?php esc_html_e( 'Before and after purchase', 'woodmart-child' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Essential Additions Section (Directly under Hero, matching Image 1) -->
<?php
if ( empty( $addons ) ) {
	$default_data = function_exists( 'woodmart_child_get_default_laser_crafting_builder_data' ) ? woodmart_child_get_default_laser_crafting_builder_data() : array();
	$addons = $default_data['general']['bundle_addons'] ?? array();
}

if ( ! empty( $addons ) && is_array( $addons ) ) :
?>
<section class="filament-additions container lc-additions-section" id="lc-essential-additions">
	<div class="filament-additions__header">
		<span class="eyebrow"><?php esc_html_e( 'DISCOVER MORE HERE!', 'woodmart-child' ); ?></span>
		<h2 class="filament-additions__title"><?php esc_html_e( 'Essential additions specifically tested with Bambu Lab A2L', 'woodmart-child' ); ?></h2>
	</div>

	<div class="filament-additions__grid">
		<?php
		foreach ( $addons as $a_idx => $addon ) :
			$addon_title      = ! empty( $addon['title'] ) ? $addon['title'] : '';
			if ( empty( $addon_title ) ) {
				continue;
			}
			$addon_price      = ! empty( $addon['price'] ) ? $addon['price'] : '';
			$addon_reg_price  = ! empty( $addon['regular_price'] ) ? $addon['regular_price'] : '';
			$addon_desc       = ! empty( $addon['description'] ) ? $addon['description'] : '';
			$addon_image      = ! empty( $addon['image'] ) ? $addon['image'] : '';
			$addon_product_id = ! empty( $addon['product_id'] ) ? absint( $addon['product_id'] ) : 0;
			
			$options_raw = $addon['options'] ?? array();
			if ( is_string( $options_raw ) ) {
				$addon_options = array_values( array_filter( array_map( 'trim', explode( ',', $options_raw ) ) ) );
			} elseif ( is_array( $options_raw ) ) {
				$addon_options = $options_raw;
			} else {
				$addon_options = array();
			}

			// Fallback options if none provided
			if ( empty( $addon_options ) ) {
				if ( 0 === $a_idx ) {
					$addon_options = array( __( 'Standard Toolset (Complete)', 'woodmart-child' ) );
				} elseif ( 1 === $a_idx ) {
					$addon_options = array( __( 'A2L Mounting Bracket Kit', 'woodmart-child' ) );
				} else {
					$addon_options = array( __( 'A2L / Large Format Series', 'woodmart-child' ) );
				}
			}
		?>
		<div class="addition-card" data-product-id="<?php echo esc_attr( $addon_product_id ); ?>" data-title="<?php echo esc_attr( $addon_title ); ?>" data-price="<?php echo esc_attr( $addon_price ); ?>" data-image="<?php echo esc_url( $addon_image ); ?>">
			<div class="addition-card__icon-box">
				<?php if ( ! empty( $addon_image ) ) : ?>
					<img src="<?php echo esc_url( $addon_image ); ?>" alt="<?php echo esc_attr( $addon_title ); ?>" style="width: 28px; height: 28px; object-fit: contain;">
				<?php else : ?>
					<?php if ( 0 === $a_idx ) : ?>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="10"></circle>
							<path d="m4.93 4.93 4.24 4.24"></path>
							<path d="m14.83 9.17 4.24-4.24"></path>
							<path d="m14.83 14.83 4.24 4.24"></path>
							<path d="m9.17 14.83-4.24 4.24"></path>
						</svg>
					<?php elseif ( 1 === $a_idx ) : ?>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
							<circle cx="12" cy="13" r="4"></circle>
						</svg>
					<?php else : ?>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
							<line x1="3" y1="9" x2="21" y2="9"></line>
							<line x1="9" y1="21" x2="9" y2="9"></line>
						</svg>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<h3 class="addition-card__title"><?php echo esc_html( $addon_title ); ?></h3>
			<div class="addition-card__pricing">
				<span class="price-current"><?php echo esc_html( $addon_price ); ?></span>
				<?php if ( ! empty( $addon_reg_price ) ) : ?>
					<span class="price-old"><?php echo esc_html( $addon_reg_price ); ?></span>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $addon_desc ) ) : ?>
				<p class="addition-card__desc"><?php echo esc_html( $addon_desc ); ?></p>
			<?php endif; ?>
			<div class="addition-card__options custom-dropdown-wrap">
				<select class="addition-card__select visually-hidden-select" aria-label="<?php esc_attr_e( 'Option', 'woodmart-child' ); ?>">
					<?php foreach ( $addon_options as $opt_val ) : ?>
						<option value="<?php echo esc_attr( $opt_val ); ?>"><?php echo esc_html( $opt_val ); ?></option>
					<?php endforeach; ?>
				</select>
				<button type="button" class="custom-dropdown-trigger" aria-haspopup="listbox" aria-expanded="false">
					<span class="custom-dropdown-label"><?php echo esc_html( $addon_options[0] ?? '' ); ?></span>
					<span class="custom-dropdown-arrow" aria-hidden="true">
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<polyline points="6 9 12 15 18 9"></polyline>
						</svg>
					</span>
				</button>
				<div class="custom-dropdown-menu" role="listbox">
					<?php foreach ( $addon_options as $opt_idx => $opt_val ) : ?>
						<div class="custom-dropdown-item <?php echo 0 === $opt_idx ? 'is-selected' : ''; ?>" role="option" data-value="<?php echo esc_attr( $opt_val ); ?>" aria-selected="<?php echo 0 === $opt_idx ? 'true' : 'false'; ?>">
							<span class="item-text"><?php echo esc_html( $opt_val ); ?></span>
							<span class="item-check" aria-hidden="true">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="20 6 9 17 4 12"></polyline>
								</svg>
							</span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="addition-card__footer">
				<div class="addition-card__qty">
					<button type="button" data-step="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woodmart-child' ); ?>">−</button>
					<input type="text" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>">
					<button type="button" data-step="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'woodmart-child' ); ?>">+</button>
				</div>
				<button type="button" class="btn addition-card__btn-add" data-product-id="<?php echo esc_attr( $addon_product_id ); ?>" data-title="<?php echo esc_attr( $addon_title ); ?>" data-price="<?php echo esc_attr( $addon_price ); ?>" data-image="<?php echo esc_url( $addon_image ); ?>">
					<span><?php esc_html_e( 'Add', 'woodmart-child' ); ?></span>
				</button>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>
