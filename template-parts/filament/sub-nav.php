<?php
/**
 * Template Part: Filament In-Page Sticky Navigation
 *
 * Sticky anchor bar matching Figma Image 1:
 * - Items: OVERVIEW | FIND COLORS | PERFORMANCE | RFID & AMS | DOWNLOAD | PRINTING TIPS
 * - Right Action: Orange "b2b order →" button
 * - Stays pinned when scrolling past the Essential Additions section
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'nav', $product_id ) ) {
	return;
}

$nav_data = woodmart_child_get_filament_section_data( 'nav', $product_id );
$items    = ! empty( $nav_data['items'] ) ? $nav_data['items'] : array(
	array( 'label' => __( 'OVERVIEW', 'woodmart-child' ), 'target' => '#overview' ),
	array( 'label' => __( 'FIND COLORS', 'woodmart-child' ), 'target' => '#find-colors' ),
	array( 'label' => __( 'PERFORMANCE', 'woodmart-child' ), 'target' => '#materials' ),
	array( 'label' => __( 'RFID & AMS', 'woodmart-child' ), 'target' => '#rfid-ams' ),
	array( 'label' => __( 'DOWNLOAD', 'woodmart-child' ), 'target' => '#downloads' ),
	array( 'label' => __( 'PRINTING TIPS', 'woodmart-child' ), 'target' => '#printing-tips' ),
);
$b2b_text = ! empty( $nav_data['b2b_text'] ) ? $nav_data['b2b_text'] : __( 'b2b order →', 'woodmart-child' );
$b2b_url  = ! empty( $nav_data['b2b_url'] ) ? $nav_data['b2b_url'] : '#';
?>

<nav class="filament-subnav-bar" id="filament-subnav" aria-label="<?php esc_attr_e( 'Filament In-Page Navigation', 'woodmart-child' ); ?>">
	<div class="container filament-subnav-inner">
		<ul class="filament-subnav-links" role="menubar">
			<?php foreach ( $items as $idx => $item ) : ?>
				<li role="none">
					<a href="<?php echo esc_attr( $item['target'] ); ?>" class="filament-subnav-link <?php echo 0 === $idx ? 'is-active' : ''; ?>" role="menuitem">
						<span><?php echo esc_html( $item['label'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if ( ! empty( $b2b_text ) ) : ?>
			<div class="filament-subnav-action">
				<a href="<?php echo esc_url( $b2b_url ); ?>" class="filament-b2b-btn">
					<?php echo esc_html( $b2b_text ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</nav>
