<?php
/**
 * Template Part: AMS FAQ & High-Conversion Bottom CTA Banner
 *
 * - Questions Answered Accordion
 * - High-impact Orange Call To Action Banner
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'faq', $product_id );

$eyebrow  = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'Got Questions?', 'woodmart-child' );
$title    = ! empty( $data['title'] ) ? $data['title'] : __( 'Frequently Asked Questions', 'woodmart-child' );
$items    = ! empty( $data['items'] ) ? $data['items'] : array();
$cta      = ! empty( $data['cta'] ) ? $data['cta'] : array();
$cta_btn  = ! empty( $cta['btn_text'] ) ? $cta['btn_text'] : __( 'Order Bambu Lab AMS Now', 'woodmart-child' );
$cta_url  = ! empty( $cta['btn_url'] ) ? $cta['btn_url'] : '#ams-hero';
?>

<section class="ams-faq-section container" id="ams-faq">
	<div class="ams-section-head text-center">
		<?php if ( ! empty( $eyebrow ) ) : ?>
			<span class="ams-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>
		<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
	</div>

	<!-- FAQ Accordion -->
	<div class="ams-faq-accordion">
		<?php foreach ( $items as $idx => $item ) : ?>
			<div class="ams-faq-item">
				<button type="button" class="ams-faq-question" aria-expanded="false">
					<span><?php echo esc_html( $item['question'] ?? '' ); ?></span>
					<span class="faq-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<line x1="12" y1="5" x2="12" y2="19"></line>
							<line x1="5" y1="12" x2="19" y2="12"></line>
						</svg>
					</span>
				</button>
				<div class="ams-faq-answer" style="display: none;">
					<div class="ams-faq-answer-inner">
						<?php echo wp_kses_post( $item['answer'] ?? '' ); ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- High-Impact Bottom CTA Banner -->
	<div class="ams-bottom-cta-banner">
		<?php if ( ! empty( $cta['badge'] ) ) : ?>
			<div class="cta-badge">
				<span class="dot">●</span>
				<span><?php echo esc_html( $cta['badge'] ); ?></span>
			</div>
		<?php endif; ?>

		<h3 class="cta-title">
			<?php echo esc_html( $cta['title'] ?? __( 'Ready to Print in Full Color?', 'woodmart-child' ) ); ?>
		</h3>

		<?php if ( ! empty( $cta['subtitle'] ) ) : ?>
			<p class="cta-subtitle"><?php echo esc_html( $cta['subtitle'] ); ?></p>
		<?php endif; ?>

		<div class="cta-actions">
			<a href="<?php echo esc_url( $cta_url ); ?>" class="btn ams-btn-cta" id="ams-banner-scroll-btn">
				<span><?php echo esc_html( $cta_btn ); ?></span>
				<span class="arrow" aria-hidden="true">→</span>
			</a>
		</div>
	</div>
</section>
