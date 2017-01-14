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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_purpod100');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'bhPTFWfoZV0d>2ug+|^/tNEfr9&/`T4LMg3bT~KFWs1o*Z)y6G%-IZYW}*EOzF2:');
define('SECURE_AUTH_KEY',  '|a*8cod;WX$=o_5W^MoXy+cnX/hPpu)IKWHox^Gz)P?sucVYjv)3zl*x0?|sV#^Z');
define('LOGGED_IN_KEY',    '3v 9FEiPh5k`73dly6s7x|5eE$lBB_nr3tDQHzpUTdvI_P;mmXh2|b[b6|DA.|or');
define('NONCE_KEY',        '8/YT9VW{#-QDxQQaxzi// ?nqdtD4|V6atPE?`X;g`Kk?8pSz3;G6KUFLOe)do+G');
define('AUTH_SALT',        'LsZVrW]FO8[|RFV/~(Ur+BBLJ~[]3Ug&5;?JOxVt[rJ&241I,y+Gu%PLaY9,Elv>');
define('SECURE_AUTH_SALT', 'u_t32<[}3d %{Sl_9|j?*A6YjpJvg*;.crxMS62rY:@5t?*ZZW_1Z>PF38PJX[}V');
define('LOGGED_IN_SALT',   'M,]*jy[kBpmFW,)[TiX)Nciy0,ui#D<zzO-|0qGWXBy$3>ULXc;y_r:-Bo+y;|2 ');
define('NONCE_SALT',       '8Z78xI6c@4t/Z|llg^mgB2Yo]q8lUL[[AsQo7@d+ri)X-P9c4+9h*]4jL3ZYx>F{');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
