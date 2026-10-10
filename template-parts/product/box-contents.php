<?php
/**
 * Template Part: Package Contents Section (In The Box)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'box_contents', $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}
$core        = woodmart_child_get_core_product_data( $product_id );
$variations  = ! empty( $core['variations'] ) ? $core['variations'] : array();
$default_idx = ( count( $variations ) > 1 ) ? 1 : 0;
?>

<section class="section product-package-contents" id="in-the-box" style="padding-top:0">
	<div class="container">
		<div class="section__head">
			<?php if ( ! empty( $data['eyebrow'] ) ) : ?>
				<span class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $data['title'] ) ) : ?>
				<h2><?php echo esc_html( $data['title'] ); ?></h2>
			<?php endif; ?>
		</div>

		<div class="product-package-contents__grid">
			<!-- Standalone Items -->
			<article class="card pkg <?php echo ( 0 === $default_idx ) ? 'is-active' : ''; ?>" data-select-setup="standalone" tabindex="0" role="button" aria-label="<?php esc_attr_e( 'Choose Standalone setup', 'woodmart-child' ); ?>">
				<h3><?php echo esc_html( $data['standalone_title'] ?: 'X1–Carbon' ); ?></h3>

				<?php if ( ! empty( $data['standalone_items'] ) ) : ?>
					<ul>
						<?php foreach ( $data['standalone_items'] as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</article>

			<!-- Combo Items (Recommended) -->
			<article class="card pkg pkg--rec <?php echo ( 1 === $default_idx ) ? 'is-active' : ''; ?>" data-select-setup="combo" tabindex="0" role="button" aria-label="<?php esc_attr_e( 'Choose Combo setup', 'woodmart-child' ); ?>">
				<?php if ( ! empty( $data['combo_badge'] ) ) : ?>
					<span class="badge-rec"><?php echo esc_html( $data['combo_badge'] ); ?></span>
				<?php endif; ?>

				<h3><?php echo esc_html( $data['combo_title'] ?: 'X1–Carbon Combo' ); ?></h3>

				<?php if ( ! empty( $data['combo_items'] ) ) : ?>
					<ul>
						<?php foreach ( $data['combo_items'] as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</article>
		</div>

		<?php if ( ! empty( $data['note'] ) ) : ?>
			<p class="note"><?php echo esc_html( $data['note'] ); ?></p>
		<?php endif; ?>
	</div>
</section>
