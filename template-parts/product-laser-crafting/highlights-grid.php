<?php
/**
 * Template Part: Highlights Grid & Video Banner
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
if ( ! woodmart_child_is_laser_crafting_section_enabled( 'highlights', $product_id ) ) {
	return;
}

$section_data    = woodmart_child_get_laser_crafting_section_data( 'highlights', $product_id );
$eyebrow         = ! empty( $section_data['eyebrow'] ) ? $section_data['eyebrow'] : __( 'Oversized Build Volume · Modular Multi-Tool', 'woodmart-child' );
$title           = ! empty( $section_data['title'] ) ? $section_data['title'] : __( "Creative Playground.\nExtra Large.", 'woodmart-child' );
$subtitle        = ! empty( $section_data['description'] ) ? $section_data['description'] : __( 'Expand your creative boundaries with 330 × 320 × 325 mm³ build volume and modular crafting toolheads for cutting, plotting, and printing.', 'woodmart-child' );
$video_url       = ! empty( $section_data['video_url'] ) ? $section_data['video_url'] : '';
$video_title     = ! empty( $section_data['video_title'] ) ? $section_data['video_title'] : __( 'Why choose Bambu Lab A2L', 'woodmart-child' );
$video_btn_text  = ! empty( $section_data['video_btn_text'] ) ? $section_data['video_btn_text'] : __( 'Watch Video', 'woodmart-child' );
$items           = ! empty( $section_data['items'] ) && is_array( $section_data['items'] ) ? $section_data['items'] : array();
$community_title = ! empty( $section_data['community_title'] ) ? $section_data['community_title'] : __( "Printing Is a Blast When There's Always Something New on the Menu", 'woodmart-child' );
$community_sub   = ! empty( $section_data['community_sub'] ) ? $section_data['community_sub'] : __( 'Top Creators · 2M+ Models · One Click Away', 'woodmart-child' );
$community_items = ! empty( $section_data['community_items'] ) && is_array( $section_data['community_items'] ) ? $section_data['community_items'] : array();
?>

<section class="lc-highlights-section" id="lc-highlights">
	<div class="container">

		<!-- Section Heading -->
		<div class="lc-section-header text-center">
			<span class="lc-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>
			<p class="lc-section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
		</div>

		<!-- Video Hero Banner -->
		<?php if ( ! empty( $video_url ) ) : ?>
			<div class="lc-video-banner">
				<div class="lc-video-wrapper">
					<?php if ( false !== strpos( $video_url, 'youtube.com' ) || false !== strpos( $video_url, 'youtu.be' ) ) : 
						// Extract YouTube ID if possible
						preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $video_url, $yt_matches );
						$yt_id = ! empty( $yt_matches[1] ) ? $yt_matches[1] : '';
					?>
						<?php if ( ! empty( $yt_id ) ) : ?>
							<iframe class="lc-feature-video" src="https://www.youtube.com/embed/<?php echo esc_attr( $yt_id ); ?>?rel=0&modestbranding=1" title="<?php echo esc_attr( $video_title ); ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border:0; width:100%; height:100%;"></iframe>
						<?php else : ?>
							<a href="<?php echo esc_url( $video_url ); ?>" target="_blank" rel="noopener noreferrer" class="lc-video-link-wrap">
								<div class="lc-video-overlay">
									<span class="lc-overlay-badge"><?php echo esc_html( $video_btn_text ); ?></span>
									<h3 class="lc-overlay-heading"><?php echo esc_html( $video_title ); ?></h3>
								</div>
							</a>
						<?php endif; ?>
					<?php else : ?>
						<video class="lc-feature-video" autoplay muted loop playsinline>
							<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
						</video>
						<div class="lc-video-overlay">
							<span class="lc-overlay-badge"><?php echo esc_html( $video_btn_text ); ?></span>
							<h3 class="lc-overlay-heading"><?php echo esc_html( $video_title ); ?></h3>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- 6 Core Highlight Metrics Grid -->
		<?php if ( ! empty( $items ) ) : ?>
			<div class="lc-highlights-grid">
				<?php foreach ( $items as $h ) : 
					$val   = ! empty( $h['value'] ) ? $h['value'] : ( ! empty( $h['stat'] ) ? $h['stat'] : '' );
					$label = ! empty( $h['title'] ) ? $h['title'] : ( ! empty( $h['label'] ) ? $h['label'] : '' );
					$desc  = ! empty( $h['desc'] ) ? $h['desc'] : '';
					if ( empty( $val ) && empty( $label ) ) continue;
				?>
					<div class="lc-highlight-card">
						<div class="lc-highlight-stat"><?php echo esc_html( $val ); ?></div>
						<h4 class="lc-highlight-label"><?php echo esc_html( $label ); ?></h4>
						<p class="lc-highlight-desc"><?php echo esc_html( $desc ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Community Creations / Crafting Showcase Strip -->
		<?php if ( ! empty( $community_items ) ) : ?>
			<div class="lc-creations-showcase">
				<div class="lc-creations-header">
					<h3 class="lc-creations-title"><?php echo esc_html( $community_title ); ?></h3>
					<span class="lc-creations-tagline"><?php echo esc_html( $community_sub ); ?></span>
				</div>
				<div class="lc-creations-grid">
					<?php foreach ( $community_items as $c ) : 
						$c_title = ! empty( $c['title'] ) ? $c['title'] : '';
						$c_tag   = ! empty( $c['tag'] ) ? $c['tag'] : '';
						$c_desc  = ! empty( $c['desc'] ) ? $c['desc'] : '';
						$c_img   = ! empty( $c['image'] ) ? $c['image'] : '';
					?>
						<div class="lc-creation-card">
							<?php if ( ! empty( $c_img ) ) : ?>
								<div class="lc-creation-media">
									<img src="<?php echo esc_url( $c_img ); ?>" alt="<?php echo esc_attr( $c_title ); ?>" loading="lazy" />
								</div>
							<?php endif; ?>
							<div class="lc-creation-body">
								<?php if ( ! empty( $c_tag ) ) : ?>
									<span class="lc-creation-tag-pill"><?php echo esc_html( $c_tag ); ?></span>
								<?php endif; ?>
								<h5 class="lc-creation-name"><?php echo esc_html( $c_title ); ?></h5>
								<p class="lc-creation-note"><?php echo esc_html( $c_desc ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</section>
