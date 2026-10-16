/**
 * Product Landing Page Frontend JavaScript
 * Handles gallery, vertical thumbnails navigation, quantity stepper, smooth scroll,
 * sticky purchase bar, variation switcher synchronization with image swapping,
 * and WooCommerce AJAX add-to-cart.
 *
 * @package WoodmartChild
 */

(function () {
	'use strict';

	function sanitizeCurrencyHtml(html) {
		if (!html) return '';
		return String(html).replace(/&#36;|\$|&dollar;/g, '€');
	}

	document.addEventListener('DOMContentLoaded', function () {
		initMobileMenu();
		initQuantitySteppers();
		initProductGallery();
		initSmoothScrollAndSpy();
		initStickyPurchaseBar();
		initVariationSync();
		initAjaxAddToCart();
		initFilamentInteractions();
		initAccessoriesInteractions();
		initLaserCraftingInteractions();
		initAmsInteractions();
	});

	/* ==========================================================================
	   1. MOBILE MENU TOGGLE
	   ========================================================================== */
	function initMobileMenu() {
		const menuToggle = document.querySelector('.menu-toggle');
		const siteNav = document.getElementById('site-nav');

		if (!menuToggle || !siteNav) return;

		menuToggle.addEventListener('click', function (e) {
			const isOpen = siteNav.classList.toggle('is-open');
			menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		});

		// Close nav when clicking outside
		document.addEventListener('click', function (e) {
			if (!siteNav.contains(e.target) && !menuToggle.contains(e.target) && siteNav.classList.contains('is-open')) {
				siteNav.classList.remove('is-open');
				menuToggle.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/* ==========================================================================
	   2. QUANTITY STEPPERS
	   ========================================================================== */
	function initQuantitySteppers() {
		const steppers = document.querySelectorAll('.product-quantity');

		steppers.forEach(stepper => {
			const input = stepper.querySelector('input');
			if (!input) return;

			input.addEventListener('change', function () {
				this.value = Math.max(1, parseInt(this.value, 10) || 1);
			});

			stepper.addEventListener('click', function (e) {
				const stepBtn = e.target.closest('button[data-step]');
				if (!stepBtn) return;

				const step = parseInt(stepBtn.dataset.step, 10) || 0;
				const currentVal = Math.max(1, parseInt(input.value, 10) || 1);
				const newVal = Math.max(1, currentVal + step);

				input.value = newVal;
				input.dispatchEvent(new Event('change', { bubbles: true }));
			});
		});
	}

	/* ==========================================================================
	   3. PRODUCT GALLERY THUMBNAIL SWITCHER & VERTICAL SLIDER
	   ========================================================================== */
	function initProductGallery() {
		const gallery = document.querySelector('.product-gallery');
		if (!gallery) return;

		let mainImg = gallery.querySelector('.product-gallery__main img');
		const mainContainer = gallery.querySelector('.product-gallery__main');
		const thumbsWrap = gallery.querySelector('.product-gallery__thumbs-wrap');
		const thumbsList = gallery.querySelector('.product-gallery__thumbs');
		const thumbs = gallery.querySelectorAll('.product-gallery__thumbs li');
		const prevBtn = gallery.querySelector('.gallery-nav-prev');
		const nextBtn = gallery.querySelector('.gallery-nav-next');

		if (!thumbs.length) return;

		// Handle Vertical Scrolling Navigation - only show arrows if thumbnails actually overflow
		function checkThumbsOverflow() {
			if (!thumbsWrap || !thumbsList) return;
			const hasOverflow = (thumbsList.scrollHeight - thumbsList.clientHeight) > 8;
			thumbsWrap.classList.toggle('has-nav-active', hasOverflow);
		}

		checkThumbsOverflow();
		window.addEventListener('load', checkThumbsOverflow);
		window.addEventListener('resize', checkThumbsOverflow);
		setTimeout(checkThumbsOverflow, 300);
		setTimeout(checkThumbsOverflow, 1000);

		function scrollThumbs(direction) {
			if (!thumbsList) return;
			const scrollStep = 94; // 82px thumb + 12px gap
			const currentTop = thumbsList.scrollTop;
			const targetTop = direction === 'up' ? Math.max(0, currentTop - scrollStep) : currentTop + scrollStep;

			try {
				thumbsList.scrollTo({ top: targetTop, behavior: 'smooth' });
			} catch (err) {
				thumbsList.scrollTop = targetTop;
			}
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				scrollThumbs('up');
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				scrollThumbs('down');
			});
		}

		thumbs.forEach((thumb) => {
			thumb.addEventListener('click', function () {
				thumbs.forEach(t => t.classList.remove('is-active'));
				thumb.classList.add('is-active');

				const targetUrl = thumb.dataset.fullUrl;
				const targetAlt = thumb.dataset.alt || '';

				if (targetUrl) {
					if (!mainImg && mainContainer) {
						mainContainer.innerHTML = `<img src="${targetUrl}" alt="${targetAlt}" id="product-main-image">`;
						mainImg = mainContainer.querySelector('img');
					} else if (mainImg) {
						mainImg.style.transition = 'opacity 0.2s ease';
						mainImg.style.opacity = '0.3';
						setTimeout(() => {
							mainImg.src = targetUrl;
							mainImg.alt = targetAlt;
							mainImg.style.opacity = '1';
						}, 150);
					}
				}
			});
		});

		// "Change view" button to cycle through thumbnails
		const changeViewBtn = document.getElementById('hero-change-view');
		if (changeViewBtn && thumbs.length > 1) {
			changeViewBtn.addEventListener('click', function (e) {
				e.preventDefault();
				let currentIdx = 0;
				thumbs.forEach((t, i) => {
					if (t.classList.contains('is-active')) currentIdx = i;
				});
				const nextIdx = (currentIdx + 1) % thumbs.length;
				thumbs[nextIdx].click();
				thumbs[nextIdx].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			});
		}
	}

	/* ==========================================================================
	   4. SMOOTH SCROLL & IN-PAGE NAV SPY (WITH MOBILE AUTO-CENTER ACTIVE TAB)
	   ========================================================================== */
	function initSmoothScrollAndSpy() {
		const sectionNav = document.querySelector('.product-section-navigation');
		const navUl = sectionNav ? sectionNav.querySelector('ul') : null;
		const navLinks = sectionNav ? sectionNav.querySelectorAll('a[href^="#"]') : [];
		const header = document.querySelector('.whb-header') || document.querySelector('.site-header') || document.querySelector('header');

		function getOffset() {
			const headerHeight = header ? header.offsetHeight : 64;
			const navHeight = sectionNav ? sectionNav.offsetHeight : 48;
			return headerHeight + navHeight + 10;
		}

		function centerActiveTab(activeLink) {
			if (!activeLink || !navUl) return;
			// Automatically center active tab if navUl has horizontal overflow
			if (navUl.scrollWidth > navUl.clientWidth) {
				const targetItem = activeLink.closest('li') || activeLink;
				const scrollLeftTarget = targetItem.offsetLeft - (navUl.clientWidth / 2) + (targetItem.offsetWidth / 2);
				navUl.scrollTo({
					left: Math.max(0, scrollLeftTarget),
					behavior: 'smooth'
				});
			}
		}

		// Smooth scroll on anchor click
		document.querySelectorAll('a[href^="#"]').forEach(anchor => {
			anchor.addEventListener('click', function (e) {
				const targetId = this.getAttribute('href');
				if (targetId === '#' || targetId === '#top') {
					e.preventDefault();
					window.scrollTo({ top: 0, behavior: 'smooth' });
					return;
				}

				const targetElem = document.querySelector(targetId);
				if (targetElem) {
					e.preventDefault();
					const elementPosition = targetElem.getBoundingClientRect().top + window.pageYOffset;
					const offsetPosition = elementPosition - getOffset();

					window.scrollTo({
						top: offsetPosition,
						behavior: 'smooth'
					});

					// If anchor is in tab navigation, activate and center it immediately
					if (sectionNav && sectionNav.contains(this)) {
						navLinks.forEach(l => l.classList.remove('is-active'));
						this.classList.add('is-active');
						centerActiveTab(this);
					}
				}
			});
		});

		// Scrollspy for in-page navigation links
		if (navLinks.length) {
			const sections = [];
			navLinks.forEach(link => {
				const target = document.querySelector(link.getAttribute('href'));
				if (target) sections.push({ link, target });
			});

			let currentActiveLink = null;

			window.addEventListener('scroll', function () {
				const scrollPos = window.pageYOffset + getOffset() + 20;

				sections.forEach(({ link, target }) => {
					const top = target.offsetTop;
					const height = target.offsetHeight;

					if (scrollPos >= top && scrollPos < top + height) {
						if (currentActiveLink !== link) {
							currentActiveLink = link;
							navLinks.forEach(l => l.classList.remove('is-active'));
							link.classList.add('is-active');
							centerActiveTab(link);
						}
					}
				});
			}, { passive: true });
		}
	}

	/* ==========================================================================
	   5. STICKY BOTTOM PURCHASE BAR
	   ========================================================================== */
	function initStickyPurchaseBar() {
		const stickyBar = document.querySelector('.sticky-purchase-bar');
		const heroForm = document.querySelector('.product-add-to-cart-form');

		if (!stickyBar || !heroForm) return;

		const observer = new IntersectionObserver(entries => {
			entries.forEach(entry => {
				// Show sticky bar when hero form is scrolled past
				if (!entry.isIntersecting && entry.boundingClientRect.top < 0) {
					stickyBar.classList.add('is-visible');
				} else if (entry.isIntersecting) {
					stickyBar.classList.remove('is-visible');
				}
			});
		}, {
			threshold: 0.1
		});

		observer.observe(heroForm);
	}

	/* ==========================================================================
	   6. VARIATION SWITCHER SYNCHRONIZATION WITH IMAGE CHANGE
	   ========================================================================== */
	function initVariationSync() {
		const setupRadios = document.querySelectorAll('input[name="setup"]');
		const skuDisplay = document.querySelector('.product-sku');
		const priceDisplay = document.querySelector('.product-price');
		const priceNote = document.querySelector('.product-price-note');
		const vatLink = document.querySelector('.vat-link');
		const stickyBarTitle = document.querySelector('.sticky-bar-title') || document.querySelector('.sticky-purchase-bar b');
		const stickyBarPrice = document.querySelector('.sticky-bar-price') || document.querySelector('.sticky-purchase-bar small');
		const stickyBarThumb = document.querySelector('.sticky-bar__thumb') || document.querySelector('.sticky-bar-thumb');
		const stickyVarBtns = document.querySelectorAll('.sticky-var-btn');
		const boxCards = document.querySelectorAll('.product-package-contents__grid .pkg[data-select-setup]');
		const hiddenVariationInput = document.getElementById('selected-variation-id');

		let isExVat = false;
		let currentRawPrice = parseFloat(priceDisplay ? (priceDisplay.dataset.priceRaw || 0) : 0) || 0;
		let currentPriceHtml = priceDisplay ? (priceDisplay.dataset.priceHtml || priceDisplay.innerHTML) : '';

		function formatPrice(rawNum) {
			let symbol = (window.woodmartLandingData && window.woodmartLandingData.currencySymbol) || '€';
			if (symbol === '$') symbol = '€';
			const formatted = rawNum.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			return `<span class="woocommerce-Price-amount amount" style="color:#111827 !important;"><bdi style="color:#111827 !important;"><span class="woocommerce-Price-currencySymbol" style="color:#111827 !important;">${symbol}</span>${formatted}</bdi></span>`;
		}

		function renderCurrentPrice() {
			let displayHtml = sanitizeCurrencyHtml(currentPriceHtml);
			if (isExVat && currentRawPrice > 0) {
				const exVatNum = currentRawPrice / 1.24;
				displayHtml = formatPrice(exVatNum);
			}

			if (priceDisplay) {
				priceDisplay.innerHTML = displayHtml;
				priceDisplay.style.color = '#111827';
			}

			if (stickyBarPrice) {
				const noteText = isExVat ? 'excl. 24% VAT · sample price' : 'incl. 24% VAT · sample price';
				stickyBarPrice.innerHTML = `${displayHtml} <small>${noteText}</small>`;
			}
		}

		// Initialize VAT toggle button
		if (vatLink) {
			vatLink.addEventListener('click', function (e) {
				e.preventDefault();
				isExVat = !isExVat;
				this.textContent = isExVat ? 'Show incl. VAT' : 'Show ex. VAT';
				if (priceNote) {
					priceNote.textContent = isExVat ? 'excl. 24% VAT · sample price' : 'incl. 24% VAT · sample price';
				}
				renderCurrentPrice();
			});
		}

		function applyVariation(variationId, title, priceHtml, sku, isCombo, rawPrice, imageUrl) {
			// Update hidden form field
			if (hiddenVariationInput) {
				hiddenVariationInput.value = variationId;
			}

			// Update SKU
			if (skuDisplay && sku) {
				skuDisplay.textContent = sku;
			}

			// Update prices
			currentRawPrice = parseFloat(rawPrice || 0) || 0;
			currentPriceHtml = priceHtml || '';
			renderCurrentPrice();

			// Update Sticky Bar Title & Thumbnail
			if (stickyBarTitle && title) {
				let cleanTitle = title;
				if (cleanTitle.indexOf(' - ') !== -1) {
					const parts = cleanTitle.split(' - ');
					cleanTitle = parts[parts.length - 1].trim();
				}
				stickyBarTitle.textContent = cleanTitle;
			}
			if (stickyBarThumb && imageUrl) {
				stickyBarThumb.src = imageUrl;
			}

			// Update Main Gallery Image if variation image is provided
			if (imageUrl) {
				const mainImg = document.getElementById('product-main-image');
				if (mainImg) {
					mainImg.style.transition = 'opacity 0.2s ease';
					mainImg.style.opacity = '0.3';
					setTimeout(() => {
						mainImg.src = imageUrl;
						mainImg.style.opacity = '1';
					}, 150);
				}

				// Also highlight the corresponding gallery thumbnail if it exists
				const matchingThumb = document.querySelector(`.product-gallery__thumbs li[data-full-url="${imageUrl}"]`);
				if (matchingThumb) {
					document.querySelectorAll('.product-gallery__thumbs li').forEach(t => t.classList.remove('is-active'));
					matchingThumb.classList.add('is-active');
					matchingThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
				}
			}

			// Sync hero radio labels - only the selected variation receives is-selected
			setupRadios.forEach(radio => {
				const isMatch = (String(radio.value) === String(variationId));
				radio.checked = isMatch;
				const parentLabel = radio.closest('.option');
				if (parentLabel) {
					parentLabel.classList.toggle('is-selected', isMatch);
				}
			});

			// Sync sticky purchase bar variation toggle buttons
			stickyVarBtns.forEach(btn => {
				const isMatch = (btn.dataset.variationId === String(variationId)) || (isCombo && btn.dataset.combo === '1') || (!isCombo && btn.dataset.combo === '0');
				btn.classList.toggle('is-active', isMatch);
			});

			// Sync "What's in the Box" cards
			boxCards.forEach(card => {
				const isCardCombo = card.dataset.selectSetup === 'combo';
				card.classList.toggle('is-active', isCardCombo === isCombo);
			});

			// Sync Comparison / Plan cards
			document.querySelectorAll('.product-comparison .plan').forEach(card => {
				const isPlanCombo = card.dataset.setup === 'combo';
				card.classList.toggle('is-active', isPlanCombo === isCombo);
			});
		}

		// When Hero radio changes
		setupRadios.forEach(radio => {
			radio.addEventListener('change', function () {
				const variationId = this.value;
				const title = this.dataset.title;
				const priceHtml = this.dataset.priceHtml;
				const sku = this.dataset.sku;
				const isCombo = this.dataset.combo === '1';
				const rawPrice = this.dataset.priceRaw || 0;
				const imageUrl = this.dataset.image || '';

				applyVariation(variationId, title, priceHtml, sku, isCombo, rawPrice, imageUrl);
			});
		});

		// When sticky bottom bar variation toggle button is clicked
		stickyVarBtns.forEach(btn => {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				const varId = this.dataset.variationId;
				let matchedRadio = null;
				if (varId) {
					matchedRadio = document.querySelector(`input[name="setup"][value="${varId}"]`);
				}
				if (!matchedRadio) {
					const targetCombo = this.dataset.combo === '1';
					matchedRadio = document.querySelector(`input[name="setup"][data-combo="${targetCombo ? '1' : '0'}"]`);
				}
				if (matchedRadio) {
					matchedRadio.checked = true;
					matchedRadio.dispatchEvent(new Event('change', { bubbles: true }));
				}
			});
		});

		// When "What's in the box" package cards are clicked
		boxCards.forEach(card => {
			card.addEventListener('click', function () {
				const targetCombo = this.dataset.selectSetup === 'combo';
				const matchedRadio = document.querySelector(`input[name="setup"][data-combo="${targetCombo ? '1' : '0'}"]`);
				if (matchedRadio) {
					matchedRadio.checked = true;
					matchedRadio.dispatchEvent(new Event('change', { bubbles: true }));
				}
			});

			card.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					this.click();
				}
			});
		});

		// When comparison package cards or buttons are clicked (e.g. Choose Standalone / Choose Combo)
		document.querySelectorAll('.product-comparison .plan').forEach(planCard => {
			planCard.addEventListener('click', function (e) {
				const selectBtn = planCard.querySelector('[data-select-setup]');
				const targetCombo = (planCard.dataset.setup === 'combo') || (selectBtn && selectBtn.dataset.selectSetup === 'combo');
				const matchedRadio = document.querySelector(`input[name="setup"][data-combo="${targetCombo ? '1' : '0'}"]`);

				if (matchedRadio) {
					matchedRadio.checked = true;
					matchedRadio.dispatchEvent(new Event('change', { bubbles: true }));
				}
			});
		});

		// Initial check on page load: only activate card if a variation radio is already selected
		const initialChecked = document.querySelector('input[name="setup"]:checked');
		if (initialChecked) {
			const isInitialCombo = initialChecked.dataset.combo === '1';
			document.querySelectorAll('.product-comparison .plan').forEach(card => {
				const isPlanCombo = card.dataset.setup === 'combo';
				card.classList.toggle('is-active', isPlanCombo === isInitialCombo);
			});
		} else {
			document.querySelectorAll('.product-comparison .plan').forEach(card => {
				card.classList.remove('is-active');
			});
		}
	}

	/* ==========================================================================
	   7. WOOCOMMERCE AJAX ADD-TO-CART & NOTICES
	   ========================================================================== */
	function showNotice(message, isError) {
		const existingNotice = document.querySelector('.wc-landing-toast');
		if (existingNotice) existingNotice.remove();

		const toast = document.createElement('div');
		toast.className = 'wc-landing-toast' + (isError ? ' is-error' : '');
		toast.innerHTML = message;
		document.body.appendChild(toast);

		setTimeout(() => {
			toast.style.transition = 'opacity 0.3s ease';
			toast.style.opacity = '0';
			setTimeout(() => toast.remove(), 300);
		}, 4000);
	}

	function initAjaxAddToCart() {
		const form = document.querySelector('.product-add-to-cart-form');
		const stickyBtn = document.querySelector('.sticky-purchase-bar .btn');

		if (!form) return;

		function handleAddToCart(submitBtn) {
			const productIdInput = form.querySelector('input[name="product_id"]');
			const variationIdInput = form.querySelector('input[name="variation_id"]') || form.querySelector('#selected-variation-id');
			const qtyInput = form.querySelector('input[name="quantity"]') || form.querySelector('.product-quantity input');

			const productId = productIdInput ? productIdInput.value : 0;
			const variationId = variationIdInput ? variationIdInput.value : 0;
			const quantity = qtyInput ? Math.max(1, parseInt(qtyInput.value, 10) || 1) : 1;

			if (!productId) return;

			// Check if variation is required but not selected (printer setup radios)
			const setupRadios = form.querySelectorAll('input[name="setup"]');
			if (setupRadios.length > 0 && !variationId) {
				showNotice('Please choose your setup before adding to basket.', true);
				const configBox = form.querySelector('.product-configuration');
				if (configBox) {
					configBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
					configBox.classList.add('is-unselected-alert');
					setTimeout(() => configBox.classList.remove('is-unselected-alert'), 1200);
				}
				return;
			}

			// Check if variation is required but not selected (filament swatches)
			const filamentSwatches = form.querySelectorAll('.filament-swatch');
			if (filamentSwatches.length > 0 && !variationId) {
				showNotice('Please select a color before adding to basket.', true);
				const colorsBlock = form.querySelector('.filament-colors-block');
				if (colorsBlock) {
					colorsBlock.scrollIntoView({ behavior: 'smooth', block: 'center' });
					colorsBlock.classList.add('is-unselected-alert');
					setTimeout(() => colorsBlock.classList.remove('is-unselected-alert'), 1200);
				}
				return;
			}

			// Check if variation is required but not selected (filament format cards)
			const filamentCards = form.querySelectorAll('.filament-format-card');
			if (filamentCards.length > 0 && !variationId) {
				showNotice('Please select a variation before adding to basket.', true);
				const formatsBlock = form.querySelector('.filament-formats-block');
				if (formatsBlock) {
					formatsBlock.scrollIntoView({ behavior: 'smooth', block: 'center' });
					formatsBlock.classList.add('is-unselected-alert');
					setTimeout(() => formatsBlock.classList.remove('is-unselected-alert'), 1200);
				}
				return;
			}

			// Check if variation is required but not selected (accessories pill selectors)
			const accPillGroups = form.querySelectorAll('.accessories-attr-group');
			if (accPillGroups.length > 0 && !variationId) {
				showNotice('Please select your preferred specification before adding to basket.', true);
				const attrContainer = form.querySelector('.accessories-attributes-container');
				if (attrContainer) {
					attrContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
					attrContainer.classList.add('is-unselected-alert');
					setTimeout(() => attrContainer.classList.remove('is-unselected-alert'), 1200);
				}
				return;
			}

			// Check if variation is required but not selected (laser & crafting choice)
			const lcRadios = form.querySelectorAll('input[name="lc_variation_choice"]');
			if (lcRadios.length > 0 && !variationId) {
				showNotice('Please choose your configuration before adding to basket.', true);
				const configBox = form.querySelector('.lc-variations-fieldset');
				if (configBox) {
					configBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
					configBox.classList.add('is-unselected-alert');
					setTimeout(() => configBox.classList.remove('is-unselected-alert'), 1200);
				}
				return;
			}

			// Set loading state
			if (submitBtn) {
				submitBtn.classList.add('is-loading');
				submitBtn.disabled = true;
			}
			if (stickyBtn && stickyBtn !== submitBtn) {
				stickyBtn.classList.add('is-loading');
				stickyBtn.disabled = true;
			}

			const config = window.woodmartLandingData || {};
			const ajaxUrl = config.ajaxUrl || '/wp-admin/admin-ajax.php';
			const nonce = config.nonce || '';

			const formData = new FormData();
			formData.append('action', 'woodmart_child_add_to_cart');
			formData.append('security', nonce);
			formData.append('product_id', productId);
			formData.append('variation_id', variationId);
			formData.append('quantity', quantity);

			fetch(ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then(res => res.text())
			.then(text => {
				if (submitBtn) {
					submitBtn.classList.remove('is-loading');
					submitBtn.disabled = false;
				}
				if (stickyBtn) {
					stickyBtn.classList.remove('is-loading');
					stickyBtn.disabled = false;
				}

				let data = null;
				try {
					data = JSON.parse(text);
				} catch (e) {
					// Extract JSON if any characters or PHP notices were wrapped around it
					const jsonMatch = text.match(/\{[\s\S]*\}/);
					if (jsonMatch) {
						try {
							data = JSON.parse(jsonMatch[0]);
						} catch (err2) {}
					}
				}

				const cartUrl = (config && config.cartUrl) || '#';

				if (data && data.success) {
					// Update cart count badges across Woodmart header builder
					const resData = (data && data.data) ? data.data : (data || {});
					const cartCount = (typeof resData.cart_count !== 'undefined') ? resData.cart_count : data.cart_count;
					if (typeof cartCount !== 'undefined') {
						const cartCountBadges = document.querySelectorAll('.wd-cart-number, .whb-cart-number, .woodmart-cart-number, .cart-count, .site-header__tools .cart-count');
						cartCountBadges.forEach(badge => {
							badge.textContent = cartCount;
						});
					}

					// Show success toast
					showNotice(`✓ Added to sample basket! <a href="${cartUrl}">View basket →</a>`, false);

					// Trigger native WooCommerce fragments update safely
					if (window.jQuery) {
						try {
							const $btn = submitBtn ? window.jQuery(submitBtn) : (stickyBtn ? window.jQuery(stickyBtn) : window.jQuery(document.body));
							const fragments = resData.fragments || data.fragments || {};
							const cartHash = resData.cart_hash || data.cart_hash || '';

							if (fragments && typeof fragments === 'object') {
								window.jQuery.each(fragments, function(key, val) {
									window.jQuery(key).replaceWith(val);
								});
							}

							window.jQuery(document.body).trigger('wc_fragment_refresh');
							window.jQuery(document.body).trigger('added_to_cart', [fragments, cartHash, $btn]);
						} catch (jqErr) {
							console.warn('Woodmart fragment trigger notice:', jqErr);
						}
					}
				} else if (data && data.success === false) {
					const errorMsg = (data.data && data.data.message) ? data.data.message : ((data && data.message) ? data.message : 'Could not add item to basket. Please try again.');
					showNotice(errorMsg, true);
				} else {
					// Fallback: If HTTP request succeeded, notify success and trigger fragments
					showNotice(`✓ Added to sample basket! <a href="${cartUrl}">View basket →</a>`, false);

					if (window.jQuery) {
						try {
							const $btn = submitBtn ? window.jQuery(submitBtn) : (stickyBtn ? window.jQuery(stickyBtn) : window.jQuery(document.body));
							window.jQuery(document.body).trigger('wc_fragment_refresh');
							window.jQuery(document.body).trigger('added_to_cart', [{}, '', $btn]);
						} catch (jqErr) {
							console.warn('Woodmart fragment trigger notice:', jqErr);
						}
					}
				}
			})
			.catch(err => {
				console.error('AJAX add-to-cart error:', err);
				if (submitBtn) {
					submitBtn.classList.remove('is-loading');
					submitBtn.disabled = false;
				}
				if (stickyBtn) {
					stickyBtn.classList.remove('is-loading');
					stickyBtn.disabled = false;
				}
				showNotice('An error occurred. Please try again.', true);
			});
		}

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			const submitBtn = form.querySelector('button[type="submit"]');
			handleAddToCart(submitBtn);
		});

		if (stickyBtn) {
			stickyBtn.addEventListener('click', function (e) {
				e.preventDefault();
				handleAddToCart(stickyBtn);
			});
		}
	}

	/* ==========================================================================
	   8. FILAMENT LANDING PAGE INTERACTIONS
	   ========================================================================== */
	function initFilamentInteractions() {
		const root = document.querySelector('.filament-landing-root');
		if (!root) return;

		const activeColorSpan = root.querySelector('#active-filament-color-name');
		const colorInput = root.querySelector('#selected-filament-color');
		const formatInput = root.querySelector('#selected-filament-format');
		const variationSummary = root.querySelector('#filament-variation-summary');
		const mainPriceSpan = root.querySelector('.filament-current-price');
		const swatches = root.querySelectorAll('.filament-swatch');
		const formatCards = root.querySelectorAll('.filament-formats-grid .filament-format-card');
		const compFormatCards = root.querySelectorAll('.filament-format-cards-grid .filament-format-card');
		const addToCartBtn = root.querySelector('.filament-btn-add-to-cart') || root.querySelector('.product-add-to-cart button[type="submit"]');
		const btnTextSpan = addToCartBtn ? (addToCartBtn.querySelector('.btn-text') || addToCartBtn.querySelector('span')) : null;

		let matrix = [];
		const matrixScript = root.querySelector('#filament-variation-matrix');
		if (matrixScript) {
			try {
				matrix = JSON.parse(matrixScript.textContent) || [];
			} catch (e) {
				matrix = [];
			}
		}

		let selectedColorSlug = '';
		let currentColorName = '';
		const initialActiveSwatch = root.querySelector('.filament-swatch.is-active');
		if (initialActiveSwatch) {
			selectedColorSlug = (initialActiveSwatch.dataset.slug || '').toLowerCase();
			currentColorName = initialActiveSwatch.dataset.colorName || '';
		}

		let selectedFormatSlug = '';
		let currentFormatTitle = '';
		const initialActiveCard = root.querySelector('.filament-format-card.is-active');
		if (initialActiveCard) {
			selectedFormatSlug = (initialActiveCard.dataset.format || '').toLowerCase();
			currentFormatTitle = initialActiveCard.dataset.title || '';
		}

		function findMatchingVariation(colorSlug, formatSlug) {
			if (!matrix.length) return null;
			const cSlug = (colorSlug || '').toLowerCase().trim();
			const fSlug = (formatSlug || '').toLowerCase().trim();

			// 1. Exact match on both color and format
			if (cSlug && fSlug) {
				const exact = matrix.find(v => {
					const cMatch = v.color && (v.color.toLowerCase() === cSlug || cSlug.includes(v.color.toLowerCase()) || v.color.toLowerCase().includes(cSlug));
					const fMatch = v.format && (v.format.toLowerCase() === fSlug || fSlug.includes(v.format.toLowerCase()) || v.format.toLowerCase().includes(fSlug));
					return cMatch && fMatch;
				});
				if (exact) return exact;
			}

			// 2. If format is chosen but no color
			if (fSlug && !cSlug) {
				const fMatch = matrix.find(v => v.format && (v.format.toLowerCase() === fSlug || fSlug.includes(v.format.toLowerCase())));
				if (fMatch) return fMatch;
			}

			// 3. Match color if chosen
			if (cSlug) {
				const cMatch = matrix.find(v => v.color && (v.color.toLowerCase() === cSlug || cSlug.includes(v.color.toLowerCase()) || v.color.toLowerCase().includes(cSlug)));
				if (cMatch) return cMatch;
			}

			return null;
		}

		function updateFormatCardPrices() {
			formatCards.forEach(card => {
				const fSlug = card.dataset.format;
				const priceSlot = card.querySelector('[data-format-slot]');
				if (priceSlot && fSlug) {
					const v = findMatchingVariation(selectedColorSlug, fSlug);
					if (v && v.price_html) {
						priceSlot.innerHTML = sanitizeCurrencyHtml(v.price_html);
					}
				}
			});
		}

		function applyVariation(v) {
			if (!v) return;

			// 1. Populate Hidden Form Variation ID
			const varInput = root.querySelector('#selected-variation-id') || root.querySelector('input[name="variation_id"]');
			if (varInput && v.id) {
				varInput.value = v.id;
			}

			// 2. Price Update (Strict EUR)
			if (mainPriceSpan && v.price_html) {
				mainPriceSpan.innerHTML = sanitizeCurrencyHtml(v.price_html);
			}
			const priceRow = root.querySelector('.filament-price-row');
			if (priceRow && typeof v.price_raw !== 'undefined') {
				priceRow.dataset.priceRaw = v.price_raw;
			}

			// 3. Dynamic Variation Image Switching & Thumbnail Sync
			const mainImg = root.querySelector('#product-main-image') || root.querySelector('.product-gallery__main img');
			if (mainImg) {
				const defaultSrc = mainImg.dataset.defaultSrc || mainImg.src;
				const defaultSrcset = mainImg.dataset.defaultSrcset || '';
				const targetSrc = v.image ? v.image : defaultSrc;
				const targetSrcset = (v.image && v.srcset) ? v.srcset : (!v.image ? defaultSrcset : '');

				if (targetSrc && mainImg.src !== targetSrc) {
					mainImg.style.transition = 'opacity 0.2s ease';
					mainImg.style.opacity = '0.3';
					setTimeout(() => {
						mainImg.src = targetSrc;
						if (targetSrcset) {
							mainImg.setAttribute('srcset', targetSrcset);
						} else {
							mainImg.removeAttribute('srcset');
						}
						mainImg.style.opacity = '1';
					}, 150);
				}

				// Highlight matching thumbnail if in gallery list
				const thumbs = root.querySelectorAll('.product-gallery__thumbs li');
				thumbs.forEach(t => {
					const tUrl = t.dataset.fullUrl;
					if (tUrl && targetSrc && (tUrl === targetSrc || targetSrc.includes(tUrl) || tUrl.includes(targetSrc))) {
						t.classList.add('is-active');
					} else {
						t.classList.remove('is-active');
					}
				});
			}

			// 4. SKU & Summary Note
			const stockNote = root.querySelector('#filament-stock-note') || root.querySelector('.product-stock-row .stock-note');
			if (stockNote && v.sku) {
				stockNote.textContent = 'SKU: ' + v.sku;
			}
			if (variationSummary) {
				const parts = [];
				if (currentColorName) parts.push(currentColorName.toUpperCase());
				if (currentFormatTitle) parts.push(currentFormatTitle.toUpperCase());
				if (v.sku) parts.push(v.sku);
				if (parts.length > 0) {
					variationSummary.textContent = parts.join(' · ');
				}
			}

			// 5. 100% Dynamic Stock Status (Strictly In Stock / Out of Stock / Available on Backorder - NO Tallinn)
			const stockRow = root.querySelector('#filament-stock-row') || root.querySelector('.product-stock-row');
			const stockText = root.querySelector('#filament-stock-text') || (stockRow ? stockRow.querySelector('.stock-text') : null);
			if (stockText && v.stock_text) {
				stockText.textContent = v.stock_text;
			}
			if (stockRow && v.stock_status) {
				stockRow.classList.remove('is-instock', 'is-outofstock', 'is-backorder');
				stockRow.classList.add('is-' + v.stock_status);
			}

			// 6. Add to Basket CTA Conditional State
			if (addToCartBtn) {
				if (v.stock_status === 'outofstock' || v.in_stock === false) {
					addToCartBtn.disabled = true;
					addToCartBtn.classList.add('is-disabled');
					addToCartBtn.dataset.state = 'outofstock';
					if (btnTextSpan) {
						btnTextSpan.textContent = 'Out of Stock';
					}
				} else {
					addToCartBtn.disabled = false;
					addToCartBtn.classList.remove('is-disabled');
					addToCartBtn.dataset.state = 'ready';
					if (btnTextSpan) {
						btnTextSpan.textContent = 'Add to basket';
					}
				}
			}

			// 7. Sticky Bottom Purchase Bar Sync
			const stickyBar = document.querySelector('.sticky-purchase-bar');
			if (stickyBar) {
				const sPrice = stickyBar.querySelector('.sticky-bar-price') || stickyBar.querySelector('small');
				const sThumb = stickyBar.querySelector('.sticky-bar__thumb');
				const sBtn = stickyBar.querySelector('.sticky-bar-cta') || stickyBar.querySelector('.btn');

				if (sPrice && v.price_html) {
					sPrice.innerHTML = `${sanitizeCurrencyHtml(v.price_html)} <small>incl. 24% VAT · sample price</small>`;
				}
				if (sThumb && v.image) {
					sThumb.src = v.image;
				}
				if (sBtn) {
					if (v.stock_status === 'outofstock' || v.in_stock === false) {
						sBtn.disabled = true;
						sBtn.classList.add('is-disabled');
						sBtn.textContent = 'Out of Stock';
					} else {
						sBtn.disabled = false;
						sBtn.classList.remove('is-disabled');
						sBtn.textContent = 'Add to basket';
					}
				}
			}
		}

		// Initial update of format prices
		updateFormatCardPrices();

		// Color Swatches Selection
		swatches.forEach(swatch => {
			swatch.addEventListener('click', function () {
				swatches.forEach(s => s.classList.remove('is-active'));
				this.classList.add('is-active');

				selectedColorSlug = (this.dataset.slug || '').toLowerCase();
				currentColorName = this.dataset.colorName || '';

				if (activeColorSpan) {
					activeColorSpan.textContent = this.dataset.colorDisplay || this.dataset.colorName || '';
					activeColorSpan.classList.remove('is-placeholder');
				}
				if (colorInput) {
					colorInput.value = currentColorName;
				}

				// If product has format cards and none is selected yet, auto-select first format card (Complete Spool)
				if (formatCards.length > 0 && !selectedFormatSlug) {
					const firstCard = formatCards[0];
					firstCard.classList.add('is-active');
					selectedFormatSlug = (firstCard.dataset.format || '').toLowerCase();
					currentFormatTitle = firstCard.dataset.title || '';
					if (formatInput) {
						formatInput.value = currentFormatTitle;
					}
					syncChooseFormatCards(selectedFormatSlug, currentFormatTitle);
				}

				// Update prices shown on format cards for newly picked color
				updateFormatCardPrices();

				// Locate and apply matching variation
				const matchedVar = findMatchingVariation(selectedColorSlug, selectedFormatSlug);
				if (matchedVar) {
					applyVariation(matchedVar);
				} else {
					if (variationSummary && currentColorName) {
						variationSummary.textContent = currentColorName.toUpperCase();
					}
				}
			});
		});

		// Synchronize Choose Format comparison section
		function syncChooseFormatCards(formatSlug, formatTitle) {
			if (!compFormatCards || !compFormatCards.length) return;
			const query = ((formatSlug || '') + ' ' + (formatTitle || '')).toLowerCase();

			compFormatCards.forEach(c => {
				const type = (c.dataset.formatType || '').toLowerCase();
				let isMatch = false;
				if (query.includes('spool') && type.includes('spool')) {
					isMatch = true;
				} else if (query.includes('refill') && type.includes('refill')) {
					isMatch = true;
				}
				c.classList.toggle('is-selected', isMatch);
			});
		}

		// Format Cards Selection in Hero (Complete Spool vs Refill)
		formatCards.forEach(card => {
			card.addEventListener('click', function () {
				formatCards.forEach(c => c.classList.remove('is-active'));
				this.classList.add('is-active');

				selectedFormatSlug = (card.dataset.format || '').toLowerCase();
				currentFormatTitle = card.dataset.title || '';

				if (formatInput) {
					formatInput.value = currentFormatTitle;
				}

				// If a color has already been chosen, apply the variation for (color, format)
				if (selectedColorSlug) {
					const matchedVar = findMatchingVariation(selectedColorSlug, selectedFormatSlug);
					if (matchedVar) {
						applyVariation(matchedVar);
					}
				} else {
					if (variationSummary && currentFormatTitle) {
						variationSummary.textContent = currentFormatTitle.toUpperCase();
					}
				}

				// Sync with Choose Format section
				syncChooseFormatCards(selectedFormatSlug, currentFormatTitle);
			});
		});

		// Two-way synchronization: clicking on Choose Format comparison cards or buttons
		if (compFormatCards && compFormatCards.length) {
			compFormatCards.forEach(card => {
				card.addEventListener('click', function (e) {
					const type = (this.dataset.formatType || '').toLowerCase();

					// Highlight this comparison card
					compFormatCards.forEach(c => c.classList.remove('is-selected'));
					this.classList.add('is-selected');

					// Find matching hero format card and trigger click
					let matchedHeroCard = null;
					formatCards.forEach(hc => {
						const hSlug = (hc.dataset.format || '').toLowerCase();
						const hTitle = (hc.dataset.title || '').toLowerCase();
						if (type.includes('spool') && (hSlug.includes('spool') || hTitle.includes('spool'))) {
							matchedHeroCard = hc;
						} else if (type.includes('refill') && (hSlug.includes('refill') || hTitle.includes('refill'))) {
							matchedHeroCard = hc;
						}
					});

					if (matchedHeroCard) {
						if (!matchedHeroCard.classList.contains('is-active')) {
							matchedHeroCard.click();
						}
					}

					// If the user clicked the action button, smoothly scroll to hero
					if (e.target.closest('.btn-format-action')) {
						const heroSection = document.getElementById('filament-hero') || root.querySelector('.filament-hero');
						if (heroSection) {
							const subnavEl = document.querySelector('.filament-subnav-bar');
							const offset = (subnavEl ? subnavEl.offsetHeight : 52) + 20;
							const topPos = heroSection.getBoundingClientRect().top + window.pageYOffset - offset;
							window.scrollTo({
								top: Math.max(0, topPos),
								behavior: 'smooth'
							});
						}
					}
				});
			});
		}

		// Essential Additions Add Button (Real WooCommerce Cart & Order Sync)
		const additionAddBtns = root.querySelectorAll('.btn-addition-add');
		additionAddBtns.forEach(btn => {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				const card = this.closest('.filament-addition-card');
				if (!card) return;

				const productId = parseInt(this.dataset.productId || card.dataset.productId, 10) || 0;
				const qtyInput = card.querySelector('.addition-quantity input');
				const quantity = qtyInput ? Math.max(1, parseInt(qtyInput.value, 10) || 1) : 1;
				const selectElem = card.querySelector('.addition-select');
				const selectedOption = selectElem ? selectElem.value : '';
				const cardTitle = this.dataset.title || 'Product';

				if (!productId) {
					// Feedback when admin hasn't linked a specific product ID
					const origText = this.textContent.trim();
					this.textContent = 'Added ✓';
					this.style.background = '#047857';
					setTimeout(() => {
						this.textContent = origText;
						this.style.background = '';
					}, 1500);
					return;
				}

				// Real WooCommerce AJAX Add To Cart
				const origText = this.textContent;
				this.classList.add('is-loading');
				this.disabled = true;

				const config = window.woodmartLandingData || {};
				const ajaxUrl = config.ajaxUrl || '/wp-admin/admin-ajax.php';
				const nonce = config.nonce || '';

				const formData = new FormData();
				formData.append('action', 'woodmart_child_add_to_cart');
				formData.append('security', nonce);
				formData.append('product_id', productId);
				formData.append('quantity', quantity);
				if (selectedOption) {
					formData.append('addition_option', selectedOption);
				}

				fetch(ajaxUrl, {
					method: 'POST',
					body: formData
				})
				.then(res => res.text())
				.then(text => {
					this.classList.remove('is-loading');
					this.disabled = false;

					let data = null;
					try {
						data = JSON.parse(text);
					} catch (err) {
						const match = text.match(/\{[\s\S]*\}/);
						if (match) {
							try { data = JSON.parse(match[0]); } catch (e) {}
						}
					}

					const cartUrl = (config && config.cartUrl) || '#';

					if (data && data.success) {
						const resData = (data && data.data) ? data.data : data;
						const cartCount = (typeof resData.cart_count !== 'undefined') ? resData.cart_count : data.cart_count;
						if (typeof cartCount !== 'undefined') {
							document.querySelectorAll('.wd-cart-number, .whb-cart-number, .woodmart-cart-number, .cart-count, .site-header__tools .cart-count').forEach(b => {
								b.textContent = cartCount;
							});
						}

						this.textContent = 'Added ✓';
						this.style.background = '#047857';
						setTimeout(() => {
							this.textContent = origText;
							this.style.background = '';
						}, 2000);

						// Show toast notice
						showNotice(`✓ Added ${cardTitle} to basket! <a href="${cartUrl}">View basket →</a>`, false);

						// Trigger fragments
						if (window.jQuery) {
							try {
								const fragments = resData.fragments || data.fragments || {};
								const cartHash = resData.cart_hash || data.cart_hash || '';
								if (fragments && typeof fragments === 'object') {
									window.jQuery.each(fragments, function(k, v) {
										window.jQuery(k).replaceWith(v);
									});
								}
								window.jQuery(document.body).trigger('wc_fragment_refresh');
								window.jQuery(document.body).trigger('added_to_cart', [fragments, cartHash, window.jQuery(btn)]);
							} catch (jqErr) {}
						}
					} else {
						const errorMsg = (data && data.data && data.data.message) ? data.data.message : 'Could not add to basket.';
						showNotice(errorMsg, true);
					}
				})
				.catch(err => {
					this.classList.remove('is-loading');
					this.disabled = false;
					showNotice('Network error. Please try again.', true);
				});
			});
		});
	}

	/* ==========================================================================
	   FILAMENT: STICKY SUBNAV SMOOTH SCROLL & SCROLLSPY + COLOR PALETTE SYNC
	   ========================================================================== */
	(function initFilamentInteractiveSections() {
		// 1. Subnav Smooth Scroll & Scrollspy (Matching 3D Printer Header Docking)
		const subnav = document.querySelector('.filament-subnav-bar');
		if (subnav) {
			const oldSpacer = document.getElementById('filament-subnav-spacer');
			if (oldSpacer) oldSpacer.remove();

			const subnavLinksUl = subnav.querySelector('.filament-subnav-links');
			const links = subnav.querySelectorAll('.filament-subnav-link');

			function getHeaderOffset() {
				const adminBar = document.getElementById('wpadminbar');
				let adminOffset = 0;
				if (adminBar) {
					const abStyle = window.getComputedStyle(adminBar);
					if (abStyle.display !== 'none' && abStyle.visibility !== 'hidden' && abStyle.position === 'fixed') {
						adminOffset = adminBar.offsetHeight || 0;
					}
				}

				// Target the specific sticky row in Woodmart (excluding multi-row wrappers like .whb-header)
				const stickyRow = document.querySelector('.whb-clone.whb-sticked') ||
				                  document.querySelector('.whb-clone') ||
				                  document.querySelector('.whb-header.whb-sticked .whb-sticky-row') ||
				                  document.querySelector('.whb-header.whb-sticked .whb-main-header') ||
				                  document.querySelector('.whb-header.whb-sticked .whb-general-header') ||
				                  document.querySelector('.whb-sticky-row') ||
				                  document.querySelector('.whb-main-header') ||
				                  document.querySelector('.whb-general-header');

				if (stickyRow) {
					const rect = stickyRow.getBoundingClientRect();
					const style = window.getComputedStyle(stickyRow);
					const isFixedOrSticky = style.position === 'fixed' || style.position === 'sticky' ||
					                        (stickyRow.closest('.whb-sticked') && window.getComputedStyle(stickyRow.closest('.whb-sticked')).position === 'fixed');

					if (isFixedOrSticky && rect.height > 0 && rect.top >= 0 && rect.top <= adminOffset + 15) {
						return Math.round(rect.bottom);
					}

					if (rect.height > 0) {
						return Math.round(adminOffset + rect.height);
					}
				}

				const genericSticky = document.querySelector('.whb-sticked:not(.whb-header)');
				if (genericSticky && genericSticky.offsetHeight > 0) {
					return Math.round(adminOffset + genericSticky.offsetHeight);
				}

				const isMobile = window.innerWidth <= 1024;
				const defaultHeight = isMobile ? 60 : 64;
				return Math.round(adminOffset + defaultHeight);
			}

			function updateStickyTop() {
				const offset = getHeaderOffset();
				document.documentElement.style.setProperty('--filament-subnav-top', offset + 'px');
				subnav.style.setProperty('top', offset + 'px', 'important');
			}
			updateStickyTop();
			window.addEventListener('resize', updateStickyTop);
			window.addEventListener('scroll', updateStickyTop, { passive: true });
			window.addEventListener('wdHeaderBuilderStickyChanged', updateStickyTop);
			document.addEventListener('wdHeaderBuilderStickyChanged', updateStickyTop);

			function centerActiveTab(activeLink) {
				if (!activeLink || !subnavLinksUl) return;
				if (subnavLinksUl.scrollWidth > subnavLinksUl.clientWidth) {
					const targetLi = activeLink.closest('li') || activeLink;
					const ulRect = subnavLinksUl.getBoundingClientRect();
					const liRect = targetLi.getBoundingClientRect();
					const currentScroll = subnavLinksUl.scrollLeft;
					const relativeLeft = liRect.left - ulRect.left;
					const targetScroll = currentScroll + relativeLeft - (ulRect.width / 2) + (liRect.width / 2);
					subnavLinksUl.scrollTo({
						left: Math.max(0, targetScroll),
						behavior: 'smooth'
					});
				}
			}

			// Handle link click with sticky offset
			links.forEach(link => {
				link.addEventListener('click', function (e) {
					const targetId = this.getAttribute('href');
					if (!targetId || targetId === '#' || !targetId.startsWith('#')) return;

					const targetEl = document.querySelector(targetId);
					if (targetEl) {
						e.preventDefault();
						const subnavHeight = subnav.offsetHeight || 48;
						const offset = getHeaderOffset();
						const topPos = targetEl.getBoundingClientRect().top + window.pageYOffset - (offset + subnavHeight + 10);
						window.scrollTo({
							top: Math.max(0, topPos),
							behavior: 'smooth'
						});

						links.forEach(l => l.classList.remove('is-active'));
						this.classList.add('is-active');
						centerActiveTab(this);
					}
				});
			});

			// Scrollspy to highlight active link & pinned shadow
			let isScrolling = false;
			window.addEventListener('scroll', function () {
				if (!isScrolling) {
					window.requestAnimationFrame(() => {
						const offset = getHeaderOffset();
						const subnavHeight = subnav.offsetHeight || 48;
						const scrollY = window.pageYOffset;
						const fromTop = scrollY + offset + subnavHeight + 30;

						let currentSectionId = '';
						links.forEach(link => {
							const targetId = link.getAttribute('href');
							if (targetId && targetId.startsWith('#')) {
								const sec = document.querySelector(targetId);
								if (sec) {
									const top = sec.offsetTop;
									const height = sec.offsetHeight;
									if (fromTop >= top && fromTop < top + height) {
										currentSectionId = targetId;
									}
								}
							}
						});

						if (currentSectionId) {
							links.forEach(l => {
								const isCurrent = l.getAttribute('href') === currentSectionId;
								if (isCurrent && !l.classList.contains('is-active')) {
									l.classList.add('is-active');
									centerActiveTab(l);
								} else if (!isCurrent && l.classList.contains('is-active')) {
									l.classList.remove('is-active');
								}
							});
						}

						subnav.classList.toggle('is-pinned', scrollY > 200);

						isScrolling = false;
					});
					isScrolling = true;
				}
			}, { passive: true });

			// Center initial active tab on page load
			const initialActive = subnav.querySelector('.filament-subnav-link.is-active');
			if (initialActive) {
				centerActiveTab(initialActive);
				setTimeout(() => centerActiveTab(initialActive), 300);
			}
		}

		// 2. Color Showcase Interactive Palette
		const paletteCard = document.querySelector('.filament-palette-card');
		if (paletteCard) {
			const dots = paletteCard.querySelectorAll('.filament-palette-dot');
			const statusSwatch = document.getElementById('filament-palette-status-swatch');
			const statusName = document.getElementById('filament-palette-status-name');

			dots.forEach(dot => {
				dot.addEventListener('click', function () {
					dots.forEach(d => d.classList.remove('is-active'));
					this.classList.add('is-active');

					const name = this.getAttribute('data-name') || '';
					const hex = this.getAttribute('data-hex') || '#111827';

					if (statusSwatch) {
						statusSwatch.style.backgroundColor = hex;
					}
					if (statusName) {
						statusName.textContent = name;
					}

					// Sync with hero color swatches if present
					const heroSwatches = document.querySelectorAll('.filament-color-swatch-item');
					heroSwatches.forEach(hs => {
						const hsHex = hs.getAttribute('data-hex') || '';
						if (hsHex && hsHex.toLowerCase() === hex.toLowerCase()) {
							hs.click();
						}
					});
				});
			});
		}

		// 4. CTA Banner Shop button smooth scroll
		const ctaShopBtn = document.querySelector('.btn-cta-shop');
		if (ctaShopBtn) {
			ctaShopBtn.addEventListener('click', function (e) {
				const href = this.getAttribute('href');
				if (href && href.startsWith('#')) {
					e.preventDefault();
					const targetEl = document.querySelector(href) || document.getElementById('choose-format') || document.getElementById('filament-hero');
					if (targetEl) {
						targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
					}
				}
			});
		}
	})();

	/* ==========================================================================
	   9. ACCESSORIES LANDING PAGE INTERACTIONS
	   ========================================================================== */
	function initAccessoriesInteractions() {
		const root = document.querySelector('.accessories-landing-root');
		if (!root) return;

		// 1. FAQ Accordion Toggle
		const faqHeaders = root.querySelectorAll('.accessories-faq-accordion .faq-accordion-header');
		faqHeaders.forEach(header => {
			header.addEventListener('click', function () {
				const item = this.closest('.faq-accordion-item');
				if (!item) return;

				const isOpen = item.classList.contains('is-open');
				const body = item.querySelector('.faq-accordion-body');

				// Close other open items
				const allItems = root.querySelectorAll('.accessories-faq-accordion .faq-accordion-item');
				allItems.forEach(otherItem => {
					if (otherItem !== item && otherItem.classList.contains('is-open')) {
						otherItem.classList.remove('is-open');
						const otherBtn = otherItem.querySelector('.faq-accordion-header');
						if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
						const otherBody = otherItem.querySelector('.faq-accordion-body');
						if (otherBody) otherBody.style.display = 'none';
					}
				});

				if (isOpen) {
					item.classList.remove('is-open');
					this.setAttribute('aria-expanded', 'false');
					if (body) body.style.display = 'none';
				} else {
					item.classList.add('is-open');
					this.setAttribute('aria-expanded', 'true');
					if (body) body.style.display = 'block';
				}
			});
		});

		// 2. Variations Handling
		const matrixEl = document.getElementById('accessories-variation-matrix');
		let matrix = [];
		if (matrixEl) {
			try {
				matrix = JSON.parse(matrixEl.textContent || '[]');
			} catch (e) {
				matrix = [];
			}
		}

		const pillButtons = root.querySelectorAll('.accessories-pill-btn');
		const variationIdInput = root.querySelector('#selected-accessories-variation-id') || root.querySelector('input[name="variation_id"]');
		const summarySpan = root.querySelector('#accessories-variation-summary');
		const currentPriceEls = root.querySelectorAll('.accessories-current-price');
		const stockTextEl = root.querySelector('#acc-stock-status-text');
		const stockNoteEl = root.querySelector('#acc-stock-note-text');
		const mainImg = root.querySelector('#product-main-image');

		// Sticky bar elements
		const stickyBar = document.getElementById('accessories-sticky-bar') || root.querySelector('.accessories-sticky-bar');
		const stickyThumb = document.getElementById('sticky-accessories-thumb');
		const stickyBadge = document.getElementById('sticky-accessories-var-badge');
		const stickyCta = root.querySelector('.accessories-sticky-cta');

		const totalAttrGroups = root.querySelectorAll('.accessories-attr-group').length;
		const defaultPriceHtml = (currentPriceEls[0] && currentPriceEls[0].innerHTML) ? currentPriceEls[0].innerHTML : '';
		const stickyPriceEls = document.querySelectorAll('.accessories-sticky-price-val');
		const defaultMainImgSrc = (mainImg && mainImg.src) ? mainImg.src : '';
		const defaultStockText = stockTextEl ? stockTextEl.textContent : '';
		const defaultStockNote = stockNoteEl ? stockNoteEl.textContent : '';

		function getSelectedAttributes() {
			const selected = {};
			const groups = root.querySelectorAll('.accessories-attr-group');
			groups.forEach(group => {
				const activeBtn = group.querySelector('.accessories-pill-btn.is-active');
				const key = group.dataset.attrKey;
				if (activeBtn && key) {
					selected[key] = activeBtn.dataset.attrVal;
				}
			});
			return selected;
		}

		function getSelectedAttributeNames() {
			const names = [];
			const groups = root.querySelectorAll('.accessories-attr-group');
			groups.forEach(group => {
				const activeBtn = group.querySelector('.accessories-pill-btn.is-active');
				if (activeBtn && activeBtn.dataset.attrName) {
					names.push(activeBtn.dataset.attrName);
				}
			});
			return names;
		}

		function findMatchingVariation(selectedAttrs) {
			if (!matrix.length) return null;
			const selectedKeys = Object.keys(selectedAttrs);
			if (totalAttrGroups > 0 && selectedKeys.length < totalAttrGroups) {
				return null;
			}

			return matrix.find(v => {
				const vAttrs = v.attributes || {};
				for (const [key, val] of Object.entries(selectedAttrs)) {
					if (vAttrs[key] && vAttrs[key] !== '' && vAttrs[key].toLowerCase() !== val.toLowerCase()) {
						return false;
					}
				}
				return true;
			}) || null;
		}

		function syncVariationState() {
			const selectedAttrs = getSelectedAttributes();
			const names = getSelectedAttributeNames();
			const isComplete = totalAttrGroups > 0 ? (Object.keys(selectedAttrs).length >= totalAttrGroups) : true;
			const matched = isComplete ? findMatchingVariation(selectedAttrs) : null;

			if (matched) {
				if (variationIdInput) {
					variationIdInput.value = matched.id;
				}

				// Price update
				currentPriceEls.forEach(el => {
					if (matched.price_html) {
						el.innerHTML = matched.price_html;
					}
				});
				stickyPriceEls.forEach(el => {
					if (matched.price_html) {
						el.innerHTML = matched.price_html;
					}
				});

				// Summary indicator
				if (summarySpan) {
					const parts = [...names];
					if (matched.sku) {
						parts.push('SKU: ' + matched.sku);
					}
					summarySpan.textContent = parts.join(' · ') || '—';
				}

				// Stock update
				if (stockTextEl) {
					if (matched.in_stock) {
						stockTextEl.textContent = 'In Stock — Tallinn';
						if (stockNoteEl && matched.sku) {
							stockNoteEl.textContent = 'SKU: ' + matched.sku + ' · Dispatched in 24h';
						}
					} else {
						stockTextEl.textContent = 'Backorder / Out of stock';
						if (stockNoteEl) {
							stockNoteEl.textContent = 'Special order item';
						}
					}
				}

				// Image update
				if (matched.image && mainImg) {
					mainImg.style.opacity = '0.4';
					setTimeout(() => {
						mainImg.src = matched.image;
						mainImg.style.opacity = '1';
					}, 150);

					// Sync left gallery active thumb if matching URL
					const thumbs = root.querySelectorAll('.product-gallery__thumbs li');
					thumbs.forEach(t => {
						const tUrl = t.dataset.fullUrl || '';
						if (tUrl && matched.image.includes(tUrl.split('/').pop())) {
							thumbs.forEach(th => th.classList.remove('is-active'));
							t.classList.add('is-active');
						}
					});
				}

				// Sticky Bar update
				if (stickyBadge) {
					stickyBadge.textContent = names.join(' · ');
					stickyBadge.style.display = 'inline-block';
				}
				if (stickyThumb && matched.image) {
					stickyThumb.src = matched.image;
				}
			} else {
				// No variation or incomplete selection
				if (variationIdInput) {
					variationIdInput.value = '';
				}

				// Restore default price
				if (defaultPriceHtml) {
					currentPriceEls.forEach(el => {
						el.innerHTML = defaultPriceHtml;
					});
					stickyPriceEls.forEach(el => {
						el.innerHTML = defaultPriceHtml;
					});
				}

				// Summary indicator
				if (summarySpan) {
					summarySpan.textContent = names.length > 0 ? names.join(' · ') : '—';
				}

				// Stock update
				if (stockTextEl && defaultStockText) {
					stockTextEl.textContent = defaultStockText;
				}
				if (stockNoteEl && defaultStockNote) {
					stockNoteEl.textContent = defaultStockNote;
				}

				// Main image
				if (mainImg && defaultMainImgSrc && !mainImg.src.includes(defaultMainImgSrc.split('/').pop())) {
					mainImg.src = defaultMainImgSrc;
				}

				// Sticky bar reset
				if (stickyBadge) {
					stickyBadge.textContent = '';
					stickyBadge.style.display = 'none';
				}
				if (stickyThumb && defaultMainImgSrc) {
					stickyThumb.src = defaultMainImgSrc;
				}
			}
		}

		pillButtons.forEach(btn => {
			btn.addEventListener('click', function () {
				const group = this.closest('.accessories-attr-group');
				if (!group) return;

				// Toggle active in this group
				group.querySelectorAll('.accessories-pill-btn').forEach(b => b.classList.remove('is-active'));
				this.classList.add('is-active');

				// Update selected label
				const labelVal = group.querySelector('.accessories-attr-selected-value');
				if (labelVal) {
					labelVal.textContent = this.dataset.attrName || '';
				}

				// Update hidden input
				const hiddenInput = group.querySelector('.accessories-hidden-attr');
				if (hiddenInput) {
					hiddenInput.value = this.dataset.attrVal || '';
				}

				syncVariationState();
			});
		});

		// Initial sync
		if (matrix.length > 0) {
			syncVariationState();
		}

		// 3. Sticky Bottom Bar Scroll Visibility & CTA proxy
		if (stickyBar) {
			const heroEl = document.getElementById('accessories-hero') || root.querySelector('.accessories-hero');
			function checkStickyBar() {
				if (!heroEl) return;
				const heroBottom = heroEl.getBoundingClientRect().bottom;
				if (heroBottom < 100) {
					stickyBar.classList.add('is-visible');
				} else {
					stickyBar.classList.remove('is-visible');
				}
			}

			window.addEventListener('scroll', checkStickyBar, { passive: true });
			checkStickyBar();

			if (stickyCta) {
				stickyCta.addEventListener('click', function (e) {
					e.preventDefault();
					const heroAddBtn = root.querySelector('.accessories-btn-add-to-cart');
					if (heroAddBtn) {
						heroAddBtn.click();
					}
				});
			}
		}
	}

	/* ==========================================================================
	   10. LASER & CRAFTING LANDING CONTROLLER
	   ========================================================================== */
	function initLaserCraftingInteractions() {
		const root = document.querySelector('.laser-crafting-landing-root');
		if (!root) return;

		// 1. Dynamic Variations Sync (Variable WooCommerce Products)
		const lcVarRadios = root.querySelectorAll('input[name="lc_variation_choice"]');
		const lcHiddenVarInput = root.querySelector('#selected-variation-id');
		const lcSkuDisplay = root.querySelector('#lc-selected-sku');
		const lcPriceDisplay = root.querySelector('.product-price');
		const lcStickyPrice = root.querySelector('#lc-sticky-price');
		const lcStickyConfig = root.querySelector('#lc-sticky-config');
		const lcMainImg = root.querySelector('#product-main-image');
		const lcStickyThumb = root.querySelector('#lc-sticky-thumb-img');

		lcVarRadios.forEach(radio => {
			radio.addEventListener('change', function () {
				const varId = this.value;
				const title = this.dataset.title || '';
				const priceHtml = this.dataset.priceHtml || '';
				const sku = this.dataset.sku || '';
				const imageUrl = this.dataset.image || '';

				if (lcHiddenVarInput) lcHiddenVarInput.value = varId;
				if (lcSkuDisplay && sku) lcSkuDisplay.textContent = sku;

				if (lcPriceDisplay && priceHtml) {
					lcPriceDisplay.innerHTML = sanitizeCurrencyHtml(priceHtml);
				}
				if (lcStickyPrice && priceHtml) {
					lcStickyPrice.innerHTML = sanitizeCurrencyHtml(priceHtml);
				}
				if (lcStickyConfig && title) {
					lcStickyConfig.textContent = title;
				}

				// Highlight selected option label
				lcVarRadios.forEach(r => {
					const opt = r.closest('.option');
					if (opt) opt.classList.toggle('is-selected', r === radio);
				});

				// Swap main gallery image if variation image exists
				if (imageUrl && lcMainImg) {
					lcMainImg.style.transition = 'opacity 0.2s ease';
					lcMainImg.style.opacity = '0.3';
					setTimeout(() => {
						lcMainImg.src = imageUrl;
						lcMainImg.style.opacity = '1';
						if (lcStickyThumb) lcStickyThumb.src = imageUrl;
					}, 150);
				}
			});
		});

		// 2. Essential Additions (Steppers & Add Buttons)
		const additionCards = root.querySelectorAll('.lc-additions-section .addition-card');
		additionCards.forEach(card => {
			const qtyInput = card.querySelector('.addition-card__qty input');
			const qtyBtns = card.querySelectorAll('.addition-card__qty button[data-step]');
			const addBtn = card.querySelector('.addition-card__btn-add');
			const title = card.querySelector('.addition-card__title') ? card.querySelector('.addition-card__title').textContent.trim() : 'Item';

			qtyBtns.forEach(btn => {
				btn.addEventListener('click', function () {
					const step = parseInt(this.getAttribute('data-step'), 10) || 0;
					const current = Math.max(1, parseInt(qtyInput ? qtyInput.value : 1, 10) || 1);
					if (qtyInput) qtyInput.value = Math.max(1, current + step);
				});
			});

			if (addBtn) {
				addBtn.addEventListener('click', function (e) {
					e.preventDefault();
					const origText = this.innerHTML;
					this.innerHTML = '<span>Added ✓</span>';
					this.style.background = '#047857';
					showNotice(`✓ Added ${title} to sample basket!`, false);
					setTimeout(() => {
						this.innerHTML = origText;
						this.style.background = '';
					}, 2000);
				});
			}
		});

		// 3. Sticky In-Page Sub-Navigation & ScrollSpy (Image 2)
		const subnavBar = root.querySelector('#lc-subnav');
		if (subnavBar) {
			const subnavLinks = subnavBar.querySelectorAll('.lc-subnav-link');
			const sections = [
				{ id: 'lc-overview', el: document.getElementById('lc-overview') },
				{ id: 'lc-dive-in', el: document.getElementById('lc-dive-in') },
				{ id: 'lc-specifications', el: document.getElementById('lc-specifications') },
				{ id: 'lc-faq', el: document.getElementById('lc-faq') }
			];

			function getHeaderOffset() {
				const adminBar = document.getElementById('wpadminbar');
				let adminOffset = 0;
				if (adminBar) {
					const abStyle = window.getComputedStyle(adminBar);
					if (abStyle.display !== 'none' && abStyle.visibility !== 'hidden' && abStyle.position === 'fixed') {
						adminOffset = adminBar.offsetHeight || 0;
					}
				}

				// Target the specific sticky row in Woodmart (excluding multi-row wrappers like .whb-header which include top-bar)
				const stickyRow = document.querySelector('.whb-clone.whb-sticked') ||
				                  document.querySelector('.whb-clone') ||
				                  document.querySelector('.whb-header.whb-sticked .whb-sticky-row') ||
				                  document.querySelector('.whb-header.whb-sticked .whb-main-header') ||
				                  document.querySelector('.whb-header.whb-sticked .whb-general-header') ||
				                  document.querySelector('.whb-sticky-row') ||
				                  document.querySelector('.whb-main-header') ||
				                  document.querySelector('.whb-general-header');

				if (stickyRow) {
					const rect = stickyRow.getBoundingClientRect();
					const style = window.getComputedStyle(stickyRow);
					const isFixedOrSticky = style.position === 'fixed' || style.position === 'sticky' ||
					                        (stickyRow.closest('.whb-sticked') && window.getComputedStyle(stickyRow.closest('.whb-sticked')).position === 'fixed');

					// When the header row is actively sticky at the top, its viewport bottom is the exact docking coordinate
					if (isFixedOrSticky && rect.height > 0 && rect.top >= 0 && rect.top <= adminOffset + 15) {
						return Math.round(rect.bottom);
					}

					if (rect.height > 0) {
						return Math.round(adminOffset + rect.height);
					}
				}

				const genericSticky = document.querySelector('.whb-sticked:not(.whb-header)');
				if (genericSticky && genericSticky.offsetHeight > 0) {
					return Math.round(adminOffset + genericSticky.offsetHeight);
				}

				const isMobile = window.innerWidth <= 1024;
				const defaultHeight = isMobile ? 60 : 64;
				return Math.round(adminOffset + defaultHeight);
			}

			function updateStickyTop() {
				const offset = getHeaderOffset();
				document.documentElement.style.setProperty('--lc-subnav-top', offset + 'px');
				subnavBar.style.setProperty('top', offset + 'px', 'important');
			}
			updateStickyTop();
			window.addEventListener('resize', updateStickyTop);
			window.addEventListener('scroll', updateStickyTop, { passive: true });
			window.addEventListener('wdHeaderBuilderStickyChanged', updateStickyTop);
			document.addEventListener('wdHeaderBuilderStickyChanged', updateStickyTop);

			function getNavOffset() {
				const headerH = getHeaderOffset();
				const subnavH = subnavBar ? subnavBar.offsetHeight : 50;
				return headerH + subnavH + 16;
			}

			// Smooth scroll on click
			subnavLinks.forEach(link => {
				link.addEventListener('click', function (e) {
					const href = this.getAttribute('href');
					if (!href || !href.startsWith('#')) return;
					const target = document.querySelector(href);
					if (target) {
						e.preventDefault();
						const targetTop = target.getBoundingClientRect().top + window.pageYOffset - getNavOffset();
						window.scrollTo({
							top: Math.max(0, targetTop),
							behavior: 'smooth'
						});
						subnavLinks.forEach(l => l.classList.remove('is-active'));
						this.classList.add('is-active');
					}
				});
			});

			// ScrollSpy
			function handleSubnavScrollSpy() {
				const scrollPos = window.pageYOffset + getNavOffset() + 60;
				let currentSectionId = '';

				sections.forEach(sec => {
					if (sec.el) {
						const top = sec.el.offsetTop;
						const height = sec.el.offsetHeight;
						if (scrollPos >= top && scrollPos < top + height) {
							currentSectionId = sec.id;
						}
					}
				});

				if (currentSectionId) {
					subnavLinks.forEach(link => {
						const href = link.getAttribute('href');
						link.classList.toggle('is-active', href === '#' + currentSectionId);
					});
				}
			}

			window.addEventListener('scroll', handleSubnavScrollSpy, { passive: true });
			handleSubnavScrollSpy();
		}

		// 3b. Video Popup Modal for Overview Banner ("Watch Video" button)
		const videoBtn = root.querySelector('.lc-btn-watch-video');
		const videoModal = document.getElementById('lc-video-modal');
		if (videoBtn && videoModal) {
			const modalIframe = videoModal.querySelector('#lc-modal-iframe');
			const modalClose = videoModal.querySelector('.lc-video-modal-close');
			const modalBackdrop = videoModal.querySelector('.lc-video-modal-backdrop');

			function formatVideoEmbed(url) {
				if (!url) return '';
				// YouTube match
				const ytMatch = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i);
				if (ytMatch && ytMatch[1]) {
					return 'https://www.youtube.com/embed/' + ytMatch[1] + '?autoplay=1&rel=0&modestbranding=1';
				}
				// Vimeo match
				const vimeoMatch = url.match(/(?:vimeo\.com\/)(\d+)/i);
				if (vimeoMatch && vimeoMatch[1]) {
					return 'https://player.vimeo.com/video/' + vimeoMatch[1] + '?autoplay=1';
				}
				return url;
			}

			function openVideoModal(e) {
				if (e) e.preventDefault();
				const url = videoBtn.getAttribute('data-video-url') || videoBtn.getAttribute('href');
				const embedUrl = formatVideoEmbed(url);
				if (modalIframe && embedUrl) {
					modalIframe.setAttribute('src', embedUrl);
				}
				videoModal.classList.add('is-open');
				videoModal.setAttribute('aria-hidden', 'false');
				document.body.style.overflow = 'hidden';
			}

			function closeVideoModal() {
				videoModal.classList.remove('is-open');
				videoModal.setAttribute('aria-hidden', 'true');
				if (modalIframe) {
					modalIframe.setAttribute('src', '');
				}
				document.body.style.overflow = '';
			}

			videoBtn.addEventListener('click', openVideoModal);
			if (modalClose) modalClose.addEventListener('click', closeVideoModal);
			if (modalBackdrop) modalBackdrop.addEventListener('click', closeVideoModal);

			window.addEventListener('keydown', function (e) {
				if (e.key === 'Escape' && videoModal.classList.contains('is-open')) {
					closeVideoModal();
				}
			});
		}

		// 4. Community Creations Slider (Image 4)
		const sliderTrack = root.querySelector('#lc-slider-track');
		const sliderDots = root.querySelectorAll('#lc-slider-dots .lc-dot');
		const slideItems = root.querySelectorAll('.lc-slide-item');

		if (sliderTrack && sliderDots.length && slideItems.length) {
			function updateActiveDot(idx) {
				sliderDots.forEach((dot, i) => {
					dot.classList.toggle('is-active', i === idx);
				});
			}

			sliderDots.forEach(dot => {
				dot.addEventListener('click', function () {
					const idx = parseInt(this.getAttribute('data-slide'), 10) || 0;
					const targetSlide = slideItems[idx];
					if (targetSlide) {
						const scrollLeft = targetSlide.offsetLeft - sliderTrack.offsetLeft;
						sliderTrack.scrollTo({
							left: scrollLeft,
							behavior: 'smooth'
						});
						updateActiveDot(idx);
					}
				});
			});

			// Update dot on scroll
			let scrollTimer = null;
			sliderTrack.addEventListener('scroll', function () {
				if (scrollTimer) clearTimeout(scrollTimer);
				scrollTimer = setTimeout(() => {
					const trackScroll = sliderTrack.scrollLeft;
					let closestIdx = 0;
					let minDiff = Infinity;
					slideItems.forEach((item, i) => {
						const diff = Math.abs((item.offsetLeft - sliderTrack.offsetLeft) - trackScroll);
						if (diff < minDiff) {
							minDiff = diff;
							closestIdx = i;
						}
					});
					updateActiveDot(closestIdx);
				}, 60);
			}, { passive: true });

			// Drag to scroll
			let isDown = false;
			let startX = 0;
			let scrollLeft = 0;

			sliderTrack.addEventListener('mousedown', (e) => {
				isDown = true;
				sliderTrack.classList.add('is-dragging');
				startX = e.pageX - sliderTrack.offsetLeft;
				scrollLeft = sliderTrack.scrollLeft;
			});
			window.addEventListener('mouseup', () => {
				isDown = false;
				if (sliderTrack) sliderTrack.classList.remove('is-dragging');
			});
			sliderTrack.addEventListener('mousemove', (e) => {
				if (!isDown) return;
				e.preventDefault();
				const x = e.pageX - sliderTrack.offsetLeft;
				const walk = (x - startX) * 1.5;
				sliderTrack.scrollLeft = scrollLeft - walk;
			});
		}

		// 5. Modular Add-ons Image Accordion (Image 2 Top)
		const accordionWrap = root.querySelector('#lc-modular-accordion');
		if (accordionWrap) {
			const expandCards = accordionWrap.querySelectorAll('.lc-expand-card');
			expandCards.forEach(card => {
				card.addEventListener('mouseenter', function () {
					expandCards.forEach(c => c.classList.remove('is-expanded'));
					this.classList.add('is-expanded');
				});
				card.addEventListener('click', function () {
					expandCards.forEach(c => c.classList.remove('is-expanded'));
					this.classList.add('is-expanded');
				});
			});

			accordionWrap.addEventListener('mouseleave', function () {
				expandCards.forEach(c => c.classList.remove('is-expanded'));
				const defaultCard = accordionWrap.querySelector('[data-card-id="decal-cut"]') || expandCards[1] || expandCards[0];
				if (defaultCard) defaultCard.classList.add('is-expanded');
			});
		}

		// 6. Stability & Motion Tabs (Switches Upper Visuals AND Lower Descriptions)
		const stabTabBtns = root.querySelectorAll('.lc-stab-tab-btn');
		const stabPanels = root.querySelectorAll('.lc-stab-panel');
		const viewVibration = root.querySelector('#lc-stab-view-vibration');
		const viewDamper = root.querySelector('#lc-stab-view-damper');

		stabTabBtns.forEach(btn => {
			btn.addEventListener('click', function () {
				const tabType = this.getAttribute('data-tab') || (this.getAttribute('data-stab-target') && this.getAttribute('data-stab-target').includes('damper') ? 'damper' : 'vibration');

				stabTabBtns.forEach(b => {
					b.classList.remove('is-active');
					b.setAttribute('aria-selected', 'false');
				});
				this.classList.add('is-active');
				this.setAttribute('aria-selected', 'true');

				// Switch upper section visual
				if (tabType === 'damper') {
					if (viewVibration) {
						viewVibration.classList.remove('is-active');
						viewVibration.style.display = 'none';
					}
					if (viewDamper) {
						viewDamper.classList.add('is-active');
						viewDamper.style.display = 'block';
					}
				} else {
					if (viewDamper) {
						viewDamper.classList.remove('is-active');
						viewDamper.style.display = 'none';
					}
					if (viewVibration) {
						viewVibration.classList.add('is-active');
						viewVibration.style.display = 'block';
					}
				}

				// Switch lower description panel
				stabPanels.forEach(p => {
					p.classList.remove('is-active');
					p.style.display = 'none';
				});

				const targetPanel = root.querySelector(`#lc-stab-panel-${tabType}`);
				if (targetPanel) {
					targetPanel.classList.add('is-active');
					targetPanel.style.display = 'block';
				}
			});
		});

		// 6b. Autopilot Hover-Expanding Image Cards (Item 3)
		const autoAccordion = root.querySelector('#lc-autopilot-accordion');
		if (autoAccordion) {
			const autoCards = autoAccordion.querySelectorAll('.lc-auto-card');
			autoCards.forEach(card => {
				card.addEventListener('mouseenter', function () {
					autoCards.forEach(c => c.classList.remove('is-expanded'));
					this.classList.add('is-expanded');
				});
				card.addEventListener('click', function () {
					autoCards.forEach(c => c.classList.remove('is-expanded'));
					this.classList.add('is-expanded');
				});
			});

			autoAccordion.addEventListener('mouseleave', function () {
				autoCards.forEach(c => c.classList.remove('is-expanded'));
				const defaultCard = autoAccordion.querySelector('[data-card-id="filament-grind"]') || autoCards[1] || autoCards[0];
				if (defaultCard) defaultCard.classList.add('is-expanded');
			});
		}

		// 6c. Unboxing Video Play Button Trigger (Item 5)
		const videoBox = root.querySelector('#lc-unboxing-video-player');
		if (videoBox) {
			const playBtn = videoBox.querySelector('.lc-video-play-btn');
			const ytBox = videoBox.querySelector('.lc-yt-player-box');
			if (playBtn && ytBox) {
				playBtn.addEventListener('click', function (e) {
					e.preventDefault();
					const ytId = ytBox.getAttribute('data-yt-id');
					if (ytId) {
						ytBox.innerHTML = `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${ytId}?autoplay=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute;inset:0;width:100%;height:100%;border-radius:18px;"></iframe>`;
					}
				});
			}
		}

		// 7. Technical Specifications Collapsible Toggle
		const specsToggleBtn = root.querySelector('#lc-specs-toggle-btn');
		const specsCard = root.querySelector('.lc-specs-card');
		if (specsToggleBtn && specsCard) {
			specsToggleBtn.addEventListener('click', function () {
				const isExpanded = specsCard.classList.toggle('is-expanded');
				const toggleText = this.querySelector('.lc-toggle-text');
				if (toggleText) {
					toggleText.textContent = isExpanded ? 'Collapse specifications' : 'Show all specifications';
				}
				const svg = this.querySelector('svg');
				if (svg) {
					svg.style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
				}
			});
		}

		// 8. FAQ Accordion
		const faqQuestions = root.querySelectorAll('.lc-faq-question');
		faqQuestions.forEach(btn => {
			btn.addEventListener('click', function () {
				const item = this.closest('.lc-faq-item');
				if (!item) return;
				const isOpen = item.classList.contains('is-open');
				const answer = item.querySelector('.lc-faq-answer');

				if (isOpen) {
					item.classList.remove('is-open');
					this.setAttribute('aria-expanded', 'false');
					if (answer) answer.style.display = 'none';
				} else {
					item.classList.add('is-open');
					this.setAttribute('aria-expanded', 'true');
					if (answer) answer.style.display = 'block';
				}
			});
		});

		// 9. Sticky Bottom Bar Scroll Trigger & Purchase Proxy
		const stickyBar = root.querySelector('#lc-sticky-bar');
		const heroSection = document.getElementById('lc-hero') || root.querySelector('.lc-product-hero');
		const heroQtyInput = root.querySelector('.product-hero .product-quantity input');
		const stickyQtyInput = root.querySelector('.lc-sticky-qty-input');
		const stickyQtyBtns = root.querySelectorAll('.lc-sticky-qty-btn');
		const stickyAddBtn = root.querySelector('#lc-sticky-btn-add');
		const mainAddBtn = root.querySelector('#lc-main-add-btn') || root.querySelector('.lc-add-btn');

		function syncQty(val) {
			const clamped = Math.max(1, Math.min(99, parseInt(val, 10) || 1));
			if (heroQtyInput) heroQtyInput.value = clamped;
			if (stickyQtyInput) stickyQtyInput.value = clamped;
		}

		if (heroQtyInput) {
			heroQtyInput.addEventListener('change', () => syncQty(heroQtyInput.value));
		}

		stickyQtyBtns.forEach(btn => {
			btn.addEventListener('click', function () {
				const dir = parseInt(this.getAttribute('data-dir'), 10) || 1;
				const current = parseInt(stickyQtyInput ? stickyQtyInput.value : 1, 10) || 1;
				syncQty(current + dir);
			});
		});

		if (stickyBar && heroSection) {
			function handleStickyScroll() {
				const rect = heroSection.getBoundingClientRect();
				if (rect.bottom < 80) {
					stickyBar.classList.add('is-visible');
				} else {
					stickyBar.classList.remove('is-visible');
				}
			}

			window.addEventListener('scroll', handleStickyScroll, { passive: true });
			handleStickyScroll();

			if (stickyAddBtn && mainAddBtn) {
				stickyAddBtn.addEventListener('click', function (e) {
					e.preventDefault();
					mainAddBtn.click();
				});
			}
		}

		// 10. Banner Scroll Button
		const bannerScrollBtn = root.querySelector('#lc-banner-scroll-btn');
		if (bannerScrollBtn && heroSection) {
			bannerScrollBtn.addEventListener('click', function (e) {
				e.preventDefault();
				heroSection.scrollIntoView({ behavior: 'smooth' });
			});
		}
	}

	/* ==========================================================================
	   11. AMS (AUTOMATIC MATERIAL SYSTEM) LANDING CONTROLLER
	   ========================================================================== */
	function initAmsInteractions() {
		const root = document.querySelector('.ams-landing-root');
		if (!root) return;

		// 1. Dynamic Variations Sync (Variable WooCommerce Products)
		const amsVarRadios = root.querySelectorAll('input[name="ams_variation_choice"]');
		const amsHiddenVarInput = root.querySelector('#selected-variation-id');
		const amsSkuDisplay = root.querySelector('#ams-selected-sku');
		const amsStockText = root.querySelector('#ams-stock-text');
		const amsStockRow = root.querySelector('#ams-stock-row');
		const amsStockNote = root.querySelector('#ams-stock-note');
		const amsPriceDisplay = root.querySelector('.ams-current-price');
		const amsPriceRow = root.querySelector('.ams-price-row');
		const amsStickyPrice = root.querySelector('#ams-sticky-price');
		const amsStickyConfig = root.querySelector('#ams-sticky-config');
		const amsStickyStock = root.querySelector('#ams-sticky-stock');
		const amsMainImg = root.querySelector('#product-main-image');
		const amsStickyThumb = root.querySelector('#ams-sticky-thumb-img');
		const vatLink = root.querySelector('.vat-link');
		const priceNote = root.querySelector('.product-price-note');

		let isExVat = false;
		let currentRawPrice = parseFloat(amsPriceRow ? (amsPriceRow.dataset.priceRaw || 0) : 0) || 0;
		let currentPriceHtml = amsPriceDisplay ? amsPriceDisplay.innerHTML : '';

		function formatPrice(rawNum) {
			let symbol = (window.woodmartLandingData && window.woodmartLandingData.currencySymbol) || '€';
			const formatted = rawNum.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			return `<span class="woocommerce-Price-amount amount" style="color:#111827 !important;"><bdi style="color:#111827 !important;"><span class="woocommerce-Price-currencySymbol" style="color:#111827 !important;">${symbol}</span>${formatted}</bdi></span>`;
		}

		function renderPrice() {
			let displayHtml = sanitizeCurrencyHtml(currentPriceHtml);
			if (isExVat && currentRawPrice > 0) {
				const exVatNum = currentRawPrice / 1.24;
				displayHtml = formatPrice(exVatNum);
			}
			if (amsPriceDisplay) {
				amsPriceDisplay.innerHTML = displayHtml;
				amsPriceDisplay.style.color = '#111827';
			}
			if (amsStickyPrice) {
				amsStickyPrice.innerHTML = displayHtml;
				amsStickyPrice.style.color = '#111827';
			}
		}

		if (vatLink) {
			vatLink.addEventListener('click', function (e) {
				e.preventDefault();
				isExVat = !isExVat;
				this.textContent = isExVat ? 'Show incl. VAT' : 'Show ex. VAT';
				if (priceNote) {
					priceNote.textContent = isExVat ? 'excl. 24% VAT · sample price' : 'incl. 24% VAT · sample price';
				}
				renderPrice();
			});
		}

		amsVarRadios.forEach(radio => {
			radio.addEventListener('change', function () {
				const varId = this.value;
				const title = this.dataset.title || '';
				const priceHtml = this.dataset.priceHtml || '';
				const sku = this.dataset.sku || '';
				const imageUrl = this.dataset.image || '';
				const stockStatus = this.dataset.stock || 'instock';
				const rawPrice = parseFloat(this.dataset.priceRaw || 0) || 0;

				// 1. Hidden form field
				if (amsHiddenVarInput) amsHiddenVarInput.value = varId;

				// 2. Title & attribute labels in sticky bar
				if (amsStickyConfig && title) {
					amsStickyConfig.textContent = title;
				}

				// 3. Dynamic SKU display
				if (amsSkuDisplay && sku) {
					amsSkuDisplay.textContent = sku;
				}
				if (amsStockNote && sku) {
					amsStockNote.textContent = 'SKU: ' + sku;
				}

				// 4. Dynamic Price (Hero & Sticky Bar)
				currentRawPrice = rawPrice;
				currentPriceHtml = priceHtml;
				renderPrice();

				// 5. Live Stock Status: Strictly dynamic "In Stock" / "Out of Stock"
				const isInStock = (stockStatus !== 'outofstock');
				if (amsStockText) {
					amsStockText.textContent = isInStock ? 'In Stock' : 'Out of Stock';
				}
				if (amsStockRow) {
					amsStockRow.classList.toggle('is-instock', isInStock);
					amsStockRow.classList.toggle('is-outofstock', !isInStock);
				}
				if (amsStickyStock) {
					amsStickyStock.textContent = isInStock ? '● In Stock' : '● Out of Stock';
					amsStickyStock.classList.toggle('is-instock', isInStock);
					amsStickyStock.classList.toggle('is-outofstock', !isInStock);
				}

				// 6. Highlight selected option label
				amsVarRadios.forEach(r => {
					const opt = r.closest('.option');
					if (opt) opt.classList.toggle('is-selected', r === radio);
				});

				// 7. Swap main gallery image to variation image
				if (imageUrl && amsMainImg) {
					amsMainImg.style.transition = 'opacity 0.2s ease';
					amsMainImg.style.opacity = '0.3';
					setTimeout(() => {
						amsMainImg.src = imageUrl;
						amsMainImg.style.opacity = '1';
						if (amsStickyThumb) amsStickyThumb.src = imageUrl;
					}, 150);

					// Highlight corresponding thumb if exists
					const matchingThumb = root.querySelector(`.product-gallery__thumbs li[data-full-url="${imageUrl}"]`);
					if (matchingThumb) {
						root.querySelectorAll('.product-gallery__thumbs li').forEach(t => t.classList.remove('is-active'));
						matchingThumb.classList.add('is-active');
					}
				}
			});
		});

		// 2. Essential Additions (Steppers & Add Buttons)
		const additionCards = root.querySelectorAll('.ams-additions-section .addition-card');
		additionCards.forEach(card => {
			const qtyInput = card.querySelector('.addition-card__qty input');
			const qtyBtns = card.querySelectorAll('.addition-card__qty button[data-step]');
			const addBtn = card.querySelector('.addition-card__btn-add');
			const title = card.querySelector('.addition-card__title') ? card.querySelector('.addition-card__title').textContent.trim() : 'Item';

			qtyBtns.forEach(btn => {
				btn.addEventListener('click', function () {
					const step = parseInt(this.getAttribute('data-step'), 10) || 0;
					const current = Math.max(1, parseInt(qtyInput ? qtyInput.value : 1, 10) || 1);
					if (qtyInput) qtyInput.value = Math.max(1, current + step);
				});
			});

			if (addBtn) {
				addBtn.addEventListener('click', function (e) {
					e.preventDefault();
					const origText = this.innerHTML;
					this.innerHTML = '<span>Added ✓</span>';
					this.style.background = '#047857';
					if (typeof showNotice === 'function') {
						showNotice(`✓ Added ${title} to sample basket!`, false);
					}
					setTimeout(() => {
						this.innerHTML = origText;
						this.style.background = '';
					}, 2000);
				});
			}
		});

		// 3. Overview Video Modal ("Watch AMS in Action" button)
		const videoBtn = root.querySelector('.ams-btn-watch-video');
		const videoModal = document.getElementById('ams-video-modal');
		if (videoBtn && videoModal) {
			const modalIframe = videoModal.querySelector('#ams-modal-iframe');
			const modalClose = videoModal.querySelector('.ams-video-modal-close');
			const modalBackdrop = videoModal.querySelector('.ams-video-modal-backdrop');

			function formatVideoEmbed(url) {
				if (!url) return '';
				const ytMatch = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i);
				if (ytMatch && ytMatch[1]) {
					return 'https://www.youtube.com/embed/' + ytMatch[1] + '?autoplay=1&rel=0&modestbranding=1';
				}
				const vimeoMatch = url.match(/(?:vimeo\.com\/)(\d+)/i);
				if (vimeoMatch && vimeoMatch[1]) {
					return 'https://player.vimeo.com/video/' + vimeoMatch[1] + '?autoplay=1';
				}
				return url;
			}

			function openVideoModal(e) {
				if (e) e.preventDefault();
				const url = videoBtn.getAttribute('data-video-url') || videoBtn.getAttribute('href');
				const embedUrl = formatVideoEmbed(url);
				if (modalIframe && embedUrl) {
					modalIframe.setAttribute('src', embedUrl);
				}
				videoModal.classList.add('is-open');
				videoModal.setAttribute('aria-hidden', 'false');
				document.body.style.overflow = 'hidden';
			}

			function closeVideoModal() {
				videoModal.classList.remove('is-open');
				videoModal.setAttribute('aria-hidden', 'true');
				if (modalIframe) {
					modalIframe.setAttribute('src', '');
				}
				document.body.style.overflow = '';
			}

			videoBtn.addEventListener('click', openVideoModal);
			if (modalClose) modalClose.addEventListener('click', closeVideoModal);
			if (modalBackdrop) modalBackdrop.addEventListener('click', closeVideoModal);

			window.addEventListener('keydown', function (e) {
				if (e.key === 'Escape' && videoModal.classList.contains('is-open')) {
					closeVideoModal();
				}
			});
		}

		// 4. Technical Specifications Collapsible Toggle
		const specsToggleBtn = root.querySelector('#ams-specs-toggle-btn');
		const specsCard = root.querySelector('.ams-specs-card');
		if (specsToggleBtn && specsCard) {
			specsToggleBtn.addEventListener('click', function () {
				const isExpanded = specsCard.classList.toggle('is-expanded');
				const toggleText = this.querySelector('.ams-toggle-text');
				if (toggleText) {
					toggleText.textContent = isExpanded ? 'Collapse specifications' : 'Show all specifications';
				}
				const svg = this.querySelector('svg');
				if (svg) {
					svg.style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
				}
			});
		}

		// 5. FAQ Accordion
		const faqQuestions = root.querySelectorAll('.ams-faq-question');
		faqQuestions.forEach(btn => {
			btn.addEventListener('click', function () {
				const item = this.closest('.ams-faq-item');
				if (!item) return;
				const isOpen = item.classList.contains('is-open');
				const answer = item.querySelector('.ams-faq-answer');

				if (isOpen) {
					item.classList.remove('is-open');
					this.setAttribute('aria-expanded', 'false');
					if (answer) answer.style.display = 'none';
				} else {
					item.classList.add('is-open');
					this.setAttribute('aria-expanded', 'true');
					if (answer) answer.style.display = 'block';
				}
			});
		});

		// 6. Sticky Bottom Bar Scroll Trigger & Proxy Purchase
		const stickyBar = root.querySelector('#ams-sticky-bar');
		const heroSection = document.getElementById('ams-hero') || root.querySelector('.ams-product-hero');
		const heroQtyInput = root.querySelector('.product-hero .product-quantity input');
		const stickyQtyInput = root.querySelector('.ams-sticky-qty-input');
		const stickyQtyBtns = root.querySelectorAll('.ams-sticky-qty-btn');
		const stickyAddBtn = root.querySelector('#ams-sticky-btn-add');
		const mainAddBtn = root.querySelector('#ams-main-add-btn');

		function syncQty(val) {
			const clamped = Math.max(1, Math.min(99, parseInt(val, 10) || 1));
			if (heroQtyInput) heroQtyInput.value = clamped;
			if (stickyQtyInput) stickyQtyInput.value = clamped;
		}

		if (heroQtyInput) {
			heroQtyInput.addEventListener('change', () => syncQty(heroQtyInput.value));
		}

		stickyQtyBtns.forEach(btn => {
			btn.addEventListener('click', function () {
				const dir = parseInt(this.getAttribute('data-dir'), 10) || 1;
				const current = parseInt(stickyQtyInput ? stickyQtyInput.value : 1, 10) || 1;
				syncQty(current + dir);
			});
		});

		if (stickyBar && heroSection) {
			function handleStickyScroll() {
				const rect = heroSection.getBoundingClientRect();
				if (rect.bottom < 80) {
					stickyBar.classList.add('is-visible');
				} else {
					stickyBar.classList.remove('is-visible');
				}
			}

			window.addEventListener('scroll', handleStickyScroll, { passive: true });
			handleStickyScroll();

			if (stickyAddBtn && mainAddBtn) {
				stickyAddBtn.addEventListener('click', function (e) {
					e.preventDefault();
					mainAddBtn.click();
				});
			}
		}

		// 7. Bottom CTA Banner Scroll Button
		const bannerScrollBtn = root.querySelector('#ams-banner-scroll-btn');
		if (bannerScrollBtn && heroSection) {
			bannerScrollBtn.addEventListener('click', function (e) {
				e.preventDefault();
				heroSection.scrollIntoView({ behavior: 'smooth' });
			});
		}
	}
})();



