<?php
/**
 * Template Part: Filament What's in the Box
 *
 * Displays side-by-side package contents comparison:
 * Complete Spool (Recommended, orange border) vs Refill (clean border)
 * with green checkmarks and footnote disclaimer matching Figma Image 1.
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'box_contents', $product_id ) ) {
	return;
}

$box_data = woodmart_child_get_filament_section_data( 'box_contents', $product_id );

$eyebrow      = ! empty( $box_data['eyebrow'] ) ? $box_data['eyebrow'] : __( 'START WITH WHAT YOU NEED', 'woodmart-child' );
$title        = ! empty( $box_data['title'] ) ? $box_data['title'] : __( "What's in the box.", 'woodmart-child' );
$spool_badge  = ! empty( $box_data['spool_badge'] ) ? $box_data['spool_badge'] : __( 'RECOMMENDED', 'woodmart-child' );
$spool_title  = ! empty( $box_data['spool_title'] ) ? $box_data['spool_title'] : __( 'COMPLETE SPOOL', 'woodmart-child' );
$spool_items  = ! empty( $box_data['spool_items'] ) && is_array( $box_data['spool_items'] ) ? $box_data['spool_items'] : array();
$refill_title = ! empty( $box_data['refill_title'] ) ? $box_data['refill_title'] : __( 'REFILL', 'woodmart-child' );
$refill_items = ! empty( $box_data['refill_items'] ) && is_array( $box_data['refill_items'] ) ? $box_data['refill_items'] : array();
$note         = ! empty( $box_data['note'] ) ? $box_data['note'] : __( 'Contents may vary slightly by region or batch. Confirm against the selected SKU', 'woodmart-child' );

if ( ! function_exists( 'woodmart_child_format_box_bullet' ) ) {
	/**
	 * Format bullet text to bold "Note:" if present
	 */
	function woodmart_child_format_box_bullet( $text ) {
		if ( 0 === strpos( $text, 'Note:' ) ) {
			return '<strong>Note:</strong>' . esc_html( substr( $text, 5 ) );
		}
		return esc_html( $text );
	}
}
?>

<section class="filament-box-section" id="in-the-box" aria-label="<?php esc_attr_e( "What's in the box", 'woodmart-child' ); ?>">
	<div class="container filament-box-container">
		<div class="filament-box-header">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="filament-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="filament-box-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
		</div>

		<div class="filament-box-grid">
			<!-- Card 1: Complete Spool (Recommended) -->
			<div class="filament-box-card is-recommended">
				<?php if ( ! empty( $spool_badge ) ) : ?>
					<span class="filament-box-badge"><?php echo esc_html( $spool_badge ); ?></span>
				<?php endif; ?>

				<h3 class="filament-box-card-title"><?php echo esc_html( $spool_title ); ?></h3>

				<?php if ( ! empty( $spool_items ) ) : ?>
					<ul class="filament-box-list" role="list">
						<?php foreach ( $spool_items as $item_text ) : ?>
							<li class="filament-box-item">
								<span class="filament-box-check" aria-hidden="true">
									<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
										<polyline points="20 6 9 17 4 12"></polyline>
									</svg>
								</span>
								<span class="filament-box-text"><?php echo woodmart_child_format_box_bullet( $item_text ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<!-- Card 2: Refill -->
			<div class="filament-box-card is-refill">
				<h3 class="filament-box-card-title"><?php echo esc_html( $refill_title ); ?></h3>

				<?php if ( ! empty( $refill_items ) ) : ?>
					<ul class="filament-box-list" role="list">
						<?php foreach ( $refill_items as $item_text ) : ?>
							<li class="filament-box-item">
								<span class="filament-box-check" aria-hidden="true">
									<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
										<polyline points="20 6 9 17 4 12"></polyline>
									</svg>
								</span>
								<span class="filament-box-text"><?php echo woodmart_child_format_box_bullet( $item_text ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( ! empty( $note ) ) : ?>
			<div class="filament-box-footnote">
				<p><?php echo esc_html( $note ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
