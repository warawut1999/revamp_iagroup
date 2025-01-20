<?php
//Begin Really Simple Security session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple Security cookie settings
//Begin Really Simple Security key
define('RSSSL_KEY', 'MMhRj1iAaRmjmNoPZXkofpjGsLqfa1qg2IJYmSbG8d2ZwDGY0bzlkOruQJTf1QpB');
//END Really Simple Security key

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
define( 'DB_NAME', 'wordpressdb' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'P;AnG<H2BavreTo9Hd|z/<xr!n4~?oY+hr?^O|FQoSq4L@L*ML[fE9L~3?Q=JD,g' );
define( 'SECURE_AUTH_KEY',  '5xL7vJQB@eN{&ji?!r`W&AP]XhxjN~|hu[B$C0N@M7Jx+J.HlcOO-^.r)&&^6oP<' );
define( 'LOGGED_IN_KEY',    'h}H.#U$3F{5X=z+I27f#5n:!P!90Qf5!jVx48)*{k69eB9Ed:G]r^`> Hp^yn]nV' );
define( 'NONCE_KEY',        'Bnbo:$Sh?.;{$r>Ql;cJwK^]pMg3_T#g7M-VJ 8!i)b[rBO_[fEWGlSY|_Y|Uu,u' );
define( 'AUTH_SALT',        '2+>*H+I&T~YjR$gjn?<+Fz;2&VouR<o#FIR{ZUBv<BZ=J^7yBbi%11Zajs&)TZx_' );
define( 'SECURE_AUTH_SALT', '=?Xs0at:pWg.9er*SQJyq}XP+@*5R-uZ6L+xQ[:6fAxCHqAKY~J-vILD-&Y#JfNF' );
define( 'LOGGED_IN_SALT',   '~}WI-/(VjomR$#n(P@ExNx|uUN|5TLr>:@G$Z>]Na~JVH?&U@[x%)FE&8Q[QRdrr' );
define( 'NONCE_SALT',       '0:=Wn#{Tdv6:en!E&p<7?9s}vc)zf$R;hA^Q[anfOUYy+,T;QcrO,{`IxY*x!|De' );

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
$table_prefix = 'mywp_';

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
