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

<!-- Local Brand Difference Section -->
<?php if ( ! empty( $data['brand']['title'] ) ) : ?>
	<section class="section dark product-brand">
		<div class="container grid" style="grid-template-columns:1fr 1.6fr;gap:40px">
			<div>
				<?php if ( ! empty( $data['brand']['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $data['brand']['eyebrow'] ); ?></span>
				<?php endif; ?>

				<h2 style="font-size:clamp(26px,3.4vw,38px)"><?php echo nl2br( esc_html( $data['brand']['title'] ) ); ?></h2>

				<?php if ( ! empty( $data['brand']['description'] ) ) : ?>
					<p class="muted" style="margin:14px 0 20px"><?php echo esc_html( $data['brand']['description'] ); ?></p>
				<?php endif; ?>

				<a class="btn btn--ghost" href="<?php echo esc_url( $data['brand']['btn_url'] ?: '#' ); ?>">
					<?php echo esc_html( $data['brand']['btn_text'] ?: __( 'Talk to a local expert', 'woodmart-child' ) ); ?>
				</a>
			</div>

			<?php if ( ! empty( $data['brand']['cards'] ) ) : ?>
				<div class="grid grid--2">
					<?php foreach ( $data['brand']['cards'] as $card ) : ?>
						<article class="card">
							<h3><?php echo esc_html( $card['title'] ); ?></h3>
							<p><?php echo esc_html( $card['description'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
