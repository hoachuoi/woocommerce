<?php
/**
 * WooCommerce Brands Compatibility File Functions
 *
 * @package Emoza
 */

/**
 * Single product elements 'Brand' output
 * 
 */
function emoza_wc_brands_brand() {
    $width  = get_theme_mod( 'emoza_wc_brands_brand_image_width', 65 );
    $height = get_theme_mod( 'emoza_wc_brands_brand_image_height', 65 );

    echo '<div class="emoza-wc-brands-brand-wrapper">';
        echo do_shortcode( "[product_brand width=\"{$width}px\" height=\"{$height}px\" class=\"emoza-wc-brands-brand-image\"]" );
    echo '</div>';
}
