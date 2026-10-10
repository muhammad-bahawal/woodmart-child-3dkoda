<?php
/**
 * Template Part: Supported Materials Section & Combo Promo
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'materials', $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}
?>

<section class="section product-materials" id="materials">
	<div class="container">
		<div class="section__head">
			<?php if ( ! empty( $data['eyebrow'] ) ) : ?>
				<span class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $data['title'] ) ) : ?>
				<h2><?php echo nl2br( esc_html( $data['title'] ) ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $data['description'] ) ) : ?>
				<p><?php echo esc_html( $data['description'] ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Materials 4-Grid -->
		<?php if ( ! empty( $data['items'] ) ) : ?>
			<div class="grid grid--4">
				<?php foreach ( $data['items'] as $m ) : ?>
					<article class="card">
						<span class="dot" style="--c:<?php echo esc_attr( $m['color'] ?: '#ff6b57' ); ?>"></span>
						<span class="eyebrow" style="color:var(--text-2)"><?php echo esc_html( $m['name'] ); ?></span>
						<h3><?php echo esc_html( $m['subtitle'] ); ?></h3>
						<p><?php echo esc_html( $m['description'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Combo Promo Banner -->
		<?php if ( ! empty( $data['combo']['title'] ) ) : ?>
			<div class="combo">
				<div>
					<?php if ( ! empty( $data['combo']['eyebrow'] ) ) : ?>
						<span class="eyebrow"><?php echo esc_html( $data['combo']['eyebrow'] ); ?></span>
					<?php endif; ?>

					<h3><?php echo esc_html( $data['combo']['title'] ); ?></h3>

					<?php if ( ! empty( $data['combo']['description'] ) ) : ?>
						<p><?php echo esc_html( $data['combo']['description'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $data['combo']['link_text'] ) ) : ?>
						<a class="link" href="<?php echo esc_url( $data['combo']['link_url'] ?: '#packages' ); ?>">
							<?php echo esc_html( $data['combo']['link_text'] ); ?>
						</a>
					<?php endif; ?>
				</div>

				<?php woodmart_child_render_image( $data['combo']['image'], 'Combo image', '', 'Combo image' ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
