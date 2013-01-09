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
define('DB_NAME', 'wattspor_database');

/** MySQL database username */
define('DB_USER', 'wattspor');

/** MySQL database password */
define('DB_PASSWORD', 'wattball10');

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
define('AUTH_KEY',         './{;It:?NI-wT8e)(HZP+*ex},-/Q>upzFp|u87(p+++]wotu2gcGj}cDyAz}EBF');
define('SECURE_AUTH_KEY',  'J#6`_DPrk tP&&6}F&/H3Bn&tS_OoY~2q73V-+1X}f`|HnVwvS!5y}P7)<!?K-$,');
define('LOGGED_IN_KEY',    '%95end=z[-DA9c2TtdY`6S%Y%ZZ|aktzfP09:Y7&|LW]Yo:v#NN+zL<,TN#>&|4T');
define('NONCE_KEY',        'V-G{L+n_p`NY=n1(>Az+/jK0D`ihg}S-#0k3pGH,j4G(;,&Cs}||P2QIaIe8vZ|U');
define('AUTH_SALT',        'EXh+P4hjVoX{-nef9NL<@+/EB6qa*!cLvxabMhXD8@094rE(T|#R#4C8XcWWdx!-');
define('SECURE_AUTH_SALT', 'b;c<5nqU:hb`HGZLzyu{(dtu%/O7JW;r:R7SBiU9 c`5`ALrysb1)N<I5<#n$gnT');
define('LOGGED_IN_SALT',   '.~Bj?_+_9}ok?p#}AW:d!.GR0x`;hH5?U0-l;vBD7|b_xX<*58|`mM#cSE9][l(O');
define('NONCE_SALT',       '~?Nx|~C-+F#lRD+b?0 Hp.{K)5rcn4V-`5pgi*Z^D.rd61KzJ<rx<yfT||/d-m]x');

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

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
