<?php
/**
 * Template Part: Unboxing Video Section
 *
 * Exact match to User Instruction 5 & Image 5:
 * - Title: Unboxing Video
 * - Responsive Video Player Card with play button overlay
 * - Supports HTML5 Video or YouTube Embed URL
 * - 100% Dynamic with fallback
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$uv           = ! empty( $settings['unboxing_video'] ) ? $settings['unboxing_video'] : array();
$title        = ! empty( $uv['title'] ) ? $uv['title'] : ( ! empty( $settings['highlights']['unboxing_title'] ) ? $settings['highlights']['unboxing_title'] : __( 'Unboxing Video', 'woodmart-child' ) );
$video_url    = ! empty( $uv['video_url'] ) ? $uv['video_url'] : ( ! empty( $settings['highlights']['video_url'] ) ? $settings['highlights']['video_url'] : 'https://www.youtube.com/watch?v=0h9Vp5a8n2Y' );
$video_poster = ! empty( $uv['video_poster'] ) ? $uv['video_poster'] : ( ! empty( $settings['highlights']['video_poster'] ) ? $settings['highlights']['video_poster'] : '' );
?>

<section class="lc-unboxing-section" id="lc-unboxing-video">
	<div class="container">

		<!-- Section Title -->
		<div class="lc-unboxing-header text-center">
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
		</div>

		<!-- Video Player Container Card -->
		<div class="lc-unboxing-card">
			<div class="lc-video-wrapper" id="lc-unboxing-video-player">
				<?php if ( ! empty( $video_url ) && ( false !== strpos( $video_url, 'youtube.com' ) || false !== strpos( $video_url, 'youtu.be' ) ) ) : 
					// Parse YouTube ID
					preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches );
					$yt_id = ! empty( $matches[1] ) ? $matches[1] : '';
				?>
					<div class="lc-yt-player-box" data-yt-id="<?php echo esc_attr( $yt_id ); ?>">
						<div class="lc-video-poster">
							<?php if ( ! empty( $video_poster ) ) : ?>
								<img src="<?php echo esc_url( $video_poster ); ?>" alt="Unboxing Video Poster" style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0;" />
							<?php else : ?>
								<div class="lc-carton-mockup">
									<div class="lc-carton-brand">
										<div class="lc-bambu-logo-icon"></div>
										<span class="lc-carton-text">Bambu Lab</span>
									</div>
									<span class="lc-carton-model">A2L</span>
									<div class="lc-carton-line-art"></div>
								</div>
							<?php endif; ?>

							<!-- Big Play Button Overlay -->
							<button type="button" class="lc-video-play-btn" aria-label="<?php esc_attr_e( 'Play Unboxing Video', 'woodmart-child' ); ?>">
								<span class="lc-play-icon">▶</span>
							</button>

							<!-- Bottom Player Control Bar Mockup -->
							<div class="lc-player-control-bar">
								<span class="lc-ctrl-play">▶</span>
								<span class="lc-ctrl-time">0:00 / 9:07</span>
								<div class="lc-ctrl-progress-bar">
									<div class="lc-ctrl-progress-fill"></div>
								</div>
								<span class="lc-ctrl-hd">HD</span>
								<span class="lc-ctrl-fs">⛶</span>
							</div>
						</div>
						<div class="lc-yt-iframe-slot" style="display:none;"></div>
					</div>
				<?php else : ?>
					<div class="lc-html5-player-box">
						<video controls poster="<?php echo esc_url( $video_poster ); ?>" style="width:100%; height:100%; border-radius:16px;">
							<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
						</video>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>
