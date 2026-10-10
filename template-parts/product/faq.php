<?php
/**
 * Template Part: Product FAQ Accordion & Bottom Call To Action Banner
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'faq', $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}
?>

<!-- FAQ Accordion -->
<section class="section product-faq" id="faq" style="padding-top:0">
	<div class="container product-faq__layout">
		<div>
			<?php if ( ! empty( $data['eyebrow'] ) ) : ?>
				<span class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $data['title'] ) ) : ?>
				<h2><?php echo esc_html( $data['title'] ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $data['description'] ) ) : ?>
				<p class="muted"><?php echo esc_html( $data['description'] ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $data['btn_text'] ) ) : ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( $data['btn_url'] ?: '#' ); ?>">
					<?php echo esc_html( $data['btn_text'] ); ?>
				</a>
			<?php endif; ?>
		</div>

		<div>
			<?php if ( ! empty( $data['items'] ) ) : ?>
				<?php foreach ( $data['items'] as $idx => $f ) : ?>
					<details <?php echo 0 === $idx ? 'open' : ''; ?>>
						<summary><?php echo esc_html( $f['question'] ); ?></summary>
						<p><?php echo wp_kses_post( $f['answer'] ); ?></p>
					</details>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Bottom Orange Call to Action Banner -->
<?php if ( ! empty( $data['cta']['title'] ) ) : ?>
	<section class="section product-cta">
		<div class="container">
			<div>
				<?php if ( ! empty( $data['cta']['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $data['cta']['eyebrow'] ); ?></span>
				<?php endif; ?>

				<h2><?php echo wp_kses_post( $data['cta']['title'] ); ?></h2>

				<?php if ( ! empty( $data['cta']['description'] ) ) : ?>
					<p><?php echo esc_html( $data['cta']['description'] ); ?></p>
				<?php endif; ?>
			</div>

			<div class="btns">
				<?php if ( ! empty( $data['cta']['btn1_text'] ) ) : ?>
					<a class="btn btn--dark" href="<?php echo esc_url( $data['cta']['btn1_url'] ?: '#packages' ); ?>">
						<?php echo esc_html( $data['cta']['btn1_text'] ); ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $data['cta']['btn2_text'] ) ) : ?>
					<a class="btn" href="<?php echo esc_url( $data['cta']['btn2_url'] ?: '#' ); ?>">
						<?php echo esc_html( $data['cta']['btn2_text'] ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
