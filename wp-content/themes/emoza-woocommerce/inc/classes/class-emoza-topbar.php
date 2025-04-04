<?php
/**
 * Header class class
 *
 * @package Emoza
 */

if ( !class_exists( 'Emoza_Top_Bar' ) ) :
	Class Emoza_Top_Bar {

		/**
		 * Instance
		 */     
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'emoza_header', array( $this, 'topbar_markup' ), 5 );
		}

		/**
		 * Desktop header markup
		 */
		public function topbar_markup() {
			$enable     = get_theme_mod( 'enable_top_bar', 0 );

			if ( !$enable ) {
				return;
			}

			$container  = get_theme_mod( 'topbar_container', 'container-fluid' );
			$visibility = get_theme_mod( 'topbar_visibility', 'desktop-only' );
			$delimiter  = get_theme_mod( 'topbar_delimiter', 'none' );
			?>

			<div class="top-bar visibility-<?php echo esc_attr( $visibility ); ?>">
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="top-bar-inner">
						<div class="row valign">

							<?php if( ! $this->elements_empty( 'left' ) ) : ?>
								<div class="<?php echo esc_attr( $this->get_column_class( 'left' ) ); ?> header-elements delimiter-<?php echo esc_attr( $delimiter ); ?>">
									<?php $this->render_components( 'left' ); ?>
								</div>
							<?php endif; ?>
							<?php if( ! $this->elements_empty( 'right' ) ) : ?>
								<div class="<?php echo esc_attr( $this->get_column_class( 'right' ) ); ?> header-elements delimiter-<?php echo esc_attr( $delimiter ); ?>">
									<?php $this->render_components( 'right' ); ?>
								</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Get topbar components
		 */
		public function get_topbar_components( $location ) {
			$defaults   = emoza_get_default_topbar_components();
			$components = get_theme_mod( 'topbar_components_' . $location, $defaults[$location] );

			return $components;
		}

		/**
		 * Check if specified elements area is empty/hidden
		 */
		public function elements_empty( $location ) {
			$components = $this->get_topbar_components( $location );

			if( count( $components ) === 0 ) {
				return true;
			}

			return false;
		}

		/**
		 * Render header components
		 */
		public function render_components( $location ) {
			$components = $this->get_topbar_components( $location );

			if( has_nav_menu( 'top-bar-mobile' ) ) {
				array_splice( $components, array_search( 'secondary_nav', $components, true ), 0, 'secondary_nav_mobile' );
			}

			foreach ( $components as $component ) {
				call_user_func( array( $this, $component ) );
			}
		}

		/**
		 * Get column class
		 */
		public function get_column_class( $location ) {
			$center_content = get_theme_mod( 'center_top_bar_contents', 0 );

			if( 'left' === $location ) {
				$components = $this->get_topbar_components( 'right' );
			}

			if( 'right' === $location ) {
				$components = $this->get_topbar_components( 'left' );
			}
			
			if( count( $components ) === 0 && ! $center_content ) {
				if( 'right' === $location ) {
					return 'col-12 justify-content-end';
				}

				return 'col-12';
			}

			return 'col';
		}

		/**
		 * Contact info
		 */
		public function contact_info() {
			$email  = get_theme_mod( 'topbar_contact_mail', esc_html__( 'office@example.org', 'emoza-woocommerce' ) );
			$phone  = get_theme_mod( 'topbar_contact_phone', esc_html__( '111222333', 'emoza-woocommerce' ) );

			?>
				<div class="header-item top-bar-contact">
					<?php if ( $email ) : ?>
						<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><i class="ws-svg-icon"><?php emoza_get_svg_icon( 'icon-mail', true ); ?></i><?php echo esc_html( antispambot( $email ) ); ?></a>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<a href="tel:<?php echo esc_attr( $phone ); ?>"><i class="ws-svg-icon"><?php emoza_get_svg_icon( 'icon-phone', true ); ?></i><?php echo esc_html( $phone ); ?></a>
					<?php endif; ?>					
				</div>
			<?php
		}   
		
		/**
		 * Text
		 */
		public function text() {
			$text = get_theme_mod( 'topbar_text', esc_html__( 'Your text here', 'emoza-woocommerce' ) );
			?>
			<div class="header-item top-bar-text">
				<?php echo wp_kses_post( $text ); ?>
			</div>
			<?php
		}

		/**
		 * Social
		 */
		public function social() {
			echo '<div class="header-item top-bar-social">';
				emoza_social_profile( 'social_profiles_topbar' );
			echo '</div>';
		}

		/**
		 * Secondary menu
		 */
		public function secondary_nav() {
			if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled( 'secondary' ) ) : ?>
				<nav class="header-item secondary-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
				</nav>
			<?php else: 
				$has_hover_delay = get_option( 'emoza_dropdowns_hover_delay', 'yes' );
				?>
				<nav class="header-item top-bar-secondary-navigation secondary-navigation emoza-dropdown<?php echo 'yes' === $has_hover_delay ? ' with-hover-delay' : ''; ?>">
					<?php
					wp_nav_menu( array(
						'theme_location'=> 'secondary',
						'menu_id'       => 'secondary',
						'fallback_cb'   => false,
						'depth'         => 0,

						/**
						 * Hook 'emoza_secondary_wp_nav_menu_walker'
						 *
						 * @since 1.0.0
						 */
						'walker'        => apply_filters( 'emoza_secondary_wp_nav_menu_walker', '' ),
					) );
					?>
				</nav>
			<?php endif;
		}

		/**
		 * Secondary menu mobile
		 */
		public function secondary_nav_mobile() {
			if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled( 'secondary' ) && ! has_nav_menu( 'top-bar-mobile' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
			<?php else: ?>				
			<nav class="header-item top-bar-secondary-navigation secondary-navigation top-bar-mobile-navigation emoza-dropdown">
				<?php
				wp_nav_menu( array(
					'theme_location'=> 'top-bar-mobile',
					'menu_id'       => 'top-bar-mobile',
					'menu_class'    => 'menu emoza-dropdown-ul',
					'fallback_cb'   => false,
					'depth'         => 0,
				) );
				?>
			</nav>
			<?php endif;
		}

		/**
		 * HTML
		 */
		public function html() {
			$topbar_html_content = get_theme_mod( 'topbar_html_content', '' );

			if( ! $topbar_html_content ) {
				return '';
			}

			echo '<div class="header-item top-bar-html">';
				echo wp_kses_post( $topbar_html_content ); 
			echo '</div>';
		}

		/**
		 * Shortcode
		 */
		public function shortcode() {
			$topbar_shortcode_content  = get_theme_mod( 'topbar_shortcode_content', '' );

			if( ! $topbar_shortcode_content ) {
				return '';
			}

			echo '<div class="header-item top-bar-shortcode">';
				echo do_shortcode( $topbar_shortcode_content ); 
			echo '</div>';
		}

		/**
		 * Login/Register
		 */
		public function login_register() {
			$output = '';

			if( ! class_exists( 'Woocommerce' ) ) {
				return '';
			}

			if( is_user_logged_in() ) {
				$show_welcome_message = get_theme_mod( 'login_register_show_welcome_message', 1 );
				if( ! $show_welcome_message ) {
					return;
				}

				$current_user = wp_get_current_user();

				/* translators: 1: display name. */
				$welcome_message_text = get_theme_mod( 'login_register_welcome_message_text', sprintf( esc_html__( 'Welcome %s', 'emoza-woocommerce' ), '{display_name}' ) );
				$welcome_message_text = str_replace(
					array( '{user_firstname}', '{user_lastname}', '{user_email}', '{user_login}', '{display_name}' ),
					array( $current_user->user_firstname, $current_user->user_lastname, $current_user->user_email, $current_user->user_login, $current_user->display_name ),
					$welcome_message_text
				);
				
				$output .= '<a href="'. esc_url( wc_get_page_permalink( 'myaccount' ) ) .'" title="'. esc_attr__( 'My account', 'emoza-woocommerce' ) .'">' . esc_html( $welcome_message_text ) . '</a>'; 
				$output .= '<nav>';
					$output .= '<a href="'. esc_url( wc_get_page_permalink( 'myaccount' ) ) .'" title="'. esc_attr__( 'My account dashboard', 'emoza-woocommerce' ) .'">'. esc_html__( 'Dashboard', 'emoza-woocommerce' ) .'</a>';
					$output .= '<a href="'. esc_url( wc_get_endpoint_url( 'orders', '', wc_get_page_permalink( 'myaccount' ) ) ) .'" title="'. esc_attr__( 'Orders', 'emoza-woocommerce' ) .'">'. esc_html__( 'Orders', 'emoza-woocommerce' ) .'</a>';
					$output .= '<a href="'. esc_url( wc_get_endpoint_url( 'downloads', '', wc_get_page_permalink( 'myaccount' ) ) ) .'" title="'. esc_attr__( 'Downloads', 'emoza-woocommerce' ) .'">'. esc_html__( 'Downloads', 'emoza-woocommerce' ) .'</a>';
					$output .= '<a href="'. esc_url( wc_get_endpoint_url( 'edit-address', '', wc_get_page_permalink( 'myaccount' ) ) ) .'" title="'. esc_attr__( 'Addresses', 'emoza-woocommerce' ) .'">'. esc_html__( 'Addresses', 'emoza-woocommerce' ) .'</a>';
					$output .= '<a href="'. esc_url( wc_get_endpoint_url( 'edit-account', '', wc_get_page_permalink( 'myaccount' ) ) ) .'" title="'. esc_attr__( 'Account details', 'emoza-woocommerce' ) .'">'. esc_html__( 'Account Details', 'emoza-woocommerce' ) .'</a>';
					$output .= '<a href="'. esc_url( wc_logout_url() ) .'" title="'. esc_attr__( 'Logout', 'emoza-woocommerce' ) .'">'. esc_html__( 'Logout', 'emoza-woocommerce' ) .'</a>';
				$output .= '</nav>';
			} else {
				$login_register_link_text = get_theme_mod( 'login_register_link_text', esc_html__( 'Login', 'emoza-woocommerce' ) );
				$login_register_popup     = Emoza_Modules::is_module_active( 'login-popup' );
				
				$link_classes = array( 'emoza-login-register-link' );
				
				if( $login_register_popup ) {
					$link_classes[] = 'has-popup';
				}

				$output .= '<a href="'. esc_url( wc_get_page_permalink( 'myaccount' ) ) .'" title="'. esc_attr__( 'Login or register', 'emoza-woocommerce' ) .'" data-popup-id="loginRegisterPopup" class="'. esc_attr( implode( ' ', $link_classes ) ) .'">'. esc_html( $login_register_link_text ) .'</a>';
			}

			echo '<div class="header-item top-bar-login-register">';
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- previously escaped
			echo '</div>';
		}
	}

	/**
	 * Initialize class
	 */
	Emoza_Top_Bar::get_instance();

endif;