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
define('DB_HOST', 'localhost:3306');

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
define('AUTH_KEY',         '9Xu@7)9c}BiiV&mBnqLVh(a~:|B%u+t&TMi@?QsH[@-LZaSFX%24Ky@4^}aXyUQ}');
define('SECURE_AUTH_KEY',  'Cr/W|m@37@*?PUmN7@5c(B-gtV-gru?I;Hc8QaMv^}FN_hFN~ht.-eNJ5E*V.h?V');
define('LOGGED_IN_KEY',    'pe!j=}x*Z6=iD:?XXDyRnKCES+~z)|a}cO3`mA(s!lhn&ki4n36e{k(FeE3=x[q5');
define('NONCE_KEY',        'x4SCw|x0zm5tT?M|3X(+4h?6<D^r?SS*VJu)6bLa5wk+U-AK|r<y^:h7bi3g(ZJx');
define('AUTH_SALT',        '~]3- 1VdK-T|U|.XU?cL?Wpa?%wWinV/b]6`!qrg*BXHdGCBm]qd!h?LZX2R,+a3');
define('SECURE_AUTH_SALT', ',Mj*_Lfu]WI7VO|cAPMFAz4U7mH Zqo3Xr`ur@DuV|lNh.pE#8iqk_LJKQoe?60,');
define('LOGGED_IN_SALT',   's*6j |29Cq-HARGn%|sznO?D=FLr4FZ|y+nL X:WILqg}c9KL?6!~SuM8H1g6PC+');
define('NONCE_SALT',       ')FdCYz(s^T#6B!0}`@$ic$.h&b8|5lInaeVf&~#EE<DYp8 {G0]T+W%c!{f,gThR');

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
