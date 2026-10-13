/**
 * 3DKODA - Custom WooCommerce Login & Register Auth Split-Screen Interactivity
 *
 * Handles seamless view switching (Login <-> Register) and password visibility toggle.
 *
 * @package WoodmartChild
 * @version 1.0.0
 */

(function () {
	'use strict';

	/**
	 * Initialize Auth Interactions once DOM is ready
	 */
	function initKodaAuth() {
		const root = document.querySelector('.koda-auth-page-root');
		if (!root) {
			return;
		}

		const loginCard = document.getElementById('koda-view-login');
		const registerCard = document.getElementById('koda-view-register');
		const heroTitleLogin = document.querySelector('.koda-hero-title-login');
		const heroTitleRegister = document.querySelector('.koda-hero-title-register');
		const switchButtons = document.querySelectorAll('[data-switch-to]');
		const passwordToggles = document.querySelectorAll('.koda-toggle-password-btn');

		/**
		 * Switch Active Auth View (Login or Register)
		 *
		 * @param {string} targetView 'login' | 'register'
		 * @param {boolean} updateHistory Whether to update URL hash
		 */
		function switchAuthView(targetView, updateHistory) {
			if (targetView !== 'login' && targetView !== 'register') {
				return;
			}

			// 1. Update Root Attribute
			root.setAttribute('data-active-tab', targetView);

			// 2. Toggle Form Cards
			if (targetView === 'register') {
				if (loginCard) {
					loginCard.classList.remove('is-active');
				}
				if (registerCard) {
					registerCard.classList.add('is-active');
				}

				// Toggle Hero Headings
				if (heroTitleLogin) {
					heroTitleLogin.classList.remove('active');
				}
				if (heroTitleRegister) {
					heroTitleRegister.classList.add('active');
				}

				if (updateHistory && window.history && window.history.replaceState) {
					window.history.replaceState(null, null, '#register');
				}
			} else {
				if (registerCard) {
					registerCard.classList.remove('is-active');
				}
				if (loginCard) {
					loginCard.classList.add('is-active');
				}

				// Toggle Hero Headings
				if (heroTitleRegister) {
					heroTitleRegister.classList.remove('active');
				}
				if (heroTitleLogin) {
					heroTitleLogin.classList.add('active');
				}

				if (updateHistory && window.history && window.history.replaceState) {
					window.history.replaceState(null, null, '#login');
				}
			}

			// 3. Synchronize Prominent Nav Tabs
			document.querySelectorAll('.koda-nav-tab-btn').forEach(function (tab) {
				if (tab.getAttribute('data-switch-to') === targetView) {
					tab.classList.add('is-active');
				} else {
					tab.classList.remove('is-active');
				}
			});

			// Focus first input in newly activated form for great accessibility
			const activeCard = targetView === 'register' ? registerCard : loginCard;
			if (activeCard) {
				const firstInput = activeCard.querySelector('input:not([type="hidden"])');
				if (firstInput && document.activeElement && document.activeElement.tagName === 'BUTTON') {
					firstInput.focus();
				}
			}
		}

		// Attach click listeners to Switch Triggers
		switchButtons.forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				const target = this.getAttribute('data-switch-to');
				switchAuthView(target, true);
			});
		});

		// Check URL hash on initial load
		const currentHash = window.location.hash.toLowerCase();
		if (currentHash === '#register') {
			switchAuthView('register', false);
		} else if (currentHash === '#login') {
			switchAuthView('login', false);
		} else {
			// Respect server-rendered initial tab
			const serverTab = root.getAttribute('data-active-tab');
			if (serverTab === 'register') {
				switchAuthView('register', false);
			}
		}

		// Handle browser Back / Forward navigation
		window.addEventListener('hashchange', function () {
			const hash = window.location.hash.toLowerCase();
			if (hash === '#register') {
				switchAuthView('register', false);
			} else if (hash === '#login') {
				switchAuthView('login', false);
			}
		});

		/**
		 * Password Show/Hide Toggle Implementation
		 */
		passwordToggles.forEach(function (toggleBtn) {
			toggleBtn.addEventListener('click', function (e) {
				e.preventDefault();
				const wrap = this.closest('.koda-password-field-wrap');
				if (!wrap) {
					return;
				}

				const passwordInput = wrap.querySelector('.koda-password-input');
				if (!passwordInput) {
					return;
				}

				const isPassword = passwordInput.getAttribute('type') === 'password';
				if (isPassword) {
					passwordInput.setAttribute('type', 'text');
					this.textContent = 'Hide';
					this.setAttribute('aria-label', 'Hide password');
				} else {
					passwordInput.setAttribute('type', 'password');
					this.textContent = 'Show';
					this.setAttribute('aria-label', 'Show password');
				}

				// Maintain cursor position at end of string
				passwordInput.focus();
			});
		});

		/**
		 * Ensure WooCommerce password strength meter and hints stay outside fixed-height input wrap
		 */
		const regPassInput = document.getElementById('reg_password');
		if (regPassInput) {
			const passWrap = regPassInput.closest('.koda-password-field-wrap');
			if (passWrap) {
				const relocateMeter = function () {
					const misplaced = passWrap.querySelectorAll('.woocommerce-password-strength, .woocommerce-password-hint');
					misplaced.forEach(function (el) {
						passWrap.parentNode.insertBefore(el, passWrap.nextSibling);
					});
				};

				regPassInput.addEventListener('input', function () {
					setTimeout(relocateMeter, 10);
				});

				regPassInput.addEventListener('keyup', function () {
					setTimeout(relocateMeter, 10);
				});

				if (window.MutationObserver) {
					const observer = new MutationObserver(relocateMeter);
					observer.observe(passWrap, { childList: true });
				}
			}
		}

		/**
		 * Scroll to notices if present on page load
		 */
		const notices = document.querySelector('.koda-notices-wrap');
		if (notices && notices.children.length > 0) {
			notices.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
		}

		/**
		 * Ensure zero top offset on theme wrappers to permanently eliminate white header gap
		 */
		function cleanThemeOffsets() {
			document.body.style.setProperty('padding-top', '0px', 'important');
			document.body.style.setProperty('margin-top', '0px', 'important');

			const wrappers = document.querySelectorAll('.website-wrapper, .wd-page-wrapper, .main-page-wrapper, .wd-page-content, .site-content, .entry-content, .woocommerce');
			wrappers.forEach(function (el) {
				el.style.setProperty('padding-top', '0px', 'important');
				el.style.setProperty('margin-top', '0px', 'important');
			});
		}

		cleanThemeOffsets();
		window.addEventListener('resize', cleanThemeOffsets);
		window.addEventListener('scroll', cleanThemeOffsets, { passive: true });
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initKodaAuth);
	} else {
		initKodaAuth();
	}
})();
