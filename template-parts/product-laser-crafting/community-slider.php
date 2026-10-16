<?php
/**
 * Template Part: Community Creations Slider
 *
 * Exact match to Image 4:
 * - Eyebrow: Top Creators | 2M+ Models | One Click Away
 * - Heading: Printing Is a Blast When There’s Always Something New on the Menu
 * - Horizontal interactive carousel with rounded project cards
 * - Dot pagination indicator
 * - 100% Dynamic with fallback
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$eyebrow = ! empty( $settings['community_slider']['eyebrow'] ) ? $settings['community_slider']['eyebrow'] : ( ! empty( $settings['highlights']['community_sub'] ) ? $settings['highlights']['community_sub'] : __( 'Top Creators | 2M+ Models | One Click Away', 'woodmart-child' ) );
$title   = ! empty( $settings['community_slider']['title'] ) ? $settings['community_slider']['title'] : ( ! empty( $settings['highlights']['community_title'] ) ? $settings['highlights']['community_title'] : __( "Printing Is a Blast When There's Always Something New on the Menu", 'woodmart-child' ) );

$slides = ! empty( $settings['community_slider']['items'] ) ? $settings['community_slider']['items'] : ( ! empty( $settings['highlights']['community_items'] ) ? $settings['highlights']['community_items'] : array() );

$default_classes = array( 'slide-boardgame', 'slide-redsword', 'slide-bluesword', 'slide-modelkit', 'slide-diorama' );

if ( empty( $slides ) ) {
	$slides = array(
		array(
			'title' => __( 'Mechanical Board Game & Gears', 'woodmart-child' ),
			'desc'  => __( 'Multi-color interactive mechanisms printed with high-tolerance interlocking teeth.', 'woodmart-child' ),
			'class' => 'slide-boardgame',
			'badge' => 'Interactive Kit',
			'image' => '',
		),
		array(
			'title' => __( 'Crimson Dragon Greatsword', 'woodmart-child' ),
			'desc'  => __( 'Full-scale cosplay prop printed in sections with internal channels for LED glow strips.', 'woodmart-child' ),
			'class' => 'slide-redsword',
			'badge' => 'Illuminated Prop',
			'image' => '',
		),
		array(
			'title' => __( 'Azure Energy Claymore', 'woodmart-child' ),
			'desc'  => __( 'Translucent blue PETG blade with crystal clear edge glow and high layer rigidity.', 'woodmart-child' ),
			'class' => 'slide-bluesword',
			'badge' => 'Full-Scale Z-Height',
			'image' => '',
		),
		array(
			'title' => __( 'Precision Model Kit Sprues', 'woodmart-child' ),
			'desc'  => __( 'Modular snap-together mechanical components organized on injection-molding style sprues.', 'woodmart-child' ),
			'class' => 'slide-modelkit',
			'badge' => 'Multi-Material',
			'image' => '',
		),
		array(
			'title' => __( 'Topographical 3D Map Diorama', 'woodmart-child' ),
			'desc'  => __( 'High-density architectural contour elevations printed with razor-sharp step precision.', 'woodmart-child' ),
			'class' => 'slide-diorama',
			'badge' => 'Sub-Millimeter',
			'image' => '',
		),
	);
}
?>

<section class="lc-community-section" id="lc-dive-in">
	<div class="container">
		<div class="lc-community-header text-center">
			<span class="lc-community-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-community-title"><?php echo esc_html( $title ); ?></h2>
		</div>

		<!-- Interactive Slider Container -->
		<div class="lc-slider-wrapper" id="lc-community-slider">
			<div class="lc-slider-track" id="lc-slider-track">
				<?php foreach ( $slides as $s_idx => $slide ) : 
					$s_title = ! empty( $slide['title'] ) ? $slide['title'] : '';
					$s_desc  = ! empty( $slide['desc'] ) ? $slide['desc'] : '';
					$s_badge = ! empty( $slide['badge'] ) ? $slide['badge'] : ( ! empty( $slide['tag'] ) ? $slide['tag'] : '' );
					$s_img   = ! empty( $slide['image'] ) ? $slide['image'] : '';
					$s_class = ! empty( $slide['class'] ) ? $slide['class'] : ( isset( $default_classes[ $s_idx ] ) ? $default_classes[ $s_idx ] : 'slide-boardgame' );
				?>
					<div class="lc-slide-item <?php echo esc_attr( $s_class ); ?>" data-slide-index="<?php echo esc_attr( $s_idx ); ?>">
						<div class="lc-slide-card">
							<div class="lc-slide-media" <?php echo ! empty( $s_img ) ? 'style="background-image: url(' . esc_url( $s_img ) . '); background-size: cover; background-position: center;"' : ''; ?>>
								<?php if ( ! empty( $s_badge ) ) : ?>
									<span class="lc-slide-badge"><?php echo esc_html( $s_badge ); ?></span>
								<?php endif; ?>
							</div>
							<div class="lc-slide-info">
								<h4 class="lc-slide-title"><?php echo esc_html( $s_title ); ?></h4>
								<p class="lc-slide-desc"><?php echo esc_html( $s_desc ); ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Pagination Dots -->
			<div class="lc-slider-dots" id="lc-slider-dots" aria-label="<?php esc_attr_e( 'Slider Pagination', 'woodmart-child' ); ?>">
				<?php foreach ( $slides as $s_idx => $slide ) : ?>
					<button type="button" class="lc-dot <?php echo 0 === $s_idx ? 'is-active' : ''; ?>" data-slide="<?php echo esc_attr( $s_idx ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'woodmart-child' ), $s_idx + 1 ) ); ?>"></button>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
