<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'woocommerce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'bacdz2002' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'B6]Y%_83_-X/z-3iI6KrhXlOcB~wHd#&5R1H7NAw}#{+C+d6Pt7cfE{V+KMNY2rB' );
define( 'SECURE_AUTH_KEY',  '@5|0 ?BkIH%~Y2[k125SChQF{VFN@!?]AZeU~;Do,:WC!oKvz(BQvC6<ae;vc}=D' );
define( 'LOGGED_IN_KEY',    'o |p0 eil4JR+=SEs1/v6:/H)Q3i=I?T1^`q>8+@R;jCo+eJ4c2?is~tk-XMOV;=' );
define( 'NONCE_KEY',        'Gzt1kYMh53bp[aTen+kv,7a-ARvi<48Es^o-_^ZI0Sc_6OP(a_WFEgm8YB#cP.r=' );
define( 'AUTH_SALT',        'c&juvA0Vy6!9cFkA#kI(o@brHGIP%Zt_-$_5}ick91I~j.XfbWEzp]@uqueI:{Ee' );
define( 'SECURE_AUTH_SALT', 'Ei!*JRrRKce@*!L&ja;Q>VXcnWFZ7%.o<I4iTIZE4~`IM0[oo@H)B^p*1::F`W1c' );
define( 'LOGGED_IN_SALT',   '2NYsuI#|CYKm`SB.btHoPebW+GBr.@|%J09*Ib1>ngZ!))eQ:5ZapRYV/^e}9!Za' );
define( 'NONCE_SALT',       'o%04@Z/ fS}&]o_FogE:FYS*poU;@#.>T~t_y4T{5n|r!iYkqZBVFCq{!u%+FW#Q' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true);
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
