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
define( 'DB_NAME', 'dhizo_db' );

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
define( 'AUTH_KEY',         'N #jX:eFBnVu+Y6lep5d`<MLPQqpC[B?D^kunrAkLDaA@&h&&&(+L&Qp15kT4}o&' );
define( 'SECURE_AUTH_KEY',  'T7SqkT6P=R0HCAN{&OSToyM:/zLHLk6HsTT%kJ+P$)30(T(+sxdP`~(6+@~oZFxg' );
define( 'LOGGED_IN_KEY',    '(L@?7xya84;&p55IK[t`buw*2BTVFB*l#Wp~R$ kM?s!X%)5`V.SRfOh?TmJ96dD' );
define( 'NONCE_KEY',        'AY2_bkF&pFZY4AjJ]W4Ec+BCA^)B]`= W%{.+>!s%G:C`*J(n]*g(Pfnq4f_UkcQ' );
define( 'AUTH_SALT',        '0LF:/A$.L~/R9gi`EIL 3|h)p@CVWNtl#]4tz~*uY3[/m(NjCmM[!:~qkD(vZ=3>' );
define( 'SECURE_AUTH_SALT', 'jC-Y.hkIhP[ 0 63t*)aO]zf6dU_4F8ap9qkU.|aAHSWtRapK$uC:GB#;aF/ oT5' );
define( 'LOGGED_IN_SALT',   '+u$RH<B/6XH){qKNMfV1)8N:Y&1}|VpS%X^TZ0Z?&8_TTqw{S!S&*ir/ZW2O(D:A' );
define( 'NONCE_SALT',       ' 0ma&qo `u7#QhTt<8vs0rK2v@cCbDnZe59^0Z*vV=ig$?jT9>Jn&[(Q`.p.A&e/' );

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
