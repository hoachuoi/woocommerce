<?php

/**
 * Settings - General
 * 
 * @package Dashboard
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>

<div class="emoza-dashboard-card emoza-dashboard-card-no-box-shadow">
    <div class="emoza-dashboard-card-body emoza-dashboard-card-body-content-with-dividers">
       
        <?php if ( defined( 'EMOZA_PRO_VERSION' ) ) : ?>

            <div class="emoza-dashboard-license-wrapper">
                <h2 class="em-mb-10px"><?php echo esc_html__( 'Emoza Pro License', 'emoza-woocommerce' ); ?></h2>
                <p class="em-text-color-grey em-mb-20px"><?php echo esc_html__( 'Activate your license key for Emoza Pro to get the latest theme updates automatically right from your WordPress Dashboard.', 'emoza-woocommerce' ); ?> </p>
                <?php 
                /**
                 * Hook 'emoza_pro_license_form'
                 *
                 * @since 1.0.0
                 */
                do_action( 'emoza_pro_license_form' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound ?>
                <div class="emoza-dashboard-content-expand em-mt-20px" data-em-toggle-expand style="max-width: 360px;">
                    <div class="emoza-dashboard-content-expand-title">
                        <a href="#" class="emoza-dashboard-content-expand-link">
                            <?php echo emoza_dashboard_get_setting_icon( 'info' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            <?php echo esc_html__( 'Instructions', 'emoza-woocommerce' ); ?>
                        </a>
                    </div>
                    <div class="emoza-dashboard-content-expand-content em-toggle-expand-content">
                        <ul class="emoza-dashboard-content-expand-list">
                            <li>
                                <?php echo emoza_dashboard_get_setting_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <?php 
                                printf(
                                    /* translators: 1: emoza website login url */
                                    esc_html__( 'To get your license key, please login to your %1$sAccount%2$s.', 'emoza-woocommerce' ),
                                    '<a href="https://www.emoza.org/account" target="_blank">',
                                    '</a>'
                                ); ?>
                            </li>
                            <li class="">
                                <?php echo emoza_dashboard_get_setting_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <?php echo esc_html__( 'After Copying your license key, click the below button for activation.', 'emoza-woocommerce' ); ?>
                                
                            </li>
                            <li>
                                <a href="<?php echo esc_url( admin_url( 'admin.php?page=emoza-dashboard&action=restart_freemius&action=reset_anonymous_mode&fs_unique_affix=emoza-woocommerce-premium-theme' ) ) ?>" class="button button-primary button-medium"><?php echo esc_html__( 'Activate', 'emoza-woocommerce' ); ?></a>
                            </li>
                            <li class="hidden">
                                <?php echo emoza_dashboard_get_setting_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <?php 
                                printf( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    /* translators: 1: key icon */
                                    esc_html__( 'Under the Licenses tab, click on the %s key icon next to your product name. Copy and paste the key in the field above.', 'emoza-woocommerce' ),
                                    '<i>🔑</i>'
                                ); ?>
                            </li>
                            <li class="hidden">
                                <?php echo emoza_dashboard_get_setting_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <?php echo esc_html__( 'Click the blue Activate button above. Congratulations! Your key is now activated.', 'emoza-woocommerce' ); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        <?php else : ?>

            <div class="emoza-dashboard-module-card">
                <div class="emoza-dashboard-module-card-header">
                    <div class="emoza-dashboard-module-card-header-info">
                        <h2 class="em-mb-10px"><?php echo esc_html__( 'Boost Your Store with Enhanced Premium Features', 'emoza-woocommerce' ); ?></h2>
                        <p class="em-text-color-grey"><?php echo esc_html__( 'Accelerate your brand’s growth with a theme crafted for high conversions. Emoza Pro combines a sleek design with powerful features to drive sales and elevate your brand. Join hundreds of successful entrepreneurs who have transformed their websites and taken their business to the next level with Emoza Pro.', 'emoza-woocommerce' ); ?></p>
                    </div>
                    <div class="emoza-dashboard-module-card-header-actions">
                        <a href="<?php echo esc_url( $this->settings['upgrade_pro'] ); ?>" class="emoza-dashboard-external-link" target="_blank">
                            <?php echo esc_html__( 'Upgrade Now', 'emoza-woocommerce' ); ?>
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.4375 0H8.25C7.94531 0 7.66406 0.1875 7.54688 0.492188C7.42969 0.773438 7.5 1.10156 7.71094 1.3125L8.67188 2.27344L4.14844 6.79688C3.84375 7.07812 3.84375 7.57031 4.14844 7.85156C4.28906 7.99219 4.47656 8.0625 4.6875 8.0625C4.875 8.0625 5.0625 7.99219 5.20312 7.85156L9.72656 3.32812L10.6875 4.28906C10.8281 4.42969 11.0156 4.5 11.2266 4.5C11.3203 4.5 11.4141 4.5 11.5078 4.45312C11.8125 4.33594 12 4.05469 12 3.75V0.5625C12 0.257812 11.7422 0 11.4375 0ZM9.1875 7.5C8.85938 7.5 8.625 7.75781 8.625 8.0625V10.6875C8.625 10.8047 8.53125 10.875 8.4375 10.875H1.3125C1.19531 10.875 1.125 10.8047 1.125 10.6875V3.5625C1.125 3.46875 1.19531 3.375 1.3125 3.375H3.9375C4.24219 3.375 4.5 3.14062 4.5 2.8125C4.5 2.50781 4.24219 2.25 3.9375 2.25H1.3125C0.585938 2.25 0 2.85938 0 3.5625V10.6875C0 11.4141 0.585938 12 1.3125 12H8.4375C9.14062 12 9.75 11.4141 9.75 10.6875V8.0625C9.75 7.75781 9.49219 7.5 9.1875 7.5Z" fill="#2271b1"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>