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
define( 'DB_NAME', 'wp_piscina' );

/** Database username */
define( 'DB_USER', 'enkit' );

/** Database password */
define( 'DB_PASSWORD', '123' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('FS_METHOD', 'direct');

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
define( 'AUTH_KEY',         '4-C>{T,1z|HNT0t{<y:0kF)kfJq;FHTV:{[;Z[e.-|OPqi)O7KKcyjcz!>Mx-PY7' );
define( 'SECURE_AUTH_KEY',  ')|Xr@3Jp_Dj;wlY|0GUVPR/tI9LV=DTzuf%Ap)tp,%K[NcLuZ6>!b~T-^GY-$-)w' );
define( 'LOGGED_IN_KEY',    'AjTRFSrPn4nT)CE=SyNN<WKb}FxJ6OXkiW@zPA*_-9,:Y<x34eo=2pX-}UFd:+<2' );
define( 'NONCE_KEY',        'bjfV,#fk/6D-4*{(%>1F)yg*CM5v-.nbkfZjTL?FFK6^)H$u^,=xgQ2m5^w=:NCn' );
define( 'AUTH_SALT',        '?Wx!Ul<M2I~yqW0MXK9f@TzNs=c@#)$b!1o.y<9M:mxdc./PmWlc/k8FA}vI=Xc=' );
define( 'SECURE_AUTH_SALT', '&K!c-iY3O-V}p0YC3=*`FU6GlcT[+l?LGf&><2Z{f9Njb)pnknjTD;}.p2wI_us=' );
define( 'LOGGED_IN_SALT',   'b`nf[V&x(w^)-7m62:*rE(YeDYmDUZ?#asxMd.?aCM,Xs|*fWjs;Dt{OpD?p[=pb' );
define( 'NONCE_SALT',       '/.)JOxDMZ$/i&?jfO57!`2n(}F+fpGE)_$Nsiwv4R;|RR@LQ5iNo_{};rvCVa@m9' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
