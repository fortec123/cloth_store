<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'cloth_store' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'G PHw$`#A)l<brXbN6=oh-NphLbH*E=G]DyF.jGy5vL.=G3ob#*(cq!p9Q{Nc`:#' );
define( 'SECURE_AUTH_KEY',  '<}~cx#!_JL-s$Xjatd6LeQp.m4_wRu}`n1))hOg.Z+v<?}+M@ (]3H&!dl/.NuNH' );
define( 'LOGGED_IN_KEY',    'AD^$&E{tqL~zCHML[x~:k`F?C:bKLxWhn{|%VnJK-Qi:me{lP$(=2C[vIFd_4$-:' );
define( 'NONCE_KEY',        'Wt_Fqb!8QMX+_$gZ:fi#DI)x_u.e!KwY9r#ZNgoBLCei277m(n/q|UL/5PDKA7Ct' );
define( 'AUTH_SALT',        '1y0k#/P3%D&7)LZ6ruHx|CH/^[83$}Xn4jrL{uRNdc1KX=HWDmqD)=|RcYZ)UYjG' );
define( 'SECURE_AUTH_SALT', '*E.^IV_Ut}Ni5zSG),LPF7zOadg]eD1/2cZXD&6@!d~EHE .r#>V1Tn]n}!-VMO{' );
define( 'LOGGED_IN_SALT',   '#F*&Y^LZhR,j`nPDTT5u$K|vc0.:`vIFFP!t|U,:2 <D?v[5z?EUwvTXA+uVJ#>0' );
define( 'NONCE_SALT',       '|oP<3iPvn2_!KIvEPgTVqv{3huc&ATLnmX;S@r6M^4.Fwu;G>F%d%=B@fgIE<qdo' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
