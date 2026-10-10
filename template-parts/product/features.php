<?php
/**
 * Template Part: Product Features Section (Dark) - Figma Pixel-Perfect Specification
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$data       = woodmart_child_get_section_data( 'features', $product_id );
$core       = woodmart_child_get_core_product_data( $product_id );

if ( empty( $data ) || empty( $data['enabled'] ) ) {
	return;
}

$main_bullets = array();
if ( ! empty( $data['main']['bullets'] ) ) {
	$main_bullets = array_filter( array_map( 'trim', explode( "\n", $data['main']['bullets'] ) ) );
}

$bullet_icons = array(
	// 1. Crosshair / auto-calibration scan icon matching Figma
	'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V4h4M20 8V4h-4M4 16v4h4M20 16v4h-4"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/><line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/></svg>',
	// 2. Built-in video camera icon matching Figma
	'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7l-7 5 7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>',
	// 3. Connected control / WiFi signal icon matching Figma
	'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1"/></svg>',
);

$grid_icons = array(
	// 02: Lightning ⚡ (Speed without guesswork)
	'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
	// 03: Speed bolt ⚡ (Ready sooner)
	'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
	// 04: Hex gear / materials ⚙️ (Demanding materials)
	'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 19 6 19 18 12 22 5 18 5 6 12 2"/><circle cx="12" cy="12" r="3.5"/></svg>',
	// 05: Sound waves / quiet room 🔈 (Made for the room you work in)
	'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff5e1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>',
);

$feature_img = ! empty( $data['main']['image'] ) ? $data['main']['image'] : ( ! empty( $core['main_image_url'] ) ? $core['main_image_url'] : '' );
?>

<section class="section dark product-features" id="features">
	<div class="container">
		<div class="section__head">
			<?php if ( ! empty( $data['eyebrow'] ) ) : ?>
				<span class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $data['title'] ) ) : ?>
				<h2><?php echo nl2br( esc_html( $data['title'] ) ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $data['description'] ) ) : ?>
				<p><?php echo esc_html( $data['description'] ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Main Hero Feature Card matching Figma -->
		<?php if ( ! empty( $data['main']['title'] ) ) : ?>
			<div class="feature-main">
				<div class="feature-main__media">
					<?php woodmart_child_render_image( $feature_img, $data['main']['title'], 'feature-main-img', 'Product image' ); ?>
				</div>

				<div class="feature-main__content">
					<?php if ( ! empty( $data['main']['num'] ) ) : ?>
						<span class="num"><?php echo esc_html( $data['main']['num'] ); ?></span>
					<?php endif; ?>

					<h3 class="feature-main__title"><?php echo esc_html( $data['main']['title'] ); ?></h3>

					<?php if ( ! empty( $data['main']['description'] ) ) : ?>
						<p class="feature-main__desc"><?php echo esc_html( $data['main']['description'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $main_bullets ) ) : ?>
						<ul class="feature-main__bullets">
							<?php foreach ( $main_bullets as $b_idx => $bullet ) :
								$b_icon = isset( $bullet_icons[ $b_idx ] ) ? $bullet_icons[ $b_idx ] : $bullet_icons[0];
							?>
								<li>
									<span class="bullet-icon"><?php echo $b_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									<span class="bullet-text"><?php echo esc_html( $bullet ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- 4-Grid Features matching Figma -->
		<?php if ( ! empty( $data['grid'] ) ) : ?>
			<div class="grid grid--4 product-features__grid">
				<?php foreach ( $data['grid'] as $g_idx => $fg ) :
					$g_icon = isset( $grid_icons[ $g_idx ] ) ? $grid_icons[ $g_idx ] : $grid_icons[0];
				?>
					<article class="feature">
						<?php if ( ! empty( $fg['num'] ) ) : ?>
							<span class="feature__num"><?php echo esc_html( $fg['num'] ); ?></span>
						<?php endif; ?>
						<div class="feature__icon">
							<?php echo $g_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<h3 class="feature__title"><?php echo esc_html( $fg['title'] ); ?></h3>
						<p class="feature__desc"><?php echo esc_html( $fg['description'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
