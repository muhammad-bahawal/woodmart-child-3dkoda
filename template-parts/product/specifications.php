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

<!-- Setup Guide Banner - Figma Specification -->
<?php if ( ! empty( $data['setup']['title'] ) ) : ?>
	<?php
	$setup_img = ! empty( $data['setup']['image'] ) ? $data['setup']['image'] : '';

	if ( empty( $setup_img ) ) {
		$core = woodmart_child_get_core_product_data( $product_id );
		if ( ! empty( $core['variations'] ) ) {
			foreach ( $core['variations'] as $v ) {
				if ( ! empty( $v['is_combo'] ) && ! empty( $v['image_url'] ) ) {
					$setup_img = $v['image_url'];
					break;
				}
			}
		}
		if ( empty( $setup_img ) && ! empty( $core['main_image_url'] ) ) {
			$setup_img = $core['main_image_url'];
		}
	}

	// Ensure highest resolution full-size image is loaded
	if ( ! empty( $setup_img ) ) {
		if ( is_numeric( $setup_img ) ) {
			$full_url = wp_get_attachment_image_url( (int) $setup_img, 'full' );
			if ( $full_url ) {
				$setup_img = $full_url;
			}
		} elseif ( function_exists( 'attachment_url_to_postid' ) ) {
			$att_id = attachment_url_to_postid( $setup_img );
			if ( $att_id ) {
				$full_url = wp_get_attachment_image_url( $att_id, 'full' );
				if ( $full_url ) {
					$setup_img = $full_url;
				}
			} else {
				// Strip any thumbnail dimension suffix (e.g., -150x150, -300x300)
				$unscaled = preg_replace( '/-\d+x\d+(\.[a-zA-Z0-9]+)$/', '$1', $setup_img );
				if ( $unscaled && $unscaled !== $setup_img ) {
					$att_id = attachment_url_to_postid( $unscaled );
					$setup_img = ( $att_id && wp_get_attachment_image_url( $att_id, 'full' ) ) ? wp_get_attachment_image_url( $att_id, 'full' ) : $unscaled;
				}
			}
		}
	}
	?>
	<section class="container product-setup-container" style="padding-bottom:var(--gap)">
		<div class="setup product-setup">
			<div class="setup__content">
				<?php if ( ! empty( $data['setup']['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $data['setup']['eyebrow'] ); ?></span>
				<?php endif; ?>

				<h2 class="setup__title"><?php echo nl2br( esc_html( $data['setup']['title'] ) ); ?></h2>

				<?php if ( ! empty( $data['setup']['description'] ) ) : ?>
					<p class="setup__desc"><?php echo esc_html( $data['setup']['description'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $data['setup']['link_text'] ) ) : ?>
					<a class="setup__link" href="<?php echo esc_url( $data['setup']['link_url'] ?: '#' ); ?>" target="_blank" rel="noopener">
						<span><?php echo esc_html( $data['setup']['link_text'] ); ?></span>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
					</a>
				<?php endif; ?>
			</div>

			<div class="setup__media">
				<div class="setup-preview-card">
					<div class="setup-preview-card__img">
						<?php woodmart_child_render_image( $setup_img, 'Official setup guide', 'setup-guide-img', 'Official setup guide' ); ?>
					</div>
					<a class="setup-preview-card__btn" href="<?php echo esc_url( $data['setup']['link_url'] ?: '#' ); ?>" target="_blank" rel="noopener">
						<svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
						<span><?php esc_html_e( 'Official setup guide', 'woodmart-child' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
