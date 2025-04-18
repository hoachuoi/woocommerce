<?php
/**
 * Schema Markup
 *
 * @package Emoza
 */

function emoza_get_schema( $location ) {

	if ( ! Emoza_Modules::is_module_active( 'schema-markup' ) ) {
		return;
	}

	switch ( $location ) {

		case 'html':
			if ( is_home() || is_front_page() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			} elseif ( is_category() || is_tag() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/Blog"';
			} elseif ( is_singular( 'post') ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/Article"';
			} elseif ( is_page() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			} else {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			}
		    break;

		case 'header':
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/WPHeader"';
			break;

		case 'article':
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/CreativeWork"';
			break;

		case 'blog':
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/Blog"';
			break;

		case 'search':
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/SearchResultsPage"';
			break;

		case 'logo':
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/Brand"';
			break;

		case 'nav':
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement"';
			break;

		case 'sidebar':
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/WPSideBar"';
			break;

		case 'footer':
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/WPFooter"';
			break;

		case 'thumbnail':
			$schema = 'itemscope="itemscope" itemprop="image" itemtype="https://schema.org/ImageObject"';
			break;

		case 'headline':
			$schema = 'itemprop="headline"';
			break;

		case 'entry_content':
			$schema = 'itemprop="text"';
			break;

		case 'published_date':
			$schema = 'itemprop="datePublished"';
			break;

		case 'modified_date':
			$schema = 'itemprop="dateModified"';
			break;

		case 'author':
			$schema = 'itemscope="itemscope" itemprop="author" itemtype="https://schema.org/Person"';
			break;

		case 'author_name':
			$schema = 'itemprop="name"';
			break;

		case 'author_url':
			$schema = 'itemprop="url"';
			break;

		case 'image':
			$schema = 'itemprop="image"';
			break;

		default:
			$schema = '';
			break;

	}

	/**
	 * Hook 'emoza_schema_'
	 *
	 * @since 1.0.0
	 */
	$schema = apply_filters( 'emoza_schema_'. $location, $schema );

	return $schema;
}

function emoza_schema( $location, $do_echo = true ) {
	if( $do_echo ) {
		echo emoza_get_schema( $location ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return emoza_get_schema( $location );
	}
}

/**
 * Attachment Image Scheme 
 */
function emoza_attachment_image_schema( $attr ) {

	if ( Emoza_Modules::is_module_active( 'schema-markup' ) ) {
    	$attr['itemprop'] = 'image';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'emoza_attachment_image_schema' );
