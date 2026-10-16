<?php
/**
 * Template Part: AMS What's in the Box
 *
 * Visual unboxing grid with cards for each included item:
 * - AMS Unit
 * - Reusable Spools
 * - Filament Buffer
 * - Bus Cables
 * - PTFE Tubing
 * - Desiccant Packs
 * - PTFE Coupler & Tools
 * - Quick Start Guide
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'box_contents', $product_id );

$eyebrow  = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'Unboxing Experience', 'woodmart-child' );
$title    = ! empty( $data['title'] ) ? $data['title'] : __( "What's in the Box", 'woodmart-child' );
$subtitle = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( 'Everything you need to begin multi-color 3D printing right out of the box.', 'woodmart-child' );
$items    = ! empty( $data['items'] ) ? $data['items'] : array();
?>

<section class="ams-box-section container" id="ams-box-contents">
	<div class="ams-section-head text-center">
		<?php if ( ! empty( $eyebrow ) ) : ?>
			<span class="ams-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>
		<h2 class="ams-section-title"><?php echo esc_html( $title ); ?></h2>
		<?php if ( ! empty( $subtitle ) ) : ?>
			<p class="ams-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>

	<div class="ams-box-grid">
		<?php foreach ( $items as $idx => $item ) : 
			$icon = $item['icon'] ?? 'box';
		?>
			<div class="ams-box-item">
				<div class="ams-box-icon" aria-hidden="true">
					<?php if ( 'disc' === $icon ) : ?>
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="1.8">
							<circle cx="12" cy="12" r="10"></circle>
							<circle cx="12" cy="12" r="3"></circle>
						</svg>
					<?php elseif ( 'cable' === $icon ) : ?>
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="1.8">
							<path d="M4 12h16"></path>
							<path d="M7 6v12"></path>
							<path d="M17 6v12"></path>
						</svg>
					<?php elseif ( 'tube' === $icon ) : ?>
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="1.8">
							<circle cx="6" cy="12" r="3"></circle>
							<circle cx="18" cy="12" r="3"></circle>
							<line x1="6" y1="9" x2="18" y2="9"></line>
							<line x1="6" y1="15" x2="18" y2="15"></line>
						</svg>
					<?php elseif ( 'droplet' === $icon ) : ?>
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="1.8">
							<path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
						</svg>
					<?php elseif ( 'tool' === $icon ) : ?>
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="1.8">
							<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
						</svg>
					<?php elseif ( 'book' === $icon ) : ?>
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="1.8">
							<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
							<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
						</svg>
					<?php else : ?>
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="1.8">
							<rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
							<line x1="8" y1="21" x2="16" y2="21"></line>
							<line x1="12" y1="17" x2="12" y2="21"></line>
						</svg>
					<?php endif; ?>
				</div>
				<h3 class="ams-box-title"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
				<?php if ( ! empty( $item['desc'] ) ) : ?>
					<p class="ams-box-desc"><?php echo esc_html( $item['desc'] ); ?></p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
