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
define('DB_NAME', 'wp_rit-safety');

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
define('AUTH_KEY',         'K :42!m(+~(0eVr4DB;len O060hMMa)6+!dJLA+;3N3(6B*a$cer%wE4D{|9-dk');
define('SECURE_AUTH_KEY',  '{+J15^Ih{b&e=R0itypc(%vXY:e3H%&Y5F6~@c*p%&f2NoX`rz]Xs.$T@v}A^kxb');
define('LOGGED_IN_KEY',    'Ycx_,@3#|ANS~aF24~M6%/5ai_`fe!wCw`Z4|*GL9zl8>$+tNlI>2K(<u@T8-XJd');
define('NONCE_KEY',        '(-;isEEs?[jo5|;{`o2*N1th)&>U-K5U4xL7*u 5~H3tQ#?YyJL#/QIb/0r+_eRZ');
define('AUTH_SALT',        'FCjUR$hAwG `=|tbnwJ3/o[VG< oKdb}Mt6M&GkGwJ***r`E>DH2i4+Aq5~<7=jS');
define('SECURE_AUTH_SALT', '%E-o*-=R8y%67R)Av^VwRNF/!NK>XxWD-l_&:[*[J`WZgc=EGs$qeQ}Z|CY-((YM');
define('LOGGED_IN_SALT',   'u|?~Ykl|N7qdo,o>d8vA.&`cnQ#boN:H*?B(<dqf^lr?*>.]J]<Ph,RFNc/q2Oeh');
define('NONCE_SALT',       'J7D}HsESDAVAw~:o*`D0jxi6QBwE)_}UcKm8)3[8C|2##IAia]UaV<s@Hu<sO;s.');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
