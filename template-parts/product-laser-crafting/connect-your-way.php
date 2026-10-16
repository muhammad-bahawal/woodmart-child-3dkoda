<?php
/**
 * Template Part: Connectivity & Privacy
 *
 * Exact match to User Instruction 4 & Image 4 (Bottom):
 * - Green Eyebrow: Connectivity & Privacy
 * - Title: Connect Your Way
 * - Paragraph: Your printer, your privacy...
 * - Diagram Image Card with Bambu Cloud, LAN Mode, Developer Mode, SD Card & 3rd Party
 * - 100% Dynamic with fallback
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$settings   = woodmart_child_get_laser_crafting_builder_settings( $product_id );

$co          = ! empty( $settings['connectivity'] ) ? $settings['connectivity'] : array();
$eyebrow     = ! empty( $co['eyebrow'] ) ? $co['eyebrow'] : __( 'Connectivity & Privacy', 'woodmart-child' );
$title       = ! empty( $co['title'] ) ? $co['title'] : __( 'Connect Your Way', 'woodmart-child' );
$desc        = ! empty( $co['desc'] ) ? $co['desc'] : __( 'Your printer, your privacy. Use Bambu Cloud for effortless cross-device connectivity, or switch to LAN-only mode for a secure, local-network experience. Total control over how you connect.', 'woodmart-child' );
$connect_img = ! empty( $co['image'] ) ? $co['image'] : ( ! empty( $settings['ams_multicolor']['img_connectivity'] ) ? $settings['ams_multicolor']['img_connectivity'] : '' );
?>

<section class="lc-connect-section" id="lc-connect-way">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-connect-header text-center">
			<span class="lc-green-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-desc"><?php echo esc_html( $desc ); ?></p>
		</div>

		<!-- Connectivity Architecture Image Card -->
		<div class="lc-connect-card">
			<div class="lc-connect-img-wrap">
				<?php if ( ! empty( $connect_img ) ) : ?>
					<img src="<?php echo esc_url( $connect_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="lc-connect-img" />
				<?php else : ?>
					<div class="lc-connect-diagram-stage">
						<!-- Top: Bambu Cloud -->
						<div class="lc-node-cloud">
							<span class="lc-cloud-icon">☁</span>
							<span class="lc-node-lbl"><?php esc_html_e( 'Bambu Cloud', 'woodmart-child' ); ?></span>
						</div>

						<!-- Middle Tier: Clients & Printer -->
						<div class="lc-connect-mid-row">
							<div class="lc-node-client node-handy">
								<span class="lc-device-icon mobile-icon">📱</span>
								<span class="lc-node-lbl"><?php esc_html_e( 'Bambu Handy', 'woodmart-child' ); ?></span>
							</div>

							<div class="lc-node-client node-studio">
								<span class="lc-device-icon pc-icon">💻</span>
								<span class="lc-node-lbl"><?php esc_html_e( 'Bambu Studio & Bambu Suite', 'woodmart-child' ); ?></span>
							</div>

							<div class="lc-node-badge-lan">
								<span class="lc-lan-badge"><?php esc_html_e( 'LAN Mode Only', 'woodmart-child' ); ?></span>
							</div>
						</div>

						<!-- Bottom Tier: Physical Printer Nodes & Local Controls -->
						<div class="lc-connect-bottom-row">
							<div class="lc-node-printer">
								<div class="lc-printer-wireframe">
									<span class="lc-wireframe-lbl"><?php esc_html_e( 'Bambu Lab A2L', 'woodmart-child' ); ?></span>
								</div>
							</div>

							<div class="lc-node-peripherals">
								<div class="lc-periph-item">
									<span class="lc-periph-icon">💾</span>
									<span class="lc-periph-lbl"><?php esc_html_e( 'MicroSD Card', 'woodmart-child' ); ?></span>
								</div>
								<div class="lc-periph-item">
									<span class="lc-periph-icon">⚙</span>
									<span class="lc-periph-lbl"><?php esc_html_e( 'Developer Mode', 'woodmart-child' ); ?></span>
								</div>
								<div class="lc-periph-item">
									<span class="lc-periph-icon">🔒</span>
									<span class="lc-periph-lbl"><?php esc_html_e( 'Hardware Killswitch', 'woodmart-child' ); ?></span>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>
