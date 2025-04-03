<?php
/**
 * Header/Footer Builder
 * Contact Info Component
 * 
 * @package Emoza_Pro
 */ ?>

<div class="ehfb-builder-item ehfb-component-contact_info" data-component-id="contact_info">
    <?php 
    $this->customizer_edit_button();
    
    // @codingStandardsIgnoreStart WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $email 	        = get_theme_mod( 'header_contact_mail', esc_html__( 'office@example.org', 'emoza-woocommerce' ) );
    $phone	        = get_theme_mod( 'header_contact_phone', esc_html__( '111222333', 'emoza-woocommerce' ) ); 
    $display_inline = get_theme_mod( 'ehfb_contact_info_display_inline', 0 ); 
    // @codingStandardsIgnoreEnd WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

    ?>

    <div class="header-contact<?php echo ( $display_inline ? ' header-contact-inline' : '' ); ?>">
        <?php if ( $email ) : ?>
            <a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><i class="ws-svg-icon"><?php emoza_get_svg_icon( 'icon-mail', true ); ?></i><?php echo esc_html( antispambot( $email ) ); ?></a>
        <?php endif; ?>
        <?php if ( $phone ) : ?>
            <a href="tel:<?php echo esc_attr( $phone ); ?>"><i class="ws-svg-icon"><?php emoza_get_svg_icon( 'icon-phone', true ); ?></i><?php echo esc_html( $phone ); ?></a>
        <?php endif; ?>					
    </div>
</div>