<?php
/**
 * Template Part: Filament Formulation Showcase Banner
 *
 * Dark showcase banner matching Figma Image 1:
 * - Eyebrow: "FLAGSHIP FILAMENT FORMULATION" (orange)
 * - Large Headline: "PLA Basic"
 * - Subtitle: "Stand Out, Never Dull"
 * - Description: Polymer consistency & high-speed ecosystem performance
 * - Background Image: Bambu Lab filament spools & 3D prints
 * - Bottom Creator Credit Strip: 4 community maker tags
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'formulation', $product_id ) ) {
	return;
}

$data        = woodmart_child_get_filament_section_data( 'formulation', $product_id );
$eyebrow     = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'FLAGSHIP FILAMENT FORMULATION', 'woodmart-child' );
$title       = ! empty( $data['title'] ) ? $data['title'] : __( 'PLA Basic', 'woodmart-child' );
$subtitle    = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( 'Stand Out, Never Dull', 'woodmart-child' );
$description = ! empty( $data['description'] ) ? $data['description'] : __( 'Designed from the polymer-up for high-speed Bambu Lab ecosystems. Get reliable first-layer adhesion, vibrant consistency, and ultra-smooth surface finishes right out of the box.', 'woodmart-child' );
$image_url   = ! empty( $data['image'] ) ? $data['image'] : ( get_stylesheet_directory_uri() . '/assets/images/filament-formulation-banner.jpg' );
$credits     = ! empty( $data['credits'] ) ? $data['credits'] : '• Cake Containers @s_branquinho • Cute figure of bear flying on balloon @Sam HellMyth • Brick Stackable Desk Boxes @Sakul • Articulated Orca @Jopek Design';
?>

<section class="filament-dark-wrap filament-formulation-section" id="overview">
	<div class="container">
		<div class="filament-formulation-card" style="background-image: url('<?php echo esc_url( $image_url ); ?>');">
			<div class="filament-formulation-overlay"></div>

			<div class="filament-formulation-content">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<span class="filament-eyebrow-orange"><?php echo esc_html( $eyebrow ); ?></span>
				<?php endif; ?>

				<h2 class="filament-formulation-title"><?php echo esc_html( $title ); ?></h2>

				<?php if ( ! empty( $subtitle ) ) : ?>
					<h3 class="filament-formulation-subtitle"><?php echo esc_html( $subtitle ); ?></h3>
				<?php endif; ?>

				<?php if ( ! empty( $description ) ) : ?>
					<p class="filament-formulation-desc"><?php echo nl2br( esc_html( $description ) ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $credits ) ) : ?>
				<div class="filament-formulation-credits">
					<span><?php echo esc_html( $credits ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
