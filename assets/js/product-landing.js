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

		// Handle Vertical Scrolling Navigation
		function checkThumbsOverflow() {
			if (!thumbsWrap || !thumbsList) return;
			const hasOverflow = thumbsList.scrollHeight > thumbsList.clientHeight + 4;
			thumbsWrap.classList.toggle('has-nav-active', hasOverflow);
		}

		checkThumbsOverflow();
		window.addEventListener('resize', checkThumbsOverflow);

		if (prevBtn) {
			prevBtn.addEventListener('click', function (e) {
				e.preventDefault();
				if (thumbsList) {
					thumbsList.scrollBy({ top: -92, behavior: 'smooth' });
				}
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', function (e) {
				e.preventDefault();
				if (thumbsList) {
					thumbsList.scrollBy({ top: 92, behavior: 'smooth' });
				}
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
	   4. SMOOTH SCROLL & IN-PAGE NAV SPY
	   ========================================================================== */
	function initSmoothScrollAndSpy() {
		const sectionNav = document.querySelector('.product-section-navigation');
		const navLinks = sectionNav ? sectionNav.querySelectorAll('a[href^="#"]') : [];
		const header = document.querySelector('.whb-header') || document.querySelector('.site-header') || document.querySelector('header');

		function getOffset() {
			const headerHeight = header ? header.offsetHeight : 64;
			const navHeight = sectionNav ? sectionNav.offsetHeight : 48;
			return headerHeight + navHeight + 10;
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

			window.addEventListener('scroll', function () {
				const scrollPos = window.pageYOffset + getOffset() + 20;

				sections.forEach(({ link, target }) => {
					const top = target.offsetTop;
					const height = target.offsetHeight;

					if (scrollPos >= top && scrollPos < top + height) {
						navLinks.forEach(l => l.classList.remove('is-active'));
						link.classList.add('is-active');
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
		const stickyVarBtns = document.querySelectorAll('.sticky-var-btn');
		const boxCards = document.querySelectorAll('.product-package-contents__grid .pkg[data-select-setup]');
		const hiddenVariationInput = document.getElementById('selected-variation-id');

		let isExVat = false;
		let currentRawPrice = parseFloat(priceDisplay ? (priceDisplay.dataset.priceRaw || 0) : 0) || 0;
		let currentPriceHtml = priceDisplay ? (priceDisplay.dataset.priceHtml || priceDisplay.innerHTML) : '';

		function formatPrice(rawNum) {
			const symbol = (window.woodmartLandingData && window.woodmartLandingData.currencySymbol) || '€';
			const formatted = rawNum.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			return `<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">${symbol}</span>${formatted}</bdi></span>`;
		}

		function renderCurrentPrice() {
			let displayHtml = currentPriceHtml;
			if (isExVat && currentRawPrice > 0) {
				const exVatNum = currentRawPrice / 1.24;
				displayHtml = formatPrice(exVatNum);
			}

			if (priceDisplay) {
				priceDisplay.innerHTML = displayHtml;
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

			// Update Sticky Bar Title
			if (stickyBarTitle && title) {
				stickyBarTitle.textContent = title;
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

			// Sync hero radio labels
			setupRadios.forEach(radio => {
				const isMatch = (radio.value === String(variationId)) || (isCombo && radio.dataset.combo === '1') || (!isCombo && radio.dataset.combo === '0');
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

		// When comparison package buttons are clicked (e.g. Choose Standalone / Choose Combo)
		document.querySelectorAll('.plan [data-select-setup]').forEach(btn => {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				const targetCombo = this.dataset.selectSetup === 'combo';
				const matchedRadio = document.querySelector(`input[name="setup"][data-combo="${targetCombo ? '1' : '0'}"]`);

				if (matchedRadio) {
					matchedRadio.checked = true;
					matchedRadio.dispatchEvent(new Event('change', { bubbles: true }));

					// Smooth scroll up to hero
					const heroSection = document.querySelector('.product-hero');
					if (heroSection) {
						heroSection.scrollIntoView({ behavior: 'smooth' });
					}
				}
			});
		});
	}

	/* ==========================================================================
	   7. WOOCOMMERCE AJAX ADD-TO-CART
	   ========================================================================== */
	function initAjaxAddToCart() {
		const form = document.querySelector('.product-add-to-cart-form');
		const stickyBtn = document.querySelector('.sticky-purchase-bar .btn');

		if (!form) return;

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

		function handleAddToCart(submitBtn) {
			const productIdInput = form.querySelector('input[name="product_id"]');
			const variationIdInput = form.querySelector('input[name="variation_id"]') || form.querySelector('#selected-variation-id');
			const qtyInput = form.querySelector('input[name="quantity"]') || form.querySelector('.product-quantity input');

			const productId = productIdInput ? productIdInput.value : 0;
			const variationId = variationIdInput ? variationIdInput.value : 0;
			const quantity = qtyInput ? Math.max(1, parseInt(qtyInput.value, 10) || 1) : 1;

			if (!productId) return;

			// Check if variation is required but not selected
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
			.then(res => res.json())
			.then(data => {
				if (submitBtn) {
					submitBtn.classList.remove('is-loading');
					submitBtn.disabled = false;
				}
				if (stickyBtn) {
					stickyBtn.classList.remove('is-loading');
					stickyBtn.disabled = false;
				}

				if (data && data.success) {
					// Update cart count badges across Woodmart header builder
					if (typeof data.cart_count !== 'undefined') {
						const cartCountBadges = document.querySelectorAll('.wd-cart-number, .whb-cart-number, .woodmart-cart-number, .cart-count, .site-header__tools .cart-count');
						cartCountBadges.forEach(badge => {
							badge.textContent = data.cart_count;
						});
					}

					// Trigger native WooCommerce fragments update if jQuery is available
					if (window.jQuery) {
						window.jQuery(document.body).trigger('wc_fragment_refresh');
						window.jQuery(document.body).trigger('added_to_cart', [data.fragments, data.cart_hash, submitBtn]);
					}

					const cartUrl = config.cartUrl || '#';
					showNotice(`✓ Added to sample basket! <a href="${cartUrl}">View basket →</a>`, false);
				} else {
					const errorMsg = (data && data.message) ? data.message : 'Could not add item to basket. Please try again.';
					showNotice(errorMsg, true);
				}
			})
			.catch(err => {
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
})();
