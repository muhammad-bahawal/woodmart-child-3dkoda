<?php
/**
 * Template Part: Product Use Cases Section (Dark)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'use_cases', $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}
?>

<section class="section dark product-use-cases">
	<div class="container">
		<div class="section__head">
			<?php if ( ! empty( $data['eyebrow'] ) ) : ?>
				<span class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $data['title'] ) ) : ?>
				<h2><?php echo nl2br( esc_html( $data['title'] ) ); ?></h2>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $data['items'] ) ) : ?>
			<div class="grid grid--4">
				<?php foreach ( $data['items'] as $uc ) : ?>
					<article class="card">
						<?php if ( ! empty( $uc['num'] ) ) : ?>
							<span class="num"><?php echo esc_html( $uc['num'] ); ?></span>
						<?php endif; ?>

						<h3><?php echo esc_html( $uc['title'] ); ?></h3>

						<?php if ( ! empty( $uc['description'] ) ) : ?>
							<p class="muted" style="font-size:12px;margin-top:6px"><?php echo esc_html( $uc['description'] ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
