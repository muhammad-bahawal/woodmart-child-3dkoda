<?php
/**
 * Template Part: Laser & Crafting Sticky In-Page Navigation
 *
 * Exact match to Image 2:
 * - Fixed/Sticky dark top bar
 * - 4 Navigation Links: Overview | Dive in | Specs | FAQ
 * - ScrollSpy active indicator
 *
 * @package WoodmartChild
 */

defined( 'ABSPATH' ) || exit;
?>

<nav class="lc-subnav-bar" id="lc-subnav" aria-label="<?php esc_attr_e( 'In-Page Navigation', 'woodmart-child' ); ?>">
	<div class="container lc-subnav-inner">
		<ul class="lc-subnav-links" role="menubar">
			<li role="none">
				<a href="#lc-overview" class="lc-subnav-link is-active" role="menuitem">
					<span><?php esc_html_e( 'Overview', 'woodmart-child' ); ?></span>
				</a>
			</li>
			<li role="none">
				<a href="#lc-dive-in" class="lc-subnav-link" role="menuitem">
					<span><?php esc_html_e( 'Dive in', 'woodmart-child' ); ?></span>
				</a>
			</li>
			<li role="none">
				<a href="#lc-specifications" class="lc-subnav-link" role="menuitem">
					<span><?php esc_html_e( 'Specs', 'woodmart-child' ); ?></span>
				</a>
			</li>
			<li role="none">
				<a href="#lc-faq" class="lc-subnav-link" role="menuitem">
					<span><?php esc_html_e( 'FAQ', 'woodmart-child' ); ?></span>
				</a>
			</li>
		</ul>
	</div>
</nav>
