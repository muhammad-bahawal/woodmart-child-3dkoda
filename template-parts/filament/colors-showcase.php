<?php
/**
 * Template Part: Filament Colors Showcase Section
 *
 * Color palette showcase matching Figma Image 2:
 * - Eyebrow: "ONE FILAMENT FAMILY. MANY USE CASES"
 * - Title: "Find the Perfect Color"
 * - Description: "With a palette of up to 30 colors, Bambu PLA Basic lets you find the perfect shade..."
 * - Palette Box: 10 vertical columns of color circles with active indicator
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();

if ( ! woodmart_child_is_filament_section_enabled( 'colors_showcase', $product_id ) ) {
	return;
}

$data        = woodmart_child_get_filament_section_data( 'colors_showcase', $product_id );
$eyebrow     = ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : __( 'ONE FILAMENT FAMILY. MANY USE CASES', 'woodmart-child' );
$title       = ! empty( $data['title'] ) ? $data['title'] : __( 'Find the Perfect Color', 'woodmart-child' );
$description = ! empty( $data['description'] ) ? $data['description'] : __( 'With a palette of up to 30 colors, Bambu PLA Basic lets you find the perfect shade to bring flair to your projects. The colors remain consistent across prints, ensuring a stunning and uniform finish every time', 'woodmart-child' );

// Fetch dynamic color options from product attributes
$color_options = function_exists( 'woodmart_child_get_filament_color_options' ) ? woodmart_child_get_filament_color_options( $product_id ) : array();

// Fetch default color set by admin
$product_obj        = wc_get_product( $product_id );
$default_attributes = ( $product_obj instanceof WC_Product ) ? $product_obj->get_default_attributes() : array();
$default_color_slug = '';
if ( ! empty( $default_attributes ) ) {
	foreach ( $default_attributes as $d_key => $d_val ) {
		$d_key_clean = strtolower( trim( str_replace( 'attribute_', '', $d_key ) ) );
		if ( false !== stripos( $d_key_clean, 'color' ) ) {
			$default_color_slug = strtolower( trim( (string) $d_val ) );
			break;
		}
	}
}

$active_color = null;
if ( ! empty( $color_options ) ) {
	if ( $default_color_slug ) {
		foreach ( $color_options as $co ) {
			if ( $co['slug'] === $default_color_slug || sanitize_title( $co['name'] ) === $default_color_slug || strtolower( $co['name'] ) === $default_color_slug ) {
				$active_color = $co;
				break;
			}
		}
	}
	if ( ! $active_color ) {
		$active_color = $color_options[0];
	}
}

// Fallback 10 columns of colors if product has no variable attributes
$color_columns = array(
	// Col 1 (4 dots)
	array(
		array( 'name' => 'White #FFFFFF', 'hex' => '#FFFFFF', 'border' => true ),
		array( 'name' => 'Black #000000', 'hex' => '#111827', 'active' => true ),
		array( 'name' => 'Slate Purple #6366F1', 'hex' => '#6366f1' ),
		array( 'name' => 'Light Gray #9CA3AF', 'hex' => '#9ca3af' ),
	),
	// Col 2 (4 dots)
	array(
		array( 'name' => 'Beige #F5EBE0', 'hex' => '#f5ebe0' ),
		array( 'name' => 'Lime Green #84CC16', 'hex' => '#84cc16' ),
		array( 'name' => 'Dark Indigo #4338CA', 'hex' => '#4338ca' ),
		array( 'name' => 'Deep Violet #3B0764', 'hex' => '#3b0764' ),
	),
	// Col 3 (4 dots)
	array(
		array( 'name' => 'Silver #E2E8F0', 'hex' => '#e2e8f0', 'border' => true ),
		array( 'name' => 'Bright Green #22C55E', 'hex' => '#22c55e' ),
		array( 'name' => 'Dark Slate #334155', 'hex' => '#334155' ),
		array( 'name' => 'Charcoal #1E293B', 'hex' => '#1e293b' ),
	),
	// Col 4 (3 dots)
	array(
		array( 'name' => 'Lemon Yellow #FEF08A', 'hex' => '#fef08a' ),
		array( 'name' => 'Forest Green #15803D', 'hex' => '#15803d' ),
		array( 'name' => 'Cyan #06B6D4', 'hex' => '#06b6d4' ),
	),
	// Col 5 (3 dots)
	array(
		array( 'name' => 'Orange #F97316', 'hex' => '#f97316' ),
		array( 'name' => 'Emerald Green #10B981', 'hex' => '#10b981' ),
		array( 'name' => 'Sky Blue #0284C7', 'hex' => '#0284c7' ),
	),
	// Col 6 (3 dots)
	array(
		array( 'name' => 'Amber Gold #F59E0B', 'hex' => '#f59e0b' ),
		array( 'name' => 'Coral #FB7185', 'hex' => '#fb7185' ),
		array( 'name' => 'Royal Blue #2563EB', 'hex' => '#2563eb' ),
	),
	// Col 7 (3 dots)
	array(
		array( 'name' => 'Bright Orange #EA580C', 'hex' => '#ea580c' ),
		array( 'name' => 'Rose Pink #F43F5E', 'hex' => '#f43f5e' ),
		array( 'name' => 'Navy Blue #1E3A8A', 'hex' => '#1e3a8a' ),
	),
	// Col 8 (3 dots)
	array(
		array( 'name' => 'Light Pink #FBCFE8', 'hex' => '#fbcfe8' ),
		array( 'name' => 'Magenta #EC4899', 'hex' => '#ec4899' ),
		array( 'name' => 'Brown #92400E', 'hex' => '#92400e' ),
	),
	// Col 9 (3 dots)
	array(
		array( 'name' => 'Tan #D4B996', 'hex' => '#d4b996' ),
		array( 'name' => 'Crimson Red #B91C1C', 'hex' => '#b91c1c' ),
		array( 'name' => 'Olive #4D7C0F', 'hex' => '#4d7c0f' ),
	),
	// Col 10 (3 dots)
	array(
		array( 'name' => 'Bronze #78350F', 'hex' => '#78350f' ),
		array( 'name' => 'Burgundy #831843', 'hex' => '#831843' ),
		array( 'name' => 'Slate Gray #6B7280', 'hex' => '#6b7280' ),
	),
);
?>

<section class="filament-colors-section" id="find-colors">
	<div class="container">
		<div class="filament-section-head text-center">
			<?php if ( ! empty( $eyebrow ) ) : ?>
				<span class="filament-eyebrow-orange"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<h2 class="filament-section-title"><?php echo esc_html( $title ); ?></h2>

			<?php if ( ! empty( $description ) ) : ?>
				<p class="filament-section-desc"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Swatch Palette Box (Dynamic from Product Color Variations) -->
		<div class="filament-palette-card" aria-label="<?php esc_attr_e( 'Color swatches palette', 'woodmart-child' ); ?>">
			<?php if ( ! empty( $color_options ) ) : ?>
				<div class="filament-palette-columns filament-dynamic-palette" style="display:flex !important; flex-wrap:wrap !important; justify-content:center !important; align-items:center !important; gap:16px !important; max-width:860px; margin:0 auto;">
					<?php foreach ( $color_options as $c ) : 
						$is_active = ( $active_color && $active_color['slug'] === $c['slug'] );
						$is_border = in_array( strtolower( $c['hex'] ), array( '#ffffff', '#fff', '#fefefe', '#f8fafc', '#f1f5f9' ), true );
					?>
						<button type="button" 
								class="filament-palette-dot <?php echo $is_active ? 'is-active' : ''; ?> <?php echo $is_border ? 'has-border' : ''; ?>" 
								style="--dot-color: <?php echo esc_attr( $c['hex'] ); ?>; width:36px !important; height:36px !important; min-width:36px !important; min-height:36px !important;" 
								data-slug="<?php echo esc_attr( $c['slug'] ); ?>"
								data-name="<?php echo esc_attr( $c['name'] ); ?>"
								data-display="<?php echo esc_attr( $c['display'] ); ?>"
								data-hex="<?php echo esc_attr( $c['hex'] ); ?>"
								aria-label="<?php echo esc_attr( $c['name'] ); ?>"
								title="<?php echo esc_attr( $c['name'] ); ?>">
							<span class="dot-fill" style="background-color: <?php echo esc_attr( $c['hex'] ); ?>; width:22px !important; height:22px !important; min-width:22px !important; min-height:22px !important;"></span>
						</button>
					<?php endforeach; ?>
				</div>

				<!-- Dynamic Active Color Display -->
				<div class="filament-palette-status" id="filament-palette-status">
					<span class="status-swatch" id="filament-palette-status-swatch" style="background-color: <?php echo esc_attr( $active_color['hex'] ?? '#111827' ); ?>;"></span>
					<span class="status-name" id="filament-palette-status-name"><?php echo esc_html( $active_color['display'] ?? ( $active_color['name'] ?? '' ) ); ?></span>
				</div>
			<?php else : ?>
				<!-- Fallback 10-Columns Swatch Palette Box if no variable colors -->
				<div class="filament-palette-columns">
					<?php foreach ( $color_columns as $col_idx => $column ) : ?>
						<div class="filament-palette-col" data-col="<?php echo esc_attr( $col_idx ); ?>">
							<?php foreach ( $column as $swatch ) : 
								$is_active = ! empty( $swatch['active'] );
								$has_border = ! empty( $swatch['border'] );
							?>
								<button type="button" 
										class="filament-palette-dot <?php echo $is_active ? 'is-active' : ''; ?> <?php echo $has_border ? 'has-border' : ''; ?>" 
										style="--dot-color: <?php echo esc_attr( $swatch['hex'] ); ?>;" 
										data-name="<?php echo esc_attr( $swatch['name'] ); ?>"
										data-hex="<?php echo esc_attr( $swatch['hex'] ); ?>"
										aria-label="<?php echo esc_attr( $swatch['name'] ); ?>"
										title="<?php echo esc_attr( $swatch['name'] ); ?>">
									<span class="dot-fill" style="background-color: <?php echo esc_attr( $swatch['hex'] ); ?>;"></span>
								</button>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="filament-palette-status" id="filament-palette-status">
					<span class="status-swatch" id="filament-palette-status-swatch" style="background-color: #111827;"></span>
					<span class="status-name" id="filament-palette-status-name">Black #000000</span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
