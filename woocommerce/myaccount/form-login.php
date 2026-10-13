<?php
/**
 * Custom WooCommerce Login & Register Auth Split-Screen Template
 *
 * Overrides default woocommerce/myaccount/form-login.php
 * Only rendered for guest (unauthenticated) users on My Account page.
 *
 * @package WoodmartChild
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Determine active view tab (Login or Register)
$initial_tab = 'login';
if ( isset( $_POST['register'] ) || ( isset( $_GET['action'] ) && 'register' === sanitize_key( $_GET['action'] ) ) ) {
	$initial_tab = 'register';
}

$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$contact_url = home_url( '/contact/' );
$privacy_url = function_exists( 'get_privacy_policy_url' ) && get_privacy_policy_url() ? get_privacy_policy_url() : home_url( '/privacy-policy/' );
$terms_url   = home_url( '/terms-of-service/' );
$current_yr  = gmdate( 'Y' );
?>

<div class="koda-auth-page-root" data-active-tab="<?php echo esc_attr( $initial_tab ); ?>">

	<!-- 1. TOP ANNOUNCEMENT BAR -->
	<aside class="koda-auth-topbar" aria-label="<?php esc_attr_e( 'Store Announcement', 'woodmart-child' ); ?>">
		<div class="koda-auth-topbar-inner">
			<span><?php esc_html_e( 'FROM TALLINN TO YOUR DOOR • 1–2 DAY BALTIC DELIVERY', 'woodmart-child' ); ?></span>
		</div>
	</aside>

	<!-- 2. MINIMAL HEADER BAR -->
	<header class="koda-auth-header">
		<div class="koda-auth-header-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="koda-auth-logo" aria-label="<?php esc_attr_e( '3DKODA Home', 'woodmart-child' ); ?>">
				<span class="koda-logo-text">3DKODA</span>
			</a>
			<a href="<?php echo esc_url( $shop_url ); ?>" class="koda-auth-back-link">
				<span><?php esc_html_e( 'Back to store', 'woodmart-child' ); ?></span>
				<span class="koda-arrow-icon" aria-hidden="true">&#8599;</span>
			</a>
		</div>
	</header>

	<!-- 3. SPLIT-SCREEN MAIN WORKSPACE -->
	<main class="koda-auth-main" id="koda-auth-main">
		<div class="koda-auth-split-wrapper">

			<!-- LEFT COLUMN: DARK HERO (0b0f19) -->
			<section class="koda-hero-col" aria-label="<?php esc_attr_e( '3DKODA Information', 'woodmart-child' ); ?>">
				<div class="koda-hero-content">

					<!-- Top Sub-tagline -->
					<div class="koda-hero-badge">
						<?php esc_html_e( 'PRECISION TOOLS. LOCAL KNOW-HOW.', 'woodmart-child' ); ?>
					</div>

					<!-- Dynamic Headings Area (Switches based on active view) -->
					<div class="koda-hero-headings-container">
						<!-- Login View Dynamic Heading -->
						<div class="koda-hero-title-block koda-hero-title-login <?php echo ( 'login' === $initial_tab ) ? 'active' : ''; ?>" data-hero-view="login">
							<h1 class="koda-hero-h1">
								<span class="koda-hero-lead"><?php esc_html_e( 'Welcome back', 'woodmart-child' ); ?></span>
								<span class="koda-hero-sub-lines">
									<span class="koda-sub-line"><?php esc_html_e( 'Tools for your imagination.', 'woodmart-child' ); ?></span>
									<span class="koda-sub-line"><?php esc_html_e( 'Expertise you can count on.', 'woodmart-child' ); ?></span>
								</span>
								<span class="koda-hero-tail"><?php esc_html_e( 'to making.', 'woodmart-child' ); ?></span>
							</h1>
						</div>

						<!-- Register View Dynamic Heading -->
						<div class="koda-hero-title-block koda-hero-title-register <?php echo ( 'register' === $initial_tab ) ? 'active' : ''; ?>" data-hero-view="register">
							<h1 class="koda-hero-h1">
								<span class="koda-hero-lead"><?php esc_html_e( 'Your next idea', 'woodmart-child' ); ?></span>
								<span class="koda-hero-sub-lines">
									<span class="koda-sub-line"><?php esc_html_e( 'Tools for your imagination.', 'woodmart-child' ); ?></span>
									<span class="koda-sub-line"><?php esc_html_e( 'Expertise you can count on.', 'woodmart-child' ); ?></span>
								</span>
								<span class="koda-hero-tail"><?php esc_html_e( 'starts here.', 'woodmart-child' ); ?></span>
							</h1>
						</div>
					</div>

					<!-- Numbered Value Points -->
					<div class="koda-hero-points">
						<article class="koda-point-item">
							<div class="koda-point-index"><?php esc_html_e( '01 / MADE FOR YOUR WORK', 'woodmart-child' ); ?></div>
							<p class="koda-point-desc"><?php esc_html_e( 'Keep your orders and invoices in one place.', 'woodmart-child' ); ?></p>
						</article>

						<article class="koda-point-item">
							<div class="koda-point-index"><?php esc_html_e( '02 / A TEAM CLOSE BY', 'woodmart-child' ); ?></div>
							<p class="koda-point-desc"><?php esc_html_e( 'Connect with your local Baltic printing experts.', 'woodmart-child' ); ?></p>
						</article>

						<article class="koda-point-item">
							<div class="koda-point-index"><?php esc_html_e( '03 / KEEP CREATING', 'woodmart-child' ); ?></div>
							<p class="koda-point-desc"><?php esc_html_e( 'Find genuine printers, materials and parts.', 'woodmart-child' ); ?></p>
						</article>
					</div>

					<!-- Bottom Brand Tagline -->
					<div class="koda-hero-footer-tag">
						<span><?php esc_html_e( 'FROM TALLINN. FOR THE BALTICS.', 'woodmart-child' ); ?></span>
					</div>

				</div>
			</section>

			<!-- RIGHT COLUMN: CLEAN FORM WORKSPACE -->
			<section class="koda-forms-col" aria-label="<?php esc_attr_e( 'Account Authentication', 'woodmart-child' ); ?>">
				<div class="koda-forms-inner">

					<!-- WooCommerce Action Hook: Before Customer Login Form -->
					<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

					<!-- Notices Container (Validation & Feedback) -->
					<div class="koda-notices-wrap">
						<?php woocommerce_output_all_notices(); ?>
					</div>

					<!-- PROMINENT VIEW SWITCHER TABS (EASILY VISIBLE AT TOP) -->
					<nav class="koda-auth-nav-tabs" aria-label="<?php esc_attr_e( 'Account Access Views', 'woodmart-child' ); ?>">
						<button type="button" class="koda-nav-tab-btn <?php echo ( 'login' === $initial_tab ) ? 'is-active' : ''; ?>" data-switch-to="login">
							<?php esc_html_e( 'Log in', 'woodmart-child' ); ?>
						</button>
						<button type="button" class="koda-nav-tab-btn <?php echo ( 'register' === $initial_tab ) ? 'is-active' : ''; ?>" data-switch-to="register">
							<?php esc_html_e( 'Create an account', 'woodmart-child' ); ?>
						</button>
					</nav>

					<!-- ============================================== -->
					<!-- A. LOGIN FORM BLOCK -->
					<!-- ============================================== -->
					<div class="koda-auth-card koda-card-login <?php echo ( 'login' === $initial_tab ) ? 'is-active' : ''; ?>" id="koda-view-login">
						<div class="koda-card-header">
							<div class="koda-card-header-top">
								<span class="koda-eyebrow"><?php esc_html_e( 'YOUR 3DKODA ACCOUNT', 'woodmart-child' ); ?></span>
								<button type="button" class="koda-top-switch-link" data-switch-to="register">
									<?php esc_html_e( 'Create account →', 'woodmart-child' ); ?>
								</button>
							</div>
							<h2 class="koda-heading"><?php esc_html_e( 'Welcome back.', 'woodmart-child' ); ?></h2>
							<p class="koda-subtext"><?php esc_html_e( 'Log in to view your orders, invoices and account details.', 'woodmart-child' ); ?></p>
						</div>

						<form class="woocommerce-form woocommerce-form-login login koda-auth-form" method="post">
							<?php do_action( 'woocommerce_login_form_start' ); ?>

							<!-- Email / Username -->
							<div class="koda-form-row">
								<label for="username" class="koda-label">
									<?php esc_html_e( 'Email address', 'woodmart-child' ); ?>
								</label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text koda-input" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="you@example.com" required />
							</div>

							<!-- Password -->
							<div class="koda-form-row">
								<label for="password" class="koda-label">
									<?php esc_html_e( 'Password', 'woodmart-child' ); ?>
								</label>
								<div class="koda-password-field-wrap">
									<input class="woocommerce-Input woocommerce-Input--text input-text koda-input koda-password-input" type="password" name="password" id="password" autocomplete="current-password" placeholder="Enter your password" required />
									<button type="button" class="koda-toggle-password-btn" aria-label="<?php esc_attr_e( 'Toggle password visibility', 'woodmart-child' ); ?>">
										<?php esc_html_e( 'Show', 'woodmart-child' ); ?>
									</button>
								</div>
							</div>

							<!-- Meta Row: Remember me + Forgot password -->
							<div class="koda-form-row koda-meta-row">
								<label class="koda-checkbox-container">
									<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
									<span class="koda-checkbox-custom"></span>
									<span class="koda-checkbox-label-text"><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
								</label>

								<a class="koda-forgot-link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
									<?php esc_html_e( 'Forgot password?', 'woocommerce' ); ?>
								</a>
							</div>

							<?php do_action( 'woocommerce_login_form' ); ?>

							<!-- Submit Button & Nonce -->
							<div class="koda-form-row koda-submit-row">
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
								<button type="submit" class="woocommerce-button button woocommerce-form-login__submit koda-btn-submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
									<span><?php esc_html_e( 'LOG IN', 'woodmart-child' ); ?></span>
									<span class="koda-btn-arrow" aria-hidden="true">&rarr;</span>
								</button>
							</div>

							<?php do_action( 'woocommerce_login_form_end' ); ?>
						</form>

						<!-- View Switch Trigger to Register -->
						<div class="koda-switch-bar">
							<span class="koda-switch-desc"><?php esc_html_e( 'New to 3DKoda?', 'woodmart-child' ); ?></span>
							<button type="button" class="koda-switch-link" data-switch-to="register">
								<?php esc_html_e( 'Create an account', 'woodmart-child' ); ?>
							</button>
						</div>
					</div>

					<!-- ============================================== -->
					<!-- B. REGISTER FORM BLOCK -->
					<!-- ============================================== -->
					<div class="koda-auth-card koda-card-register <?php echo ( 'register' === $initial_tab ) ? 'is-active' : ''; ?>" id="koda-view-register">
						<div class="koda-card-header">
							<div class="koda-card-header-top">
								<span class="koda-eyebrow"><?php esc_html_e( 'YOUR 3DKODA ACCOUNT', 'woodmart-child' ); ?></span>
								<button type="button" class="koda-top-switch-link" data-switch-to="login">
									<?php esc_html_e( 'Log in instead →', 'woodmart-child' ); ?>
								</button>
							</div>
							<h2 class="koda-heading"><?php esc_html_e( 'Create your account', 'woodmart-child' ); ?></h2>
							<p class="koda-subtext"><?php esc_html_e( 'A simpler way to manage your orders and keep creating.', 'woodmart-child' ); ?></p>
						</div>

						<form method="post" class="woocommerce-form woocommerce-form-register register koda-auth-form" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
							<?php do_action( 'woocommerce_register_form_start' ); ?>

							<!-- Full Name -->
							<div class="koda-form-row">
								<label for="reg_full_name" class="koda-label">
									<?php esc_html_e( 'Full name', 'woodmart-child' ); ?>
								</label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text koda-input" name="account_full_name" id="reg_full_name" autocomplete="name" value="<?php echo ( ! empty( $_POST['account_full_name'] ) ) ? esc_attr( wp_unslash( $_POST['account_full_name'] ) ) : ''; ?>" placeholder="Enter your full name" required />
							</div>

							<!-- Email Address -->
							<div class="koda-form-row">
								<label for="reg_email" class="koda-label">
									<?php esc_html_e( 'Email address', 'woocommerce' ); ?>
								</label>
								<input type="email" class="woocommerce-Input woocommerce-Input--text input-text koda-input" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" placeholder="you@example.com" required />
							</div>

							<!-- Password -->
							<div class="koda-form-row">
								<label for="reg_password" class="koda-label">
									<?php esc_html_e( 'Password', 'woocommerce' ); ?>
								</label>
								<div class="koda-password-field-wrap">
									<input class="woocommerce-Input woocommerce-Input--text input-text koda-input koda-password-input" type="password" name="password" id="reg_password" autocomplete="new-password" placeholder="Create a password" required minlength="8" />
									<button type="button" class="koda-toggle-password-btn" aria-label="<?php esc_attr_e( 'Toggle password visibility', 'woodmart-child' ); ?>">
										<?php esc_html_e( 'Show', 'woodmart-child' ); ?>
									</button>
								</div>
								<div class="woocommerce-password-strength" aria-live="polite"></div>
								<span class="koda-field-hint"><?php esc_html_e( 'Use at least 8 characters.', 'woodmart-child' ); ?></span>
							</div>

							<!-- Checkboxes -->
							<div class="koda-form-row koda-checkboxes-block">
								<!-- Terms & Privacy Agreement -->
								<label class="koda-checkbox-container koda-terms-checkbox">
									<input type="checkbox" name="terms_privacy_agreed" id="terms_privacy_agreed" value="1" required />
									<span class="koda-checkbox-custom"></span>
									<span class="koda-checkbox-label-text">
										<?php esc_html_e( 'I agree to the', 'woodmart-child' ); ?>
										<a href="<?php echo esc_url( $terms_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Terms of Service', 'woodmart-child' ); ?></a>
										<?php esc_html_e( 'and', 'woodmart-child' ); ?>
										<a href="<?php echo esc_url( $privacy_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Privacy Policy', 'woodmart-child' ); ?></a>.
									</span>
								</label>

								<!-- Marketing Newsletter Opt-In (Optional) -->
								<label class="koda-checkbox-container koda-optin-checkbox">
									<input type="checkbox" name="newsletter_optin" id="newsletter_optin" value="1" />
									<span class="koda-checkbox-custom"></span>
									<span class="koda-checkbox-label-text">
										<?php esc_html_e( 'Send me product news and printing tips. (Optional)', 'woodmart-child' ); ?>
									</span>
								</label>
							</div>

							<?php do_action( 'woocommerce_register_form' ); ?>

							<!-- Submit Button & Nonce -->
							<div class="koda-form-row koda-submit-row">
								<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
								<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit koda-btn-submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
									<span><?php esc_html_e( 'CREATE ACCOUNT', 'woodmart-child' ); ?></span>
									<span class="koda-btn-arrow" aria-hidden="true">&rarr;</span>
								</button>
							</div>

							<?php do_action( 'woocommerce_register_form_end' ); ?>
						</form>

						<!-- View Switch Trigger to Login -->
						<div class="koda-switch-bar">
							<span class="koda-switch-desc"><?php esc_html_e( 'Already have an account?', 'woodmart-child' ); ?></span>
							<button type="button" class="koda-switch-link" data-switch-to="login">
								<?php esc_html_e( 'Log in', 'woodmart-child' ); ?>
							</button>
						</div>
					</div>

					<!-- ============================================== -->
					<!-- C. HELP CARD (BOTTOM OF RIGHT COLUMN) -->
					<!-- ============================================== -->
					<aside class="koda-help-card" aria-label="<?php esc_attr_e( 'Support Assistance', 'woodmart-child' ); ?>">
						<h3 class="koda-help-heading"><?php esc_html_e( "Need a hand? We're close by.", 'woodmart-child' ); ?></h3>
						<a href="<?php echo esc_url( $contact_url ); ?>" class="koda-help-link">
							<span><?php esc_html_e( 'Contact your local Baltic team', 'woodmart-child' ); ?></span>
							<span class="koda-help-arrow" aria-hidden="true">&#8599;</span>
						</a>
					</aside>

					<!-- WooCommerce Action Hook: After Customer Login Form -->
					<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

				</div>
			</section>

		</div>
	</main>

	<!-- 4. MINIMAL FOOTER BAR -->
	<footer class="koda-auth-footer">
		<div class="koda-auth-footer-inner">
			<div class="koda-footer-left">
				<span>&copy; <?php echo esc_html( $current_yr ); ?> <?php esc_html_e( '3DKoda OÜ • From Tallinn. For the Baltics.', 'woodmart-child' ); ?></span>
			</div>
			<nav class="koda-footer-right" aria-label="<?php esc_attr_e( 'Legal Links', 'woodmart-child' ); ?>">
				<a href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'woodmart-child' ); ?></a>
				<a href="<?php echo esc_url( $terms_url ); ?>"><?php esc_html_e( 'Terms of Service', 'woodmart-child' ); ?></a>
			</nav>
		</div>
	</footer>

</div>
