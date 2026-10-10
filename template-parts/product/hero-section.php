<?php
/**
 * Template Part: Product Hero Section
 *
 * Pixel-perfect alignment with Figma design:
 * - Breadcrumb bar at top
 * - 2-column balanced layout
 * - Vertical thumbnails with scroll navigation
 * - Main image card with "FLAGSHIP COREXY" and "Change view"
 * - Reseller badge with green verified shield icon
 * - Product title, short description, orange 5-star rating
 * - Full-width "In Stock · Tallinn" card with package icon
 * - Clean black price row with VAT toggle
 * - Unselected setup options by default with black price & variation image sync
 * - Add to sample basket button with Figma basket icon
 * - Full-width "Buying for a team?" bar
 * - 3-column Service benefits placed inside right column with orange icons
 * - Sticky section navigation
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_builder_settings( $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

$variations  = ! empty( $core['variations'] ) ? $core['variations'] : array();
$is_variable = ! empty( $core['is_variable'] ) && count( $variations ) > 1;

// By default, no variation is selected
$default_idx = -1;
$default_var = array();
?>

<!-- Breadcrumb Strip matching Figma -->
<div class="product-breadcrumb-wrap container">
	<nav class="product-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'woodmart-child' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'woodmart-child' ); ?></a>
		<span class="sep">/</span>
		<?php if ( ! empty( $core['primary_cat'] ) ) : ?>
			<a href="<?php echo esc_url( get_term_link( $core['primary_cat'] ) ); ?>"><?php echo esc_html( $core['primary_cat']->name ); ?></a>
			<span class="sep">/</span>
		<?php else : ?>
			<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>"><?php esc_html_e( '3D printers', 'woodmart-child' ); ?></a>
			<span class="sep">/</span>
		<?php endif; ?>
		<span class="current"><?php echo esc_html( $core['title'] ); ?></span>
	</nav>
</div>

<section class="product-hero container">
	<!-- Left Column: Gallery -->
	<div class="product-gallery">
		<div class="product-gallery__thumbs-wrap">
			<button type="button" class="gallery-nav-btn gallery-nav-prev" aria-label="<?php esc_attr_e( 'Previous thumbnail', 'woodmart-child' ); ?>">
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<polyline points="18 15 12 9 6 15"></polyline>
				</svg>
			</button>

			<ul class="product-gallery__thumbs">
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
				<?php endif; ?>
			</ul>

			<button type="button" class="gallery-nav-btn gallery-nav-next" aria-label="<?php esc_attr_e( 'Next thumbnail', 'woodmart-child' ); ?>">
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<polyline points="6 9 12 15 18 9"></polyline>
				</svg>
			</button>
		</div>

		<div class="product-gallery__main">
			<span class="hero-badge-corner"><?php echo esc_html( $settings['general']['eyebrow'] ?: 'FLAGSHIP COREXY' ); ?></span>

			<?php if ( ! empty( $core['main_image_url'] ) ) : ?>
				<img src="<?php echo esc_url( $core['main_image_url'] ); ?>" alt="<?php echo esc_attr( $core['title'] ); ?>" id="product-main-image">
			<?php else : ?>
				<div class="placeholder" role="img" aria-label="<?php echo esc_attr( 'Product image: ' . $core['title'] ); ?>">
					[<?php echo esc_html( $core['title'] ); ?>]
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
	<div class="product-summary">
		<!-- 2. Reseller Tag with Static Green Shield Icon -->
		<div class="product-reseller-tag">
			<span class="reseller-icon" aria-hidden="true">
				<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
					<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
					<polyline points="9 12 11 14 15 10"></polyline>
				</svg>
			</span>
			<span class="reseller-text"><?php echo esc_html( $settings['general']['badge_text'] ?: 'Authorized Bambu Lab Reseller' ); ?></span>
		</div>

		<h1 class="product-title"><?php echo esc_html( $core['title'] ); ?></h1>

		<p class="product-subtitle"><?php echo esc_html( $core['short_desc'] ); ?></p>

		<div class="product-rating-line">
			<span class="stars" aria-label="5 out of 5 stars">★★★★★</span>
			<span class="rating-quote"><?php esc_html_e( 'Built for serious making', 'woodmart-child' ); ?></span>
		</div>

		<!-- 3. Full-width In Stock Row with Package Icon and Border -->
		<?php
		$clean_stock_label = preg_replace( '/^[●•\s·]+/', '', $core['stock_label'] );
		?>
		<div class="product-stock-row">
			<span class="stock-icon" aria-hidden="true">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
					<polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
					<line x1="12" y1="22.08" x2="12" y2="12"></line>
				</svg>
			</span>
			<span class="stock-text"><?php echo esc_html( $clean_stock_label ); ?></span>
			<span class="stock-sep">·</span>
			<span class="stock-note"><?php echo esc_html( ! empty( $core['sku'] ) ? ( __( 'SKU: ', 'woodmart-child' ) . $core['sku'] ) : __( 'Demo Inventory', 'woodmart-child' ) ); ?></span>
		</div>

		<!-- 4. Price Row with Black Color and VAT toggle -->
		<div class="product-price-row" data-price-raw="<?php echo esc_attr( $core['price'] ?? 0 ); ?>">
			<div class="product-price-main">
				<span class="product-price" style="color: #111827 !important;" data-price-raw="<?php echo esc_attr( $core['price'] ?? 0 ); ?>" data-price-html="<?php echo esc_attr( $core['price_html'] ); ?>"><?php echo wp_kses_post( $core['price_html'] ); ?></span>
			</div>
			<div class="product-price-meta">
				<span class="product-price-note"><?php esc_html_e( 'incl. 24% VAT · sample price', 'woodmart-child' ); ?></span>
				<div class="product-vat-toggle">
					<a href="#packages" class="vat-link"><?php esc_html_e( 'Show ex. VAT', 'woodmart-child' ); ?></a>
				</div>
			</div>
		</div>

		<form class="product-add-to-cart-form" method="post" action="">
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="variation_id" id="selected-variation-id" value="<?php echo ! $is_variable ? esc_attr( $core['id'] ) : ''; ?>">

			<!-- 5. Choose Your Setup Options (Not selected by default, black price, image sync) -->
			<?php if ( $is_variable ) : ?>
				<fieldset class="product-configuration">
					<div class="product-configuration__head">
						<legend class="product-configuration__label"><?php esc_html_e( 'CHOOSE YOUR SETUP', 'woodmart-child' ); ?></legend>
						<a href="#packages" class="compare-packages-link"><?php esc_html_e( 'Compare packages', 'woodmart-child' ); ?></a>
					</div>
					<div class="product-configuration__options">
						<?php foreach ( $variations as $idx => $var ) : ?>
							<label class="option" data-var-id="<?php echo esc_attr( $var['id'] ); ?>">
								<input type="radio" name="setup" value="<?php echo esc_attr( $var['id'] ); ?>"
									data-combo="<?php echo ! empty( $var['is_combo'] ) ? '1' : '0'; ?>"
									data-title="<?php echo esc_attr( $var['title'] ); ?>"
									data-price-raw="<?php echo esc_attr( $var['price_raw'] ?? 0 ); ?>"
									data-price-html="<?php echo esc_attr( $var['price_html'] ); ?>"
									data-sku="<?php echo esc_attr( $var['sku'] ); ?>"
									data-image="<?php echo esc_url( $var['image_url'] ?? '' ); ?>">
								<div class="option-header">
									<span class="option-title"><?php echo esc_html( $var['title'] ); ?></span>
									<span class="option-check-icon" aria-hidden="true">
										<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
											<polyline points="20 6 9 17 4 12"></polyline>
										</svg>
									</span>
								</div>
								<span class="option-desc"><?php echo esc_html( $var['subtitle'] ); ?></span>
								<span class="option-price" style="color: #111827 !important;"><?php echo wp_kses_post( $var['price_html'] ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
					<p class="note"><?php esc_html_e( 'Selected article:', 'woodmart-child' ); ?> <span class="product-sku"><?php echo esc_html( $core['sku'] ?: '—' ); ?></span></p>
				</fieldset>
			<?php endif; ?>

			<!-- 5 (part 2). Quantity & Add to Sample Basket Button with Figma Icon -->
			<div class="product-add-to-cart">
				<div class="product-quantity">
					<button type="button" data-step="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woodmart-child' ); ?>">−</button>
					<input type="text" name="quantity" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>">
					<button type="button" data-step="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'woodmart-child' ); ?>">+</button>
				</div>
				<button class="btn btn-add-to-cart" type="submit">
					<span><?php esc_html_e( 'Add to sample basket', 'woodmart-child' ); ?></span>
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

		<!-- 6. Buying for a Team Bar with Full-width Border -->
		<div class="product-team-quote">
			<a href="#packages" class="quote-link">
				<span><?php esc_html_e( 'Buying for a team? Request a tailored quote', 'woodmart-child' ); ?></span>
				<span class="arrow">→</span>
			</a>
		</div>

		<!-- 7. 3 Service Highlights Strip (Same row, no background, no borders) -->
		<?php if ( ! empty( $settings['general']['benefits'] ) ) : ?>
			<div class="hero-service-features" aria-label="<?php esc_attr_e( 'Service highlights', 'woodmart-child' ); ?>">
				<?php
				$benefit_svgs = array(
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>',
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>',
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>',
				);
				foreach ( $settings['general']['benefits'] as $b_idx => $b ) :
					$icon_svg = $benefit_svgs[ $b_idx % count( $benefit_svgs ) ];
				?>
					<div class="hero-service-feature-item">
						<div class="hero-service-feature-icon"><?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<div class="hero-service-feature-text">
							<b class="hero-service-feature-title"><?php echo esc_html( $b['title'] ); ?></b>
							<span class="hero-service-feature-desc"><?php echo esc_html( $b['subtitle'] ); ?></span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- In-Page Sticky Navigation -->
<nav class="product-section-navigation" aria-label="<?php esc_attr_e( 'Product sections', 'woodmart-child' ); ?>">
	<ul>
		<?php if ( woodmart_child_is_section_enabled( 'highlights' ) ) : ?>
			<li><a href="#why"><?php echo esc_html( ! empty( $settings['highlights']['eyebrow'] ) ? $settings['highlights']['eyebrow'] : ( ! empty( $settings['general']['brand_name'] ) ? sprintf( __( 'Why %s', 'woodmart-child' ), $settings['general']['brand_name'] ) : __( 'Why Choose', 'woodmart-child' ) ) ); ?></a></li>
		<?php endif; ?>
		<?php if ( woodmart_child_is_section_enabled( 'features' ) ) : ?>
			<li><a href="#features"><?php esc_html_e( 'Features', 'woodmart-child' ); ?></a></li>
		<?php endif; ?>
		<?php if ( woodmart_child_is_section_enabled( 'materials' ) ) : ?>
			<li><a href="#materials"><?php esc_html_e( 'Materials', 'woodmart-child' ); ?></a></li>
		<?php endif; ?>
		<?php if ( woodmart_child_is_section_enabled( 'packages' ) ) : ?>
			<li><a href="#packages"><?php esc_html_e( 'Packages', 'woodmart-child' ); ?></a></li>
		<?php endif; ?>
		<?php if ( woodmart_child_is_section_enabled( 'specs' ) ) : ?>
			<li><a href="#specifications"><?php esc_html_e( 'Specifications', 'woodmart-child' ); ?></a></li>
		<?php endif; ?>
		<?php if ( woodmart_child_is_section_enabled( 'box_contents' ) ) : ?>
			<li><a href="#in-the-box"><?php esc_html_e( 'In the box', 'woodmart-child' ); ?></a></li>
		<?php endif; ?>
		<?php if ( woodmart_child_is_section_enabled( 'faq' ) ) : ?>
			<li><a href="#faq"><?php esc_html_e( 'FAQ', 'woodmart-child' ); ?></a></li>
		<?php endif; ?>
	</ul>
</nav>
