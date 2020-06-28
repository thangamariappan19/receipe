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
define( 'DB_NAME', 'receipe' );

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
define( 'AUTH_KEY',         'awWbT.q,C;D/S&sK2Cf/PaspH.-cKDcW#KT3GNw;/i)#@C-e%zOg_L]m]V:?WFm<' );
define( 'SECURE_AUTH_KEY',  ' 6.4j2[7!8pfw%zx27r@%!jAVqIBfsxz<b>vXA6jv-mld.=CBXE10gzQY+w]sq>(' );
define( 'LOGGED_IN_KEY',    '~G3gK_hIhm;vAE+ wP>d$sx4j~eV.2@.E*GbdTT.v<lfzoHF,1BVrKlBvpUE`Zf}' );
define( 'NONCE_KEY',        '#UH0Eqed@}t9=-~:geHRlMw1?}l]-r14$Md-4,p,)Ntix2;_d7`PXWbc8c`PP/uE' );
define( 'AUTH_SALT',        'j1Qkz1cw*gjOVu+Em7K1{RE}q(c>864$WcxE4o@WANyf37SVx,B5)x@Q$si><&}n' );
define( 'SECURE_AUTH_SALT', '-+A%9=h7+|cA/uA15A} A_m)r5+S9k:muS6.Tp`8np01_#Pc8|@tEmT(M(`cw;.4' );
define( 'LOGGED_IN_SALT',   'aN)iU=D-{oAoQVET|-I95~yk/g|3iL(1?4<:J<2G:T{#}:jdvr1.IP;}Lm/P!l$L' );
define( 'NONCE_SALT',       '5JvO|-yvHnra|F<Ieh0oi`/X+a4>6YuttE9)j*B`)NMv^UQ$<D0,JjSqI|q+!Vu>' );

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
