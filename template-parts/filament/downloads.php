<?php
/**
 * Template Part: Filament Downloads & Technical Documents
 *
 * Displays 5x2 grid of 10 document cards with PDF badges,
 * technical specs, datasheets, and regulatory compliance items matching Figma Image 2.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'downloads', $product_id ) ) {
	return;
}

$dl_data = woodmart_child_get_filament_section_data( 'downloads', $product_id );

$title       = ! empty( $dl_data['title'] ) ? $dl_data['title'] : __( 'Downloads & technical documents', 'woodmart-child' );
$description = ! empty( $dl_data['description'] ) ? $dl_data['description'] : __( 'Official material datasheets, safety records, and regulatory compliance documents.', 'woodmart-child' );
$items       = ! empty( $dl_data['items'] ) && is_array( $dl_data['items'] ) ? $dl_data['items'] : array();
?>

<section class="filament-downloads-section" id="downloads" aria-label="<?php esc_attr_e( 'Downloads & Technical Documents', 'woodmart-child' ); ?>">
	<div class="container filament-downloads-container">
		<div class="filament-downloads-header">
			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="filament-downloads-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $description ) ) : ?>
				<p class="filament-downloads-subtitle"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="filament-downloads-grid">
				<?php foreach ( $items as $d_idx => $d_item ) : 
					$d_title    = ! empty( $d_item['title'] ) ? $d_item['title'] : '';
					$d_subtitle = ! empty( $d_item['subtitle'] ) ? $d_item['subtitle'] : '';
					$d_url      = ! empty( $d_item['url'] ) ? $d_item['url'] : '#';
					if ( empty( $d_title ) ) {
						continue;
					}
				?>
					<a href="<?php echo esc_url( $d_url ); ?>" class="filament-doc-card" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( sprintf( __( 'Download %s (%s)', 'woodmart-child' ), $d_title, $d_subtitle ) ); ?>">
						<span class="filament-doc-badge">PDF</span>
						<span class="filament-doc-title"><?php echo esc_html( $d_title ); ?></span>
						<?php if ( ! empty( $d_subtitle ) ) : ?>
							<span class="filament-doc-subtitle"><?php echo esc_html( $d_subtitle ); ?></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
