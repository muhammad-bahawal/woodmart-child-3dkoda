<?php
/**
 * Template Part: Filament Material Overview
 *
 * 4-Card Material Overview matching Figma Image 2:
 * - Eyebrow: "MATERIAL OVERVIEW"
 * - Title: "Choose the right material"
 * - Description: "PLA Basic is the everyday choice. Explore other Bambu Lab material families..."
 * - Grid: PLA (Fast concepts), PETG (Functional parts), ABS/ASA (Working prototypes), CF MATERIALS (Engineering intent)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'materials', $product_id ) ) {
	return;
}

$data        = woodmart_child_get_filament_section_data( 'materials', $product_id );
$eyebrow     = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'MATERIAL OVERVIEW', 'woodmart-child' );
$title       = ! empty( $data['title'] ) ? $data['title'] : __( 'Choose the right material', 'woodmart-child' );
$description = ! empty( $data['description'] ) ? $data['description'] : __( 'PLA Basic is the everyday choice. Explore other Bambu Lab material families for tougher or more specialised work', 'woodmart-child' );
$items       = ! empty( $data['items'] ) ? $data['items'] : array();
?>

<section class="filament-materials-section" id="materials">
	<div class="container">
		<div class="filament-section-head text-center">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="filament-eyebrow-orange"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<h2 class="filament-section-title"><?php echo esc_html( $title ); ?></h2>

			<?php if ( ! empty( $description ) ) : ?>
				<p class="filament-section-desc"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="filament-materials-grid">
				<?php foreach ( $items as $item ) : ?>
					<article class="filament-material-card">
						<?php if ( ! empty( $item['tag'] ) ) : ?>
							<span class="filament-material-tag"><?php echo esc_html( $item['tag'] ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $item['title'] ) ) : ?>
							<h3 class="filament-material-title"><?php echo esc_html( $item['title'] ); ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $item['description'] ) ) : ?>
							<p class="filament-material-desc"><?php echo esc_html( $item['description'] ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
