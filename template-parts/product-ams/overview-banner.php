<?php
/**
 * Template Part: AMS Overview & High-Impact Hero Banner
 *
 * Exact match to Image 1:
 * - Brand Eyebrow: "Bambu Lab AMS 2 Pro"
 * - Large Headline: "AMS, Evolved."
 * - High-impact product hero render with ambient spotlight
 * - 4-Column Divider Highlight Strip:
 *   1. 24-Colors/Multi-material | Serially connect up to 4 AMS 2 Pro & 8 AMS HT units, total of 24 filaments
 *   2. Electro-Magnetic Air Vent | Fast filament drying & air-tight filament storage
 *   3. 65°C Drying | Up to 65°C drying temperature
 *   4. Brushless Motor | 60% faster feeding speed
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'overview', $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

$eyebrow    = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'Bambu Lab AMS 2 Pro', 'woodmart-child' );
$title      = ! empty( $data['title'] ) ? $data['title'] : __( 'AMS, Evolved.', 'woodmart-child' );
$subtitle   = ! empty( $data['subtitle'] ) ? $data['subtitle'] : '';
$video_url  = ! empty( $data['video_url'] ) ? $data['video_url'] : '';
$video_btn  = ! empty( $data['video_btn_text'] ) ? $data['video_btn_text'] : __( 'Watch AMS in Action', 'woodmart-child' );
$image_url  = ! empty( $data['banner_image'] ) ? $data['banner_image'] : ( ! empty( $core['main_image_url'] ) ? $core['main_image_url'] : '' );

// 4 Highlight Columns
$highlights = ! empty( $data['metrics'] ) ? $data['metrics'] : array(
	array(
		'value' => '',
		'label' => __( '24-Colors/Multi-material', 'woodmart-child' ),
		'desc'  => __( 'Serially connect up to 4 AMS 2 Pro & 8 AMS HT units, total of 24 filaments', 'woodmart-child' ),
	),
	array(
		'value' => '',
		'label' => __( 'Electro-Magnetic Air Vent', 'woodmart-child' ),
		'desc'  => __( 'Fast filament drying & air-tight filament storage', 'woodmart-child' ),
	),
	array(
		'value' => '',
		'label' => __( '65°C Drying', 'woodmart-child' ),
		'desc'  => __( 'Up to 65°C drying temperature', 'woodmart-child' ),
	),
	array(
		'value' => '',
		'label' => __( 'Brushless Motor', 'woodmart-child' ),
		'desc'  => __( '60% faster feeding speed', 'woodmart-child' ),
	),
);
?>

<section class="ams-overview-banner" id="ams-overview">
	<div class="ams-overview-container container">
		<!-- Header Content -->
		<div class="ams-overview-header text-center">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="ams-overview-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<h2 class="ams-overview-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>

			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="ams-overview-subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $video_url ) ) : ?>
				<div class="ams-overview-actions">
					<button type="button" class="btn ams-btn-watch-video" data-video-url="<?php echo esc_url( $video_url ); ?>" aria-label="<?php echo esc_attr( $video_btn ); ?>">
						<span class="play-icon" aria-hidden="true">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
								<polygon points="5 3 19 12 5 21 5 3"></polygon>
							</svg>
						</span>
						<span><?php echo esc_html( $video_btn ); ?></span>
					</button>
				</div>
			<?php endif; ?>
		</div>

		<!-- Central Hero Image Stage with Ambient Glow -->
		<div class="ams-overview-stage">
			<div class="ams-stage-glow" aria-hidden="true"></div>
			<div class="ams-stage-render">
				<?php if ( ! empty( $image_url ) ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="ams-stage-img" loading="lazy">
				<?php else : ?>
					<!-- Stylized High-Fidelity Vector AMS 4-Spool Chassis -->
					<div class="ams-vector-chassis">
						<div class="ams-vector-top-cover">
							<div class="ams-vector-spool spool-1">
								<div class="spool-flange"></div>
								<span class="spool-filament sf-white"></span>
							</div>
							<div class="ams-vector-spool spool-2">
								<div class="spool-flange"></div>
								<span class="spool-filament sf-blue"></span>
							</div>
							<div class="ams-vector-spool spool-3">
								<div class="spool-flange"></div>
								<span class="spool-filament sf-green"></span>
							</div>
							<div class="ams-vector-spool spool-4">
								<div class="spool-flange"></div>
								<span class="spool-filament sf-orange"></span>
							</div>
						</div>
						<div class="ams-vector-feeder-base">
							<div class="feeder-unit fu-1"><span class="led-indicator"></span><span class="feeder-label">1</span></div>
							<div class="feeder-unit fu-2"><span class="led-indicator"></span><span class="feeder-label">2</span></div>
							<div class="feeder-unit fu-3"><span class="led-indicator"></span><span class="feeder-label">3</span></div>
							<div class="feeder-unit fu-4"><span class="led-indicator"></span><span class="feeder-label">4</span></div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- 4-Column Highlights Strip with Dividers (Image 1) -->
		<?php if ( ! empty( $highlights ) && is_array( $highlights ) ) : ?>
			<div class="ams-overview-highlights-strip">
				<?php foreach ( $highlights as $idx => $m ) : 
					$label = $m['label'] ?? ( $m['title'] ?? '' );
					$desc  = $m['desc'] ?? ( $m['description'] ?? '' );
					$is_multicolor = ( 0 === $idx );
				?>
					<div class="ams-highlight-col <?php echo $is_multicolor ? 'is-multicolor' : ''; ?>">
						<h3 class="highlight-title">
							<?php if ( $is_multicolor ) : ?>
								<span class="txt-accent-gradient"><?php echo esc_html( $label ); ?></span>
							<?php else : ?>
								<?php echo esc_html( $label ); ?>
							<?php endif; ?>
						</h3>
						<?php if ( ! empty( $desc ) ) : ?>
							<p class="highlight-desc"><?php echo esc_html( $desc ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $video_url ) ) : ?>
		<!-- Modal Video Popup -->
		<div class="ams-video-modal" id="amsVideoModal" aria-hidden="true" role="dialog">
			<div class="ams-video-modal-backdrop"></div>
			<div class="ams-video-modal-container">
				<button type="button" class="ams-video-modal-close" aria-label="<?php esc_attr_e( 'Close Video', 'woodmart-child' ); ?>">&times;</button>
				<div class="ams-video-modal-iframe-wrap">
					<iframe src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
