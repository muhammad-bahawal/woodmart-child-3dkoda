<?php
/**
 * Template Part: Filament FAQ Accordion & Bottom CTA Banner
 *
 * Displays 2-column FAQ layout (narrative left, 6 questions accordion right)
 * and full-width Baltic logistics orange call-to-action banner matching Figma Image 2.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'faq', $product_id ) ) {
	return;
}

$faq_data = woodmart_child_get_filament_section_data( 'faq', $product_id );

$eyebrow     = ! empty( $faq_data['eyebrow'] ) ? $faq_data['eyebrow'] : __( 'BEFORE YOU DECIDE', 'woodmart-child' );
$title       = ! empty( $faq_data['title'] ) ? $faq_data['title'] : __( 'Questions, answered.', 'woodmart-child' );
$description = ! empty( $faq_data['description'] ) ? $faq_data['description'] : __( 'Still deciding? Our team can help you choose the right material for your printer and application', 'woodmart-child' );
$ask_text    = ! empty( $faq_data['ask_text'] ) ? $faq_data['ask_text'] : __( 'Ask 3DKoda →', 'woodmart-child' );
$ask_url     = ! empty( $faq_data['ask_url'] ) ? $faq_data['ask_url'] : '#';
$items       = ! empty( $faq_data['items'] ) && is_array( $faq_data['items'] ) ? $faq_data['items'] : array();

// Bottom CTA Banner Data
$cta_data       = ! empty( $faq_data['cta'] ) && is_array( $faq_data['cta'] ) ? $faq_data['cta'] : array();
$cta_enabled    = ! empty( $cta_data['enabled'] );
$cta_badge      = ! empty( $cta_data['badge'] ) ? $cta_data['badge'] : __( 'BALTIC LOGISTICS & BULK TIERS', 'woodmart-child' );
$cta_title      = ! empty( $cta_data['title'] ) ? $cta_data['title'] : __( 'Ready to bring your next print to life?', 'woodmart-child' );
$cta_desc       = ! empty( $cta_data['description'] ) ? $cta_data['description'] : __( 'Choose your Bambu PLA setup today or connect with a Baltic 3D printing specialist in Tallinn for test prints and volume pricing.', 'woodmart-child' );
$cta_shop_text  = ! empty( $cta_data['btn_shop_text'] ) ? $cta_data['btn_shop_text'] : __( 'Shop PLA Basic Now', 'woodmart-child' );
$cta_shop_url   = ! empty( $cta_data['btn_shop_url'] ) ? $cta_data['btn_shop_url'] : '#choose-format';
$cta_quote_text = ! empty( $cta_data['btn_quote_text'] ) ? $cta_data['btn_quote_text'] : __( 'Request Business Quote', 'woodmart-child' );
$cta_quote_url  = ! empty( $cta_data['btn_quote_url'] ) ? $cta_data['btn_quote_url'] : '#';
?>

<!-- FAQ Accordion Section -->
<section class="filament-faq-section" id="faq" aria-label="<?php esc_attr_e( 'Frequently Asked Questions', 'woodmart-child' ); ?>">
	<div class="container filament-faq-container">
		<div class="filament-faq-layout">
			<!-- Left Column: Narrative & Action Link -->
			<div class="filament-faq-info">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<span class="filament-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="filament-faq-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $description ) ) : ?>
					<p class="filament-faq-desc"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $ask_text ) ) : ?>
					<div class="filament-faq-ask-wrap">
						<a href="<?php echo esc_url( $ask_url ); ?>" class="filament-faq-ask-link">
							<?php echo esc_html( $ask_text ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<!-- Right Column: Accordion Questions -->
			<?php if ( ! empty( $items ) ) : ?>
				<div class="filament-faq-accordion">
					<?php foreach ( $items as $f_idx => $f_item ) : 
						$question = ! empty( $f_item['question'] ) ? $f_item['question'] : '';
						$answer   = ! empty( $f_item['answer'] ) ? $f_item['answer'] : '';
						if ( empty( $question ) ) {
							continue;
						}
						// First question open by default matching Figma screenshot
						$is_open = ( 0 === $f_idx );
					?>
						<details class="filament-faq-item" <?php echo $is_open ? 'open' : ''; ?>>
							<summary class="filament-faq-question">
								<span class="faq-question-text"><?php echo esc_html( $question ); ?></span>
								<span class="faq-chevron" aria-hidden="true">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
										<polyline points="6 9 12 15 18 9"></polyline>
									</svg>
								</span>
							</summary>
							<div class="filament-faq-answer">
								<p><?php echo wp_kses_post( $answer ); ?></p>
							</div>
						</details>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Bottom Full-Width Orange Call To Action Banner -->
<?php if ( $cta_enabled ) : ?>
	<section class="filament-cta-banner" aria-label="<?php esc_attr_e( 'Filament Call To Action', 'woodmart-child' ); ?>">
		<div class="container filament-cta-container">
			<div class="filament-cta-layout">
				<div class="filament-cta-content">
					<?php if ( ! empty( $cta_badge ) ) : ?>
						<span class="filament-cta-badge"><?php echo esc_html( $cta_badge ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $cta_title ) ) : ?>
						<h2 class="filament-cta-title"><?php echo esc_html( $cta_title ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $cta_desc ) ) : ?>
						<p class="filament-cta-desc"><?php echo esc_html( $cta_desc ); ?></p>
					<?php endif; ?>
				</div>

				<div class="filament-cta-actions">
					<?php if ( ! empty( $cta_shop_text ) ) : ?>
						<a href="<?php echo esc_url( $cta_shop_url ); ?>" class="btn-cta-shop">
							<?php echo esc_html( $cta_shop_text ); ?>
						</a>
					<?php endif; ?>

					<?php if ( ! empty( $cta_quote_text ) ) : ?>
						<a href="<?php echo esc_url( $cta_quote_url ); ?>" class="btn-cta-quote">
							<?php echo esc_html( $cta_quote_text ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
