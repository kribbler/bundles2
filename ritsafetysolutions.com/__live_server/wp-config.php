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
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '');

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
define('AUTH_KEY',         'Da?L4]~XvJ#P<6f?C8V:N&,-&Zm=M$}QCy##>l=,^CJm!&Z4X{R|XL[fTI76f+3-');
define('SECURE_AUTH_KEY',  '+g+iO&$IkfpyOMZI[IRs)Iq2YLf.Y$K<& Uq$Krvl8v|YRK2cz`U9sYj, 6/B3nE');
define('LOGGED_IN_KEY',    '.<Wj]b_A~_lZJjZ-q~6sFo24-?evXkp0a|ZBK2*NnO.m0-$u^`&FPUfoBPy}$=3)');
define('NONCE_KEY',        ':=!OVL)9|lX-32V|mSo ^Ffs(6`Xh^JiV}Ff71[F87 ~%IobK*nPz<97?WZ=6H>O');
define('AUTH_SALT',        'ysTbwe6 vmR!,!19BGr9=*qvPcgO9~3I$P5,5>9^h,(Hb/+.2!}}/Xb~`,8=tclU');
define('SECURE_AUTH_SALT', 'f6`1B^0x gNY/.uT[,}9+AUU1q7c2S|2d9P!@7<Ssh{:|s5]xw!lC%_W:B<Yh`WZ');
define('LOGGED_IN_SALT',   'Z?r3L!%SpEB(Fi J>uhUd+V@co/HAY4=N#A}mmR01^<|s40]-Ah@<Ng`/ST$t|qN');
define('NONCE_SALT',       ' pE+B0g|9-&gRUFIr:>;aKRB|Qb`-lM]Wl>ZZAjAPEyn$@?o}|y$|^0@LR00X)9O');

/**#@-*/

/**
* WordPress Database Table prefix.
*
* You can have multiple installations in one database if you give each a unique
* prefix. Only numbers, letters, and underscores please!
*/
$table_prefix  = 'nptz9h_';

/**
* WordPress Localized Language, defaults to English.
*
* Change this to localize WordPress. A corresponding MO file for the chosen
* language must be installed to wp-content/languages. For example, install
* de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
* language support.
*/
define('WPLANG', '');
define('WP_MEMORY_LIMIT', '64M');

/**
* For developers: WordPress debugging mode.
*
* Change this to true to enable the display of notices during development.
* It is strongly recommended that plugin and theme developers use WP_DEBUG
* in their development environments.
*/
if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163'){
	define('WP_DEBUG', false);
}
else define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

