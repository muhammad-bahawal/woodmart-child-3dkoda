<?php
/**
 * Template Part: AMS Overview & High-Impact Hero Banner
 *
 * Dark Band Background (#0e1117 / #161b22)
 * - Brand Eyebrow & Hero intro headline
 * - Subtitle description & "Watch Video" popup trigger
 * - High-impact product hero render
 * - 4 Metric cards (4-16 Spool Capacity, Airtight Seal, RFID detection, Auto Backup)
 * - Modal Video popup player
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_ams_section_data( 'overview', $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

$eyebrow    = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'Next-Gen Automated Material System', 'woodmart-child' );
$title      = ! empty( $data['title'] ) ? $data['title'] : __( "Multi-Color 3D Printing.\nEffortless, Airtight & Intelligent.", 'woodmart-child' );
$subtitle   = ! empty( $data['subtitle'] ) ? $data['subtitle'] : __( "Color, the ultimate expression of emotion, is brought to you by Bambu Lab's Automatic Material System (AMS). You can now enjoy printing freely in multiple colors and materials.", 'woodmart-child' );
$video_url  = ! empty( $data['video_url'] ) ? $data['video_url'] : 'https://www.youtube.com/watch?v=kYv9bI3oH6U';
$video_btn  = ! empty( $data['video_btn_text'] ) ? $data['video_btn_text'] : __( 'Watch AMS in Action', 'woodmart-child' );
$image_url  = ! empty( $data['banner_image'] ) ? $data['banner_image'] : ( ! empty( $core['main_image_url'] ) ? $core['main_image_url'] : '' );
$metrics    = ! empty( $data['metrics'] ) ? $data['metrics'] : array();
?>

<section class="ams-overview-banner" id="ams-overview">
	<div class="ams-overview-container container">
		<!-- Header Content -->
		<div class="ams-overview-header text-center">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="ams-eyebrow-pill"><?php echo esc_html( $eyebrow ); ?></span>
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

		<!-- Central Hero Image with Ambient Glow -->
		<div class="ams-overview-stage">
			<div class="ams-stage-glow" aria-hidden="true"></div>
			<div class="ams-stage-render">
				<?php if ( ! empty( $image_url ) ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="ams-stage-img" loading="lazy">
				<?php else : ?>
					<!-- Stylized Vector Silhouette Fallback -->
					<div class="ams-vector-chassis">
						<div class="ams-vector-top-cover">
							<div class="ams-vector-spool spool-1"><span class="spool-glow c-cyan"></span></div>
							<div class="ams-vector-spool spool-2"><span class="spool-glow c-green"></span></div>
							<div class="ams-vector-spool spool-3"><span class="spool-glow c-orange"></span></div>
							<div class="ams-vector-spool spool-4"><span class="spool-glow c-purple"></span></div>
						</div>
						<div class="ams-vector-feeder-base">
							<span class="feeder-port f-1"></span>
							<span class="feeder-port f-2"></span>
							<span class="feeder-port f-3"></span>
							<span class="feeder-port f-4"></span>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- High-Impact 4-Metric Grid -->
		<?php if ( ! empty( $metrics ) && is_array( $metrics ) ) : ?>
			<div class="ams-metrics-grid">
				<?php foreach ( $metrics as $m ) : ?>
					<div class="ams-metric-card">
						<div class="metric-val"><?php echo esc_html( $m['value'] ?? '' ); ?></div>
						<div class="metric-label"><?php echo esc_html( $m['label'] ?? '' ); ?></div>
						<?php if ( ! empty( $m['desc'] ) ) : ?>
							<p class="metric-desc"><?php echo esc_html( $m['desc'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<!-- Modal Video Popup -->
	<div class="ams-video-modal" id="ams-video-modal" aria-hidden="true" role="dialog" aria-modal="true">
		<div class="ams-video-modal-backdrop"></div>
		<div class="ams-video-modal-container">
			<button type="button" class="ams-video-modal-close" aria-label="<?php esc_attr_e( 'Close video modal', 'woodmart-child' ); ?>">&times;</button>
			<div class="ams-video-modal-iframe-wrap">
				<iframe id="ams-modal-iframe" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>
