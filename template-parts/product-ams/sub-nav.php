<?php
/**
 * Template Part: AMS Sticky In-Page Navigation Bar
 *
 * Sticky dark tabs bar positioned directly below the site header:
 * - Tabs: Overview (#ams-overview) | Specs (#ams-specifications) | FAQ (#ams-faq)
 * - Sticky scroll behavior with active indicator underline
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;
?>

<nav class="ams-subnav-bar" id="ams-subnav" aria-label="<?php esc_attr_e( 'In-Page Navigation', 'woodmart-child' ); ?>">
	<div class="ams-subnav-inner container">
		<ul class="ams-subnav-links" role="menubar">
			<li role="none">
				<a href="#ams-overview" class="ams-subnav-link is-active" role="menuitem">
					<span><?php esc_html_e( 'Overview', 'woodmart-child' ); ?></span>
				</a>
			</li>
			<li role="none">
				<a href="#ams-specifications" class="ams-subnav-link" role="menuitem">
					<span><?php esc_html_e( 'Specs', 'woodmart-child' ); ?></span>
				</a>
			</li>
			<li role="none">
				<a href="#ams-faq" class="ams-subnav-link" role="menuitem">
					<span><?php esc_html_e( 'FAQ', 'woodmart-child' ); ?></span>
				</a>
			</li>
		</ul>
	</div>
</nav>
