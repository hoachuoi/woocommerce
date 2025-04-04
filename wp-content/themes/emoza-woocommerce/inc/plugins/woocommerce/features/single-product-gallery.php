<?php
/**
 * Single Product Gallery
 *
 * @package Emoza
 */

/**
 * WC Hooks 
 */
function emoza_single_product_gallery_hooks() {
    $has_quick_view = get_theme_mod( 'shop_product_quickview_layout', 'layout1' ) !== 'layout1' ? true : false;

    if( ! $has_quick_view && ! is_product() ) {
        return;
    }

    $single_product_gallery = get_theme_mod( 'single_product_gallery', 'gallery-default' );

    // Preload main product image.
    add_action( 'wp_head', 'emoza_single_product_preload_image', 5 );

    //Gallery
    if( 'gallery-grid' === $single_product_gallery || 'gallery-scrolling' === $single_product_gallery ) {
        remove_theme_support( 'wc-product-gallery-slider' );
        remove_theme_support( 'wc-product-gallery-zoom' );
        add_action( 'woocommerce_single_product_summary', function(){ echo '<div class="sticky-entry-summary">'; }, -99 );
        add_action( 'woocommerce_single_product_summary', function(){ echo '</div>'; }, 99 );
        add_filter( 'woocommerce_gallery_image_size', function(){ return 'woocommerce_single'; } );
    }

    if( 'gallery-showcase' === $single_product_gallery ) {
        remove_theme_support( 'wc-product-gallery-zoom' );
        add_action( 'woocommerce_single_product_summary', function(){ echo '<div class="sticky-entry-summary">'; }, -99 );
        add_action( 'woocommerce_single_product_summary', function(){ echo '</div>'; }, 99 );
    }

    if( 'gallery-full-width' === $single_product_gallery ) {
        remove_theme_support( 'wc-product-gallery-zoom' );
        add_action( 'woocommerce_single_product_summary', function(){ echo '<div class="gallery-full-width-title-wrapper">'; }, 0 );
        add_action( 'woocommerce_single_product_summary', function(){ echo '</div><div class="gallery-full-width-addtocart-wrapper">'; }, 20 );
        add_action( 'woocommerce_single_product_summary', function(){ echo '</div>'; }, 99 );
    }
}
add_action( 'wp', 'emoza_single_product_gallery_hooks' );

/**
 * Preload main product image.
 * 
 * @return void
 */
function emoza_single_product_preload_image() {
    global $post;

    if ( ! $post ) {
        return;
    }

    if ( ! is_singular( 'product' ) ) {
        return;
    }

    $product       = wc_get_product( $post );
    $main_image_id = $product->get_image_id();

    if ( ! $main_image_id ) {
        return;
    }

    $image_src = wp_get_attachment_image_src( $main_image_id, 'full' );
    if ( ! $image_src ) {
        return;
    }

    echo '<link rel="preload" href="' . esc_url( $image_src[0] ) . '" as="image">';
}

/**
 * Single product top area wrapper
 */
function emoza_single_product_wrap_before() {
    $classes = array( 'product-gallery-summary' );

    // Gallery layout.
    $classes[] = get_theme_mod( 'single_product_gallery', 'gallery-default' );

    // Thumbs slider.
    $classes[] = get_theme_mod( 'single_gallery_slider', 1 ) ? 'has-thumbs-slider' : 'has-thumbs-grid';

    // Output.
    echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
}
add_action( 'woocommerce_before_single_product_summary', 'emoza_single_product_wrap_before', -99 );

/**
 * Single product top area wrapper
 */
function emoza_single_product_wrap_after() {
	echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary', 'emoza_single_product_wrap_after', 9 );

/**
 * Filter single product Flexslider options
 */
function emoza_product_carousel_options( $options ) {

	$layout = get_theme_mod( 'single_product_gallery', 'gallery-default' );

	if ( 'gallery-single' === $layout ) {
		$options['controlNav'] = false;
		$options['directionNav'] = true;
	}

	if ( 'gallery-showcase' === $layout || 'gallery-full-width' === $layout ) {
		$options['controlNav'] = 'thumbnails';
		$options['directionNav'] = true;
	}

	return $options;
}
add_filter( 'woocommerce_single_product_carousel_options', 'emoza_product_carousel_options' );
