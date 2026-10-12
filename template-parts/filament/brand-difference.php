<?php
/**
 * Template Part: Filament 3DKoda Difference Section (Dark)
 *
 * Local brand value proposition matching Figma:
 * - Left: "THE 3DKODA DIFFERENCE", "Quality filament. A local team behind it.", description, "Talk to a local expert →"
 * - Right: 2x2 grid with 4 orange-icon value propositions:
 *     1. Tallinn-based stock
 *     2. Storage guidance
 *     3. Practical print support
 *     4. Business purchasing
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'brand_difference', $product_id ) ) {
	return;
}

$data        = woodmart_child_get_filament_section_data( 'brand_difference', $product_id );
$eyebrow     = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'THE 3DKODA DIFFERENCE', 'woodmart-child' );
$title       = ! empty( $data['title'] ) ? $data['title'] : "Quality filament.\nA local team behind it.";
$description = ! empty( $data['description'] ) ? $data['description'] : __( 'Choosing the right filament is the first step. We help you pick the right material, dial in your print settings, and get support whenever you need it', 'woodmart-child' );
$btn_text    = ! empty( $data['btn_text'] ) ? $data['btn_text'] : __( 'Talk to a local expert →', 'woodmart-child' );
$btn_url     = ! empty( $data['btn_url'] ) ? $data['btn_url'] : '#';
$items       = ! empty( $data['items'] ) ? $data['items'] : array();

$icon_svgs = array(
	// Location pin
	'location' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>',
	// Storage / snowflake / drop
	'storage'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M2 12h20M4.93 4.93l14.14 14.14M4.93 19.07l14.14-14.14"></path></svg>',
	// Shield support
	'support'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>',
	// Business / invoice
	'business' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>',
);
?>

<section class="filament-dark-wrap filament-brand-section" id="difference">
	<div class="container">
		<div class="filament-brand-layout">
			<!-- Left Column: Content & Expert Link -->
			<div class="filament-brand-main">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<span class="filament-eyebrow-orange"><?php echo esc_html( $eyebrow ); ?></span>
				<?php endif; ?>

				<h2 class="filament-brand-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>

				<?php if ( ! empty( $description ) ) : ?>
					<p class="filament-brand-desc"><?php echo nl2br( esc_html( $description ) ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $btn_text ) ) : ?>
					<div class="filament-brand-link-wrap">
						<a href="<?php echo esc_url( $btn_url ); ?>" class="filament-brand-link">
							<span><?php echo esc_html( $btn_text ); ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<!-- Right Column: 2x2 Value Props Grid -->
			<?php if ( ! empty( $items ) ) : ?>
				<div class="filament-brand-grid">
					<?php foreach ( $items as $idx => $item ) :
						$icon_key = $item['icon'] ?? 'location';
						$svg      = $icon_svgs[ $icon_key ] ?? $icon_svgs['location'];
					?>
						<div class="filament-brand-prop-card">
							<div class="filament-brand-prop-icon">
								<?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<div class="filament-brand-prop-text">
								<h3 class="filament-brand-prop-title"><?php echo esc_html( $item['title'] ); ?></h3>
								<p class="filament-brand-prop-desc"><?php echo esc_html( $item['description'] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
