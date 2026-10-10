<?php
/**
 * Template Part: Supported Materials Section & Combo Promo - Figma Pixel-Perfect
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

		<!-- Materials 4-Grid matching Figma -->
		<?php if ( ! empty( $data['items'] ) ) : ?>
			<div class="grid grid--4 product-materials__grid">
				<?php foreach ( $data['items'] as $m ) : ?>
					<article class="material-card">
						<span class="dot" style="--c:<?php echo esc_attr( $m['color'] ?: '#ff6b57' ); ?>"></span>
						<span class="material-tag"><?php echo esc_html( $m['name'] ); ?></span>
						<h3 class="material-title"><?php echo esc_html( $m['subtitle'] ); ?></h3>
						<p class="material-desc"><?php echo esc_html( $m['description'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Combo Promo Banner matching Figma -->
		<?php if ( ! empty( $data['combo']['title'] ) ) : ?>
			<div class="combo product-combo">
				<div class="combo__content">
					<?php if ( ! empty( $data['combo']['eyebrow'] ) ) : ?>
						<span class="eyebrow"><?php echo esc_html( $data['combo']['eyebrow'] ); ?></span>
					<?php endif; ?>

					<h3 class="combo__title"><?php echo esc_html( $data['combo']['title'] ); ?></h3>

					<?php if ( ! empty( $data['combo']['description'] ) ) : ?>
						<p class="combo__desc"><?php echo esc_html( $data['combo']['description'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $data['combo']['link_text'] ) ) : ?>
						<a class="combo__link" href="<?php echo esc_url( $data['combo']['link_url'] ?: '#packages' ); ?>">
							<span><?php echo esc_html( $data['combo']['link_text'] ); ?></span>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
						</a>
					<?php endif; ?>
				</div>

				<div class="combo__media">
					<?php
					$combo_img = ! empty( $data['combo']['image'] ) ? $data['combo']['image'] : '';

					if ( empty( $combo_img ) ) {
						$core = woodmart_child_get_core_product_data( $product_id );
						if ( ! empty( $core['variations'] ) ) {
							foreach ( $core['variations'] as $v ) {
								if ( ! empty( $v['is_combo'] ) && ! empty( $v['image_url'] ) ) {
									$combo_img = $v['image_url'];
									break;
								}
							}
						}
						if ( empty( $combo_img ) && ! empty( $core['main_image_url'] ) ) {
							$combo_img = $core['main_image_url'];
						}
					}

					// Ensure highest resolution full-size image is loaded
					if ( ! empty( $combo_img ) ) {
						if ( is_numeric( $combo_img ) ) {
							$full_url = wp_get_attachment_image_url( (int) $combo_img, 'full' );
							if ( $full_url ) {
								$combo_img = $full_url;
							}
						} elseif ( function_exists( 'attachment_url_to_postid' ) ) {
							$att_id = attachment_url_to_postid( $combo_img );
							if ( $att_id ) {
								$full_url = wp_get_attachment_image_url( $att_id, 'full' );
								if ( $full_url ) {
									$combo_img = $full_url;
								}
							} else {
								// Strip any thumbnail dimension suffix (e.g., -150x150, -300x300)
								$unscaled = preg_replace( '/-\d+x\d+(\.[a-zA-Z0-9]+)$/', '$1', $combo_img );
								if ( $unscaled && $unscaled !== $combo_img ) {
									$att_id = attachment_url_to_postid( $unscaled );
									$combo_img = ( $att_id && wp_get_attachment_image_url( $att_id, 'full' ) ) ? wp_get_attachment_image_url( $att_id, 'full' ) : $unscaled;
								}
							}
						}
					}

					woodmart_child_render_image( $combo_img, 'Bambu Lab X1-Carbon Combo', 'combo-img', 'Bambu Lab X1-Carbon Combo' );
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
