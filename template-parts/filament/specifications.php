<?php
/**
 * Template Part: Filament Technical Specifications
 *
 * Displays technical specification table with 17 filament parameters
 * and official data source disclaimer matching Figma Image 1.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'specifications', $product_id ) ) {
	return;
}

$specs_data = woodmart_child_get_filament_section_data( 'specifications', $product_id );

$eyebrow     = ! empty( $specs_data['eyebrow'] ) ? $specs_data['eyebrow'] : __( 'THE DETAILS BEHIND THE DECISION', 'woodmart-child' );
$title       = ! empty( $specs_data['title'] ) ? $specs_data['title'] : __( 'Technical specifications.', 'woodmart-child' );
$description = ! empty( $specs_data['description'] ) ? $specs_data['description'] : __( 'Key filament data for print planning. Final data verified against official Bambu documentation.', 'woodmart-child' );
$note        = ! empty( $specs_data['note'] ) ? $specs_data['note'] : __( 'Data based on official Bambu Lab product information', 'woodmart-child' );
$items       = ! empty( $specs_data['items'] ) && is_array( $specs_data['items'] ) ? $specs_data['items'] : array();
?>

<section class="filament-specs-section" id="specifications" aria-label="<?php esc_attr_e( 'Technical Specifications', 'woodmart-child' ); ?>">
	<div class="container filament-specs-container">
		<div class="filament-specs-header">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="filament-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="filament-specs-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $description ) ) : ?>
				<p class="filament-specs-subtitle"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="filament-specs-card">
				<div class="filament-specs-table" role="table" aria-label="<?php esc_attr_e( 'Filament Technical Data Table', 'woodmart-child' ); ?>">
					<?php foreach ( $items as $idx => $item ) : 
						$label = ! empty( $item['label'] ) ? $item['label'] : '';
						$val   = ! empty( $item['value'] ) ? $item['value'] : '';
						if ( empty( $label ) && empty( $val ) ) {
							continue;
						}
						$is_even = ( 0 === $idx % 2 );
					?>
						<div class="filament-spec-row <?php echo $is_even ? 'row-even' : 'row-odd'; ?>" role="row">
							<div class="filament-spec-cell spec-cell-label" role="rowheader">
								<?php echo esc_html( $label ); ?>
							</div>
							<div class="filament-spec-cell spec-cell-value" role="cell">
								<?php echo esc_html( $val ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $note ) ) : ?>
			<div class="filament-specs-note">
				<p><?php echo esc_html( $note ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
