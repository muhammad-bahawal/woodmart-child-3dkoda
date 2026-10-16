<?php
/**
 * Template Part: Laser & Crafting Overview Banner
 *
 * Exact match to Image 2:
 * - Full-width high-impact hero showcase
 * - Title: Bambu Lab A2L
 * - Heading: Creative Playground. Extra Large.
 * - Button: Watch Video (Opens in-page popup modal)
 * - Studio photo / Product image with fallback
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$title       = ! empty( $settings['overview']['title'] ) ? $settings['overview']['title'] : ( ! empty( $settings['highlights']['title'] ) ? $settings['highlights']['title'] : __( "Creative Playground.\nExtra Large.", 'woodmart-child' ) );
$brand_title = ! empty( $settings['overview']['brand_title'] ) ? $settings['overview']['brand_title'] : ( ! empty( $settings['general']['brand_name'] ) ? $settings['general']['brand_name'] . ' A2L' : 'Bambu Lab A2L' );
$video_url   = ! empty( $settings['overview']['video_url'] ) ? $settings['overview']['video_url'] : ( ! empty( $settings['highlights']['video_url'] ) ? $settings['highlights']['video_url'] : 'https://www.youtube.com/watch?v=0h9Vp5a8n2Y' );
$video_btn   = ! empty( $settings['overview']['video_btn_text'] ) ? $settings['overview']['video_btn_text'] : ( ! empty( $settings['highlights']['video_btn_text'] ) ? $settings['highlights']['video_btn_text'] : __( 'Watch Video', 'woodmart-child' ) );

// Fetch banner image with robust fallback
$banner_img  = ! empty( $settings['overview']['banner_image'] ) ? $settings['overview']['banner_image'] : ( ! empty( $settings['highlights']['banner_image'] ) ? $settings['highlights']['banner_image'] : '' );
if ( empty( $banner_img ) ) {
	$banner_img = get_the_post_thumbnail_url( $product_id, 'full' );
}
?>

<section class="lc-overview-banner" id="lc-overview">
	<div class="container lc-overview-inner">
		<div class="lc-overview-content">
			<span class="lc-overview-sub"><?php echo esc_html( $brand_title ); ?></span>
			<h2 class="lc-overview-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>
			<?php if ( ! empty( $video_url ) ) : ?>
				<div class="lc-overview-action">
					<a href="<?php echo esc_url( $video_url ); ?>" class="lc-btn-watch-video" data-video-url="<?php echo esc_url( $video_url ); ?>" role="button" aria-haspopup="dialog">
						<span><?php echo esc_html( $video_btn ); ?></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<div class="lc-overview-media">
			<?php if ( ! empty( $banner_img ) ) : ?>
				<img src="<?php echo esc_url( $banner_img ); ?>" alt="<?php echo esc_attr( $brand_title ); ?>" class="lc-overview-img" />
			<?php else : ?>
				<div class="lc-overview-placeholder" style="width: 100%; max-width: 520px; aspect-ratio: 16/10; background: linear-gradient(135deg, #e5e7eb, #d1d5db); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(0,0,0,0.06);">
					<span style="font-weight: 700; color: #4b5563; font-size: 18px;"><?php echo esc_html( $brand_title ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Video Popup Modal -->
<div class="lc-video-modal" id="lc-video-modal" aria-hidden="true" role="dialog" aria-modal="true">
	<div class="lc-video-modal-backdrop"></div>
	<div class="lc-video-modal-dialog">
		<button type="button" class="lc-video-modal-close" aria-label="<?php esc_attr_e( 'Close Video', 'woodmart-child' ); ?>">&times;</button>
		<div class="lc-video-modal-body">
			<iframe id="lc-modal-iframe" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
	</div>
</div>
