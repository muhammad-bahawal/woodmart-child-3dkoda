<?php
/**
 * Template Part: Filament Product Hero Section
 *
 * Pixel-perfect alignment with Figma / Prototype for Filament Products:
 * - Breadcrumb bar (Home / Filaments / Product Name)
 * - 2-Column responsive layout
 * - Vertical thumbnails strip + Main image preview
 * - Distinctive RFID badge in top-left of image preview
 * - "Change view" bottom-right overlay button
 * - Green Authorized Reseller tag
 * - Large product title & short description (from default WooCommerce product)
 * - 5-star rating with tagline "Built for everyday making"
 * - In Stock — Tallinn pill/card with package icon
 * - Price row with VAT note & Show ex. VAT link
 * - Dynamic variations handling: swatches & format cards ONLY render when product has variations
 * - Quantity stepper + Orange "Add to basket" button with padlock icon
 * - Full-width "Buying for a team? Request a tailored quote →" button
 * - 3 Service highlights with orange outline icons
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_filament_builder_settings( $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

// Default WooCommerce data takes full authority (matching 3D printer logic)
$title           = $core['title'];
$subtitle        = $core['short_desc'];
$price_display   = $core['price_html'];
$badge_text      = ! empty( $settings['general']['badge_text'] ) ? $settings['general']['badge_text'] : __( 'Authorized Bambu Lab Reseller', 'woodmart-child' );
$rating_text     = ! empty( $settings['general']['rating_text'] ) ? $settings['general']['rating_text'] : __( 'Built for everyday making', 'woodmart-child' );

// 100% Dynamic Stock Status via WooCommerce Native Methods
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

$stock_note      = ! empty( $settings['general']['stock_note'] ) ? $settings['general']['stock_note'] : ( ! empty( $core['sku'] ) ? ( __( 'SKU: ', 'woodmart-child' ) . $core['sku'] ) : '' );
$vat_note        = ! empty( $settings['general']['vat_note'] ) ? $settings['general']['vat_note'] : __( 'incl. 24% VAT', 'woodmart-child' );
$ex_vat_text     = ! empty( $settings['general']['ex_vat_text'] ) ? $settings['general']['ex_vat_text'] : __( 'Show ex. VAT', 'woodmart-child' );
$team_quote_text = ! empty( $settings['general']['team_quote_text'] ) ? $settings['general']['team_quote_text'] : __( 'Buying for a team? Request a tailored quote →', 'woodmart-child' );
$benefits        = ! empty( $settings['general']['benefits'] ) ? $settings['general']['benefits'] : array();

// Check if product is variable
$variations  = ! empty( $core['variations'] ) ? $core['variations'] : array();
$is_variable = ! empty( $core['is_variable'] ) && count( $variations ) > 1;

// Discover WooCommerce Default Form Values set by admin in backend
$product_obj         = ( ! empty( $core['product'] ) && $core['product'] instanceof WC_Product ) ? $core['product'] : wc_get_product( $core['id'] );
$attributes          = ( $product_obj instanceof WC_Product ) ? $product_obj->get_attributes() : array();
$default_attributes  = ( $product_obj instanceof WC_Product ) ? $product_obj->get_default_attributes() : array();
$default_color_slug  = '';
$default_format_slug = '';

if ( ! empty( $default_attributes ) ) {
	foreach ( $default_attributes as $d_key => $d_val ) {
		$d_key_clean = strtolower( trim( str_replace( 'attribute_', '', $d_key ) ) );
		$d_val_clean = strtolower( trim( (string) $d_val ) );
		if ( false !== stripos( $d_key_clean, 'color' ) ) {
			$default_color_slug = $d_val_clean;
		} else {
			$default_format_slug = $d_val_clean;
		}
	}
}

// Pre-match active color display if default exists
$active_color_name    = '';
$active_color_display = '';
if ( function_exists( 'woodmart_child_get_filament_color_options' ) ) {
	$init_color_options = woodmart_child_get_filament_color_options( $core['id'] );
	if ( $default_color_slug && ! empty( $init_color_options ) ) {
		foreach ( $init_color_options as $c ) {
			if ( $c['slug'] === $default_color_slug || sanitize_title( $c['name'] ) === $default_color_slug || strtolower( $c['name'] ) === $default_color_slug ) {
				$active_color_name    = $c['name'];
				$active_color_display = $c['display'];
				break;
			}
		}
	}
}
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
			<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>"><?php esc_html_e( 'Filaments', 'woodmart-child' ); ?></a>
			<span class="sep">/</span>
		<?php endif; ?>
		<span class="current"><?php echo esc_html( $title ); ?></span>
	</nav>
</div>

<section class="product-hero container filament-hero">
	<!-- Left Column: Gallery -->
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
			<!-- Distinctive RFID Badge in Top-Left matching Prototype -->
			<div class="filament-rfid-badge" aria-label="<?php esc_attr_e( 'RFID Enabled', 'woodmart-child' ); ?>">
				<svg class="filament-rfid-icon" width="46" height="30" viewBox="0 0 60 40" fill="none" stroke="#111827" stroke-width="3.5" stroke-linecap="round">
					<path d="M 6,36 A 24,24 0 0,1 54,36" />
					<path d="M 14,36 A 16,16 0 0,1 46,36" />
					<path d="M 22,36 A 8,8 0 0,1 38,36" />
				</svg>
				<span class="filament-rfid-text">RFID</span>
			</div>

			<?php
			$default_img_src    = ! empty( $core['main_image_url'] ) ? $core['main_image_url'] : '';
			$default_img_id     = ! empty( $core['main_image_id'] ) ? $core['main_image_id'] : 0;
			$default_img_srcset = $default_img_id ? ( wp_get_attachment_image_srcset( $default_img_id, 'full' ) ?: '' ) : '';
			if ( ! empty( $default_img_src ) ) : ?>
				<img src="<?php echo esc_url( $default_img_src ); ?>" <?php echo $default_img_srcset ? 'srcset="' . esc_attr( $default_img_srcset ) . '"' : ''; ?> alt="<?php echo esc_attr( $title ); ?>" id="product-main-image" data-default-src="<?php echo esc_url( $default_img_src ); ?>" data-default-srcset="<?php echo esc_attr( $default_img_srcset ); ?>">
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

	<!-- Right Column: Summary & Controls -->
	<div class="product-summary">
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

		<!-- 2. Product Title & Subtitle (From Default WooCommerce) -->
		<h1 class="product-title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( ! empty( $subtitle ) ) : ?>
			<div class="product-subtitle"><?php echo apply_filters( 'woocommerce_short_description', $subtitle ); ?></div>
		<?php endif; ?>

		<!-- 3. Star Rating & Tagline -->
		<div class="product-rating-line">
			<span class="stars" aria-label="5 out of 5 stars">★★★★★</span>
			<span class="rating-quote"><?php echo esc_html( $rating_text ); ?></span>
		</div>

		<!-- 4. Dynamic Stock Banner (WooCommerce Inventory Synced) -->
		<div class="product-stock-row <?php echo esc_attr( $stock_class ); ?>" id="filament-stock-row">
			<span class="stock-icon" aria-hidden="true">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
					<polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
					<line x1="12" y1="22.08" x2="12" y2="12"></line>
				</svg>
			</span>
			<span class="stock-text" id="filament-stock-text"><?php echo esc_html( $stock_text ); ?></span>
			<span class="stock-sep">·</span>
			<span class="stock-note" id="filament-stock-note"><?php echo esc_html( $stock_note ); ?></span>
		</div>

		<!-- 5. Price Display Row -->
		<div class="product-price-row filament-price-row" data-price-raw="<?php echo esc_attr( $core['price'] ?? 0 ); ?>">
			<div class="product-price-main">
				<span class="product-price filament-current-price" style="color: #111827 !important;"><?php echo wp_kses_post( $price_display ); ?></span>
			</div>
			<div class="product-price-meta">
				<span class="product-price-note"><?php echo esc_html( $vat_note ); ?></span>
				<div class="product-vat-toggle">
					<a href="#packages" class="vat-link"><?php echo esc_html( $ex_vat_text ); ?></a>
				</div>
			</div>
		</div>

		<!-- 6. Form & Swatches -->
		<form class="product-add-to-cart-form filament-purchase-form" method="post" action="" data-default-color="<?php echo esc_attr( $default_color_slug ); ?>" data-default-format="<?php echo esc_attr( $default_format_slug ); ?>">
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $core['id'] ); ?>">
			<input type="hidden" name="variation_id" id="selected-variation-id" value="<?php echo ! $is_variable ? esc_attr( $core['id'] ) : ''; ?>">
			<input type="hidden" name="filament_color" id="selected-filament-color" value="<?php echo esc_attr( $active_color_name ); ?>">
			<input type="hidden" name="filament_format" id="selected-filament-format" value="<?php echo esc_attr( $default_format_slug ); ?>">

			<!-- VARIATIONS BLOCK: Only displayed when product is variable in WooCommerce -->
			<?php if ( $is_variable ) : ?>
				<?php
				// 1. Build Color Options dynamically from WooCommerce attributes
				$color_options = function_exists( 'woodmart_child_get_filament_color_options' ) ? woodmart_child_get_filament_color_options( $core['id'] ) : array();

				// Discover Format / Packaging attribute
				$format_attr = null;
				foreach ( $attributes as $attr_key => $attr_val ) {
					$attr_name = is_object( $attr_val ) && method_exists( $attr_val, 'get_name' ) ? $attr_val->get_name() : $attr_key;
					if ( false === stripos( $attr_key, 'color' ) && false === stripos( $attr_name, 'color' ) && is_object( $attr_val ) && method_exists( $attr_val, 'get_variation' ) && $attr_val->get_variation() ) {
						$format_attr = $attr_val;
						break;
					}
				}

				// 2. Build Format Options (The 2 Packaging Boxes: Complete Spool vs Refill)
				$format_options = array();
				if ( $format_attr ) {
					if ( $format_attr->is_taxonomy() ) {
						$f_terms = wc_get_product_terms( $core['id'], $format_attr->get_name(), array( 'fields' => 'all' ) );
						if ( ! is_wp_error( $f_terms ) && ! empty( $f_terms ) ) {
							foreach ( $f_terms as $ft ) {
								$desc = $ft->description;
								if ( empty( $desc ) ) {
									if ( false !== stripos( $ft->name, 'spool' ) ) {
										$desc = __( 'Ready-to-print 1 kg spool for everyday PLA work.', 'woodmart-child' );
									} elseif ( false !== stripos( $ft->name, 'refill' ) ) {
										$desc = __( '1 kg refill for a reusable spool. Lower packaging, same material.', 'woodmart-child' );
									} else {
										$desc = __( 'Standard packaging format.', 'woodmart-child' );
									}
								}
								$format_options[] = array(
									'name' => $ft->name,
									'slug' => $ft->slug,
									'desc' => $desc,
								);
							}
						}
					} else {
						$raw_f_opts = $format_attr->get_options();
						foreach ( $raw_f_opts as $rfo ) {
							$desc = '';
							if ( false !== stripos( $rfo, 'spool' ) ) {
								$desc = __( 'Ready-to-print 1 kg spool for everyday PLA work.', 'woodmart-child' );
							} elseif ( false !== stripos( $rfo, 'refill' ) ) {
								$desc = __( '1 kg refill for a reusable spool. Lower packaging, same material.', 'woodmart-child' );
							}
							$format_options[] = array(
								'name' => $rfo,
								'slug' => sanitize_title( $rfo ),
								'desc' => $desc,
							);
						}
					}
				}

				// Fallback if no specific format attribute, but product has variations
				if ( empty( $format_options ) && empty( $color_options ) ) {
					foreach ( $variations as $var ) {
						$format_options[] = array(
							'name' => $var['title'],
							'slug' => sanitize_title( $var['title'] ),
							'desc' => $var['subtitle'] ?? '',
						);
					}
				}

				// 3. Build Variation Matrix for dynamic client-side pairing
				$available_variations = ( $product_obj instanceof WC_Product_Variable ) ? $product_obj->get_available_variations() : array();
				$matrix = array();
				$initial_format_prices = array();

				$first_color_slug = ! empty( $color_options[0]['slug'] ) ? $color_options[0]['slug'] : '';

				foreach ( $available_variations as $av ) {
					$v_attrs = $av['attributes'];
					$c_slug  = '';
					$f_slug  = '';

					foreach ( $v_attrs as $ak => $val ) {
						if ( false !== stripos( $ak, 'color' ) ) {
							$c_slug = strtolower( trim( $val ) );
						} else {
							$f_slug = strtolower( trim( $val ) );
						}
					}

					$var_obj = wc_get_product( $av['variation_id'] );
					$v_in_stock = $var_obj ? $var_obj->is_in_stock() : ( ! empty( $av['is_in_stock'] ) );
					$v_stock_status = $var_obj ? $var_obj->get_stock_status() : ( $v_in_stock ? 'instock' : 'outofstock' );
					$v_backorder = ( 'onbackorder' === $v_stock_status ) || ( $var_obj && $var_obj->is_on_backorder() );

					if ( $v_backorder ) {
						$v_stock_text  = __( 'Available on Backorder', 'woodmart-child' );
						$v_stock_state = 'backorder';
					} elseif ( $v_in_stock && 'outofstock' !== $v_stock_status ) {
						$v_stock_text  = __( 'In Stock', 'woodmart-child' );
						$v_stock_state = 'instock';
					} else {
						$v_stock_text  = __( 'Out of Stock', 'woodmart-child' );
						$v_stock_state = 'outofstock';
					}

					// Dynamic image and srcset extraction
					$v_img_id = ! empty( $av['image_id'] ) ? absint( $av['image_id'] ) : 0;
					if ( ! $v_img_id && ! empty( $av['variation_id'] ) ) {
						$v_img_id = absint( get_post_thumbnail_id( $av['variation_id'] ) );
						if ( ! $v_img_id && $var_obj && method_exists( $var_obj, 'get_image_id' ) ) {
							$v_img_id = absint( $var_obj->get_image_id() );
						}
					}

					$v_img_url    = '';
					$v_img_srcset = '';
					if ( $v_img_id ) {
						$v_img_url    = wp_get_attachment_image_url( $v_img_id, 'full' );
						$v_img_srcset = wp_get_attachment_image_srcset( $v_img_id, 'full' ) ?: '';
					}
					if ( empty( $v_img_url ) && ! empty( $av['image'] ) ) {
						$v_img_url    = ! empty( $av['image']['full_src'] ) ? $av['image']['full_src'] : ( ! empty( $av['image']['src'] ) ? $av['image']['src'] : ( ! empty( $av['image']['url'] ) ? $av['image']['url'] : '' ) );
						$v_img_srcset = ! empty( $av['image']['srcset'] ) ? $av['image']['srcset'] : '';
					}

					$v_price_html = $av['price_html'] ?: wc_price( $av['display_price'] );
					$v_sku = $av['sku'] ?: ( $var_obj ? $var_obj->get_sku() : $core['sku'] );

					$matrix[] = array(
						'id'           => $av['variation_id'],
						'color'        => $c_slug,
						'format'       => $f_slug,
						'price_raw'    => $av['display_price'],
						'price_html'   => $v_price_html,
						'sku'          => $v_sku,
						'image'        => $v_img_url,
						'srcset'       => $v_img_srcset,
						'in_stock'     => $v_in_stock,
						'stock_status' => $v_stock_state,
						'stock_text'   => $v_stock_text,
						'gallery'      => woodmart_child_get_variation_gallery_images( $av['variation_id'], $core['id'], $av ),
					);

					if ( $f_slug && ( empty( $first_color_slug ) || $c_slug === $first_color_slug ) ) {
						$initial_format_prices[ $f_slug ] = $v_price_html;
					} elseif ( $f_slug && ! isset( $initial_format_prices[ $f_slug ] ) ) {
						$initial_format_prices[ $f_slug ] = $v_price_html;
					}
				}
				?>

				<?php if ( ! empty( $color_options ) ) : ?>
					<!-- COLOR SWATCHES (From WooCommerce Product Attributes) -->
					<div class="filament-colors-block">
						<div class="filament-colors-header">
							<div class="filament-colors-label">
								<?php esc_html_e( 'COLOR :', 'woodmart-child' ); ?> <span class="active-color-name <?php echo $active_color_display ? '' : 'is-placeholder'; ?>" id="active-filament-color-name"><?php echo esc_html( $active_color_display ?: __( 'Select a color', 'woodmart-child' ) ); ?></span>
							</div>
							<a href="#find-colors" class="filament-view-colors-link"><?php esc_html_e( 'View all colors ›', 'woodmart-child' ); ?></a>
						</div>

						<div class="filament-swatches-grid" role="radiogroup" aria-label="<?php esc_attr_e( 'Filament Color Swatches', 'woodmart-child' ); ?>">
							<?php foreach ( $color_options as $c_idx => $c ) : 
								$is_c_active = ( $default_color_slug && ( $c['slug'] === $default_color_slug || sanitize_title( $c['name'] ) === $default_color_slug || strtolower( $c['name'] ) === $default_color_slug ) );
							?>
								<button type="button" 
										class="filament-swatch <?php echo $is_c_active ? 'is-active' : ''; ?>" 
										data-color-name="<?php echo esc_attr( $c['name'] ); ?>" 
										data-color-display="<?php echo esc_attr( $c['display'] ); ?>" 
										data-color-hex="<?php echo esc_attr( $c['hex'] ); ?>" 
										data-slug="<?php echo esc_attr( $c['slug'] ); ?>"
										style="--swatch-hex: <?php echo esc_attr( $c['hex'] ); ?>; background-color: <?php echo esc_attr( $c['hex'] ); ?> !important;" 
										title="<?php echo esc_attr( $c['name'] ); ?>"
										aria-label="<?php echo esc_attr( $c['name'] ); ?>">
								</button>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $format_options ) ) : ?>
					<!-- FORMAT / PACKAGING TYPE CARDS (The 2 Boxes: Complete Spool vs Refill) -->
					<div class="filament-formats-block">
						<div class="filament-formats-grid">
							<?php foreach ( $format_options as $fo ) :
								$f_slug  = $fo['slug'];
								$f_title = $fo['name'];
								$f_desc  = $fo['desc'];
								$f_price = $initial_format_prices[ $f_slug ] ?? $core['price_html'];
								$is_f_active = false;
								if ( $default_format_slug ) {
									if ( $f_slug === $default_format_slug || sanitize_title( $f_title ) === $default_format_slug || strtolower( $f_title ) === $default_format_slug ) {
										$is_f_active = true;
									} elseif ( false !== stripos( $default_format_slug, 'spool' ) && false !== stripos( $f_slug, 'spool' ) ) {
										$is_f_active = true;
									} elseif ( false !== stripos( $default_format_slug, 'refill' ) && false !== stripos( $f_slug, 'refill' ) ) {
										$is_f_active = true;
									}
								}
							?>
								<div class="filament-format-card <?php echo $is_f_active ? 'is-active' : ''; ?>" 
									 data-format="<?php echo esc_attr( $f_slug ); ?>"
									 data-title="<?php echo esc_attr( $f_title ); ?>">
									<div class="format-card-top">
										<div class="format-card-check">
											<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
												<polyline points="20 6 9 17 4 12"></polyline>
											</svg>
										</div>
										<span class="format-card-title"><?php echo esc_html( $f_title ); ?></span>
									</div>
									<?php if ( ! empty( $f_desc ) ) : ?>
										<div class="format-card-desc"><?php echo esc_html( $f_desc ); ?></div>
									<?php endif; ?>
									<div class="format-card-price" data-format-slot="<?php echo esc_attr( $f_slug ); ?>">
										<?php echo wp_kses_post( $f_price ); ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>

						<p class="filament-selected-variation-note">
							<?php esc_html_e( 'Selected variation:', 'woodmart-child' ); ?> <span id="filament-variation-summary"><?php echo esc_html( $core['sku'] ?: '—' ); ?></span>
						</p>
					</div>
				<?php endif; ?>

				<script type="application/json" id="filament-variation-matrix">
					<?php echo wp_json_encode( $matrix ); ?>
				</script>
			<?php endif; ?>

			<!-- Quantity Stepper + Add to Basket Button -->
			<?php
			$has_default_selection = ( $default_color_slug && $default_format_slug );
			?>
			<div class="product-add-to-cart filament-add-row">
				<div class="product-quantity">
					<button type="button" data-step="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woodmart-child' ); ?>">−</button>
					<input type="text" name="quantity" value="1" aria-label="<?php esc_attr_e( 'Quantity', 'woodmart-child' ); ?>">
					<button type="button" data-step="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'woodmart-child' ); ?>">+</button>
				</div>
				<button class="btn btn-add-to-cart filament-btn-add-to-cart <?php echo ( $is_variable && ! $has_default_selection ) ? 'is-disabled' : ''; ?>" type="submit" <?php echo ( $is_variable && ! $has_default_selection ) ? 'data-state="unselected"' : 'data-state="ready"'; ?>>
					<span class="btn-text"><?php echo ( $is_variable && ! $has_default_selection ) ? esc_html__( 'Please select a color', 'woodmart-child' ) : esc_html__( 'Add to basket', 'woodmart-child' ); ?></span>
					<span class="cart-icon" aria-hidden="true">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
							<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
						</svg>
					</span>
				</button>
			</div>
		</form>

		<!-- 7. Team Quote Bar -->
		<div class="product-team-quote">
			<a href="#packages" class="quote-link">
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
