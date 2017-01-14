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
define('DB_NAME', 'wp_norwegian_directory');

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
define('AUTH_KEY',         '!!1[<<z01JJj1t|^^:5n@gU(Ld-e7aLYe/ViIHMcYkldI_at9uW}`NH!o&tH5$Vm');
define('SECURE_AUTH_KEY',  'G-q>U9Z0L|Ocb$).yS+.vULDd?0.!}]Cfa;7(b@],7I28=WzirhpMIv({O6-#0df');
define('LOGGED_IN_KEY',    '|SqH+]#;WsosKn@4:~F?km~ivH3mu$)6H$i@: ]sO>XUE4sjSmi|6T/7u<^:$>aV');
define('NONCE_KEY',        'D(<fAWn`(2lW`LRI/!8ueOvLV!|I7l(EA]-{<oh%LKpP#[-@:wg9`.R[N-8}7}A)');
define('AUTH_SALT',        '!:5p&:KHDpg0vP$+/;DKy4fi&n+-sJJJ< M6ivqhP+^kG}4KZ.aL_f6O+{*-O?da');
define('SECURE_AUTH_SALT', 'Ykw9pN6`x6U6s?aBw-]i7^px+dDJDu/U~TP8K*-Luy |jLOL,m?B6C[w{]:z(8`1');
define('LOGGED_IN_SALT',   'Wr|>|<&E1kmr`@EAgT([As{w29Xt7JuAZM^^U&hX]M1PQ>E>HPh^~Kdvp^B$_-V-');
define('NONCE_SALT',       '7j>*kao!.,de&(|$H}/m:NJMuHr**A;lO-Fb&O-d:6K<k}|(/-WcP%$QX:?EH-!s');

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
