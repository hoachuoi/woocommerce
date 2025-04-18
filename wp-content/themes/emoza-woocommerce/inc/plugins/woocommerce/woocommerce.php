<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Emoza
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function emoza_woocommerce_setup() {

	$enable_zoom     = get_theme_mod( 'single_zoom_effects', 1 );
	$enable_gallery  = get_theme_mod( 'single_gallery_slider', 1 );
	$enable_lightbox = get_theme_mod( 'single_product_image_lightbox', 1 );

	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 420,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
		)
	);
	
	if ( $enable_zoom ) {
		add_theme_support( 'wc-product-gallery-zoom' );
	}

	if ( $enable_gallery ) {
		add_theme_support( 'wc-product-gallery-slider' );
	}
	
	if ( $enable_lightbox ) {
		add_theme_support( 'wc-product-gallery-lightbox' );
	}
}
add_action( 'after_setup_theme', 'emoza_woocommerce_setup' );

/**
 * WooCommerce admin specific scripts & stylesheets.
 *
 * @return void
 */
function emoza_admin_woocommerce_scripts() {
	$current_screen = get_current_screen();

    if( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
		wp_enqueue_style( 'emoza-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.min.css', array(), EMOZA_VERSION );
	}
}
add_action( 'admin_enqueue_scripts', 'emoza_admin_woocommerce_scripts' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function emoza_woocommerce_scripts() {
	$single_product_gallery = get_theme_mod( 'single_product_gallery', 'gallery-default' );

	if ( current_theme_supports( 'wc-product-gallery-slider' ) && in_array( $single_product_gallery, array( 'gallery-vertical', 'gallery-showcase' ) ) ) {
		wp_enqueue_script( 'emoza-swiper', get_template_directory_uri() . '/assets/js/emoza-swiper.min.js', array(), EMOZA_VERSION, true );
	}

	if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
		wp_enqueue_script( 'emoza-gallery', get_template_directory_uri() . '/assets/js/emoza-gallery.min.js', array( 'emoza-custom' ), EMOZA_VERSION, true );
	}

	wp_enqueue_style( 'emoza-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.min.css', array(), EMOZA_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}
		@font-face {
			font-family: "WooCommerce";
			src: url("' . $font_path . 'WooCommerce.eot");
			src: url("' . $font_path . 'WooCommerce.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'WooCommerce.woff") format("woff"),
				url("' . $font_path . 'WooCommerce.ttf") format("truetype"),
				url("' . $font_path . 'WooCommerce.svg#WooCommerce") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'emoza-woocommerce-style', $inline_font );

	// Sidebar
	$shop_archive_sidebar = get_theme_mod( 'shop_archive_sidebar', 'no-sidebar' );

	if( 'sidebar-slide' === $shop_archive_sidebar && ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) ) {
		wp_register_script( 'emoza-sidebar', get_template_directory_uri() . '/assets/js/emoza-sidebar.min.js', array( 'emoza-custom' ), EMOZA_VERSION, true );
		wp_enqueue_script( 'emoza-sidebar' );
	}
}
add_action( 'wp_enqueue_scripts', 'emoza_woocommerce_scripts', 9 );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Include the fragments script in the cart page.
 * 
 */
function emoza_woocommerce_cart_fragments() {
	if ( is_cart() ) {
		wp_enqueue_script( 'wc-cart-fragments', WC()->plugin_url() . '/assets/js/frontend/cart-fragments.min.js', array( 'jquery' ), EMOZA_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'emoza_woocommerce_cart_fragments', 11 );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function emoza_woocommerce_active_body_class( $classes ) {
	global $template;
	$template_name = basename($template);
	
	$single_breadcrumbs = get_theme_mod( 'single_breadcrumbs', 1 );
	if( ! $single_breadcrumbs && is_single() ) {
		$classes[] = 'no-single-breadcrumbs';
	}

	$classes[] = 'woocommerce-active';

	if( 'template-wishlist.php' === $template_name ) {
		$classes[] = 'woocommerce-cart';
	}

	// Shop catalog responsive columns
	$shop_columns_tablet  = get_theme_mod( 'shop_woocommerce_catalog_columns_tablet', 3 );
	$shop_columns_mobile  = get_theme_mod( 'shop_woocommerce_catalog_columns_mobile', 1 );

	$classes[] = 'shop-columns-tablet-' . absint( $shop_columns_tablet );
	$classes[] = 'shop-columns-mobile-' . absint( $shop_columns_mobile ); 

	return $classes;
}
add_filter( 'body_class', 'emoza_woocommerce_active_body_class' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Layout shop archive
 */
function emoza_wc_archive_layout() {

	$archive_sidebar        = get_theme_mod( 'shop_archive_sidebar', 'no-sidebar' );
	$shop_categories_layout = get_theme_mod( 'shop_categories_layout', 'layout1' );
	$shop_archive_sidebar_filter_in_desktop = get_theme_mod( 'shop_archive_sidebar_filter_in_desktop', 1 );

	if ( $archive_sidebar === 'sidebar-slide' && $shop_archive_sidebar_filter_in_desktop ) {
		$archive_sidebar .= ' sidebar-desktop';
	}

	if ( 'no-sidebar' === $archive_sidebar ) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	}

	if ( 'sidebar-top' === $archive_sidebar ) {
		$shop_archive_sidebar_top_columns = get_theme_mod( 'shop_archive_sidebar_top_columns', '4' );

		$archive_sidebar .= ' sidebar-top-columns-' . $shop_archive_sidebar_top_columns;
	}

	$archive_sidebar .= ' product-category-item-' . $shop_categories_layout;
	
	$layout = get_theme_mod( 'shop_archive_layout', 'product-grid' );       

	return $archive_sidebar . ' ' . $layout;
}

/**
 * Layout single product
 */
function emoza_wc_single_layout() {

	// Sidebar layout
	$sidebar_layout = get_theme_mod( 'single_product_sidebar', 'no-sidebar' );

	$meta_sidebar_layout = get_post_meta( get_the_ID(), '_emoza_sidebar_layout', true );

	if ( ! empty( $meta_sidebar_layout ) && $meta_sidebar_layout !== 'customizer' ) {
		$sidebar_layout = $meta_sidebar_layout;
	}

	// Remove sidebar
	if ( $sidebar_layout === 'no-sidebar' ) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		add_filter( 'emoza_sidebar', '__return_false' );
	}

	return $sidebar_layout;
}

/**
 * Hook into Woocommerce
 */
function emoza_wc_hooks() {

	//No sidebar for checkout, cart, account
	if ( is_cart() ) {
		add_filter( 'emoza_content_class', function() { 
			$layout = get_theme_mod( 'shop_cart_layout', 'layout1' ); 

			return 'no-sidebar cart-' . esc_attr( $layout ); 
		} );
		add_filter( 'emoza_sidebar', '__return_false' );
	} elseif ( is_checkout() ) {
		add_filter( 'emoza_content_class', function() { 
			$layout = get_theme_mod( 'shop_checkout_layout', 'layout1' ); 
			
			return 'no-sidebar checkout-' . esc_attr( $layout ); 
		} );
		add_filter( 'emoza_sidebar', '__return_false' );
	} elseif( is_account_page() ) {
		add_filter( 'emoza_content_class', function() { 
			return 'no-sidebar'; 
		} );
		add_filter( 'emoza_sidebar', '__return_false' );
	}

	//Archive layout
	if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
		add_filter( 'emoza_content_class', 'emoza_wc_archive_layout' );
	}

	//Single product settings
	if ( is_product() ) {
		$single_breadcrumbs            = get_theme_mod( 'single_breadcrumbs', 1 );
		$single_breadcrumbs_hide_title = get_theme_mod( 'single_breadcrumbs_hide_title', 1 );

		//Content class
		add_filter( 'emoza_content_class', 'emoza_wc_single_layout' );

		add_action( 'woocommerce_before_add_to_cart_button', 'emoza_single_addtocart_wrapper_open' );
		add_action( 'woocommerce_after_add_to_cart_button', 'emoza_single_addtocart_wrapper_close' );

		//Breadcrumbs
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		if ( $single_breadcrumbs ) {
			add_action( 'woocommerce_before_main_content', 'emoza_woocommerce_breadcrumbs', 20 );
		}

		if( $single_breadcrumbs_hide_title ) {
			add_filter( 'woocommerce_get_breadcrumb', 'emoza_remove_last_item_from_breadcrumb', 10, 2 );
		}

		//Elements Order
		$single_product_gallery = get_theme_mod( 'single_product_gallery', 'gallery-default' );
		if( 'gallery-full-width' !== $single_product_gallery ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
	
			$defaults   = emoza_get_default_single_product_components();
			$components = get_theme_mod( 'single_product_elements_order', $defaults );

			add_action( 'woocommerce_single_product_summary', function(){ 

				/**
				 * Hook 'emoza_before_render_single_product_elements'
				 * Fires before rendering single product elements.
				 * 
				 * @since 1.1.0
				 */
				do_action( 'emoza_before_render_single_product_elements' );
			}, 5 );

			foreach ( $components as $component ) {
				if( ! function_exists( $component ) ) {
					continue;
				}
				
				add_action( 'woocommerce_single_product_summary', $component, 5 );
			}
			
			add_action( 'woocommerce_single_product_summary', function() { 
				echo '<div class="elements-order-end"></div>'; 
			}, 50 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		}

	}

	//Move cart collaterals
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals' );
	add_action( 'woocommerce_before_cart_collaterals', function() {
		echo woocommerce_cart_totals(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	} );

	//Results and sorting
	$shop_results_count     = get_theme_mod( 'shop_results_count', 1 );
	$shop_product_sorting   = get_theme_mod( 'shop_product_sorting', 1 );

	if ( !$shop_product_sorting ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}

	if ( !$shop_results_count ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	}
	
	//Shop sidebar
	$shop_archive_sidebar = get_theme_mod( 'shop_archive_sidebar', 'no-sidebar' );

	if( 'sidebar-slide' === $shop_archive_sidebar ) {
		add_action( 'woocommerce_before_shop_loop', function() {
			$shop_archive_sidebar_open_button_text = get_theme_mod( 'shop_archive_sidebar_open_button_text', '' );
			$shop_archive_sidebar_open_icon        = get_theme_mod( 'shop_archive_sidebar_open_icon', 1 );

			$icon = '';
			if( $shop_archive_sidebar_open_icon ) {
				$icon = emoza_get_svg_icon( 'icon-filters' );
			}

			$text = '';
			if( $shop_archive_sidebar_open_button_text ) {
				$text = $shop_archive_sidebar_open_button_text;
			}

			echo '<div class="sidebar-open-wrapper'. ( $text ? ' has-text' : '' ) .'">';
			echo '    <a href="#" role="button" class="sidebar-open" onclick="emoza.toggleClass.init(event, this, \'sidebar-slide-open\');" data-emoza-selector=".sidebar-slide+.widget-area" data-emoza-toggle-class="show">'. $icon . esc_html( $text ) .'</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div>';
		}, 19 );
	}

	//Cart total sticky
	$shop_cart_sticky_totals_box = get_theme_mod( 'shop_cart_sticky_totals_box', 0 );
	$cart_layout                 = get_theme_mod( 'shop_cart_layout', 'layout1' ); 

	if( $shop_cart_sticky_totals_box && $cart_layout === 'layout2' ) {
		add_action( 'woocommerce_before_cart', function() { 
			echo '<div class="cart-totals-sticky"></div>'; 
		}, 999 );
	}
}
add_action( 'wp', 'emoza_wc_hooks' );

/**
 * Loop shop columns callback
 */
function emoza_loop_shop_columns() {
	$columns_desktop = get_theme_mod( 'shop_woocommerce_catalog_columns_desktop', 4 );
	return $columns_desktop;
}
add_filter( 'loop_shop_columns', 'emoza_loop_shop_columns' );

/**
 * Loop shop rows callback
 */
function emoza_loop_shop_per_page() {
	$columns = get_theme_mod( 'shop_woocommerce_catalog_columns_desktop', 4 );
	$rows    = get_theme_mod( 'shop_woocommerce_catalog_rows', 4 );
	return $columns * $rows;
}
add_filter( 'loop_shop_per_page', 'emoza_loop_shop_per_page' );

/**
 * Loop shop product title
 */
function emoza_shop_loop_product_title() {
	global $post;
	ob_start();
	the_title( '<h2 class="woocommerce-loop-product__title"><a class="emoza-wc-loop-product__title" href="'. esc_url( get_the_permalink( $post->ID ) ) .'">', '</a></h2>' );
	$the_title = ob_get_clean();

	/**
	 * Hook 'emoza_shop_loop_product_title'
	 *
	 * @since 1.0.0
	 */
	echo wp_kses_post( apply_filters( 'emoza_shop_loop_product_title', $the_title, $post ) );
}

/**
 * Single add to cart wrapper
 */
function emoza_single_addtocart_wrapper_open() {
	echo '<div class="emoza-single-addtocart-wrapper">';
}

function emoza_single_addtocart_wrapper_close() {
	echo '</div>';
}

/**
 * Quantity buttons
 */
function emoza_woocommerce_before_quantity_input_field() {
	echo '<a href="#" class="emoza-quantity-minus" title="' . esc_attr__( 'Decrease quantity', 'emoza-woocommerce' ) . '" role="button">'. esc_html( emoza_get_quantity_symbols_output( 'minus' ) ) .'<span class="em-d-none">'. esc_html__( 'Decrease product quantity.', 'emoza-woocommerce' ) .'</span></a>';
}
add_action( 'woocommerce_before_quantity_input_field', 'emoza_woocommerce_before_quantity_input_field' );

function emoza_woocommerce_after_quantity_input_field() {
	echo '<a href="#" class="emoza-quantity-plus" title="' . esc_attr__( 'Increase quantity', 'emoza-woocommerce' ) . '" role="button">'. esc_html( emoza_get_quantity_symbols_output( 'plus' ) ) .'<span class="em-d-none">'. esc_html__( 'Increase product quantity.', 'emoza-woocommerce' ) .'</span></a>';
}
add_action( 'woocommerce_after_quantity_input_field', 'emoza_woocommerce_after_quantity_input_field' );

function emoza_get_quantity_symbols_output( $type = 'plus' ) {
	$qty_style = get_theme_mod( 'shop_general_quantity_style', 'style1' );

	if( in_array( $qty_style, array( 'style1', 'style2', 'style4', 'style5', 'style6', 'style8' ) ) ) {
		if( $type === 'plus' ) {
			return '+';
		} else {
			return '-';
		}
	}

	return '';
}

/**
 * Loop product category
 */
function emoza_loop_product_category() {
	echo '<div class="product-category">' . wc_get_product_category_list( get_the_id() ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Loop product description
 */
function emoza_loop_product_description() {
	$content = get_the_excerpt();

	echo '<div class="product-description">' . wp_kses_post( wp_trim_words( $content, 12, '&hellip;' ) ) . '</div>';
}

if ( ! function_exists( 'emoza_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function emoza_woocommerce_wrapper_before() {
		/**
		 * Hook 'emoza_content_class'
		 *
		 * @since 1.0.0
		 */
		$content_class = apply_filters( 'emoza_content_class', '' );
		?>
			<main id="primary" class="site-main <?php echo esc_attr( $content_class ); ?>">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'emoza_woocommerce_wrapper_before' );

if ( ! function_exists( 'emoza_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function emoza_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'emoza_woocommerce_wrapper_after' );

/**
 * Wrap products results and ordering before
 */
function emoza_wrap_products_results_ordering_before() {
	if( ! emoza_has_woocommerce_sorting_wrapper() ) {
		return;
	}

	echo '<div class="woocommerce-sorting-wrapper">';
	echo '<div class="row">';
	echo '<div class="col-md-6 col-6 emoza-sorting-left">';
	echo '<div class="emoza-sorting-left-inner">';
}
add_action( 'woocommerce_before_shop_loop', 'emoza_wrap_products_results_ordering_before', 19 );

/**
 * Add a button to toggle filters on shop archives
 */
function emoza_add_filters_button() {
	if( ! emoza_has_woocommerce_sorting_wrapper() ) {
		return;
	}

	echo '</div>';
	echo '</div>';
	echo '<div class="col-md-6 col-6 emoza-sorting-right">';
	echo '<div class="emoza-sorting-right-inner">';
}
add_action( 'woocommerce_before_shop_loop', 'emoza_add_filters_button', 22 );

/**
 * Wrap products results and ordering after
 */
function emoza_wrap_products_results_ordering_after() {
	if( ! emoza_has_woocommerce_sorting_wrapper() ) {
		return;
	}
	
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'emoza_wrap_products_results_ordering_after', 31 );

/**
 * Check if has "woocommerce-sorting-wrapper"
 */
function emoza_has_woocommerce_sorting_wrapper() {
	$shop_grid_list_view  = get_theme_mod( 'shop_grid_list_view', 0 );
	$shop_product_sorting = get_theme_mod( 'shop_product_sorting', 1 );
	$shop_results_count   = get_theme_mod( 'shop_results_count', 1 );
	$shop_archive_sidebar = get_theme_mod( 'shop_archive_sidebar', 'no-sidebar' );

	if( ! $shop_grid_list_view && ! $shop_product_sorting && ! $shop_results_count && $shop_archive_sidebar !== 'sidebar-slide' ) {
		return false;
	}

	return true;
}

/**
 * Checkout wrapper
 */
function emoza_wrap_order_review_before() {
	echo '<div class="checkout-wrapper">';
}
add_action( 'woocommerce_checkout_before_order_review_heading', 'emoza_wrap_order_review_before', 5 );

/**
 * Checkout wrapper end
 */
function emoza_wrap_order_review_after() {
	echo '</div>';
}
add_action( 'woocommerce_checkout_after_order_review', 'emoza_wrap_order_review_after', 15 );

/**
 * My account page 
 * Identify the page and insert html so we can style some elements
 */
function emoza_myaccount_html_insert() {
    if( !isset( $_SERVER['REQUEST_URI'] ) && is_account_page() ) {
		return;
	}

	$request_url = wc_clean( wp_unslash( $_SERVER['REQUEST_URI'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
    
	// view-order
    if( strpos( $request_url, '/view-order' ) !== FALSE || strpos( $request_url, '&view-order=' ) !== FALSE ) {
        echo '<div class="emoza-wc-account-view-order"></div>';
    }
}
add_action( 'woocommerce_account_content', 'emoza_myaccount_html_insert', 0 );

/**
 * Store Notice
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/store-notice.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Identify products with manage stock and only one instock
 * This is needed because since WooCommerce 7.4.0 the quantity input is automatically hidden when the product has only one instock or is defined to "Limit purchases to 1 item per order"
 */
function emoza_woocommerce_post_class( $classes, $product ) {
	if( $product->get_manage_stock() ) {
		$classes[] = 'has-manage-stock';

		if( $product->get_stock_quantity() === 1 && $product->get_type() !== 'variable' ) {
			$classes[] = 'has-only-one-instock';
		}
	}

	if( ! empty( $product->get_gallery_image_ids() ) ) {
		$classes[] = 'has-gallery-images';
	}

	return $classes;
}
add_filter( 'woocommerce_post_class', 'emoza_woocommerce_post_class', 10, 2 );

/**
 * Remove the quantity input from the cart page for products that have either only one instock or sold individually option enabled
 */
function emoza_cart_item_quantity( $product_quantity_output, $cart_item_key, $cart_item ) {
	$product = wc_get_product( $cart_item['product_id'] );

	if( $product->is_sold_individually() ) {
		return '';
	}

	return $product_quantity_output;
}
add_filter( 'woocommerce_cart_item_quantity', 'emoza_cart_item_quantity', 10, 3 );

/**
 * Remove the last item from the breadcrumb trail
 */
function emoza_remove_last_item_from_breadcrumb( $crumbs, $breadcrumb ) {
	if( is_product() ) {
		$last_index            = count( $crumbs ) - 1;
		$crumbs[ $last_index ] = array( '', '' );
	}

	return $crumbs;
}

/**
 * Display how many products are available before backorder.
 * Currently we can do that only to simple products because the 'woocommerce_cart_item_backorder_notification' filter passes only the parent product id and not the variation ID.
 * So we can't identify what is the variation added to cart. 
 * 
 * @param string $message The default message.
 * @param int    $product_id The product ID.
 * 
 * @return string
 */
function emoza_cart_backorder_notification( $message, $product_id ){
	$product             = wc_get_product( $product_id );
	$new_default_message = sprintf( '<small class="em-d-block em-m-0">%1$s</small>', __( 'Available on backorder', 'emoza-woocommerce' ) );

	if ( $product->get_type() !== 'simple' ) {
		return $new_default_message;
	}

	$stock_quantity = $product->get_stock_quantity();
	if ( $stock_quantity > 0 ) {
		return sprintf( '<small class="em-d-block em-m-0">%1$s %2$s</small>', absint( $stock_quantity ), __( 'in stock. Remaining is available on backorder.', 'emoza-woocommerce' ) );
	}

	return $new_default_message;
}
add_filter( 'woocommerce_cart_item_backorder_notification', 'emoza_cart_backorder_notification', 10, 2 );

/**
 * Disable the ComingSoon block from being displayed in the widget areas.
 * Since Woo 9.2.0+ the ComingSoon block is loaded in the widget areas such as the customizer. 
 * Due to how the CSS is written in the block, the customizer is taking too much to load generating a bad user experience.
 * 
 * Note: There's a PR opened to fix this issue in the plugin here: https://github.com/woocommerce/woocommerce/pull/51058.
 * Once it is approved we can remove this filter.
 * 
 * @param array $block_types The block types.
 * 
 * @since 1.1.0
 * @return array
 */
function emoza_disable_coming_soon_block_from_widget_areas( $block_types ) {
	global $pagenow;

	if ( ! in_array( $pagenow, array( 'widgets.php', 'themes.php', 'customize.php' ), true ) ) {
		return $block_types;
	}

	return array_diff(
		$block_types,
		array( 'ComingSoon' )
	);
}
add_filter( 'woocommerce_get_block_types', 'emoza_disable_coming_soon_block_from_widget_areas' );

/**
 * WooCommerce Blocks
 */
require get_template_directory() . '/inc/plugins/woocommerce/blocks/product-categories/class-emoza-woocommerce-block-product-categories.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Real Time Ajax Search
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/real-time-ajax-search/real-time-ajax-search.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Header Mini Cart
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/mini-cart.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Shop Page Header
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/wc-page-header.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Sale Badge
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/sale-badge.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Quick View
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/quick-view.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Quick View
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/wishlist.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Cross Sell
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/cross-sell.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Product Card
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/product-card.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Single Product Gallery
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/single-product-gallery.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Single Product Ajax Add to Cart
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/single-ajax-add-to-cart.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Single Product Tabs
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/single-product-tabs.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Upsell Products
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/upsell-products.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Related Products
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/related-products.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Recently viewed products
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/recently-viewed-products.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * WooCommerce GB Blocks
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/wc-editor-blocks.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * WooCommerce No Posts Found
 */
require get_template_directory() . '/inc/plugins/woocommerce/features/no-posts-found.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * WooCommerce Template Functions
 */
require get_template_directory() . '/inc/plugins/woocommerce/woocommerce-template-functions.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * WooCommerce Ajax Callbacks
 */
require get_template_directory() . '/inc/plugins/woocommerce/woocommerce-ajax-callbacks.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound