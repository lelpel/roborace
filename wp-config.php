<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'roboracedb');

/** MySQL database username */
define('DB_USER', 'mysql');

/** MySQL database password */
define('DB_PASSWORD', 'basta');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1:3306');

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
define('AUTH_KEY',         '`/.zjo6AG9^ucn#BW3|%QTp&Kw,h9fI,]u0XD.px=+<_Zz9+QYOvv+F|X0n$ZH%I');
define('SECURE_AUTH_KEY',  'WuEVnT+1kRt1;A>qd~^F5+.(,M=Mn_)Z!SKqsXW1-OMhsBpMg-#EkLH<_d|$g-xk');
define('LOGGED_IN_KEY',    ')7&<Oq2|At!y<e|))8W1)8g$-pfRjOq!:b/I|9r,La6=-Kff.<A,QKZnti=ss.<4');
define('NONCE_KEY',        '}/ ftP:}ZT#rM8`[Z>9Y[]|-;`OBi?euBXEJj)vZ.Xx{-yaku&GC<f :|?VtSM$p');
define('AUTH_SALT',        'ILvM}ii-UX^U|7?xeO<<UQ~|<vQ,V96Q0Vb~osuIrkj(daDl:ea8{E.wY3Xzkk/z');
define('SECURE_AUTH_SALT', 'Q?aL#CQH-6~wTu4UcnZFedd?KRnK>!Unc.=Y-jb;GRXqpqxkBeE]~qo*$NBJ Y0!');
define('LOGGED_IN_SALT',   'UCmW8DEbsajXY-eG! idN9$|fcI::*f~wmgB_6+4FVQF*pt](Xo$0bQB r9LnN[S');
define('NONCE_SALT',       'T>u%fk8;0>[>DdqoW6|VtUxdX9&/^Dt,GvbzdU uYzs_J1L $`l8-c|5XX+h^iWC');

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
