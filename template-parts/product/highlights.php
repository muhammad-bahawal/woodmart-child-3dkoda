<?php
/**
 * Template Part: Highlights & Stats Section
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'highlights', $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}
?>

<section class="section product-intro" id="why">
	<div class="container">
		<?php if ( ! empty( $data['eyebrow'] ) ) : ?>
			<span class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $data['title'] ) ) : ?>
			<h2><?php echo nl2br( esc_html( $data['title'] ) ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $data['description'] ) ) : ?>
			<p><?php echo esc_html( $data['description'] ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $data['items'] ) ) : ?>
			<div class="stats">
				<?php foreach ( $data['items'] as $item ) : ?>
					<div>
						<b><?php echo esc_html( $item['value'] ); ?></b>
						<span><?php echo esc_html( $item['label'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
