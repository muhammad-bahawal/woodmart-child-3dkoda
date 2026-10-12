<?php
/**
 * Template Part: Filament Printing Tips Accordion
 *
 * Displays 4-card expandable accordion for printing tips:
 * 1. Accessory Compatibility, 2. Drying Recommendations,
 * 3. Refill Guidelines, 4. Safety Tips matching Figma Image 1.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'printing_tips', $product_id ) ) {
	return;
}

$tips_data = woodmart_child_get_filament_section_data( 'printing_tips', $product_id );

$title       = ! empty( $tips_data['title'] ) ? $tips_data['title'] : __( 'Printing Tips', 'woodmart-child' );
$description = ! empty( $tips_data['description'] ) ? $tips_data['description'] : __( 'PLA Basic is designed for Bambu Lab printers and works with all hotend sizes', 'woodmart-child' );
$items       = ! empty( $tips_data['items'] ) && is_array( $tips_data['items'] ) ? $tips_data['items'] : array();
?>

<section class="filament-tips-section" id="printing-tips" aria-label="<?php esc_attr_e( 'Printing Tips', 'woodmart-child' ); ?>">
	<div class="container filament-tips-container">
		<div class="filament-tips-header">
			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="filament-tips-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $description ) ) : ?>
				<p class="filament-tips-subtitle"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="filament-tips-accordion">
				<?php foreach ( $items as $idx => $item ) : 
					$item_title   = ! empty( $item['title'] ) ? $item['title'] : '';
					$item_content = ! empty( $item['content'] ) ? $item['content'] : '';
					if ( empty( $item_title ) ) {
						continue;
					}
					// First item open by default matching Figma screenshot
					$is_open = ( 0 === $idx );
				?>
					<details class="filament-tip-card" <?php echo $is_open ? 'open' : ''; ?>>
						<summary class="filament-tip-summary">
							<span class="filament-tip-heading"><?php echo esc_html( $item_title ); ?></span>
							<span class="filament-tip-chevron" aria-hidden="true">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="6 9 12 15 18 9"></polyline>
								</svg>
							</span>
						</summary>
						<div class="filament-tip-body">
							<p><?php echo wp_kses_post( $item_content ); ?></p>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
