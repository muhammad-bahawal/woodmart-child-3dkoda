<?php
/**
 * Template Part: Technical Specifications & Setup Guide Callout
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'specs', $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}
?>

<!-- Technical Specifications -->
<section class="section product-specifications" id="specifications">
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

		<?php if ( ! empty( $data['items'] ) ) : ?>
			<dl>
				<?php foreach ( $data['items'] as $spec ) : ?>
					<div class="spec">
						<dt><?php echo esc_html( $spec['label'] ); ?></dt>
						<dd><?php echo esc_html( $spec['value'] ); ?></dd>
					</div>
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>

		<?php if ( ! empty( $data['note'] ) ) : ?>
			<p class="note"><?php echo esc_html( $data['note'] ); ?></p>
		<?php endif; ?>
	</div>
</section>

<!-- Setup Guide Banner -->
<?php if ( ! empty( $data['setup']['title'] ) ) : ?>
	<section class="container" style="padding-bottom:var(--gap)">
		<div class="setup">
			<div>
				<?php if ( ! empty( $data['setup']['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $data['setup']['eyebrow'] ); ?></span>
				<?php endif; ?>

				<h2><?php echo nl2br( esc_html( $data['setup']['title'] ) ); ?></h2>

				<?php if ( ! empty( $data['setup']['description'] ) ) : ?>
					<p><?php echo esc_html( $data['setup']['description'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $data['setup']['link_text'] ) ) : ?>
					<a class="link" href="<?php echo esc_url( $data['setup']['link_url'] ?: '#' ); ?>">
						<?php echo esc_html( $data['setup']['link_text'] ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php woodmart_child_render_image( $data['setup']['image'], 'Official setup guide', '', 'Official setup guide' ); ?>
		</div>
	</section>
<?php endif; ?>
