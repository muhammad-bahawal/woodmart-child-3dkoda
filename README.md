# Woodmart Child Theme - Apple / Bambu Lab Single Product Landing Page Builder

Production-ready, modular Woodmart Child Theme solution that turns the Bambu Lab X1-Carbon Apple-style static HTML/CSS prototype into a fully dynamic WooCommerce product page without any external plugins (No ACF, CMB2, etc.).

---

## Architecture Overview

```text
woodmart-child/
├── style.css                      # Child theme definition
├── functions.php                  # Enqueues, Woodmart bypass hooks, template_include filter, AJAX cart
├── inc/
│   ├── helpers.php                # Core data mapping, settings fetchers, sanitizers, fallbacks
│   └── meta-boxes.php             # Native custom meta box with tabbed UI, repeaters, nonces
├── assets/
│   ├── css/
│   │   ├── admin-meta-boxes.css   # Styling for tabs, switch toggles, cards, repeater rows
│   │   └── product-landing.css    # Full tokens, responsive styles, full-width viewport reset
│   └── js/
│       ├── admin-meta-boxes.js    # Vanilla JS tab switching, row cloning, wp.media uploader
│       └── product-landing.js     # Gallery, smooth scroll, sticky bar, variation sync, AJAX cart
├── templates/
│   └── custom-single-product.php  # Integrated single product template calling get_header() & get_footer()
├── woocommerce/
│   └── single-product.php         # WooCommerce template override delegating to templates/
└── template-parts/product/
    ├── hero-section.php           # Isolated 52/48 2-column gallery, summary, variations, stepper, quote, sticky nav
    ├── highlights.php             # Why X1 Carbon intro, big numbers/stats repeater
    ├── features.php               # Dark features section, main hero feature, 4-grid cards
    ├── materials.php              # Materials grid with color dot indicators, combo callout
    ├── use-cases.php              # Dark use cases 4-grid numbered cards
    ├── pricing-variants.php       # Standalone vs Combo plan comparison, brand difference
    ├── specifications.php         # Technical specifications DL grid, setup guide banner
    ├── box-contents.php           # What's in the box: Standalone vs Combo item lists
    ├── faq.php                    # FAQ details accordion, bottom orange CTA banner
    ├── sticky-bottom-bar.php      # Floating bottom purchase bar synced with variations
    ├── custom-nav.php             # (Deprecated) Neutralized in favor of Woodmart Native Header Builder
    └── custom-footer.php          # (Deprecated) Neutralized in favor of Woodmart Native Footer Builder
```

---

## Key Features & Highlights

1. **No External Plugins**:
   - Zero dependency on ACF, CMB2, Carbon Fields, or page builders.
   - 100% native WordPress custom meta boxes registered via `add_meta_box()`.
   - Native nonces, capabilities validation (`edit_product`), and sanitization.

2. **Native Woodmart Header & Footer Integration with Layout Builder Suppression**:
   - `templates/custom-single-product.php` calls standard WordPress `get_header()` and `get_footer()`, preserving Woodmart's native Header Builder (site menu, cart drawer, my-account, mobile navigation) and Footer Builder.
   - Completely suppresses Woodmart's Single Product Layout Builder (`woodmart_single_product_builder`, `woodmart_get_opt_single_product_builder`, `woodmart_layout_single_product`, `woodmart_has_custom_layout`, `woodmart_get_layout_id`) and clears cached layout data, preventing Elementor layout #1620 from injecting.
   - `template_include` hooked at `PHP_INT_MAX` ensures our custom template is the final authoritative template.
   - Suppresses native WooCommerce product summary/gallery hooks (`woocommerce_before_single_product_summary`, `woocommerce_single_product_summary`, etc.) so default product blocks never duplicate.

3. **Isolated 2-Column Hero Section**:
   - Hero section is locked into a balanced 52/48 ratio using CSS Grid with `minmax(0, ...)` tracks.
   - Left gallery column is constrained with `min-width: 0`, `overflow: hidden`, and images are strictly sized with `max-width: 100%`, `height: auto`, and `object-fit: contain` to prevent grid blowout or image overlap onto the summary area.

3. **Dedicated Admin "Product Page Builder"**:
   - 9 structured tabs: General & Nav, Highlights, Features, Materials, Use Cases, Packages & Brand, Technical Specs, What's in the Box, FAQ & CTA.
   - Master checkbox toggles per section to selectively enable/disable any section per product.
   - Dynamic vanilla JavaScript repeaters for stats, features, materials, specs, box items, FAQs, service benefits, and brand pillar cards.
   - Interactive HTML5 drag-and-drop row reordering (`☰`) for all repeater sections.
   - WordPress Media Library integration (`wp.media`) for feature and banner images with singleton frame management.
   - Strict sanitization, nonce protection, and associative-aware deep merging preventing repeater list corruption.

4. **Dynamic WooCommerce Integration & Variation Sync**:
   - Automatically binds Product Title, SKU, Price/Sale Price, Stock Status, Short Description, and Image Gallery.
   - Seamlessly handles **Variable Products** (Standalone vs Combo) with dynamic name and price resolution.
   - Real-time variation switcher synchronizes:
     - Hero setup radio buttons
     - Packages comparison plan cards
     - What's in the Box package cards
     - Sticky bottom purchase bar variation toggle pills
   - Native WooCommerce AJAX Add-to-Cart with cart fragment refreshes, exception handling, and toast notifications.

---

## Installation & Setup Instructions

1. **Upload the Child Theme**:
   - Copy the entire `woodmart-child` folder into your WordPress themes directory:
     `wp-content/themes/woodmart-child`
2. **Activate the Child Theme**:
   - Go to **wp-admin > Appearance > Themes** and activate **Woodmart Child**.
   - Ensure the parent **Woodmart** theme is installed in `wp-content/themes/woodmart`.
3. **Configure a Product**:
   - Go to **Products > All Products** and edit a product (or add a new product).
   - Scroll to the **Product Page Builder (Apple / Bambu Lab Style)** meta box.
   - Check the master toggle: **"Enable Custom Apple/Bambu Lab Landing Page"**.
   - Customize texts, images, and repeater items as desired across the tabs, or keep the built-in defaults.
   - Click **Update** to publish changes.
