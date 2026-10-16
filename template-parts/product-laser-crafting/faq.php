<?php
/**
 * Template Part: FAQ & Bottom Conversion CTA Banner
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_laser_crafting_section_enabled( 'faq', $product_id ) ) {
	return;
}

$section_data = woodmart_child_get_laser_crafting_section_data( 'faq', $product_id );
$eyebrow      = ! empty( $section_data['eyebrow'] ) ? $section_data['eyebrow'] : __( 'FREQUENTLY ASKED QUESTIONS', 'woodmart-child' );
$title        = ! empty( $section_data['title'] ) ? $section_data['title'] : __( 'Got Questions? We Have Answers.', 'woodmart-child' );
$subtitle     = ! empty( $section_data['description'] ) ? $section_data['description'] : __( 'Everything you need to know about the Bambu Lab A2L multi-tool system, maintenance, and software.', 'woodmart-child' );
$items        = ! empty( $section_data['items'] ) && is_array( $section_data['items'] ) ? $section_data['items'] : array();
$cta          = ! empty( $section_data['cta'] ) && is_array( $section_data['cta'] ) ? $section_data['cta'] : array();
$cta_title    = ! empty( $cta['title'] ) ? $cta['title'] : __( 'Ready to Bring Large-Scale Crafting to Your Bench?', 'woodmart-child' );
$cta_desc     = ! empty( $cta['subtitle'] ) ? $cta['subtitle'] : __( 'Dispatched from our Tallinn warehouse with fast Baltic delivery and official local warranty.', 'woodmart-child' );
$cta_btn_text = ! empty( $cta['btn_text'] ) ? $cta['btn_text'] : __( 'Choose Your A2L Package →', 'woodmart-child' );
?>

<section class="lc-faq-section" id="lc-faq">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-section-header text-center">
			<span class="lc-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
		</div>

		<!-- Accordion FAQ Items -->
		<?php if ( ! empty( $items ) ) : ?>
			<div class="lc-faq-accordion" id="lc-faq-accordion">
				<?php foreach ( $items as $f_idx => $faq ) : 
					$q = ! empty( $faq['question'] ) ? $faq['question'] : ( ! empty( $faq['q'] ) ? $faq['q'] : '' );
					$a = ! empty( $faq['answer'] ) ? $faq['answer'] : ( ! empty( $faq['a'] ) ? $faq['a'] : '' );
					$is_open = ( $f_idx === 0 );
					if ( empty( $q ) ) continue;
				?>
					<div class="lc-faq-item <?php echo $is_open ? 'is-open' : ''; ?>">
						<button type="button" class="lc-faq-question" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
							<span class="lc-faq-q-text"><?php echo esc_html( $q ); ?></span>
							<span class="lc-faq-icon" aria-hidden="true">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
							</span>
						</button>
						<div class="lc-faq-answer" <?php echo $is_open ? '' : 'style="display:none;"'; ?>>
							<div class="lc-faq-answer-inner">
								<?php echo wp_kses_post( wpautop( $a ) ); ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Bottom Orange High-Conversion CTA Banner -->
		<div class="lc-bottom-cta-banner">
			<div class="lc-cta-banner-content">
				<h3 class="lc-banner-title"><?php echo esc_html( $cta_title ); ?></h3>
				<p class="lc-banner-desc"><?php echo esc_html( $cta_desc ); ?></p>
			</div>
			<div class="lc-cta-banner-action">
				<a href="#lc-hero" class="lc-banner-btn" id="lc-banner-scroll-btn">
					<span><?php echo esc_html( $cta_btn_text ); ?></span>
				</a>
			</div>
		</div>

	</div>
</section>
