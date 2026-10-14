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
			const symbol = (window.woodmartLandingData && window.woodmartLandingData.currencySymbol) || '€';
			const formatted = rawNum.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			return `<span class="woocommerce-Price-amount amount" style="color:#111827 !important;"><bdi style="color:#111827 !important;"><span class="woocommerce-Price-currencySymbol" style="color:#111827 !important;">${symbol}</span>${formatted}</bdi></span>`;
		}

		function renderCurrentPrice() {
			let displayHtml = currentPriceHtml;
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
			selectedColorSlug = initialActiveSwatch.dataset.slug || '';
			currentColorName = initialActiveSwatch.dataset.colorName || '';
		}

		let selectedFormatSlug = '';
		let currentFormatTitle = '';
		const initialActiveCard = root.querySelector('.filament-format-card.is-active');
		if (initialActiveCard) {
			selectedFormatSlug = initialActiveCard.dataset.format || '';
			currentFormatTitle = initialActiveCard.dataset.title || '';
		}

		function findMatchingVariation(colorSlug, formatSlug) {
			if (!matrix.length) return null;
			// 1. Exact match on both color and format
			let match = matrix.find(v => {
				const cMatch = (!colorSlug && !v.color) || (v.color && v.color === colorSlug);
				const fMatch = (!formatSlug && !v.format) || (v.format && v.format === formatSlug);
				return cMatch && fMatch;
			});
			if (match) return match;

			// 2. Match format if color is empty
			if (formatSlug) {
				match = matrix.find(v => v.format === formatSlug);
				if (match) return match;
			}

			// 3. Match color if format is empty
			if (colorSlug) {
				match = matrix.find(v => v.color === colorSlug);
				if (match) return match;
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
						priceSlot.innerHTML = v.price_html;
					}
				}
			});
		}

		function applyVariation(v) {
			const varInput = root.querySelector('#selected-variation-id') || root.querySelector('input[name="variation_id"]');
			if (varInput && v) {
				varInput.value = v.id;
			}
			if (mainPriceSpan && v && v.price_html) {
				mainPriceSpan.innerHTML = v.price_html;
			}
			if (v && v.image) {
				const mainImg = root.querySelector('.product-gallery__main img');
				if (mainImg) {
					mainImg.style.transition = 'opacity 0.2s ease';
					mainImg.style.opacity = '0.3';
					setTimeout(() => {
						mainImg.src = v.image;
						mainImg.style.opacity = '1';
					}, 150);
				}
			}

			if (variationSummary) {
				const parts = [];
				if (currentColorName) {
					parts.push(currentColorName.toUpperCase());
				}
				if (currentFormatTitle) {
					parts.push(currentFormatTitle.toUpperCase());
				}
				if (v && v.sku) {
					parts.push(v.sku);
				}
				if (parts.length > 0) {
					variationSummary.textContent = parts.join(' · ');
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

				selectedColorSlug = this.dataset.slug || '';
				currentColorName = this.dataset.colorName || '';

				if (activeColorSpan) {
					activeColorSpan.textContent = this.dataset.colorDisplay || this.dataset.colorName || '';
				}
				if (colorInput) {
					colorInput.value = currentColorName;
				}

				// Update prices shown on the 2 format boxes for the newly picked color
				updateFormatCardPrices();

				// If a format card is already active, sync the matching variation
				if (selectedFormatSlug) {
					const matchedVar = findMatchingVariation(selectedColorSlug, selectedFormatSlug);
					if (matchedVar) {
						applyVariation(matchedVar);
					}
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

		// Format Cards Selection in Hero (The 2 Boxes: Complete Spool vs Refill)
		formatCards.forEach(card => {
			card.addEventListener('click', function () {
				formatCards.forEach(c => c.classList.remove('is-active'));
				this.classList.add('is-active');

				selectedFormatSlug = this.dataset.format || '';
				currentFormatTitle = this.dataset.title || '';

				if (formatInput) {
					formatInput.value = currentFormatTitle;
				}

				const matchedVar = findMatchingVariation(selectedColorSlug, selectedFormatSlug);
				if (matchedVar) {
					applyVariation(matchedVar);
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

				const isMobile = window.innerWidth <= 1024;
				let headerHeight = isMobile ? 60 : 64;

				// Check visible Woodmart sticky/pinned header height if present
				const stickyHeader = document.querySelector('.whb-sticked') || document.querySelector('.whb-clone');
				if (stickyHeader && stickyHeader.offsetHeight > 0) {
					headerHeight = stickyHeader.offsetHeight;
				}

				return adminOffset + headerHeight;
			}

			function updateStickyTop() {
				const offset = getHeaderOffset();
				document.documentElement.style.setProperty('--filament-subnav-top', offset + 'px');
				subnav.style.setProperty('top', offset + 'px', 'important');
			}
			updateStickyTop();
			window.addEventListener('resize', updateStickyTop);

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

			return matrix.find(v => {
				const vAttrs = v.attributes || {};
				for (const [key, val] of Object.entries(selectedAttrs)) {
					if (vAttrs[key] && vAttrs[key] !== '' && vAttrs[key].toLowerCase() !== val.toLowerCase()) {
						return false;
					}
				}
				return true;
			}) || matrix[0];
		}

		function syncVariationState() {
			const selectedAttrs = getSelectedAttributes();
			const matched = findMatchingVariation(selectedAttrs);
			const names = getSelectedAttributeNames();

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
					stickyBadge.textContent = names.join(' · ') || 'Standard';
				}
				if (stickyThumb && matched.image) {
					stickyThumb.src = matched.image;
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
})();



