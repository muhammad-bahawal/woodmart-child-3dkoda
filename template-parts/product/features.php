<?php
/**
 * Template Part: Product Features Section (Dark)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'features', $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}

$main_bullets = array();
if ( ! empty( $data['main']['bullets'] ) ) {
	$main_bullets = array_filter( array_map( 'trim', explode( "\n", $data['main']['bullets'] ) ) );
}
?>

<section class="section dark product-features" id="features">
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

		<!-- Main Hero Feature -->
		<?php if ( ! empty( $data['main']['title'] ) ) : ?>
			<div class="feature-main">
				<?php woodmart_child_render_image( $data['main']['image'], $data['main']['title'], '', 'Product image' ); ?>

				<div>
					<?php if ( ! empty( $data['main']['num'] ) ) : ?>
						<span class="num"><?php echo esc_html( $data['main']['num'] ); ?></span>
					<?php endif; ?>

					<h3 style="font-size:22px"><?php echo esc_html( $data['main']['title'] ); ?></h3>

					<?php if ( ! empty( $data['main']['description'] ) ) : ?>
						<p class="muted" style="margin-top:10px;font-size:12px"><?php echo esc_html( $data['main']['description'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $main_bullets ) ) : ?>
						<ul>
							<?php foreach ( $main_bullets as $bullet ) : ?>
								<li><?php echo esc_html( $bullet ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- 4-Grid Features -->
		<?php if ( ! empty( $data['grid'] ) ) : ?>
			<div class="grid grid--4">
				<?php foreach ( $data['grid'] as $fg ) : ?>
					<article class="feature">
						<?php if ( ! empty( $fg['num'] ) ) : ?>
							<span class="num"><?php echo esc_html( $fg['num'] ); ?></span>
						<?php endif; ?>
						<h3><?php echo esc_html( $fg['title'] ); ?></h3>
						<p><?php echo esc_html( $fg['description'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
