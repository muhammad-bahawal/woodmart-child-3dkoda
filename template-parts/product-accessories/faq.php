<?php
/**
 * Template Part: Accessories FAQ & Bottom CTA Banner
 *
 * Implements accordion FAQ and high-conversion bottom purchase banner.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_accessories_section_enabled( 'faq', $product_id ) ) {
	return;
}

$section = woodmart_child_get_accessories_section_data( 'faq', $product_id );
$faqs    = ! empty( $section['items'] ) ? $section['items'] : array();
$cta     = ! empty( $section['cta'] ) ? $section['cta'] : array();
?>

<section class="accessories-faq-section" id="faq">
	<div class="container">
		<div class="accessories-section-header text-center">
			<span class="accessories-eyebrow"><?php echo esc_html( $section['eyebrow'] ); ?></span>
			<h2 class="accessories-title"><?php echo esc_html( $section['title'] ); ?></h2>
			<p class="accessories-desc"><?php echo esc_html( $section['description'] ); ?></p>
			<?php if ( ! empty( $section['ask_text'] ) ) : ?>
				<div class="faq-ask-link-wrap">
					<a href="<?php echo esc_url( $section['ask_url'] ?? '#' ); ?>" class="faq-ask-link">
						<?php echo esc_html( $section['ask_text'] ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $faqs ) ) : ?>
			<div class="accessories-faq-accordion">
				<?php foreach ( $faqs as $idx => $f ) :
					$is_first = ( 0 === $idx );
				?>
					<div class="faq-accordion-item <?php echo $is_first ? 'is-open' : ''; ?>">
						<button type="button" class="faq-accordion-header" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>">
							<span class="faq-question-text"><?php echo esc_html( $f['question'] ); ?></span>
							<span class="faq-toggle-icon" aria-hidden="true">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="6 9 12 15 18 9"></polyline>
								</svg>
							</span>
						</button>
						<div class="faq-accordion-body" style="<?php echo $is_first ? 'display: block;' : 'display: none;'; ?>">
							<div class="faq-answer-inner">
								<p><?php echo esc_html( $f['answer'] ); ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Bottom High-Conversion CTA Banner -->
		<?php if ( ! empty( $cta['title'] ) ) : ?>
			<div class="accessories-bottom-cta-banner">
				<div class="cta-banner-content text-center">
					<?php if ( ! empty( $cta['badge'] ) ) : ?>
						<span class="cta-badge"><?php echo esc_html( $cta['badge'] ); ?></span>
					<?php endif; ?>
					<h3 class="cta-title"><?php echo esc_html( $cta['title'] ); ?></h3>
					<?php if ( ! empty( $cta['description'] ) ) : ?>
						<p class="cta-desc"><?php echo esc_html( $cta['description'] ); ?></p>
					<?php endif; ?>

					<div class="cta-buttons-wrap">
						<?php if ( ! empty( $cta['btn_shop_text'] ) ) : ?>
							<a href="<?php echo esc_url( $cta['btn_shop_url'] ?? '#accessories-hero' ); ?>" class="btn cta-btn-primary">
								<span><?php echo esc_html( $cta['btn_shop_text'] ); ?></span>
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<line x1="5" y1="12" x2="19" y2="12"></line>
									<polyline points="12 5 19 12 12 19"></polyline>
								</svg>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $cta['btn_quote_text'] ) ) : ?>
							<a href="<?php echo esc_url( $cta['btn_quote_url'] ?? '#' ); ?>" class="btn cta-btn-secondary">
								<span><?php echo esc_html( $cta['btn_quote_text'] ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
