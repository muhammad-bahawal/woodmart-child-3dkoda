<?php
/**
 * Template Part: Pricing Packages Comparison & Brand Difference
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'packages', $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}

$variations = ! empty( $core['variations'] ) ? $core['variations'] : array();

// Match Standalone and Combo variations dynamically by is_combo flag
$standalone_var = null;
$combo_var      = null;

foreach ( $variations as $var ) {
	if ( ! empty( $var['is_combo'] ) && null === $combo_var ) {
		$combo_var = $var;
	} elseif ( empty( $var['is_combo'] ) && null === $standalone_var ) {
		$standalone_var = $var;
	}
}

if ( null === $standalone_var ) {
	$standalone_var = $variations[0] ?? array();
}
if ( null === $combo_var ) {
	$combo_var = isset( $variations[1] ) ? $variations[1] : ( $variations[0] ?? array() );
}

$default_price_html    = ! empty( $core['price_html'] ) ? $core['price_html'] : ( function_exists( 'wc_price' ) ? wc_price( 0 ) : '€0.00' );
$standalone_price_html = ! empty( $standalone_var['price_html'] ) ? $standalone_var['price_html'] : $default_price_html;
$combo_price_html      = ! empty( $combo_var['price_html'] ) ? $combo_var['price_html'] : ( isset( $variations[1]['price_html'] ) ? $variations[1]['price_html'] : $default_price_html );

$standalone_bullets = array();
if ( ! empty( $data['standalone']['bullets'] ) ) {
	$standalone_bullets = array_filter( array_map( 'trim', explode( "\n", $data['standalone']['bullets'] ) ) );
}

$combo_bullets = array();
if ( ! empty( $data['combo']['bullets'] ) ) {
	$combo_bullets = array_filter( array_map( 'trim', explode( "\n", $data['combo']['bullets'] ) ) );
}
?>

<!-- Packages Comparison Grid - Figma Specification -->
<section class="section product-comparison" id="packages">
	<div class="container">
		<div class="section__head">
			<?php if ( ! empty( $data['eyebrow'] ) ) : ?>
				<span class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $data['title'] ) ) : ?>
				<h2><?php echo esc_html( $data['title'] ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $data['description'] ) ) : ?>
				<p><?php echo esc_html( $data['description'] ); ?></p>
			<?php endif; ?>
		</div>

		<div class="product-comparison__grid">
			<!-- Standalone Plan -->
			<article class="card plan" data-setup="standalone" data-variation-id="<?php echo esc_attr( $standalone_var['id'] ?? '' ); ?>">
				<?php if ( ! empty( $data['standalone']['eyebrow'] ) ) : ?>
					<span class="plan__eyebrow"><?php echo esc_html( $data['standalone']['eyebrow'] ); ?></span>
				<?php endif; ?>

				<h3 class="plan__title"><?php echo esc_html( $data['standalone']['title'] ); ?></h3>
				<p class="price"><?php echo wp_kses_post( $standalone_price_html ); ?></p>

				<?php if ( ! empty( $data['standalone']['price_note'] ) ) : ?>
					<small class="plan__price-note"><?php echo esc_html( $data['standalone']['price_note'] ); ?></small>
				<?php endif; ?>

				<?php if ( ! empty( $data['standalone']['description'] ) ) : ?>
					<p class="plan__desc"><?php echo esc_html( $data['standalone']['description'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $standalone_bullets ) ) : ?>
					<ul class="plan__bullets">
						<?php foreach ( $standalone_bullets as $bullet ) : ?>
							<li><?php echo esc_html( $bullet ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<button type="button" class="btn btn--plan" data-select-setup="standalone">
					<span><?php echo esc_html( $data['standalone']['btn_text'] ?: __( 'Choose Standalone', 'woodmart-child' ) ); ?></span>
					<span class="btn-arrow" aria-hidden="true">→</span>
				</button>
			</article>

			<!-- Combo Plan -->
			<article class="card plan plan--combo" data-setup="combo" data-variation-id="<?php echo esc_attr( $combo_var['id'] ?? '' ); ?>">
				<?php if ( ! empty( $data['combo']['badge'] ) ) : ?>
					<span class="badge-rec"><?php echo esc_html( $data['combo']['badge'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $data['combo']['eyebrow'] ) ) : ?>
					<span class="plan__eyebrow"><?php echo esc_html( $data['combo']['eyebrow'] ); ?></span>
				<?php endif; ?>

				<h3 class="plan__title"><?php echo esc_html( $data['combo']['title'] ); ?></h3>
				<p class="price"><?php echo wp_kses_post( $combo_price_html ); ?></p>

				<?php if ( ! empty( $data['combo']['price_note'] ) ) : ?>
					<small class="plan__price-note"><?php echo esc_html( $data['combo']['price_note'] ); ?></small>
				<?php endif; ?>

				<?php if ( ! empty( $data['combo']['description'] ) ) : ?>
					<p class="plan__desc"><?php echo esc_html( $data['combo']['description'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $combo_bullets ) ) : ?>
					<ul class="plan__bullets">
						<?php foreach ( $combo_bullets as $bullet ) : ?>
							<li><?php echo esc_html( $bullet ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<button type="button" class="btn btn--plan" data-select-setup="combo">
					<span><?php echo esc_html( $data['combo']['btn_text'] ?: __( 'Choose Combo', 'woodmart-child' ) ); ?></span>
					<span class="btn-arrow" aria-hidden="true">→</span>
				</button>
			</article>
		</div>
	</div>
</section>

<!-- Local Brand Difference Section - Figma Specification -->
<?php if ( ! empty( $data['brand']['title'] ) ) : ?>
	<?php
	$brand_icons = array(
		// 1. Tallinn-based stock - Pin / Location
		'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>',
		// 2. Warranty guidance - Shield with checkmark
		'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>',
		// 3. Practical diagnostics - Gear / Settings
		'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>',
		// 4. Business purchasing - Document / Invoice
		'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
	);
	?>
	<section class="section dark product-brand" id="brand-difference">
		<div class="container product-brand__wrap">
			<div class="product-brand__content">
				<?php if ( ! empty( $data['brand']['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $data['brand']['eyebrow'] ); ?></span>
				<?php endif; ?>

				<h2 class="product-brand__title"><?php echo nl2br( esc_html( $data['brand']['title'] ) ); ?></h2>

				<?php if ( ! empty( $data['brand']['description'] ) ) : ?>
					<p class="product-brand__desc"><?php echo esc_html( $data['brand']['description'] ); ?></p>
				<?php endif; ?>

				<a class="product-brand__link" href="<?php echo esc_url( $data['brand']['btn_url'] ?: '#' ); ?>">
					<span><?php echo esc_html( $data['brand']['btn_text'] ?: __( 'Talk to a local expert', 'woodmart-child' ) ); ?></span>
					<span class="arrow" aria-hidden="true">→</span>
				</a>
			</div>

			<?php if ( ! empty( $data['brand']['cards'] ) ) : ?>
				<div class="product-brand__grid">
					<?php foreach ( $data['brand']['cards'] as $c_idx => $card ) :
						$c_icon = isset( $brand_icons[ $c_idx ] ) ? $brand_icons[ $c_idx ] : $brand_icons[0];
					?>
						<div class="brand-feature">
							<div class="brand-feature__header">
								<span class="brand-feature__icon"><?php echo $c_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								<h3 class="brand-feature__title"><?php echo esc_html( $card['title'] ); ?></h3>
							</div>
							<p class="brand-feature__desc"><?php echo esc_html( $card['description'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
