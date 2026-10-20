<?php
/**
 * Woodmart Child Theme Helper Functions
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Check if the AMS product landing page is enabled for a given product.
 *
 * @param int|WC_Product|null $product_or_id Product ID or WC_Product object.
 * @return bool True if AMS landing page is enabled.
 */
function woodmart_child_is_ams_landing( $product_or_id = null ) {
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

	$enabled = get_post_meta( $product_id, '_woodmart_child_ams_landing_enabled', true );

	if ( '' === $enabled ) {
		$settings = get_post_meta( $product_id, '_woodmart_child_ams_builder', true );
		if ( is_array( $settings ) && isset( $settings['general']['enable_landing'] ) ) {
			$enabled = $settings['general']['enable_landing'];
		} else {
			$enabled = '0';
		}
	}

	return ( '1' === (string) $enabled || 'yes' === (string) $enabled || true === $enabled );
}

/**
 * Check if the Laser & Crafting product landing page is enabled for a given product.
 *
 * @param int|WC_Product|null $product_or_id Product ID or WC_Product object.
 * @return bool True if laser & crafting landing page is enabled.
 */
function woodmart_child_is_laser_crafting_landing( $product_or_id = null ) {
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

	// 0. If AMS landing is enabled, AMS takes highest precedence
	if ( function_exists( 'woodmart_child_is_ams_landing' ) && woodmart_child_is_ams_landing( $product_id ) ) {
		return false;
	}

	$enabled = get_post_meta( $product_id, '_woodmart_child_laser_crafting_landing_enabled', true );

	if ( '' === $enabled ) {
		$settings = get_post_meta( $product_id, '_woodmart_child_laser_crafting_builder', true );
		if ( is_array( $settings ) && isset( $settings['general']['enable_landing'] ) ) {
			$enabled = $settings['general']['enable_landing'];
		} else {
			$enabled = '0';
		}
	}

	return ( '1' === (string) $enabled || 'yes' === (string) $enabled || true === $enabled );
}

/**
 * Check if the Accessories product landing page is enabled for a given product.
 *
 * @param int|WC_Product|null $product_or_id Product ID or WC_Product object.
 * @return bool True if accessories landing page is enabled.
 */
function woodmart_child_is_accessories_landing( $product_or_id = null ) {
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

	// 0. If AMS landing is enabled, AMS takes highest precedence
	if ( function_exists( 'woodmart_child_is_ams_landing' ) && woodmart_child_is_ams_landing( $product_id ) ) {
		return false;
	}

	// 1. If laser crafting landing is enabled, laser crafting takes precedence
	if ( function_exists( 'woodmart_child_is_laser_crafting_landing' ) && woodmart_child_is_laser_crafting_landing( $product_id ) ) {
		return false;
	}

	$enabled = get_post_meta( $product_id, '_woodmart_child_accessories_landing_enabled', true );

	if ( '' === $enabled ) {
		$settings = get_post_meta( $product_id, '_woodmart_child_accessories_builder', true );
		if ( is_array( $settings ) && isset( $settings['general']['enable_landing'] ) ) {
			$enabled = $settings['general']['enable_landing'];
		} else {
			$enabled = '0';
		}
	}

	return ( '1' === (string) $enabled || 'yes' === (string) $enabled || true === $enabled );
}

/**
 * Check if the Filament product landing page is enabled for a given product.
 *
 * @param int|WC_Product|null $product_or_id Product ID or WC_Product object.
 * @return bool True if filament landing page is enabled.
 */
function woodmart_child_is_filament_landing( $product_or_id = null ) {
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

	// 0. If AMS landing is enabled, AMS takes highest precedence
	if ( function_exists( 'woodmart_child_is_ams_landing' ) && woodmart_child_is_ams_landing( $product_id ) ) {
		return false;
	}

	// 1. If laser crafting landing is enabled, laser crafting takes precedence
	if ( function_exists( 'woodmart_child_is_laser_crafting_landing' ) && woodmart_child_is_laser_crafting_landing( $product_id ) ) {
		return false;
	}

	// 2. If accessories landing is enabled, accessories takes precedence
	if ( function_exists( 'woodmart_child_is_accessories_landing' ) && woodmart_child_is_accessories_landing( $product_id ) ) {
		return false;
	}

	$enabled = get_post_meta( $product_id, '_woodmart_child_filament_landing_enabled', true );

	if ( '' === $enabled ) {
		$settings = get_post_meta( $product_id, '_woodmart_child_filament_builder', true );
		if ( is_array( $settings ) && isset( $settings['general']['enable_landing'] ) ) {
			$enabled = $settings['general']['enable_landing'];
		} else {
			$enabled = '0';
		}
	}

	return ( '1' === (string) $enabled || 'yes' === (string) $enabled || true === $enabled );
}

/**
 * Check if the 3D Printer product landing page is enabled for a given product.
 *
 * @param int|WC_Product|null $product_or_id Product ID or WC_Product object.
 * @return bool True if 3D printer landing page is enabled.
 */
function woodmart_child_is_printer_landing( $product_or_id = null ) {
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

	// 0. If AMS landing is enabled, AMS takes highest precedence
	if ( function_exists( 'woodmart_child_is_ams_landing' ) && woodmart_child_is_ams_landing( $product_id ) ) {
		return false;
	}

	// 1. If laser crafting landing is enabled, laser crafting takes precedence
	if ( function_exists( 'woodmart_child_is_laser_crafting_landing' ) && woodmart_child_is_laser_crafting_landing( $product_id ) ) {
		return false;
	}

	// 2. If accessories landing is enabled, accessories takes precedence
	if ( function_exists( 'woodmart_child_is_accessories_landing' ) && woodmart_child_is_accessories_landing( $product_id ) ) {
		return false;
	}

	$enabled = get_post_meta( $product_id, '_woodmart_child_custom_landing_enabled', true );

	// If not explicitly set yet, check builder array or fallback
	if ( '' === $enabled ) {
		$settings = get_post_meta( $product_id, '_woodmart_child_product_builder', true );
		if ( is_array( $settings ) && isset( $settings['general']['enable_landing'] ) ) {
			$enabled = $settings['general']['enable_landing'];
		} else {
			// If filament landing is explicitly enabled on this product, yield to filament
			if ( function_exists( 'woodmart_child_is_filament_landing' ) && woodmart_child_is_filament_landing( $product_id ) ) {
				return false;
			}
			$enabled = '1';
		}
	}

	// If filament landing is explicitly enabled, yield to filament unless printer is explicitly '1'
	if ( function_exists( 'woodmart_child_is_filament_landing' ) && woodmart_child_is_filament_landing( $product_id ) ) {
		if ( '1' !== (string) $enabled ) {
			return false;
		}
	}

	return ( '0' !== (string) $enabled && 'no' !== (string) $enabled && false !== $enabled );
}

/**
 * Check if any custom product landing page is enabled for a given product.
 *
 * @param int|WC_Product|null $product_or_id Product ID or WC_Product object.
 * @return bool True if custom landing page is enabled.
 */
function woodmart_child_is_custom_landing( $product_or_id = null ) {
	return woodmart_child_is_ams_landing( $product_or_id ) || woodmart_child_is_laser_crafting_landing( $product_or_id ) || woodmart_child_is_accessories_landing( $product_or_id ) || woodmart_child_is_printer_landing( $product_or_id ) || woodmart_child_is_filament_landing( $product_or_id );
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
			'reseller_strip'     => '<b>●</b> Authorized Bambu Lab Reseller · <span class="muted">Fast Baltic delivery · 2-Year Warranty.</span>',
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
				'price_note'  => 'incl. 24% VAT',
				'description' => 'For makers who mainly print one material or color at a time.',
				'bullets'     => "X1-Carbon printer\nEnclosed CoreXY platform\nTextured PEI plate\nLocal Baltic support",
				'btn_text'    => 'Choose Standalone',
			),
			'combo'       => array(
				'badge'       => 'OUR RECOMMENDED SETUP',
				'eyebrow'     => 'Multi material ready',
				'title'       => 'X1–Carbon Combo',
				'price_note'  => 'incl. 24% VAT',
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
 * Retrieve additional variation gallery images for a specific variation.
 *
 * Supports WoodMart native variation gallery, WooCommerce additional variation
 * images, and popular gallery plugins.
 *
 * @param int $variation_id Variation ID.
 * @param int $parent_product_id Optional parent product ID.
 * @return array Array of image items with id, url, thumb, alt.
 */
function woodmart_child_get_variation_gallery_images( $variation_id, $parent_product_id = 0, $var_data = array() ) {
	if ( ! $variation_id ) {
		return array();
	}

	$var_obj = wc_get_product( $variation_id );
	if ( ! $var_obj ) {
		return array();
	}

	$parent_id = $parent_product_id ?: $var_obj->get_parent_id();
	$images    = array();
	$img_ids   = array();

	// 1. Primary featured image of the variation (always first)
	$primary_id = $var_obj->get_image_id();
	if ( ! $primary_id && ! empty( $var_data['image_id'] ) ) {
		$primary_id = absint( $var_data['image_id'] );
	}
	if ( $primary_id ) {
		$img_ids[] = absint( $primary_id );
	}

	// 2. WooCommerce Core Native Variation Gallery CRUD method
	if ( method_exists( $var_obj, 'get_gallery_image_ids' ) ) {
		$core_gallery_ids = $var_obj->get_gallery_image_ids();
		if ( ! empty( $core_gallery_ids ) && is_array( $core_gallery_ids ) ) {
			foreach ( $core_gallery_ids as $cid ) {
				$cid = absint( $cid );
				if ( $cid && ! in_array( $cid, $img_ids, true ) ) {
					$img_ids[] = $cid;
				}
			}
		}
	}

	// 3. Post meta: WooCommerce Core stores variation gallery in '_product_image_gallery'
	$gallery_post_meta = get_post_meta( $variation_id, '_product_image_gallery', true );
	if ( ! empty( $gallery_post_meta ) ) {
		$parsed_meta = is_array( $gallery_post_meta ) ? $gallery_post_meta : explode( ',', (string) $gallery_post_meta );
		foreach ( $parsed_meta as $g_id ) {
			$g_id = absint( trim( (string) $g_id ) );
			if ( $g_id && ! in_array( $g_id, $img_ids, true ) ) {
				$img_ids[] = $g_id;
			}
		}
	}

	// 4. If passed from $product->get_available_variations()
	if ( ! empty( $var_data['gallery_image_ids'] ) && is_array( $var_data['gallery_image_ids'] ) ) {
		foreach ( $var_data['gallery_image_ids'] as $v_gid ) {
			$v_gid = absint( $v_gid );
			if ( $v_gid && ! in_array( $v_gid, $img_ids, true ) ) {
				$img_ids[] = $v_gid;
			}
		}
	}

	// 5. WoodMart variation gallery data stored on the parent product
	if ( $parent_id ) {
		$parent_gallery_data = get_post_meta( $parent_id, 'woodmart_variation_gallery_data', true );
		if ( ! empty( $parent_gallery_data ) ) {
			$parent_gallery_data = maybe_unserialize( $parent_gallery_data );
			if ( is_array( $parent_gallery_data ) && ! empty( $parent_gallery_data[ $variation_id ] ) ) {
				$raw_data = $parent_gallery_data[ $variation_id ];
				$parsed   = is_array( $raw_data ) ? $raw_data : explode( ',', (string) $raw_data );
				foreach ( $parsed as $pid ) {
					$pid = absint( trim( (string) $pid ) );
					if ( $pid && ! in_array( $pid, $img_ids, true ) ) {
						$img_ids[] = $pid;
					}
				}
			}
		}
	}

	// 6. Direct variation meta keys used by WoodMart and other variation gallery extensions
	$meta_keys = array(
		'wd_additional_variation_images_data',
		'woodmart_additional_variation_images_data',
		'_variation_image_gallery',
		'_wc_additional_variation_images',
		'woo_variation_gallery_images',
		'rtwpvs_images',
		'variation_image_gallery',
	);

	foreach ( $meta_keys as $m_key ) {
		$val = get_post_meta( $variation_id, $m_key, true );
		if ( ! empty( $val ) ) {
			$val = maybe_unserialize( $val );
			$ids = is_array( $val ) ? $val : explode( ',', (string) $val );
			foreach ( $ids as $raw_id ) {
				$raw_id = absint( trim( (string) $raw_id ) );
				if ( $raw_id && ! in_array( $raw_id, $img_ids, true ) ) {
					$img_ids[] = $raw_id;
				}
			}
		}
	}

	// 7. WoodMart helper function fallback if available
	if ( function_exists( 'woodmart_get_variation_gallery_data' ) ) {
		$wd_data = woodmart_get_variation_gallery_data( $variation_id );
		if ( is_array( $wd_data ) ) {
			foreach ( $wd_data as $wid ) {
				$wid = absint( $wid );
				if ( $wid && ! in_array( $wid, $img_ids, true ) ) {
					$img_ids[] = $wid;
				}
			}
		}
	}

	$var_title = $var_obj->get_name();

	foreach ( $img_ids as $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( ! $url ) {
			continue;
		}
		$thumb = wp_get_attachment_image_url( $id, 'thumbnail' ) ?: $url;
		$alt   = get_post_meta( $id, '_wp_attachment_image_alt', true ) ?: $var_title;

		$images[] = array(
			'id'    => $id,
			'url'   => $url,
			'thumb' => $thumb,
			'alt'   => $alt,
		);
	}

	// 8. If additional images exist as structured objects in variation data
	if ( ! empty( $var_data['variation_gallery_images'] ) && is_array( $var_data['variation_gallery_images'] ) ) {
		$existing_urls = array_column( $images, 'url' );
		foreach ( $var_data['variation_gallery_images'] as $v_img ) {
			if ( is_array( $v_img ) ) {
				$full_src = $v_img['full_src'] ?? ( $v_img['src'] ?? ( $v_img['url'] ?? '' ) );
				if ( $full_src && ! in_array( $full_src, $existing_urls, true ) ) {
					$images[] = array(
						'id'    => absint( $v_img['image_id'] ?? ( $v_img['id'] ?? 0 ) ),
						'url'   => $full_src,
						'thumb' => $v_img['gallery_thumbnail_src'] ?? ( $v_img['thumb'] ?? $full_src ),
						'alt'   => $v_img['alt'] ?? $var_title,
					);
					$existing_urls[] = $full_src;
				}
			}
		}
	}

	return $images;
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
	$stock_label  = $is_in_stock ? __( '● In Stock', 'woodmart-child' ) : __( '○ Out of stock', 'woodmart-child' );

	// Variations
	$is_variable = $product->is_type( 'variable' );
	$variations  = array();

	if ( $is_variable ) {
		$available_variations = $product->get_available_variations();

		foreach ( $available_variations as $idx => $var ) {
			$var_obj     = wc_get_product( $var['variation_id'] );
			$var_price   = $var['display_price'];
			$formatted_p = wc_price( $var_price );

			$is_printer = woodmart_child_is_printer_landing( $product_id );

			if ( $is_printer ) {
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
					$raw_var_name = $var_obj->get_name();
					if ( false !== strpos( $raw_var_name, ' - ' ) ) {
						$parts = explode( ' - ', $raw_var_name );
						$display_title = trim( end( $parts ) );
					} else {
						$display_title = $raw_var_name;
					}
				}
				$display_sub = $is_combo ? __( 'Add AMS for automatic multi color and multi material printing.', 'woodmart-child' ) : __( 'The printer, ready for focused single material work.', 'woodmart-child' );
			} else {
				$display_title = $var_obj ? $var_obj->get_name() : $product->get_name();
				if ( false !== strpos( $display_title, ' - ' ) ) {
					$parts = explode( ' - ', $display_title );
					$display_title = trim( end( $parts ) );
				}
				$display_sub = $var_obj ? $var_obj->get_description() : '';
				$is_combo = false;
			}

			$var_img_id = ! empty( $var['image_id'] ) ? absint( $var['image_id'] ) : ( $var_obj ? absint( $var_obj->get_image_id() ) : 0 );
			$var_img_url = $var_img_id ? wp_get_attachment_image_url( $var_img_id, 'full' ) : '';
			if ( empty( $var_img_url ) && ! empty( $var['image'] ) ) {
				$var_img_url = ! empty( $var['image']['full_src'] ) ? $var['image']['full_src'] : ( ! empty( $var['image']['src'] ) ? $var['image']['src'] : ( ! empty( $var['image']['url'] ) ? $var['image']['url'] : '' ) );
			}
			if ( empty( $var_img_url ) ) {
				$var_img_url = $main_image_url;
			}

			$var_gallery = woodmart_child_get_variation_gallery_images( $var['variation_id'], $product_id, $var );
			if ( ! empty( $var_gallery[0]['url'] ) ) {
				$var_img_url = $var_gallery[0]['url'];
			}
			$var_stock_status = $var_obj ? $var_obj->get_stock_status() : ( $var['is_in_stock'] ? 'instock' : 'outofstock' );
			$var_backorder = ( 'onbackorder' === $var_stock_status ) || ( $var_obj && $var_obj->is_on_backorder() );

			if ( $var_backorder ) {
				$var_stock_text = __( 'Available on Backorder', 'woodmart-child' );
			} elseif ( $var['is_in_stock'] && 'outofstock' !== $var_stock_status ) {
				$var_stock_text = __( 'In Stock', 'woodmart-child' );
			} else {
				$var_stock_text = __( 'Out of stock', 'woodmart-child' );
			}

			$variations[] = array(
				'id'           => $var['variation_id'],
				'title'        => $display_title,
				'subtitle'     => $display_sub,
				'price_raw'    => $var_price,
				'price_html'   => $formatted_p,
				'sku'          => $var['sku'] ?: $product->get_sku(),
				'in_stock'     => $var['is_in_stock'],
				'stock_status' => $var_stock_status,
				'stock_text'   => $var_stock_text,
				'is_combo'     => $is_combo,
				'image_url'    => $var_img_url,
				'gallery'      => $var_gallery,
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
				'id'           => $product_id,
				'title'        => $product->get_name(),
				'subtitle'     => $product->get_short_description() ?: __( 'Standard package', 'woodmart-child' ),
				'price_raw'    => $base_price_num,
				'price_html'   => $formatted_p,
				'sku'          => $product->get_sku(),
				'in_stock'     => $is_in_stock,
				'stock_status' => $stock_status,
				'stock_text'   => $is_in_stock ? __( 'In Stock', 'woodmart-child' ) : __( 'Out of stock', 'woodmart-child' ),
				'is_combo'     => false,
				'image_url'    => $main_image_url,
				'gallery'      => $gallery_images,
				'attributes'   => array(),
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

/**
 * Get default demo data for Filament Landing Page (Bambu Lab PLA Basic Filament).
 *
 * @return array
 */
function woodmart_child_get_default_filament_builder_data() {
	return array(
		'general'             => array(
			'enable_landing'    => '0',
			'badge_text'        => 'Authorized Bambu Lab Reseller',
			'title'             => 'Bambu Lab PLA Basic Filament',
			'subtitle'          => 'Reliable, easy-to-print PLA for prototypes, models and everyday parts.',
			'rating_text'       => 'Built for everyday making',
			'stock_text'        => 'In Stock',
			'stock_note'        => '',
			'price_display'     => '€24.90',
			'price_raw'         => '24.90',
			'vat_note'          => 'incl. 24% VAT',
			'ex_vat_text'       => 'Show ex. VAT',
			'selected_sku_note' => '',
			'team_quote_text'   => 'Buying for a team? Request a tailored quote →',
			'benefits'          => array(
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
			'colors'            => array(
				array( 'name' => 'BLACK #000000', 'hex' => '#000000' ),
				array( 'name' => 'WHITE #FFFFFF', 'hex' => '#ffffff' ),
				array( 'name' => 'BEIGE #F5EBE0', 'hex' => '#f5ebe0' ),
				array( 'name' => 'LEMON YELLOW #FEF08A', 'hex' => '#fef08a' ),
				array( 'name' => 'YELLOW #EAB308', 'hex' => '#eab308' ),
				array( 'name' => 'WARM YELLOW #F59E0B', 'hex' => '#f59e0b' ),
				array( 'name' => 'ORANGE #F97316', 'hex' => '#f97316' ),
				array( 'name' => 'BRIGHT ORANGE #EA580C', 'hex' => '#ea580c' ),
				array( 'name' => 'TAN #D4B996', 'hex' => '#d4b996' ),
				array( 'name' => 'BROWN #92400E', 'hex' => '#92400e' ),
				array( 'name' => 'BURGUNDY #831843', 'hex' => '#831843' ),
				array( 'name' => 'LIGHT PINK #FBCFE8', 'hex' => '#fbcfe8' ),
				array( 'name' => 'MINT GREEN #86EFAC', 'hex' => '#86efac' ),
				array( 'name' => 'BRIGHT GREEN #22C55E', 'hex' => '#22c55e' ),
				array( 'name' => 'FOREST GREEN #15803D', 'hex' => '#15803d' ),
				array( 'name' => 'CORAL #FB7185', 'hex' => '#fb7185' ),
				array( 'name' => 'ROSE PINK #F43F5E', 'hex' => '#f43f5e' ),
				array( 'name' => 'MAGENTA #EC4899', 'hex' => '#ec4899' ),
				array( 'name' => 'CRIMSON #B91C1C', 'hex' => '#b91c1c' ),
				array( 'name' => 'DARK RED #7F1D1D', 'hex' => '#7f1d1d' ),
				array( 'name' => 'LAVENDER #818CF8', 'hex' => '#818cf8' ),
				array( 'name' => 'PURPLE #6366F1', 'hex' => '#6366f1' ),
				array( 'name' => 'DARK VIOLET #3B0764', 'hex' => '#3b0764' ),
				array( 'name' => 'CYAN #06B6D4', 'hex' => '#06b6d4' ),
				array( 'name' => 'SKY BLUE #0284C7', 'hex' => '#0284c7' ),
				array( 'name' => 'ROYAL BLUE #2563EB', 'hex' => '#2563eb' ),
				array( 'name' => 'NAVY BLUE #1E3A8A', 'hex' => '#1e3a8a' ),
				array( 'name' => 'BRONZE #78350F', 'hex' => '#78350f' ),
				array( 'name' => 'OLIVE #4D7C0F', 'hex' => '#4d7c0f' ),
				array( 'name' => 'GRAY #6B7280', 'hex' => '#6b7280' ),
				array( 'name' => 'LIGHT GRAY #D1D5DB', 'hex' => '#d1d5db' ),
				array( 'name' => 'SLATE BLUE #475569', 'hex' => '#475569' ),
				array( 'name' => 'CHARCOAL #374151', 'hex' => '#374151' ),
			),
			'formats'           => array(
				array(
					'id'        => 'complete-spool',
					'name'      => 'Complete Spool',
					'desc'      => 'Ready-to-print 1 kg spool for everyday PLA work.',
					'price'     => '€24.90',
					'price_raw' => '24.90',
					'active'    => '1',
				),
				array(
					'id'        => 'refill',
					'name'      => 'Refill',
					'desc'      => '1 kg refill for a reusable spool. Lower packaging, same material.',
					'price'     => '€21.90',
					'price_raw' => '21.90',
					'active'    => '0',
				),
			),
		),
		'essential_additions' => array(
			'enabled'           => '1',
			'eyebrow'           => 'DISCOVER MORE HERE!',
			'title'             => 'Essential additions specifically tested with Bambu PLA Basic',
			'cards'             => array(
				array(
					'icon'      => 'spool',
					'title'     => 'Bambu Reusable Spool',
					'price'     => '€7.99',
					'old_price' => '€11.99',
					'desc'      => '',
					'badge'     => '',
					'options'   => array( 'Low Temp (≤70°C)', 'High Temp' ),
				),
				array(
					'icon'      => 'support',
					'title'     => 'Support for PLA/PETG',
					'price'     => '€27.99',
					'old_price' => '€34.99',
					'desc'      => 'Tool-free support removal for clean overhangs',
					'badge'     => 'With Spool',
					'options'   => array( 'Black (05103) / 0.5 kg', 'White (05100) / 0.5 kg' ),
				),
				array(
					'icon'      => 'plate',
					'title'     => 'Bambu Cool Plate SuperTack Series',
					'price'     => '€24.49',
					'old_price' => '€34.99',
					'desc'      => 'Strong adhesion at low bed temp, designed for PLA',
					'badge'     => '',
					'options'   => array( 'P1 Series / Cool Plate SuperTack', 'X1 Series / Cool Plate SuperTack', 'A1 Series / Cool Plate SuperTack' ),
				),
			),
			'shipping_bullet_1' => 'Free shipping over €50 across Estonia, Latvia and Lithuania',
			'shipping_bullet_2' => '1–2 day Baltic delivery from Tallinn. See our Shipping Policy',
			'payment_methods'   => array( 'Montonio', 'Bank Payments', 'Card Payments', 'Digital Wallets' ),
		),
		'nav'                 => array(
			'enabled'  => '1',
			'items'    => array(
				array( 'label' => 'OVERVIEW', 'target' => '#overview' ),
				array( 'label' => 'FIND COLORS', 'target' => '#find-colors' ),
				array( 'label' => 'PERFORMANCE', 'target' => '#materials' ),
				array( 'label' => 'RFID & AMS', 'target' => '#rfid-ams' ),
				array( 'label' => 'DOWNLOAD', 'target' => '#downloads' ),
				array( 'label' => 'PRINTING TIPS', 'target' => '#printing-tips' ),
			),
			'b2b_text' => 'b2b order →',
			'b2b_url'  => '#',
		),
		'formulation'         => array(
			'enabled'     => '1',
			'eyebrow'     => 'FLAGSHIP FILAMENT FORMULATION',
			'title'       => 'PLA Basic',
			'subtitle'    => 'Stand Out, Never Dull',
			'description' => 'Designed from the polymer-up for high-speed Bambu Lab ecosystems. Get reliable first-layer adhesion, vibrant consistency, and ultra-smooth surface finishes right out of the box.',
			'image'       => '',
			'credits'     => '• Cake Containers @s_branquinho • Cute figure of bear flying on balloon @Sam HellMyth • Brick Stackable Desk Boxes @Sakul • Articulated Orca @Jopek Design',
		),
		'colors_showcase'     => array(
			'enabled'     => '1',
			'eyebrow'     => 'ONE FILAMENT FAMILY. MANY USE CASES',
			'title'       => 'Find the Perfect Color',
			'description' => 'With a palette of up to 30 colors, Bambu PLA Basic lets you find the perfect shade to bring flair to your projects. The colors remain consistent across prints, ensuring a stunning and uniform finish every time',
		),
		'materials'           => array(
			'enabled'     => '1',
			'eyebrow'     => 'MATERIAL OVERVIEW',
			'title'       => 'Choose the right material',
			'description' => 'PLA Basic is the everyday choice. Explore other Bambu Lab material families for tougher or more specialised work',
			'items'       => array(
				array(
					'tag'         => 'PLA',
					'title'       => 'Fast concepts',
					'description' => 'Reliable everyday prints and presentation models.',
				),
				array(
					'tag'         => 'PETG',
					'title'       => 'Functional parts',
					'description' => 'Balanced durability for tools and fixtures',
				),
				array(
					'tag'         => 'ABS / ASA',
					'title'       => 'Working prototypes',
					'description' => 'Heat- and impact-resistant options',
				),
				array(
					'tag'         => 'CF MATERIALS',
					'title'       => 'Engineering intent',
					'description' => 'Reinforced composites for stiff parts',
				),
			),
		),
		'rfid_ams'            => array(
			'enabled'     => '1',
			'eyebrow'     => 'SMART MATERIAL DETECTION',
			'title'       => 'Built for RFID & AMS Compatibility',
			'description' => 'All printing parameters are embedded in RFID and read automatically through the Bambu Lab AMS. Load and print, with no tedious setup steps',
			'bullets'     => array(
				'Automatic material recognition',
				'Real-time remaining-filament tracking',
				'Seamless multi-color workflow with AMS',
				'Reduces print failures from wrong settings',
			),
			'link_text'   => 'See AMS-compatible printers →',
			'link_url'    => '#',
		),
		'use_cases'           => array(
			'enabled' => '1',
			'eyebrow' => 'WHERE IT EARNS ITS PLACE',
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
		'choose_format'       => array(
			'enabled'        => '1',
			'eyebrow'        => 'CHOOSE YOUR FORMAT',
			'title'          => 'Complete Spool or Refill?',
			'subtitle'       => "The filament is the same. What changes is what's included",
			'spool_badge'    => 'RECOMMENDED FOR FIRST PURCHASE',
			'spool_title'    => 'Complete Spool',
			'spool_price'    => '€24.90',
			'spool_vat'      => '€24.90 incl. 24% VAT',
			'spool_desc'     => "Ready-to-print 1 kg spool for everyday PLA work. Best choice if this is your first time buying Bambu filament or you don't yet own a reusable spool",
			'spool_bullets'  => array(
				'Includes reusable spool',
				'Ready to load and print immediately',
				"Best if you don't already own a spool",
			),
			'spool_btn_text' => 'Add Complete Spool →',
			'refill_badge'   => 'BEST IF YOU ALREADY OWN A SPOOL',
			'refill_title'   => 'Refill',
			'refill_price'   => '€21.90',
			'refill_vat'     => '€21.90 incl. 24% VAT',
			'refill_desc'    => 'Fits the Bambu Reusable Spool. See official assembly guide',
			'refill_bullets' => array(
				'No spool included',
				'Less packaging waste, more eco-friendly',
				'Requires an existing compatible spool',
			),
			'refill_btn_text' => 'Add Refill',
		),
		'brand_difference'    => array(
			'enabled'     => '1',
			'eyebrow'     => 'THE 3DKODA DIFFERENCE',
			'title'       => "Quality filament.\nA local team behind it.",
			'description' => 'Choosing the right filament is the first step. We help you pick the right material, dial in your print settings, and get support whenever you need it',
			'btn_text'    => 'Talk to a local expert →',
			'btn_url'     => '#',
			'items'       => array(
				array(
					'icon'        => 'location',
					'title'       => 'Tallinn-based stock',
					'description' => 'Faster dispatch and clear local availability.',
				),
				array(
					'icon'        => 'storage',
					'title'       => 'Storage guidance',
					'description' => 'Advice on keeping your filament dry and print-ready.',
				),
				array(
					'icon'        => 'support',
					'title'       => 'Practical print support',
					'description' => 'Help from people familiar with PLA settings and troubleshooting.',
				),
				array(
					'icon'        => 'business',
					'title'       => 'Business purchasing',
					'description' => 'VAT invoices, volume quotes and setup advice for teams.',
				),
			),
		),
		'specifications'      => array(
			'enabled'     => '1',
			'eyebrow'     => 'THE DETAILS BEHIND THE DECISION',
			'title'       => 'Technical specifications.',
			'description' => 'Key filament data for print planning. Final data verified against official Bambu documentation.',
			'note'        => 'Data based on official Bambu Lab product information',
			'items'       => array(
				array( 'label' => 'Material type', 'value' => 'PLA' ),
				array( 'label' => 'Nozzle temperature', 'value' => '190–230 °C' ),
				array( 'label' => 'Bed temperature', 'value' => '35–45 °C (with glue)' ),
				array( 'label' => 'Print speed', 'value' => '< 300 mm/s' ),
				array( 'label' => 'Drying', 'value' => '55 °C, 8 h' ),
				array( 'label' => 'Storage humidity', 'value' => '< 20% RH (sealed, with desiccant)' ),
				array( 'label' => 'Density', 'value' => '1.24 g/cm³' ),
				array( 'label' => 'Vicat softening temp', 'value' => '57 °C' ),
				array( 'label' => 'Heat deflection temp', 'value' => '57 °C' ),
				array( 'label' => 'Melting temperature', 'value' => '160 °C' ),
				array( 'label' => 'Melt index', 'value' => '42.4 ± 3.5 g/10 min' ),
				array( 'label' => 'Tensile strength', 'value' => '35 ± 4 MPa' ),
				array( 'label' => 'Breaking elongation', 'value' => '12.2 ± 1.8 %' ),
				array( 'label' => 'Bending modulus', 'value' => '2750 ± 160 MPa' ),
				array( 'label' => 'Bending strength', 'value' => '76 ± 5 MPa' ),
				array( 'label' => 'Impact strength', 'value' => '26.6 ± 2.8 kJ/m²' ),
				array( 'label' => 'RFID / AMS', 'value' => 'Yes' ),
			),
		),
		'recommended_settings' => array(
			'enabled'       => '1',
			'eyebrow'       => 'SETUP WITHOUT THE UNCERTAINTY',
			'title'         => 'Recommended print settings',
			'description'   => 'Getting clean results starts with the right profile. Use these starting settings, then fine-tune based on your printer and nozzle',
			'profile_text'  => 'Open official Bambu PLA print profile',
			'profile_url'   => '#',
			'spool_badge'   => 'RECOMMENDED FOR FIRST PURCHASE',
			'spool_title'   => 'Complete Spool',
			'spool_price'   => '€24.90',
			'spool_vat'     => '€24.90 incl. 24% VAT',
			'spool_btn'     => 'Add Complete Spool →',
			'items'         => array(
				array( 'label' => 'Material type', 'value' => 'PLA' ),
				array( 'label' => 'Nozzle temperature', 'value' => '190–230 °C' ),
				array( 'label' => 'Bed temperature', 'value' => '35–45 °C (with glue)' ),
				array( 'label' => 'Print speed', 'value' => '< 300 mm/s' ),
				array( 'label' => 'Drying', 'value' => '55 °C, 8 h' ),
				array( 'label' => 'Humidity', 'value' => '< 20% RH (sealed, with desiccant)' ),
			),
		),
		'downloads'           => array(
			'enabled'     => '1',
			'title'       => 'Downloads & technical documents',
			'description' => 'Official material datasheets, safety records, and regulatory compliance documents.',
			'items'       => array(
				array( 'title' => 'Filament TDS', 'subtitle' => 'Technical Specs', 'url' => '#' ),
				array( 'title' => 'Filament MSDS', 'subtitle' => 'Safety Sheet', 'url' => '#' ),
				array( 'title' => 'Filament RoHS', 'subtitle' => 'EU Standard', 'url' => '#' ),
				array( 'title' => 'Hex Code', 'subtitle' => 'Color Palette', 'url' => '#' ),
				array( 'title' => 'Filament POPs', 'subtitle' => 'Certification', 'url' => '#' ),
				array( 'title' => 'Filament CP65', 'subtitle' => 'Proposition 65', 'url' => '#' ),
				array( 'title' => 'Filament TSCA', 'subtitle' => 'Chemical Act', 'url' => '#' ),
				array( 'title' => 'Filament SVHC', 'subtitle' => 'REACH List', 'url' => '#' ),
				array( 'title' => 'Filament PAHs', 'subtitle' => 'Aromatic Test', 'url' => '#' ),
				array( 'title' => 'EN71-3', 'subtitle' => 'Toy Safety Standard', 'url' => '#' ),
			),
		),
		'printing_tips'       => array(
			'enabled'     => '1',
			'title'       => 'Printing Tips',
			'description' => 'PLA Basic is designed for Bambu Lab printers and works with all hotend sizes',
			'items'       => array(
				array(
					'title'   => '1. Accessory Compatibility',
					'content' => 'Recommended plates: Cool Plate, High Temperature Plate, Textured PEI Plate. Not recommended: Engineering Plate. Hotend: all sizes and materials. Glue: Bambu Liquid Glue or Glue Stick',
				),
				array(
					'title'   => '2. Drying Recommendations',
					'content' => 'Drying conditions: 55 °C for 8 hours in a filament dryer or heated print chamber. Store in an airtight container with desiccant (< 20% RH) to preserve printability and avoid brittleness.',
				),
				array(
					'title'   => '3. Refill Guidelines',
					'content' => 'Align the filament spool locator pin with the notch on the reusable spool, press together and twist clockwise until firmly latched. Cut the plastic straps only after locking the spool halves.',
				),
				array(
					'title'   => '4. Safety Tips',
					'content' => 'Maintain proper ventilation during long print sessions. Do not exceed 250 °C nozzle temperature to prevent thermal degradation and polymer fuming.',
				),
			),
		),
		'box_contents'        => array(
			'enabled'       => '1',
			'eyebrow'       => 'START WITH WHAT YOU NEED',
			'title'         => "What's in the box.",
			'spool_badge'   => 'RECOMMENDED',
			'spool_title'   => 'COMPLETE SPOOL',
			'spool_items'   => array(
				'1 × Bambu PLA Basic filament, 1 kg, 1.75 mm, wound on reusable spool',
				'1 × desiccant pack',
				'1 × packaging',
				'Note: RFID-enabled: print parameters are read automatically by AMS',
			),
			'refill_title'  => 'REFILL',
			'refill_items'  => array(
				'1 × Bambu PLA Basic filament refill, 1 kg, 1.75 mm (no spool)',
				'1 × desiccant pack',
				'1 × packaging',
				'Note: Requires a Bambu Reusable Spool (sold separately)',
			),
			'note'          => 'Contents may vary slightly by region or batch. Confirm against the selected SKU',
		),
		'faq'                 => array(
			'enabled'     => '1',
			'eyebrow'     => 'BEFORE YOU DECIDE',
			'title'       => 'Questions, answered.',
			'description' => 'Still deciding? Our team can help you choose the right material for your printer and application',
			'ask_text'    => 'Ask 3DKoda →',
			'ask_url'     => '#',
			'items'       => array(
				array(
					'question' => "What's the difference between Complete Spool and Refill?",
					'answer'   => 'Complete Spool includes the filament wound on a reusable Bambu spool and is ready to print. Refill contains the filament only, to be loaded onto a Bambu Reusable Spool you already own',
				),
				array(
					'question' => 'Which printers is this filament compatible with?',
					'answer'   => 'Compatible with all Bambu Lab 3D printers including X1-Carbon, X1E, P1S, P1P, and A1 / A1 mini series. Also works with third-party printers using 1.75 mm filament.',
				),
				array(
					'question' => 'Does this filament support RFID/AMS auto-detection?',
					'answer'   => 'Yes! Every spool and refill comes with dual RFID tags that the Bambu Lab AMS automatically reads to set material type, color, and starting printing parameters.',
				),
				array(
					'question' => 'What print settings should I use?',
					'answer'   => 'Use the default official Bambu PLA Basic print profile in Bambu Studio. Standard nozzle temperature is 190–230 °C, and bed temperature is 35–45 °C with glue.',
				),
				array(
					'question' => 'How should I store this filament?',
					'answer'   => 'Keep filament sealed in an airtight bag or container with desiccant (< 20% RH). If exposed to humidity, dry at 55 °C for 8 hours before printing.',
				),
				array(
					'question' => 'Can my company buy without Estonian VAT?',
					'answer'   => 'Yes, EU businesses with a valid VIES VAT number outside Estonia can purchase with 0% reverse charge VAT. Tallinn-based local companies receive standard VAT invoices.',
				),
			),
			'cta'         => array(
				'enabled'        => '1',
				'badge'          => 'BALTIC LOGISTICS & BULK TIERS',
				'title'          => 'Ready to bring your next print to life?',
				'description'    => 'Choose your Bambu PLA setup today or connect with a Baltic 3D printing specialist in Tallinn for test prints and volume pricing.',
				'btn_shop_text'  => 'Shop PLA Basic Now',
				'btn_shop_url'   => '#choose-format',
				'btn_quote_text' => 'Request Business Quote',
				'btn_quote_url'  => '#',
			),
		),
	);
}

/**
 * Get all Filament builder settings for a product, merged with defaults.
 *
 * @param int $product_id Product ID.
 * @return array
 */
function woodmart_child_get_filament_builder_settings( $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$defaults = woodmart_child_get_default_filament_builder_data();
	$saved    = get_post_meta( $product_id, '_woodmart_child_filament_builder', true );

	if ( ! is_array( $saved ) || empty( $saved ) ) {
		return $defaults;
	}

	return woodmart_child_merge_builder_settings( $defaults, $saved );
}

/**
 * Check if a specific Filament builder section is enabled.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return bool
 */
function woodmart_child_is_filament_section_enabled( $section_key, $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$settings = woodmart_child_get_filament_builder_settings( $product_id );

	if ( ! isset( $settings[ $section_key ] ) ) {
		return false;
	}

	$section = $settings[ $section_key ];

	if ( ! isset( $section['enabled'] ) || ! in_array( (string) $section['enabled'], array( '1', 'yes', 'true' ), true ) ) {
		return false;
	}

	return true;
}

/**
 * Get section data for a given Filament product.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return array
 */
function woodmart_child_get_filament_section_data( $section_key, $product_id = 0 ) {
	$settings = woodmart_child_get_filament_builder_settings( $product_id );
	return isset( $settings[ $section_key ] ) ? $settings[ $section_key ] : array();
}

/**
 * Retrieve the swatch color hex code for a product attribute term.
 *
 * @param WP_Term|int|string $term Term object, term ID, or term name/slug.
 * @param string             $taxonomy Taxonomy slug.
 * @return string Hex color string (e.g. '#2563eb').
 */
function woodmart_child_get_term_color( $term, $taxonomy = 'pa_color' ) {
	$term_obj = null;

	if ( is_numeric( $term ) ) {
		$term_obj = get_term( absint( $term ), $taxonomy );
	} elseif ( is_string( $term ) ) {
		$term_obj = get_term_by( 'slug', $term, $taxonomy ) ?: get_term_by( 'name', $term, $taxonomy );
	} elseif ( $term instanceof WP_Term ) {
		$term_obj = $term;
	}

	if ( $term_obj && ! is_wp_error( $term_obj ) ) {
		$term_id = $term_obj->term_id;

		// 1. Woodmart native term meta key is 'color'
		$meta_keys = array( 'color', '_woodmart_color', 'swatch_color', 'pa_color_color', 'product_attribute_color', 'st_color' );
		foreach ( $meta_keys as $mk ) {
			$val = get_term_meta( $term_id, $mk, true );
			if ( ! empty( $val ) && is_string( $val ) ) {
				$val = trim( $val );
				if ( '#' === substr( $val, 0, 1 ) && ( 4 === strlen( $val ) || 7 === strlen( $val ) || 9 === strlen( $val ) ) ) {
					return $val;
				}
				if ( preg_match( '/^[a-fA-F0-9]{3,6}$/', $val ) ) {
					return '#' . $val;
				}
			}
		}

		$search_name = strtolower( trim( $term_obj->name ) );
		$search_slug = strtolower( trim( $term_obj->slug ) );
	} else {
		$search_name = is_string( $term ) ? strtolower( trim( $term ) ) : '';
		$search_slug = $search_name;
	}

	// 2. Check if name or slug contains a hex color code (e.g. "Charcoal #374151")
	if ( preg_match( '/#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b/', $search_name, $m ) ) {
		return '#' . $m[1];
	}
	if ( preg_match( '/(?:^|-)([a-fA-F0-9]{6})$/', $search_slug, $m ) ) {
		return '#' . $m[1];
	}

	// 3. Palette of standard Bambu / 3D printing & web colors
	$palette = array(
		'blue'        => '#0051ff',
		'dark-blue'   => '#1e3a8a',
		'light-blue'  => '#38bdf8',
		'sky-blue'    => '#0ea5e9',
		'green'       => '#008736',
		'dark-green'  => '#14532d',
		'bambu-green' => '#00ae42',
		'light-green' => '#4ade80',
		'lime'        => '#84cc16',
		'red'         => '#e11d48',
		'dark-red'    => '#991b1b',
		'crimson'     => '#be123c',
		'black'       => '#111827',
		'white'       => '#f9fafb',
		'charcoal'    => '#374151',
		'gray'        => '#6b7280',
		'grey'        => '#6b7280',
		'light-gray'  => '#d1d5db',
		'dark-gray'   => '#374151',
		'silver'      => '#94a3b8',
		'orange'      => '#ea580c',
		'yellow'      => '#eab308',
		'gold'        => '#d97706',
		'purple'      => '#7e22ce',
		'violet'      => '#8b5cf6',
		'pink'        => '#ec4899',
		'magenta'     => '#d946ef',
		'cyan'        => '#06b6d4',
		'teal'        => '#0d9488',
		'brown'       => '#78350f',
		'beige'       => '#f5f5dc',
	);

	if ( isset( $palette[ $search_slug ] ) ) {
		return $palette[ $search_slug ];
	}
	if ( isset( $palette[ $search_name ] ) ) {
		return $palette[ $search_name ];
	}

	foreach ( $palette as $k => $hex ) {
		if ( false !== strpos( $search_slug, $k ) || false !== strpos( $search_name, $k ) ) {
			return $hex;
		}
	}

	return '#111827';
}

/**
 * Get default demo data for Accessories Landing Page (Bambu Lab Hotends & Spare Parts).
 *
 * @return array
 */
function woodmart_child_get_default_accessories_builder_data() {
	return array(
		'general'              => array(
			'enable_landing'       => '0',
			'badge_text'           => '● Authorized Bambu Lab Reseller',
			'eyebrow'              => 'GENUINE ACCESSORIES & SPARE PARTS',
			'brand_name'           => 'Bambu Lab',
			'title'                => 'Bambu Hotend with Nozzle',
			'subtitle'             => 'High-precision extrusion assembly engineered for Bambu Lab X1 and P1 series. Durable hardened steel construction for composite filaments.',
			'rating_text'          => '4.9 / 5 (128 reviews) · Trusted Baltic Stock',
			'stock_text'           => 'In Stock',
			'stock_note'           => '',
			'price_display'        => '€35.00',
			'price_raw'            => '35.00',
			'vat_note'             => 'incl. 24% VAT',
			'ex_vat_text'          => 'Show ex. VAT',
			'warranty_note'        => 'Local 3DKoda warranty guidance',
			'team_quote_text'      => 'Buying spare parts in bulk for your print farm? Request business volume pricing →',
			'compatibility_badges' => array(
				array(
					'icon'     => 'shield',
					'title'    => 'Original Part',
					'subtitle' => 'Bambu Lab Certified',
				),
				array(
					'icon'     => 'temp',
					'title'    => 'Up to 300°C',
					'subtitle' => 'High-Temp Ready',
				),
				array(
					'icon'     => 'diamond',
					'title'    => 'Wear Resistant',
					'subtitle' => 'Hardened Steel',
				),
				array(
					'icon'     => 'zap',
					'title'    => 'Quick Swap',
					'subtitle' => 'Modular Assembly',
				),
			),
			'benefits'             => array(
				array(
					'title'    => 'Fast Baltic delivery',
					'subtitle' => 'Dispatched from Tallinn warehouse',
				),
				array(
					'title'    => 'Genuine components',
					'subtitle' => 'Direct authorized Bambu sourcing',
				),
				array(
					'title'    => 'Hardware support',
					'subtitle' => 'Expert advice from our local team',
				),
			),
		),
		'overview'             => array(
			'enabled'           => '1',
			'eyebrow'           => 'QUICK-SWAP DESIGN · ALL-METAL ARCHITECTURE',
			'title'             => 'Engineered for Demanding Continuous Printing',
			'description'       => 'The Bambu Lab Hotend incorporates an integrated nozzle and thermal break assembly. Machined from high-temperature copper alloy with hardened steel or stainless steel tips to eliminate leak points and ensure consistent filament melt flow.',
			'image'             => '',
			'showcase_eyebrow'  => 'PRINT RESOLUTION COMPARISON',
			'showcase_title'    => '0.2 mm vs 0.4 mm Micro-Detail Analysis',
			'showcase_desc'     => 'Choosing the right orifice diameter transforms your model finish and mechanical output.',
			'card_02'           => array(
				'tag'         => '0.2 mm Nozzle',
				'title'       => 'Ultra-Fine Precision',
				'description' => 'Sub-millimeter detail reproduction with razor-sharp micro text, intricate miniatures, and almost invisible layer lines.',
				'badge'       => 'Best for Miniatures & Text',
			),
			'card_04'           => array(
				'tag'         => '0.4 mm Nozzle',
				'title'       => 'Balanced Production Speed',
				'description' => 'The factory standard for everyday general 3D printing. Delivers great surface fidelity, high structural bonding, and standard high-speed print profiles.',
				'badge'       => 'Standard Factory Setup',
			),
		),
		'visual_showcase'      => array(
			'enabled'           => '1',
			'eyebrow'           => 'SURFACE FINISH & SPEED COMPARISON',
			'title'             => 'Visual Print Quality Across Nozzle Sizes & Layer Heights',
			'description'       => 'Understand the trade-offs between resolution, flow rate, and mechanical layer adhesion when choosing your nozzle setup.',
			'vase_cards'        => array(
				array(
					'layer'     => '0.10 mm',
					'name'      => 'Fine Resolution',
					'desc'      => 'Imperceptible layer lines for presentation models, artistic sculptures and visual displays.',
					'badge'     => 'High Detail',
				),
				array(
					'layer'     => '0.20 mm',
					'name'      => 'Standard Resolution',
					'desc'      => 'Optimal balance between smooth aesthetics and print turnaround time for everyday parts.',
					'badge'     => 'Balanced',
				),
				array(
					'layer'     => '0.28 mm',
					'name'      => 'Draft Resolution',
					'desc'      => 'Maximum throughput for rapid functional testing, structural brackets and large shells.',
					'badge'     => 'High Speed',
				),
			),
			'nozzle_columns'    => array(
				array(
					'size'        => '0.2 mm',
					'title'       => 'Ultra-Fine Details',
					'layer_range' => '0.06 – 0.14 mm',
					'flow'        => '8–12 mm³/s',
					'abrasive'    => 'Not recommended (clog risk)',
					'benchy_desc' => 'Silky smooth hull, micro lettering visible',
					'best_for'    => 'Miniatures, jewelry, keycaps, text badges',
				),
				array(
					'size'        => '0.4 mm',
					'title'       => 'Standard Versatile',
					'layer_range' => '0.12 – 0.28 mm',
					'flow'        => '16–22 mm³/s',
					'abrasive'    => 'Recommended (Hardened Steel)',
					'benchy_desc' => 'Clean balanced hull, crisp overhangs',
					'best_for'    => 'Everyday prototyping, mechanical components',
				),
				array(
					'size'        => '0.6 mm',
					'title'       => 'Fast & Carbon Fiber',
					'layer_range' => '0.18 – 0.40 mm',
					'flow'        => '24–28 mm³/s',
					'abrasive'    => 'Highly recommended (anti-clog)',
					'benchy_desc' => 'Subtle layer lines, robust wall strength',
					'best_for'    => 'Carbon-fiber composites (CF/GF), rugged jigs',
				),
				array(
					'size'        => '0.8 mm',
					'title'       => 'Maximum Flow Rate',
					'layer_range' => '0.24 – 0.56 mm',
					'flow'        => '30–35 mm³/s',
					'abrasive'    => 'Excellent for fiber composites',
					'benchy_desc' => 'Industrial rugged layers, ultra-fast prints',
					'best_for'    => 'Large functional fixtures, rapid bulk prints',
				),
			),
			'progression'       => array(
				'title' => 'Flow Rate vs Mechanical Layer Strength Progression',
				'note'  => 'Comparison benchmarked using Bambu Lab PLA Basic and PAHT-CF on Bambu Lab X1-Carbon at 220°C–280°C.',
				'bars'  => array(
					array(
						'size'         => '0.2 mm',
						'flow'         => '10 mm³/s',
						'strength_pct' => '45%',
						'label'        => 'Max Detail',
					),
					array(
						'size'         => '0.4 mm',
						'flow'         => '20 mm³/s',
						'strength_pct' => '75%',
						'label'        => 'Standard Flow',
					),
					array(
						'size'         => '0.6 mm',
						'flow'         => '26 mm³/s',
						'strength_pct' => '90%',
						'label'        => '+40% Flow Speed',
					),
					array(
						'size'         => '0.8 mm',
						'flow'         => '32 mm³/s',
						'strength_pct' => '100%',
						'label'        => 'Max Flow & Strength',
					),
				),
			),
		),
		'compatibility_matrix' => array(
			'enabled'     => '1',
			'eyebrow'     => 'FILAMENT & HARDWARE COMPATIBILITY',
			'title'       => 'Filament & Hardware Compatibility Guide',
			'description' => 'Verify which materials can be printed safely through each nozzle size and alloy.',
			'note'        => 'Filaments containing carbon fiber, glass fiber, metal particles, or glow-in-the-dark powders require Hardened Steel nozzles (0.4mm or larger) to prevent rapid orifice erosion and blockages.',
			'rows'        => array(
				array(
					'category'  => 'Standard Filaments',
					'filament'  => 'PLA / PLA Basic / PLA Matte',
					'nozzle_02' => 'yes',
					'nozzle_04' => 'yes',
					'nozzle_06' => 'yes',
					'nozzle_08' => 'yes',
					'notes'     => 'Universal compatibility across all nozzle sizes',
				),
				array(
					'category'  => 'Standard Filaments',
					'filament'  => 'PETG / PETG Basic',
					'nozzle_02' => 'yes',
					'nozzle_04' => 'yes',
					'nozzle_06' => 'yes',
					'nozzle_08' => 'yes',
					'notes'     => 'High layer bonding, versatile functional use',
				),
				array(
					'category'  => 'Standard Filaments',
					'filament'  => 'ABS / ASA',
					'nozzle_02' => 'yes',
					'nozzle_04' => 'yes',
					'nozzle_06' => 'yes',
					'nozzle_08' => 'yes',
					'notes'     => 'Requires enclosed chamber (X1 / P1S)',
				),
				array(
					'category'  => 'Flexible Filaments',
					'filament'  => 'TPU 95A / TPU 90A',
					'nozzle_02' => 'no',
					'nozzle_04' => 'yes',
					'nozzle_06' => 'yes',
					'nozzle_08' => 'yes',
					'notes'     => '0.2mm prone to backpressure and clogs',
				),
				array(
					'category'  => 'Engineering Filaments',
					'filament'  => 'PC (Polycarbonate)',
					'nozzle_02' => 'no',
					'nozzle_04' => 'hardened',
					'nozzle_06' => 'hardened',
					'nozzle_08' => 'hardened',
					'notes'     => 'High temp required (260°C–280°C)',
				),
				array(
					'category'  => 'Abrasive Composites',
					'filament'  => 'PLA-CF / PETG-CF',
					'nozzle_02' => 'no',
					'nozzle_04' => 'hardened',
					'nozzle_06' => 'hardened',
					'nozzle_08' => 'hardened',
					'notes'     => 'Carbon fiber will abrade stainless steel',
				),
				array(
					'category'  => 'Abrasive Composites',
					'filament'  => 'PA-CF / PAHT-CF',
					'nozzle_02' => 'no',
					'nozzle_04' => 'hardened',
					'nozzle_06' => 'hardened',
					'nozzle_08' => 'hardened',
					'notes'     => 'Structural engineering grade; Hardened only',
				),
				array(
					'category'  => 'Abrasive Composites',
					'filament'  => 'PET-CF / PPS-CF',
					'nozzle_02' => 'no',
					'nozzle_04' => 'hardened',
					'nozzle_06' => 'hardened',
					'nozzle_08' => 'hardened',
					'notes'     => 'High wear resistance; 0.6mm+ recommended',
				),
				array(
					'category'  => 'Support Materials',
					'filament'  => 'Support for PLA / PA',
					'nozzle_02' => 'no',
					'nozzle_04' => 'yes',
					'nozzle_06' => 'yes',
					'nozzle_08' => 'yes',
					'notes'     => 'Dual extrusion interface material',
				),
				array(
					'category'  => 'Support Materials',
					'filament'  => 'PVA (Water Soluble)',
					'nozzle_02' => 'no',
					'nozzle_04' => 'yes',
					'nozzle_06' => 'yes',
					'nozzle_08' => 'yes',
					'notes'     => 'Dissolvable support; keep strictly dry',
				),
			),
		),
		'specifications'       => array(
			'enabled'     => '1',
			'eyebrow'     => 'ENGINEERING DETAILS',
			'title'       => 'Technical Specifications',
			'description' => 'Accurate dimensions, material hardness, and operating temperatures for Bambu Lab X1 and P1 hotends.',
			'note'        => 'Specifications verified against official Bambu Lab hardware documentation.',
			'items'       => array(
				array(
					'label' => 'Nozzle Orifice Diameter',
					'value' => '0.2 mm / 0.4 mm / 0.6 mm / 0.8 mm',
				),
				array(
					'label' => 'Nozzle Tip Material',
					'value' => 'Hardened Tool Steel (55–60 HRC) / Stainless Steel',
				),
				array(
					'label' => 'Thermal Block Material',
					'value' => 'Chrome-Zirconium Copper with Nickel Plating',
				),
				array(
					'label' => 'Max Extrusion Temperature',
					'value' => '300 °C (572 °F)',
				),
				array(
					'label' => 'Filament Diameter',
					'value' => '1.75 mm',
				),
				array(
					'label' => 'Heater Power Rating',
					'value' => '48W Ceramic Heating Element',
				),
				array(
					'label' => 'Temperature Sensor',
					'value' => 'NTC 100K 3950 Precision Thermistor',
				),
				array(
					'label' => 'Cooling Fan',
					'value' => '3010 Brushless Axial Fan (included with Complete Assembly)',
				),
				array(
					'label' => 'Printer Compatibility',
					'value' => 'Bambu Lab X1-Carbon, X1E, P1S, P1P, A1 Series',
				),
				array(
					'label' => 'Thermal Interface',
					'value' => 'Bambu Thermal Grease (1.2 W/m·K included)',
				),
			),
		),
		'box_contents'         => array(
			'enabled'        => '1',
			'eyebrow'        => 'PACKAGE CONTENTS',
			'title'          => "What's in the box.",
			'note'           => 'Package contents correspond to the selected SKU variation.',
			'assembly_title' => 'Complete Hotend Assembly',
			'assembly_badge' => 'PLUG & PLAY · 2-MINUTE SWAP',
			'assembly_items' => array(
				'1 × Bambu Lab Hardened Steel Hotend (Selected Size)',
				'1 × Silicone Heat-Insulating Sock',
				'1 × 48W Ceramic Heating Element (Pre-installed)',
				'1 × NTC 100K Thermistor Sensor (Pre-installed)',
				'1 × 3010 Hotend Cooling Fan with pre-crimped JST connector',
				'2 × M3×14 Socket Head Retaining Screws',
				'1 × Thermal Grease Packet (1.2 W/m·K)',
			),
			'nozzle_title'   => 'Hotend with Nozzle (Core Unit)',
			'nozzle_badge'   => 'COMPONENT UPGRADE',
			'nozzle_items'   => array(
				'1 × Bambu Lab Hotend with Integrated Nozzle',
				'1 × Silicone Heat-Insulating Sock',
				'2 × M3×14 Retaining Screws',
				'1 × Thermal Grease Packet',
			),
		),
		'faq'                  => array(
			'enabled'     => '1',
			'eyebrow'     => 'BEFORE YOU DECIDE',
			'title'       => 'Questions, answered.',
			'description' => 'Still deciding on nozzle size or material alloy? Our Baltic team is here to help.',
			'ask_text'    => 'Ask 3DKoda Hardware Specialist →',
			'ask_url'     => '#',
			'items'       => array(
				array(
					'question' => 'How do I know whether to choose Hardened Steel or Stainless Steel?',
					'answer'   => 'Choose Stainless Steel if you only print standard filaments like PLA, PETG, TPU, and ABS. Choose Hardened Steel (55–60 HRC) if you plan to print any composite or filled filaments (Carbon Fiber PLA-CF/PAHT-CF, Glass Fiber, Wood, or Glow-in-the-dark), as abrasive fibers will wear out a stainless steel nozzle within a few hours.',
				),
				array(
					'question' => 'What is the difference between Complete Hotend Assembly and Hotend with Nozzle?',
					'answer'   => 'The Complete Hotend Assembly comes fully wired with the ceramic heating element, thermistor sensor, and cooling fan pre-mounted. It allows a seamless 2-minute quick swap. The "Hotend with Nozzle" is the metal assembly only; you will need to unscrew and transfer the ceramic heater, thermistor, and fan from your previous hotend.',
				),
				array(
					'question' => 'When should I choose a 0.2mm or 0.6mm nozzle instead of the standard 0.4mm?',
					'answer'   => 'The 0.2mm nozzle is designed for high-resolution miniatures, fine typography, and jewelry models where visible layers must be minimized. The 0.6mm and 0.8mm nozzles offer significantly higher volumetric flow rates, enabling 30% to 50% faster print times, stronger layer-to-layer adhesion, and virtually zero clog risk when printing carbon-fiber filaments.',
				),
				array(
					'question' => 'Is thermal paste necessary when replacing the hotend?',
					'answer'   => 'Yes, always apply a thin layer of the included thermal grease between the metal thermal block and the ceramic heating cartridge. This ensures stable temperature conduction and accurate PID readings.',
				),
				array(
					'question' => 'How fast is dispatch and Baltic delivery for spare parts?',
					'answer'   => 'All in-stock parts are dispatched from our Tallinn warehouse within 24 hours. Delivery across Estonia, Latvia, and Lithuania takes 1–2 business days via Omniva, DPD, or Smartpost.',
				),
			),
			'cta'         => array(
				'enabled'        => '1',
				'badge'          => 'BALTIC HARDWARE INVENTORY',
				'title'          => 'Keep your 3D printers running at peak uptime.',
				'description'    => 'Stock up on genuine Bambu Lab hotends, extruders, build plates, and wear parts with local Baltic delivery.',
				'btn_shop_text'  => 'Choose Hotend Setup',
				'btn_shop_url'   => '#accessories-hero',
				'btn_quote_text' => 'Request Print Farm Bulk Quote',
				'btn_quote_url'  => '#',
			),
		),
	);
}

/**
 * Get all Accessories builder settings for a product, merged with defaults.
 *
 * @param int $product_id Product ID.
 * @return array
 */
function woodmart_child_get_accessories_builder_settings( $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$defaults = woodmart_child_get_default_accessories_builder_data();
	$saved    = get_post_meta( $product_id, '_woodmart_child_accessories_builder', true );

	if ( ! is_array( $saved ) || empty( $saved ) ) {
		return $defaults;
	}

	return woodmart_child_merge_builder_settings( $defaults, $saved );
}

/**
 * Check if a specific Accessories builder section is enabled.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return bool
 */
function woodmart_child_is_accessories_section_enabled( $section_key, $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$settings = woodmart_child_get_accessories_builder_settings( $product_id );

	if ( ! isset( $settings[ $section_key ] ) ) {
		return false;
	}

	$section = $settings[ $section_key ];

	if ( ! isset( $section['enabled'] ) || ! in_array( (string) $section['enabled'], array( '1', 'yes', 'true' ), true ) ) {
		return false;
	}

	return true;
}

/**
 * Get section data for a given Accessories product.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return array
 */
function woodmart_child_get_accessories_section_data( $section_key, $product_id = 0 ) {
	$settings = woodmart_child_get_accessories_builder_settings( $product_id );
	return isset( $settings[ $section_key ] ) ? $settings[ $section_key ] : array();
}

/**
 * Get default demo data for Laser & Crafting Builder (Bambu Lab A2L multi-tool & crafting).
 *
 * @return array
 */
function woodmart_child_get_default_laser_crafting_builder_data() {
	return array(
		'general'          => array(
			'enable_landing'   => '0',
			'eyebrow'          => 'CREATIVE PLAYGROUND · EXTRA LARGE',
			'brand_name'       => 'Bambu Lab',
			'badge_text'       => '● Authorized Bambu Lab Reseller',
			'rating_text'      => '4.9 / 5 (94 reviews) · Trusted Baltic Stock',
			'stock_text'       => 'In Stock',
			'stock_note'       => 'Dispatched within 24h · Free Baltic Shipping',
			'vat_note'         => 'incl. 24% VAT',
			'ex_vat_text'      => 'Show ex. VAT',
			'warranty_text'    => '2-Year Local Warranty',
			'team_quote_text'  => 'Need crafting workstations for your studio or lab? Request volume business quote →',
			'guarantees'       => array(
				array(
					'icon'     => 'truck',
					'title'    => 'Free Baltic Shipping',
					'subtitle' => 'Dispatched from Tallinn',
				),
				array(
					'icon'     => 'shield',
					'title'    => '30-Day Price Protection',
					'subtitle' => 'Guaranteed official pricing',
				),
				array(
					'icon'     => 'refresh',
					'title'    => '30-Day Returns',
					'subtitle' => 'Hassle-free return policy',
				),
				array(
					'icon'     => 'award',
					'title'    => '2-Year Warranty',
					'subtitle' => 'Local diagnostics & parts',
				),
			),
			'packages'         => array(
				'standalone' => array(
					'title'       => 'A2L',
					'price'       => '€469.00',
					'price_raw'   => 469.00,
					'badge'       => '',
					'description' => 'Complete large-format 330×320×325 mm 3D printer for expansive creations.',
					'bullets'     => "A2L 3D Printer\nTextured PEI Build Plate\nStainless Steel Toolhead\nBasic Tool & Maintenance Box",
				),
				'combo'      => array(
					'title'       => 'A2L Combo',
					'price'       => '€569.00',
					'price_raw'   => 569.00,
					'badge'       => 'MOST POPULAR',
					'description' => 'Adds AMS lite for seamless 4-color automatic multi-material and support printing.',
					'bullets'     => "Everything in A2L\nAutomatic Material System (AMS lite)\n4-Spool automatic filament feeding\nRFID spool detection",
				),
				'full_combo' => array(
					'title'       => 'A2L Cutting Full Combo',
					'price'       => '€629.00',
					'price_raw'   => 629.00,
					'badge'       => 'FULL ECOSYSTEM',
					'description' => 'Includes 3D printer + AMS lite + modular blade cutting & pen plotting crafting toolhead.',
					'bullets'     => "Everything in A2L Combo\nBlade Cutting Module (up to 500g force)\nPen Plotting Drawing Clamp & Pens\nCrafting Cutting Mat & Decal Starter Pack",
				),
			),
			'bundle_addons'    => array(
				array(
					'id'             => 'print-finishing-kit',
					'title'          => 'Print Finishing Kit',
					'badge'          => '15% off',
					'price'          => '€45.00',
					'regular_price'  => '€52.95',
					'description'    => 'The Complete Kit for Print Removal, De-support & Surface Cleanup.',
					'image'          => '',
				),
				array(
					'id'             => 'timelapse-kit',
					'title'          => 'CyberBrick Time-lapse Kit',
					'badge'          => '35% off',
					'price'          => '€13.60',
					'regular_price'  => '€20.90',
					'description'    => 'Specially designed for 3D printers to capture high-framerate time-lapse videos.',
					'image'          => '',
				),
				array(
					'id'             => 'hardware-kit',
					'title'          => 'CyberBrick Hardware Kit',
					'badge'          => '25% off',
					'price'          => '€59.90',
					'regular_price'  => '€79.99',
					'description'    => 'Ultimate Robotics & Hardware Kit — includes 2 vehicles and 2 remote transmitters.',
					'image'          => '',
				),
			),
		),
		'overview'         => array(
			'enabled'        => '1',
			'brand_title'    => 'Bambu Lab A2L',
			'title'          => "Creative Playground.\nExtra Large.",
			'banner_image'   => '',
			'video_url'      => 'https://www.youtube.com/watch?v=0h9Vp5a8n2Y',
			'video_btn_text' => 'Watch Video',
		),
		'why_choose'       => array(
			'title' => 'Why choose Bambu Lab A2L',
			'items' => array(
				array( 'title' => 'Extra Large Build Volume', 'sub' => 'Oversized build in one go.', 'badge' => '330×320×325 mm³', 'desc' => '', 'image' => '', 'mock' => 'lc-mock-helmet' ),
				array( 'title' => 'Multi-Color Printing', 'sub' => 'The most reliable multi-color solution.', 'badge' => '19-Color AMS lite', 'desc' => '', 'image' => '', 'mock' => 'lc-mock-parrot' ),
				array( 'title' => 'Full-Auto Calibration', 'sub' => "You don't have to do ANY manual tuning.", 'badge' => 'Dual Eddy-Current', 'desc' => '', 'image' => '', 'mock' => 'lc-mock-calibration' ),
				array( 'title' => 'Modular Add-Ons', 'sub' => 'Blade cutting, pen drawing and more.', 'badge' => '500g Force · Quick-Swap', 'desc' => '', 'image' => '', 'mock' => 'lc-mock-toolheads' ),
				array( 'title' => 'MakerWorld Ecosystem', 'sub' => 'Millions of models, one-click away.', 'badge' => '2M+ Free Models', 'desc' => '', 'image' => '', 'mock' => 'lc-mock-makerworld' ),
				array( 'title' => 'Intelligent Monitoring', 'sub' => 'AutoPilot your printing process.', 'badge' => 'AutoPilot AI Sensors', 'desc' => '', 'image' => '', 'mock' => 'lc-mock-phone' ),
			),
		),
		'community_slider' => array(
			'eyebrow' => 'Top Creators | 2M+ Models | One Click Away',
			'title'   => "Printing Is a Blast When There's Always Something New on the Menu",
			'items'   => array(
				array( 'title' => 'Mechanical Board Game & Gears', 'badge' => 'Interactive Kit', 'desc' => 'Multi-color interactive mechanisms printed with high-tolerance interlocking teeth.', 'image' => '', 'class' => 'slide-boardgame' ),
				array( 'title' => 'Crimson Dragon Greatsword', 'badge' => 'Illuminated Prop', 'desc' => 'Full-scale cosplay prop printed in sections with internal channels for LED glow strips.', 'image' => '', 'class' => 'slide-redsword' ),
				array( 'title' => 'Azure Energy Claymore', 'badge' => 'Full-Scale Z-Height', 'desc' => 'Translucent blue PETG blade with crystal clear edge glow and high layer rigidity.', 'image' => '', 'class' => 'slide-bluesword' ),
				array( 'title' => 'Precision Model Kit Sprues', 'badge' => 'Multi-Material', 'desc' => 'Modular snap-together mechanical components organized on injection-molding style sprues.', 'image' => '', 'class' => 'slide-modelkit' ),
				array( 'title' => 'Topographical 3D Map Diorama', 'badge' => 'Sub-Millimeter', 'desc' => 'High-density architectural contour elevations printed with razor-sharp step precision.', 'image' => '', 'class' => 'slide-diorama' ),
			),
		),
		'build_volume'     => array(
			'eyebrow'     => 'Oversized Build Volume',
			'title'       => 'Extra Large Volume for Extra Bold Ideas',
			'desc'        => "330 × 320 × 325 mm. That's 105% more space than the 256 mm class. A full-scale helmet, in one piece. A batch of 40 fidget toys, in one run. The kind of project that used to mean slicing your model into chunks—or starting over when the seams didn't line up—now just fits.",
			'dim_w'       => '330 mm',
			'dim_d'       => '320 mm',
			'dim_h'       => '325 mm',
			'machine_tag' => 'BAMBU LAB A2L 330×320×325 mm³ ENVELOPE',
			'a1_sub'      => '256 × 256 mm · Model must be sliced into parts',
			'a1_image'    => '',
			'a2l_sub'     => '330 × 320 mm · Single-piece continuous print',
			'a2l_image'   => '',
		),
		'highlights'       => array(
			'enabled'         => '1',
			'eyebrow'         => 'Oversized Build Volume · Modular Multi-Tool',
			'title'           => "Creative Playground.\nExtra Large.",
			'description'     => 'Expand your creative boundaries with 330 × 320 × 325 mm³ build volume and modular crafting toolheads for cutting, plotting, and printing.',
			'banner_image'    => '',
			'video_title'     => 'Why choose Bambu Lab A2L',
			'video_url'       => 'https://www.youtube.com/watch?v=0h9Vp5a8n2Y',
			'video_btn_text'  => 'Watch Video',
			'items'           => array(
				array( 'value' => '330³ mm', 'title' => 'Extra Large Build Volume', 'desc' => '105% more volume than 256 mm class. Print full-scale helmets and large props in a single run.', 'image' => '' ),
				array( 'value' => 'Modular', 'title' => 'Multi-Tool Ecosystem', 'desc' => 'Modular snap-on heads for drag blade cutting, pen plotting, and laser/smartphone alignment.', 'image' => '' ),
				array( 'value' => 'Full-Auto', 'title' => 'Hands-Free Calibration', 'desc' => 'Zero manual bed leveling or Z-offset adjustments. Bed leveling and vibration calibration run automatically.', 'image' => '' ),
				array( 'value' => '19 Colors', 'title' => '2nd-Gen AMS Compatibility', 'desc' => 'Stack up to 4 AMS units for 16-color prints + 3 external feeds with active filament drying.', 'image' => '' ),
				array( 'value' => 'AutoPilot', 'title' => 'Intelligent Monitoring', 'desc' => 'PMSM motor sensors actively detect nozzle clumping, filament grinding, and air-printing in real time.', 'image' => '' ),
				array( 'value' => 'MakerWorld', 'title' => '2M+ Models One Click Away', 'desc' => 'Access millions of verified printable designs and multi-tool crafting templates with direct mobile slicing.', 'image' => '' ),
			),
			'community_title' => "Printing Is a Blast When There's Always Something New on the Menu",
			'community_sub'   => 'Top Creators · 2M+ Models · One Click Away',
			'community_items' => array(
				array( 'title' => 'Full-Scale Helmet', 'tag' => '330mm Single Piece', 'desc' => 'No slicing into chunks, no adhesive seams — print ready to wear directly off the bed.', 'image' => '' ),
				array( 'title' => 'Master Sword & Props', 'tag' => 'Massive Z-Height', 'desc' => 'Tall rigid structures printed with high layer stability and zero banding.', 'image' => '' ),
				array( 'title' => 'Miniature Dioramas', 'tag' => 'Sub-Millimeter Detail', 'desc' => 'Complex gaming terrain and topographical maps with sharp overhangs and vivid multi-color accents.', 'image' => '' ),
				array( 'title' => 'Batch Production Runs', 'tag' => '40+ Parts at Once', 'desc' => 'Maximized bed surface for high-volume makers and low-volume manufacturing.', 'image' => '' ),
			),
		),
		'modular_addons'   => array(
			'enabled'     => '1',
			'eyebrow'     => 'Modular Add-ons & 2D Processing',
			'title'       => 'Add a New Dimension with Blade Cutting & Drawing',
			'description' => "Swap the toolhead cover for the cutting module, and the A2L isn't just a printer anymore — it cuts stickers, leather, fabric, paper, and plots vector line art.",
			'tools'       => array(
				array(
					'title'    => 'Blade Cutting Module',
					'subtitle' => 'Decal, vinyl & leather cutting with up to 500g force',
					'desc'     => 'Swap to the hardened steel drag knife to cut custom liveries for RC planes, leather wraps for sword hilts, precision heat-transfer decals, and bespoke papercraft.',
					'tag'      => 'Up to 500g Force',
					'icon'     => 'knife',
					'image'    => '',
				),
				array(
					'title'    => 'Pen Drawing & Vector Plotter',
					'subtitle' => 'High-precision sketching with standard gel pens & markers',
					'desc'     => 'Mount fine-liner pens, metallic inks, or standard markers to plot architectural blueprints, circuit traces, certificates, and generative line art directly onto paper or board.',
					'tag'      => 'Vector Plotter',
					'icon'     => 'pen',
					'image'    => '',
				),
				array(
					'title'    => 'Smartphone Vision Alignment',
					'subtitle' => 'Camera auto-positioning for 2D print-and-cut jobs',
					'desc'     => 'Snap a photo of your pre-printed sheet with the Bambu Handy app. Computer vision aligns cut vectors perfectly with physical graphics, eliminating manual registration marks.',
					'tag'      => 'Vision Alignment',
					'icon'     => 'camera',
					'image'    => '',
				),
			),
		),
		'motion_stability' => array(
			'enabled'        => '1',
			'eyebrow'        => 'Engineered for Stability',
			'title'          => 'A Bed-Slinger As Stable As CoreXY',
			'description'    => 'Most bed-slingers degrade as prints get taller and heavier. The A2L uses real-time adaptive vibration compensation and tuned granular mass dampers so the last layer comes out as crisp as the first.',
			'tab1_title'     => 'Adaptive Vibration Compensation',
			'tab1_desc'      => 'Most printers run input shaping once at startup. The A2L runs a real-time calibration matrix that accounts for toolhead position AND shifting bed weight as the model grows.',
			'img_off'        => '',
			'img_on'         => '',
			'comparison_on'  => 'Active Compensation (ON): Flawless surfaces, crisp 90° corners, and zero ghosting at 500 mm/s.',
			'comparison_off' => 'Compensation (OFF): High-speed resonance artifacts, corner bulging, and layer ringing.',
			'tab2_title'     => 'Granular Mass Damper',
			'tab2_desc'      => 'Internal tuned dampers dissipate gantry resonance and harmonic vibration, enabling high-acceleration movement without ringing.',
			'img_damper'     => '',
			'img_silence'    => '',
			'stats'          => array(
				array( 'value' => '500 mm/s', 'label' => 'Max Toolhead Speed' ),
				array( 'value' => '10,000 mm/s²', 'label' => 'Max Acceleration' ),
				array( 'value' => '<49 dB', 'label' => 'Silent Mode Noise Level' ),
				array( 'value' => 'UL 2904', 'label' => 'Clean Air Certified' ),
			),
		),
		'ams_multicolor'   => array(
			'enabled'          => '1',
			'eyebrow'          => 'Automatic Material System',
			'title'            => 'Multi-Color Made Easy with 2nd-Gen AMS',
			'description'      => 'Pair the A2L with the 2nd-Gen AMS, and your filament gets a sealed, climate-controlled home — dried on demand before each print, kept airtight between them.',
			'hero_title'       => 'Multi-Color Cockatiel Bird',
			'hero_badge'       => '4-Color Single-Extruder Swap',
			'hero_img'         => '',
			'sub1_title'       => 'Nordschleife 3D Miniature',
			'sub1_img'         => '',
			'sub2_title'       => 'Relic Rush Board Game',
			'sub2_img'         => '',
			'ams_diagram_title'=> 'Support 2nd–Gen AMS',
			'ams_diagram_desc' => 'Pair the A2L with the 2nd-Gen AMS, and your filament gets a sealed, climate-controlled home—dried on demand before each print, kept airtight between them. Need more colors? Need different material types running side by side? AMS lite and the 2nd-Gen AMS share the same embedded buffer system, so you can stack and mix them: four spools, eight spools, sixteen spools—whatever your project asks for, fed cleanly through one queue.',
			'ams_diagram_pills'=> '19-Color Printing | Filament Drying | Enclosed Storage',
			'ams_diagram_img'  => '',
			'img_clumping'     => '',
			'img_grinding'     => '',
			'img_airprint'     => '',
			'img_connectivity' => '',
			'autopilot_eyebrow'=> 'INTELLIGENT PRINT MONITORING',
			'autopilot_title'  => 'Put Your Printing on Autopilot',
			'autopilot_desc'   => 'Most print failures happen quietly—the nozzle keeps moving, but the part stopped forming hours ago. Sensors along the extrusion path, paired with the PMSM extruder as a feedback node, feed a Bambu-trained algorithm that catches filament tangle, runout, nozzle clumping, and air printing—then pauses A2L and guides you through the fix on Bambu Handy.',
			'sensors'          => array(
				array( 'name' => 'Nozzle Clumping Detector', 'desc' => 'Optical eddy sensors monitor the hotend tip and trigger automatic pauses if debris accumulates.' ),
				array( 'name' => 'Filament Grinding Sensor', 'desc' => 'Monitors extruder gear torque and flags slipping or spool resistance instantly.' ),
				array( 'name' => 'Air Printing / Runout Sensor', 'desc' => 'Stops immediately if filament snaps or runs out, prompting one-touch spool recovery via Bambu Handy.' ),
			),
		),
		'flow_calibration' => array(
			'eyebrow'     => 'Auto Flow Dynamics Calibration',
			'title'       => 'Repeatable Sharp Print Details',
			'desc'        => 'Most printers calibrate flow once and trust it for every print after. A2L recalibrates every time. Before each job, Flow Dynamics Calibration measures how filament actually flows through this nozzle, with this spool, today—and builds a nonlinear model of the entire extrusion path. Nozzle wear, filament moisture, a fresh roll—all factored in before the first layer goes down. Sharp corners. Clean details. Print after print.',
			'a2l_image'   => '',
			'other_image' => '',
			'status_text' => 'Worn nozzle (20% out-spec) , Damp filament , Nozzle residue',
		),
		'clean_air'        => array(
			'eyebrow'         => 'UL Clean Air Certified',
			'title'           => 'Print with Confidence, Breathe with Peace of Mind',
			'desc'            => 'The A2L is certified under the UL 2904 standard for 3D printing indoor air quality when used with official filaments. Testing with our core lineup—including Bambu PLA Basic, PLA Pure, and PETG Basic—confirms ultra-low emissions, making the A2L safe for indoor use.',
			'lifestyle_image' => '',
			'badge_title'     => 'GREENGUARD',
			'badge_sub'       => 'PRODUCT CERTIFIED FOR LOW CHEMICAL EMISSIONS',
		),
		'silence'          => array(
			'eyebrow' => 'Engineered for Silence',
			'title'   => 'Print Quietly. Work Comfortably.',
			'desc'    => 'The A2L uses active motor noise cancellation, precision linear rails, and intelligent fan scaling to deliver a seamless experience. In Silent Mode, it operates at just 49dB—as peaceful as a quiet library.',
			'metric'  => '49 dB · Silent Mode',
			'image'   => '',
		),
		'connectivity'     => array(
			'eyebrow' => 'Connectivity & Privacy',
			'title'   => 'Connect Your Way',
			'desc'    => 'Your printer, your privacy. Use Bambu Cloud for effortless cross-device connectivity, or switch to LAN-only mode for a secure, local-network experience. Total control over how you connect.',
			'image'   => '',
		),
		'unboxing_video'   => array(
			'title'        => 'Unboxing Video',
			'video_url'    => 'https://www.youtube.com/watch?v=0h9Vp5a8n2Y',
			'video_poster' => '',
		),
		'box_contents'     => array(
			'enabled'     => '1',
			'eyebrow'     => 'Package Comparison Matrix',
			'title'       => "What's in the Box",
			'description' => 'Choose the configuration that matches your creative workflow — from standalone 3D printing to the full multi-tool crafting ecosystem.',
			'packages'    => array( 'A2L', 'A2L Combo', 'A2L Cutting Full Combo' ),
			'items'       => array(
				array(
					'name'       => 'A2L 3D Printer (330×320×325mm)',
					'standalone' => '1',
					'combo'      => '1',
					'full_combo' => '1',
				),
				array(
					'name'       => 'Tool Box & Hex Wrenches',
					'standalone' => '1',
					'combo'      => '1',
					'full_combo' => '1',
				),
				array(
					'name'       => 'Dual-Sided Textured PEI Build Plate',
					'standalone' => '1',
					'combo'      => '1',
					'full_combo' => '1',
				),
				array(
					'name'       => 'Spool Holder & PTFE Tubing',
					'standalone' => '1',
					'combo'      => '1',
					'full_combo' => '1',
				),
				array(
					'name'       => 'Sample PLA Spool & Nozzle Wiper',
					'standalone' => '1',
					'combo'      => '1',
					'full_combo' => '1',
				),
				array(
					'name'       => 'AMS lite (4-Color Automatic Material Feeder)',
					'standalone' => '0',
					'combo'      => '1',
					'full_combo' => '1',
				),
				array(
					'name'       => 'Blade Cutting Module & 45° Drag Knives',
					'standalone' => '0',
					'combo'      => '0',
					'full_combo' => '1',
				),
				array(
					'name'       => 'Pen Plotter Clamp & Dual Drawing Pens',
					'standalone' => '0',
					'combo'      => '0',
					'full_combo' => '1',
				),
				array(
					'name'       => 'Self-Healing Cutting Mat & Vinyl Sample Pack',
					'standalone' => '0',
					'combo'      => '0',
					'full_combo' => '1',
				),
			),
		),
		'specs'            => array(
			'enabled'     => '1',
			'eyebrow'     => 'Verified Engineering Metrics',
			'title'       => 'Technical Specifications',
			'description' => 'Comprehensive technical data for the Bambu Lab A2L multi-tool platform.',
			'pdf_url'     => '#',
			'items'       => array(
				array(
					'category' => 'Body & Physical Dimensions',
					'label'    => 'Build Volume (W×D×H)',
					'value'    => '330 × 320 × 325 mm³',
				),
				array(
					'category' => 'Body & Physical Dimensions',
					'label'    => 'Chassis Material',
					'value'    => 'Die-Cast Aluminum & High-Tensile Steel',
				),
				array(
					'category' => 'Body & Physical Dimensions',
					'label'    => 'Outer Frame',
					'value'    => 'Reinforced Engineered Polymer',
				),
				array(
					'category' => 'Body & Physical Dimensions',
					'label'    => 'Physical Machine Dimensions',
					'value'    => '544 × 529 × 505 mm',
				),
				array(
					'category' => 'Body & Physical Dimensions',
					'label'    => 'Net Weight',
					'value'    => '12.8 kg (A2L) / 14.9 kg (A2L Combo)',
				),
				array(
					'category' => 'Toolhead & Extrusion',
					'label'    => 'Extruder Drive Gear',
					'value'    => 'Hardened Steel Dual-Drive Gears',
				),
				array(
					'category' => 'Toolhead & Extrusion',
					'label'    => 'Hotend & Nozzle',
					'value'    => 'Stainless Steel (0.4 mm included, 0.2/0.6/0.8 mm supported)',
				),
				array(
					'category' => 'Toolhead & Extrusion',
					'label'    => 'Max Nozzle Temperature',
					'value'    => '300 °C',
				),
				array(
					'category' => 'Toolhead & Extrusion',
					'label'    => 'Filament Diameter',
					'value'    => '1.75 mm',
				),
				array(
					'category' => 'Toolhead & Extrusion',
					'label'    => 'Extruder Motor',
					'value'    => 'Closed-Loop PMSM Servo Extruder Motor',
				),
				array(
					'category' => 'Crafting & 2D Processing',
					'label'    => 'Cutting Mechanism',
					'value'    => 'Quick-Swap Modular Drag Knife Assembly',
				),
				array(
					'category' => 'Crafting & 2D Processing',
					'label'    => 'Max Cutting Downforce',
					'value'    => 'Up to 500 g',
				),
				array(
					'category' => 'Crafting & 2D Processing',
					'label'    => 'Compatible 2D Media',
					'value'    => 'Adhesive vinyl, heat transfer vinyl, cardstock, leather (<1.0mm)',
				),
				array(
					'category' => 'Crafting & 2D Processing',
					'label'    => 'Pen Plotter Support',
					'value'    => 'Universal pen adapter clamp (6 mm to 12 mm barrel)',
				),
				array(
					'category' => 'Crafting & 2D Processing',
					'label'    => 'Vision Registration',
					'value'    => 'Optical alignment via Bambu Handy smartphone camera',
				),
				array(
					'category' => 'Heatbed & Motion',
					'label'    => 'Build Plate System',
					'value'    => 'Spring Steel Plate with Double-Sided Textured PEI',
				),
				array(
					'category' => 'Heatbed & Motion',
					'label'    => 'Max Heatbed Temperature',
					'value'    => '100 °C',
				),
				array(
					'category' => 'Heatbed & Motion',
					'label'    => 'Max Toolhead Speed',
					'value'    => '500 mm/s',
				),
				array(
					'category' => 'Heatbed & Motion',
					'label'    => 'Max Acceleration',
					'value'    => '10,000 mm/s²',
				),
				array(
					'category' => 'Electronics & Software',
					'label'    => 'Control Display',
					'value'    => '3.5-inch Color IPS Touchscreen',
				),
				array(
					'category' => 'Electronics & Software',
					'label'    => 'Wireless & Connectivity',
					'value'    => 'Wi-Fi (2.4 GHz), Bluetooth, MicroSD, LAN Mode',
				),
				array(
					'category' => 'Electronics & Software',
					'label'    => 'Acoustic Noise Level',
					'value'    => '<49 dB in Silent Mode',
				),
				array(
					'category' => 'Electronics & Software',
					'label'    => 'Clean Air Certification',
					'value'    => 'UL 2904 Indoor Air Quality Certified',
				),
			),
		),
		'faq'              => array(
			'enabled'     => '1',
			'eyebrow'     => 'Questions & Answers',
			'title'       => 'Frequently Asked Questions',
			'description' => 'Find clear answers regarding the Bambu Lab A2L, multi-tool crafting add-ons, and AMS setup.',
			'items'       => array(
				array(
					'question' => 'What is the required installation space for the A2L?',
					'answer'   => 'The A2L requires a clear desktop footprint of at least 650 mm (W) × 700 mm (D) × 750 mm (H) to allow full bed traversal and adequate clearance for the top-mounted PTFE tubes.',
				),
				array(
					'question' => 'What are the primary differences between the A2L and the A1 series?',
					'answer'   => 'The A2L expands the build volume to 330 × 320 × 325 mm³ (over 105% larger volume than A1), introduces the modular crafting ecosystem for blade cutting and pen plotting, and includes tuned granular mass dampers for CoreXY-level stability.',
				),
				array(
					'question' => 'How does the blade-cutting module attach to the A2L?',
					'answer'   => 'The cutting module replaces the magnetic toolhead front cover in seconds. A single locking lever secures the drag knife assembly with automatic Z-datum referencing.',
				),
				array(
					'question' => 'How many AMS units can be connected to the A2L simultaneously?',
					'answer'   => 'The A2L supports up to 4 AMS units connected via the AMS Hub, enabling up to 16 colors in a single automated print job, plus 3 external manual feeds.',
				),
				array(
					'question' => 'Does using the AMS drying function require an external power supply?',
					'answer'   => 'The 2nd-Gen AMS includes an independent high-efficiency AC heating module that plugs into standard wall power, while communication is maintained via the A2L data bus.',
				),
				array(
					'question' => 'How quiet is the A2L during high-speed printing?',
					'answer'   => 'With active motor noise cancellation and precision linear rails, the A2L operates at under 49 dB in Silent Mode — quiet enough for bedrooms, living rooms, and office desks.',
				),
				array(
					'question' => 'What materials can the blade cutting module cut?',
					'answer'   => 'The drag knife cuts vinyl decals, heat-transfer vinyl (HTV), paper, cardstock, sticker sheets, stencil film, and thin craft leather (<1.0 mm thick) with up to 500g calibrated downforce.',
				),
				array(
					'question' => 'How does Smartphone Vision Alignment work for 2D crafting?',
					'answer'   => 'Using the Bambu Handy app on your phone, you photograph your workpiece on the bed. The software recognizes registration borders and aligns your cut or plot job with sub-millimeter precision.',
				),
				array(
					'question' => 'Does the A2L require manual bed leveling or Z-offset calibration?',
					'answer'   => 'No. The A2L features fully automatic bed leveling with eddy current distance sensing, automated nozzle offset calibration, and dynamic vibration frequency compensation before every print.',
				),
				array(
					'question' => 'Is local warranty and technical support included in the Baltics?',
					'answer'   => 'Yes. 3DKoda provides an official 2-year warranty for Baltic customers with local diagnostic assistance and genuine spare parts dispatched directly from our Tallinn warehouse.',
				),
			),
			'cta'         => array(
				'enabled'   => '1',
				'badge'     => 'READY TO CREATE?',
				'title'     => 'Transform your workflow from 3D printing to full-spectrum crafting.',
				'subtitle'  => 'Dispatched from our Tallinn warehouse with fast 1–2 day Baltic delivery and official local warranty.',
				'btn_text'  => 'Choose Your A2L Package',
				'btn_url'   => '#laser-crafting-hero',
			),
		),
	);
}

/**
 * Get all Laser & Crafting builder settings for a product, merged with defaults.
 *
 * @param int $product_id Product ID.
 * @return array
 */
function woodmart_child_get_laser_crafting_builder_settings( $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$defaults = woodmart_child_get_default_laser_crafting_builder_data();
	$saved    = get_post_meta( $product_id, '_woodmart_child_laser_crafting_builder', true );

	if ( ! is_array( $saved ) || empty( $saved ) ) {
		return $defaults;
	}

	return woodmart_child_merge_builder_settings( $defaults, $saved );
}

/**
 * Check if a specific Laser & Crafting builder section is enabled.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return bool
 */
function woodmart_child_is_laser_crafting_section_enabled( $section_key, $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$aliases = array(
		'modular'   => 'modular_addons',
		'stability' => 'motion_stability',
		'ams'       => 'ams_multicolor',
		'box'       => 'box_contents',
	);
	if ( isset( $aliases[ $section_key ] ) ) {
		$section_key = $aliases[ $section_key ];
	}

	$settings = woodmart_child_get_laser_crafting_builder_settings( $product_id );

	if ( ! isset( $settings[ $section_key ] ) ) {
		return false;
	}

	$section = $settings[ $section_key ];

	if ( ! isset( $section['enabled'] ) || ! in_array( (string) $section['enabled'], array( '1', 'yes', 'true' ), true ) ) {
		return false;
	}

	return true;
}

/**
 * Get section data for a given Laser & Crafting product.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return array
 */
function woodmart_child_get_laser_crafting_section_data( $section_key, $product_id = 0 ) {
	$aliases = array(
		'modular'   => 'modular_addons',
		'stability' => 'motion_stability',
		'ams'       => 'ams_multicolor',
		'box'       => 'box_contents',
	);
	if ( isset( $aliases[ $section_key ] ) ) {
		$section_key = $aliases[ $section_key ];
	}

	$settings = woodmart_child_get_laser_crafting_builder_settings( $product_id );
	return isset( $settings[ $section_key ] ) ? $settings[ $section_key ] : array();
}

/**
 * Get default demo data for the AMS (Automatic Material System) builder.
 *
 * @return array
 */
function woodmart_child_get_default_ams_builder_data() {
	return array(
		'general'                 => array(
			'enable_landing'  => '1',
			'eyebrow'         => 'Bambu Lab AMS',
			'brand_name'      => 'Bambu Lab',
			'badge_text'      => 'Authorized Bambu Lab Reseller',
			'rating_text'     => 'Multi-Color & Filament Drying System',
			'stock_text'      => 'In Stock',
			'stock_note'      => 'SKU: FA008',
			'warranty_text'   => '2-Year Official Warranty',
			'vat_note'        => 'incl. 24% VAT',
			'ex_vat_text'     => 'Show ex. VAT',
			'team_quote_text' => 'Buying for a team or print farm? Request a tailored quote →',
			'guarantees'      => array(
				array(
					'icon'     => 'truck',
					'title'    => 'Fast Baltic delivery',
					'subtitle' => 'Dispatched from Tallinn',
				),
				array(
					'icon'     => 'shield',
					'title'    => 'Local warranty',
					'subtitle' => 'Official 2-year coverage & EU support',
				),
				array(
					'icon'     => 'user',
					'title'    => 'Expert support',
					'subtitle' => 'Guidance from our engineering team',
				),
			),
			'bundle_addons'   => array(
				array(
					'id'            => 'ams-hub',
					'title'         => 'Bambu Lab AMS Hub',
					'badge'         => '16 Colors',
					'price'         => '59.00',
					'regular_price' => '69.00',
					'description'   => 'Connect up to 4 AMS units together for 16-color multi-spool printing.',
					'image'         => '',
				),
				array(
					'id'            => 'reusable-spools',
					'title'         => 'High-Temp Reusable Spools (4-Pack)',
					'badge'         => 'Eco-Friendly',
					'price'         => '45.00',
					'regular_price' => '55.00',
					'description'   => 'Durable high-temperature polycarbonate spools for refills and drying.',
					'image'         => '',
				),
				array(
					'id'            => 'desiccant-refill',
					'title'         => 'High-Capacity Desiccant Packs (4 Pairs)',
					'badge'         => 'Dry Storage',
					'price'         => '14.00',
					'regular_price' => '18.00',
					'description'   => 'Long-lasting silica gel packs to maintain chamber moisture below 20% RH.',
					'image'         => '',
				),
				array(
					'id'            => 'ptfe-tube-kit',
					'title'         => 'Low-Friction PTFE Tube Replacement Kit',
					'badge'         => 'Original Parts',
					'price'         => '12.00',
					'regular_price' => '15.00',
					'description'   => 'Precision-cut tubing ensuring silky smooth feeding and minimal retraction friction.',
					'image'         => '',
				),
			),
		),
		'overview'                => array(
			'eyebrow'        => 'Bambu Lab AMS 2 Pro',
			'title'          => 'AMS, Evolved.',
			'subtitle'       => '',
			'banner_image'   => '',
			'video_url'      => '',
			'video_btn_text' => 'Watch AMS in Action',
			'metrics'        => array(
				array(
					'value' => '',
					'label' => '24-Colors/Multi-material',
					'desc'  => 'Serially connect up to 4 AMS 2 Pro & 8 AMS HT units, total of 24 filaments',
				),
				array(
					'value' => '',
					'label' => 'Electro-Magnetic Air Vent',
					'desc'  => 'Fast filament drying & air-tight filament storage',
				),
				array(
					'value' => '',
					'label' => '65°C Drying',
					'desc'  => 'Up to 65°C drying temperature',
				),
				array(
					'value' => '',
					'label' => 'Brushless Motor',
					'desc'  => '60% faster feeding speed',
				),
			),
		),
		'drying_feeding'          => array(
			'eyebrow'  => '',
			'title'    => 'Dry Filament Quickly and Intelligently',
			'subtitle' => '',
			'cards'    => array(
				array(
					'tag'   => '',
					'title' => 'Electro-Magnetic Air Vent',
					'badge' => '',
					'desc'  => 'Automated venting facilitates dehumidification during drying and ensures airtight sealing for weeks of high-quality printing.',
					'image' => '',
				),
				array(
					'tag'   => '',
					'title' => 'Auto-rotate Drying',
					'badge' => '',
					'desc'  => 'During the drying process, the filament spools rotate automatically to ensure more even drying.',
					'image' => '',
				),
				array(
					'tag'   => '',
					'title' => 'RFID Sync',
					'badge' => '',
					'desc'  => 'AMS 2 Pro uses RFID to auto-match drying settings for Bambu official filaments, no manual input needed.',
					'image' => '',
				),
			),
		),
		'efficiency_metrics'      => array(
			'comparison_caption' => 'Bambu PETG Basic',
			'dry_label'          => 'Dry',
			'moist_label'        => 'Moist',
			'dry_image'          => '',
			'moist_image'        => '',
			'comparison_image'   => '',
			'eyebrow'            => '',
			'title'              => 'Speed Up! Faster Multi-material Printing!',
			'subtitle'           => '',
			'card_speed'         => array(
				'metric' => '+60%',
				'label'  => '',
				'desc'   => 'The powerful Bambu permanent magnet synchronous servo motor accelerates filament feeding by 60% for enhanced efficiency.',
			),
			'card_waste'         => array(
				'metric' => '-10min',
				'label'  => '',
				'desc'   => 'Saves an average of 10 minutes per 100 filament changes.',
			),
			'banner_title'       => 'Faster multi-color printing',
			'banner_credit'      => 'Xiaomi SU7 Ultra Prototype by @大匠',
			'banner_image'       => '',
		),
		'design_details'          => array(
			'eyebrow'  => '',
			'title'    => 'Evolved, Polished Design Details',
			'subtitle' => '',
			'cards'    => array(
				array(
					'title' => 'Tool-Free Filament Tubes Access',
					'desc'  => 'Removing snapped filament from the first-gen AMS requires extracting all spools and disassembling the shell with two screws, taking 3-5 minutes. In contrast, the AMS 2 Pro offers direct, tool-free access to filament tubes from the top.',
					'image' => '',
				),
				array(
					'title' => 'Ceramic Inlet',
					'desc'  => 'Ceramic filament inlets with Vickers hardness of 1200 significantly enhance durability.',
					'image' => '',
				),
			),
		),
		'compatibility_matrix'    => array(
			'eyebrow'      => '',
			'title'        => 'Compatible With All Bambu Lab Printers',
			'subtitle'     => 'The AMS 2 Pro will be compatible with all Bambu Lab products.',
			'lineup_image' => '',
			'note'         => 'Note: Daisy-chaining 2 to 4 AMS units requires the Bambu Lab AMS Hub and additional bus cables.',
			'printers'     => array(
				array(
					'model'        => 'X1-Carbon & X1E Series',
					'status'       => 'Full Plug & Play',
					'status_badge' => 'Native Ready',
					'multi_ams'    => 'Up to 4 AMS (16 Colors)',
					'buffer_req'   => 'Included with printer',
					'notes'        => 'Direct bus connection, full touch UI integration & chamber temp sync',
				),
				array(
					'model'        => 'P1S & P1P Series',
					'status'       => 'Full Plug & Play',
					'status_badge' => 'Native Ready',
					'multi_ams'    => 'Up to 4 AMS (16 Colors)',
					'buffer_req'   => 'Included with AMS combo or standalone buffer',
					'notes'        => 'Seamless control via Bambu Studio & Bambu Handy mobile app',
				),
				array(
					'model'        => 'A1 & A1 Mini Series',
					'status'       => 'AMS lite / Dedicated Hub',
					'status_badge' => 'Compatible',
					'multi_ams'    => '4 Colors via AMS lite',
					'buffer_req'   => 'Top mount or side feed adapter',
					'notes'        => 'Active color management with rotary spool tensioning',
				),
			),
		),
		'box_contents'            => array(
			'eyebrow'  => 'Unboxing Experience',
			'title'    => "What's in the Box",
			'subtitle' => 'Everything you need to begin multi-color 3D printing right out of the box.',
			'items'    => array(
				array(
					'title' => 'Bambu Lab AMS Unit',
					'desc'  => '1x Complete enclosed multi-material unit with airtight seal',
					'icon'  => 'box',
				),
				array(
					'title' => 'Reusable Spools',
					'desc'  => '4x High-temperature reusable spools included inside',
					'icon'  => 'disc',
				),
				array(
					'title' => 'Filament Buffer',
					'desc'  => '1x Spring-loaded dynamic buffer mechanism',
					'icon'  => 'buffer',
				),
				array(
					'title' => 'Bus Cables',
					'desc'  => '1x 6-Pin bus cable (1.5m) & 1x 4-Pin bus cable (0.5m)',
					'icon'  => 'cable',
				),
				array(
					'title' => 'PTFE Tubing',
					'desc'  => '2x Premium low-friction PTFE tubes (1.5m & 2.0m)',
					'icon'  => 'tube',
				),
				array(
					'title' => 'Desiccant Refills',
					'desc'  => '2x High-capacity desiccant packs pre-installed',
					'icon'  => 'droplet',
				),
				array(
					'title' => 'PTFE Coupler & Mount',
					'desc'  => '1x Spare PTFE coupler and Allen key set',
					'icon'  => 'tool',
				),
				array(
					'title' => 'Quick Start Guide',
					'desc'  => 'Comprehensive multi-language setup guide',
					'icon'  => 'book',
				),
			),
		),
		'specifications'          => array(
			'eyebrow'  => 'Engineering Data',
			'title'    => 'Technical Specifications',
			'subtitle' => 'Full mechanical, electrical, and material specifications for Bambu Lab AMS.',
			'items'    => array(
				array(
					'category' => 'Physical & Dimensions',
					'label'    => 'Product Dimensions',
					'value'    => '368 × 283 × 224 mm (14.5 × 11.1 × 8.8 in)',
				),
				array(
					'category' => 'Physical & Dimensions',
					'label'    => 'Net Weight',
					'value'    => '2.50 kg (5.5 lbs)',
				),
				array(
					'category' => 'Physical & Dimensions',
					'label'    => 'Chamber Seal',
					'value'    => 'Hermetic airtight silicone rubber seal ring',
				),
				array(
					'category' => 'Physical & Dimensions',
					'label'    => 'Spool Capacity',
					'value'    => '4 spools per AMS unit (daisy-chainable up to 16 spools)',
				),
				array(
					'category' => 'Spool Compatibility',
					'label'    => 'Supported Spool Width',
					'value'    => '50 mm – 68 mm',
				),
				array(
					'category' => 'Spool Compatibility',
					'label'    => 'Supported Spool Diameter',
					'value'    => '197 mm – 202 mm',
				),
				array(
					'category' => 'Spool Compatibility',
					'label'    => 'Spool Materials',
					'value'    => 'Plastic reusable spools, compatible with cardboard spools (adapter recommended)',
				),
				array(
					'category' => 'Electrical & Electronics',
					'label'    => 'Operating Voltage',
					'value'    => '24V DC (powered directly via printer bus cable)',
				),
				array(
					'category' => 'Electrical & Electronics',
					'label'    => 'Power Consumption',
					'value'    => '12W Max during feed/retraction cycle',
				),
				array(
					'category' => 'Electrical & Electronics',
					'label'    => 'RFID Frequency',
					'value'    => '13.56 MHz (ISO 15693 compatible)',
				),
				array(
					'category' => 'Electrical & Electronics',
					'label'    => 'Sensors',
					'value'    => 'Hall effect filament odometer, tension buffer sensor, humidity monitor',
				),
				array(
					'category' => 'Material Compatibility',
					'label'    => 'Recommended Materials',
					'value'    => 'PLA, PETG, ABS, ASA, PET, PC, PA, PVA, BVOH',
				),
				array(
					'category' => 'Material Compatibility',
					'label'    => 'Support Materials',
					'value'    => 'Bambu Support for PLA, Support for PA/PET, Water-soluble PVA',
				),
				array(
					'category' => 'Material Compatibility',
					'label'    => 'Not Recommended',
					'value'    => 'TPU, TPE, Damp PVA, abrasive fiber filaments without hardened gears',
				),
			),
		),
		'faq'                     => array(
			'eyebrow'    => 'Got Questions?',
			'title'      => 'Frequently Asked Questions',
			'items'      => array(
				array(
					'question' => 'How does the AMS automatically recognize filaments?',
					'answer'   => 'Each Bambu Lab filament spool includes an RFID tag on its spool core. The AMS has an integrated RFID reader at each spool bay that reads the tag when loaded, automatically identifying the filament type, color, and temperature settings without manual configuration.',
				),
				array(
					'question' => 'Can I connect multiple AMS units together for 16 colors?',
					'answer'   => 'Yes! You can connect up to 4 AMS units together to achieve 16-color 3D printing. To do so, you will need the Bambu Lab AMS Hub, which coordinates the filament feeds from all 4 units into the printer toolhead.',
				),
				array(
					'question' => 'Does the AMS dry wet filament or keep it dry?',
					'answer'   => 'The AMS features an airtight silicone seal and dual high-capacity desiccant bays designed to keep already dry filament dry during storage and printing (typically maintaining below 20% relative humidity). For filaments that have already absorbed moisture from the open air, we recommend pre-drying them in a dedicated filament dryer or on the printer heatbed.',
				),
				array(
					'question' => 'Can I print flexible TPU or carbon-fiber filaments with the AMS?',
					'answer'   => 'Flexible filaments like TPU and TPE are too soft for the AMS drive gears and retraction mechanism and should be printed directly from the external spool holder. Fiber-reinforced filaments (such as PA-CF or PET-CF) can cause wear on standard funnels over long durations; Bambu Lab recommends using hardened feed funnels for composite printing.',
				),
				array(
					'question' => 'What happens when a filament spool runs out during a print?',
					'answer'   => 'The AMS has automated spool runout detection. If you have loaded another spool with the same filament type and color, the AMS will seamlessly switch to the backup spool and continue printing without pausing. If no identical backup is available, the printer safely pauses and alerts you via Bambu Studio or the Bambu Handy app.',
				),
				array(
					'question' => 'Can I use 3rd-party spools and filaments with the AMS?',
					'answer'   => 'Yes, 3rd-party filaments on spools matching the standard dimensions (width 50–68mm, diameter 197–202mm) work seamlessly. For 3rd-party spools, you simply select the material profile manually in Bambu Studio or on the touchscreen. For cardboard spools, we recommend 3D printing a reusable perimeter ring to ensure smooth rotation.',
				),
			),
			'cta'        => array(
				'badge'    => 'Fast Baltic Delivery · Dispatched from Tallinn',
				'title'    => 'Ready to Print in Full Color?',
				'subtitle' => 'Upgrade your 3D printer with the Bambu Lab Automatic Material System today. 2-year official warranty and local Baltic support included.',
				'btn_text' => 'Order Bambu Lab AMS Now',
				'btn_url'  => '#ams-hero',
			),
			'sticky_bar' => array(
				'enabled'     => '1',
				'button_text' => 'Add to basket',
			),
		),
	);
}

/**
 * Get all AMS builder settings for a product, merged with defaults.
 *
 * @param int $product_id Product ID.
 * @return array
 */
function woodmart_child_get_ams_builder_settings( $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$defaults = woodmart_child_get_default_ams_builder_data();
	$saved    = get_post_meta( $product_id, '_woodmart_child_ams_builder', true );

	if ( ! is_array( $saved ) || empty( $saved ) ) {
		return $defaults;
	}

	return woodmart_child_merge_builder_settings( $defaults, $saved );
}

/**
 * Check if a specific AMS builder section is enabled.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return bool
 */
function woodmart_child_is_ams_section_enabled( $section_key, $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_queried_object_id() ?: get_the_ID();
	}

	$aliases = array(
		'drying'         => 'drying_feeding',
		'efficiency'     => 'efficiency_metrics',
		'speed'          => 'efficiency_metrics',
		'design'         => 'design_details',
		'design_details' => 'design_details',
		'compatibility'  => 'compatibility_matrix',
		'box'            => 'box_contents',
		'specs'          => 'specifications',
	);
	if ( isset( $aliases[ $section_key ] ) ) {
		$section_key = $aliases[ $section_key ];
	}

	$settings = woodmart_child_get_ams_builder_settings( $product_id );

	if ( ! isset( $settings[ $section_key ] ) ) {
		return false;
	}

	$section = $settings[ $section_key ];

	if ( isset( $section['enabled'] ) && ! in_array( (string) $section['enabled'], array( '1', 'yes', 'true' ), true ) ) {
		return false;
	}

	return true;
}

/**
 * Get section data for a given AMS product.
 *
 * @param string $section_key Section identifier.
 * @param int    $product_id  Product ID.
 * @return array
 */
function woodmart_child_get_ams_section_data( $section_key, $product_id = 0 ) {
	$aliases = array(
		'drying'         => 'drying_feeding',
		'efficiency'     => 'efficiency_metrics',
		'speed'          => 'efficiency_metrics',
		'design'         => 'design_details',
		'design_details' => 'design_details',
		'compatibility'  => 'compatibility_matrix',
		'box'            => 'box_contents',
		'specs'          => 'specifications',
	);
	if ( isset( $aliases[ $section_key ] ) ) {
		$section_key = $aliases[ $section_key ];
	}

	$settings = woodmart_child_get_ams_builder_settings( $product_id );
	return isset( $settings[ $section_key ] ) ? $settings[ $section_key ] : array();
}



