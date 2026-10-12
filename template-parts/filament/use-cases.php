<?php
/**
 * Template Part: Filament Use Cases Section (Dark)
 *
 * "Where It Earns Its Place" 4-column numbered grid matching Figma:
 * - Eyebrow: "WHERE IT EARNS ITS PLACE" (orange)
 * - Title: "Made for ideas that have somewhere to go."
 * - Divider Line
 * - 4 Columns: 01 Product development, 02 Small production, 03 Education & labs, 04 Creative studios
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'use_cases', $product_id ) ) {
	return;
}

$data    = woodmart_child_get_filament_section_data( 'use_cases', $product_id );
$eyebrow = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'WHERE IT EARNS ITS PLACE', 'woodmart-child' );
$title   = ! empty( $data['title'] ) ? $data['title'] : "Made for ideas\nthat have somewhere to go.";
$items   = ! empty( $data['items'] ) ? $data['items'] : array();
?>

<section class="filament-dark-wrap filament-use-cases-section" id="performance">
	<div class="container">
		<div class="filament-use-cases-header">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="filament-eyebrow-orange"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<h2 class="filament-use-cases-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>
		</div>

		<div class="filament-use-cases-divider"></div>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="filament-use-cases-grid">
				<?php foreach ( $items as $uc ) : ?>
					<div class="filament-use-case-item">
						<?php if ( ! empty( $uc['num'] ) ) : ?>
							<span class="filament-use-case-num"><?php echo esc_html( $uc['num'] ); ?></span>
						<?php endif; ?>

						<h3 class="filament-use-case-heading"><?php echo esc_html( $uc['title'] ); ?></h3>

						<?php if ( ! empty( $uc['description'] ) ) : ?>
							<p class="filament-use-case-desc"><?php echo esc_html( $uc['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
