<?php
/**
 * Customizer
 * Ajax callback functions
 *
 * @package Emoza
 */

/**
 * Adobe fonts control kits ajax callback
 */
function emoza_typography_adobe_kits_control() {
	check_ajax_referer( 'customize-typography-adobe-kits-control-nonce', 'nonce' );

    $token = isset( $_POST['token'] ) ? wp_strip_all_tags( wp_unslash( $_POST['token'] ) ) : '';
    
    $url       = 'https://typekit.com/api/v1/json/kits/';
    $response  = wp_remote_request( $url . '?token=' . esc_attr( $token ), array() );

    if ( wp_remote_retrieve_response_code( $response ) !== 200 ) {
        update_option( 'emoza_adobe_fonts_kits', array() );

        wp_send_json( array(
            'status' => 'error',
            'output' => '<p>' . esc_html__( 'Invalid API token.', 'emoza-woocommerce' ) . '</p>',
        ) );
    }

    $fonts = array();
    $response_body = json_decode( wp_remote_retrieve_body( $response ) );
    foreach( $response_body->kits as $kit ) {
        $url       = 'https://typekit.com/api/v1/json/kits/' . esc_attr( $kit->id ) . '?token=' . esc_attr( $token );
		$response  = wp_remote_request( $url, array() );

		if ( wp_remote_retrieve_response_code( $response ) === 200 ) {
			$response_body = json_decode( wp_remote_retrieve_body( $response ) );

            $fonts[ $response_body->kit->id ] = array(
                'enable'       => true,
                'project_name' => $response_body->kit->name,
            );

            foreach( $response_body->kit->families as $family ) {
                $fonts[ $response_body->kit->id ][ 'families' ][] = array(
                    'name'       => $family->name,
                    'css_name'   => $family->css_names,
                    'css_stack'  => $family->css_stack,
                    'subset'     => $family->subset,
                    'variations' => $family->variations,
                );
            }

            update_option( 'emoza_adobe_fonts_kits', $fonts );
		}
    }

    // Token is valid 
    // But there's no fonts attached to the token
    if( count( $fonts ) === 0 ) {
        $output = sprintf(
            /* translators: 1: Adobe Fonts docs link */
            __( 'Your API token is valid but you don\'t have fonts attached to this token. Click <a href="%s" target="_blank">here</a> to learn more about that.', 'emoza-woocommerce' ),
            'https://docs.emoza.org/'
        );

        if( defined( 'EMOZA_WL_ACTIVE' ) ) {
            $output = __( 'Your API token is valid but you don\'t have fonts attached to this token.', 'emoza-woocommerce' );
        }

        wp_send_json( array(
            'status'  => 'error',
            'output'  => '<p>' . wp_kses_post( $output ) . '</p>',
        ) );
    }

    // Success. 
    // There's fonts attached to the token
    wp_send_json( array(
        'status'  => 'success',
        'output'  => emoza_customize_control_adobe_font_kits_output( get_option( 'emoza_adobe_fonts_kits' ), false ),
    ) );
}
add_action('wp_ajax_emoza_typography_adobe_kits_control', 'emoza_typography_adobe_kits_control');

/**
 * Adobe fonts control enable/disable kits ajax callback
 */
function emoza_typography_adobe_kits_control_enable_disable() {
	check_ajax_referer( 'customize-typography-adobe-kits-control-onoff-nonce', 'nonce' );

    $kit_id = isset( $_POST['kit'] ) ? wp_strip_all_tags( wp_unslash( $_POST['kit'] ) ) : '';
    
    $kits = get_option( 'emoza_adobe_fonts_kits', false );

    if( $kits[ $kit_id ]['enable'] ) {
        $kits[ $kit_id ]['enable'] = 0;
    } else {
        $kits[ $kit_id ]['enable'] = 1;
    }

    update_option( 'emoza_adobe_fonts_kits', $kits );

    wp_send_json( array(
        'status'      => 'success',
        'kit_id'      => $kit_id,
        'kit_enabled' => $kits[ $kit_id ]['enable'],
    ) );
}
add_action('wp_ajax_emoza_typography_adobe_kits_control_enable_disable', 'emoza_typography_adobe_kits_control_enable_disable');

/**
 * Create page control ajax callback
 */
function emoza_create_page_control() {
	check_ajax_referer( 'customize-create-page-control-nonce', 'nonce' );
    
    $page_title      = isset( $_POST['page_title'] ) ? wp_strip_all_tags( wp_unslash( $_POST['page_title'] ) ) : '';
    $page_meta_key   = isset( $_POST['page_meta_key'] ) ? sanitize_text_field( wp_unslash( $_POST['page_meta_key'] ) ) : '';
    $page_meta_value = isset( $_POST['page_meta_value'] ) ? sanitize_text_field( wp_unslash( $_POST['page_meta_value'] ) ) : '';
    $option_name     = isset( $_POST['option_name'] ) ? sanitize_text_field( wp_unslash( $_POST['option_name'] ) ) : '';

    $meta_input = array();
    if( $page_meta_key && $page_meta_value ) { 
        $meta_input = array(
            $page_meta_key => $page_meta_value,
        );
    }

    $postarr = array(
        'post_type'    => 'page',
        'post_status'  => 'publish',
        'post_title'    => $page_title,
        'post_content' => '',
        'meta_input'   => $meta_input,
    );

	$page_id = wp_insert_post( $postarr );

    if( ! is_wp_error( $page_id ) ) {
        if( $option_name ) {
            update_option( wp_unslash( $option_name ), $page_id );
        }

        wp_send_json( array(
            'status'  => 'success',
            'page_id' => $page_id,
        ) );
    } else {
        wp_send_json( array(
            'status'  => 'error',
        ) );
    }
}
add_action('wp_ajax_emoza_create_page_control', 'emoza_create_page_control');

/**
 * Display conditions ajax callback
 */
function emoza_display_conditions_select_ajax() {
    $term   = ( isset( $_GET['term'] ) ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';
    $nonce  = ( isset( $_GET['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_GET['nonce'] ) ) : '';
    $source = ( isset( $_GET['source'] ) ) ? sanitize_text_field( wp_unslash( $_GET['source'] ) ) : '';

    if ( ! empty( $term ) && ! empty( $source ) && ! empty( $nonce ) && wp_verify_nonce( $nonce, 'emoza_ajax_nonce' ) ) {
        $options = emoza_get_display_conditions_select_options( $term, $source );
        
        wp_send_json_success( $options );
    } else {
        wp_send_json_error();
    }
}
add_action( 'wp_ajax_emoza_display_conditions_select_ajax', 'emoza_display_conditions_select_ajax' );
