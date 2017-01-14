<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_polwarth');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '[_3Ps5WX! $ET-5ZmLJOp7*W?.u.k=uDo<L_SJsC+U-XvixI<t!xynF>t$}tCmG6');
define('SECURE_AUTH_KEY',  '85FH;ucF$Dy`az(--,s1FC8PNkPCD?cRZG-~Rv3(bBtc#%L}860?p7sd-)e^Z6&R');
define('LOGGED_IN_KEY',    '~]Bhsm]|5dNXOC9cI;Gc`z=f#lXrAlkQePp:ry-qFc/a4Z+%-Xr%M2zt;CNjQs,_');
define('NONCE_KEY',        'jc<+M?8AC!J9F*1[C2Rr6(1/hFZmF>~}QK/4N1^8?0-~>|P 5dy8?zX[}#n]3W3o');
define('AUTH_SALT',        'Kk+<M+rM0R+VOj;Xs`/ZKyeY;y3m$y|iE30bf!Dn9{[I[k*7z`OXlYF~Oswwi-^A');
define('SECURE_AUTH_SALT', 'tf#BCja6l#/-$@ !fmM/H)0w-i{-{I)80]NkNgj3!d(pdCz&H%d<{-.94x^g)_iP');
define('LOGGED_IN_SALT',   '~[k{TnxZ 4|+;FV_vW<,q) &2oHTi9U6hSJk-!wk~Pc;i<2B+?0LpZ^jL1gGNSoL');
define('NONCE_SALT',       'kN 9cuR4ar%O*+[cexWo36q|}&X/Fe76pcI!l|~k .os>Cqrsr~Q8?Mn?e&Lcjnv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

require_once 'mobile_detect/Short_Mobile_Detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
define('DEVICE_TYPE', $deviceType);

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
