<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '123456' );

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
define( 'AUTH_KEY',         '#KMy~9Us{>.<TFM}t>0fpB9elR/x.tNzu@HKlPJnWC1KmS*kBAp2F61hXP&`93v=' );
define( 'SECURE_AUTH_KEY',  ')g(FIuCwd/d$O4e@uZfshV/wq.d[qv>iYE^5bOeEK~J(_vr245HVb`%*;pjER7_X' );
define( 'LOGGED_IN_KEY',    'ke*O}1at!3`Sta@J/*n?]&~ZnyAx8aS2M.x23jlv9O~tvzD]}&Vm[qerdVufG1n.' );
define( 'NONCE_KEY',        '84}D<fvR;qQu$PK4lg!qXWXK?U3|z9+W%6<7Lx{<Fo/ck&WeKlU~^FBT+YQ}5Ou$' );
define( 'AUTH_SALT',        '3ywj,2&RLcPsM+)<p`pa1^^A|!K:6E4z0<T&ZknfnMUTE@oaO<QB||QwN2&D(mX!' );
define( 'SECURE_AUTH_SALT', '0O0uDa_REvv=it:.P+sx`vg9i&}(e-O&>02]3Wy?Na!D}+~:ag))3E-~`pvmKdN;' );
define( 'LOGGED_IN_SALT',   'eRO+dt|U^#wCqb}R$wt/D;DZm%+(W7{;rx|b(`DXr?Xud}xv@Y|2]Gu=UxgX3r9Y' );
define( 'NONCE_SALT',       '6t?!;v@vm+14p>aC2WdJKb.1bM6Sn=P`d0#B:CjNAqPf?1<2g#pXOQdrM+f}#l_V' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
