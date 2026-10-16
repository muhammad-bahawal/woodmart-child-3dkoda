<?php
/**
 * Template Part: Multi-Color & AMS Support
 *
 * Exact match to Image 3:
 * - Green Eyebrow: Automatic Material System
 * - Title: Multi-Color Made Easy
 * - Description: Multi-color printing isn't new...
 * - Visual Showcase Grid:
 *   - Top full-width featured card: Multi-color Cockatiel Bird print on river stones
 *   - Bottom 2-column grid:
 *     - Left: Nordschleife 3D Miniature
 *     - Right: Relic Rush Board Game
 * - 100% Dynamic with image upload support & fallback
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$section_data = woodmart_child_get_laser_crafting_section_data( 'ams_multicolor', $product_id );

$eyebrow    = ! empty( $section_data['eyebrow'] ) ? $section_data['eyebrow'] : __( 'Automatic Material System', 'woodmart-child' );
$title      = ! empty( $section_data['title'] ) ? $section_data['title'] : __( 'Multi-Color Made Easy', 'woodmart-child' );
$desc       = ! empty( $section_data['description'] ) ? $section_data['description'] : __( 'Multi-color printing isn\'t new. Doing it thousands of times in a row, without a single jam, is. That\'s the bar AMS lite is built to clear. Over a million users worldwide have put it through long, color-heavy prints—the kind where one bad swap ruins twelve hours of work—and it keeps swapping.', 'woodmart-child' );

$hero_img   = ! empty( $section_data['hero_img'] ) ? $section_data['hero_img'] : '';
$hero_badge = ! empty( $section_data['hero_badge'] ) ? $section_data['hero_badge'] : __( '4-Color Single-Extruder Swap', 'woodmart-child' );
$sub1_title = ! empty( $section_data['sub1_title'] ) ? $section_data['sub1_title'] : __( 'Nordschleife 3D Miniature', 'woodmart-child' );
$sub1_img   = ! empty( $section_data['sub1_img'] ) ? $section_data['sub1_img'] : '';
$sub2_title = ! empty( $section_data['sub2_title'] ) ? $section_data['sub2_title'] : __( 'Relic Rush Board Game', 'woodmart-child' );
$sub2_img   = ! empty( $section_data['sub2_img'] ) ? $section_data['sub2_img'] : '';
?>

<section class="lc-multicolor-section" id="lc-ams-multicolor">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-multicolor-header text-center">
			<span class="lc-green-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-desc"><?php echo esc_html( $desc ); ?></p>
		</div>

		<!-- Showcase Visual Grid -->
		<div class="lc-multicolor-grid">
			<!-- Top Full-Width Hero Card: Multi-Color Cockatiel Bird -->
			<div class="lc-mc-card lc-mc-card-hero">
				<div class="lc-mc-media lc-mc-bird-scene">
					<?php if ( ! empty( $hero_img ) ) : ?>
						<img src="<?php echo esc_url( $hero_img ); ?>" alt="Multi-Color Hero Model" style="width:100%; height:100%; object-fit:cover;" />
					<?php else : ?>
						<div class="lc-bird-illustration">
							<div class="lc-bird-perch"></div>
							<div class="lc-bird-body">
								<div class="lc-bird-head">
									<div class="lc-bird-crest"></div>
									<div class="lc-bird-beak"></div>
									<div class="lc-bird-eye"></div>
									<div class="lc-bird-cheek"></div>
								</div>
								<div class="lc-bird-wing"></div>
								<div class="lc-bird-tail"></div>
								<div class="lc-bird-feet"></div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $hero_badge ) ) : ?>
						<div class="lc-mc-badge-overlay">
							<span class="lc-mc-badge"><?php echo esc_html( $hero_badge ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Bottom 2-Column Cards -->
			<div class="lc-mc-bottom-row">
				<!-- Card 1: Nordschleife 3D Miniature -->
				<div class="lc-mc-card lc-mc-card-sub">
					<div class="lc-mc-media lc-mc-track-scene">
						<?php if ( ! empty( $sub1_img ) ) : ?>
							<img src="<?php echo esc_url( $sub1_img ); ?>" alt="<?php echo esc_attr( $sub1_title ); ?>" style="width:100%; height:100%; object-fit:cover;" />
						<?php else : ?>
							<div class="lc-miniature-map">
								<div class="lc-map-contour"></div>
								<div class="lc-map-track-line"></div>
								<div class="lc-calipers-graphic"></div>
							</div>
						<?php endif; ?>
						<div class="lc-mc-caption">
							<h3 class="lc-mc-title"><?php echo esc_html( $sub1_title ); ?></h3>
						</div>
					</div>
				</div>

				<!-- Card 2: Relic Rush Board Game -->
				<div class="lc-mc-card lc-mc-card-sub">
					<div class="lc-mc-media lc-mc-game-scene">
						<?php if ( ! empty( $sub2_img ) ) : ?>
							<img src="<?php echo esc_url( $sub2_img ); ?>" alt="<?php echo esc_attr( $sub2_title ); ?>" style="width:100%; height:100%; object-fit:cover;" />
						<?php else : ?>
							<div class="lc-boardgame-diorama">
								<div class="lc-crystal-torches">
									<span class="torch-flame flame-1"></span>
									<span class="torch-flame flame-2"></span>
									<span class="torch-flame flame-3"></span>
								</div>
								<div class="lc-character-figures">
									<div class="lc-char char-1"></div>
									<div class="lc-char char-2"></div>
								</div>
							</div>
						<?php endif; ?>
						<div class="lc-mc-caption">
							<h3 class="lc-mc-title"><?php echo esc_html( $sub2_title ); ?></h3>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>
