<?php
/**
 * Template Part: Multi-Tool & Modularity Showcase
 *
 * Exact match to Image 2 (Top Section):
 * - Green Eyebrow: Modular Add-ons
 * - Title: Add a New Dimension with Blade Cutting
 * - Paragraph: Swap the toolhead cover for the cutting module...
 * - 3-Card Interactive Accordion (Expands on Hover):
 *   1. Alignment by Smart Phone
 *   2. Decal Cutting (Default Large / Expanded)
 *   3. Pen Drawing
 *
 * Scoped under: .landing-page-root.laser-crafting-canvas
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$section_data = woodmart_child_get_laser_crafting_section_data( 'modular_addons', $product_id );

$eyebrow = ! empty( $section_data['eyebrow'] ) ? $section_data['eyebrow'] : __( 'Modular Add-ons', 'woodmart-child' );
$title   = ! empty( $section_data['title'] ) ? $section_data['title'] : __( 'Add a New Dimension with Blade Cutting', 'woodmart-child' );
$desc    = ! empty( $section_data['description'] ) ? $section_data['description'] : __( "Swap the toolhead cover for the cutting module, and the A2L isn't just a printer anymore—it cuts. Stickers, leather, fabric, paper. Custom livery for your model plane? Done. A leather wrap for the handle of your Excalibur? Done.", 'woodmart-child' );

$tools = ! empty( $section_data['tools'] ) ? $section_data['tools'] : array();

if ( empty( $tools ) ) {
	$cards = array(
		array(
			'id'    => 'align-phone',
			'title' => __( 'Alignment by<br>Smart Phone', 'woodmart-child' ),
			'desc'  => __( 'Camera vision alignment for 2D print-and-cut jobs', 'woodmart-child' ),
			'class' => 'lc-expand-card-align',
			'image' => '',
		),
		array(
			'id'     => 'decal-cut',
			'title'  => __( 'Decal Cutting', 'woodmart-child' ),
			'desc'   => __( 'Hardened drag blade cuts custom stickers, vinyl and leather', 'woodmart-child' ),
			'class'  => 'lc-expand-card-decal is-expanded',
			'image' => '',
		),
		array(
			'id'    => 'pen-draw',
			'title' => __( 'Pen Drawing', 'woodmart-child' ),
			'desc'  => __( 'Vector line plotting with gel pens, markers & metallic inks', 'woodmart-child' ),
			'class' => 'lc-expand-card-pen',
			'image' => '',
		),
	);
} else {
	$cards = array();
	$default_ids     = array( 'align-phone', 'decal-cut', 'pen-draw' );
	$default_classes = array( 'lc-expand-card-align', 'lc-expand-card-decal is-expanded', 'lc-expand-card-pen' );

	foreach ( array_slice( $tools, 0, 3 ) as $idx => $t ) {
		$cards[] = array(
			'id'    => $default_ids[ $idx ] ?? ( 'tool-' . $idx ),
			'title' => ! empty( $t['title'] ) ? $t['title'] : '',
			'desc'  => ! empty( $t['desc'] ) ? $t['desc'] : ( ! empty( $t['subtitle'] ) ? $t['subtitle'] : '' ),
			'class' => $default_classes[ $idx ] ?? 'lc-expand-card-tool',
			'image' => ! empty( $t['image'] ) ? $t['image'] : '',
		);
	}
}
?>

<section class="lc-modular-section" id="lc-modular-addons">
	<div class="container">

		<!-- Section Header -->
		<div class="lc-modular-header text-center">
			<span class="lc-green-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="lc-section-title"><?php echo esc_html( $title ); ?></h2>
			<p class="lc-section-desc"><?php echo esc_html( $desc ); ?></p>
		</div>

		<!-- 3-Column Expandable Image Accordion (Hover Expands) -->
		<div class="lc-accordion-cards-wrap" id="lc-modular-accordion">
			<?php foreach ( $cards as $c_idx => $card ) : ?>
				<div class="lc-expand-card <?php echo esc_attr( $card['class'] ); ?>" data-card-id="<?php echo esc_attr( $card['id'] ); ?>" tabindex="0">
					<div class="lc-expand-card-bg">
						<?php if ( ! empty( $card['image'] ) ) : ?>
							<div class="lc-card-custom-img-layer" style="width:100%; height:100%; position:absolute; inset:0;">
								<img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $card['title'] ) ); ?>" style="width:100%; height:100%; object-fit:cover;" />
							</div>
						<?php else : ?>
							<div class="lc-card-visual-layer visual-<?php echo esc_attr( $card['id'] ); ?>">
								<?php if ( 'align-phone' === $card['id'] ) : ?>
									<!-- Phone Alignment Mockup -->
									<div class="lc-phone-mockup-layer">
										<div class="lc-phone-chassis">
											<div class="lc-phone-notch"></div>
											<div class="lc-phone-screen">
												<div class="lc-viewfinder-grid">
													<div class="lc-viewfinder-box"></div>
													<div class="lc-align-dot"></div>
												</div>
											</div>
										</div>
									</div>
								<?php elseif ( 'decal-cut' === $card['id'] ) : ?>
									<!-- Blade Cutting Toolhead Mockup -->
									<div class="lc-cutter-mockup-layer">
										<div class="lc-cutter-head">
											<div class="lc-blade-tip"></div>
										</div>
										<div class="lc-cut-pattern"></div>
									</div>
								<?php elseif ( 'pen-draw' === $card['id'] ) : ?>
									<!-- Pen Plotter Mockup -->
									<div class="lc-pen-mockup-layer">
										<div class="lc-pen-holder">
											<div class="lc-pen-tip"></div>
										</div>
										<div class="lc-blueprint-grid"></div>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<div class="lc-expand-card-gradient"></div>
					</div>
					<div class="lc-expand-card-caption">
						<h3 class="lc-expand-title"><?php echo wp_kses( $card['title'], array( 'br' => array() ) ); ?></h3>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
