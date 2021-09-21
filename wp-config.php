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
define( 'DB_NAME', 'allianz' );

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
define( 'AUTH_KEY',         '+/-J)i(,MUmoAg&`=:MRth[/s{La1P6s%uo9V:2hF-zTER7o9aD9>NbOY2]*5o^)' );
define( 'SECURE_AUTH_KEY',  'ZwUyke:PPWt6tueU.p>L0ub`P(sF.UFd,B(q)-eE7BxTkR0c>fYj8>r@ARqhC_LX' );
define( 'LOGGED_IN_KEY',    'tvNzm(JT)*;/*<tzrM/Ddm%C$M<xQcj-huAEqu!@-am{X^rq-4h,d5r_=_GLNN9}' );
define( 'NONCE_KEY',        'Me8UAk}`9-SHJefuQRsMZ9%P[N|?.UbmWpW,#cFylhJ/hZ6)(;k [;y&A}cn8Q1h' );
define( 'AUTH_SALT',        'BzNp)+Fz*oYolA)K(/qZ-#|Qmh=aRs#Hg/tQTVw^Zvu(?.0$H8uoyAc]C}shTpiZ' );
define( 'SECURE_AUTH_SALT', '*;66k!IRyndh@i<RwF=DX5<{e/bWDp=t1o8+tq#*uj/xg>ue}lg?]eby>yOAMfMQ' );
define( 'LOGGED_IN_SALT',   '.Sn+r}8R9=`kgIT3ly}*6WB)0F%4T4:[j}b>-`D-53l-fg3!LZ@OaUtoyv&0E~-N' );
define( 'NONCE_SALT',       '>Yg_z1_Dl6b&N4$i>f<k1SuZ  zZ}o!m<:C7TZ3nGSPCSft(J)euMWs k&Bn,)HV' );

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
