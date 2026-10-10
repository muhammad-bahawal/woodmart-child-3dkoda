<?php
/**
 * Woodmart Child Theme Helper Functions
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Check if the custom product landing page is enabled for a given product.
 *
 * @param int|WC_Product|null $product_or_id Product ID or WC_Product object.
 * @return bool True if custom landing page is enabled.
 */
function woodmart_child_is_custom_landing( $product_or_id = null ) {
	$product_id = 0;

	if ( $product_or_id instanceof WC_Product ) {
		$product_id = $product_or_id->get_id();
	} elseif ( is_numeric( $product_or_id ) && $product_or_id > 0 ) {
		$product_id = absint( $product_or_id );
	} elseif ( is_singular( 'product' ) || ( function_exists( 'is_product' ) && is_product() ) ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	} elseif ( is_admin() && isset( $_GET['post'] ) && is_numeric( $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$product_id = absint( $_GET['post'] );
	}

	if ( ! $product_id ) {
		return false;
	}

	$enabled = get_post_meta( $product_id, '_woodmart_child_custom_landing_enabled', true );

	// If not explicitly set yet, check builder array or default to true ('1')
	if ( '' === $enabled ) {
		$settings = get_post_meta( $product_id, '_woodmart_child_product_builder', true );
		if ( is_array( $settings ) && isset( $settings['general']['enable_landing'] ) ) {
			$enabled = $settings['general']['enable_landing'];
		} else {
			$enabled = '1';
		}
	}

	return ( '0' !== (string) $enabled && 'no' !== (string) $enabled && false !== $enabled );
}

/**
 * Get default demo data matching the Bambu Lab X1-Carbon prototype.
 *
 * @return array
 */
function woodmart_child_get_default_builder_data() {
	return array(
		'general'        => array(
			'enable_landing'     => '1',
			'eyebrow'            => 'Flagship CoreXY',
			'badge_text'         => '● Authorized Bambu Lab Reseller',
			'brand_name'         => 'Bambu Lab',
			'announcement_left'  => 'From Tallinn to your door. 1–2 day Baltic delivery.',
			'announcement_mid'   => 'Estonia · Latvia · Lithuania | EN',
			'announcement_right' => 'Prices incl. VAT',
			'reseller_strip'     => '<b>●</b> Authorized Bambu Lab Reseller · <span class="muted">Product-page concept · Sample prices, stock and SKU mappings · No payment is processed.</span>',
			'benefits'           => array(
				array(
					'title'    => 'Fast Baltic delivery',
					'subtitle' => 'Dispatched from Tallinn',
				),
				array(
					'title'    => 'Local warranty',
					'subtitle' => 'Guidance from our team',
				),
				array(
					'title'    => 'Human support',
					'subtitle' => 'Before and after purchase',
				),
			),
			'team_quote_text'    => 'Buying for a team? <a href="#packages">Request a tailored quote</a> · <a href="#packages">Show ex. VAT</a> · <a href="#packages">Compare packages</a>',
		),
		'highlights'     => array(
			'enabled'     => '1',
			'eyebrow'     => 'From idea to finished part',
			'title'       => "A printer that keeps up\nwith your ambition.",
			'description' => 'Spend less time tuning and more time making. The X1-Carbon combines automated setup, high speed CoreXY motion and an enclosed workspace in one refined machine.',
			'items'       => array(
				array(
					'value' => '256³ mm',
					'label' => 'build volume',
				),
				array(
					'value' => '300 °C',
					'label' => 'hotend capability',
				),
				array(
					'value' => 'CoreXY',
					'label' => 'fast, stable motion',
				),
				array(
					'value' => 'AMS ready',
					'label' => 'multi material freedom',
				),
			),
		),
		'features'       => array(
			'enabled'     => '1',
			'eyebrow'     => 'Intelligence built into the workflow',
			'title'       => "Confident first layers.\nFewer interrupted prints.",
			'description' => 'Automation handles the routine checks, so you can focus on the part that matters: the result.',
			'main'        => array(
				'num'         => '01',
				'title'       => 'A system that watches the details.',
				'description' => 'Automated calibration, flow checks and camera monitoring support a smoother start and better visibility during long jobs.',
				'image'       => '',
				'bullets'     => "Automatic calibration workflow\nBuilt-in camera monitoring\nConnected control through Bambu software",
			),
			'grid'        => array(
				array(
					'num'         => '02',
					'title'       => 'Speed without guesswork',
					'description' => 'CoreXY motion and input shaping support fast movement while maintaining control.',
				),
				array(
					'num'         => '03',
					'title'       => 'Ready sooner',
					'description' => 'Automated bed leveling and guided setup reduce repetitive preparation.',
				),
				array(
					'num'         => '04',
					'title'       => 'Engineered for demanding materials',
					'description' => 'An enclosed build area and hardened extrusion components expand your material options.',
				),
				array(
					'num'         => '05',
					'title'       => 'Made for the room you work in',
					'description' => 'Enclosure and active monitoring create a more composed desktop workflow.',
				),
			),
		),
		'materials'      => array(
			'enabled'     => '1',
			'eyebrow'     => 'One machine. More ways to make.',
			'title'       => "Prototype today.\nProduce tomorrow.",
			'description' => 'Move from clean visual models to functional components without changing your ambition.',
			'items'       => array(
				array(
					'color'       => '#ff6b57',
					'name'        => 'PLA',
					'subtitle'    => 'Fast concepts',
					'description' => 'Reliable everyday prints and presentation models.',
					'image'       => '',
				),
				array(
					'color'       => '#2eb6c9',
					'name'        => 'PETG',
					'subtitle'    => 'Functional parts',
					'description' => 'Balanced durability for tools, fixtures and useful objects.',
					'image'       => '',
				),
				array(
					'color'       => '#f2b705',
					'name'        => 'ABS / ASA',
					'subtitle'    => 'Working prototypes',
					'description' => 'Enclosure friendly options for tougher applications.',
					'image'       => '',
				),
				array(
					'color'       => '#1f2a44',
					'name'        => 'CF MATERIALS',
					'subtitle'    => 'Engineering intent',
					'description' => 'Hardened components support compatible abrasive composites.',
					'image'       => '',
				),
			),
			'combo'       => array(
				'eyebrow'     => 'With the X1–Carbon Combo',
				'title'       => 'Four colors. One continuous workflow.',
				'description' => 'AMS automates material loading and enables multi color or support interface workflows. Build a system that grows with the way you print.',
				'link_text'   => 'See what the Combo adds',
				'link_url'    => '#packages',
				'image'       => '',
			),
		),
		'use_cases'      => array(
			'enabled' => '1',
			'eyebrow' => 'Where it earns its place',
			'title'   => "Made for ideas\nthat have somewhere to go.",
			'items'   => array(
				array(
					'num'         => '01',
					'title'       => 'Product development',
					'description' => 'Move through form, fit and function without waiting on an outside supplier.',
				),
				array(
					'num'         => '02',
					'title'       => 'Small production',
					'description' => 'Build jigs, fixtures and repeatable parts near the work that needs them.',
				),
				array(
					'num'         => '03',
					'title'       => 'Education & labs',
					'description' => 'Give learners a dependable path from CAD to a physical result.',
				),
				array(
					'num'         => '04',
					'title'       => 'Creative studios',
					'description' => 'Create props, models and detailed objects with broad material choice.',
				),
			),
		),
		'packages'       => array(
			'enabled'     => '1',
			'eyebrow'     => 'Choose the system around your work',
			'title'       => 'Standalone or Combo?',
			'description' => 'The printer is the same. The workflow is what changes.',
			'standalone'  => array(
				'eyebrow'     => 'Focused & flexible',
				'title'       => 'X1–Carbon',
				'price_note'  => 'incl. 24% VAT · sample price',
				'description' => 'For makers who mainly print one material or color at a time.',
				'bullets'     => "X1-Carbon printer\nEnclosed CoreXY platform\nTextured PEI plate\nLocal Baltic support",
				'btn_text'    => 'Choose Standalone',
			),
			'combo'       => array(
				'badge'       => 'OUR RECOMMENDED SETUP',
				'eyebrow'     => 'Multi material ready',
				'title'       => 'X1–Carbon Combo',
				'price_note'  => 'incl. 24% VAT · sample price',
				'description' => 'For a more automated workflow with multi color and material management.',
				'bullets'     => "Everything in Standalone\nAutomatic Material System\nAutomatic material loading\nMulti color workflow",
				'btn_text'    => 'Choose Combo',
			),
			'brand'       => array(
				'eyebrow'     => 'The 3DKoda difference',
				'title'       => "A powerful printer.\nA local team behind it.",
				'description' => 'Buying the machine is the first step. We help you choose the setup, start confidently, find genuine parts and navigate support when you need it.',
				'btn_text'    => 'Talk to a local expert',
				'btn_url'     => '#',
				'cards'       => array(
					array(
						'title'       => 'Tallinn based stock',
						'description' => 'Faster dispatch and clear local availability.',
					),
					array(
						'title'       => 'Warranty guidance',
						'description' => 'A local point of contact for eligible warranty cases.',
					),
					array(
						'title'       => 'Practical diagnostics',
						'description' => 'Help from people familiar with the printer and its workflow.',
					),
					array(
						'title'       => 'Business purchasing',
						'description' => 'VAT invoices, volume quotes and setup advice for teams.',
					),
				),
			),
		),
		'specs'          => array(
			'enabled'     => '1',
			'eyebrow'     => 'The details behind the decision',
			'title'       => 'Technical specifications.',
			'description' => 'Key purchase planning information. Final launch data will be verified against official Bambu documentation.',
			'note'        => 'Specifications shown for design demonstration. Confirm regional package, electrical, safety and exact technical details in the approved product feed before launch.',
			'items'       => array(
				array(
					'label' => 'Printing technology',
					'value' => 'Fused Deposition Modeling (FDM)',
				),
				array(
					'label' => 'Build volume',
					'value' => '256 × 256 × 256 mm',
				),
				array(
					'label' => 'Motion system',
					'value' => 'CoreXY',
				),
				array(
					'label' => 'Maximum hotend temperature',
					'value' => '300 °C',
				),
				array(
					'label' => 'Maximum build plate temperature',
					'value' => '110 °C',
				),
				array(
					'label' => 'Standard nozzle',
					'value' => '0.4 mm hardened steel',
				),
				array(
					'label' => 'Supported nozzle sizes',
					'value' => '0.2 / 0.4 / 0.6 / 0.8 mm',
				),
				array(
					'label' => 'Extruder gears',
					'value' => 'Hardened steel',
				),
				array(
					'label' => 'Enclosure',
					'value' => 'Fully enclosed',
				),
				array(
					'label' => 'Bed leveling',
					'value' => 'Automatic',
				),
				array(
					'label' => 'Monitoring',
					'value' => 'Built-in camera and AI assisted detection',
				),
				array(
					'label' => 'Connectivity',
					'value' => 'Wi-Fi / Bambu Studio / Bambu Handy',
				),
				array(
					'label' => 'Display',
					'value' => '5 inch touchscreen',
				),
				array(
					'label' => 'Multi material',
					'value' => 'AMS compatible',
				),
			),
			'setup'       => array(
				'eyebrow'     => 'Setup without the uncertainty',
				'title'       => "From the box\nto your first print.",
				'description' => 'The final page can embed the approved official setup or unboxing video. Until then, the Bambu Lab wiki provides the latest model specific guidance.',
				'link_text'   => 'Open official X1 setup guide ↗',
				'link_url'    => '#',
				'image'       => '',
			),
		),
		'box_contents'   => array(
			'enabled'          => '1',
			'eyebrow'          => 'Start with what you need',
			'title'            => 'What’s in the box.',
			'note'             => 'Contents are representative for the concept. Confirm exact regional contents against the selected official SKU.',
			'standalone_title' => 'X1–Carbon',
			'standalone_items' => array(
				'X1-Carbon 3D printer',
				'Textured PEI build plate',
				'0.4 mm hardened steel hotend',
				'Accessory box',
				'Power cable',
				'Build plate glue',
				'Maintenance tools',
				'Quick start materials',
			),
			'combo_title'      => 'X1–Carbon Combo',
			'combo_badge'      => 'RECOMMENDED',
			'combo_items'      => array(
				'X1-Carbon 3D printer',
				'Textured PEI build plate',
				'0.4 mm hardened steel hotend',
				'Accessory box',
				'Power cable',
				'Build plate glue',
				'Maintenance tools',
				'Quick start materials',
				'Automatic Material System (AMS)',
				'AMS buffer',
				'AMS connection cable',
				'PTFE tubes for AMS',
			),
		),
		'faq'            => array(
			'enabled'     => '1',
			'eyebrow'     => 'Before you decide',
			'title'       => 'Questions, answered.',
			'description' => 'Still deciding? Our team can help you match the printer to your work.',
			'btn_text'    => 'Ask 3DKoda',
			'btn_url'     => '#',
			'items'       => array(
				array(
					'question' => 'Is the X1–Carbon suitable for a first 3D printer?',
					'answer'   => 'Yes. Its automated calibration and guided setup make it approachable, while its speed, enclosure and material capability leave room to grow. Our team can help with setup and your first material profiles.',
				),
				array(
					'question' => 'What is the difference between Standalone and Combo?',
					'answer'   => 'The printer is the same. The Combo adds the Automatic Material System (AMS) for multi color and multi material workflows.',
				),
				array(
					'question' => 'Which materials can I print?',
					'answer'   => 'PLA, PETG, ABS / ASA and, with the hardened components, compatible carbon fibre composites.',
				),
				array(
					'question' => 'Does it include local warranty support?',
					'answer'   => 'Yes, our local team guides eligible warranty cases.',
				),
				array(
					'question' => 'How fast is delivery?',
					'answer'   => 'Dispatched from Tallinn with 1–2 day Baltic delivery.',
				),
				array(
					'question' => 'Can my company buy without Estonian VAT?',
					'answer'   => 'Business customers can request VAT invoices and quotes.',
				),
				array(
					'question' => 'Can you help choose materials and accessories?',
					'answer'   => 'Yes, ask our team for recommendations.',
				),
			),
			'cta'         => array(
				'eyebrow'     => 'Ready when your next idea is',
				'title'       => 'Make the leap<br>from concept to real.',
				'description' => 'Choose your X1–Carbon setup or talk with a local expert first.',
				'btn1_text'   => 'Choose X1–Carbon Combo',
				'btn1_url'    => '#packages',
				'btn2_text'   => 'Request a business quote ↗',
				'btn2_url'    => '#',
			),
		),
	);
}

/**
 * Check if an array is associative (not a numerically indexed list).
 *
 * @param array $arr Array to check.
 * @return bool
 */
function woodmart_child_is_assoc_array( array $arr ) {
	if ( empty( $arr ) ) {
		return false;
	}
	return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
}

/**
 * Merge saved builder settings over defaults without corrupting indexed repeater lists.
 *
 * @param array $defaults Default settings template.
 * @param array $saved    Saved settings from post meta.
 * @return array
 */
function woodmart_child_merge_builder_settings( array $defaults, array $saved ) {
	$result = $defaults;
	foreach ( $saved as $key => $val ) {
		if ( ! array_key_exists( $key, $defaults ) ) {
			$result[ $key ] = $val;
		} elseif ( is_array( $val ) && is_array( $defaults[ $key ] ) && woodmart_child_is_assoc_array( $defaults[ $key ] ) ) {
			$result[ $key ] = woodmart_child_merge_builder_settings( $defaults[ $key ], $val );
		} else {
			// For scalar values and numerically indexed repeater lists, the saved data takes full authority.
			$result[ $key ] = $val;
		}
	}
	return $result;
}

/**
 * Get all builder settings for a product, merged with defaults.
 *
 * @param int $product_id Product ID.
 * @return array
 */
function woodmart_child_get_builder_settings( $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$defaults = woodmart_child_get_default_builder_data();
	$saved    = get_post_meta( $product_id, '_woodmart_child_product_builder', true );

	if ( ! is_array( $saved ) || empty( $saved ) ) {
		return $defaults;
	}

	return woodmart_child_merge_builder_settings( $defaults, $saved );
}

/**
 * Check if a specific builder section is enabled AND contains actual data.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return bool
 */
function woodmart_child_is_section_enabled( $section_key, $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$settings = woodmart_child_get_builder_settings( $product_id );

	if ( ! isset( $settings[ $section_key ] ) ) {
		return false;
	}

	$section = $settings[ $section_key ];

	// Must have enabled toggle on
	if ( ! isset( $section['enabled'] ) || ! in_array( (string) $section['enabled'], array( '1', 'yes', 'true' ), true ) ) {
		return false;
	}

	// Must contain actual content depending on section type
	switch ( $section_key ) {
		case 'highlights':
		case 'use_cases':
			return ! empty( $section['items'] );

		case 'features':
			return ! empty( $section['main']['title'] ) || ! empty( $section['grid'] );

		case 'materials':
			return ! empty( $section['items'] ) || ! empty( $section['combo']['title'] );

		case 'packages':
			return ! empty( $section['standalone']['title'] ) || ! empty( $section['combo']['title'] );

		case 'specs':
			return ! empty( $section['items'] ) || ! empty( $section['setup']['title'] );

		case 'box_contents':
			return ! empty( $section['standalone_items'] ) || ! empty( $section['combo_items'] );

		case 'faq':
			return ! empty( $section['items'] ) || ! empty( $section['cta']['title'] );

		default:
			if ( isset( $section['items'] ) && empty( $section['items'] ) ) {
				return false;
			}
			return true;
	}
}

/**
 * Get section data for a given product.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return array
 */
function woodmart_child_get_section_data( $section_key, $product_id = 0 ) {
	$settings = woodmart_child_get_builder_settings( $product_id );
	return isset( $settings[ $section_key ] ) ? $settings[ $section_key ] : array();
}

/**
 * Extract and format WooCommerce core product data for the custom product landing page.
 *
 * @param int|WC_Product|null $product_or_id
 * @return array
 */
function woodmart_child_get_core_product_data( $product_or_id = null ) {
	$product = null;

	if ( $product_or_id instanceof WC_Product ) {
		$product = $product_or_id;
	} elseif ( is_numeric( $product_or_id ) && $product_or_id > 0 ) {
		$product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_or_id ) : null;
	} elseif ( function_exists( 'is_product' ) && is_product() && function_exists( 'wc_get_product' ) ) {
		$product = wc_get_product( get_queried_object_id() ?: get_the_ID() );
	}

	if ( ! $product ) {
		return array();
	}

	$product_id = $product->get_id();

	// Primary image
	$main_image_id  = $product->get_image_id();
	$main_image_url = $main_image_id ? wp_get_attachment_image_url( $main_image_id, 'full' ) : '';
	$main_thumb_url = $main_image_id ? wp_get_attachment_image_url( $main_image_id, 'thumbnail' ) : '';

	// Gallery images
	$gallery_ids    = $product->get_gallery_image_ids();
	$gallery_images = array();

	if ( $main_image_id ) {
		$gallery_images[] = array(
			'id'    => $main_image_id,
			'url'   => $main_image_url,
			'thumb' => $main_thumb_url,
			'alt'   => get_post_meta( $main_image_id, '_wp_attachment_image_alt', true ) ?: $product->get_name(),
		);
	}

	if ( ! empty( $gallery_ids ) ) {
		foreach ( $gallery_ids as $gid ) {
			$gallery_images[] = array(
				'id'    => $gid,
				'url'   => wp_get_attachment_image_url( $gid, 'full' ),
				'thumb' => wp_get_attachment_image_url( $gid, 'thumbnail' ),
				'alt'   => get_post_meta( $gid, '_wp_attachment_image_alt', true ) ?: $product->get_name(),
			);
		}
	}

	// Categories
	$categories = wc_get_product_terms( $product_id, 'product_cat', array( 'fields' => 'all' ) );
	$primary_cat = ! empty( $categories ) && ! is_wp_error( $categories ) ? $categories[0] : null;

	// Stock
	$is_in_stock  = $product->is_in_stock();
	$stock_status = $product->get_stock_status();
	$stock_label  = $is_in_stock ? __( '● In Stock · Tallinn', 'woodmart-child' ) : __( '○ Out of stock', 'woodmart-child' );

	// Variations
	$is_variable = $product->is_type( 'variable' );
	$variations  = array();

	if ( $is_variable ) {
		$available_variations = $product->get_available_variations();

		foreach ( $available_variations as $idx => $var ) {
			$var_obj     = wc_get_product( $var['variation_id'] );
			$var_price   = $var['display_price'];
			$formatted_p = wc_price( $var_price );

			// Retrieve configured package labels if available
			$builder_settings = woodmart_child_get_builder_settings( $product_id );
			$sa_title         = ! empty( $builder_settings['packages']['standalone']['title'] ) ? $builder_settings['packages']['standalone']['title'] : $product->get_name();
			$cb_title         = ! empty( $builder_settings['packages']['combo']['title'] ) ? $builder_settings['packages']['combo']['title'] : ( $product->get_name() . ' Combo' );

			// Name fallback or attribute title
			$attr_summary = implode( ' / ', array_values( $var['attributes'] ) );
			$var_title    = $var_obj ? $var_obj->get_name() : $product->get_name() . ' ' . $attr_summary;

			// Match setup labels if available
			$is_combo = ( false !== stripos( $var_title, 'combo' ) || false !== stripos( $attr_summary, 'combo' ) || $idx === 1 );

			$display_title = $is_combo ? $cb_title : $sa_title;
			if ( $var_obj && $var_obj->get_name() && $var_obj->get_name() !== $product->get_name() ) {
				$display_title = $var_obj->get_name();
			}

			$variations[] = array(
				'id'           => $var['variation_id'],
				'title'        => $display_title,
				'subtitle'     => $is_combo ? __( 'Add AMS for automatic multi color and multi material printing.', 'woodmart-child' ) : __( 'The printer, ready for focused single material work.', 'woodmart-child' ),
				'price_raw'    => $var_price,
				'price_html'   => $formatted_p,
				'sku'          => $var['sku'] ?: $product->get_sku(),
				'in_stock'     => $var['is_in_stock'],
				'is_combo'     => $is_combo,
				'image_url'    => ! empty( $var['image']['url'] ) ? $var['image']['url'] : $main_image_url,
				'attributes'   => $var['attributes'],
			);
		}
	}

	// For simple products, provide single accurate variation mapping without inventing fake options
	if ( empty( $variations ) ) {
		$base_price     = $product->get_price();
		$base_price_num = is_numeric( $base_price ) ? (float) $base_price : 0.0;
		$formatted_p    = $product->get_price_html() ?: wc_price( $base_price_num );

		$variations = array(
			array(
				'id'         => $product_id,
				'title'      => $product->get_name(),
				'subtitle'   => $product->get_short_description() ?: __( 'Standard package', 'woodmart-child' ),
				'price_raw'  => $base_price_num,
				'price_html' => $formatted_p,
				'sku'        => $product->get_sku(),
				'in_stock'   => $is_in_stock,
				'is_combo'   => false,
				'image_url'  => $main_image_url,
				'attributes' => array(),
			),
		);
	}

	return array(
		'product'        => $product,
		'id'             => $product_id,
		'title'          => $product->get_name(),
		'sku'            => $product->get_sku() ?: '',
		'price_html'     => $product->get_price_html() ?: ( function_exists( 'wc_price' ) && $product->get_price() ? wc_price( $product->get_price() ) : '' ),
		'price'          => $product->get_price(),
		'short_desc'     => $product->get_short_description() ?: 'Bring ambitious ideas to life with speed, intelligence and material freedom.',
		'description'    => $product->get_description(),
		'is_in_stock'    => $is_in_stock,
		'stock_status'   => $stock_status,
		'stock_label'    => $stock_label,
		'primary_cat'    => $primary_cat,
		'main_image_url' => $main_image_url,
		'gallery_images' => $gallery_images,
		'is_variable'    => $is_variable,
		'variations'     => $variations,
	);
}

/**
 * Output an image tag or a styled fallback placeholder div matching the prototype.
 *
 * @param string $image_url        Image source URL.
 * @param string $alt              Alternative text.
 * @param string $extra_class      CSS classes.
 * @param string $placeholder_text Fallback placeholder text.
 */
function woodmart_child_render_image( $image_url, $alt = '', $extra_class = '', $placeholder_text = '' ) {
	if ( ! empty( $image_url ) ) {
		printf(
			'<img src="%s" alt="%s" class="%s" loading="lazy">',
			esc_url( $image_url ),
			esc_attr( $alt ),
			esc_attr( $extra_class )
		);
	} else {
		printf(
			'<div class="placeholder %s" role="img" aria-label="%s">[%s]</div>',
			esc_attr( $extra_class ),
			esc_attr( $alt ?: $placeholder_text ),
			esc_html( $placeholder_text ?: 'Product image' )
		);
	}
}
