<?php
/**
 * Template Part: Why Choose Bambu Lab A2L (6-Card Grid)
 *
 * Exact match to Image 3:
 * - Centered Heading: "Why choose Bambu Lab A2L"
 * - 6-Card Grid with high-res photography and technical callouts:
 *     1. Extra Large Build Volume (Helmet on bed)
 *     2. Multi-Color Printing (Vibrant parrot model)
 *     3. Full-Auto Calibration (Auto bed leveling sensor)
 *     4. Modular Add-Ons (Interchangeable toolheads)
 *     5. MakerWorld Ecosystem (Collage of popular prints)
 *     6. Intelligent Monitoring (Smartphone AutoPilot camera)
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$heading = ! empty( $settings['why_choose']['title'] ) ? $settings['why_choose']['title'] : ( ! empty( $settings['highlights']['video_title'] ) ? $settings['highlights']['video_title'] : __( 'Why choose Bambu Lab A2L', 'woodmart-child' ) );

$items = ! empty( $settings['why_choose']['items'] ) ? $settings['why_choose']['items'] : ( ! empty( $settings['highlights']['items'] ) ? $settings['highlights']['items'] : array() );

// Default fallback items if none defined
if ( empty( $items ) ) {
	$items = array(
		array(
			'title' => __( 'Extra Large Build Volume', 'woodmart-child' ),
			'sub'   => __( 'Oversized build in one go.', 'woodmart-child' ),
			'badge' => '330×320×325 mm³',
			'mock'  => 'lc-mock-helmet',
			'image' => '',
		),
		array(
			'title' => __( 'Multi-Color Printing', 'woodmart-child' ),
			'sub'   => __( 'The most reliable multi-color solution.', 'woodmart-child' ),
			'badge' => '19-Color AMS lite',
			'mock'  => 'lc-mock-parrot',
			'image' => '',
		),
		array(
			'title' => __( 'Full-Auto Calibration', 'woodmart-child' ),
			'sub'   => __( "You don't have to do ANY manual tuning.", 'woodmart-child' ),
			'badge' => 'Dual Eddy-Current',
			'mock'  => 'lc-mock-calibration',
			'image' => '',
		),
		array(
			'title' => __( 'Modular Add-Ons', 'woodmart-child' ),
			'sub'   => __( 'Blade cutting, pen drawing and more.', 'woodmart-child' ),
			'badge' => '500g Force · Quick-Swap',
			'mock'  => 'lc-mock-toolheads',
			'image' => '',
		),
		array(
			'title' => __( 'MakerWorld Ecosystem', 'woodmart-child' ),
			'sub'   => __( 'Millions of models, one-click away.', 'woodmart-child' ),
			'badge' => '2M+ Free Models',
			'mock'  => 'lc-mock-makerworld',
			'image' => '',
		),
		array(
			'title' => __( 'Intelligent Monitoring', 'woodmart-child' ),
			'sub'   => __( 'AutoPilot your printing process.', 'woodmart-child' ),
			'badge' => 'AutoPilot AI Sensors',
			'mock'  => 'lc-mock-phone',
			'image' => '',
		),
	);
}

$default_mocks = array( 'lc-mock-helmet', 'lc-mock-parrot', 'lc-mock-calibration', 'lc-mock-toolheads', 'lc-mock-makerworld', 'lc-mock-phone' );
?>

<section class="lc-why-choose-section" id="lc-why-choose">
	<div class="container">
		<h2 class="lc-why-title text-center"><?php echo esc_html( $heading ); ?></h2>

		<div class="lc-why-grid">
			<?php foreach ( $items as $idx => $item ) : 
				$card_title = ! empty( $item['title'] ) ? $item['title'] : '';
				$card_sub   = ! empty( $item['sub'] ) ? $item['sub'] : ( ! empty( $item['desc'] ) ? $item['desc'] : '' );
				$card_badge = ! empty( $item['badge'] ) ? $item['badge'] : ( ! empty( $item['value'] ) ? $item['value'] : '' );
				$card_image = ! empty( $item['image'] ) ? $item['image'] : '';
				$mock_class = ! empty( $item['mock'] ) ? $item['mock'] : ( isset( $default_mocks[ $idx ] ) ? $default_mocks[ $idx ] : 'lc-mock-helmet' );
			?>
				<div class="lc-why-card">
					<div class="lc-why-card__body">
						<h3 class="lc-why-card__title"><?php echo esc_html( $card_title ); ?></h3>
						<?php if ( ! empty( $card_sub ) ) : ?>
							<p class="lc-why-card__sub"><?php echo esc_html( $card_sub ); ?></p>
						<?php endif; ?>
					</div>
					<div class="lc-why-card__media">
						<?php if ( ! empty( $card_image ) ) : ?>
							<div class="lc-why-card-custom-img-wrap" style="width:100%; height:180px; display:flex; align-items:center; justify-content:center; overflow:hidden; border-radius:12px; position:relative;">
								<img src="<?php echo esc_url( $card_image ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" style="width:100%; height:100%; object-fit:cover;" />
								<?php if ( ! empty( $card_badge ) ) : ?>
									<span class="lc-mock-badge" style="position:absolute; bottom:12px; right:12px;"><?php echo esc_html( $card_badge ); ?></span>
								<?php endif; ?>
							</div>
						<?php else : ?>
							<div class="<?php echo esc_attr( $mock_class ); ?>">
								<?php if ( ! empty( $card_badge ) ) : ?>
									<span class="lc-mock-badge"><?php echo esc_html( $card_badge ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
